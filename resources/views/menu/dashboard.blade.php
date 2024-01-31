@extends('layouts.main')
@section('content')
@section('title', 'Dashboard')

<style>
  .customs-top {
    margin-top: 5px;
  }
</style>

{{-- MAIN --}}
<div class="container-fluid">
    <div class="row">
      <div class="col-lg-12 d-flex align-items-strech">
        <div class="card w-100">
          <div class="card-body">
            <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
              <div class="mb-3 mb-sm-0">
                <h3 class=" fw-semibold">Data Penjualan</h3>
                <p class="card-subtitle mb-0">Grafik data minggu terakhir ( 6 hari terakhir )</p>
              </div>
              <div>
                {{--  --}}
                <select id="ChartShow" class="form-control">
                  <option value="bar">Tampilan Grafik Omzet</option>
                  <option value="pie">Tampilan Grafik Terlaris</option>
                </select>
              </div>
            </div>
            <div class="row align-items-center">
              <div class="col-lg-8 col-md-8">
                {{--  --}}
                <canvas id="myBarChart" style="display: block; margin: auto; width:100%;max-width:800px"></canvas>
                <canvas id="myPieChart" style="display: block; margin: auto; width:100%;max-width:400px" hidden></canvas>
                {{--  --}}
              </div>
              <div class="col-lg-4 col-md-4">
                <div class="d-flex align-items-center mb-4 pb-1">
                  <div class="p-8 bg-light-primary rounded-1 me-3 d-flex align-items-center justify-content-center">
                    <i class="ti ti-grid-dots text-primary fs-6"></i>
                  </div>
                  <div>
                    <h4 class="mb-0 fs-7 fw-semibold">{{ $totalPenjualan }}</h4>
                    <p class="fs-3 mb-0">Omzet ( 6 hari terakhir )</p>
                  </div>
                </div>
                <div>
                  <div class="d-flex align-items-baseline mb-4">
                    <span class="round-8 bg-primary rounded-circle me-6"></span>
                    <div>
                      <p class="fs-3 mb-1">Transaksi</p>
                      <h6 class="fs-5 fw-semibold mb-0">{{ $totalTransaksi }}</h6>
                    </div>
                  </div>
                  <div class="d-flex align-items-baseline mb-4 pb-1">
                    <span class="round-8 bg-secondary rounded-circle me-6"></span>
                    <div>
                      <p class="fs-3 mb-1">Barang Terjual</p>
                      <h6 class="fs-5 fw-semibold mb-0">{{ $totalBarangTerjual }}</h6>
                    </div>
                  </div>
                  <div>
                    <button type="button" class="btn btn-primary w-100" id="btnShowAll">LIHAT SEMUA&emsp;<i class="ti ti-arrow-bar-to-right"></i></button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

{{-- MODAL --}}
<div class="modal fade" id="ModalDetailPenjualan" data-bs-backdrop="dynamic" data-bs-keyboard="false" tabindex="-1" aria-labelledby="" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header d-flex align-items-center">
        <h4 class="modal-title" id="">
          Detail Penjualan
        </h4>
      </div>
      <div class="modal-body">
        <div class="card-body">
          <!--/row-->
          <div class="col-12">
            <div class="alert customize-alert alert-dismissible text-primary border border-primary fade show remove-close-icon" role="alert">
              <div class="d-flex align-items-center font-medium me-3 me-md-0">
                <i class="ti ti-info-circle fs-5 me-2 flex-shrink-0 text-primary"></i>
                Menampilkan semua data penjualan
              </div>
            </div>
          </div>
          <div class="row">
            {{--  --}}
            <div class="col-md-12">
              <div class="border-top">
                <div class="row gx-0">
                  <div class="col-md-4 border-end">
                    <div class="p-4 py-3 py-md-4">
                      <p class="fs-4 text-danger mb-0">
                        <span class="text-danger">
                          <span class="round-8 bg-danger rounded-circle d-inline-block me-1"></span>
                        </span>Total Omzet
                      </p>
                      <h3 class=" mt-2 mb-0" id="dataTotalOmzet">Rp 0</h3>
                    </div>
                  </div>
                  <div class="col-md-4 border-end">
                    <div class="p-4 py-3 py-md-4">
                      <p class="fs-4 text-primary mb-0">
                        <span class="text-primary">
                          <span class="round-8 bg-primary rounded-circle d-inline-block me-1"></span>
                        </span>Total Transaksi
                      </p>
                      <h3 class=" mt-2 mb-0" id="dataTotalTransaksi">0</h3>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="p-4 py-3 py-md-4">
                      <p class="fs-4 text-info mb-0">
                        <span class="text-info">
                          <span class="round-8 bg-info rounded-circle d-inline-block me-1"></span>
                        </span>Barang Terjual
                      </p>
                      <h3 class=" mt-2 mb-0" id="dataTotalTerjual">0</h3>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            {{--  --}}
            <div class="col-md-12" align="right">
             <button type="button" class="btn btn-outline-info" style="margin-bottom:5px; font-weight:bold;" id="btnHitungPenjualan">Hitung Penjualan <i class="ti ti-refresh"></i></button>
            </div>
            <div class="col-md-12">
              <input type="text" class="form-control customs-top" id="cariNamaBarang" placeholder="Nama barang ..">
            </div>
            <div class="col-md-4">
              <input type="text" class="form-control customs-top" id="cariIdTransaksi" placeholder="ID transaksi ..">
            </div>
            <div class="col-md-4">
              <input type="text" class="form-control customs-top" id="cariQty" placeholder="Qty ..">
            </div>
            <div class="col-md-4">
              <input type="text" class="form-control customs-top" id="cariSatuan" placeholder="Satuan ..">
            </div>
            <div class="col-md-6">
              <input type="date" class="form-control customs-top" id="cariTanggal" placeholder="Tanggal ..">
            </div>
            <div class="col-md-6">
              <input type="number" class="form-control customs-top" id="cariTotalHarga" placeholder="Total harga ..">
            </div>
            <div class="col-12">
              <br>
              <div class="progress">
                <div class="progress-bar progress-bar-striped bg-primary progress-bar-animated animasiProgressBar" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
              </div>
            </div>

            {{--  --}}
            <div class="col-12">
              <div class="card-body">
                <div class="table-responsive rounded-2 mb-4">
                  <br>
                  <table class="table border text-nowrap customize-table mb-0 align-middle" id="tabel_detail_pembelian">
                    <thead class="text-dark fs-4">
                      <tr>
                        <th><h6 class="fs-4 fw- mb-0"><input type="checkbox"></h6></th>
                        <th><h6 class="fs-4 fw- mb-0">Detail&nbsp;Barang</h6></th>
                        <th><h6 class="fs-4 fw- mb-0">Qty&nbsp;|&nbsp;Satuan</h6></th>
                        <th><h6 class="fs-4 fw- mb-0">Total&nbsp;Harga</h6></th>
                      </tr>
                    </thead>
                  </table>
                  <div class="d-flex align-items-center justify-content-end py-1">
                    <br>
                  </div>
                </div>
              </div>
            </div>
            {{--  --}}
          </div>
          <!--/row-->
        </div>
      </div>
      <div class="modal-footer" style="">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup&emsp;<i class="ti ti-x"></i></button>
      </div>
    </div>
  </div>
</div>

{{-- PILIHAN --}}
<script>
  $(document).on('change','#ChartShow', function() {
      var selectedOption = $('#ChartShow').val();
      chartShow(selectedOption);
      saveChartTypePreference(selectedOption);
  });
  function chartShow(select) {
    if(select === 'pie') {
      $('#myPieChart').attr('hidden',false);
      $('#myBarChart').attr('hidden',true);
    }
    if(select === 'bar') {
      $('#myPieChart').attr('hidden',true);
      $('#myBarChart').attr('hidden',false);
    }
  }
  $(document).ready(function () {
    var savedChartType = getChartTypePreference();
    $('#ChartShow').val(savedChartType);
    chartShow(savedChartType);
  });

  // Function to save the selected chart type to local storage
  function saveChartTypePreference(chartType) {
    localStorage.setItem('chartType', chartType);
  }

  // Function to retrieve the selected chart type from local storage
  function getChartTypePreference() {
    return localStorage.getItem('chartType') || 'pie'; // Default to 'pie' if not set
  }
</script>

{{-- GRAFIK --}}
<script src="{{ asset('template/chart/chart.min.js') }}"></script>
<script>
  // BAR CHART
  var xValues = @json(array_values($xValues));
  var yValues = @json(array_values($yValues));

  new Chart("myBarChart", {
    type: "bar",
    data: {
      labels: xValues,
      datasets: [{
        backgroundColor: [
          'rgba(54, 162, 235, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(54, 162, 235, 0.2)',
        ],
        borderColor: [
          'rgb(54, 162, 235)',
          'rgb(54, 162, 235)',
          'rgb(54, 162, 235)',
          'rgb(54, 162, 235)',
          'rgb(54, 162, 235)',
          'rgb(54, 162, 235)',
        ],
        borderWidth: 1,
        data: yValues
      }]
    },
    options: {
      legend: {display: false},
      title: {
        display: true,
        text: "Total omzet (Rp) per tanggal"
      }
    }
  });
</script>
@php
  $xValuesPie = $topProducts->pluck('nama_barang')->toArray();
  $yValuesPie = $topProducts->pluck('total_qty')->toArray();
  $barColorsPie = ['#b91d47', '#00aba9', '#2b5797', '#e8c3b9', '#1e7145'];
@endphp
<script>
  // PIE CHART
  const xValuesPie = @json($xValuesPie);
  const yValuesPie = @json($yValuesPie);
  const barColorsPie = @json($barColorsPie);

  new Chart("myPieChart", {
      type: "pie",
      data: {
          labels: xValuesPie,
          datasets: [{
              backgroundColor: barColorsPie,
              data: yValuesPie
          }]
      },
      options: {
          title: {
              display: true,
              text: "Produk paling banyak di jual ( 6 hari terakhir )"
          }
      }
  });
</script>

{{-- MODAL --}}
<script>
  $(document).on('click','#btnShowAll', function () {
      $('#ModalDetailPenjualan').modal('show');
  });
</script>

{{-- LIST PEMBELIAN (TABEL & HITUNGAN) --}}
<script>
  // TABEL & CARI
  $(document).ready(function () {
    var tabel_detail_pembelian = $("#tabel_detail_pembelian").DataTable({
        dom: 'lrtip',
        order: [
            [6,'DESC']
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
            url: "{{ route('tabel_detail_pembelian') }}",
            type: 'GET',
        },
        columns: [
            {
                data: 'id',
                className: 'clickableCell',
                orderable: false,
                render: function(data, type, row, meta) {
                    return `<input type="checkbox" class="" data-id="${data}" data-id-transaksi="${row.id_transaksi}">`;
                }
            },
            {
                data: 'id_transaksi',
                render: function (data, type, row, meta) {
                    var nama_barang = row.nama_barang;
                    var id_transaksi = row.id_transaksi;
                    var tanggal = row.formatted_date;
  
                    var views = `
                        <div class="d-flex align-items-center">
                            <div class="ms-3" style="margin-left: 0rem !important;">
                            <h6 class="fw-semibold mb-0 fs-4">${nama_barang}</h6>
                            <p class="mb-0">${trimText(id_transaksi)}</p>
                            <p class="mb-0 mt-1">[&emsp;${tanggal}&emsp;]</p>
                            </div>
                        </div>
                    `;
  
                    return views;
                }
            },
            {
                data: 'qty',
                orderable: false,
                render: function(data, type, row, meta) {
                  var qty = row.qty;
                  var satuan = row.satuan;
                  var qty_satuan = 
                  `
                    <p class="mb-0 mt-1">
                      <b>${qty}</b>&nbsp;|&nbsp;${satuan}
                    </p>
                  `;
                        
                    return qty_satuan;
                }
            },
            {
              data: 'total_harga',
              render: function(data, type, row, meta) {
                  var total_harga = formatRupiah(row.total_harga);
                  return `<span style="color:red; font-weight:bold;">${total_harga}</span>`;
                }
            },
            {
              data: 'nama_barang',
              visible: false
            },
            {
              data: 'satuan',
              visible: false
            },
            {
              data: 'created_at',
              visible: false
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
          tabel_detail_pembelian.column(4).search($('#cariNamaBarang').val()).draw();
        }, 500);
    });
    let cariIdTransaksi = null;
    $('#cariIdTransaksi').on('input', function() {
        var values = $(this).val();
        $('#cariIdTransaksi').val(values.toUpperCase());
        clearTimeout(cariIdTransaksi);
        cariIdTransaksi = setTimeout( function() {
          animasiProgressBar_run();
          tabel_detail_pembelian.column(1).search($('#cariIdTransaksi').val()).draw();
        }, 500);
    });
    let cariQty = null;
    $('#cariQty').on('input', function() {
        clearTimeout(cariQty);
        cariQty = setTimeout( function() {
          animasiProgressBar_run();
          tabel_detail_pembelian.column(2).search($('#cariQty').val()).draw();
        }, 500);
    });
    let cariSatuan = null;
    $('#cariSatuan').on('input', function() {
        clearTimeout(cariSatuan);
        cariSatuan = setTimeout( function() {
          animasiProgressBar_run();
          tabel_detail_pembelian.column(5).search($('#cariSatuan').val()).draw();
        }, 500);
    });
    let cariTotalHarga = null;
    $('#cariTotalHarga').on('input', function() {
        clearTimeout(cariTotalHarga);
        cariTotalHarga = setTimeout( function() {
          animasiProgressBar_run();
          tabel_detail_pembelian.column(3).search($('#cariTotalHarga').val()).draw();
        }, 500);
    });
    $('#cariTanggal').on('change', function() {
      animasiProgressBar_run();
      tabel_detail_pembelian.column(6).search($('#cariTanggal').val()).draw();
    });

  });

  // BUTTON HITUNG PENJUALAN
  $(document).on('change','#cariTanggal', function() {
      var values = $('#cariTanggal').val();
      var dataTotalOmzet = $('#dataTotalOmzet');
      var dataTotalTransaksi = $('#dataTotalTransaksi');
      var dataTotalTerjual = $('#dataTotalTerjual');

      dataTotalOmzet.html('Rp 0');
      dataTotalTransaksi.html('0');
      dataTotalTerjual.html('0');

  });
  $(document).on('click','#btnHitungPenjualan', function() {
    var btnDef = $('#btnHitungPenjualan').html();
    var tanggal = $('#cariTanggal').val();
    if(tanggal === '') {
      return toastError("Pilih tanggal penjualan!");
    }
    customConfirm("Hitung penjualan ?","Data akan dihitung berdasarkan tanggal yang dipilih.").then((confirmed) => {
      if (confirmed) {
        
        $('#btnHitungPenjualan').attr('disabled',true);
        $('#btnHitungPenjualan').html('Memproses ..');

        $.ajax({
          type: "GET",
          url: "{{ route('hitung_data_pembelian') }}",
          data: {
            tanggal: tanggal
          },
          dataType: "JSON",
          success: function (response) {
            
            if(response.kode == 404){
              toastError(response.pesan);
              return;
            }

            // 
            $('#dataTotalOmzet').html(response.total_omzet);
            $('#dataTotalTransaksi').html(response.total_transaksi);
            $('#dataTotalTerjual').html(response.barang_terjual);
            toastSuccess(response.pesan);


          }, error: function (error) {
            toastError("Oops! Silahkan coba lagi!");
          }, complete: function () {
            $('#btnHitungPenjualan').attr('disabled',false);
            $('#btnHitungPenjualan').html(btnDef);
          }
        });
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
    const maxLength = 30; // Jumlah huruf maksimal
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