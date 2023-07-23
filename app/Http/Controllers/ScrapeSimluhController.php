<?php

namespace App\Http\Controllers;

use App\Models\KabKota;
use App\Models\Kantor;
use App\Models\Kecamatan;
use App\Models\LoginPegawai;
use App\Models\Pegawai;
use DOMDocument;
use DOMXPath;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ScrapeSimluhController extends Controller
{
    public $PHPSESSID = "4e6stpqu65qev64juk3uh81pj3";

    public function run()
    {
        $cekLogin = $this->login();
        if ($cekLogin) {
            
            $this->scrapePenyuluh();
            $this->scrapeKantor();
            $datas = $this->get_ketenagaan();
            
            $code = "00001";
            $lastPegawai = Pegawai::orderBy('code','desc')->first();
            if($lastPegawai){
                $code = $lastPegawai->code;
            }
            DB::beginTransaction();
            try {
                foreach ($datas as $data) {
                    $username = $data['nik'] ?? $data['nip'];
                    $password = Hash::make($username);
                    $cek = Pegawai::where('name',$data['nama'])
                    ->first();
                   
                    if(!$cek){
                        $code = str_pad((int)$code+1,5,"0",STR_PAD_LEFT);
                        $pegawai = Pegawai::create([
                            'code'=>$code,
                            "name"=>$data['nama'],
                            "nik"=> $data['nik'],
                            "nip"=>$data['nip'],
                            "jenis_kelamin" => $data['jenis_kelamin'],
                            "tempat_lahir" => $data['tempat_lahir'],
                            "tanggal_lahir" => date("Y-m-d", strtotime($data['tanggal_lahir'])),
                            "pendidikan_terakhir" => $data['pendidikan'],
                            "no_telp" => $data['no_telp'],
                            "email" => $data['email'],
                            "nama_jabatan" => $data['jabatan'],
                            "pangkat_golongan" => $data['golongan'],
                        ]);
                    } else {
                        $pegawai = $cek;
                        $pegawai->update([
                            "nik"=> $data['nik'] ?? $pegawai->nik,
                            "nip"=>$data['nip'] ?? $pegawai->nip,
                            "jenis_kelamin" => $data['jenis_kelamin'],
                            "tempat_lahir" => $data['tempat_lahir'],
                            "tanggal_lahir" => date("Y-m-d", strtotime($data['tanggal_lahir'])),
                            "pendidikan_terakhir" => $data['pendidikan'],
                            "no_telp" => $data['no_telp'],
                            "email" => $data['email'],
                            "nama_jabatan" => $data['jabatan'],
                            "pangkat_golongan" => $data['golongan'],
                        ]);
                        
                    }

                    LoginPegawai::firstOrCreate([
                        'username' => $username,
                    ], [
                        "pegawai_id" => $pegawai->id,
                        'password' => $password,
                    ]);

                }
            } catch (\Throwable $th) {
                DB::rollBack();
                dd($th);
                //throw $th;
            }
            DB::commit();
            return response()->json($datas);
        } else {
            dd('login gagal');
        }
    }

    private function login()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://app2.pertanian.go.id/simluh2014/index_on.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Host: app2.pertanian.go.id',
            'Content-Length: 31',
            'Cache-Control: max-age=0',
            'Sec-Ch-Ua: "Not:A-Brand";v="99", "Chromium";v="112"',
            'Sec-Ch-Ua-Mobile: ?0',
            'Sec-Ch-Ua-Platform: "Windows"',
            'Upgrade-Insecure-Requests: 1',
            'Origin: https://app2.pertanian.go.id',
            'Content-Type: application/x-www-form-urlencoded',
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.5615.50 Safari/537.36',
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
            'Sec-Fetch-Site: same-origin',
            'Sec-Fetch-Mode: navigate',
            'Sec-Fetch-User: ?1',
            'Sec-Fetch-Dest: document',
            'Referer: https://app2.pertanian.go.id/simluh2014/index_on.php',
            'Accept-Encoding: gzip, deflate',
            'Accept-Language: en-GB,en-US;q=0.9,en;q=0.8',
            'Connection: close',
        ]);
        curl_setopt($ch, CURLOPT_COOKIE, 'PHPSESSID=' . $this->PHPSESSID . ';');
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'admin=guest&kunci=guest&submit=');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        //cek status code
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $login_success = false;
        if (str_contains($response, 'gst/welcome.php') && $httpcode == 200) {
            $login_success = true;
        } else {
            $login_success = false;
        }

        curl_close($ch);
        return $login_success;
    }

    private function get_ketenagaan()
    {
        $typeUrl = [
            "pns" => "https://app2.pertanian.go.id/simluh2014/viewreport/viewLuhPnsKabAktif.php?pr=64&satm=",
            "swadaya" => "https://app2.pertanian.go.id/simluh2014/viewreport/viewLuhSwadaya.php?pr=64&satm=",
            "apbd" => "https://app2.pertanian.go.id/simluh2014/viewreport/viewLuhThlApbd.php?pr=64&satm=",
            "apbn" => "https://app2.pertanian.go.id/simluh2014/viewreport/viewLuhThlApbn.php?pr=64&satm=",
        ];
        $kabkotas = KabKota::all();
        $result = [];
        foreach ($kabkotas as $key => $kabkota) {
            try {
                foreach ($typeUrl as $url) {
                    $url = $url . $kabkota->code;
                    $httpClient = new \GuzzleHttp\Client();
                    $cookieJar = CookieJar::fromArray([
                        'PHPSESSID' => $this->PHPSESSID
                    ], 'app2.pertanian.go.id');
                    $response = $httpClient->request('GET', $url, ['cookies' => $cookieJar]);
                    $htmlString = (string) $response->getBody();
                    $htmlString = str_replace(array("\r", "\n"), '', $htmlString);
                    $dom = new DOMDocument();
                    libxml_use_internal_errors(true);
                    $dom->loadHTML($htmlString);
                    $xpath = new DOMXPath($dom);
                    //find table with class display
                    $rows = $xpath->query("//table[@id='datatables']//tr");
                    $data = [
                        'nama' => null,
                        'nik' => null,
                        "jenis_kelamin" => null,
                        "tempat_lahir" => null,
                        "tanggal_lahir" => null,
                        'nip' => null,
                        'no_telp' => null,
                        'email' => null,
                        'jabatan' => null,
                        'golongan' => null,
                        'pendidikan' => null,
                        'unit_kerja' => null

                    ];
                    foreach ($rows as $row) {
                        $data = [
                            'nama' => null,
                            'nik' => null,
                            "jenis_kelamin" => null,
                            "tempat_lahir" => null,
                            "tanggal_lahir" => null,
                            'nip' => null,
                            'no_telp' => null,
                            'email' => null,
                            'jabatan' => null,
                            'golongan' => null,
                            'pendidikan' => null,
                            'unit_kerja' => null

                        ];
                        $cols = $row->getElementsByTagName('td');

                        if ($cols->length > 0) {
                            $nama = null;
                            $nip = null;
                            $nik = null;
                            $jenis_kelamin = null;
                            $tempat_lahir = null;
                            $tanggal_lahir = null;
                            $jabatan = null;
                            $golongan = null;
                            $pendidikan = null;
                            $unit_kerja = null;
                            if ($cols[0]->nodeValue != "No") {
                                if ($cols->length == 9) {
                                    $ex = explode("<br></br>", $cols[1]->C14N());
                                    if (count($ex) > 0) {
                                        $nama = trim(strip_tags($ex[0]));
                                        //remove double white
                                        $nama = preg_replace('/\s+/', ' ', $nama);
                                    }
                                    if (count($ex) > 1) {
                                        $nip = trim(strip_tags($ex[1]));
                                        if ($nip == "") {
                                            $nip = null;
                                        }
                                    }
                                    if (count($ex) > 2) {
                                        $jenis_kelamin = trim(strip_tags($ex[2]));
                                        if ($jenis_kelamin == "") {
                                            $jenis_kelamin = null;
                                        }
                                    }

                                    $col2 = explode("<br></br>", $cols[2]->C14N());
                                    if (count($col2) > 0) {
                                        $tempat_lahir = trim(strip_tags($col2[0]));
                                        if ($tempat_lahir == "") {
                                            $tempat_lahir = null;
                                        }
                                    }
                                    if (count($col2) > 1) {
                                        $tanggal_lahir = trim(strip_tags($col2[1]));
                                        if ($tanggal_lahir == "") {
                                            $tanggal_lahir = null;
                                        }
                                    }

                                    $col2 = explode("<br></br>", $cols[3]->C14N());
                                    if (count($col2) > 0) {
                                        $pendidikan = trim(strip_tags($col2[0]));
                                        if ($pendidikan == "null") {
                                            $pendidikan = null;
                                        }
                                    }

                                    $col6 = explode("<br></br>", $cols[6]->C14N());
                                    if (count($col2) > 0) {
                                        $jabatan = trim(strip_tags($col6[0]));
                                        if ($jabatan == "") {
                                            $jabatan = null;
                                        }
                                    }
                                    if (count($col2) > 1) {
                                        $golongan = trim(strip_tags($col6[1]));
                                        if ($golongan == "") {
                                            $golongan = null;
                                        }
                                    }
                                } else if ($cols->length == 12) {
                                    $ex = explode("<br></br>", $cols[2]->C14N());

                                    if (count($ex) > 0) {
                                        $nama = trim(strip_tags($ex[0]));
                                        $nama = preg_replace('/\s+/', ' ', $nama);
                                    }

                                    $unit_kerja = trim(strip_tags($cols[1]->nodeValue));
                                    if ($unit_kerja == "") {
                                        $unit_kerja = null;
                                    }

                                    if (count($ex) > 2) {
                                        $_d = explode(",", trim(strip_tags($ex[1])));
                                        $tempat_lahir = $_d[0];
                                        $tanggal_lahir = $_d[1];
                                        if ($tempat_lahir == "") {
                                            $tempat_lahir = null;
                                        }
                                        if ($tanggal_lahir == "" || $tanggal_lahir == "0/0/0") {
                                            $tanggal_lahir = null;
                                        }
                                    }
                                    if (count($ex) > 2) {
                                        $jenis_kelamin = trim(strip_tags($ex[2]));
                                        if ($jenis_kelamin == "") {
                                            $jenis_kelamin = null;
                                        }
                                    }
                                    $ex1 = explode("<br></br>", $cols[3]->C14N());
                                    if (count($ex1) > 0) {
                                        $nik = trim(strip_tags($ex1[0]));
                                        if ($nik == "") {
                                            $nik = null;
                                        }
                                    }
                                    $pendidikan = trim(strip_tags($cols[4]->nodeValue));
                                    if ($pendidikan == "") {
                                        $pendidikan = null;
                                    }

                                } else {
                                    dd($cols[0]->nodeValue);
                                }
                                $ex3 = explode("<br></br>", $cols[$cols->length - 1]->C14N());
                                $no_telp = null;
                                $email = null;
                                if (count($ex3) > 0) {
                                    $no_telp = trim(strip_tags($ex3[0]));
                                    $no_telp = explode("/", $no_telp);
                                    $no_telp = explode(" ", $no_telp[0]);
                                    if ($no_telp[0] == "") {
                                        $no_telp = null;
                                    } else {
                                        $no_telp = $no_telp[0];
                                    }
                                }
                                if (count($ex3) > 1) {
                                    $email = trim(strip_tags($ex3[1]));
                                    if ($email == "") {
                                        $email = null;
                                    }
                                }

                                $data['nama'] = $nama;
                                $data['nip'] = $nip;
                                $data['nik'] = $nik;
                                $data['jenis_kelamin'] = $jenis_kelamin;
                                $data['tempat_lahir'] = $tempat_lahir;
                                $data['tanggal_lahir'] = $tanggal_lahir;
                                $data['jabatan'] = $jabatan;
                                $data['golongan'] = $golongan;
                                $data['no_telp'] = $no_telp;
                                $data['email'] = $email;
                                $data['pendidikan'] = $pendidikan;
                                $data['kab_kota_id'] = $kabkota->id;


                                if ($data['nama'] != null && ($data['nik'] != null || $data['nip'] != null)) {

                                    $result[] = $data;

                                }
                            }
                        }
                    }
                }
            } catch (\Throwable $th) {
                dd([
                    $kabkota->nama_kab_kota,
                    $th
                ]);
            }
        }
        return $result;
    }

    private function convertToDecimalDegrees($coordinate, $minus = 1)
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

    function lengkapiPenyuluh()
    {
        $typeUrl = [
            "pns" => "https://app2.pertanian.go.id/simluh2014/viewreport/viewLuhPnsKabAktif.php?pr=64&satm=",
            "swadaya" => "https://app2.pertanian.go.id/simluh2014/viewreport/viewLuhSwadaya.php?pr=64&satm=",
            "apbd" => "https://app2.pertanian.go.id/simluh2014/viewreport/viewLuhThlApbd.php?pr=64&satm=",
            "apbn" => "https://app2.pertanian.go.id/simluh2014/viewreport/viewLuhThlApbn.php?pr=64&satm=",
        ];
        $kabkotas = KabKota::with('kecamatans')->get();
        $result = [];
        foreach ($kabkotas as $key => $kabkota) {
            DB::beginTransaction();

            try {
                // Set the URL of the website we want to scrape.
                $url = (@$typeUrl[request()->type] ?? 'https://app2.pertanian.go.id/simluh2014/viewreport/viewLuhPnsKabAktif.php?pr=64&satm=') . $kabkota->code;


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
                $rows = $xpath->query("//table[@id='datatables']//tr");

                foreach ($rows as $row) {
                    $data = [
                        'name' => null,
                        'nik' => null,
                        'nip' => null,
                        'no_telp' => null

                    ];
                    $cols = $row->getElementsByTagName('td');
                    if ($cols->length > 0) {
                        $nama = null;
                        $nip = null;
                        $nik = null;
                        if ($cols[0]->nodeValue != "No") {
                            if ($cols->length == 9) {
                                $ex = explode("<br></br>", $cols[1]->C14N());
                                if (count($ex) > 0) {
                                    $nama = trim(strip_tags($ex[0]));
                                }
                                if (count($ex) > 1) {
                                    $nip = trim(strip_tags($ex[1]));
                                }
                            } else if ($cols->length == 12) {
                                $ex = explode("<br></br>", $cols[2]->C14N());

                                if (count($ex) > 0) {
                                    $nama = trim(strip_tags($ex[0]));
                                }
                                $ex1 = explode("<br></br>", $cols[3]->C14N());
                                if (count($ex1) > 0) {
                                    $nik = trim(strip_tags($ex1[0]));
                                }
                            } else {
                                dd($cols[0]->nodeValue);
                            }
                            $ex3 = explode("<br></br>", $cols[$cols->length - 1]->C14N());
                            $no_telp = null;
                            if (count($ex3) > 0) {
                                $no_telp = trim(strip_tags($ex3[0]));
                            }
                            $data['name'] = $nama;
                            $data['nip'] = $nip;
                            $data['nik'] = $nik;
                            $data['no_telp'] = $no_telp;
                            $data['kabkota'] = $kabkota->name;


                            if ($data['name'] != null) {
                                $penyuluh = Pegawai::where('name', $data['name'])->first();
                                $updateColumn = [
                                    "nip" => $data['nip'],
                                    "nik" => $data['nik'],
                                ];
                                if ($data['no_telp'] != null && $data['no_telp'] != "") {
                                    $updateColumn['no_telp'] = $data['no_telp'];
                                }
                                if ($penyuluh) {
                                    $penyuluh->update($updateColumn);
                                }
                                $result[] = $data;
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
    }

    function scrapeKantor()
    {
        $kabkotas = KabKota::with('kecamatans')->get();
        $result = [];
        foreach ($kabkotas as $key => $kabkota) {
            DB::beginTransaction();

            try {
                // Set the URL of the website we want to scrape.
                $url = 'https://app2.pertanian.go.id/simluh2014/viewreport/rekapKec_lembaga.php?kode_prop=6400&kode_kab=' . $kabkota->code;



                $httpClient = new \GuzzleHttp\Client();


                $cookieJar = CookieJar::fromArray([
                    'PHPSESSID' => $this->PHPSESSID
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
                            $data['latitude'] = $this->convertToDecimalDegrees(str_replace("LS", "", $data['latitude']), -1);
                        } else if (str_contains($data['latitude'], "LU")) {
                            $data['latitude'] = $this->convertToDecimalDegrees(str_replace("LU", "", $data['latitude']));
                        } else {
                            //remove all non numeric but keep . and ,
                            $data['latitude'] = $this->convertToDecimalDegrees(preg_replace("/[^0-9,.]/", "", $data['latitude']));
                        }

                        $data['longitude'] = trim(str_replace("BT", "", strip_tags($col6[1])));
                        $data['longitude'] = $this->convertToDecimalDegrees($data['longitude']);
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
    }

    function scrapePenyuluh()
    {
        $result = [];
        $kecamatans = Kecamatan::with('kabkota')->get();
        $lastKantor = Kantor::count();
        $lastPegawai = Pegawai::count();
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
                    'PHPSESSID' => $this->PHPSESSID
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
    }
}