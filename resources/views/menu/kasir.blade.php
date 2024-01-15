@extends('layouts.main')
@section('content')
@section('title', 'Kasir')

    <style>
        .custom-d {
            margin-top: 10px;
        }
        .dashed-line {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }
    </style>
  
    {{-- MAIN --}}
    <div class="container-fluid" id="pre_print">
        <!-- --------------------------------------------------- -->
        <div class="card bg-light-info shadow-none position-relative overflow-hidden">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Layanan Kasir</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted" href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Kasir</li>
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
            <div class="col-12">
                <div class="progress">
                    <div class="progress-bar progress-bar-striped bg-primary progress-bar-animated animasiProgressBar" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                </div>
            </div>
            
        </div>
        <div class="row">
    
            <div class="col-12">
                <div class="alert customize-alert alert-dismissible text-primary border border-primary fade show remove-close-icon" role="alert">
                <div class="d-flex align-items-center font-medium me-3 me-md-0">
                    <i class="ti ti-info-circle fs-5 me-2 flex-shrink-0 text-primary"></i>
                    Pada menu ini anda dapat melakukan perhitungan pembelian barang
                </div>
                </div>
            </div>
            
            <div class="col-12">
                <select name="modePrinter" id="ModePrinter" class="form-control">
                    <option value="">- Pilih Mode Printer -</option>
                    <option value="hp">Mode : Handphone ( Android, IOS, Tablet )</option>
                    <option value="pc">Mode : PC ( Laptop / Komputer )</option>
                </select>
            </div>
        </div>
        <div class="w-100 position-relative overflow-hidden">
            <div class="py-3 border-bottom">

                <form id="FormListbarang" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-1">
                                <label for="cariNamaBarang" class=""><b>Pilih Barang (Autocomplete)</b></label>
                                <input type="search" class="form-control" id="cariNamaBarang" name="cariNamaBarang" placeholder="Ketik nama barang.." list="listBarang" required>
                                <datalist id="listBarang">
                                    @foreach ($list_barang as $item)
                                        <option data-id="{{ $item->id }}" data-value="{{ strtolower($item->nama_barang) }}" value="{{ $item->nama_barang }}">
                                    @endforeach
                                </datalist>
                            </div>
                        </div>
                        <div class="col-12">  
                            <div class="mb-1">
                                <button type="submit" class="btn btn-primary col-12 btnTambahBarang" data-bs-toggle="modal" data-bs-target="#" style="font-weight:bold"><i class="ti ti-shopping-cart"></i>&emsp;Tambahkan Ke List</button>
                            </div>
                        </div>
                    
                    </div>
                </form>
    
            {{--  --}}
    
            </div>
            <div class="card-body">
                <div class="col-12">
                    <br>
                </div>
                {{-- HTML NOTA --}}
                <div class="row" id="html_print">
                    
                </div>
                {{--  --}}
                <div class="col-12">
                    <br>
                </div>
                <div class="col-12" align="right">
                    <a class="btn btn-outline-info text btnPrintNota" href="javascript:void(0)"><i class="ti ti-printer"></i>&emsp;Print Nota Pembelian</a>
                </div>
            </div>
        </div>
        <!-- --------------------------------------------------- -->
    </div>

    <script>

        // let cariNamaBarang = null;
        // $(document).on('input','#cariNamaBarang', function() {
        //     clearTimeout(cariNamaBarang);
        //     cariNamaBarang = setTimeout( function() {
        //       animasiProgressBar_run();
        //     }, 500);
        // });

        $('#FormListbarang').on('submit',function(event) {
            event.preventDefault();
            var value = $('#cariNamaBarang').val().toLowerCase();
            var selectedOption = $("#listBarang option[data-value='" + value + "']");
            if (selectedOption.length > 0) {
                var id = selectedOption.data("id");
                var nama_barang = selectedOption.val();

                toastSuccess(nama_barang);
            } else {
                toastError("Barang '"+value+"' tidak ditemukan!");
            }
        });

        // PRINT RAWBT ( https://www.rawbt.ru/start.html )
        let html_print = 
        `
            <div class="col-12">
                <h5>
                    <br>
                    <span id="notaNamaToko">NAMA TOKO</span> - <span id="notaAlamat">ALAMAT</span> 
                </h5>
                <p>
                    <span id="notaIdTransaksi">TRX-13</span> <br> 
                    <span id="notaTanggalPembelian">15 Januari 2024 18:10:05</span>
                </p>
                <p>
                    - - - - - - - - - - - -
                    <br>
                    ( 1 ). Susu bubuk dancow coklat sehat anak 500ml
                    <br>
                    3 (Grosir) x Rp 15.000
                    <br>
                    <br>
        
                    ( 2 ). Odol Pepsodent 300gr
                    <br>
                    1 (Ecer) x Rp 10.000
                    <br>
                    <br>
        
                    ( 3 ). Beras Raja Lele
                    <br>
                    1 Kg x Rp 10.000
                    <br>
                    <br>
                    - - - - - - - - - - - -
                    <br>
                    TOTAL BELANJA
                    <br>
                    <span id="notaTotalBelanja">Rp 35.000</span>
                    <br>
                    <br>
                    - - - - - - - - - - - -
                    <br>
                    TOTAL BAYAR
                    <br>
                    <span id="notaTotalBayar">Rp 50.000</span>
                    <br>
                    <br>
                    - - - - - - - - - - - -
                    <br>
                    KEMBALIAN
                    <br>
                    <span id="notaKembalian">Rp 15.000</span>
                    <br>
                    <br>
                    - - - - - - - - - - - -
                    <br>
                </p>
            </div>
        `;
        $(document).on('click','.btnPrintNota', function() {
            $('#html_print').html('');
            $('#html_print').html(html_print);
            var element = document.getElementById('html_print').innerText
            PrintNota(element);

        });
        function PrintNota(HTMLarea){
            var S = "#Intent;scheme=rawbt;";
            var P =  "package=ru.a402d.rawbtprinter;end;";
            var textEncoded = encodeURI(HTMLarea);
            window.location.href="intent:"+textEncoded+S+P;
            $('#html_print').html('');
        }

        // PROGRESSBAR
        function animasiProgressBar_run() {
            $('.animasiProgressBar').css('width', '100%');
        }
        function animasiProgressBar_stop() {
            $('.animasiProgressBar').css('width', '0%');
        }
    </script>

@endsection