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
            
        </div>
        <div class="w-100 position-relative overflow-hidden">
            <div class="py-3 border-bottom">

                <form id="FormListbarang" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-2">
                                <label for="cariNamaBarang" class="" style="margin-bottom:5px;"><b>Pilih Barang ( autocomplete )</b></label>
                                <input type="search" class="form-control" id="cariNamaBarang" name="cariNamaBarang" placeholder="Ketik nama barang.." list="listBarang">
                                <datalist id="listBarang">
                                    @foreach ($list_barang as $item)
                                        <option data-id="{{ $item->id }}" data-value="{{ strtolower($item->nama_barang) }}" value="{{ $item->nama_barang }}">
                                    @endforeach
                                </datalist>
                            </div>
                        </div>
                        <div class="col-12">  
                            <div class="mb-1">
                                <button type="submit" class="btn btn-primary col-12 btnTambahBarang" style="font-weight:bold"><i class="ti ti-shopping-cart"></i>&emsp;Tambahkan Ke List</button>
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
                        <table class="table align-middle text-nowrap mb-0" style="background-color:#f1f1f1;">
                          <thead class="mb-0 fs-4">
                            <tr>
                              <th>List&nbsp;Barang</th>
                              <th>Jumlah&nbsp;Beli</th>
                              <th class="text-end">Harga</th>
                            </tr>
                          </thead>
                          <tbody id="tabelListBelanja">
                            <tr class="listBelanjaanKosong">
                                <td colspan="3" class="text-center fs-5" style="color:red;">List barang kosong :(</td>
                            </tr>
                          </tbody>
                          
                        </table>
                      </div>
                    <div class="order-summary border rounded p-4 my-4">
                      <div class="p-0">
                        <div class="col-12">
                            <p class="mb-0 fs-4">Total Belanja</p>
                            <h2 style="margin-top:5px; color:red; font-weight:bold;" class="summaryTotalBelanja" data-total-belanja="0">Rp 0</h2>
                        </div>
                        <div class="col-12">
                            <hr>
                        </div>
                        <div class="col-12">
                            <p class="mb-0 fs-4">
                                Total Bayar&emsp;<span class="notifBayar"> </span>
                            </p>
                            <h2 style="margin-top:5px; color:#606060; font-weight:bold;" class="summaryTotalBayarRp">Rp 0</h2>
                            <h6 class="mb-0 fs-4 fw-semibold text-danger">
                                <input type="number" style="font-weight:normal" class="form-control summaryTotalBayar" placeholder="Nominal Bayar ..">
                            </h6>
                            <h6 class="mb-0 fs-4 mt-2">
                                <input type="text" style="font-weight:normal" class="form-control summaryPembeli" name="pembeli" placeholder="Nama pembeli ( opsional ) ..">
                            </h6>
                        </div>
                        <div class="col-12">
                            <br>
                        </div>
                        <div class="col-12">
                            <p class="mb-0 fs-4">Kembalian</p>
                            <h2 style="margin-top:5px; color:#606060; font-weight:normal;" class="summaryKembalian" data-total-kembalian="0">Rp 0</h2>
                        </div>
                        <div class="col-12">
                            <br>
                        </div>
                        <div class="col-12">
                            <button type="button" class="btn btn-primary btnKonfirmasiPembelian" style="width:100%; font-weight:bold;"><i class="ti ti-receipt"></i>&emsp;Konfirmasi Pembelian</button>
                            <br>
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
                        <input type="number" class="form-control idBarangDipilihPadaModal" hidden>
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
            if(value === '') {
                toastError("Nama barang tidak boleh kosong!");
                return;
            }
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
                            drawFormListBarang(id, response.kategori_barang, response.detail_barang, response.nama_barang);
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
        function drawFormListBarang(id_barang, kategori_barang, detail_barang, nama_barang) {
            // atur text
            $('.hitunganTotalRp').html('Rp 0');
            $('.hitunganTotalTerbilang').html('Terbilang');
            $('.idBarangDipilihPadaModal').val(id_barang);            

            if(kategori_barang === 'satuan_tidak_tetap') {
                
                var dataHTML = 
                `
                    <label for="" class="" style="margin-bottom:10px;"><b>Jumlah Pembelian ( Per-Satuan )</b></label>
                    <div class="input-group input-group-sm rounded">
                        <button class="btn min-width-40 py-0 border-end border-dark border-end-0 text-dark btnMinusTambahList" type="button" id=""><i class="ti ti-minus"></i></button>
                        <input type="text" class="min-width-40 flex-grow-0 border border-dark text-dark fs-3 fw-semibold form-control text-center qty hitunganDataQty" id="detailJumlahQty" name="detailJumlahQty" value="1" step="0.01" required>
                        <button class="btn min-width-40 py-0 border border-dark border-start-0 text-dark btnPlusTambahList" type="button" id=""><i class="ti ti-plus"></i></button>
                    </div>
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
                // toastSuccess(nama_barang);
                $('#tambahListNamaBarang').html(nama_barang);
                $('#ModalTambahKeList').modal('show');
                
            } else if(kategori_barang === 'satuan_tetap') {
                // atur value nya
                var eceran = detail_barang.harga_per_biji;
                var grosir = detail_barang.harga_grosir;
                var dataHTML = 
                `
                    <label for="" class="" style="margin-bottom:10px;"><b>Jumlah Beli ( Qty )</b></label>
                    <div class="input-group input-group-sm rounded">
                        <button class="btn min-width-40 py-0 border-end border-dark border-end-0 text-dark btnMinusTambahList" type="button" id=""><i class="ti ti-minus"></i></button>
                        <input type="text" class="min-width-40 flex-grow-0 border border-dark text-dark fs-3 fw-semibold form-control text-center qty hitunganDataQty" id="detailJumlahQty" name="detailJumlahQty" value="1" step="0.01" required>
                        <button class="btn min-width-40 py-0 border border-dark border-start-0 text-dark btnPlusTambahList" type="button" id=""><i class="ti ti-plus"></i></button>
                    </div>
                    </br>
                    <input type="radio" class="btn-check hitunganDataHarga" name="detailSatuan" id="detailSatuanEcer" data-satuan="Eceran" data-harga="${eceran}" autocomplete="off" />
                    <label class="btn btn-outline-primary rounded-pill font-medium me-2 mb-2" for="detailSatuanEcer"><b>Ecer</b> - ${formatRupiah(eceran)}</label>
                    <input type="radio" class="btn-check hitunganDataHarga" name="detailSatuan" id="detailSatuanGrosir" data-satuan="Grosir" data-harga="${grosir}" autocomplete="off" />
                    <label class="btn btn-outline-primary rounded-pill font-medium me-2 mb-2" for="detailSatuanGrosir"><b>Grosir</b> - ${formatRupiah(grosir)}</label>
                `;
                $('#DataDetailBarang').html(dataHTML);

                // setting ke modal
                $('#cariNamaBarang').val('');
                // toastSuccess(nama_barang);
                $('#tambahListNamaBarang').html(nama_barang);
                $('#ModalTambahKeList').modal('show');


            } else {
                toastError("Oops! Kategori barang tidak ditemukan!");
            }
        }
        
        // HITUNGAN + - PADA MODAL
        function hitunganTotalBelanja() {
            var qty = $('.hitunganDataQty').val();
            var harga = $('.hitunganDataHarga:checked').attr('data-harga');
            harga = (harga === '' || isNaN(harga)) ? 0 : harga;
            qty = (qty === '' || isNaN(qty)) ? 0 : qty;

            var TotalBelanja = qty * harga;
            var Rp = formatRupiah(TotalBelanja);
            var Terbilang = angkaTerbilang(TotalBelanja);
            
            $('.hitunganTotalRp').html(Rp);
            $('.hitunganTotalTerbilang').html(Terbilang);

        }
        $(document).on('click', '.btnMinusTambahList', function () {
            var inputQty = $(this).parent().find('.qty');
            var currentValue = parseFloat(inputQty.val());

            if (!isNaN(currentValue) && currentValue > 0) {
                inputQty.val(currentValue - 1);
            } else {
                inputQty.val(0);
            }
            hitunganTotalBelanja();

        });
        $(document).on('click', '.btnPlusTambahList', function () {
            var inputQty = $(this).parent().find('.qty');
            var currentValue = parseFloat(inputQty.val());

            if (!isNaN(currentValue)) {
                inputQty.val(currentValue + 1);
            } else {
                inputQty.val(1);
            }
            hitunganTotalBelanja();
        });
        $(document).on('input','#detailJumlahQty', function() {
            var inputQty = $('#detailJumlahQty').val();
            if (!isNaN(inputQty)) {
                $('#detailJumlahQty').val(inputQty);
            } else {
                $('#detailJumlahQty').val(1);
            }
            hitunganTotalBelanja();
        });
        $(document).on('click','.hitunganDataHarga', function() {
            hitunganTotalBelanja();
        });

        // TAMBAH KE LIST BELANJA
        $('#FormTambahListBarang').on('submit', function(e) {
            e.preventDefault();
            var id_barang = $('.idBarangDipilihPadaModal').val();
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

            drawTabelListBelanja(id_barang, nama_barang, satuan, total_qty, total_harga, harga);


        });
        let nomorUrut = 1;
        function drawTabelListBelanja(id_barang, nama_barang, satuan, total_qty, total_harga, harga) {
            $('.listBelanjaanKosong').remove();
            nomorUrut++;
            var urutan = nomorUrut;
            if(urutan <= 0) { urutan = 1; }
            var rp = formatRupiah(total_harga);
            var tabelBelanja = $('#tabelListBelanja');
            var dataHTML = 
            `
                <tr class="nomorBelanjaan ListUrutanBarang${urutan}">                          
                  <td class="border-bottom-0">
                    <div class="d-flex align-items-center gap-3">
                      <div>
                        <h6 class="fw-semibold fs-4 mb-0 "><span class="urutanListBelanja">${urutan}</span>. ${nama_barang}</h6>
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
                  <input type="hidden" class="form-control dynamicBelanjaInputan dynamicLoopingInput" name="dynamicTabelBelanja[${urutan}][id_barang]" data-urutan="${urutan}" value="${id_barang}">
                  <input type="hidden" class="form-control dynamicBelanjaInputan" name="dynamicTabelBelanja[${urutan}][nama_barang]" value="${nama_barang}">
                  <input type="hidden" class="form-control dynamicBelanjaInputan" name="dynamicTabelBelanja[${urutan}][satuan]" value="${satuan}">
                  <input type="hidden" class="form-control dynamicBelanjaInputan" name="dynamicTabelBelanja[${urutan}][total_qty]" value="${total_qty}">
                  <input type="hidden" class="form-control dynamicBelanjaInputan dynamic-total-harga-input" name="dynamicTabelBelanja[${urutan}][total_harga]" value="${total_harga}">
                  <input type="hidden" class="form-control dynamicBelanjaInputan" name="dynamicTabelBelanja[${urutan}][harga]" value="${harga}">
                </tr>
            `;
            tabelBelanja.append(dataHTML);
            // atur modal
            $('#ModalTambahKeList').modal('hide');
            // hitung total belanja
            changeTotalBelanja();
            //hitung ulang urutan
            urutanListBelanja();
        }
        function urutanListBelanja() {
            var urutan = 1;
            $('.urutanListBelanja').each(function() {
                $(this).text(urutan); // Mengatur teks span menjadi nomor urutan
                urutan++; // Menambah nomor urutan untuk item berikutnya
            });
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
            // hitung ulang total belanja
            changeTotalBelanja();
        }

        // HAPUS LIST ITEM TABEL
        $(document).on('click','.btnHapusListBarang', function() {
            var urutan = $(this).attr('data-urutan');
            $('.ListUrutanBarang'+urutan).remove();
            // hitung ulang total belanja
            changeTotalBelanja();
            // check jika kosong
            var list_total = $('.nomorBelanjaan').length;
            if(list_total < 1) {
                $('#tabelListBelanja').html(
                    `
                        <tr class="listBelanjaanKosong">
                            <td colspan="3" class="text-center fs-5" style="color:red;">List barang kosong :(</td>
                        </tr>
                    `);
            }
            // hitung ulang urutan
            urutanListBelanja();
        });

        // HITUNGAN TOTAL BELANJA
        function changeTotalBelanja() {
            var input_total_harga = $('.dynamic-total-harga-input');
            var totalHarga = 0;
            input_total_harga.each(function () {
                // Mengambil nilai dari setiap elemen dan mengonversinya ke tipe numerik
                var nilai = parseFloat($(this).val()) || 0;
                // Menambahkan nilai ke totalHarga
                totalHarga += nilai;
            });
            var totalHargaRp = formatRupiah(totalHarga);
            // ubah nilai html
            $('.summaryTotalBelanja').html(totalHargaRp);
            $('.summaryTotalBelanja').attr('data-total-belanja',totalHarga);
            // hitung ulang total
            hitungTotalBayarKembalian();
        }
        function hitungTotalBayarKembalian() {
            var total_belanja = $('.summaryTotalBelanja').attr('data-total-belanja');

            var totalBayar = $('.summaryTotalBayar').val();
            if(totalBayar === '' || totalBayar <= 0) {
                totalBayar = 0;
            }
            var totalBayarRp = formatRupiah(totalBayar);
            $('.summaryTotalBayarRp').html(totalBayarRp);
            // 
            var kembalian = totalBayar - total_belanja;
            if(kembalian <= 0) {
                kembalian = 0;
            }
            var kembalianRp = formatRupiah(kembalian);
            $('.summaryKembalian').html(kembalianRp);
            $('.summaryKembalian').attr('data-total-kembalian',kembalian);
            // atur icon
            
        }
        $(document).on('input','.summaryTotalBayar', function() {
            clearTimeout(timeQty);
            timeQty = setTimeout( function() {
                hitungTotalBayarKembalian();
            }, 500);
        });

        // KONFIRMASI PEMBELIAN & CETAK
        $(document).on('click','.btnKonfirmasiPembelian', function() {
            // validasi
            var modePrinter = $('#ModePrinter').val();
            var totalBelanja = $('.summaryTotalBelanja').attr('data-total-belanja');
            if(totalBelanja === '' || totalBelanja < 1) {
                return toastError("Total belanja kosong!");
            }
            var totalBayar = $('.summaryTotalBayar').val();
            if(totalBayar === '' || totalBayar < 1) {
                return toastError("Total bayar kosong!");
            }
            if(parseFloat(totalBayar) < parseFloat(totalBelanja)) {
                return toastError("Total pembayaran kurang dari total belanja!");
            }
            if(modePrinter === '') {
                return toastError("Mohon pilih mode device printer!");
            }
            customConfirm("Konfirmasi pembelian ?","Pastikan data sudah benar.").then((confirmed) => {
                
                // Mengumpulkan data input dinamis
                var validasiJumlahBeli = true;
                var validasiHargaBarang = true;

                var dynamicTabelBelanja = [];
                $('.dynamicLoopingInput').each(function() {
                    var urutan = $(this).data('urutan');
                    var id_barang = $('input[name="dynamicTabelBelanja[' + urutan + '][id_barang]"]').val();
                    var nama_barang = $('input[name="dynamicTabelBelanja[' + urutan + '][nama_barang]"]').val();
                    var satuan = $('input[name="dynamicTabelBelanja[' + urutan + '][satuan]"]').val();
                    var total_qty = $('input[name="dynamicTabelBelanja[' + urutan + '][total_qty]"]').val();
                    var total_harga = $('input[name="dynamicTabelBelanja[' + urutan + '][total_harga]"]').val();
                    var harga = $('input[name="dynamicTabelBelanja[' + urutan + '][harga]"]').val();

                    // validasi
                    if(parseInt(total_qty) <= 0 || total_qty === '') {
                        validasiJumlahBeli = false;
                    }
                    if(parseInt(total_harga) <= 0 || total_harga === '') {
                        validasiHargaBarang = false;
                    }

                    // Menambahkan data ke dalam array
                    dynamicTabelBelanja.push({
                        id_barang: id_barang,
                        nama_barang: nama_barang,
                        satuan: satuan,
                        total_qty: total_qty,
                        total_harga: total_harga,
                        harga: harga
                    });
                });
                
                if (confirmed) {

                    if(!validasiHargaBarang || !validasiJumlahBeli) {
                        return toastError("Harga barang / jumlah beli tidak boleh kosong!");
                    }
                    
                    var btnDefault = $('.btnKonfirmasiPembelian').html();
                    $('.btnKonfirmasiPembelian').html('Memproses ..');
                    $('.btnKonfirmasiPembelian').attr('disabled',true);

                    var total_belanja = totalBelanja;
                    var total_bayar = totalBayar;
                    var kembalian = $('.summaryKembalian').attr('data-total-kembalian');
                    var pembeli = $('.summaryPembeli').val();

                    $.ajax({
                        type: "POST",
                        url: "{{ route('konfirmasi_pembelian_barang') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            dynamicTabelBelanja: dynamicTabelBelanja,
                            total_belanja: total_belanja,
                            total_bayar: total_bayar,
                            kembalian: kembalian,
                            pembeli: pembeli,
                        },
                        dataType: "JSON",
                        success: function (response) {

                            if(response.kode == 200) {

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
                                        raw_data.pembeli,
                                        raw_data.nama_toko,
                                        raw_data.alamat_toko,
                                        response.pesan
                                    );
                                    
                                } else {
                                    toastError("Mode printer tidak dipilih! Silahkan cetak ulang pada menu pembelian!");
                                }
    
                                $('#tabelListBelanja').html(`
                                    <tr class="listBelanjaanKosong">
                                        <td colspan="3" class="text-center fs-5" style="color:red;">List barang kosong :(</td>
                                    </tr>
                                `);
                                $('.summaryTotalBayar').val('');
                                $('.summaryPembeli').val('');
                                hitungTotalBayarKembalian();
                                changeTotalBelanja();
    
                                // toast
                                toastSuccess("Transaksi pembelian berhasil!");
                            } else {

                                toastError(response.pesan);
                            
                            }


                        }, error: function (error) {
                            toastError("Oops! Terjadi kesalahan. Silahkan coba lagi!")
                        }, complete: function () {
                            $('.btnKonfirmasiPembelian').html(btnDefault);
                            $('.btnKonfirmasiPembelian').attr('disabled',false);
                            topFunction();
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

        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
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