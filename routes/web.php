<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GeojsonController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KabKotaController;
use App\Http\Controllers\KantorController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\SaranMasukanController;
use App\Http\Controllers\ScrapeSimluhController;
use App\Models\KabKota;
use App\Models\Kantor;
use App\Models\Kecamatan;
use App\Models\Pegawai;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Support\Facades\DB;
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



Route::get('/polygon', function () {
    $indonesia = URL('https://raw.githubusercontent.com/superpikar/indonesia-geojson/master/indonesia-province.json');
    return response()->json($indonesia);
});

Route::get('scrape-simluh', [ScrapeSimluhController::class,'run']);

// Route::get('scrape-kantor', [ScrapeSimluhController::class,'scrapeKantor']);
// Route::get('scrape-penyuluh', [ScrapeSimluhController::class,'scrapePenyuluh']);
// Route::get('lengkapi-penyuluh', [ScrapeSimluhController::class,'lengkapiPenyuluh']);

Route::get('update-koordinat-kantor', function () {
    $url = "https://maps.googleapis.com/maps/api/place/findplacefromtext/json?fields=formatted_address%2Cname%2Copening_hours%2Cgeometry&inputtype=textquery&key=" . env("GOOGLE_MAP_API_KEY") . "&input=";
    $kantors = Kantor::with('kabkota')->get();
    foreach ($kantors as $kantor) {
        $name = $kantor->name;
        if (!str_contains($name, "Bpp") && !str_contains($name, "BPP") && !str_contains($name, "bpp")) {
            $name = "Bpp " . $name;
        }
        $newUrl = URL($url . "Kantor Pemerintahan," . $name . "," . $kantor->kabkota->name);
        $httpClient = new \GuzzleHttp\Client();
        $response = $httpClient->request('GET', $newUrl);
        $json = json_decode($response->getBody());
        if (count($json->candidates) > 0) {
            if ($json->candidates[0]->geometry && $json->candidates[0]->geometry->location) {
                $kantor->update([
                    'name' => $name,
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
Route::get('/layanan', [HomeController::class, 'layanan'])->name('layanan');
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
    Route::post('saran-masukan', [SaranMasukanController::class, 'store'])->name('ajax.saran-masukan');
});
