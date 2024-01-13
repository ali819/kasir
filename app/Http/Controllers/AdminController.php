<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    //
    public function kasir()
    {
        return view('menu.kasir');
    }
    public function data_pembelian()
    {
        return view('menu.data_pembelian');
    }
    public function kelola_stok_harga()
    {
        return view('menu.kelola_stok_harga');
    }

    // 
    public function tabel_stok(Request $request)
    {
        if($request->ajax()) {
            $stok = $request->stok;
            if($stok == 1) {
                $data = DB::table('stok_barang')->where('stok','>', 0)->select('*');
                
            } else if($stok == 2) {
                $data = DB::table('stok_barang')->where('stok','<', 1)->select('*');
                
            } else {
                $data = DB::table('stok_barang')->select('*');
            }
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->make(true);
        }
    }
    public function tambah_barang_baru(Request $request)
    {
        $messages = [
            'tbhNamaBarang.required' => 'Nama barang tidak boleh kosong!',
            'tbhNamaBarang.unique' => 'Nama barang sudah ada!',
            'tbhHargaPerBiji.required' => 'Harga satuan tidak boleh kosong!',
            'tbhHargaPerBiji.numeric' => 'Harga satuan harus angka!',
            'tbhHargaGrosir.required' => 'Harga grosir tidak boleh kosong!',
            'tbhHargaGrosir.numeric' => 'Harga grosir harus angka!',
            'tbhQtyGrosir.required' => 'Jumlah grosir tidak boleh kosong!',
            'tbhQtyGrosir.numeric' => 'Jumlah grosir harus angka!'
        ];
        
        $validator = Validator::make($request->all(), [
            'tbhNamaBarang' => ['required','unique:stok_barang,nama_barang'],
            'tbhHargaPerBiji' => ['required','numeric'],
            'tbhHargaGrosir' => ['required','numeric'],
            'tbhQtyGrosir' => ['required','numeric'],
        ], $messages);
    
        // Respon jika validasi gagal
        if ($validator->fails()) {

            return response()->json([
                'kode' => 422,
                'pesan' => $validator->errors(),
            ]); 
            
        }

        // jika berhasil
        $nama_barang = $request->tbhNamaBarang;
        $harga_per_biji = $request->tbhHargaPerBiji;
        $harga_grosir = $request->tbhHargaGrosir;
        $kategori_barang = 'satuan_tetap';
        $qty_grosir = $request->tbhQtyGrosir;
        $stok = $request->tbhStok;
        if($stok == null) {
            $stok = 0;
        }
        if (!is_numeric($stok)) {
            $stok = 0;
        }
        $keterangan = $request->tbhKeterangan;
        $timestamp = Carbon::now();

        DB::table('stok_barang')->insert([
            'nama_barang' => $nama_barang,
            'harga_per_biji' => $harga_per_biji,
            'harga_grosir' => $harga_grosir,
            'kategori_barang' => $kategori_barang,
            'qty_grosir' => $qty_grosir,
            'stok' => $stok,
            'keterangan' => $keterangan,
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);
        
        return response()->json([
            'kode' => 200,
            'pesan' => 'Berhasil ditambahkan!',
        ]); 

    }

    public function hapus_data_barang(Request $request)
    {
        $id = $request->id;
        if($id == null) {
            return abort(500);
        }

        DB::table('stok_barang')->where('id',$id)->delete();
        
        return response()->json([
            'kode' => 200,
            'pesan' => 'Berhasil dihapus!',
        ]); 

    }

    public function update_barang(Request $request)
    {
        $messages = [
            'updateId.required' => 'ID tidak boleh kosong, silahkan reload laman!',
            'updateNamaBarang.required' => 'Nama barang tidak boleh kosong!',
            'updateHargaPerBiji.required' => 'Harga satuan tidak boleh kosong!',
            'updateHargaPerBiji.numeric' => 'Harga satuan harus angka!',
            'updateHargaGrosir.required' => 'Harga grosir tidak boleh kosong!',
            'updateHargaGrosir.numeric' => 'Harga grosir harus angka!',
            'updateQtyGrosir.required' => 'Jumlah grosir tidak boleh kosong!',
            'updateQtyGrosir.numeric' => 'Jumlah grosir harus angka!',
        ];
        
        $validator = Validator::make($request->all(), [
            'updateId' => ['required'],
            'updateNamaBarang' => ['required'],
            'updateHargaPerBiji' => ['required','numeric'],
            'updateHargaGrosir' => ['required','numeric'],
            'updateQtyGrosir' => ['required','numeric'],
        ], $messages);
    
        // Respon jika validasi gagal
        if ($validator->fails()) {

            return response()->json([
                'kode' => 422,
                'pesan' => $validator->errors(),
            ]); 
            
        }

        // jika berhasil
        $id = $request->updateId;
        $nama_barang = $request->updateNamaBarang;
        $harga_per_biji = $request->updateHargaPerBiji;
        $harga_grosir = $request->updateHargaGrosir;
        $qty_grosir = $request->updateQtyGrosir;
        $stok = $request->updateStok;
        if($stok == null) {
            $stok = 0;
        }
        if (!is_numeric($stok)) {
            $stok = 0;
        }
        $keterangan = $request->updateKeterangan;
        $timestamp = Carbon::now();

        // cek nama barang agar tidak sama
        $check = DB::table('stok_barang')->where('nama_barang', $nama_barang)->whereNotIn('id', [$id])->first();
        if($check) {
            return response()->json([
                'kode' => 500,
                'pesan' => 'Nama barang sudah ada!',
            ]); 
        }

        DB::table('stok_barang')->where('id',$id)->update([
            'nama_barang' => $nama_barang,
            'harga_per_biji' => $harga_per_biji,
            'harga_grosir' => $harga_grosir,
            'qty_grosir' => $qty_grosir,
            'stok' => $stok,
            'keterangan' => $keterangan,
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);
        
        return response()->json([
            'kode' => 200,
            'pesan' => 'Berhasil diperbarui!',
        ]); 
    }

}
