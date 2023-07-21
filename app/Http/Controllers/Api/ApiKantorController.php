<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kantor;
use Illuminate\Http\Request;

class ApiKantorController extends Controller
{
    function index() {
        $kantors = Kantor::with('kecamatans.kabkota')->get();
        return response()->json([
            'message' => 'Berhasil menampilkan data kantor',
            'data' => $kantors
        ],200);
    }
}
