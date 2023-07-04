<?php

namespace App\Http\Controllers;

use App\Models\SaranMasukan;
use Illuminate\Http\Request;

class SaranMasukanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $saranMasukan = SaranMasukan::create([
                'nama' => $request->nama,
                'saran_masukan' => $request->saran_masukan,
            ]);
            //check if request ajax
            if ($request->ajax()) {
                //response json
                return response()->json([
                    'message' => 'Saran dan Masukan berhasil dikirim',
                    'data' => $saranMasukan,
                    'jumlah_komentar' => SaranMasukan::count(),
                ], 200);
            } else {
                //redirect
                return redirect()->back()->with('success', 'Saran dan Masukan berhasil dikirim');
            }
        } catch (\Throwable $th) {
            //throw $th;
             //check if request ajax
             if ($request->ajax()) {
                //response json
                return response()->json([
                    'message' => 'Saran dan Masukan gagal dikirim',
                    'data' => $th
                ], 400);
            } else {
                //redirect
                return redirect()->back()->with('success', 'Saran dan Masukan gagal dikirim');
            }
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SaranMasukan  $saranMasukan
     * @return \Illuminate\Http\Response
     */
    public function show(SaranMasukan $saranMasukan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SaranMasukan  $saranMasukan
     * @return \Illuminate\Http\Response
     */
    public function edit(SaranMasukan $saranMasukan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SaranMasukan  $saranMasukan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SaranMasukan $saranMasukan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SaranMasukan  $saranMasukan
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaranMasukan $saranMasukan)
    {
        //
    }
}
