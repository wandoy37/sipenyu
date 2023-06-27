<?php

namespace App\Http\Controllers;

use App\Models\KabKota;
use App\Models\Kecamatan;
use Illuminate\Http\Request;

class GeojsonController extends Controller
{
    function featureKabKota(Request $request)
    {
        $features = [];
        $kabkotas = KabKota::all();

        foreach ($kabkotas as $kabkota) {
            $getData = file_get_contents(public_path("indonesia-postal-and-area/data/geojson/62/64/" . $kabkota->code . "/" . $kabkota->code . ".json"));
            $json = json_decode($getData);
            $feature = $json->features[0];
            //jumlah kantor di kecamatan
            $feature->properties->Jumlah_Kantor = $kabkota->kecamatans->sum(function ($kecamatan) {
                return $kecamatan->kantors->count();
            });
            //jumlah pegawai di kantor
            $feature->properties->Jumlah_Pegawai = $kabkota->kecamatans->sum(function ($kecamatan) {
                return $kecamatan->kantors->sum(function ($kantor) {
                    return $kantor->pegawais->count();
                });
            });
            //jumlah kecamatan
            $feature->properties->Jumlah_Kecamatan = $kabkota->kecamatans->count();
            $features[] = $feature;
        }
        $format = [
            "type" => "FeatureCollection",
            "features" => $features
        ];
        return response()->json($format);
    }
    function featureKecamatan()
    {
        $features = [];
        $kecamatans = Kecamatan::all();

        foreach ($kecamatans as $kecamatan) {
            $getData = file_get_contents(public_path("indonesia-postal-and-area/data/geojson/62/64/" . $kecamatan->kabkota->code . "/" . $kecamatan->code . "/" . $kecamatan->code . ".json"));
            $json = json_decode($getData);
            $feature = $json->features[0];
            //jumlah kantor di kecamatan
            $feature->properties->Jumlah_Kantor = $kecamatan->kantors->count();
            //jumlah pegawai di kantor
            $feature->properties->Jumlah_Pegawai = $kecamatan->kantors->sum(function ($kantor) {
                return $kantor->pegawais->count();
            });
            $features[] = $feature;
        }
        $format = [
            "type" => "FeatureCollection",
            "features" => $features
        ];
        return response()->json($format);
    }

    function featureKecamatanByKabKota($kode_kab_kota)
    {
        $features = [];
        $kecamatans = Kecamatan::whereHas('kabkota', function ($w) use ($kode_kab_kota) {
            $w->where('code', $kode_kab_kota);
        })->get();

        foreach ($kecamatans as $kecamatan) {
            $getData = file_get_contents(public_path("indonesia-postal-and-area/data/geojson/62/64/" . $kecamatan->kabkota->code . "/" . $kecamatan->code . "/" . $kecamatan->code . ".json"));
            $json = json_decode($getData);
            // $features[] = $json->features[0];
            $feature = $json->features[0];
            //jumlah kantor di kecamatan
            $feature->properties->Jumlah_Kantor = $kecamatan->kantors->count();
            //jumlah pegawai di kantor
            $feature->properties->Jumlah_Pegawai = $kecamatan->kantors->sum(function ($kantor) {
                return $kantor->pegawais->count();
            });
            $features[] = $feature;
        }
        $format = [
            "type" => "FeatureCollection",
            "features" => $features
        ];
        return response()->json($format);
    }

    function featureKecamatanSingle($kode_kab_kota,$kode_kecamatan)
    {
        $features = [];
        $kecamatan = Kecamatan::whereHas('kabkota', function ($w) use ($kode_kab_kota) {
            $w->where('code', $kode_kab_kota);
        })->where('code',$kode_kecamatan)->first();

        $getData = file_get_contents(public_path("indonesia-postal-and-area/data/geojson/62/64/" . $kecamatan->kabkota->code . "/" . $kecamatan->code . "/" . $kecamatan->code . ".json"));
        $json = json_decode($getData);
        $feature = $json->features[0];
        //jumlah kantor di kecamatan
        $feature->properties->Jumlah_Kantor = $kecamatan->kantors->count();
        //jumlah pegawai di kantor
        $feature->properties->Jumlah_Pegawai = $kecamatan->kantors->sum(function ($kantor) {
            return $kantor->pegawais->count();
        });
        $features[] = $feature;
        $format = [
            "type" => "FeatureCollection",
            "features" => $features
        ];
        return response()->json($format);
    }
}