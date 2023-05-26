<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KabKotaController;
use App\Http\Controllers\KantorController;
use App\Http\Controllers\KecamatanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    // dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Kab Kota
    Route::get('/kabupaten-kota', [KabKotaController::class, 'index'])->name('kabkota.index');
    Route::get('/kabupaten-kota/tambah', [KabKotaController::class, 'create'])->name('kabkota.create');
    Route::post('/kabupaten-kota/store', [KabKotaController::class, 'store'])->name('kabkota.store');
    Route::get('/kabupaten-kota/{code}', [KabKotaController::class, 'edit'])->name('kabkota.edit');
    Route::patch('/kabupaten-kota/{code}/update', [KabKotaController::class, 'update'])->name('kabkota.update');
    Route::delete('/kabupaten-kota/{code}/delete', [KabKotaController::class, 'destroy'])->name('kabkota.delete');

    // Kecamatan
    Route::get('/kecamatan', [KecamatanController::class, 'index'])->name('kecamatan.index');
    Route::get('/kecamatan/tambah', [KecamatanController::class, 'create'])->name('kecamatan.create');
    Route::post('/kecamatan/store', [KecamatanController::class, 'store'])->name('kecamatan.store');
    // Show Kecamatan By kabkota_id
    Route::get('/get-kecamatan/{id}', function ($id) {
        $kecamatan = App\Models\Kecamatan::where('kabkota_id', $id)->get();
        return response()->json($kecamatan);
    })->name('get.kecamatan');
    Route::get('/kecamatan/{code}', [KecamatanController::class, 'edit'])->name('kecamatan.edit');
    Route::patch('/kecamatan/{code}/update', [KecamatanController::class, 'update'])->name('kecamatan.update');
    Route::delete('/kecamatan/{code}/delete', [KecamatanController::class, 'destroy'])->name('kecamatan.delete');

    // Kantor
    Route::get('/kantor', [KantorController::class, 'index'])->name('kantor.index');
    Route::get('/kantor/tambah', [KantorController::class, 'create'])->name('kantor.create');
    Route::post('/kantor/store', [KantorController::class, 'store'])->name('kantor.store');
    Route::get('/kantor/{code}/edit', [KantorController::class, 'edit'])->name('kantor.edit');
    Route::patch('/kantor/{code}/update', [KantorController::class, 'update'])->name('kantor.update');
    Route::delete('/kantor/{code}/delete', [KantorController::class, 'destroy'])->name('kantor.delete');
});
