<?php

namespace App\Http\Controllers;

use App\Models\Kantor;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PegawaiController extends Controller
{
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
    public function index()
    {
        $pegawais = Pegawai::latest()->get();
        return view('pegawai.index', compact('pegawais'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = $this->roles();
        $kantors = Kantor::all();
        return view('pegawai.create', compact('roles', 'kantors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validator
        $validator = Validator::make(
            $request->all(),
            [
                'code' => 'unique:pegawais',
                'name' => 'required',
                'type' => 'required',
                'kantor' => 'required',
            ],
            [
                'code' => 'kode tenaga kerja sudah digunakan!',
                'name' => 'nama wajib diisi',
                'type' => 'jenis wajib diisi',
                'kantor' => 'kantor wajib diisi',
            ],
        );

        // if validator fails.
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        // if validator success
        DB::beginTransaction();
        try {
            $lastPegawai = Pegawai::all()->count();
            $lastPegawai++;

            Pegawai::create([
                'code' => str_pad($lastPegawai, 5, '0', STR_PAD_LEFT),
                'name' => $request->name,
                'type' => $request->type,
                'kantor_id' => $request->kantor,
                'no_telp' => $request->no_telp,
                'email' => $request->email,
            ]);

            return redirect()->route('pegawai.index')->with('success', $request->name . ' telah di tambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $request->name . ' gagal di tambahkan.')->withInput($request->all());
        } finally {
            DB::commit();
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($code)
    {
        $pegawai = Pegawai::where('code', $code)->first();
        $roles = $this->roles();
        $kantors = Kantor::all();
        return view('pegawai.edit', compact('roles', 'kantors', 'pegawai'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $code)
    {
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
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        // if validator success
        DB::beginTransaction();
        try {
            $pegawai = Pegawai::where('code', $code)->first();

            $pegawai->update([
                'name' => $request->name,
                'type' => $request->type,
                'kantor_id' => $request->kantor,
                'no_telp' => $request->no_telp,
                'email' => $request->email,
            ]);

            return redirect()->route('pegawai.index')->with('success', $pegawai->name . ' telah di update.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $pegawai->name . ' gagal di update.')->withInput($request->all());
        } finally {
            DB::commit();
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
            return redirect()->route('pegawai.index')->with('success', $pegawaiName . ' telah di hapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('pegawai.index')->with('fails', $pegawaiName . ' gagal di hapus.');
        } finally {
            DB::commit();
        }
    }
}
