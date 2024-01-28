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

Route::get('/dashboard', [AdminController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

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
    
    Route::get('/stok/data-list-satuan-tidak-tetap', [AdminController::class, 'list_satuan_tidak_tetap'])->name('list_satuan_tidak_tetap');
    Route::delete('/stok/hapus-data-satuan-list', [AdminController::class, 'hapus_data_satuan_list'])->name('hapus_data_satuan_list');
    Route::post('/stok/update-barang-1', [AdminController::class, 'update_barang1'])->name('update_barang1');
    
    Route::get('/kasir/detail-data-barang', [AdminController::class, 'detail_data_barang'])->name('detail_data_barang');
    Route::post('/kasir/konfirmasi-pembelian-barang', [AdminController::class, 'konfirmasi_pembelian_barang'])->name('konfirmasi_pembelian_barang');

    Route::get('/data-pembelian/tabel-data-pembelian', [AdminController::class, 'tabel_data_pembelian'])->name('tabel_data_pembelian');
    Route::get('/data-pembelian/detail-data-pembelian', [AdminController::class, 'detail_data_pembelian'])->name('detail_data_pembelian');
    Route::delete('/data-pembelian/hapus-data-pembelian', [AdminController::class, 'hapus_data_pembelian'])->name('hapus_data_pembelian');
    Route::get('/data-pembelian/nota-pembelian-html', [AdminController::class, 'nota_pembelian_html'])->name('nota_pembelian_html');
    
    Route::get('/dashboard/tabel-detail-pembelian', [AdminController::class, 'tabel_detail_pembelian'])->name('tabel_detail_pembelian');
    Route::get('/dashboard/hitung-data-pembelian', [AdminController::class, 'hitung_data_pembelian'])->name('hitung_data_pembelian');

});

require __DIR__.'/auth.php';
