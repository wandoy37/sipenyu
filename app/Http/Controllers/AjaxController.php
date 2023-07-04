<?php

namespace App\Http\Controllers;

use App\Models\Kantor;
use App\Models\Kecamatan;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    function kecamatanByKabKota($kode_kab_kota)
    {
        $kecamatans = Kecamatan::whereHas('kabkota', function ($w) use ($kode_kab_kota) {
            $w->where('code', $kode_kab_kota);
        })->get();
        return response()->json($kecamatans);
    }

    function kantorByKecamatan($kode_kab_kota, $kode_kecamatan)
    {
        $kantors = Kantor::with('pegawais:id,code,name,nip,nik,type,kantor_id', 'kecamatans')->whereHas('kecamatans', function ($w) use ($kode_kecamatan) {
            $w->where('code', $kode_kecamatan);
        })->get();
        return response()->json($kantors);
    }
}
