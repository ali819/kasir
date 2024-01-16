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
    <div class="container-fluid">
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
                <label for="ModePrinter" class=""><b>Pilih Device Printer</b></label>
                <select name="modePrinter" id="ModePrinter" class="form-control">
                    <option value="">- Pilih Mode Printer -</option>
                    <option value="hp">Printer : Handphone ( Android, IOS, Tablet )</option>
                    <option value="pc">Printer : PC ( Laptop / Komputer )</option>
                </select>
            </div>
        </div>
        <div class="w-100 position-relative overflow-hidden">
            <div class="py-3 border-bottom">

                <form id="FormListbarang" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-2">
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
    
            </div>
            <div class="card-body">
                <div class="col-12">
                    <br>
                </div>
                {{-- HTML NOTA --}}
                <div class="row" id="html_print"></div>
                {{--  --}}
                <section id="steps-uid-0-p-0" role="tabpanel" aria-labelledby="steps-uid-0-h-0" class="body current" aria-hidden="false" style="">
                    <div class="table-responsive">
                        <table class="table align-middle text-nowrap mb-0">
                          <thead class="mb-0 fs-4">
                            <tr>
                              <th>#&nbsp;List&nbsp;Barang</th>
                              <th>#&nbsp;Jumlah&nbsp;Beli</th>
                              <th class="text-end">#&nbsp;Harga</th>
                            </tr>
                          </thead>
                          <tbody>
                            {{-- <tr>
                                <td colspan="3" class="text-danger text-center fs-5">List barang kosong :(</td>
                            </tr> --}}
                            <tr>                          
                              <td class="border-bottom-0">
                                <div class="d-flex align-items-center gap-3">
                                  <div>
                                    <h6 class="fw-semibold fs-4 mb-0">1. Susu bubuk merk FrisionFlag 300ml</h6>
                                    <p class="mb-0">( Eceran )</p>
                                    <a href="javascript:void(0)" class="text-danger fs-4"><i class="ti ti-trash"></i></a>
                                  </div>
                                </div>
                              </td>
                              <td class="border-bottom-0">
                                <div class="input-group input-group-sm rounded">
                                  <button class="btn minus min-width-40 py-0 border-end border-dark border-end-0 text-dark" type="button" id="add1"><i class="ti ti-minus"></i></button>
                                  <input type="text" class="min-width-40 flex-grow-0 border border-dark text-dark fs-3 fw-semibold form-control text-center qty" placeholder="" aria-label="Example text with button addon" aria-describedby="add1" value="1">
                                  <button class="btn min-width-40 py-0 border border-dark border-start-0 text-dark add" type="button" id="addo2"><i class="ti ti-plus"></i></button>
                                </div>
                              </td>
                              <td class="text-end border-bottom-0"><h6 class="fs-4 fw-semibold mb-0">Rp 50.000</h6></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    <div class="order-summary border rounded p-4 my-4">
                      <div class="p-0">
                        <div class="col-12">
                            <p class="mb-0 fs-4">Total Belanja</p>
                            <h2 style="margin-top:5px; color:#606060; font-weight:normal;">Rp 0</h2>
                        </div>
                        <div class="col-12">
                            <hr>
                        </div>
                        <div class="col-12">
                            <p class="mb-0 fs-4">Total Bayar</p>
                            <h2 style="margin-top:5px; color:#606060; font-weight:normal;">Rp 0</h2>
                            <h6 class="mb-0 fs-4 fw-semibold text-danger">
                                <input type="number" class="form-control" placeholder="Nominal Bayar ..">
                            </h6>
                        </div>
                        <div class="col-12">
                            <br>
                        </div>
                        <div class="col-12">
                            <p class="mb-0 fs-4">Kembalian</p>
                            <h2 style="margin-top:5px; color:#606060; font-weight:normal;">Rp 0</h2>
                        </div>
                        <div class="col-12">
                            <br>
                        </div>
                        <div class="col-12">
                            <button type="button" class="btn btn-primary" style="width:100%; font-weight:bold;"><i class="ti ti-receipt"></i>&emsp;Konfirmasi Pembelian</button>
                            <br>
                            <br>
                            <a class="btn btn-outline-info text btnPrintNota" href="javascript:void(0)" style="width:100%"><i class="ti ti-printer"></i>&emsp;Print Nota Pembelian</a>
                        </div>

                      </div>
                    </div>
                </section>
                {{--  --}}
                <div class="col-12">
                    <br>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL TAMBAH KE LIST --}}
    <div class="modal fade" id="ModalTambahKeList" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
              <h4 class="modal-title" id="tambahListNamaBarang">
                Nama Barang ?
              </h4>
            </div>
            <form id="FormTambahListBarang" autocomplete="off">
              @csrf
              <div class="modal-body">
                <div class="card-body">
                  <!--/row-->
                  <div class="col-12">
                    <div class="alert customize-alert alert-dismissible text-primary border border-primary fade show remove-close-icon" role="alert">
                      <div class="d-flex align-items-center font-medium me-3 me-md-0">
                        <i class="ti ti-info-circle fs-5 me-2 flex-shrink-0 text-primary"></i>
                        Silahkan pilih satuan & qty barang
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                        {{--  --}}
                        <label for="" class=""><b>Jumlah Beli ( Qty )</b></label>
                        <input type="number" class="form-control" id="" name="" placeholder="1 - 99999" required>
                        </br>
                        <input type="radio" class="btn-check" name="options" id="option1" autocomplete="off" />
                        <label class="btn btn-outline-primary rounded-pill font-medium me-2 mb-2" for="option1">Ecer - Rp 10.000</label>
                        <input type="radio" class="btn-check" name="options" id="option2" autocomplete="off" />
                        <label class="btn btn-outline-primary rounded-pill font-medium me-2 mb-2" for="option2">Grosir - Rp 65.000</label>
                        <br>
                        <label for="" class="" style="margin-top:10px;"><b>Total ( Rp )</b></label>
                        <h2 class="text-center" style="margin-top:5px; color:#606060; font-weight:bold;">Rp 0</h2>
                        <h5 class="text-center" style="color:#606060;">" Terbilang "</h5>
                    </div>
                  </div>
                  <!--/row-->
                </div>
              </div>
              <div class="modal-footer" style="margin-top:10px;">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal&emsp;<i class="ti ti-x"></i></button>
                  <button type="submit" class="btn btn-primary font-medium"><i class="ti ti-check"></i>&emsp;Tambahkan</button>
              </div>
            </form>
          </div>
        </div>
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
                // setting ke modal
                $('#tambahListNamaBarang').html(nama_barang);
                $('#ModalTambahKeList').modal('show');

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