<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\TransaksiPenjualanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\BarangController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [WelcomeController::class, 'index']);

// Prefix untuk route terkait pengguna (user)
Route::prefix('/user')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/list', [UserController::class, 'list']);
    Route::get('/create', [UserController::class, 'create']);
    Route::post('/', [UserController::class, 'store']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::get('/{id}/edit', [UserController::class, 'edit']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
});


// Route resource m_user
Route::resource('m_user', POSController::class);

Route::resource('level', LevelController::class);
Route::post('/level/list', [LevelController::class, 'list']);

Route::resource('kategori', KategoriController::class);
Route::post('/kategori/list', [KategoriController::class, 'list']);

Route::resource('barang', BarangController::class);
Route::post('/barang/list', [BarangController::class, 'list']);

Route::resource('stok', StokController::class);
Route::post('/stok/list', [StokController::class, 'list']);

Route::resource('penjualan', TransaksiPenjualanController::class);
Route::post('/penjualan/list', [TransaksiPenjualanController::class, 'list']);
