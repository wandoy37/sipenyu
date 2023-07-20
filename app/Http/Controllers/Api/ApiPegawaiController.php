<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApiPegawaiController extends Controller
{   

    function profil() {
        return auth()->user()->loginPegawai->pegawai;
    }

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

    function updateProfil(Request $request) {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'type' => 'required',
                'kantor_id' => 'required',
            ],
            [
                'name' => 'nama wajib diisi',
                'type' => 'jenis wajib diisi',
                'kantor_id' => 'kantor wajib diisi',
            ],
        );
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Silahkan isi data dengan benar',
                'errors' => $validator->errors()
            ], 422);
        }
        $pegawai = auth()->user()->loginPegawai->pegawai;
        DB::beginTransaction();
        try {
            $foto_profil = $pegawai->foto_profil;
            $foto_stp = $pegawai->foto_stp;
            if($request->hasFile('foto_profil')){
                $foto_profil = $request->file('foto_profil')->store('peserta/foto_profil');
            }
            if($request->hasFile('foto_stp')){
                $foto_stp = $request->file('foto_stp')->store('peserta/foto_stp');
            }
            if($request->has("password_baru") && $request->password_baru != ""){
                $request->validate([
                    "password"=>'required|min:5',
                ]);
                $pegawai->loginPegawai->update([
                    "password"=>bcrypt($request->password_baru),
                ]);
            }
            $pegawai->update([
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
            DB::commit();
            return response()->json([
                'message' => 'Berhasil update profil',
                'data' => $pegawai
            ],200);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'message' => 'Gagal update profil',
                'errors' => [
                    "system error"=>$th->getMessage()
                ]
            ],402);
        }
    }

    public function dataUmumPegawai(Request $request) {
        $pegawais = Pegawai::select('id','code','name','jenis_kelamin','status_perkawinan','nama_jabatan','unit_eselon','pangkat_golongan','kantor_id','type')->with('kantor:id,name','kantor.kecamatans.kabkota');
        if($request->has('search')){
            $pegawais->where(function($w)use($request){
                $w->where('name','like','%'.$request->search.'%')
                ->orWhere('code','like','%'.$request->search.'%')
                ->orWhere('jenis_kelamin','like','%'.$request->search.'%')
                ->orWhere('status_perkawinan','like','%'.$request->search.'%')
                ->orWhere('nama_jabatan','like','%'.$request->search.'%')
                ->orWhere('unit_eselon','like','%'.$request->search.'%')
                ->orWhere('pangkat_golongan','like','%'.$request->search.'%')
                ->orWhereHas('kantor',function($q)use($request){
                    $q->where('name','like','%'.$request->search.'%');
                })
                ->orWhere('type','like','%'.$request->search.'%');
            });
        }
        return $pegawais->paginate(10);
    }

    public function detailUmumPegawai($id) {
        $pegawai = Pegawai::select('id','code','name','jenis_kelamin','status_perkawinan','nama_jabatan','unit_eselon','pangkat_golongan','kantor_id','type')
        ->with('kantor:id,name','kantor.kecamatans.kabkota')
        ->findOrFail($id);
        
        return response()->json([
            'message' => 'Success!',
            'data' => $pegawai
        ],200);
    }
}
