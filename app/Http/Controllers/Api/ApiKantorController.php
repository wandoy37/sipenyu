<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kantor;
use Illuminate\Http\Request;

class ApiKantorController extends Controller
{
    function index(Request $request) {
        $kantors = Kantor::with('kecamatans.kabkota');
        if($request->has('search')){
            $kantors = $kantors->where(function($w)use($request){
                $w->where('name','like','%'.$request->search.'%')
                ->orWhere('alamat','like','%'.$request->search.'%');
            });
        }
        return response()->json([
            'message' => 'Berhasil menampilkan data kantor',
            'data' => $kantors->paginate(10)->appends($request->all())
        ],200);
    }
}
