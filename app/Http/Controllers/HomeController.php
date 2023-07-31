<?php

namespace App\Http\Controllers;

use App\Models\KabKota;
use App\Models\SaranMasukan;
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
        return view('home.layanan.index');
    }

    public function layananShow()
    {
        return view('home.layanan.show');
    }
}
