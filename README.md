## Aplikasi Kasir POS & Inventory

### Deskripsi
Aplikasi Kasir POS & Inventory merupakan sistem manajemen penjualan dan persediaan stok barang, dirancang untuk memperlancar operasi bisnis ritel (cocok untuk toko sembako / kelontong). Dengan aplikasi ini, bisnis dapat dengan mudah mengelola transaksi penjualan, melacak tingkat persediaan secara real-time, menghasilkan dashboard yang informatif, dan banyak lagi.

### Fitur
- **Multi Satuan**: Mendukung pengelolaan produk dengan beberapa satuan : misal penjualan telur (1/2 Kg, 1/4 Kg, 1 Kg), stiker (1 Meter, 1 Cm, dll) memudahkan dalam pengaturan inventaris.
- **Dukungan Thermal Printer**: Kompatibel dengan printer termal untuk mencetak struk transaksi pada perangkat Android dan PC.
- **Custom Nama Toko & Alamat**: Memungkinkan untuk menyesuaikan nama toko dan alamat sesuai kebutuhan bisnis.
- **Buka Cashdrawer Otomatis**: (Masih dalam proses pengembangan) Fitur untuk membuka laci kas secara otomatis saat transaksi selesai.
- **Manajemen Pengguna**: (Masih dalam proses pengembangan) Membuat akun pengguna dengan tingkat akses yang berbeda untuk mengontrol izin sistem.

### Teknologi yang Digunakan
- **Backend**: Laravel
- **Frontend**: Javascript, Boostrap
- **Database**: MySQL
- **Dukungan Hardware**: Thermal Printer (Android & PC)

### Instalasi
1. Clone repository: `git clone https://github.com/ali819/kasir.git`
2. Masuk ke direktori proyek: `cd kasir`
3. Instal dependensi: `composer install`
4. Salin file `.env.example` dan ubah nama menjadi `.env`.
5. Konfigurasi koneksi database di file `.env`.
6. Jalankan migrasi untuk membuat tabel: `php artisan migrate`
7. Jalankan aplikasi: `php artisan serve`

### Penggunaan
1. Akses aplikasi melalui browser web di `http://localhost:8000`.
2. Masuk dengan kredensial Anda atau daftar untuk akun baru ( silahkan hilangkan disabled HTML button register pada login.blade.php ).
3. Mulai mengelola penjualan, inventaris, sesuai kebutuhan bisnis Anda.

### Kontributor
- Ali (@ali819)

### Lisensi
Proyek ini dilisensikan di bawah Lisensi MIT. Lihat file [LICENSE](LICENSE) untuk detailnya.

### Dukungan
Untuk pertanyaan atau bantuan, silakan hubungi [ali.sabana819@gmail.com](mailto:alisabana819@gmail.com).

### Roadmap
- Menyelesaikan pengembangan fitur buka cashdrawer otomatis.
- Menambahkan dukungan untuk pembayaran online.
- Mengimplementasikan desain responsif untuk penggunaan yang lebih baik pada perangkat mobile.
