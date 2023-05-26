<?php

namespace App\Http\Controllers;

use App\Models\KabKota;
use App\Models\Kantor;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use function PHPUnit\Framework\returnSelf;

class KantorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kantors = Kantor::latest()->get();
        return view('kantor.index', compact('kantors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kabkotas = KabKota::latest()->get();
        return view('kantor.create', compact('kabkotas'));
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
                'kabkota_id' => 'required',
                'kecamatan_id' => 'required',
                'name' => 'required',
                'alamat' => 'required',
            ],
            [
                'kabkota_id.required' => 'kabupaten kota wajib di isi',
                'kecamatan_id.required' => 'kecamatan wajib di isi',
                'name.required' => 'nama kantor wajib di isi',
                'alamat.required' => 'alamat kantor wajib di isi',
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
            $lastKantor = Kantor::all()->count();
            $lastKantor++;

            Kantor::create([
                'code' => str_pad($lastKantor, 5, '0', STR_PAD_LEFT),
                'name' => $request->name,
                'alamat' => $request->alamat,
                'kabkota_id' => $request->kabkota_id,
                'kecamatan_id' => $request->kecamatan_id,

            ]);

            return redirect()->route('kantor.index')->with('success', $request->name . ' telah di tambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('kantor.index')->with('fails', $request->name . ' gagal di tambahkan.');
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
        $kantor = Kantor::where('code', $code)->first();
        $kabkotas = KabKota::latest()->get();
        return view('kantor.edit', compact('kantor', 'kabkotas'));
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
                'kabkota_id' => 'required',
                'kecamatan_id' => 'required',
                'name' => 'required',
                'alamat' => 'required',
            ],
            [
                'kabkota_id.required' => 'kabupaten kota wajib di isi',
                'kecamatan_id.required' => 'kecamatan wajib di isi',
                'name.required' => 'nama kantor wajib di isi',
                'alamat.required' => 'alamat kantor wajib di isi',
            ],
        );

        // If validator fails.
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        // If validator success
        DB::beginTransaction();
        try {
            $kantor = Kantor::where('code', $code)->first();
            $kantor->update([
                'name' => $request->name,
                'alamat' => $request->alamat,
                'kabkota_id' => $request->kabkota_id,
                'kecamatan_id' => $request->kecamatan_id,

            ]);

            return redirect()->route('kantor.index')->with('success', 'berhasil update kantor ' . $request->name);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('kantor.index')->with('error', 'gagal update kantor ' . $request->name);
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
        $kantor = Kantor::where('code', $code)->first();
        DB::beginTransaction();
        try {
            $kantor->delete($kantor);
            return redirect()->route('kantor.index')->with('warning', 'Berhasil menghapus kantor ' . $kantor->name);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('kantor.index')->with('error', 'Gagal menghapus kantor ' . $kantor->name);
        } finally {
            DB::commit();
        }
    }
}
