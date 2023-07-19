<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class ApiPegawaiController extends Controller
{
    function getFotoProfil($id,$basename) {
        $pegawai = Pegawai::findOrFail($id);
        if($pegawai != null){
            if($pegawai->foto_profil != null){
                $name = basename($pegawai->foto_profil);
                if($name != $basename){
                    return abort(404);
                }
                //if file exist
                if(file_exists(storage_path('app/'.$pegawai->foto_profil))){
                    //return file
                    return response()->file(storage_path('app/'.$pegawai->foto_profil));
                }
            }
        }
        return abort(404);
    }

    function getFotoSpt($id,$basename) {
        $pegawai = Pegawai::findOrFail($id);
        if($pegawai != null){
            if($pegawai->foto_spt != null){
                $name = basename($pegawai->foto_spt);
                if($name != $basename){
                    return abort(404);
                }
                //if file exist
                if(file_exists(storage_path('app/'.$pegawai->foto_spt))){
                    //return file
                    return response()->file(storage_path('app/'.$pegawai->foto_spt));
                }
            }
        }
        return abort(404);
    }
}
