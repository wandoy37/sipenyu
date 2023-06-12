<?php

namespace App\Http\Controllers;

use App\Models\KabKota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class KabKotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kabkotas = KabKota::latest()->get();
        return view('kabkota.index', compact('kabkotas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kabkota.create');
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
                'code' => 'unique:kab_kotas',
                'name' => 'required',
            ],
            [
                'code.unique' => 'kode kabupaten kota sudah di gunakan!',
                'name.required' => 'nama kabupaten kota wajib di isi',
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
            $lastKabKota = KabKota::all()->count();
            $lastKabKota++;

            KabKota::create([
                'code' => str_pad($lastKabKota, 5, '0', STR_PAD_LEFT),
                'name' => $request->name,
            ]);

            return redirect()->route('kabkota.index')->with('success', $request->name . ' telah di tambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('kabkota.index')->with('fails', $request->name . ' gagal di tambahkan.');
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
        //get first code
        $kabkota = KabKota::where('code', $code)->first();
        return view('kabkota.edit', compact('kabkota'));
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
            ],
            [
                'name.required' => 'nama kabupaten kota wajib di isi',
            ],
        );

        // If validator fails.
        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Gagal melakukan perubahan !');
        }

        // If validator success
        DB::beginTransaction();
        try {
            //get first code
            $kabkota = KabKota::where('code', $code)->first();
            $name = $kabkota->name;

            $kabkota->update([
                'name' => $request->name,
            ]);

            return redirect()->route('kabkota.index')->with('success', 'Kabupaten Kota ' . $name . ' berhasil di ubah menjadi ' . $request->name);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('kabkota.index')->with('fails', 'Kabupaten Kota ' . $name . ' gagal di ubah.');
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
        //get first code
        $kabkota = KabKota::where('code', $code)->first();

        DB::beginTransaction();
        try {
            $kabkota->delete($kabkota);
            return redirect()->route('kabkota.index')->with('warning', 'Berhasil menghapus kabupaten kota ' . $kabkota->name);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('kabkota.index')->with('error', 'Gagal menghapus kabupaten kota ' . $kabkota->name);
        } finally {
            DB::commit();
        }
    }
}
