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
    public function dashboard()
    {
        // Menggunakan query builder untuk mengambil total jumlah pembelian per tanggal
        $chartData = DB::table('data_pembelian_detail')
        ->select(DB::raw('DATE(created_at) as tanggal'), DB::raw('SUM(total_harga) as jumlah'))
        ->where('created_at', '>=', now()->subDays(6)->format('Y-m-d')) // Ambil data 6 hari terakhir
        ->groupBy('tanggal')
        ->orderBy('tanggal', 'DESC') // Urutkan berdasarkan tanggal secara desc
        ->get();

        // Buat array tanggal dengan subDay(6)
        $arrayTanggal = collect(range(0, 5))->map(function ($index) {
            return now()->subDays($index)->format('Y-m-d');
        });
        $arrayTanggalIso = collect(range(0, 5))->map(function ($index) {
            return now()->subDays($index)->isoFormat('D MMMM');
        });

        // Buat array yValues, isi dengan 0 jika tanggal tidak ditemukan
        $jumlahValues = $arrayTanggal->map(function ($date) use ($chartData) {
            $chartItem = $chartData->firstWhere('tanggal', Carbon::parse($date)->format('Y-m-d'));
            return $chartItem ? $chartItem->jumlah : "0";
        })->toArray();

        // Mengelompokkan data untuk chart
        $xValues = $arrayTanggalIso->toArray();
        $yValues = $jumlahValues;

        $totalPenjualan = 'Rp ' . number_format(array_sum($jumlahValues), 0, ',', '.');
        $totalTransaksi = DB::table('data_pembelian_detail')
            ->select('id_transaksi') 
            ->whereDate('created_at', '>=', now()->subDays(5)->format('Y-m-d'))
            ->groupBy('id_transaksi')
            ->get()
            ->count();
        $totalBarangTerjual =  DB::table('data_pembelian_detail')
            ->whereDate('created_at', '>=', now()->subDays(5)->format('Y-m-d'))
            ->sum('qty'); 

        // produk terlaris
        $topProducts = DB::table('data_pembelian_detail')
        ->select('nama_barang', DB::raw('SUM(qty) as total_qty'))
        ->where('created_at', '>=', now()->subDays(6)->format('Y-m-d'))
        ->groupBy('nama_barang')
        ->orderByDesc('total_qty')
        ->limit(5)
        ->get(); 

        return view('menu.dashboard', compact('xValues', 'yValues','totalPenjualan','totalTransaksi','totalBarangTerjual','topProducts'));
    }

    public function kasir()
    {
        $list_barang = DB::table('stok_barang')
        ->select('id','nama_barang')
        ->orderBy('nama_barang')
        ->get();
        return view('menu.kasir',compact('list_barang'));
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
                $satuanList = [];
                foreach ($dynamicForm as $input) {
                    $hargaSatuan = $input['tbhHargaSatuanDynamic'];
                    $satuan = $this->UpperFirstText($input['tbhSatuanDynamic']);

                    // Periksa apakah satuan sudah ada sebelumnya
                    if (in_array($satuan, $satuanList)) {
                        // Jika satuan sudah ada, Anda dapat menangani situasi duplikat di sini
                        $pesan = 'Satuan "'.$satuan.'" tidak boleh duplikat!';
                        return response()->json([
                            'kode' => 500,
                            'pesan' => $pesan
                        ]);
                        break;
                    }

                    // Tambahkan satuan ke daftar
                    $satuanList[] = $satuan;
                
                    $insert[] = [
                        'id_stok_barang' => $idStokBarang,
                        'harga' => $hargaSatuan,
                        'satuan' => $satuan,
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

        $hitung = DB::table('list_satuan_tidak_tetap')->where('id',$id)->count();
        if($hitung <= 1) {
            return response()->json([
                'kode' => 400,
                'pesan' => 'Minimal harus ada 1 data!',
            ]); 
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
            $satuanList = [];
            foreach($dynamicUpdateInput as $input) {

                $id_satuan = $input['UpdateSatuanId1'];
                $satuan = $this->UpperFirstText($input['UpdateSatuanDynamic1']);
                $harga = $input['UpdateHargaSatuanDynamic1'];


                // Periksa apakah satuan sudah ada sebelumnya
                if (in_array($satuan, $satuanList)) {
                    // Jika satuan sudah ada, kirim respons JSON yang sesuai
                    $pesan = 'Satuan "'.$satuan.'" tidak boleh sama / duplikat!';
                    return response()->json([
                        'kode' => 500,
                        'pesan' => $pesan
                    ]);
                    // Hentikan iterasi loop
                    break;
                }
                // Tambahkan satuan ke daftar
                $satuanList[] = $satuan;

                if($id_satuan) {
                    DB::table('list_satuan_tidak_tetap')->where('id',$id_satuan)->update([
                        'harga' => $harga,
                        'satuan' => $satuan,
                        'updated_at' => $timestamp,
                    ]);
                } else {
                    DB::table('list_satuan_tidak_tetap')->insert([
                        'id_stok_barang' => $id,
                        'harga' => $harga,
                        'satuan' => $satuan,
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


    public function detail_data_barang(Request $request)
    {

        $id = $request->id;
        if($id == null) {
            return response()->json([
                'kode' => 404,
                'pesan' => 'ID barang tidak boleh kosong!',
            ]);
        }

        $barang = DB::table('stok_barang')->where('id',$id)->first();
        if(!$barang) {
            return response()->json([
                'kode' => 404,
                'pesan' => 'ID barang tidak ditemukan!',
            ]);
        } 
        // check kategorinya
        $kategori_barang = $barang->kategori_barang;
        $nama_barang = $barang->nama_barang;

        if($kategori_barang == 'satuan_tetap') {
            
            $detail_barang = $barang;
            
        } else if($kategori_barang == 'satuan_tidak_tetap') {
            
            $data_barang = DB::table('list_satuan_tidak_tetap')->where('id_stok_barang',$id)->get();
            if($data_barang->count() < 1) {
                return response()->json([
                    'kode' => 404,
                    'pesan' => 'Satuan barang belum di tambahkan!',
                ]);
            }

            $detail_barang = $data_barang;

        } else {
            return response()->json([
                'kode' => 404,
                'pesan' => 'Satuan barang tidak ditentukan!',
            ]);
        }

        return response()->json([
            'kode' => 200,
            'kategori_barang' => $kategori_barang,
            'detail_barang' => $detail_barang,
            'nama_barang' => $nama_barang,
        ]);
    }

    public function konfirmasi_pembelian_barang(Request $request)
    {

        // Mendapatkan data dinamis dari request
        $dynamicTabelBelanja = $request->input('dynamicTabelBelanja');
        $total_belanja = $request->total_belanja;
        $total_bayar = $request->total_bayar;
        $kembalian = $request->kembalian;
        $pembeli = $request->pembeli;

        // DB transaction 
        try {
            // Memulai transaksi database
            DB::beginTransaction();

            $timestamp = Carbon::now();

            // cek id
            $data_pembeli = DB::table('data_pembelian')->orderBy('id','DESC')->first();
            if(!$data_pembeli) {
                $id_transaksi = 'TRX-1';
            } else {
                $urutan = $data_pembeli->id + 1;
                $id_transaksi = 'TRX-'.$urutan;
            }

            // ambil data 
            $data_pembelian = [];
            $data_pembelian_detail = [];

            $id_barang_stok = [];
            $list_id = [];

            $list_data_belanja = [];

            // Lakukan sesuatu dengan data yang diterima, contohnya:
            foreach ($dynamicTabelBelanja as $index => $data) {
                $index++;
                $id_barang = $data['id_barang'];
                $nama_barang = $data['nama_barang'];
                $satuan = $data['satuan'];
                $total_qty = $data['total_qty'];
                $total_harga = $data['total_harga'];
                $harga = $data['harga'];

                // Validasi jika null atau kosong
                if (empty($total_qty) || empty($total_harga) || $total_qty <= 0 || $total_harga <= 0) {
                    return response()->json([
                        'kode' => 500,
                        'pesan' => 'Jumlah beli / harga barang tidak boleh kosong!',
                    ]);
                    // Hentikan iterasi loop
                    break;
                }

                $list_data_belanja[] = [
                    'nomor' => $index,
                    'nama_barang' => $nama_barang,
                    'total_qty' => $total_qty,
                    'satuan' => $satuan,
                    'harga' => $harga,
                ];
            
                $data_pembelian_detail[] = [
                    'id_transaksi' => $id_transaksi,
                    'nama_barang' => $nama_barang,
                    'satuan' => $satuan,
                    'qty' => $total_qty,
                    'harga' => $harga,
                    'total_harga' => $total_harga,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ];

                // update stok barang 
                $kategori_barang = 'satuan_tetap';
                $barang = DB::table('stok_barang')->where('id',$id_barang)->where('kategori_barang',$kategori_barang)->first();
                if($barang) {
                    $stok_sekarang = $barang->stok;
                    if($stok_sekarang > 0) {
                        
                        // hitung berdasarkan satuan (ecer) / (grosir)
                        $data_satuan = strtolower($satuan);
                        if($data_satuan == 'grosir') {
                            $dikurangi = $total_qty * $barang->qty_grosir;
                        } else {
                            $dikurangi = $total_qty;
                        }

                        $hasil_pengurangan = $stok_sekarang - $dikurangi;
                        if($hasil_pengurangan <= 0) {
                            $hasil_pengurangan = 0;
                        }
                        DB::table('stok_barang')->where('id',$id_barang)->update([
                            'stok' => $hasil_pengurangan,
                        ]);
                    }
                }
            }

            // 
            $data_pembelian[] = [
                'id_transaksi' => $id_transaksi,
                'pembeli' => $pembeli,
                'total_belanja' => $total_belanja,
                'total_bayar' => $total_bayar,
                'kembalian' => $kembalian,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ];

            // insert 
            DB::table('data_pembelian')->insert($data_pembelian);
            DB::table('data_pembelian_detail')->insert($data_pembelian_detail);

            // nota pembelian
            // android (rawbt)
            $dataToko = $this->informasiToko();
            $nama_toko = $dataToko['nama_toko'];
            $alamat_toko = $dataToko['alamat_toko'];
            $nota_pembelian = $this->HTMLNotaPembelian($list_data_belanja, $id_transaksi, $total_belanja, $total_bayar, $kembalian, $timestamp, $pembeli, $nama_toko, $alamat_toko);
            // pc / windows (recta host)
            if(!$pembeli) {
                $pembeli = '-';
            }
            $raw_data = [
                'list_data_belanja' => $list_data_belanja,
                'id_transaksi' => $id_transaksi,
                'total_belanja' => $total_belanja,
                'total_bayar' => $total_bayar,
                'kembalian' => $kembalian,
                'timestamp' => $timestamp,
                'pembeli' => $pembeli,
                'nama_toko' => $nama_toko,
                'alamat_toko' => $alamat_toko,
            ];

            // Commit transaksi jika berhasil
            DB::commit();
            // 
            return response()->json([
                'kode' => 200,
                'nota_pembelian' => $nota_pembelian,
                'raw_data' => $raw_data,
                'pesan' => 'Pembelian berhasil dikonfirmasi!'
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

    private function formatRupiah($amount)
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
    private function HTMLNotaPembelian($list_data_belanja, $id_transaksi, $total_belanja, $total_bayar, $kembalian, $timestamp, $pembeli, $nama_toko, $alamat_toko) {

        // cek nama pembeli
        if(!$pembeli) {
            $pembeli = '-';
        }

        // Jumlah dash yang diinginkan
        $jumlah_dash = 16;
        // Buat string dash dengan mengulang karakter '-' sebanyak jumlah yang diinginkan
        $dash = str_repeat('- ', $jumlah_dash);

        // header nota pembelian
        $nota_pembelian = 
        '
            <div class="col-12">
            <h5>
                <br>
                <span id="notaNamaToko">'.$nama_toko.'</span> - <span id="notaAlamat">'.$alamat_toko.'</span> 
            </h5>
            <p>
            '.$dash.'
                <br>
                <span id="notaIdTransaksi">'.$id_transaksi.'</span> <br> 
                <span id="notaTanggalPembelian">'.$timestamp.'</span>
            </p>
            <p>
                '.$dash.'
                <br>
        ';

        // foreach list belanjaan
        foreach($list_data_belanja as $item) {

            $nomor = $item['nomor'];
            $nama_barang = $item['nama_barang'];
            $total_qty = $item['total_qty'];
            $satuan = $item['satuan'];
            $harga = $item['harga'];
            $sub_total_harga = $total_qty * $harga;

            $nota_pembelian .='
                    '.$nama_barang.' ('.$satuan.')
                    <br>
                    '.$total_qty.' x '.$harga.' : '.$this->formatRupiah($sub_total_harga).'
                    <br>
                    <br>
            ';
        }

        // footer nota pembelian
        $nota_pembelian .=' 
                    '.$dash.'
                    <br>
                    NAMA PEMBELI
                    <br>
                    <span id="notaNamaPembeli">'.$pembeli.'</span>
                    <br>
                    '.$dash.'
                    <br>
                    TOTAL BELANJA
                    <br>
                    <span id="notaTotalBelanja">'.$this->formatRupiah($total_belanja).'</span>
                    <br>
                    '.$dash.'
                    <br>
                    TOTAL BAYAR
                    <br>
                    <span id="notaTotalBayar">'.$this->formatRupiah($total_bayar).'</span>
                    <br>
                    '.$dash.'
                    <br>
                    KEMBALIAN
                    <br>
                    <span id="notaKembalian">'.$this->formatRupiah($kembalian).'</span>
                    <br>
                    '.$dash.'
                    <br>
                </p>
            </div>
        ';

        return $nota_pembelian;

    }

    public function tabel_data_pembelian(Request $request)
    {
        if($request->ajax()) {
            $data = DB::table('data_pembelian')->select('*');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('formatted_date', function ($row) {
                        // Format the 'created_at' column as "Senin, 23 Desember 2024 10:10:10"
                        return Carbon::parse($row->created_at)->isoFormat('dddd, D MMMM YYYY HH:mm:ss');
                    })
                    ->make(true);
        }
    }

    public function detail_data_pembelian(Request $request)
    {
        $id_transaksi = $request->id_transaksi;
        if($id_transaksi == null) {
            return abort(404);
        }
        $data_pembelian = DB::table('data_pembelian')->where('id_transaksi',$id_transaksi)->first();
        $detail_pembelian = DB::table('data_pembelian_detail')->where('id_transaksi',$id_transaksi)->get();
        if($detail_pembelian->count() <= 0) {
            return response()->json([
                'kode' => 404,
                'pesan' => 'List barang tidak ditemukan!',
            ]);
        }
        if(!$data_pembelian) {
            return response()->json([
                'kode' => 404,
                'pesan' => 'ID transaksi tidak ditemukan!',
            ]);
        }
        
        // 
        $tanggal = $data_pembelian->created_at;
        $total_belanja = $data_pembelian->total_belanja;
        $total_bayar = $data_pembelian->total_bayar;
        $kembalian = $data_pembelian->kembalian;
        $list = $detail_pembelian;
        // 
        
        return response()->json([
            'kode' => 200,
            'tanggal' => $tanggal,
            'total_belanja' => $total_belanja,
            'total_bayar' => $total_bayar,
            'kembalian' => $kembalian,
            'list' => $list,
            'pesan' => 'Menampilkan detail pembelian.',
        ]);

        

    }

    public function hapus_data_pembelian(Request $request)
    {

        $list_id = $request->input('list_id_transaksi');
        if (empty($list_id)) { 
            return abort(404);
        }

        // DB transaction 
        try {
            // Memulai transaksi database
            DB::beginTransaction();

            // hapus data dari 2 tabel
            Db::table('data_pembelian')->whereIn('id_transaksi',$list_id)->delete();
            Db::table('data_pembelian_detail')->whereIn('id_transaksi',$list_id)->delete();

            // Commit transaksi jika berhasil
            DB::commit();
            // 
            return response()->json([
                'kode' => 200,
                'pesan' => 'Data berhasil dihapus!',
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

    public function nota_pembelian_html(Request $request)
    {
        $id_transaksi = $request->id_transaksi;
        if($id_transaksi == null) {
            return abort(404);
        }

        // ambil data
        $data_pembelian = DB::table('data_pembelian')->where('id_transaksi',$id_transaksi)->first();
        $data_pembelian_detail = DB::table('data_pembelian_detail')->where('id_transaksi',$id_transaksi)->get();
        if(!$data_pembelian) {
            return response()->json([
                'kode' => 404,
                'pesan' => 'ID transaksi pembelian tidak di temukan!',
            ]);
        }
        if($data_pembelian_detail->count() <= 0) {
            return response()->json([
                'kode' => 404,
                'pesan' => 'Detail pembelian tidak di temukan!',
            ]);
        }

        // variabel di kirim
        $list_data_belanja = [];
        foreach($data_pembelian_detail as $index => $item) {
            $index++;
            $list_data_belanja[] = [
                'nomor' => $index,
                'nama_barang' => $item->nama_barang,
                'total_qty' => $item->qty,
                'satuan' => $item->satuan,
                'harga' => $item->harga,
            ];

        }
        // 
        $id_transaksi = $data_pembelian->id_transaksi;
        $total_belanja = $data_pembelian->total_belanja;
        $total_bayar = $data_pembelian->total_bayar;
        $kembalian = $data_pembelian->kembalian;
        $timestamp = $data_pembelian->created_at;
        $pembeli = $data_pembelian->pembeli;
        if(!$pembeli) {
            $pembeli = '-';
        }
        $dataToko = $this->informasiToko();
        $nama_toko = $dataToko['nama_toko'];
        $alamat_toko = $dataToko['alamat_toko'];

        // android (rawbt)
        $nota_pembelian = $this->HTMLNotaPembelian($list_data_belanja, $id_transaksi, $total_belanja, $total_bayar, $kembalian, $timestamp, $pembeli, $nama_toko, $alamat_toko);
        // pc / windows (recta host)
        $raw_data = [
            'list_data_belanja' => $list_data_belanja,
            'id_transaksi' => $id_transaksi,
            'total_belanja' => $total_belanja,
            'total_bayar' => $total_bayar,
            'kembalian' => $kembalian,
            'timestamp' => $timestamp,
            'pembeli' => $pembeli,
            'nama_toko' => $nama_toko,
            'alamat_toko' => $alamat_toko,
        ];

        return response()->json([
            'kode' => 200,
            'nota_pembelian' => $nota_pembelian,
            'raw_data' => $raw_data,
            'pesan' => 'Mencetak nota pembelian',
        ]);
    }

    public function tabel_detail_pembelian(Request $request) 
    {
        if($request->ajax()) {
            $data = DB::table('data_pembelian_detail')->select('*');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('formatted_date', function ($row) {
                        // Format the 'created_at' column as "Senin, 23 Desember 2024 10:10:10"
                        return Carbon::parse($row->created_at)->isoFormat('dddd, D MMMM YYYY HH:mm:ss');
                    })
                    ->make(true);
        }
    }
    public function hitung_data_pembelian(Request $request)
    {
        $tanggal = $request->tanggal;
        if($tanggal == null) {
            return response()->json([
                'kode' => 404,
                'pesan' => 'Tanggal tidak boleh kosong!',
            ]);
        }

        $data = DB::table('data_pembelian_detail')->select('*')->where('created_at','LIKE',$tanggal.'%')->get();
        $total_omzet = $data->sum('total_harga');
        $total_transaksi = $data->groupBy('id_transaksi')->count();
        $barang_terjual = $data->sum('qty');

        $tanggal_formatted = Carbon::parse($tanggal)->isoFormat('dddd, D MMMM YYYY');

        return response()->json([
            'kode' => 200,
            'total_omzet' => 'Rp ' . number_format($total_omzet, 0, ',', '.'),
            'total_transaksi' => $total_transaksi,
            'barang_terjual' => $barang_terjual,
            'pesan' => 'Data : '.$tanggal_formatted,
        ]);
    }

    public function informasi_toko()
    {
        
        $data = $this->informasiToko();
        $nama_toko = $data['nama_toko'];
        $alamat_toko = $data['alamat_toko'];

        return view('menu.informasi_toko',compact('nama_toko','alamat_toko'));
    }
    public function update_informasi_toko(Request $request)
    {
        $nama_toko = $request->nama_toko;
        $alamat_toko = $request->alamat_toko; 

        Cache::forever('toko_info', ['nama_toko' => $nama_toko, 'alamat_toko' => $alamat_toko]);

        return response()->json([
            'kode' => 200,
            'pesan' => 'Berhasil diperbarui !',
        ]);
    }

    private function informasiToko() {
        $informasiToko = Cache::get('toko_info');
        if ($informasiToko === null) {
            $nama_toko = 'NAMA TOKO';
            $alamat_toko = 'ALAMAT';
        } else {
            $nama_toko = $informasiToko['nama_toko'];
            $alamat_toko = $informasiToko['alamat_toko'];
        }

        $data = [
            'nama_toko' => $nama_toko,
            'alamat_toko' => $alamat_toko,
        ];

        return $data;
    }

}
