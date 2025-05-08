<?php

namespace App\Http\Controllers;

use App\Models\KabKota;
use App\Models\Kantor;
use App\Models\Kecamatan;
use App\Models\SaranMasukan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $saran_masukan = SaranMasukan::latest()->get();
            return view('dashboard.index', compact('saran_masukan'));
        } else {
            $pegawais = DB::table('pegawais')
                ->join('kantors', 'pegawais.kantor_id', '=', 'kantors.id')
                ->join('kab_kotas', 'kantors.kabkota_id', '=', 'kab_kotas.id')
                ->join('kecamatans', 'kab_kotas.id', '=', 'kecamatans.kabkota_id')
                ->select(
                    'pegawais.code',
                    'pegawais.name',
                    'pegawais.nik',
                    'pegawais.nip',
                    'pegawais.type',
                    'kantors.name AS kantor',
                    'pegawais.no_telp',
                    'pegawais.email',
                    'kab_kotas.name AS kabkota',
                    DB::raw('MAX(kecamatans.name) AS kecamatan') // Menggunakan fungsi agregat
                )
                ->where('kab_kotas.id', Auth::user()->kabkota_id)
                ->groupBy('pegawais.code', 'pegawais.name', 'pegawais.nik', 'pegawais.nip', 'pegawais.type', 'kantor', 'pegawais.no_telp', 'pegawais.email', 'kabkota')
                ->distinct()
                ->get();

            $kecamatans = Kecamatan::where('kabkota_id', Auth::user()->kabkota_id)->get();
            $kantors = Kantor::where('kabkota_id', Auth::user()->kabkota_id)->get();

            return view('dashboard.index_operator', compact('pegawais', 'kecamatans', 'kantors'));
        }
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
        //
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
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
