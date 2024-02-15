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
            <h4 class="fw-semibold mb-8">Informasi Toko</h4>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a class="text-muted" href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">Informasi Toko</li>
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
              Pada menu ini menampilkan informasi toko yang di tampilkan pada nota belanja
            </div>
          </div>
        </div>
    </div>
    <div class="w-100 position-relative overflow-hidden">
      <div class="py-3 border-bottom">

        <div class="row">
          <div class="col-12">  
            <div class="mb-1">
              <label for=""><b>Nama Toko</b></label>
              <input type="text" class="form-control" id="informasiNamaToko" name="informasiNamaToko" placeholder="Nama Toko .." value="{{ $nama_toko }}" autocomplete="off">
            </div>
        </div>
        <div class="col-md-12">  
            <div class="mb-3">
              <label for=""><b>Alamat</b></label>
              <textarea name="informasiAlamatToko" id="informasiAlamatToko" cols="30" rows="5" class="form-control" placeholder="Alamat ..">{{ $alamat_toko }}</textarea>
            </div>
        </div>
        <div class="col-12">
            <div class="progress">
              <div class="progress-bar progress-bar-striped bg-primary progress-bar-animated animasiProgressBar" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
            </div>
          </div>
        </div>

        <div class="col-12">
          <hr>
        </div>
        <div class="col-12" align="right">
          <button type="button" id="btnKonfirmasiInformasiToko" class="btn btn-primary" style="font-weight:bold;">Perbarui&emsp;<i class="ti ti-check"></i></button>
        </div>
      
      </div>

    </div>
    <!-- --------------------------------------------------- -->
</div>

<script>
  $(document).on('click','#btnKonfirmasiInformasiToko', function() {

      var nama_toko = $('#informasiNamaToko').val();
      var alamat_toko = $('#informasiAlamatToko').val();
      if(nama_toko === '') {
        toastError("Nama toko tidak boleh kosong !");
        return;
      }
      if(alamat_toko === '') {
        toastError("Alamat toko tidak boleh kosong !");
        return;
      }

      var btnDef = $('#btnKonfirmasiInformasiToko').html();
      $('#btnKonfirmasiInformasiToko').html('Memproses ..');
      $('#btnKonfirmasiInformasiToko').attr('disabled',true);

      $.ajax({
        type: "POST",
        url: "{{ route('update_informasi_toko') }}",
        data: {
          _token: "{{ csrf_token() }}",
          nama_toko: nama_toko,
          alamat_toko: alamat_toko,
        },
        dataType: "JSON",
        success: function (response) {

          toastSuccess(response.pesan);

        }, error: function (error) {

          toastError("Oops! Silahkan coba lagi!");
        
        }, complete: function () {
          $('#btnKonfirmasiInformasiToko').html(btnDef);
          $('#btnKonfirmasiInformasiToko').attr('disabled',false);
        }
      });
  });
</script>

@endsection