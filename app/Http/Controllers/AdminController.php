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
        $kategori = $request->tbhKategoriBarang;
        if($kategori == 'satuan_tetap') {

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

        } else if($kategori == 'satuan_tidak_tetap') {
            $messages = [
                'tbhNamaBarang.required' => 'Nama barang tidak boleh kosong!',
                'tbhNamaBarang.unique' => 'Nama barang sudah ada!',
                'dynamicTbhInput.*.tbhHargaSatuanDynamic.required' => 'Harga satuan tidak boleh kosong!',
                'dynamicTbhInput.*.tbhHargaSatuanDynamic.numeric' => 'Harga satuan harus angka!',
                'dynamicTbhInput.*.tbhSatuanDynamic.required' => 'Satuan tidak boleh kosong!',
            ];
            $validator = Validator::make($request->all(), [
                'tbhNamaBarang' => ['required','unique:stok_barang,nama_barang'],
                'dynamicTbhInput.*.tbhHargaSatuanDynamic' => ['required', 'numeric'],
                'dynamicTbhInput.*.tbhSatuanDynamic' => ['required'],
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
            $harga_per_biji = 0;
            $harga_grosir = 0;
            $kategori_barang = 'satuan_tidak_tetap';
            $qty_grosir = 1;
            $stok = 0;
            $keterangan = null;
            $timestamp = Carbon::now();
            // 
            $dynamicForm = $request->input('dynamicTbhInput');
            
        } else {
            return abort(500);
        }

        // DB transaction 
        try {
            // Memulai transaksi database
            DB::beginTransaction();

            $idStokBarang = DB::table('stok_barang')->insertGetId([
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

            if($kategori == 'satuan_tidak_tetap') {
                $insert = [];
                foreach ($dynamicForm as $input) {
                    $hargaSatuan = $input['tbhHargaSatuanDynamic'];
                    $satuan = strtolower($input['tbhSatuanDynamic']);
                
                    $insert[] = [
                        'id_stok_barang' => $idStokBarang,
                        'harga' => $hargaSatuan,
                        'satuan' => ucwords($satuan),
                        'created_at' => $timestamp,
                        'updated_at' => $timestamp,
                    ];
                }

                DB::table('list_satuan_tidak_tetap')->insert($insert);

            }
            
            // Commit transaksi jika berhasil
            DB::commit();
            // 
            return response()->json([
                'kode' => 200,
                'pesan' => 'Berhasil ditambahkan!',
            ]); 

        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi pengecualian
            DB::rollback();

            // Membaca pesan error dari pengecualian
            $errorMessage = $e->getMessage();

            // Mengirim pesan error sebagai respons HTTP 500
            return response($errorMessage, 500);
        }



    }
    private function UpperFirstText($text) {
        $lowerText = strtolower($text);
        $convertedText = ucwords($lowerText);
        return $convertedText;
    }

    public function hapus_data_barang(Request $request)
    {
        $id = $request->id;
        if($id == null) {
            return abort(500);
        }

        // DB transaction 
        try {
            // Memulai transaksi database
            DB::beginTransaction();
            //  delete
            DB::table('stok_barang')->where('id',$id)->delete();
            DB::table('list_satuan_tidak_tetap')->where('id_stok_barang',$id)->delete();
            // Commit transaksi jika berhasil
            DB::commit();

        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi pengecualian
            DB::rollback();

            // Membaca pesan error dari pengecualian
            $errorMessage = $e->getMessage();

            // Mengirim pesan error sebagai respons HTTP 500
            return response($errorMessage, 500);
        }
        
        
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

    public function list_satuan_tidak_tetap(Request $request)
    {
        $id = $request->id;
        if($id == null) {
            return abort(404);
        }

        $list_satuan = DB::table('list_satuan_tidak_tetap')->where('id_stok_barang',$id)->get();
        if($list_satuan->count() < 1) {

            return response()->json([
                'kode' => 201,
                'list_satuan' => $list_satuan,
                'pesan' => 'Data satuan belum di tetapkan!',
            ]); 

        }

        return response()->json([
            'kode' => 200,
            'list_satuan' => $list_satuan,
            'pesan' => 'Memuat data satuan',
        ]); 
    }

    public function hapus_data_satuan_list(Request $request)
    {
        $id = $request->id;
        if($id == null) {
            return abort(500);
        }

        DB::table('list_satuan_tidak_tetap')->where('id',$id)->delete();

        return response()->json([
            'kode' => 200,
            'pesan' => 'Berhasil dihapus !',
        ]); 
    }

    // update barang satuan tidak tetap
    public function update_barang1(Request $request)
    {
        $messages = [
            'updateId1.required' => 'ID tidak boleh kosong!',
            'updateNamaBarang1.required' => 'Nama barang tidak boleh kosong!',
            'dynamicUpdateInput.*.UpdateSatuanDynamic1.required' => 'Satuan tidak boleh kosong!',
            'dynamicUpdateInput.*.UpdateHargaSatuanDynamic1.required' => 'Harga satuan tidak boleh kosong!',
            'dynamicUpdateInput.*.UpdateHargaSatuanDynamic1.numeric' => 'Harga satuan harus angka!',

        ];
        $validator = Validator::make($request->all(), [
            'updateId1' => ['required'],
            'updateNamaBarang1' => ['required'],
            'dynamicUpdateInput.*.UpdateSatuanDynamic1' => ['required'],
            'dynamicUpdateInput.*.UpdateHargaSatuanDynamic1' => ['required','numeric'],

        ], $messages);
        // Respon jika validasi gagal
        if ($validator->fails()) {

            return response()->json([
                'kode' => 422,
                'pesan' => $validator->errors(),
            ]); 
            
        }

        // jika berhasil
        $id = $request->updateId1;
        $nama_barang = $request->updateNamaBarang1;
        $dynamicUpdateInput = $request->input('dynamicUpdateInput');
        $timestamp = Carbon::now();

        // DB transaction 
        try {
            // Memulai transaksi database
            DB::beginTransaction();

            // update stok_barang
            $check = DB::table('stok_barang')->where('nama_barang', $nama_barang)->whereNotIn('id', [$id])->first();
            if($check) {
                return response()->json([
                    'kode' => 500,
                    'pesan' => 'Nama barang sudah ada!',
                ]); 
            }
            DB::table('stok_barang')->where('id',$id)->update([
                'nama_barang' => $nama_barang,
                'updated_at' => $timestamp,
            ]);

            // update list_satuan_tidak_tetap
            foreach($dynamicUpdateInput as $input) {

                $id_satuan = $input['UpdateSatuanId1'];
                $satuan = strtolower($input['UpdateSatuanDynamic1']);
                $harga = $input['UpdateHargaSatuanDynamic1'];
                if($id_satuan) {
                    DB::table('list_satuan_tidak_tetap')->where('id',$id_satuan)->update([
                        'harga' => $harga,
                        'satuan' => ucwords($satuan),
                        'updated_at' => $timestamp,
                    ]);
                } else {
                    DB::table('list_satuan_tidak_tetap')->insert([
                        'id_stok_barang' => $id,
                        'harga' => $harga,
                        'satuan' => ucwords($satuan),
                        'created_at' => $timestamp,
                        'updated_at' => $timestamp,
                    ]);
                }

            }

            // Commit transaksi jika berhasil
            DB::commit();

            return response()->json([
                'kode' => 200,
                'pesan' => 'Berhasil diperbarui!',
            ]); 

        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi pengecualian
            DB::rollback();

            // Membaca pesan error dari pengecualian
            $errorMessage = $e->getMessage();

            // Mengirim pesan error sebagai respons HTTP 500
            return response($errorMessage, 500);
        }


    }

}
