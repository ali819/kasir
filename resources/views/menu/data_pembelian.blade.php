@extends('layouts.main')
@section('content')
@section('title', 'Data Pembelian')


{{-- MAIN --}}
<div class="container-fluid">
    <!-- --------------------------------------------------- -->
    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
      <div class="card-body px-4 py-3">
        <div class="row align-items-center">
          <div class="col-9">
            <h4 class="fw-semibold mb-8">Data Pembelian</h4>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a class="text-muted" href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">Data Pembelian</li>
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
              Pada menu ini menampilkan semua detail pembelian
            </div>
          </div>
        </div>
        
        <div class="col-12">
            <br>
        </div>
        <div class="col-4">
            <h5 class="card-title fw-semibold mb-0 lh-sm" style="color: rgb(48, 48, 48)">Pencarian</h5>
        </div>
        <div class="col-8" align="right">
            <button type="button" class="btn btn-outline-danger btnHapusTransaksiDipilih"><i class="ti ti-trash"></i>&emsp;Hapus Data Dipilih</button>
        </div>
    </div>
    <div class="w-100 position-relative overflow-hidden">
      <div class="py-3 border-bottom">

        <div class="row">
          <div class="col-md-6">  
            <div class="mb-1">
              <input type="text" class="form-control" id="cariIdTransaksi" name="cariIdTransaksi" placeholder="ID transaksi .." autocomplete="off">
            </div>
        </div>
        <div class="col-md-6">  
            <div class="mb-3">
                <input type="number" class="form-control" id="cariTotalBelanja" name="cariTotalBelanja" placeholder="Total belanja .." autocomplete="off">
            </div>
        </div>
        <div class="col-12">  
            <div class="mb-3">
                <input type="date" class="form-control" id="cariTanggalBeli" name="cariTanggalBeli" placeholder="Tanggal .." autocomplete="off">
            </div>
          </div>
          <div class="col-12">
            <div class="progress">
              <div class="progress-bar progress-bar-striped bg-primary progress-bar-animated animasiProgressBar" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
            </div>
          </div>
        </div>

      </div>

      <div class="card-body">
        <div class="table-responsive rounded-2 mb-4">
          <br>
          <table class="table border text-nowrap customize-table mb-0 align-middle" id="tabel_data_pembelian">
            <thead class="text-dark fs-4">
              <tr>
                <th><h6 class="fs-4 fw- mb-0">#</h6></th>
                <th><h6 class="fs-4 fw- mb-0">Detail&nbsp;Pembelian</h6></th>
                <th><h6 class="fs-4 fw- mb-0">Pilihan</h6></th>
              </tr>
            </thead>
          </table>
          <div class="d-flex align-items-center justify-content-end py-1">
            <br>
          </div>
        </div>
        <div class="row" id="html_print">

        </div>
      </div>
    </div>
    <!-- --------------------------------------------------- -->
</div>

{{-- MODAL DATA PEMBELIAN --}}
<div class="modal fade" id="ModalDataPembelian" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header d-flex align-items-center">
          <h4 class="modal-title" id="">
            <span id="pembelianIdTransaksi">ID Transaksi ?</span>
          </h4>
        </div>
        <form id="FormUpdatePembelianBarang" autocomplete="off">
          @csrf
          <div class="modal-body">
            <div class="card-body">
              <!--/row-->
              <div class="col-12">
                <div class="alert customize-alert alert-dismissible text-primary border border-primary fade show remove-close-icon" role="alert">
                    <div class="d-flex align-items-center font-medium me-3 me-md-0">
                      <i class="ti ti-info-circle fs-5 me-2 flex-shrink-0 text-primary"></i>
                      Detail transaksi pembelian
                    </div>
                  </div>
                {{-- <hr> --}}
              </div>
              <div class="row">
                <div class="col-4">
                    <label class=""><b>Tanggal</b></label>
                    <hr>
                </div>
                <div class="col-8">
                    <label class="detailTanggalPembelian">yyy-mm-dd hh:mm:ss</label>
                    <hr>
                </div>
                <div class="col-12">
                    <label class=""><b>List Barang</b></label>
                    <br>
                </div>
                <div class="col-12" id="formDetailListPembelian">
                      
                </div>
                <div class="col-4">
                  
                  <label class=""><b>Total</b></label>
                  <hr>
                  <label class=""><b>Bayar</b></label>
                  <br>
                  <label class=""><b>Kembalian</b></label>
                  <hr>
                </div>
                <div class="col-8">
                    
                    <label class="detailTotalBelanja">Rp 0</label>
                    <hr>
                    <label class="detailTotalBayar">Rp 0</label>
                    <br>
                    <label class="detailKembalian">Rp 0</label>
                    <hr>
                </div>
                <!--/span-->
              </div>
              <!--/row-->
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup&emsp;<i class="ti ti-x"></i></button>
          </div>
        </form>
      </div>
    </div>
</div>


<script>

    // TABEL & CARI
    $(document).ready(function () {
        var tabel_data_pembelian = $("#tabel_data_pembelian").DataTable({
            dom: 'lrtip',
            order: [
                [0,'DESC']
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
                url: "{{ route('tabel_data_pembelian') }}",
                type: 'GET',
            },
            columns: [
                {
                    data: 'id',
                    className: 'clickableCell',
                    orderable: true,
                    render: function(data, type, row, meta) {
                        return `<input type="checkbox" class="dataIdPembelianBarang" data-id="${data}" data-id-transaksi="${row.id_transaksi}">`;
                    }
                },
                {
                    data: 'id_transaksi',
                    render: function (data, type, row, meta) {
                        var id_transaksi = row.id_transaksi;
                        var total_belanja = row.total_belanja;
                        var tanggal = row.formatted_date;

                        var views = `
                            <div class="d-flex align-items-center">
                                <div class="ms-3" style="margin-left: 0rem !important;">
                                <h6 class="fw-semibold mb-0 fs-4">${trimText(id_transaksi)}</h6>
                                <p class="mb-0">${tanggal}</p>
                                <p class="mb-0 mt-1">[&emsp;<b>${formatRupiah(total_belanja)}</b>&emsp;]</p>
                                </div>
                            </div>
                        `;

                        return views;
                    }
                },
                {
                    data: 'id',
                    orderable: false,
                    render: function(data, type, row, meta) {
                        var buttonList = `
                        <button type="button" class="btnEditDataPembelian d-inline-flex align-items-center justify-content-center btn btn-primary btn-circle btn-lg" data-id="${row.id}" data-id-transaksi="${row.id_transaksi}">
                            <i class="ti ti-eye"></i>
                        </button>
                        <button type="button" class="btnPrintDataPembelian d-inline-flex align-items-center justify-content-center btn btn-info btn-circle btn-lg" data-id="${row.id}" data-id-transaksi="${row.id_transaksi}">
                            <i class="ti ti-receipt"></i>
                        </button>
                        `;
                            
                        return buttonList;
                    }
                },
                {
                  data: 'created_at',
                  visible: false
                },
                {
                  data: 'total_belanja',
                  visible: false
                }
        
            ],
            drawCallback: function(settings) {
                // Fungsi yang akan dijalankan setelah tabel selesai di-draw
                animasiProgressBar_stop();
            }
        });

        // PENCARIAN
        let cariIdTransaksi = null;
        $('#cariIdTransaksi').on('input', function() {
            var values = $(this).val();
            $('#cariIdTransaksi').val(values.toUpperCase())
            clearTimeout(cariIdTransaksi);
            cariIdTransaksi = setTimeout( function() {
              animasiProgressBar_run();
              tabel_data_pembelian.column(1).search($('#cariIdTransaksi').val()).draw();
            }, 500);
        });
        let cariTotalBelanja = null;
        $('#cariTotalBelanja').on('input', function() {
            clearTimeout(cariTotalBelanja);
            cariTotalBelanja = setTimeout( function() {
              animasiProgressBar_run();
              tabel_data_pembelian.column(4).search($('#cariTotalBelanja').val()).draw();
            }, 500);
        });
        $('#cariTanggalBeli').on('change', function() {
          animasiProgressBar_run();
          tabel_data_pembelian.column(3).search($('#cariTanggalBeli').val()).draw();
        });

        $('#tabel_data_pembelian tbody').on('click', '.clickableCell', function (event) {
            // Check if the click occurred on a button or input checkbox
            if ($(event.target).is('button') || $(event.target).is('input[type="checkbox"]')) {
                return;
            }
            // Toggle the checkbox state
            var checkbox = $(this).find('.dataIdPembelianBarang');
            checkbox.prop('checked', !checkbox.prop('checked'));
        });

    });

    // LEMPAR KE MODAL
    $(document).on('click','.btnEditDataPembelian', function() {

        $('.btnEditDataPembelian').attr('disabled',true);
        var id_transaksi = $(this).attr('data-id-transaksi');
        animasiProgressBar_run();

        $.ajax({
            type: "GET",
            url: "{{ route('detail_data_pembelian') }}",
            data: {
                id_transaksi: id_transaksi,
            },
            dataType: "JSON",
            success: function (response) {
                if(response.kode == 404) {
                    toastError(response.pesan);
                    return;
                }
                var tanggal = response.tanggal;
                var total_belanja = formatRupiah(response.total_belanja);
                var total_bayar = formatRupiah(response.total_bayar);
                var kembalian = formatRupiah(response.kembalian);
                var list = response.list;

                $('#pembelianIdTransaksi').html(id_transaksi);
                $('.detailTanggalPembelian').html(tanggal);
                $('.detailTotalBelanja').html(total_belanja);
                $('.detailTotalBayar').html(total_bayar);
                $('.detailKembalian').html(kembalian);

                $('#formDetailListPembelian').html('');
                $.each(list, function (index, detail) {
                    index++;
                    $('#formDetailListPembelian').append(
                    `
                        <hr>
                        <label class="">( ${index} ). ${detail.nama_barang} ( ${detail.satuan} ) - ( ${detail.qty} x ${formatRupiah(detail.harga)} : ${formatRupiah(detail.total_harga)} )</label>
                    `);
                });
                $('#formDetailListPembelian').append('<hr>');

                // show modal
                $('#ModalDataPembelian').modal('show');

            }, error: function (error) {

                toastError("Oops! Terjadi kesalahan. Coba lagi!");

            }, complete: function () {
              animasiProgressBar_stop();
                $('.btnEditDataPembelian').attr('disabled',false);
            }
        });

    });

    // HAPUS DATA DIPILIH
    $(document).on('click','.btnHapusTransaksiDipilih', function() {

        var btnDef = $('.btnHapusTransaksiDipilih').html();
        var selectedIds = [];
        $('.dataIdPembelianBarang:checked').each(function() {
            selectedIds.push($(this).data('id-transaksi'));
        });
        console.log(selectedIds);

        if (selectedIds.length <= 0) {
            toastError("Tidak ada data dipilih!");
            return;
        }

        customConfirm("Hapus ("+selectedIds.length+") data ?","Data yang sudah dihapus tidak bisa dikembalikan.").then((confirmed) => { 
            if(confirmed) {

                $('.btnHapusTransaksiDipilih').attr('disabled',true);
                $('.btnHapusTransaksiDipilih').html('Memproses ..');

                $.ajax({
                    type: "DELETE",
                    url: "{{ route('hapus_data_pembelian') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        list_id_transaksi: selectedIds,
                    },
                    dataType: "JSON",
                    success: function (response) {
                        toastSuccess(response.pesan);
                        $("#tabel_data_pembelian").DataTable().draw();
                    }, error: function (error) {
                        toastError("Oops! Silahkan coba lagi!");
                    }, complete: function() {
                        $('.btnHapusTransaksiDipilih').attr('disabled',false);
                        $('.btnHapusTransaksiDipilih').html(btnDef);
                    }
                });
            }
        });
    });

    // PRINT NOTA PEMBELIAN
    $(document).on('click','.btnPrintDataPembelian', function() {
      // validasi
        var id_transaksi = $(this).attr('data-id-transaksi');
        var modePrinter = $('#ModePrinter').val();
        if(modePrinter === '') {
            return toastError("Mohon pilih mode device printer!");
        }
        if(id_transaksi === '') {
            return toastError("ID transaksi kosong. Silahkan coba lagi!");
        }

        // 
        $('.btnPrintDataPembelian').attr('disabled',true);
        animasiProgressBar_run();

        $.ajax({
          type: "GET",
          url: "{{ route('nota_pembelian_html') }}",
          data: {
            id_transaksi: id_transaksi,
          },
          dataType: "JSON",
          success: function (response) {
            
            if(response.kode == 404) {
              return toastError(response.pesan);
            }

            // cek jenis printer
            if(modePrinter == 'hp') {
              printNotaPembelian(response.nota_pembelian);

            } else if(modePrinter == 'pc') {
                var raw_data = response.raw_data;
                // Panggil fungsi untuk mencetak receipt dengan data dari server
                printReceiptRectaHost(
                    raw_data.list_data_belanja,
                    raw_data.id_transaksi,
                    raw_data.total_belanja,
                    raw_data.total_bayar,
                    raw_data.kembalian,
                    raw_data.timestamp,
                    response.pesan
                );
                
            } else {
                toastError("Mode printer tidak dipilih!");
            }

          }, error: function (error) {
            toastError("Oops! Silahkan coba lagi!");
          }, complete: function () {

            animasiProgressBar_stop();
            $('.btnPrintDataPembelian').attr('disabled',false);

          }
        });

    });

    // PROGRESSBAR
    function animasiProgressBar_run() {
        $('.animasiProgressBar').css('width', '100%');
    }
    function animasiProgressBar_stop() {
        $('.animasiProgressBar').css('width', '0%');
    }
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
</script>

@endsection