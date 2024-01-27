@extends('layouts.main')
@section('content')
@section('title', 'Stok & Harga')

<style>
  .custom-d {
    margin-top: 10px;
  }
</style>

{{-- MAIN --}}
<div class="container-fluid">
    <!-- --------------------------------------------------- -->
    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
      <div class="card-body px-4 py-3">
        <div class="row align-items-center">
          <div class="col-9">
            <h4 class="fw-semibold mb-8">Kelola Stok & Harga</h4>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a class="text-muted" href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">Stok & Harga</li>
              </ol>
            </nav>
          </div>
          <div class="col-3">
            <div class="text-center mb-n5">
              {{--  --}}
            </div>
          </div>
        </div>
      </div>
      
    </div>
    <div class="row">

        <div class="col-12">
          <div class="alert customize-alert alert-dismissible text-primary border border-primary fade show remove-close-icon" role="alert">
            <div class="d-flex align-items-center font-medium me-3 me-md-0">
              <i class="ti ti-info-circle fs-5 me-2 flex-shrink-0 text-primary"></i>
              Pada menu ini menampilkan semua detail barang yang ada
            </div>
          </div>
        </div>
        <div class="col-12">
            <button type="button" class="btn btn-primary col-12 btnTambahBarang" data-bs-toggle="modal" data-bs-target="#ModalTambahBarang" style="font-weight:bold"><i class="ti ti-folder-plus"></i>&emsp;Tambahkan Barang</button>
        </div>
        <div class="col-12">
            <br>
        </div>
        <div class="col-6">
            <h5 class="card-title fw-semibold mb-0 lh-sm" style="color: rgb(48, 48, 48)">Pencarian</h5>
        </div>
        <div class="col-6" align="right">
            <button type="button" class="btn btn-outline-primary text btnRefreshData"><i class="ti ti-reload"></i>&emsp;Refresh Data</button>
        </div>
    </div>
    <div class="w-100 position-relative overflow-hidden">
      <div class="py-3 border-bottom">

        <div class="row">
          <div class="col-md-6">  
            <div class="mb-1">
              <input type="text" class="form-control" id="cariNamaBarang" name="cariNamaBarang" placeholder="Cari nama barang .." autocomplete="off">
            </div>
          </div>
          <div class="col-md-6">  
            <div class="mb-3">
              <select name="cariStok" id="cariStok" class="form-control">
                <option value="">- Filter -</option>
                <option value="1">Tampilkan : Stok Tersedia</option>
                <option value="2">Tampilkan : Stok Habis</option>
              </select>
            </div>
          </div>
          <div class="col-md-12">  
            <div class="mb-3">
              <select name="cariKategoriBarang" id="cariKategoriBarang" class="form-control">
                <option value="">- Semua Kategori -</option>
                <option value="satuan_tetap">Tampilkan : Satuan Tetap</option>
                <option value="satuan_tidak_tetap">Tampilkan : Satuan Tidak Tetap</option>
              </select>
            </div>
          </div>
          <div class="col-12">
            <div class="progress">
              <div class="progress-bar progress-bar-striped bg-primary progress-bar-animated animasiProgressBar" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
            </div>
          </div>
        </div>

        {{--  --}}

      </div>
      <div class="card-body">
        <div class="table-responsive rounded-2 mb-4">
          <br>
          <table class="table border text-nowrap customize-table mb-0 align-middle" id="tabel_stok">
            <thead class="text-dark fs-4">
              <tr>
                <th><h6 class="fs-4 fw- mb-0">ID</h6></th>
                <th><h6 class="fs-4 fw- mb-0">Detail&nbsp;Barang</h6></th>
                <th><h6 class="fs-4 fw- mb-0">Pilihan</h6></th>
              </tr>
            </thead>
          </table>
          <div class="d-flex align-items-center justify-content-end py-1">
            <br>
          </div>
        </div>
      </div>
    </div>
    <!-- --------------------------------------------------- -->
</div>

{{-- MODAL TAMBAH BARANG --}}
<div class="modal fade" id="ModalTambahBarang" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header d-flex align-items-center">
          <h4 class="modal-title" id="myLargeModalLabel">
            Tambah Barang Baru
          </h4>
        </div>
        <form id="FormTambahBarang" autocomplete="off">
          @csrf
          <div class="modal-body">
            <div class="card-body">
              <!--/row-->
              <div class="col-12">
                <div class="alert customize-alert alert-dismissible text-primary border border-primary fade show remove-close-icon" role="alert">
                  <div class="d-flex align-items-center font-medium me-3 me-md-0">
                    <i class="ti ti-info-circle fs-5 me-2 flex-shrink-0 text-primary"></i>
                    Silahkan tambah barang baru
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  {{--  --}}
                  <label for="" class=""><b>Nama Barang</b></label>
                  <input type="text" class="form-control" id="tbhNamaBarang" name="tbhNamaBarang" placeholder="Nama barang .." required>
                  <label for="" class=""><b>Kategori Barang</b></label>
                  <select name="tbhKategoriBarang" id="tbhKategoriBarang" class="form-control" required>
                    <option value="">- Pilih -</option>
                    <option value="satuan_tetap">Barang Satuan Tetap</option>
                    <option value="satuan_tidak_tetap">Barang Satuan Tidak Tetap</option>
                  </select>
                  
                  {{--  --}}
                  <div id="DataBarangDynamic">
                    
                  </div>
                  {{--  --}}
                </div>
                <!--/span-->
              </div>
              <!--/row-->
            </div>
          </div>
          <div class="modal-footer" style="margin-top:20px;">
              <button type="button" class="btn btn-danger btnBatalTambahBarang" data-bs-dismiss="modal">Batal&emsp;<i class="ti ti-x"></i></button>
              <button type="submit" class="btn btn-primary font-medium btnKonfirmasiTambahBarang" disabled>Silahkan Pilih Kategori..</button>
          </div>
        </form>
      </div>
    </div>
</div>

{{-- MODAL UPDATE BARANG --}}
<div class="modal fade" id="ModalUpdateBarang" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header d-flex align-items-center">
          <h4 class="modal-title" id="myLargeModalLabel">
            <span id="updateTitleNamaBarang">Perbarui Data Barang</span>
          </h4>
        </div>
        <form id="FormUpdateBarang" autocomplete="off">
          @csrf
          <div class="modal-body">
            <div class="card-body">
              <!--/row-->
              <div class="col-12">
                <div class="alert customize-alert alert-dismissible text-primary border border-primary fade show remove-close-icon" role="alert">
                  <div class="d-flex align-items-center font-medium me-3 me-md-0">
                    <i class="ti ti-info-circle fs-5 me-2 flex-shrink-0 text-primary"></i>
                    Silahkan perbarui data barang
                  </div>
                </div>
              </div>
              <div class="col-12" style="margin-top:10px;">
                <div class="alert customize-alert alert-dismissible text-primary border border-primary fade show remove-close-icon" role="alert">
                  <div class="d-flex align-items-center font-medium me-3 me-md-0">
                    <i class="ti ti-info-circle fs-5 me-2 flex-shrink-0 text-primary"></i>
                    Barang bisa dijual 'Eceran' & 'Grosir' ( Satuan tetap )
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  {{--  --}}
                  <input type="number" class="form-control" id="updateId" name="updateId" placeholder=".." required hidden>
                  <label for="" class=""><b>Nama Barang</b></label>
                  <input type="text" class="form-control" id="updateNamaBarang" name="updateNamaBarang" placeholder="Nama barang .." required>
                  <label for=""><b>Harga Per-Barang ( Eceran )</b> </label>
                  <input type="number" id="updateHargaPerBiji" name="updateHargaPerBiji" class="form-control terbilang" placeholder="Rp ( 0 - 999999 )" value="0" required>
                  <label for=""><b>Harga Grosir</b></label>
                  <input type="number" id="updateHargaGrosir" name="updateHargaGrosir" class="form-control terbilang" placeholder="Rp ( 0 - 999999 )" value="0" required>
                  <label for=""><b>1 Grosir = Berapa Barang ?</b></label>
                  <input type="number" id="updateQtyGrosir" name="updateQtyGrosir" class="form-control" placeholder="0 - 999999" required>
                  <label for=""><b>Jumlah Stok ( Dihitung Pcs )</b></label>
                  <input type="number" id="updateStok" name="updateStok" class="form-control" placeholder="0 - 999999">
                  <label for=""><b>Keterangan</b></label>
                  <textarea name="updateKeterangan" id="updateKeterangan" class="form-control" cols="30" rows="3" placeholder="Isi keterangan jika diperlukan .."></textarea>
                  {{--  --}}
                </div>
                <!--/span-->
              </div>
              <!--/row-->
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal&emsp;<i class="ti ti-x"></i></button>
              <button type="submit" class="btn btn-primary font-medium btnKonfirmasiUpdateBarang"><i class="ti ti-check"></i>&emsp;Perbarui</button>
          </div>
        </form>
      </div>
    </div>
</div>

{{-- MODAL UPDATE BARANG 1 --}}
<div class="modal fade" id="ModalUpdateBarang1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header d-flex align-items-center">
          <h4 class="modal-title" id="myLargeModalLabel">
            <span id="updateTitleNamaBarang1">Perbarui Data Barang</span>
          </h4>
        </div>
        <form id="FormUpdateBarang1" autocomplete="off">
          @csrf
          <div class="modal-body">
            <div class="card-body">
              <!--/row-->
              <div class="col-12">
                <div class="alert customize-alert alert-dismissible text-primary border border-primary fade show remove-close-icon" role="alert">
                  <div class="d-flex align-items-center font-medium me-3 me-md-0">
                    <i class="ti ti-info-circle fs-5 me-2 flex-shrink-0 text-primary"></i>
                    Silahkan perbarui data barang
                  </div>
                </div>
              </div>
              <div class="col-12" style="margin-top:10px;">
                <div class="alert customize-alert alert-dismissible text-primary border border-primary fade show remove-close-icon" role="alert">
                  <div class="d-flex align-items-center font-medium me-3 me-md-0">
                    <i class="ti ti-info-circle fs-5 me-2 flex-shrink-0 text-primary"></i>
                    Pembelian barang umumnya harus di timbang terlebih dahulu ( Satuan tidak tetap )
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  {{--  --}}
                  <input type="number" class="form-control" id="updateId1" name="updateId1" placeholder=".." required hidden>
                  <label for="" class=""><b>Nama Barang</b></label>
                  <input type="text" class="form-control" id="updateNamaBarang1" name="updateNamaBarang1" placeholder="Nama barang .." required>
                  <button type="button" class="btn btn-primary btnTambahListSatuanTidakTetap" style="font-weight: bold; width:100%; margin-top:10px;"><i class="ti ti-pencil-plus"></i>&emsp;Tambah Satuan Baru</button>
                  <div class="DynamicInputan">
        
                  </div>
                  {{--  --}}
                </div>
                <!--/span-->
              </div>
              <!--/row-->
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger btnTutupModalUpdateBarang1" data-bs-dismiss="modal">Tutup&emsp;<i class="ti ti-x"></i></button>
              <button type="submit" class="btn btn-primary font-medium btnKonfirmasiUpdateBarang1"><i class="ti ti-check"></i>&emsp;Perbarui</button>
          </div>
        </form>
      </div>
    </div>
</div>

{{-- SCRIPT --}}
<script>

    // TABEL & CARI
    $(document).ready(function () {
        var tabel_stok = $("#tabel_stok").DataTable({
            dom: 'lrtip',
            order: [
                [1,'DESC']
            ],
            autoWidth: false,
            language: {
                "sProcessing":   "Sedang memproses...",
                "sLengthMenu":   "Tampilkan _MENU_ entri",
                "sZeroRecords":  "Tidak ditemukan data yang sesuai",
                "loadingRecords": "Memuat data, mohon tunggu ...",
                "sInfo":         "Total : <b>_TOTAL_</b> entri",
                "sInfoEmpty":    "Menampilkan : <b>0</b> entri",
                "sInfoFiltered": "",
                "sInfoPostFix":  "",
                "sSearch":       "Cari : ",
                "sUrl":          "",
                "oPaginate": {
                    "sFirst":    "Pertama",
                    "sPrevious": "<i class='ti ti-chevron-left'></i>",
                    "sNext":     "<i class='ti ti-chevron-right'></i>",
                    "sLast":     "Terakhir"
                }
            },
            serverSide: true,
            ajax: {
                url: "{{ route('tabel_stok') }}",
                type: 'GET',
                data: function (d) {
                    d.stok = $('#cariStok').val();
                },
            },
            columns: [
                {
                    data: 'id',
                    orderable: true,
                    render: function(data, type, row, meta) {
                        return `${data}</b>`;
                    }
                },
                {
                    data: 'nama_barang',
                    render: function (data, type, row, meta) {
                        var nama_barang = row.nama_barang;
                        var harga_per_biji = row.harga_per_biji;
                        var harga_grosir = row.harga_grosir;
                        var stok = row.stok;
                        var kategori = row.kategori_barang;

                        if(kategori == 'satuan_tetap') {
                          var views = `
                              <div class="d-flex align-items-center">
                                  <div class="ms-3" style="margin-left: 0rem !important;">
                                  <h6 class="fw-semibold mb-0 fs-4">${trimText(nama_barang)}</h6>
                                  <p class="mb-0">${formatRupiah(harga_per_biji)} / ${formatRupiah(harga_grosir)}</p>
                                  <p class="mb-0 mt-1">[&emsp;<b>${stok}</b> Pcs&emsp;]</p>
                                  </div>
                              </div>
                          `;
                          
                        } else if(kategori == 'satuan_tidak_tetap') {
                          var views = `
                              <div class="d-flex align-items-center">
                                  <div class="ms-3" style="margin-left: 0rem !important;">
                                  <h6 class="fw-semibold mb-0 fs-4">${trimText(nama_barang)}</h6>
                                  <p class="mb-0">Barang Satuan Tidak Tetap</p>
                                  <p class="mb-0 mt-1">[&emsp;<b>?</b>&emsp;]</p>
                                  </div>
                              </div>
                          `;

                        } else {
                          var views = `Barang Tidak Valid !`;
                        }


                        return views;
                    }
                },
                {
                    data: 'updated_at',
                    orderable: true,
                    render: function(data, type, row, meta) {
                        var buttonList = `
                        <button type="button" class="btnEditStok d-inline-flex align-items-center justify-content-center btn btn-primary btn-circle btn-lg" data-id="${row.id}"  data-nama-barang="${row.nama_barang}" data-harga-per-biji="${row.harga_per_biji}" data-harga-grosir="${row.harga_grosir}" data-stok="${row.stok}" data-qty-grosir="${row.qty_grosir}" data-kategori-barang="${row.kategori_barang}" data-keterangan="${row.keterangan}">
                            <i class="ti ti-pencil"></i>
                        </button>
                        <button type="button" class="btnHapusStok d-inline-flex align-items-center justify-content-center btn btn-danger btn-circle btn-lg" data-id="${row.id}">
                            <i class="ti ti-trash"></i>
                        </button>
                        `;
                            
                        return buttonList;
                    }
                },
                {
                  data: 'kategori_barang',
                  visible: false
                }
        
            ],
            drawCallback: function(settings) {
                // Fungsi yang akan dijalankan setelah tabel selesai di-draw
                animasiProgressBar_stop();
            }
        });

        // PENCARIAN
        let cariNamaBarang = null;
        $('#cariNamaBarang').on('input', function() {
            clearTimeout(cariNamaBarang);
            cariNamaBarang = setTimeout( function() {
              animasiProgressBar_run();
              tabel_stok.column(1).search($('#cariNamaBarang').val()).draw();
            }, 500);
        });
          
        $('#cariStok').on('change', function() {
          animasiProgressBar_run();
          tabel_stok.draw();
        });
        $('#cariKategoriBarang').on('change', function() {
          animasiProgressBar_run();
          tabel_stok.column(3).search($('#cariKategoriBarang').val()).draw();
        });

        function trimText(text) {
            const maxLength = 20; // Jumlah huruf maksimal
            if (text.length > maxLength) {
                return text.substring(0, maxLength) + '..'; // Mengganti dengan teks yang diakhiri elipsis
            }
            return text;
        } 
        function formatRupiah(angka) {
              angka = Math.floor(angka); // Menghilangkan angka desimal
              const reverse = angka.toString().split('').reverse().join('');
              let ribuan = reverse.match(/\d{1,3}/g);
              ribuan = ribuan.join('.').split('').reverse().join('');
              return 'Rp ' + ribuan;
        }

        $('.btnRefreshData').on('click', function() {
            animasiProgressBar_run();
            tabel_stok.draw();
            var btnDef = $(this).html();

            // Menonaktifkan tombol selama 2 detik
            $(this).attr('disabled', true);
            $(this).html('Memproses ..');

            // Mengaktifkan tombol setelah 2 detik
            setTimeout(function() {
                $('.btnRefreshData').attr('disabled', false);
                $('.btnRefreshData').html(btnDef);
            }, 1000);
        });

    });

    // TAMBAH
    $('#FormTambahBarang').on('submit', function(event) {
        event.preventDefault();

        if(confirm("Tambah barang baru ?")) {
              var data = $(this).serialize();
              var btnValue = $('.btnKonfirmasiTambahBarang').html();
              $('.btnKonfirmasiTambahBarang').html('Memproses ..');
              $('.btnKonfirmasiTambahBarang').attr('disabled',true);
               
              $.ajax({
                type: "POST",
                url: "{{ route('tambah_barang_baru') }}",
                data: data,
                dataType: "JSON",
                success: function (response) {
                  if(response.kode == 200) {
                    // kosongkan form
                    $('#FormTambahBarang')[0].reset();
                    $('#DataBarangDynamic').html('');
                    $('.btnKonfirmasiTambahBarang').attr('disabled',true);
                    $('.btnKonfirmasiTambahBarang').html('Silahkan Pilih Kategori..');
                    // toast
                    toastSuccess(response.pesan);
                    // draw
                    $("#tabel_stok").DataTable().draw();

                  } else if(response.kode == 422) {

                    errorHandlerToast(response.pesan);
                    $('.btnKonfirmasiTambahBarang').html(btnValue);
                    $('.btnKonfirmasiTambahBarang').attr('disabled',false);

                  }
                }, error: function (error) {

                  toastError("Oops! Terjadi kesalahan.");
                  $('.btnKonfirmasiTambahBarang').html(btnValue);
                  $('.btnKonfirmasiTambahBarang').attr('disabled',false);
                
                }

              });
        } else {
          return;
        }
    });
    $(document).on('click','.btnBatalTambahBarang', function() {
      $('#FormTambahBarang')[0].reset();
      $('#DataBarangDynamic').html('');
      $('.btnKonfirmasiTambahBarang').attr('disabled',true);
      $('.btnKonfirmasiTambahBarang').html('Silahkan Pilih Kategori..');
    });

    // EDIT & UPDATE
    $(document).on('click','.btnEditStok', function() {
      var id = $(this).attr('data-id');
      var namaBarang = $(this).attr('data-nama-barang');
      var hargaPerBiji = $(this).attr('data-harga-per-biji');
      var hargaGrosir = $(this).attr('data-harga-grosir');
      var stok = $(this).attr('data-stok');
      var qtyGrosir = $(this).attr('data-qty-grosir');
      var keterangan = ($(this).attr('data-keterangan') !== 'null') ? $(this).attr('data-keterangan') : '';
      var kategori_barang = $(this).attr('data-kategori-barang');

      
      if(kategori_barang === 'satuan_tetap') {
        $('#updateId').val(id);
        $('#updateTitleNamaBarang').html(namaBarang);
        $('#updateNamaBarang').val(namaBarang);
        $('#updateHargaPerBiji').val(hargaPerBiji);
        $('#updateHargaGrosir').val(hargaGrosir);
        $('#updateStok').val(stok);
        $('#updateQtyGrosir').val(qtyGrosir);
        $('#updateKeterangan').val(keterangan);
        // modal
        $('#ModalUpdateBarang').modal('show');
      } else if(kategori_barang === 'satuan_tidak_tetap') {
        // 
        $('#FormUpdateBarang1')[0].reset();
        $('.DynamicInputan').html('');
        // 
        $('#updateId1').val(id);
        $('#updateTitleNamaBarang1').html(namaBarang);
        $('#updateNamaBarang1').val(namaBarang);
        // 
        animasiProgressBar_run();
        // 
        $('.btnEditStok').attr('disabled',true);
        // ambil data satuan
        $.ajax({
          type: "GET",
          url: "{{ route('list_satuan_tidak_tetap') }}",
          data: {
            id: id,
          },
          dataType: "JSON",
          success: function (response) {
            
            if(response.kode == 200) {

              $('.DynamicInputan').append(
                `
                <div class="row">
                    <div class="col-4" style="margin-top: 10px;">
                      <label for=""><b>Satuan</b></label>
                    </div>
                    <div class="col-8" style="margin-top: 10px;">
                      <label for=""><b>Harga Per-Satuan</b></label>
                    </div>
                </div>
                `
              );
              response.list_satuan.forEach(function (item) {
                hitungan ++;
                $('.DynamicInputan').append(
                    `
                    <div class="row" id="DataSatuanDynamic${hitungan}">
                        <div class="col-4">
                            <input type="text" class="form-control custom-d capitalEachWord" name="dynamicUpdateInput[${hitungan}][UpdateSatuanDynamic1]" id="" value="${item.satuan}" placeholder="Kg, Gram, Pack, dll" required>
                            <input type="text" class="form-control" name="dynamicUpdateInput[${hitungan}][UpdateSatuanId1]" id="" value="${item.id}" placeholder="ID.." required hidden>
                        </div>
                        <div class="col-6">
                            <input type="number" class="form-control custom-d terbilang" name="dynamicUpdateInput[${hitungan}][UpdateHargaSatuanDynamic1]" id="dynamicUrutan${hitungan}" value="${item.harga}" placeholder="Rp ( 0 - 99999999 )" required>
                        </div>
                        <div class="col-2">
                            <button type="button" class="btn btn-danger btnHapusDataSatuan1" data-id="DataSatuanDynamic${hitungan}" data-id-stok="${item.id}" style="margin-top:11px; float:right;"><i class="ti ti-trash"></i></button>
                        </div>
                    </div>
                    `
                );
              });

              // show modal
              $('#ModalUpdateBarang1').modal('show');

            } else if(response.kode == 201) {
              toastError(response.pesan);
               // show modal
               $('#ModalUpdateBarang1').modal('show');
            }
            
          }, error: function (error) {
            
            toastError("Oops! Silahkan coba lagi.");

          }, complete: function () {
            $('.btnEditStok').attr('disabled',false);
            animasiProgressBar_stop();
          }
          
        });
        
        
      } else {

      }

    });

    // BARANG SATUAN TETAP
    $('#FormUpdateBarang').on('submit', function(event) {
        event.preventDefault();

        if(confirm("Perbarui data barang ini ?")) {
              var data = $(this).serialize();
              var btnValue = $('.btnKonfirmasiUpdateBarang').html();
              $('.btnKonfirmasiUpdateBarang').html('Memproses ..');
              $('.btnKonfirmasiUpdateBarang').attr('disabled',true);
               
              $.ajax({
                type: "POST",
                url: "{{ route('update_barang') }}",
                data: data,
                dataType: "JSON",
                success: function (response) {
                  if(response.kode == 200) {
                    // toast
                    toastSuccess(response.pesan);
                    // draw
                    $("#tabel_stok").DataTable().draw();
                    
                  } else if(response.kode == 500) {
                    toastError(response.pesan);

                  } else if(response.kode == 422) {

                    errorHandlerToast(response.pesan);

                  }
                }, error: function (error) {

                  toastError("Oops! Terjadi kesalahan.");
                
                }, complete: function () {
                  $('.btnKonfirmasiUpdateBarang').html(btnValue);
                  $('.btnKonfirmasiUpdateBarang').attr('disabled',false);
                }
              });
        } else {
          return;
        }
    });
    $(document).on('input','#updateNamaBarang', function() {
        var valueName = $(this).val();
        $('#updateTitleNamaBarang').html(valueName);
    });

    // BARANG SATUAN TIDAK TETAP
    $(document).on('click','.btnTambahListSatuanTidakTetap', function() {
        hitungan ++;
        $('.DynamicInputan').append(
          `
          <div class="row" id="DataSatuanDynamic${hitungan}">
              <div class="col-4">
                  <input type="text" class="form-control custom-d capitalEachWord" name="dynamicUpdateInput[${hitungan}][UpdateSatuanDynamic1]" id="" value="" placeholder="Kg, Gram, Pack, dll" required>
                  <input type="text" class="form-control" name="dynamicUpdateInput[${hitungan}][UpdateSatuanId1]" id="" value="" placeholder="ID.." hidden>
              </div>
              <div class="col-6">
                  <input type="number" class="form-control custom-d terbilang" name="dynamicUpdateInput[${hitungan}][UpdateHargaSatuanDynamic1]" id="dynamicUrutan${hitungan}" value="" placeholder="Rp ( 0 - 99999999 )" required>
              </div>
              <div class="col-2">
                  <button type="button" class="btn btn-danger btnHapusDataSatuan1" data-id="DataSatuanDynamic${hitungan}" data-id-stok="" style="margin-top:11px; float:right;"><i class="ti ti-trash"></i></button>
              </div>
          </div>
          `
        );
    });
    $(document).on('click','.btnHapusDataSatuan1', function () { 
        var id_stok = $(this).attr('data-id-stok');
        var id_inputan = $(this).attr('data-id');
        if(id_stok === '') {
          $('#'+id_inputan).remove();
          return;
        }

        if(confirm("Hapus data satuan? data yang sudah dihapus tidak bisa dikembalikan.")) {

          $('.btnHapusDataSatuan1').attr('disabled',true);

          $.ajax({
            type: "DELETE",
            url: "{{ route('hapus_data_satuan_list') }}",
            data: {
              _token: "{{ csrf_token() }}",
              id: id_stok,
            },
            dataType: "JSON",
            success: function (response) {
              if(response.kode == 200) {
                $('#'+id_inputan).remove();
              } else if(response.kode == 400) {
                toastError(response.pesan);
              }
            }, error: function (error) {
                toastError("Oops! Silahkan coba lagi.");
            }, complete: function () {
              $('.btnHapusDataSatuan1').attr('disabled',false);
            }

          });

        } else {
          return;
        }

    });
    $('#FormUpdateBarang1').on('submit', function(event) {
        event.preventDefault(event);
        if(confirm("Perbarui data barang ini? pastikan data sudah benar.")) {
              var data = $(this).serialize();
              var btnValue = $('.btnKonfirmasiUpdateBarang1').html();
              $('.btnKonfirmasiUpdateBarang1').html('Memproses ..');
              $('.btnKonfirmasiUpdateBarang1').attr('disabled',true);
               
              $.ajax({
                type: "POST",
                url: "{{ route('update_barang1') }}",
                data: data,
                dataType: "JSON",
                success: function (response) {
                  if(response.kode == 200) {
                    // toast
                    toastSuccess(response.pesan);
                    // draw
                    $("#tabel_stok").DataTable().draw();
                    // hidden
                    $('#ModalUpdateBarang1').modal('hide');
                    
                  } else if(response.kode == 500) {
                    toastError(response.pesan);

                  } else if(response.kode == 422) {

                    errorHandlerToast(response.pesan);

                  }
                }, error: function (error) {

                  toastError("Oops! Terjadi kesalahan.");
                
                }, complete: function () {
                  $('.btnKonfirmasiUpdateBarang1').html(btnValue);
                  $('.btnKonfirmasiUpdateBarang1').attr('disabled',false);
                }
              });
        } else {
          return;
        }
    });
    $(document).on('click','.btnTutupModalUpdateBarang1', function() {
        $('#FormUpdateBarang1')[0].reset();
        $('.DynamicInputan').html('');
    });
    $(document).on('input','#updateNamaBarang1', function() {
        var valueName = $(this).val();
        $('#updateTitleNamaBarang1').html(valueName);
    });

    // HAPUS
    $(document).on('click','.btnHapusStok', function() {
        var id = $(this).attr('data-id');
        if(confirm("Apakah anda yakin akan menghapus data ini ?")) {
          if(confirm("Data yang sudah dihapus tidak bisa dikembalikan, Lanjutkan ?")) {

            // 
            var btnValue = $(this).html();
            $('.btnHapusStok').html('<i class="ti ti-loader-2"></i>');
            $('.btnHapusStok').attr('disabled',true); 
            // 
            $.ajax({
              type: "DELETE",
              url: "{{ route('hapus_data_barang') }}",
              data: {
                _token: "{{ csrf_token() }}",
                id: id,
              },
              dataType: "JSON",
              success: function (response) {
                
                $("#tabel_stok").DataTable().draw();
                toastError(response.pesan);
                
              }, error: function (error) {
                
                toastError("Oops! Silahkan coba lagi.");
              
              }, complete: function () {
                $('.btnHapusStok').html(btnValue);
                $('.btnHapusStok').attr('disabled',false);
              }

            });

          } else {
            return;
          }
        } else {
          return;
        }
    });

    // TERBILANG
    $(document).on('click','.terbilang', function() {
        var attribute = $(this).attr('id');
        var angka = $('#'+attribute).val();
        // kondisi jika kosong / kurang dari 1
        if(angka === '' || angka < 1) {
          return;
        }
        // jika terpenuhi
        var hasil = angkaTerbilang(angka);
        toastSuccess(hasil);

    });

    // KATEGORI EVENT
    var BarangSatuanTetap = 
    `
      <div class="col-12" style="margin-top:10px;">
        <div class="alert customize-alert alert-dismissible text-primary border border-primary fade show remove-close-icon" role="alert">
          <div class="d-flex align-items-center font-medium me-3 me-md-0">
            <i class="ti ti-info-circle fs-5 me-2 flex-shrink-0 text-primary"></i>
            Satuan Tetap : barang bisa dijual 'Eceran' & 'Grosir', contoh sabun, bolpoin, dll
          </div>
        </div>
      </div>
      <label for=""><b>Harga Per-Barang ( Eceran )</b></label>
      <input type="number" id="tbhHargaPerBiji" name="tbhHargaPerBiji" class="form-control terbilang" placeholder="Rp ( 0 - 999999 )" required>
      <label for=""><b>Harga Grosir</b></label>
      <input type="number" id="tbhHargaGrosir" name="tbhHargaGrosir" class="form-control terbilang" placeholder="Rp ( 0 - 999999 )" required>
      <label for=""><b>1 Grosir = Berapa Barang ?</b></label>
      <input type="number" id="tbhQtyGrosir" name="tbhQtyGrosir" class="form-control" placeholder="0 - 999999" required>
      <label for=""><b>Jumlah Stok ( Dihitung Pcs )</b></label>
      <input type="number" id="tbhStok" name="tbhStok" class="form-control" placeholder="0 - 999999">
      <label for=""><b>Keterangan</b></label>
      <textarea name="tbhKeterangan" id="tbhKeterangan" class="form-control" cols="30" rows="3" placeholder="Isi keterangan jika diperlukan .."></textarea>
    `;
    var BarangSatuanTidakTetap = 
    `
      <div class="col-12" style="margin-top:10px;">
        <div class="alert customize-alert alert-dismissible text-primary border border-primary fade show remove-close-icon" role="alert">
          <div class="d-flex align-items-center font-medium me-3 me-md-0">
            <i class="ti ti-info-circle fs-5 me-2 flex-shrink-0 text-primary"></i>
            Satuan Tidak Tetap : pembelian barang biasanya di timbang terlebih dahulu contoh beras, gula, telur dll
          </div>
        </div>
      </div>
      <div class="row">
          <div class="col-4">
            <label for=""><b>Satuan</b></label>
            <input type="text" class="form-control custom-d capitalEachWord" name="dynamicTbhInput[0][tbhSatuanDynamic]" id="" placeholder="Kg, Gram, Pack, dll" required>
          </div>
          <div class="col-6">
            <label for=""><b>Harga Per-Satuan</b></label>
            <input type="number" class="form-control custom-d terbilang" name="dynamicTbhInput[0][tbhHargaSatuanDynamic]" id="dynamicUrutan0" placeholder="Rp ( 0 - 99999999 )" required>
          </div>
          <div class="col-2">
            <button type="button" class="btn btn-primary btnTambahDataSatuan" style="margin-top:31px; float:right;"><i class="ti ti-plus"></i></button>
          </div>
      </div>
      <div class="DynamicInputan">
        
      </div>
    `;
    $(document).on('change','#tbhKategoriBarang', function() {
        
      var value = $(this).val();
      var dynamicForm = $('#DataBarangDynamic');
      var btnSubmit = $('.btnKonfirmasiTambahBarang');
      var btnValueDefault = '<i class="ti ti-check"></i>&emsp;Konfirmasi';

      if(value === 'satuan_tetap') {
        dynamicForm.html(BarangSatuanTetap);
        btnSubmit.attr('disabled',false);
        btnSubmit.html(btnValueDefault);
      } else if(value === 'satuan_tidak_tetap') {
        dynamicForm.html(BarangSatuanTidakTetap);
        btnSubmit.attr('disabled',false);
        btnSubmit.html(btnValueDefault);
      } else {
        dynamicForm.html('');
        btnSubmit.attr('disabled',true);
        btnSubmit.html('Silahkan Pilih Kategori..');
      }

    });

    // DYNAMIC INPUTAN
    let hitungan = 1;
    $(document).on('click','.btnTambahDataSatuan', function() {
      
        hitungan ++;

        $('.DynamicInputan').append(
          `
            <div class="row" id="DataSatuanDynamic${hitungan}">
              <div class="col-4">
                <input type="text" class="form-control custom-d capitalEachWord" name="dynamicTbhInput[${hitungan}][tbhSatuanDynamic]" id="" placeholder="Kg, Gram, Pack, dll" required>
              </div>
              <div class="col-6">
                <input type="number" class="form-control custom-d terbilang" name="dynamicTbhInput[${hitungan}][tbhHargaSatuanDynamic]" id="dynamicUrutan${hitungan}" placeholder="Rp ( 0 - 99999999 )" required>
              </div>
              <div class="col-2">
                <button type="button" class="btn btn-danger btnHapusDataSatuan" data-id="DataSatuanDynamic${hitungan}" style="margin-top:11px; float:right;"><i class="ti ti-trash"></i></button>
              </div>
            </div>
          `
        );
    });
    $(document).on('click','.btnHapusDataSatuan', function () { 
        var id_inputan = $(this).attr('data-id');
        $('#'+id_inputan).remove(); 
    });

    $(document).on('input', '.capitalEachWord', function() {
        var value = $(this).val();
        var convertedText = capitalizeEachWord(value);
    
        $(this).val(convertedText);
    });
    // Fungsi untuk mengonversi teks menjadi huruf kapital di awal setiap kata
    function capitalizeEachWord(text) {
        return text.toLowerCase().replace(/(?:^|\s)\S/g, function(char) {
            return char.toUpperCase();
        });
    }

    // PROGRESSBAR
    function animasiProgressBar_run() {
        $('.animasiProgressBar').css('width', '100%');
    }
    function animasiProgressBar_stop() {
        $('.animasiProgressBar').css('width', '0%');
    }

    function angkaTerbilang(nilai) {
        // deklarasi variabel nilai sebagai angka matemarika
        // Objek Math bertujuan agar kita bisa melakukan tugas matemarika dengan javascript
        nilai = Math.floor(Math.abs(nilai));
        
        // deklarasi nama angka dalam bahasa indonesia
        var huruf = [ '', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas', ];
        
        // menyimpan nilai default untuk pembagian
        var bagi = 0;
        // deklarasi variabel penyimpanan untuk menyimpan proses rumus 
        var penyimpanan = '';
        
        // rumus 
        if (nilai < 12) {
          penyimpanan = ' ' + huruf[nilai];
        } else if (nilai < 20) {
          penyimpanan = angkaTerbilang(Math.floor(nilai - 10)) + ' Belas';
        } else if (nilai < 100) {
          bagi = Math.floor(nilai / 10);
          penyimpanan = angkaTerbilang(bagi) + ' Puluh' + angkaTerbilang(nilai % 10);
        } else if (nilai < 200) {
          penyimpanan = ' Seratus' + angkaTerbilang(nilai - 100);
        } else if (nilai < 1000) {
          bagi = Math.floor(nilai / 100);
          penyimpanan = angkaTerbilang(bagi) + ' Ratus' + angkaTerbilang(nilai % 100);
        } else if (nilai < 2000) {
          penyimpanan = ' Seribu' + angkaTerbilang(nilai - 1000);
        } else if (nilai < 1000000) {
          bagi = Math.floor(nilai / 1000);
          penyimpanan = angkaTerbilang(bagi) + ' Ribu' + angkaTerbilang(nilai % 1000);
        } else if (nilai < 1000000000) {
          bagi = Math.floor(nilai / 1000000);
          penyimpanan = angkaTerbilang(bagi) + ' Juta' + angkaTerbilang(nilai % 1000000);
        } else if (nilai < 1000000000000) {
          bagi = Math.floor(nilai / 1000000000);
          penyimpanan = angkaTerbilang(bagi) + ' Miliar' + angkaTerbilang(nilai % 1000000000);
        } else if (nilai < 1000000000000000) {
          bagi = Math.floor(nilai / 1000000000000);
          penyimpanan = angkaTerbilang(nilai / 1000000000000) + ' Triliun' + angkaTerbilang(nilai % 1000000000000);
        } else {
          penyimpanan = 'Nominal Angka Terlalu Banyak !';
        }
      
        // mengambalikan nilai yang ada dalam variabel penyimpanan
        return penyimpanan;

    }

</script>

@endsection