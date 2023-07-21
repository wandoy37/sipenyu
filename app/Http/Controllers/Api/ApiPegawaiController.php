<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kantor;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApiPegawaiController extends Controller
{   

    function profil() {
        return Pegawai::with('kantor:id,name','kantor.kecamatans.kabkota')->findOrFail(auth()->user()->loginPegawai->pegawai_id);
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
                'code' => 'unique:pegawais',
                'name' => 'required',
                'type' => 'required',
                'kantor_id' => 'required',
                'username' => 'required'
            ],
            [
                'code' => 'kode tenaga kerja sudah digunakan!',
                'name' => 'nama wajib diisi',
                'type' => 'jenis wajib diisi',
                'kantor_id' => 'kantor wajib diisi',
                'username' => 'username wajib diisi'
            ],
        );
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Silahkan isi data dengan benar',
                'errors' => $validator->errors()
            ], 422);
        }
        $pegawai = auth()->user()->loginPegawai->pegawai;
        if($request->has("password_baru") && $request->password_baru != ""){
            $request->validate([
                "password"=>'required|min:5',
            ]);
            $pegawai->loginPegawai->update([
                "password"=>bcrypt($request->password_baru),
            ]);
        }
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
                'type' => $request->type,
                'kantor_id' => $request->kantor_id,
                'jenis_kelamin'=>$request->jenis_kelamin,
                'tempat_lahir'=>$request->tempat_lahir,
                'tanggal_lahir'=>$request->tanggal_lahir,
                'alamat_rumah'=>$request->alamat_rumah,
                'pendidikan_terakhir'=>$request->pendidikan_terakhir,
                'no_telp' => $request->no_telp,
                'email' => $request->email,
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

    private function roles()
    {
        return [
            'penyuluh pns' => 'Penyuluh Pertanian PNS (Aktif)',
            'penyuluh pppk' => 'Penyuluh Pertanian PPPK',
            'thl-tbpp apbn' => 'Penyuluh THL-TBPP APBN',
            'thl-tbpp apbd' => 'Penyuluh THL-TBPP APBD',
            'penyuluh swadaya'=>'Penyuluh Swadaya',
            'penyuluh swasta'=> 'Penyuluh Swasta',
            'petugas popt'=>'Petugas POPT',
            'petugas pbt'=>'Petugas PBT',
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        if(auth()->user()->client_name !== $request->client_name){
            return abort(404);
        }
        $pegawais = Pegawai::with('kantor:id,name','kantor.kecamatans.kabkota');
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {   
        if(auth()->user()->client_name !== $request->client_name){
            return abort(404);
        }
        $roles = $this->roles();
        $kantors = Kantor::all();
        return response()->json([
            'message' => 'Success!',
            'data' => [
                'roles' => $roles,
                'kantors' => $kantors,
            ]
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        if(auth()->user()->client_name !== $request->client_name){
            return abort(404);
        }
        // Validator
        $validator = Validator::make(
            $request->all(),
            [
                'code' => 'unique:pegawais',
                'name' => 'required',
                'type' => 'required',
                'kantor_id' => 'required',
                'username' => 'required',
                'password' => 'required',
            ],
            [
                'code' => 'kode tenaga kerja sudah digunakan!',
                'name' => 'nama wajib diisi',
                'type' => 'jenis wajib diisi',
                'kantor_id' => 'kantor wajib diisi',
                'username' => 'username wajib diisi',
                'password'=>'password wajib diisi',
            ],
        );

        // if validator fails.
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Silahkan isi data dengan benar',
                'errors' => $validator->errors()
            ], 422);
        }

        // if validator success
        DB::beginTransaction();
        try {
            $lastPegawai = Pegawai::all()->count();
            $lastPegawai++;

            $foto_profil = null;
            $foto_stp = null;
            if($request->hasFile('foto_profil')){
                $foto_profil = $request->file('foto_profil')->store('peserta/foto_profil');
            }
            if($request->hasFile('foto_stp')){
                $foto_stp = $request->file('foto_stp')->store('peserta/foto_stp');
            }

            $pegawai = Pegawai::create([
                'code' => str_pad($lastPegawai, 5, '0', STR_PAD_LEFT),
                'name' => $request->name,
                'nik' => $request->nik,
                'nip' => $request->nip,
                'type' => $request->type,
                'kantor_id' => $request->kantor_id,
                'jenis_kelamin'=>$request->jenis_kelamin,
                'tempat_lahir'=>$request->tempat_lahir,
                'tanggal_lahir'=>$request->tanggal_lahir,
                'alamat_rumah'=>$request->alamat_rumah,
                'pendidikan_terakhir'=>$request->pendidikan_terakhir,
                'no_telp' => $request->no_telp,
                'email' => $request->email,
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
                'username'=> $request->username,
                "password"=>bcrypt($request->password),
            ]);
            DB::commit();
            return response()->json([
                'message' => 'Berhasil menambahkan pegawai',
                'data' =>  $pegawai
            ],200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal menambahkan pegawai',
                'errors' => [
                    "system error"=>$th->getMessage()
                ]
            ],402);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $roles = $this->roles();
        $kantors = Kantor::all();
        return response()->json([
            'message' => 'Success!',
            'data' =>$pegawai
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $roles = $this->roles();
        $kantors = Kantor::all();
        return response()->json([
            'message' => 'Success!',
            'data' => [
                'pegawai' => $pegawai,
                'roles' => $roles,
                'kantors' => $kantors,
            ]
        ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        if(auth()->user()->client_name !== $request->client_name){
            return abort(404);
        }
        // Validator
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'type' => 'required',
                'kantor' => 'required',
            ],
            [
                'name' => 'nama wajib diisi',
                'type' => 'jenis wajib diisi',
                'kantor' => 'kantor wajib diisi',
            ],
        );

        // if validator fails.
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Silahkan isi data dengan benar',
                'errors' => $validator->errors()
            ], 422);
        }

        $pegawai = Pegawai::findOrFail($id);

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

        // if validator success
        DB::beginTransaction();
        try {
            

            $pegawai->update([
                'name' => $request->name,
                'type' => $request->type,
                'kantor_id' => $request->kantor,
                'no_telp' => $request->no_telp,
                'nik' => $request->nik,
                'nip' => $request->nip,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'jenis_kelamin'=>$request->jenis_kelamin,
                'tempat_lahir'=>$request->tempat_lahir,
                'tanggal_lahir'=>$request->tanggal_lahir,
                'alamat_rumah'=>$request->alamat_rumah,
                'pendidikan_terakhir'=>$request->pendidikan_terakhir,
                'email' => $request->email,
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
                'message' => 'Berhasil update pegawai',
                'data' =>  $pegawai
            ],200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal update pegawai',
                'errors' => [
                    "system error"=>$th->getMessage()
                ]
            ],402);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($code)
    {
        // if validator success
        DB::beginTransaction();
        try {
            $pegawai = Pegawai::where('code', $code)->first();
            $pegawaiName = $pegawai->name;

            $pegawai->delete($pegawai);
            DB::commit();
            return response()->json([
                'message' => 'Berhasil hapus pegawai',
                'data' =>  $pegawai
            ],200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal hapus pegawai',
                'errors' => [
                    "system error"=>$th->getMessage()
                ]
            ],402);
        }
    }
}
