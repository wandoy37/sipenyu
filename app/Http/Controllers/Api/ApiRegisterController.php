<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApiRegisterController extends Controller
{
    function register(Request $request) {
        $validator = Validator::make(
            $request->all(),
            [
                'code' => 'unique:pegawais',
                'name' => 'required',
                'type' => 'required',
                'kantor_id' => 'required',
                'username' => 'required|min:6',
                'password'=>'required|min:6',
                'client_name'=>'required'
            ],
            [
                'code' => 'kode tenaga kerja sudah digunakan!',
                'name' => 'nama wajib diisi',
                'type' => 'jenis wajib diisi',
                'kantor_id' => 'kantor wajib diisi',
                'username' => 'username wajib diisi',
                'password'=>'password wajib diisi',
                'client_name'=>'client name wajib diisi'
            ],
        );
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Silahkan isi data dengan benar',
                'errors' => $validator->errors()
            ], 422);
        }
        
        DB::beginTransaction();
        try {
            $foto_profil = null;
            $foto_stp = null;
            if($request->hasFile('foto_profil')){
                $foto_profil = $request->file('foto_profil')->store('pegawai/foto_profil');
            }
            if($request->hasFile('foto_stp')){
                $foto_stp = $request->file('foto_stp')->store('pegawai/foto_stp');
            }
            $pegawai = Pegawai::create([
                'code' => $request->code,
                'name' => $request->name,
                'nik' => $request->nik,
                'nip' => $request->nip,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'type' => $request->type,
                'kantor_id' => $request->kantor_id,
                'jenis_kelamin'=>$request->jenis_kelamin,
                'tempat_lahir'=>$request->tempat_lahir,
                'tanggal_lahir'=>$request->tanggal_lahir,
                'alamat_rumah'=>$request->alamat_rumah,
                'pendidikan_terakhir'=>$request->pendidikan_terakhir,
                'no_wa'=>$request->no_wa,
                'agama'=>$request->agama,
                'status_perkawinan'=>$request->status_perkawinan,
                'nama_jabatan'=>$request->nama_jabatan,
                'unit_eselon'=>$request->unit_eselon,
                'pangkat_golongan'=>$request->pangkat_golongan,
                'foto_profil'=>$foto_profil,
                'foto_stp'=>$foto_stp,

            ]);
            $pegawai->loginPegawai()->create([
                'username' => $request->username,
                'password' => bcrypt($request->password),
            ]);
            DB::commit();
            $api_token = Str::random(60);
            $token = $pegawai->loginPegawai->loginPegawaiApiToken()->updateOrCreate([
                'client_name' => $request->client_name
            ],[
                'api_token' => hash('sha256',$api_token )
            ]);
            return response()->json([
                'message' => 'Berhasil mendaftar!',
                'api_token' => $api_token
            ],200);
            
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Gagal mendaftar',
                'errors' => [
                    "system error"=>$th->getMessage()
                ]
            ],500);
        }
    }
}
