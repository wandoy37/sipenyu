<?php

namespace App\Http\Controllers;

use App\Models\KabKota;
use App\Models\SaranMasukan;
use App\Models\uptd;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $kabkotas = KabKota::latest()->get();
        $saranMasukans = SaranMasukan::latest()->get();
        return view('home.index', compact('kabkotas', 'saranMasukans'));
    }

    public function layanan()
    {
        $uptds = uptd::all();
        return view('home.layanan.index', compact('uptds'));
    }

    public function layananShow($slug)
    {
        $uptd = uptd::where('slug', $slug)->first();
        return view('home.layanan.show', compact('uptd'));
    }
}
