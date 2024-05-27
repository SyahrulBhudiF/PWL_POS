<?php

use App\Http\Controllers\Api\BarangController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\LevelController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\TransaksiPenjualan;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', RegisterController::class)->name('register');
Route::post('/login', LoginController::class)->name('login');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/logout', LogoutController::class)->name('logout');

/**
 * Route for Api Resource for LevelModel or m_levels Table
 */
Route::resource('levels', LevelController::class)->except(['create', 'edit']);

/**
 * Route for Api Resource for UserModel or m_user Table
 */
Route::resource('user', UserController::class)->except(['create', 'edit']);

/**
 * Route for Api Resource for KategoriModel or m_kategori Table
 */
Route::resource('kategori', KategoriController::class)->except(['create', 'edit']);

/**
 * Route for Api Resource for BarangModel or m_barang Table
 */
Route::resource('barang', BarangController::class)->except(['create', 'edit']);

/**
 * for register with user fill image in form
 */
Route::post('/register1', RegisterController::class)->name('register1');


/**
 * Route for Api Resource for PenjualanModel and PenjualanDetailModel or Transaksi Barang feature
 */
Route::resource('transaksi', TransaksiPenjualan::class)->except(['create', 'edit']);
