{{-- MODAL DATA PEMBELIAN --}}
<div class="modal fade" id="ModalPengaturanPrinter" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header d-flex align-items-center">
          <h4 class="modal-title" id="">
            <span id="">Pengaturan Printer</span>
          </h4>
        </div>
        <form id="FormPengaturanPrinter" autocomplete="off">
          @csrf
          <div class="modal-body">
            <div class="card-body">
              <!--/row-->
              <div class="col-12">
                  <div class="alert customize-alert alert-dismissible text-primary border border-primary fade show remove-close-icon" role="alert">
                      <div id="keteranganPrinter" class="d-flex align-items-center font-medium me-3 me-md-0">
                        <i class="ti ti-info-circle fs-5 me-2 flex-shrink-0 text-primary"></i>
                        Aplikasi support dengan jenis printer thermal apapun, jika menggunakan android / tab / IOS printer harus support bluetooth
                      </div>
                  </div>
              </div>
              <div class="col-12" style="margin-bottom:10px;" align="right">
                <a id="btnDokumentasiPrinterTool" href="javascript:void(0)" target="_blank" style="color:rgb(62, 62, 62);">
                    <u>Lihat dokumentasi</u>
                </a>
              </div>
              <div class="row">
                <div class="col-12">
                    <label for="ModePrinter" class=""><b>Pilih Device Printer</b></label>
                    <select name="modePrinter" id="ModePrinter" class="form-control">
                        <option value="">- Pilih Mode Printer -</option>
                        <option value="hp">Printer : Handphone ( Android, IOS, Tablet )</option>
                        <option value="pc">Printer : PC ( Laptop / Komputer )</option>
                    </select>
                </div>
                <div class="col-12 formPrinterModePc">
                    <label for="" class=""><b>App Key</b></label>
                    <input type="text" class="form-control" id="rectaHostAppKey" placeholder="Masukan 'App Key' recta host ..">
                </div>
                <div class="col-12 formPrinterModePc">
                    <label for="" class=""><b>App Port</b></label>
                    <input type="text" class="form-control" id="rectaHostAppPort" placeholder="Masukan 'App Port' recta host ..">
                </div>
              </div>
                
            </div>
          </div>
          <div class="modal-footer">
            <a class="btn btn-info" href="{{ asset('printer-thermal/tutorial-setting-printer.txt') }}" target="_blank" rel="noopener noreferrer">Tutorial Install&emsp;<i class="ti ti-album"></i></a>
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup&emsp;<i class="ti ti-x"></i></button>
          </div>
        </form>
      </div>
    </div>
</div>

<script src="{{ asset('printer-thermal/recta.js') }}"></script>
<script>
    // =====================================
    // SCRIPT PRINTER THERMAL SETTING
    // =====================================
    
    // PRINT HP (RAWBT) ( https://www.rawbt.ru/start.html )
    function printNotaPembelian(HTMLarea) {
        $('#html_print').html('');
        $('#html_print').html(HTMLarea);
        var element = document.getElementById('html_print').innerText
        PrintNota(element);
    }
    function PrintNota(HTMLarea){
        var S = "#Intent;scheme=rawbt;";
        var P =  "package=ru.a402d.rawbtprinter;end;";
        var textEncoded = encodeURI(HTMLarea);        
        window.location.href="intent:"+textEncoded+S+P;
        $('#html_print').html('');
    }

    // UNTUK BUKA CASH DRAWER SETELAH PRINT (OTOMATIS)
    function PrintNotaWithCashDrawer(HTMLarea) {
        var S = "#Intent;scheme=rawbt;";
        var P = "package=ru.a402d.rawbtprinter;end;";
        // Perintah ESC/POS untuk membuka laci
        var openDrawerCommand = String.fromCharCode(27, 112, 0); // Sesuaikan dengan perintah yang benar untuk perangkat Anda
        // Tambahkan perintah membuka laci ke HTMLarea
        var htmlWithOpenDrawer = HTMLarea + openDrawerCommand;
        var textEncoded = encodeURI(htmlWithOpenDrawer);
        window.location.href = "intent:" + textEncoded + S + P;

        $('#html_print').html('');
    }
    
    // PRINT PC (RECTA HOST)
    function printReceiptRectaHost(list_data_belanja, id_transaksi, total_belanja, total_bayar, kembalian, timestamp, pembeli, nama_toko, alamat_toko, toast_message) {
        var app_key = $('#rectaHostAppKey').val();
        var app_port = $('#rectaHostAppPort').val();
        customConfirm("Cetak Nota ?","Anda dapat mencetak ulang nota pembelian pada menu data pembelian.").then((confirmed) => { 
            if(confirmed) {
                toastSuccess(toast_message);

                // Jumlah dash yang diinginkan
                // Buat string dash dengan mengulang karakter '-' sebanyak jumlah yang diinginkan
                var jumlahDash = 16;
                var dash = "- ".repeat(jumlahDash);
                console.log(dash);
    
                var printer = new Recta(app_key, app_port);
    
                printer.open().then(function () {
                    printer.align('left')
                        .text(nama_toko+' - '+alamat_toko)
                        .text(dash)
                        .text(id_transaksi)
                        .text(timestamp)
                        .text('')
                        .text(dash)
                    
                    // Loop untuk setiap item belanja
                    list_data_belanja.forEach(function (item) {
                        var nomor = item.nomor;
                        var nama_barang = item.nama_barang;
                        var total_qty = item.total_qty;
                        var satuan = item.satuan;
                        var harga = item.harga;
                        var sub_total_harga = parseInt(total_qty) * parseInt(harga);
    
                        printer.text(nama_barang+' ('+satuan+')')
                            .text(total_qty+' x '+harga+' : '+formatRupiah(sub_total_harga))
                            .text('')
                    });
    
                    printer.text(dash)
                        .text('PEMBELI : '+pembeli)
                        .text('')
                        .text(dash)
                        .text('TOTAL : '+formatRupiah(total_belanja))
                        .text('BAYAR : '+formatRupiah(total_bayar))
                        .text('KEMBALI : '+formatRupiah(kembalian))
                        .text('')
                        .text(dash)
                        .cut()
                        .print();
                });
            }
        });
    }

    // STATUS PRINTER (LOCAL STORAGE)
    function saveToLocalStorage() {
        var selectedValue = $('#ModePrinter').val();
        var rectaHostAppKey = $('#rectaHostAppKey').val();
        var rectaHostAppPort = $('#rectaHostAppPort').val();

        localStorage.setItem('printerMode', selectedValue);
        localStorage.setItem('rectaHostAppKey', rectaHostAppKey);
        localStorage.setItem('rectaHostAppPort', rectaHostAppPort);
    } 
    function loadFromLocalStorage() {
        var savedValue = localStorage.getItem('printerMode');
        var savedRectaHostAppKey = localStorage.getItem('rectaHostAppKey');
        var savedRectaHostAppPort = localStorage.getItem('rectaHostAppPort');
        if (savedValue) {
            $('#ModePrinter').val(savedValue);
        }
        if (savedRectaHostAppKey) {
            $('#rectaHostAppKey').val(savedRectaHostAppKey);
        }
        if (savedRectaHostAppPort) {
            $('#rectaHostAppPort').val(savedRectaHostAppPort);
        }
    }
    $(document).ready(function() {
        loadFromLocalStorage();
        // Tambahkan event listener untuk menyimpan nilai saat elemen berubah
        $('#ModePrinter').on('change', function() {
            saveToLocalStorage();
        });
        $('#rectaHostAppKey').on('input', function() {
            saveToLocalStorage();
        });
        $('#rectaHostAppPort').on('input', function() {
            saveToLocalStorage();
        });
        
        // atur printer value (local storage)
        eventChangePrinterValues();

        
    });

    // ON CHANGE PRNTER (DETAIL & DESKRIPSI)
    $(document).on('change','#ModePrinter', function() {
        eventChangePrinterValues();
    }); 
    function eventChangePrinterValues() {
        var keteranganPrinter = $('#keteranganPrinter');
        var btnDokumentasiPrinterTool = $('#btnDokumentasiPrinterTool');
        var formPrinterModePc = $('.formPrinterModePc');
        var mode_printer = $('#ModePrinter').val();
        
        if(mode_printer == 'hp') {
            keteranganPrinter.html(
                `<i class="ti ti-info-circle fs-5 me-2 flex-shrink-0 text-primary"></i>
                Gunakan aplikasi RAWBT untuk melakukan cetak menggunakan perangkat HP (android,tab,IOS, dll)`
            );
            btnDokumentasiPrinterTool.attr('href','https://rawbt.ru/');
            btnDokumentasiPrinterTool.html('<u>Lihat dokumentasi (RAWBT)</u>');
            btnDokumentasiPrinterTool.attr('hidden',false);
            formPrinterModePc.attr('hidden',true);
    
        } else if(mode_printer == 'pc') {
    
            keteranganPrinter.html(
                `<i class="ti ti-info-circle fs-5 me-2 flex-shrink-0 text-primary"></i>
                Untuk melakukan print pada Laptop / PC (windows) anda harus menginstall aplikasi Recta Host`
            );
            btnDokumentasiPrinterTool.attr('href','https://github.com/adenvt/recta');
            btnDokumentasiPrinterTool.html('<u>Lihat dokumentasi (RECTA-HOST)</u>');
            btnDokumentasiPrinterTool.attr('hidden',false);
            formPrinterModePc.attr('hidden',false);
            
        } else {
    
            keteranganPrinter.html(
                `<i class="ti ti-info-circle fs-5 me-2 flex-shrink-0 text-primary"></i>
                Aplikasi support dengan jenis printer thermal apapun, jika menggunakan android / tab / IOS printer harus support bluetooth`
            );
            btnDokumentasiPrinterTool.attr('href','javadcript:void(0)');
            btnDokumentasiPrinterTool.html('<u>Pilih jenis printer</u>');
            btnDokumentasiPrinterTool.attr('hidden',true);
            formPrinterModePc.attr('hidden',true);
            toastError("Mohon pilih mode printer sesuai device yang digunakan!");
            $('#ModalPengaturanPrinter').modal('show');
        }

    }

</script>