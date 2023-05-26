<?php

namespace App\Http\Controllers;

use App\Models\KabKota;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KecamatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kecamatans = Kecamatan::latest()->get();
        return view('kecamatan.index', compact('kecamatans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kabkotas = KabKota::latest()->get();
        return view('kecamatan.create', compact('kabkotas'));
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
                'name' => 'required',
                'kabkota_id' => 'required',
            ],
            [
                'name.required' => 'nama kabupaten kota wajib di isi',
                'kabkota_id.required' => 'nama kabupaten kota wajib di isi',
            ],
        );

        // If validator fails.
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        // If validator success
        DB::beginTransaction();
        try {
            // Last data
            $lastKecamatan = Kecamatan::all()->count();
            $lastKecamatan++;

            Kecamatan::create([
                'code' => 'kecamatan-' . str_pad($lastKecamatan, 4, '0', STR_PAD_LEFT),
                'name' => $request->name,
                'kabkota_id' => $request->kabkota_id
            ]);

            return redirect()->route('kecamatan.index')->with('success', $request->name . ' telah di tambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('kecamatan.index')->with('fails', $request->name . ' gagal di tambahkan.');
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
        $kecamatan = Kecamatan::where('code', $code)->first();
        $kabkotas = KabKota::latest()->get();
        return view('kecamatan.edit', compact('kecamatan', 'kabkotas'));
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
                'kabkota_id' => 'required',
            ],
            [
                'name.required' => 'nama kabupaten kota wajib di isi',
                'kabkota_id.required' => 'nama kabupaten kota wajib di isi',
            ],
        );

        // If validator fails.
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        // If validator success
        DB::beginTransaction();
        try {
            $kecamatan = Kecamatan::where('code', $code)->first();
            $name = $kecamatan->name;

            $kecamatan->update([
                'name' => $request->name,
                'kabkota_id' => $request->kabkota_id
            ]);

            return redirect()->route('kecamatan.index')->with('success', 'kecamatan ' . $name . ' berhasil di ubah menjadi ' . $request->name);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('kecamatan.index')->with('fails', 'kecamatan ' . $name . ' gagal di ubah');
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
        $kecamatan = Kecamatan::where('code', $code)->first();
        DB::beginTransaction();
        try {
            $kecamatan->delete($kecamatan);
            return redirect()->route('kecamatan.index')->with('warning', 'Berhasil menghapus kecamatan ' . $kecamatan->name);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('kecamatan.index')->with('error', 'Gagal menghapus kecamatan ' . $kecamatan->name);
        } finally {
            DB::commit();
        }
    }
}