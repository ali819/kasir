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
                <div class="row" id="html_print">

                </div>
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
                          <form id="formTabelBelanja" autocomplete="off">
                            @csrf
                              <tbody id="tabelListBelanja">
                                <tr class="listBelanjaanKosong">
                                    <td colspan="3" class="text-danger text-center fs-5">List barang kosong :(</td>
                                </tr>
                              </tbody>
                          </form>
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
    <div class="modal fade" id="ModalTambahKeList" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="" style="display: none;" aria-hidden="true">
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
                        <div id="DataDetailBarang">
                           
                            
                        </div>
                        <br>
                        <label for="" class="" style="margin-top:10px;"><b>Total ( Rp )</b></label>
                        <h2 class="text-center hitunganTotalRp" style="margin-top:5px; color:#606060; font-weight:bold;">Rp 0</h2>
                        <h5 class="text-center hitunganTotalTerbilang" style="color:#606060;">" Terbilang "</h5>
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

        // LEMPAR KE MODAL (DETAIL BARANG)
        $('#FormListbarang').on('submit',function(event) {
            event.preventDefault();
            var value = $('#cariNamaBarang').val().toLowerCase();
            var selectedOption = $("#listBarang option[data-value='" + value + "']");
            if (selectedOption.length > 0) {
                var id = selectedOption.data("id");
                var nama_barang = selectedOption.val();
                // atur button
                var btnValue = $('.btnTambahBarang').html();
                $('.btnTambahBarang').attr('disabled',true);
                $('.btnTambahBarang').html('Memuat..');
                // ajax
                $.ajax({
                    type: "GET",
                    url: "{{ route('detail_data_barang') }}",
                    data: {
                        id: id,
                    },
                    dataType: "JSON",
                    success: function (response) {

                        if(response.kode == 200) {
                            drawFormListBarang(response.kategori_barang, response.detail_barang, response.nama_barang);
                        } else if(response.kode == 404) {
                            toastError(response.pesan);
                        } else {
                            toastError("Oops! Terjadi kesalahan saat mengambil data!");
                        }
                        
                    }, error: function (error) {
                        toastError("Oops! Silahkan coba lagi!");
                    }, complete: function () {
                        $('.btnTambahBarang').attr('disabled',false);
                        $('.btnTambahBarang').html(btnValue);
                    }
                });

            } else {
                toastError("Barang '"+value+"' tidak ditemukan!");
            }
        });
        function drawFormListBarang(kategori_barang, detail_barang, nama_barang) {
            // atur text
            $('.hitunganTotalRp').html('Rp 0');
            $('.hitunganTotalTerbilang').html('Terbilang');            

            if(kategori_barang === 'satuan_tidak_tetap') {
                
                var dataHTML = 
                `
                    <label for="" class=""><b>Jumlah Pembelian ( Per-Satuan )</b></label>
                    <input type="number" class="form-control hitunganDataQty" id="detailJumlahQty" name="detailJumlahQty" placeholder="Qty .." value="1" step="0.01" required>
                    </br>
                `;

                // each get dari controller 
                detail_barang.forEach(function(item) {
                    // Buat elemen HTML untuk setiap item
                    var harga = item.harga;
                    var satuan = item.satuan;

                    dataHTML += `
                        <input type="radio" class="btn-check hitunganDataHarga" name="detailSatuan" id="detailSatuan${satuan}" data-satuan="${satuan}" data-harga="${harga}" autocomplete="off" />
                        <label class="btn btn-outline-primary rounded-pill font-medium me-2 mb-2" for="detailSatuan${satuan}"><b>${satuan}</b> - ${formatRupiah(harga)}</label>
                    `;
                });

                $('#DataDetailBarang').html(dataHTML);

                // setting ke modal
                $('#cariNamaBarang').val('');
                toastSuccess(nama_barang);
                $('#tambahListNamaBarang').html(nama_barang);
                $('#ModalTambahKeList').modal('show');
            } else if(kategori_barang === 'satuan_tetap') {
                // atur value nya
                var eceran = detail_barang.harga_per_biji;
                var grosir = detail_barang.harga_grosir;
                var dataHTML = 
                `
                    <label for="" class=""><b>Jumlah Beli ( Qty )</b></label>
                    <input type="number" class="form-control hitunganDataQty" id="detailJumlahQty" name="detailJumlahQty" placeholder="1 - 99999" required>
                    </br>
                    <input type="radio" class="btn-check hitunganDataHarga" name="detailSatuan" id="detailSatuanEcer" data-satuan="Eceran" data-harga="${eceran}" autocomplete="off" />
                    <label class="btn btn-outline-primary rounded-pill font-medium me-2 mb-2" for="detailSatuanEcer"><b>Ecer</b> - ${formatRupiah(eceran)}</label>
                    <input type="radio" class="btn-check hitunganDataHarga" name="detailSatuan" id="detailSatuanGrosir" data-satuan="Grosir" data-harga="${grosir}" autocomplete="off" />
                    <label class="btn btn-outline-primary rounded-pill font-medium me-2 mb-2" for="detailSatuanGrosir"><b>Grosir</b> - ${formatRupiah(grosir)}</label>
                `;
                $('#DataDetailBarang').html(dataHTML);

                // setting ke modal
                $('#cariNamaBarang').val('');
                toastSuccess(nama_barang);
                $('#tambahListNamaBarang').html(nama_barang);
                $('#ModalTambahKeList').modal('show');
            } else {
                toastError("Oops! Kategori barang tidak ditemukan!");
            }
        }

        // TOTAL BELANJA & TERBILANG (HITUNGAN PADA MODAL)
        function hitunganTotalBelanja() {
            var qty = $('.hitunganDataQty').val();
            var harga = $('.hitunganDataHarga:checked').attr('data-harga');
            harga = (harga === '') ? 0 : harga;
            qty = (qty === '') ? 0 : qty;

            var TotalBelanja = qty * harga;
            var Rp = formatRupiah(TotalBelanja);
            var Terbilang = angkaTerbilang(TotalBelanja);
            
            $('.hitunganTotalRp').html(Rp);
            $('.hitunganTotalTerbilang').html(Terbilang);

            console.log('QTY : '+qty+' | HARGA : '+Rp+' | TERBILANG : '+Terbilang);

        }
        $(document).on('input','.hitunganDataQty', function() {
            hitunganTotalBelanja();
        });
        $(document).on('click','.hitunganDataHarga', function() {
            hitunganTotalBelanja();
        });

        // TAMBAH KE LIST BELANJA
        $('#FormTambahListBarang').on('submit', function(e) {
            e.preventDefault();
            var nama_barang = $('#tambahListNamaBarang').html();
            var satuan = $('.hitunganDataHarga:checked').attr('data-satuan');
            var harga = $('.hitunganDataHarga:checked').attr('data-harga');
            var total_qty = $('.hitunganDataQty').val();
            var total_harga = total_qty * harga;
            if(nama_barang === '') {
                toastError("Nama barang kosong!");
                return;
            }
            if(satuan === '') {
                toastError("Satuan barang kosong!");
                return;
            }
            if(harga === '') {
                toastError("Harga barang kosong!");
                return;
            }
            if(total_qty === '' || total_qty <= 0) {
                toastError("Perhitungan total harga kosong!");
                return;
            }

            drawTabelListBelanja(nama_barang, satuan, total_qty, total_harga, harga);


        });
        function drawTabelListBelanja(nama_barang, satuan, total_qty, total_harga, harga) {
            $('.listBelanjaanKosong').remove();
            var urutan = $('.nomorBelanjaan').length;
            urutan++;
            if(urutan <= 0) { urutan = 1; }
            var rp = formatRupiah(total_harga);
            var tabelBelanja = $('#tabelListBelanja');
            var dataHTML = 
            `
                <tr class="nomorBelanjaan ListUrutanBarang${urutan}">                          
                  <td class="border-bottom-0">
                    <div class="d-flex align-items-center gap-3">
                      <div>
                        <h6 class="fw-semibold fs-4 mb-0 ">${urutan}. ${nama_barang}</h6>
                        <p class="mb-0">( ${satuan} )</p>
                        <a href="javascript:void(0)" class="text-danger fs-4 btnHapusListBarang" data-urutan="${urutan}"><i class="ti ti-trash"></i></a>
                      </div>
                    </div>
                  </td>
                  <td class="border-bottom-0">
                    <div class="input-group input-group-sm rounded">
                      <button class="btn minus min-width-40 py-0 border-end border-dark border-end-0 text-dark btnChangeQty" data-urutan="${urutan}" type="button" id="add${urutan}"><i class="ti ti-minus"></i></button>
                      <input type="text" class="min-width-40 flex-grow-0 border border-dark text-dark fs-3 fw-semibold form-control text-center qty tabelBelanjaQty numberDataQty${urutan}" data-urutan="${urutan}" placeholder="" aria-label="" aria-describedby="" value="${total_qty}" step="0.01">
                      <button class="btn min-width-40 py-0 border border-dark border-start-0 text-dark add  btnChangeQty" data-urutan="${urutan}" type="button" id="addo${urutan}"><i class="ti ti-plus"></i></button>
                    </div>
                  </td>
                  <td class="text-end border-bottom-0"><h6 class="fs-4 fw-semibold mb-0 tabelBelanjaRp numberDataRp${urutan}">${rp}</h6></td>
                  <input type="hidden" class="form-control" name="dynamicTabelBelanja[${urutan}][nama_barang]" value="${nama_barang}">
                  <input type="hidden" class="form-control" name="dynamicTabelBelanja[${urutan}][satuan]" value="${satuan}">
                  <input type="hidden" class="form-control" name="dynamicTabelBelanja[${urutan}][total_qty]" value="${total_qty}">
                  <input type="hidden" class="form-control" name="dynamicTabelBelanja[${urutan}][total_harga]" value="${total_harga}">
                  <input type="hidden" class="form-control" name="dynamicTabelBelanja[${urutan}][harga]" value="${harga}">
                </tr>
            `;
            tabelBelanja.append(dataHTML);
            // atur modal
            $('#ModalTambahKeList').modal('hide');
        }

        // ON CHANGE TABEL LIST BELANJAAN

        let timeQty = null;
        $(document).on('click','.btnChangeQty', function() {
            clearTimeout(timeQty);
            var urutan = $(this).attr('data-urutan');
            timeQty = setTimeout( function() {
                changeListBelanjaan(urutan);
            }, 500);
        });
        $(document).on('input','.tabelBelanjaQty', function() {
            var urutan = $(this).attr('data-urutan');
            changeListBelanjaan(urutan);
        });
        function changeListBelanjaan(urutan) {
            // Membuat nama atribut dengan format dinamis
            var namaAtributHarga = `dynamicTabelBelanja[${urutan}][harga]`;
            var namaAtributTotalHarga = `dynamicTabelBelanja[${urutan}][total_harga]`;
            var namaAtributTotalQty = `dynamicTabelBelanja[${urutan}][total_qty]`;
            // hitungan
            var harga = $('[name="' + namaAtributHarga + '"]').val();
            var qty = $('.numberDataQty'+urutan).val();
            if(qty === '') { qty = 0; }
            var total_hitungan = harga * qty;
            var rp = formatRupiah(total_hitungan);
            // ubah 
            $('.numberDataRp'+urutan).html(rp);
            $('[name="' + namaAtributTotalQty + '"]').val(qty);
            $('[name="' + namaAtributTotalHarga + '"]').val(total_hitungan);

            console.log('TOTAL QTY : '+qty+' | TOTAL HARGA : '+rp);
        }

        // HAPUS LIST ITEM TABEL
        $(document).on('click','.btnHapusListBarang', function() {
            var urutan = $(this).attr('data-urutan');
            $('.ListUrutanBarang'+urutan).remove();
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

        // FORMAT PENULISAN
        function formatRupiah(angka) {
            angka = Math.floor(angka); // Menghilangkan angka desimal
            const reverse = angka.toString().split('').reverse().join('');
            let ribuan = reverse.match(/\d{1,3}/g);
            ribuan = ribuan.join('.').split('').reverse().join('');
            return 'Rp ' + ribuan;
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