<?php

namespace App\Http\Controllers;

use App\Models\KabKota;
use App\Models\Kantor;
use App\Models\Kecamatan;
use App\Models\Pegawai;
use DOMDocument;
use DOMXPath;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScrapeSimluhController extends Controller
{
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
    }
}