@extends('layouts.main')
@section('content')
@section('title', 'Stok & Harga')

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
            <button type="button" class="btn btn-primary col-12 btnTambahBarang" data-bs-toggle="modal" data-bs-target="#ModalTambahBarang" style="font-weight:bold"><i class="ti ti-pencil-plus"></i>&emsp;Tambahkan Barang</button>
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

{{-- MODAL TAMBAH BARNAG --}}
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
                  <label for=""><b>Harga Per-Barang ( 1 Barang )</b></label>
                  <input type="number" id="tbhHargaPerBiji" name="tbhHargaPerBiji" class="form-control terbilang" placeholder="Rp ( 0 - 999999 )" required>
                  <label for=""><b>Harga Grosir</b></label>
                  <input type="number" id="tbhHargaGrosir" name="tbhHargaGrosir" class="form-control terbilang" placeholder="Rp ( 0 - 999999 )" required>
                  <label for=""><b>1 Grosir = Berapa Barang ?</b></label>
                  <input type="number" id="tbhQtyGrosir" name="tbhQtyGrosir" class="form-control" placeholder="0 - 999999" required>
                  <label for=""><b>Jumlah Stok ( Dihitung Pcs )</b></label>
                  <input type="number" id="tbhStok" name="tbhStok" class="form-control" placeholder="0 - 999999">
                  <label for=""><b>Keterangan</b></label>
                  <textarea name="tbhKeterangan" id="tbhKeterangan" class="form-control" cols="30" rows="5" placeholder="Isi keterangan jika diperlukan .."></textarea>
                  {{--  --}}
                </div>
                <!--/span-->
              </div>
              <!--/row-->
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal&emsp;<i class="ti ti-x"></i></button>
              <button type="submit" class="btn btn-primary font-medium btnKonfirmasiTambahBarang"><i class="ti ti-check"></i>&emsp;Konfirmasi</button>
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
              <div class="row">
                <div class="col-md-12">
                  {{--  --}}
                  <input type="number" class="form-control" id="updateId" name="updateId" placeholder=".." required hidden>
                  <label for="" class=""><b>Nama Barang</b></label>
                  <input type="text" class="form-control" id="updateNamaBarang" name="updateNamaBarang" placeholder="Nama barang .." required>
                  <label for=""><b>Harga Per-Barang ( 1 Barang )</b> </label>
                  <input type="number" id="updateHargaPerBiji" name="updateHargaPerBiji" class="form-control terbilang" placeholder="Rp ( 0 - 999999 )" value="0" required>
                  <label for=""><b>Harga Grosir</b></label>
                  <input type="number" id="updateHargaGrosir" name="updateHargaGrosir" class="form-control terbilang" placeholder="Rp ( 0 - 999999 )" value="0" required>
                  <label for=""><b>1 Grosir = Berapa Barang ?</b></label>
                  <input type="number" id="updateQtyGrosir" name="updateQtyGrosir" class="form-control" placeholder="0 - 999999" required>
                  <label for=""><b>Jumlah Stok ( Dihitung Pcs )</b></label>
                  <input type="number" id="updateStok" name="updateStok" class="form-control" placeholder="0 - 999999">
                  <label for=""><b>Keterangan</b></label>
                  <textarea name="updateKeterangan" id="updateKeterangan" class="form-control" cols="30" rows="5" placeholder="Isi keterangan jika diperlukan .."></textarea>
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

                        var views = `
                            <div class="d-flex align-items-center">
                                <div class="ms-3" style="margin-left: 0rem !important;">
                                <h6 class="fw-semibold mb-0 fs-4">${trimText(nama_barang)}</h6>
                                <p class="mb-0">${formatRupiah(harga_per_biji)} / ${formatRupiah(harga_grosir)}</p>
                                <p class="mb-0">[&emsp;<b>${stok}</b> Pcs&emsp;]</p>
                                </div>
                            </div>
                        `;

                        return views;
                    }
                },
                {
                    data: 'created_at',
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
                    // toast
                    toastSuccess(response.pesan);
                    // draw
                    $("#tabel_stok").DataTable().draw();

                  } else if(response.kode == 422) {

                    errorHandlerToast(response.pesan);

                  }
                }, error: function (error) {

                  toastError("Oops! Terjadi kesalahan.");
                
                }, complete: function () {
                  $('.btnKonfirmasiTambahBarang').html(btnValue);
                  $('.btnKonfirmasiTambahBarang').attr('disabled',false);
                }
              });
        } else {
          return;
        }
    });

    // EDIT & UPDATE
    $(document).on('click','.btnEditStok', function() {
        $('#updateId').val($(this).attr('data-id'));
        $('#updateTitleNamaBarang').html($(this).attr('data-nama-barang'));
        $('#updateNamaBarang').val($(this).attr('data-nama-barang'));
        $('#updateHargaPerBiji').val($(this).attr('data-harga-per-biji'));
        $('#updateHargaGrosir').val($(this).attr('data-harga-grosir'));
        $('#updateStok').val($(this).attr('data-stok'));
        $('#updateQtyGrosir').val($(this).attr('data-qty-grosir'));
        if ($(this).attr('data-keterangan') !== 'null') {
            $('#updateKeterangan').val($(this).attr('data-keterangan'));
        } else {
          $('#updateKeterangan').val('');
        }
        $('#ModalUpdateBarang').modal('show');
    });
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