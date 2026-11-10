# DOKUMEN SRS
## SOFTWARE REQUIREMENTS SPECIFICATION
### SISTEM INFORMASI TOKO MOTOR ONLINE BERBASIS WEB
### (Toko Motor Online)

---

## 1. PENDAHULUAN

### 1.1 Latar Belakang

Perkembangan teknologi digital telah mengubah pola bisnis secara signifikan, termasuk dalam sektor perdagangan ritel. Masyarakat semakin beralih ke platform _online_ untuk memenuhi kebutuhan belanja sehari-hari, mulai dari kebutuhan pokok hingga produk spesifik seperti suku cadang kendaraan, aksesoris, dan perlengkapan otomotif. Bisnis _e-commerce_ menawarkan kemudahan akses, efisiensi waktu, serta jangkauan pasar yang lebih luas dibandingkan toko konvensional.

Namun, tidak sedikit pelaku usaha khususnya UKM yang masih mengalami kendala dalam mengadopsi sistem penjualan _online_ secara mandiri. Beberapa permasalahan yang sering muncul antara lain: pengelolaan stok barang yang masih manual, pencatatan pesanan yang tidak terstruktur, kesulitan dalam memantau pembayaran, belum adanya sistem pelaporan penjualan yang terintegrasi, dan minimnya fitur pencarian serta perbandingan spesifikasi motor. Akibatnya, proses bisnis menjadi tidak efisien, rawan kesalahan pencatatan, dan sulit untuk dievaluasi.

Oleh karena itu, diperlukan sebuah sistem informasi toko motor _online_ yang mampu mengelola seluruh siklus penjualan secara digital—mulai dari katalog produk, keranjang belanja, proses _checkout_, pembayaran, hingga manajemen stok motor dan laporan penjualan. Sistem Informasi Toko Motor Online Berbasis Web ini dikembangkan untuk menjawab kebutuhan tersebut dengan menyediakan platform yang terintegrasi, mudah digunakan, dan dapat diakses kapan saja melalui _browser_.

### 1.2 Tujuan Dokumen SRS

Dokumen _Software Requirements Specification_ (SRS) ini bertujuan untuk mendefinisikan kebutuhan fungsional dan non-fungsional dari Sistem Informasi Toko Motor Online. Dokumen ini menjadi acuan utama dalam proses perancangan, implementasi, dan pengujian sistem, sehingga seluruh _stakeholder_ memiliki pemahaman yang sama mengenai sistem yang akan dikembangkan.

### 1.3 Ruang Lingkup Sistem

Sistem ini mencakup pengelolaan produk motor dan kategori, transaksi penjualan (_shopping cart_ dan _checkout_), manajemen stok motor, pengelolaan pesanan dan pembayaran, serta penyajian laporan penjualan dan stok. Sistem dikembangkan dalam bentuk aplikasi web dengan dua peran pengguna: **Admin** (pengelola toko) dan **Pelanggan** (pembeli).

### 1.4 Definisi, Akronim, dan Singkatan

| Istilah | Definisi |
|---------|----------|
| SRS | _Software Requirements Specification_ |
| Admin | Pengelola sistem dari pihak toko motor |
| Pelanggan | Pengguna yang melakukan pembelian motor/produk |
| Midtrans | _Payment gateway_ pihak ketiga untuk pemrosesan pembayaran _online_ |
| Snap Token | Token autentikasi dari Midtrans untuk membuka halaman pembayaran |
| CRUD | _Create, Read, Update, Delete_ — operasi dasar pengelolaan data |
| UI | _User Interface_ — antarmuka pengguna |
| Webhook | Mekanisme notifikasi otomatis dari pihak ketiga ke server |

---

## 2. DESKRIPSI UMUM SISTEM

### 2.1 Gambaran Umum Sistem

Sistem Informasi Toko Motor Online merupakan aplikasi web yang digunakan untuk mengelola dan memfasilitasi transaksi jual-beli motor dan perlengkapannya secara _online_. Sistem ini memungkinkan pelanggan untuk melihat katalog produk, menambah produk ke keranjang belanja, melakukan _checkout_, dan membayar melalui _payment gateway_ Midtrans atau _upload_ bukti pembayaran manual. Di sisi lain, admin dapat mengelola data produk, kategori, stok barang, memverifikasi pesanan dan pembayaran, serta melihat laporan penjualan dan stok secara _real-time_.

### 2.2 Karakteristik Pengguna

Pengguna sistem terdiri dari dua peran:

1. **Admin (Pengelola Toko)**
   - Memiliki akses penuh ke seluruh fitur manajemen.
   - Bertanggung jawab mengelola produk, kategori, stok, pesanan, dan pembayaran.
   - Dapat melihat dan mengekspor laporan penjualan serta stok.
   - Memiliki pemahaman dasar tentang pengoperasian komputer dan _browser_.

2. **Pelanggan (Pembeli)**
   - Mendaftar dan masuk ke sistem untuk melakukan pembelian.
   - Menelusuri katalog produk, mengelola keranjang belanja, dan melakukan _checkout_.
   - Dapat memantau status pesanan dan riwayat pembelian.
   - Dapat mengelola alamat pengiriman sendiri.
   - Memiliki kemampuan dasar menggunakan _browser_ dan internet.

### 2.3 Lingkungan Operasional

| Komponen | Spesifikasi |
|----------|-------------|
| **Sisi Server** | PHP ^8.3, Laravel 13, SQLite/MySQL |
| **Sisi Klien (Web)** | _Browser_ modern (Chrome, Firefox, Edge, Safari) |
| **Sistem Operasi Server** | Linux / Windows Server |
| **Jaringan** | Terhubung melalui internet |
| **Payment Gateway** | Midtrans Snap (mendukung _bank transfer, GO-PAY, ShopeePay_) |

### 2.4 Batasan Sistem

- Sistem tidak mencakup modul pengiriman (_shipping_/_courier_).
- Sistem tidak terintegrasi langsung dengan sistem akuntansi atau ERP eksternal.
- Sistem tidak menyediakan aplikasi _mobile native_; seluruh akses dilakukan melalui _browser_.
- Sistem hanya berfokus pada penjualan motor dan produk terkait secara ritel, bukan _wholesale_ atau _dropshipping_.
- Fitur ekspor laporan masih berupa _placeholder_ dan belum terimplementasi penuh.

---

## 3. KEBUTUHAN FUNGSIONAL

### 3.1 Kebutuhan Fungsional Admin

| Kode | Deskripsi |
|------|-----------|
| **ADM-01** | Sistem harus menyediakan fitur _login_ untuk admin. |
| **ADM-02** | Sistem harus menampilkan _dashboard_ dengan statistik: total produk, pelanggan, pesanan, pendapatan, stok minimum, dan grafik penjualan 7 hari. |
| **ADM-03** | Sistem harus memungkinkan admin mengelola data **kategori** (tambah, lihat, ubah, hapus). |
| **ADM-04** | Sistem harus memungkinkan admin mengelola data **produk** (tambah, lihat, ubah, hapus) termasuk _upload_ gambar produk dan pemilihan kategori. |
| **ADM-05** | Sistem harus memungkinkan admin mencatat **stok masuk** (_stock in_) dari pemasok. |
| **ADM-06** | Sistem harus memungkinkan admin mencatat **stok keluar** (_stock out_) karena rusak/hilang/kadaluarsa. |
| **ADM-07** | Sistem harus menyediakan riwayat stok (_stock history_) untuk setiap produk. |
| **ADM-08** | Sistem harus menampilkan daftar **pesanan** dan detail pesanan. |
| **ADM-09** | Sistem harus memungkinkan admin mengubah status pesanan (_pending → processed → shipped → completed_ atau _cancelled_). |
| **ADM-10** | Sistem harus menampilkan daftar **pembayaran** yang perlu diverifikasi. |
| **ADM-11** | Sistem harus memungkinkan admin memverifikasi atau menolak pembayaran manual (_proof upload_). |
| **ADM-12** | Sistem harus menyediakan **laporan stok** yang dapat disaring berdasarkan kategori dan status. |
| **ADM-13** | Sistem harus menyediakan **laporan penjualan** dengan filter rentang tanggal dan produk terlaris. |
| **ADM-14** | Sistem harus menyediakan fitur **logout** untuk admin. |

### 3.2 Kebutuhan Fungsional Pelanggan

| Kode | Deskripsi |
|------|-----------|
| **CST-01** | Sistem harus menyediakan fitur **registrasi** akun baru. |
| **CST-02** | Sistem harus menyediakan fitur **login** untuk pelanggan. |
| **CST-03** | Sistem harus menampilkan **katalog motor/produk** dengan pencarian, filter kategori, filter tahun produksi, filter merek, dan pengurutan (_latest, price asc/desc, name_). |
| **CST-04** | Sistem harus menampilkan **detail produk** termasuk produk terkait dari kategori yang sama. |
| **CST-05** | Sistem harus memungkinkan pelanggan menambah produk ke **keranjang belanja**. |
| **CST-06** | Sistem harus memungkinkan pelanggan mengubah kuantitas dan menghapus item di keranjang. |
| **CST-07** | Sistem harus melakukan **validasi stok** saat menambah ke keranjang dan saat _checkout_. |
| **CST-08** | Sistem harus menampilkan halaman **checkout** yang menampilkan ringkasan pesanan, alamat pengiriman, dan metode pembayaran. |
| **CST-09** | Sistem harus membuat **pesanan baru** saat _checkout_ dan mengurangi stok produk secara otomatis. |
| **CST-10** | Sistem harus menghasilkan **nomor pesanan** unik dengan format `ORD-YYYYMMDD-XXXX`. |
| **CST-11** | Sistem harus menyediakan pembayaran melalui **Midtrans Snap** (pop-up pembayaran). |
| **CST-12** | Sistem harus memungkinkan pelanggan **mengunggah bukti pembayaran** manual. |
| **CST-13** | Sistem harus menampilkan **riwayat pesanan** pelanggan. |
| **CST-14** | Sistem harus menampilkan **detail pesanan** termasuk status pembayaran dan status pengiriman. |
| **CST-15** | Sistem harus memungkinkan pelanggan **membatalkan pesanan** (dengan pengembalian stok otomatis). |
| **CST-16** | Sistem harus memungkinkan pelanggan mengelola **alamat pengiriman** (tambah, ubah, hapus). |
| **CST-17** | Sistem harus memungkinkan pelanggan memperbarui **profil** (nama dan email). |
| **CST-18** | Sistem harus menyediakan fitur **logout** untuk pelanggan. |

### 3.3 Kebutuhan Fungsional Umum

| Kode | Deskripsi |
|------|-----------|
| **GEN-01** | Sistem harus menyimpan seluruh data ke dalam basis data terpusat. |
| **GEN-02** | Sistem harus menampilkan informasi sesuai hak akses pengguna (_role-based_). |
| **GEN-03** | Sistem harus menyediakan fitur _forgot password_ dan _reset password_. |
| **GEN-04** | Sistem harus menyediakan fitur verifikasi email (_email verification_). |
| **GEN-05** | Sistem harus menyediakan halaman _error_ 404 (_not found_). |
| **GEN-06** | Sistem harus menangani notifikasi pembayaran dari Midtrans melalui **webhook** dengan verifikasi tanda tangan SHA-512. |
| **GEN-07** | Webhook Midtrans harus secara otomatis memperbarui status pesanan dan pembayaran saat transaksi sukses/gagal/expired. |
| **GEN-08** | Webhook Midtrans harus mengembalikan stok produk secara otomatis saat transaksi dibatalkan/expired/gagal. |

---

## 4. KEBUTUHAN NON-FUNGSIONAL

### 4.1 Kebutuhan Keamanan

| Kode | Deskripsi |
|------|-----------|
| **NFR-01** | Sistem harus menggunakan autentikasi pengguna (_login_ dengan email dan _password_). |
| **NFR-02** | _Password_ pengguna harus di-_hash_ dan disimpan secara aman menggunakan algoritma bcrypt. |
| **NFR-03** | Sistem harus menerapkan **CSRF Protection** pada seluruh form (kecuali _endpoint_ webhook). |
| **NFR-04** | Sistem harus menerapkan **role-based middleware** (admin dan pelanggan) untuk membatasi akses. |
| **NFR-05** | Sistem harus melakukan validasi kepemilikan (_ownership check_) pada seluruh sumber daya pelanggan. |
| **NFR-06** | Sistem harus memvalidasi tipe dan ukuran file yang diunggah (gambar produk dan bukti pembayaran). |
| **NFR-07** | Webhook Midtrans harus memverifikasi tanda tangan (_signature_) menggunakan algoritma SHA-512. |

### 4.2 Kebutuhan Kinerja

| Kode | Deskripsi |
|------|-----------|
| **NFR-08** | Sistem harus mampu memproses _input_ data dengan waktu respons di bawah 3 detik untuk operasi normal. |
| **NFR-09** | Sistem harus dapat diakses oleh beberapa pengguna secara bersamaan (minimal 50 pengguna konkuren). |
| **NFR-10** | Halaman katalog produk dengan paginasi harus dimuat dalam waktu kurang dari 2 detik. |

### 4.3 Kebutuhan _Usability_

| Kode | Deskripsi |
|------|-----------|
| **NFR-11** | Antarmuka sistem harus mudah dipahami oleh pengguna non-teknis. |
| **NFR-12** | Sistem harus memiliki navigasi yang sederhana, konsisten, dan responsif. |
| **NFR-13** | Sistem harus menampilkan pesan _error_ yang informatif dan jelas bagi pengguna. |
| **NFR-14** | Sistem harus menggunakan antarmuka berbahasa Indonesia. |

### 4.4 Kebutuhan Keandalan

| Kode | Deskripsi |
|------|-----------|
| **NFR-15** | Sistem harus menyimpan data secara konsisten tanpa kehilangan data. |
| **NFR-16** | Sistem harus menggunakan **transaksi basis data** pada operasi kritis (_checkout_, stok masuk/keluar). |
| **NFR-17** | Sistem harus dapat berjalan stabil selama 24 jam tanpa _downtime_ yang dijadwalkan. |
| **NFR-18** | Sistem harus memulihkan stok secara otomatis saat pesanan dibatalkan atau transaksi gagal. |

### 4.5 Kebutuhan Kompatibilitas

| Kode | Deskripsi |
|------|-----------|
| **NFR-19** | Sistem harus kompatibel dengan _browser_ modern: Google Chrome, Mozilla Firefox, Microsoft Edge, dan Safari. |
| **NFR-20** | Sistem harus menampilkan antarmuka yang responsif pada perangkat _desktop_ dan _tablet_. |

---

## 5. KEBUTUHAN ANTARMUKA

### 5.1 Antarmuka Pengguna (_User Interface_)

#### 5.1.1 Halaman Publik
- Halaman **Beranda** — menampilkan motor unggulan, produk terkait, kategori terbaru, dan statistik toko.
- Halaman **404** — menampilkan pesan kesalahan saat halaman tidak ditemukan.

#### 5.1.2 Halaman Pelanggan
- **Login & Registrasi** — formulir masuk dan pendaftaran akun.
- **Katalog Motor/Produk** — daftar motor/produk dengan grid, filter kategori, filter merek, filter tahun, pencarian, dan paginasi (12 per halaman).
- **Detail Motor/Produk** — informasi lengkap motor/produk termasuk spesifikasi dan produk terkait.
- **Keranjang Belanja** — daftar item dengan kuantitas, harga, dan total.
- **Checkout** — ringkasan pesanan, pilih alamat, pilih metode pembayaran.
- **Pembayaran** — pop-up Midtrans Snap atau _upload_ bukti bayar.
- **Riwayat Pesanan** — daftar pesanan dengan status dan paginasi.
- **Detail Pesanan** — informasi lengkap pesanan, item, status, dan tombol aksi.
- **Alamat Pengiriman** — CRUD alamat pengiriman.
- **Profil** — ubah nama dan email.

#### 5.1.3 Halaman Admin
- **Dashboard** — kartu statistik dan grafik penjualan.
- **Kategori** — tabel daftar kategori dengan tombol tambah/ubah/hapus.
- **Motor/Produk** — tabel daftar motor/produk dengan _upload_ gambar, spesifikasi, filter kategori, filter merek.
- **Stok Masuk** — formulir dan riwayat stok masuk dari pemasok.
- **Stok Keluar** — formulir dan riwayat stok keluar.
- **Pesanan** — tabel daftar pesanan dengan aksi ubah status.
- **Pembayaran** — daftar pembayaran menunggu verifikasi.
- **Laporan Stok** — tabel stok dengan filter.
- **Laporan Penjualan** — tabel penjualan dengan filter tanggal.

### 5.2 Antarmuka Perangkat Lunak

| Komponen | Deskripsi |
|----------|-----------|
| **Framework Backend** | Laravel 13 — arsitektur MVC dengan _service layer_ (`CartService`, `OrderService`, `StockService`, `MidtransService`). |
| **Frontend** | Tailwind CSS 3 untuk _styling_, Alpine.js 3 untuk interaktivitas frontend. |
| **Basis Data** | SQLite (pengembangan) / MySQL (produksi) — basis data relasional. |
| **Payment Gateway** | Midtrans Snap API — komunikasi melalui HTTP dengan _Snap Token_. |
| **Webhook** | Midtrans mengirim notifikasi HTTP POST ke `/midtrans/webhook` dengan payload JSON. |
| **Vite** | _Build tool_ untuk kompilasi aset frontend (CSS, JS). |

### 5.3 Tabel Basis Data

Sistem menggunakan 15 tabel utama:

| Tabel | Fungsi |
|-------|--------|
| `users` | Data pengguna (admin dan pelanggan) dengan _role_ _enum_ |
| `categories` | Data kategori produk |
| `suppliers` | Data pemasok |
| `products` | Data motor/produk dengan relasi ke kategori, merek, tahun, spesifikasi |
| `carts` | Data keranjang belanja per pengguna |
| `cart_items` | Item di dalam keranjang |
| `shipping_addresses` | Alamat pengiriman pelanggan |
| `orders` | Data pesanan dengan status dan nomor unik |
| `order_items` | Item di dalam pesanan |
| `payments` | Data pembayaran (Midtrans dan manual) |
| `stock_ins` | Riwayat stok masuk |
| `stock_outs` | Riwayat stok keluar |
| `stock_histories` | Riwayat perubahan stok (mutasi) |
| `sessions` | Sesi pengguna |
| `password_reset_tokens` | Token _reset password_ |

---

## 6. KEBUTUHAN TEKNOLOGI DAN LINGKUNGAN PENGEMBANGAN

### 6.1 _Stack_ Teknologi

| Lapisan | Teknologi |
|---------|-----------|
| **Bahasa Pemrograman** | PHP ^8.3 |
| **Framework Backend** | Laravel 13 |
| **Database** | SQLite / MySQL |
| **CSS Framework** | Tailwind CSS 3 |
| **JavaScript Framework** | Alpine.js 3 |
| **Build Tool** | Vite 8 (via laravel-vite-plugin) |
| **Payment Gateway** | Midtrans (midtrans-php 2.6) |
| **HTTP Client** | Axios |
| **Testing** | PHPUnit, Laravel Feature Tests |
| **Code Style** | Laravel Pint |

### 6.2 Ketergantungan (_Dependencies_) Utama

| Paket | Versi | Kegunaan |
|-------|-------|----------|
| `laravel/framework` | ^13.7 | Kerangka kerja aplikasi |
| `laravel/breeze` | ^2.4 | _Scaffolding_ autentikasi |
| `midtrans/midtrans-php` | ^2.6 | Integrasi payment gateway |
| `tailwindcss/forms` | ^0.5.0 | _Styling_ formulir Tailwind |

---

## 7. ASUMSI DAN KETENTUAN LAIN

1. Sistem diasumsikan digunakan oleh pengguna yang telah memiliki pengetahuan dasar tentang penggunaan _browser_ dan internet.
2. Koneksi internet yang stabil diperlukan untuk mengakses sistem dan melakukan pembayaran melalui Midtrans.
3. Pengembangan sistem dilakukan dalam lingkup akademik sebagai bagian dari Proyek Perangkat Lunak dan dapat dikembangkan lebih lanjut di masa mendatang.
4. Data produk awal (_seeder_) disediakan untuk keperluan pengujian dan demonstrasi.
5. Fitur ekspor laporan (_export stock_ dan _export sales_) masih berupa _placeholder_ dan akan diimplementasikan pada tahap pengembangan berikutnya.
6. Sistem tidak menyertakan fitur _chat_ atau komunikasi _real-time_ antara pelanggan dan admin.

---

## 8. DAFTAR PUSTAKA

1. Laravel Documentation. _Laravel 13.x_. https://laravel.com/docs/
2. Midtrans Documentation. _Midtrans Snap API_. https://docs.midtrans.com/
3. Tailwind CSS. _Documentation_. https://tailwindcss.com/docs/
4. Alpine.js. _Documentation_. https://alpinejs.dev/docs
