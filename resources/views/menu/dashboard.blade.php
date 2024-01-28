@extends('layouts.main')
@section('content')
@section('title', 'Dashboard')

<div class="container-fluid">

    <!--  Row 1 -->
    <div class="row">
      <div class="col-lg-12 d-flex align-items-strech">
        <div class="card w-100">
          <div class="card-body">
            <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
              <div class="mb-3 mb-sm-0">
                <h3 class=" fw-semibold">Data Penjualan</h3>
                <p class="card-subtitle mb-0">Grafik minggu terakhir</p>
              </div>
              <div>
                {{--  --}}
              </div>
            </div>
            <div class="row align-items-center">
              <div class="col-lg-8 col-md-8">
                {{--  --}}
                <canvas id="myChart" style="width:100%;max-width:800px"></canvas>
              </div>
              <div class="col-lg-4 col-md-4">
                <div class="d-flex align-items-center mb-4 pb-1">
                  <div class="p-8 bg-light-primary rounded-1 me-3 d-flex align-items-center justify-content-center">
                    <i class="ti ti-grid-dots text-primary fs-6"></i>
                  </div>
                  <div>
                    <h4 class="mb-0 fs-7 fw-semibold">{{ $totalPenjualan }}</h4>
                    <p class="fs-3 mb-0">Total Penjualan</p>
                  </div>
                </div>
                <div>
                  <div class="d-flex align-items-baseline mb-4">
                    <span class="round-8 bg-primary rounded-circle me-6"></span>
                    <div>
                      <p class="fs-3 mb-1">Total Transaksi</p>
                      <h6 class="fs-5 fw-semibold mb-0">{{ $totalTransaksi }}</h6>
                    </div>
                  </div>
                  <div class="d-flex align-items-baseline mb-4 pb-1">
                    <span class="round-8 bg-secondary rounded-circle me-6"></span>
                    <div>
                      <p class="fs-3 mb-1">Total Barang Terjual</p>
                      <h6 class="fs-5 fw-semibold mb-0">{{ $totalBarangTerjual }}</h6>
                    </div>
                  </div>
                  <div>
                    <button class="btn btn-primary w-100">LIHAT SEMUA</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

</div>

{{-- GRAFIK --}}
<script src="{{ asset('template/chart/chart.min.js') }}"></script>
<script>

  var xValues = @json($xValues);
  var yValues = @json($yValues);
  var barColors = @json($barColors);

  new Chart("myChart", {
    type: "bar",
    data: {
      labels: xValues,
      datasets: [{
        backgroundColor: barColors,
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

@endsection