<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LoginPegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApiLoginController extends Controller
{
    function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required|min:6',
            'password' => 'required|min:6',
            'client_name'=>'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Silahkan isi data dengan benar',
                'errors' => $validator->errors()
            ], 422);
        }

        $credentials = request()->only('username', 'password');
        if (auth()->guard('login_pegawai')->attempt($credentials)) {
            $data = auth()->guard('login_pegawai')->user();
            
            $pegawai = $data->pegawai;
            $api_token = Str::random(60);
            $token = $data->loginPegawaiApiToken()->updateOrCreate([
                'client_name' => $request->client_name
            ],[
                'api_token' => hash('sha256',$api_token ),
                'web_hook'=>$request->web_hook
            ]);
            return response()->json([
                'message' => 'Berhasil login',
                'api_token' => $api_token,
                'data'=>LoginPegawai::with('pegawai.kantor')->where('id',$token->login_pegawai_id)->first()
            ],200);
        } else {
            return response()->json([
                'message' => 'Username atau password salah',
                'errors' => [
                    'username' => ['Username atau password salah']
                ]
            ],404);
        }
    }
}
