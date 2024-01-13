<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
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

Route::get('/', function () {
 
     // Periksa apakah pengguna sudah login
     if (auth()->check()) {
        // Jika sudah login, arahkan ke laman dashboard
        return redirect()->route('dashboard');
    }

    // Jika belum login, tampilkan laman login
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('/menu/dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // MENU
    Route::get('/kasir', [AdminController::class, 'kasir'])->name('kasir');
    Route::get('/data-pembelian', [AdminController::class, 'data_pembelian'])->name('data_pembelian');
    Route::get('/kelola-stok-harga', [AdminController::class, 'kelola_stok_harga'])->name('kelola_stok_harga');
    
    Route::get('/stok/tabel-stok', [AdminController::class, 'tabel_stok'])->name('tabel_stok');
    Route::post('/stok/tambah-barang-baru', [AdminController::class, 'tambah_barang_baru'])->name('tambah_barang_baru');
    Route::delete('/stok/hapus-barang', [AdminController::class, 'hapus_data_barang'])->name('hapus_data_barang');
    Route::post('/stok/update-barang', [AdminController::class, 'update_barang'])->name('update_barang');

    

});

require __DIR__.'/auth.php';
