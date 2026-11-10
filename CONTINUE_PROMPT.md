# PROMPT LANJUTAN SISTEM INFORMASI KLINIK — STATUS: SEDANG BERJALAN

Proyek Laravel "Sistem Informasi Klinik Berbasis Web" (SPK Proyek Kejuruan PPLG XII, `C:\laragon\www\Project 3 (DSKD)`).
Database: MySQL `db_klinik`. Template: Bootstrap 5 + Bootstrap Icons via CDN (tanpa Vite/Breeze).

## Akun default (seeder)
- Admin : `admin@klinik.test` / `password`
- Dokter : `dokter@klinik.test` / `password`
- Pasien : `pasien@klinik.test` / `password`

## Struktur
- **Role**: `admin` (Admin/Petugas), `dokter`, `pasien` — middleware `role:` di `app/Http/Middleware/CheckRole.php`.
- **Model** (15): `User, Role, Pasien, Dokter, JadwalDokter, Pendaftaran, Antrian, Tindakan, Obat, Pemeriksaan, PemeriksaanTindakan, Resep, DetailResep, Pembayaran, DetailPembayaran`.
- **Controller** di `app/Http/Controllers/`: `Auth/AuthController` (login/logout), `DashboardController` (per role), `PasienController` (CRUD + pencarian nama/NIK/no_rm), `DokterController`, `JadwalDokterController` (Cegah jadwal bertabrakan), `TindakanController`, `ObatController`, `PendaftaranController` (membuat nomor pendaftaran + antrean), `AntrianController` (status menunggu/dipanggil/diperiksa/selesai/batal), `PemeriksaanController` (dokter; scoped ke jadwal dokter sendiri; menyimpan `pendaftaran_id` agar total pembayaran benar), `RekamMedisController`, `ResepController` (potong stok otomatis, cegah stok minus, ada cetak resep), `PembayaranController` (total otomatis dari tindakan+obat, filter dokter & periode, cetak struk), `LaporanController` (8 jenis: pasien, dokter, pendaftaran, antrean, pemeriksaan, rekam medis, obat, pembayaran; filter periode; cetak).
- **Routes**: `routes/web.php` lengkap.
- **Views**: `resources/views/{dashboard, pasien, dokter, jadwal, tindakan, obat, pendaftaran, antrian, pemeriksaan, rekam_medis, resep, pembayaran, laporan, pasien_portal, auth}` + `layouts/{app, sidebar, header, footer, print}`.

## Verifikasi terakhir (berhasil)
- `php artisan test` = 14 passed, 74 assertions.
  - `tests/Feature/SmokeTest.php` — render semua halaman per role + hak akses (403).
  - `tests/Feature/Auth/AuthenticationTest.php` — login/logout.
  - `tests/Feature/KlinikFlowTest.php` — alur lengkap pendaftaran→antrean→pemeriksaan→resep→pembayaran (total = tindakan + obat sesuai stok), jadwal bertabrakan ditolak, jadwal valid diterima.
- `php artisan migrate:fresh --seed` — sukses ke `db_klinik`.
- `php artisan serve` — `/login` 200, login admin 302→`/dashboard` 200 ("Dashboard Admin"), `/pasien` & `/laporan?jenis=antrean` 200.

## Catatan penting
- `pemeriksaan.pendaftaran_id` WAJIB terisi (diisi dari antrian saat store) — pembayaran menghitung total dari relasi ini.
- Jam jadwal disimpan `datetime:H:i` → ditampilkan "08:00". Cek tabrakan via `where('jam_mulai', '<', selesai)->where('jam_selesai', '>', mulai)`.
- `sidebar.blade.php` memakai closure `$isActive(...)`, bukan function global (menghindari "Cannot redeclare isActive" saat multi-request PHPUnit).

## Yang tersisa (opsional)
- Uji visual via browser untuk tiap role; perbaiki styling view yang masih memakai kelas Tailwind (mis. `laporan/*`, `resep/*`, `pembayaran/*`) agar konsisten dengan Bootstrap.
- Tambahkan cetak data pasien (`pasien_cetak`) jika penguji menghendaki.
- Jalankan `vendor\bin\pint` untuk format ulang bila perlu.