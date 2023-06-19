<?php

namespace App\Http\Controllers;

use App\Models\KabKota;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $kabkotas = KabKota::latest()->get();
        return view('home.index', compact('kabkotas'));
    }
}
