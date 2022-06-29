<?php

use App\Http\Controllers\Barang;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\Supplier;
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
    return redirect()->to('/login');
});
Route::middleware(['auth'])->group(function () {
    Route::resource('/dashboard/kasir', KasirController::class);
    Route::resource('/master/daftar-barang', Barang::class);
    Route::resource('/master/daftar-supplier', Supplier::class);
});
Route::group(['middleware'  =>  'auth', 'prefix' => 'dashboard'], function () {
    Route::get('', [Dashboard::class, 'index']);
    Route::get('/daftar-barang', [KasirController::class, 'daftarBarang']);
    Route::get('/select-barang', [KasirController::class, 'showSelectBarang']);
    Route::post('/tambah-cart', [KasirController::class, 'tambahCart']);
    Route::get('/lihat-cart', [KasirController::class, 'lihatCart']);
    Route::patch('/update-cart', [KasirController::class, 'updateCart']);
    Route::delete('/delete-cart', [KasirController::class, 'destroy']);
    Route::get('/bayar', [KasirController::class, 'bayar']);
});
