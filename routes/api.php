<?php

use App\Http\Controllers\Api\ApiLoginController;
use App\Http\Controllers\Api\ApiPegawaiController;
use App\Http\Controllers\Api\ApiRegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['as'=>'api.'],function(){
    Route::get('/pegawai/{id}/foto-profil/{basename}', [ApiPegawaiController::class,'getFotoProfil'])->name('pegawai.foto-profil');
    Route::get('/pegawai/{id}/foto-spt/{basename}', [ApiPegawaiController::class,'getFotoSpt'])->name('pegawai.foto-spt');
    
    Route::group(['middleware'=>'auth:api'],function(){
        Route::get('my-profil', [ApiPegawaiController::class,'profil'])->name('pegawai.profil');
        Route::post('my-profil', [ApiPegawaiController::class,'updateProfil'])->name('pegawai.update-profil');
        //crud
        Route::resource('pegawai', ApiPegawaiController::class);
    });
    

    Route::group(['prefix'=>'data-umum'],function(){
        Route::get('pegawai', [ApiPegawaiController::class,'dataUmumPegawai'])->name('data-umum.pegawai');
        Route::get('pegawai/{id}', [ApiPegawaiController::class,'detailUmumPegawai'])->name('data-umum.pegawai.detail');
    });

    Route::post('login',[ApiLoginController::class,'login']);
    Route::post('register',[ApiRegisterController::class,'register']);
});


