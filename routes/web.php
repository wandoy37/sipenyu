<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GeojsonController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KabKotaController;
use App\Http\Controllers\KantorController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\PegawaiController;
use App\Models\KabKota;
use App\Models\Kantor;
use App\Models\Kecamatan;
use App\Models\Pegawai;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

function convertToDecimalDegrees($coordinate, $minus = 1)
{
    if (str_contains($coordinate, "-")) {
        $parts = explode('-', $coordinate);
    } else if (str_contains($coordinate, "'")) {
        $parts = explode("'", $coordinate);
    } else if (str_contains($coordinate, ".")) {
        $parts = explode('.', $coordinate);
    } else {
        return str_replace(",", "", $coordinate);
    }

    if (count($parts) < 3) {

        return str_replace(",", "", $coordinate);
    }

    $degrees = floatval($parts[0]);
    $minutes = floatval($parts[1]);
    $seconds = floatval($parts[2]);

    //$decimalDegrees = $degrees + ($minutes / 60) + ($seconds / 3600);
    return ($degrees + ((($minutes * 60) + ($seconds)) / 3600)) * $minus;

    //return $decimalDegrees;
}

Route::get('/polygon', function () {
    $indonesia = URL('https://raw.githubusercontent.com/superpikar/indonesia-geojson/master/indonesia-province.json');
    return response()->json($indonesia);
});

Route::get('scrape-kantor', function () {
    $kabkotas = KabKota::with('kecamatans')->get();
    $result = [];
    foreach ($kabkotas as $key => $kabkota) {
        DB::beginTransaction();

        try {
            // Set the URL of the website we want to scrape.
            $url = 'https://app2.pertanian.go.id/simluh2014/viewreport/rekapKec_lembaga.php?kode_prop=6400&kode_kab=' . $kabkota->code;

         

            $httpClient = new \GuzzleHttp\Client();


            $cookieJar = CookieJar::fromArray([
                'PHPSESSID' => env('PHPSESSID')
            ], 'app2.pertanian.go.id');
            $response = $httpClient->request('GET', $url, ['cookies' => $cookieJar]);
            $htmlString = (string) $response->getBody();
            // Send a GET request to the website and set the cookie.
            // $ch = curl_init($url);
            // curl_setopt($ch, CURLOPT_COOKIE, $cookie);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // $response = curl_exec($ch);
            // curl_close($ch);
            // dd($response);
            // remove \r\n
            $htmlString = str_replace(array("\r", "\n"), '', $htmlString);
            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML($htmlString);
            $xpath = new DOMXPath($dom);
            //find table with class display
            $rows = $xpath->query("//table[@class='display']//tr");

            foreach ($rows as $row) {
                $data = [
                    'url' => $url,
                    'kabkota' => $kabkota->name,
                    'nama_kantor' => '',
                    'alamat_kantor' => '',
                    'longitude' => null,
                    'latitude' => null,
                    'link_map' => null,
                    "koordinat" => null,
                    'kecamatans' => []

                ];
                $cols = $row->getElementsByTagName('td');

                if ($cols->length == 8 && $cols[0]->nodeValue != "No" && $cols[1]->nodeValue != "Nama BP3K") {
                    $data['nama_kantor'] = trim($cols[1]->nodeValue);
                    $data['alamat_kantor'] = trim($cols[4]->nodeValue);
                    $col6 = explode("</br>", $cols[6]->C14N());
                    $data["koordinat"] = strip_tags($cols[6]->nodeValue);
                    $data['latitude'] = trim(strip_tags($col6[0]));
                    if (str_contains($data['latitude'], "LS")) {
                        $data['latitude'] = convertToDecimalDegrees(str_replace("LS", "", $data['latitude']), -1);
                    } else if (str_contains($data['latitude'], "LU")) {
                        $data['latitude'] = convertToDecimalDegrees(str_replace("LU", "", $data['latitude']));
                    } else {
                        //remove all non numeric but keep . and ,
                        $data['latitude'] = convertToDecimalDegrees(preg_replace("/[^0-9,.]/", "", $data['latitude']));
                    }

                    $data['longitude'] = trim(str_replace("BT", "", strip_tags($col6[1])));
                    $data['longitude'] = convertToDecimalDegrees($data['longitude']);
                    $data['link_map'] = "https://www.google.com/maps/search/" . $data['latitude'] . "+" . $data['longitude'] . "?entry=tts";
                    $col3 = explode("-", strip_tags($cols[3]->nodeValue));
                    $kecamatans = [];
                    foreach ($col3 as $key => $value) {
                        $kecamatan = Kecamatan::where('name', trim($value))->first();
                        if ($kecamatan) {
                            $kecamatans[] = $kecamatan->id;
                        }
                    }
                    $data['kecamatans'] = $kecamatans;
                    if ($data['nama_kantor'] != "" && $data['alamat_kantor'] != "") {
                        $result[] = $data;
                        $kantor = Kantor::where('name', $data['nama_kantor'])->first();
                        if ($kantor) {
                            $kantor->alamat = $data['alamat_kantor'];
                            $kantor->latitude = $data['latitude'];
                            $kantor->longitude = $data['longitude'];
                            $kantor->raw_coordinate = $data['koordinat'];
                            $kantor->save();
                            $kantor->kecamatans()->sync($data['kecamatans']);
                        }
                    }


                }
            }

            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            dd($th);
        }

    }

    return $result;

});

Route::get('scrape-penyuluh', function () {
    $result = [];
    $kecamatans = Kecamatan::with('kabkota')->get();
    $lastKantor = Kantor::all()->count();
    $lastPegawai = Pegawai::all()->count();
    $types = [
        "Penyuluh Pertanian PNS (Aktif)" => "penyuluh pns",
        "Penyuluh Pertanian PPPK" => "penyuluh pppk",
        "Penyuluh THL-TBPP APBN" => "thl-tbpp apbn",
        "Penyuluh THL-TBPP APBD" => "thl-tbpp apbd",
        "Penyuluh Swadaya" => "penyuluh swadaya",
    ];

    foreach ($kecamatans as $key => $kecamatan) {
        DB::beginTransaction();
        try {
            // Set the URL of the website we want to scrape.
            $url = 'https://app2.pertanian.go.id/simluh2014/viewreport/daftPenyuluh.php?id_prop=6400&kode_kab=' . $kecamatan->kabkota->code . '&tempat_tugas=' . $kecamatan->code;
            $httpClient = new \GuzzleHttp\Client();
            $cookieJar = CookieJar::fromArray([
                'PHPSESSID' => env("PHPSESSID")
            ], 'app2.pertanian.go.id');
            $response = $httpClient->request('GET', $url, ['cookies' => $cookieJar]);
            $htmlString = (string) $response->getBody();
            // Send a GET request to the website and set the cookie.
            // $ch = curl_init($url);
            // curl_setopt($ch, CURLOPT_COOKIE, $cookie);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // $response = curl_exec($ch);
            // curl_close($ch);
            // dd($response);
            // remove \r\n
            $htmlString = str_replace(array("\r", "\n"), '', $htmlString);

            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML($htmlString);
            $xpath = new DOMXPath($dom);
            //find table with class display
            $rows = $xpath->query("//table[@style='border-collapse: collapse']//tr");
            $data = [
                'url' => $url,
                'kabkota' => $kecamatan->kabkota->name,
                'kecamatan' => $kecamatan->name,
                'nama_kantor' => '',
                'alamat_kantor' => '',
                'pegawai' => []

            ];
            $jenis_penyuluh = '';
            $kantor = null;
            foreach ($rows as $row) {

                $cols = $row->getElementsByTagName('td');
                $pegawai = [
                    "name" => '',
                    "no_telp" => null,
                    "email" => null,
                    "type" => @$types[$jenis_penyuluh],
                ];
                if ($cols->length == 6 && ($cols[0]->nodeValue != "No" || $cols[1]->nodeValue != "Nama Penyuluh")) {
                    $pegawai['name'] = trim($cols[1]->nodeValue);
                    $pegawai['no_telp'] = trim(str_replace(" ", "", $cols[3]->nodeValue));
                    $pegawai['email'] = trim(str_replace(" ", "", $cols[4]->nodeValue));


                } else if ($cols->length == 1 && trim($cols[0]->nodeValue) != "") {
                    $C14N = $cols[0]->C14N();
                    $brs = explode("</br>", $C14N);
                    if (count($brs) > 4) {
                        $data['nama_kantor'] = trim(str_replace(["BP3K (", ")", "<br>"], "", $brs[3]));
                        $lastKantor++;

                        if ($data["nama_kantor"] != "") {
                            $cek = Kantor::where('name', $data['nama_kantor'])->first();
                            if ($cek) {
                                $kantor = $cek;
                            } else {
                                $kantor = Kantor::firstOrCreate([
                                    'code' => str_pad($lastKantor, 5, '0', STR_PAD_LEFT),
                                    'name' => $data['nama_kantor'],
                                    'alamat' => '-',
                                    'kabkota_id' => $kecamatan->kabkota_id,
                                ]);

                            }
                            $kantor->kecamatans()->attach([$kecamatan->id]);

                        }
                    } else if (count($brs) > 1) {
                        if (str_contains($brs[0], "<font")) {
                            $jenis_penyuluh = strip_tags($brs[2]);

                        }
                    }
                }
                if ($pegawai["name"] != "") {
                    $data['pegawai'][] = $pegawai;
                    if ($kantor != null) {
                        $lastPegawai++;
                        $pegawai['code'] = str_pad($lastPegawai, 5, '0', STR_PAD_LEFT);
                        $kantor->pegawais()->firstOrCreate($pegawai);

                    }
                }
            }
            if ($data['nama_kantor'] != "" && $data['nama_kantor'] != "BP3K ()") {
                $result[] = $data;
            }
            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            dd($th);
        }

    }

    return $result;
});

Route::get('update-koordinat-kantor', function () {
    $url = "https://maps.googleapis.com/maps/api/place/findplacefromtext/json?fields=formatted_address%2Cname%2Copening_hours%2Cgeometry&inputtype=textquery&key=".env("GOOGLE_MAP_API_KEY")."&input=";
    $kantors = Kantor::with('kabkota')->get();
    foreach ($kantors as $kantor) {
        $name = $kantor->name;
        if(!str_contains($name, "Bpp") && !str_contains($name, "BPP") && !str_contains($name, "bpp")){
            $name = "Bpp " . $name;
        }
        $newUrl = URL($url . "Kantor Pemerintahan," . $name . "," . $kantor->kabkota->name);
        $httpClient = new \GuzzleHttp\Client();
        $response = $httpClient->request('GET', $newUrl);
        $json = json_decode($response->getBody());
        if(count($json->candidates) > 0){
            if($json->candidates[0]->geometry && $json->candidates[0]->geometry->location){
                $kantor->update([
                    'name'=>$name,
                    'latitude' => $json->candidates[0]->geometry->location->lat,
                    'longitude' => $json->candidates[0]->geometry->location->lng,
                ]);
            }
        }
        
    }
    return "ok";
});

// ======================================================================================================================== //
// HOME CONTROLLER

Route::get('/', [HomeController::class, 'index'])->name('index');
// ======================================================================================================================== //
Route::middleware('auth')->group(function () {
    // dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Kab Kota
    Route::get('/kabupaten-kota', [KabKotaController::class, 'index'])->name('kabkota.index');
    Route::get('/kabupaten-kota/tambah', [KabKotaController::class, 'create'])->name('kabkota.create');
    Route::post('/kabupaten-kota/store', [KabKotaController::class, 'store'])->name('kabkota.store');
    Route::get('/kabupaten-kota/{code}', [KabKotaController::class, 'edit'])->name('kabkota.edit');
    Route::patch('/kabupaten-kota/{code}/update', [KabKotaController::class, 'update'])->name('kabkota.update');
    Route::delete('/kabupaten-kota/{code}/delete', [KabKotaController::class, 'destroy'])->name('kabkota.delete');

    // Kecamatan
    Route::get('/kecamatan', [KecamatanController::class, 'index'])->name('kecamatan.index');
    Route::get('/kecamatan/tambah', [KecamatanController::class, 'create'])->name('kecamatan.create');
    Route::post('/kecamatan/store', [KecamatanController::class, 'store'])->name('kecamatan.store');
    // Show Kecamatan By kabkota_id
    Route::get('/get-kecamatan/{id}', function ($id) {
        $kecamatan = App\Models\Kecamatan::where('kabkota_id', $id)->get();
        return response()->json($kecamatan);
    })->name('get.kecamatan');
    Route::get('/kecamatan/{code}', [KecamatanController::class, 'edit'])->name('kecamatan.edit');
    Route::patch('/kecamatan/{code}/update', [KecamatanController::class, 'update'])->name('kecamatan.update');
    Route::delete('/kecamatan/{code}/delete', [KecamatanController::class, 'destroy'])->name('kecamatan.delete');

    // Kantor
    Route::get('/kantor', [KantorController::class, 'index'])->name('kantor.index');
    Route::get('/kantor/tambah', [KantorController::class, 'create'])->name('kantor.create');
    Route::post('/kantor/store', [KantorController::class, 'store'])->name('kantor.store');
    Route::get('/kantor/{code}/edit', [KantorController::class, 'edit'])->name('kantor.edit');
    Route::patch('/kantor/{code}/update', [KantorController::class, 'update'])->name('kantor.update');
    Route::delete('/kantor/{code}/delete', [KantorController::class, 'destroy'])->name('kantor.delete');

    // Pegawai
    Route::get('/tenaga-kerja', [PegawaiController::class, 'index'])->name('pegawai.index');
    Route::get('/tenaga-kerja/tambah', [PegawaiController::class, 'create'])->name('pegawai.create');
    Route::post('/tenaga-kerja/store', [PegawaiController::class, 'store'])->name('pegawai.store');
    Route::get('/tenaga-kerja/{code}/edit', [PegawaiController::class, 'edit'])->name('pegawai.edit');
    Route::patch('/tenaga-kerja/{code}/update', [PegawaiController::class, 'update'])->name('pegawai.update');
    Route::delete('/tenaga-kerja/{code}/delete', [PegawaiController::class, 'destroy'])->name('pegawai.delete');



});

Route::group(['prefix' => 'geojson'], function () {
    Route::get('feature-kabkota', [GeojsonController::class, 'featureKabKota'])->name('geojson.feature-kabkota');
    Route::get('feature-kecamatan', [GeojsonController::class, 'featureKecamatan'])->name('geojson.feature-kecamatan');
    Route::get('feature-kecamatan/{kode_kab_kota}', [GeojsonController::class, 'featureKecamatanByKabKota'])->name('geojson.feature-kecamatan-by-kab-kota');
    Route::get('feature-kecamatan/{kode_kab_kota}/{kode_kecamatan}', [GeojsonController::class, 'featureKecamatanSingle'])->name('geojson.feature-kecamatan-single');
});

Route::group(['prefix' => 'ajax'], function () {
    Route::get('kecamatan/{kode_kab_kota}', [AjaxController::class, 'kecamatanByKabKota'])->name('ajax.feature-kabkota');
    // Route::get('kantor/{kode_kab_kota}', [AjaxController::class,'kantor'])->name('ajax.feature-kabkota');
    Route::get('kantor/{kode_kab_kota}/{kode_kecamatan}', [AjaxController::class, 'kantorByKecamatan'])->name('ajax.feature-kabkota');
});