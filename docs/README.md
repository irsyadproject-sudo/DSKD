# DPMS — Use Case Diagram & Flowchart

## Ringkasan Sistem

**Digital Project Management System (DPMS)** adalah aplikasi web berbasis Laravel untuk mengelola proyek, task, tim, dan komunikasi antara Project Manager, Team Member, dan Client.

---

## Aktor (4 Role)

| # | Role | Keterangan |
|---|------|------------|
| 1 | **Super Admin** | Akses penuh ke seluruh fitur sistem |
| 2 | **Project Manager (PM)** | Mengelola proyek, client, task, dan laporan |
| 3 | **Team Member** | Mengerjakan task yang ditugaskan, update progress |
| 4 | **Client** | Melihat proyek, approve task, ajukan revisi |

---

## Use Case Diagram

File: `docs/use-case-diagram.puml` (PlantUML)

### Aktor → Fitur

#### Super Admin
| Use Case | Keterangan |
|----------|------------|
| Login / Logout | Autentikasi |
| Dashboard | Statistik seluruh sistem |
| Manajemen User | CRUD lengkap semua role |
| Manajemen Client | CRUD client |
| Manajemen Proyek | CRUD proyek + anggota tim |
| Manajemen Task | CRUD task + update progress |
| Kanban Board | Lihat & pindahkan task antar kolom |
| File Management | Upload / download / hapus file |
| Komentar | Tambah / hapus komentar |
| Revisi | Lihat & ubah status revisi |
| Laporan | Lihat & export CSV/PDF |
| Profil | Lihat & edit profil |

#### Project Manager
| Use Case | Keterangan |
|----------|------------|
| Manajemen Client | CRUD client |
| Manajemen Proyek | CRUD proyek yang dikelola + anggota |
| Manajemen Task | CRUD task dalam proyek sendiri |
| Kanban Board | Drag & drop task |
| File Management | Upload / download / hapus |
| Komentar | Tambah / hapus komentar |
| Revisi | Lihat & proses revisi |
| Laporan | Lihat & export CSV/PDF |

#### Team Member
| Use Case | Keterangan |
|----------|------------|
| Lihat Proyek | Lihat proyek yang diikuti |
| Task Management | Lihat, edit, update progress task |
| Kanban Board | Drag & drop task |
| File Management | Upload / download file |
| Komentar | Tambah / hapus komentar |
| Revisi | Lihat & proses revisi (yang ditugaskan) |

#### Client
| Use Case | Keterangan |
|----------|------------|
| Register | Daftar akun baru (otomatis role client) |
| Lihat Proyek | Lihat proyek sendiri |
| Buat Proyek | Buat proyek baru |
| Kanban Board | Lihat board (read-only) |
| Download File | Unduh file dari proyek |
| Komentar | Tambah / hapus komentar |
| Ajukan Revisi | Kirim permintaan revisi |
| Approve Task | Setujui task yang selesai |
| Laporan | Lihat & export CSV/PDF |

---

## Flowchart (6 Alur Utama)

### 1. Login & Registrasi
File: `docs/flow-login-register.puml`

```
User → /login
  ├── Sudah akun? → Input email+password → Valid? → Dashboard
  └── Belum akun (Client) → /register → Input data → Simpan User+Client → Auto-login → Dashboard
```

### 2. Manajemen Proyek
File: `docs/flow-proyek.puml`

```
PM/SA/Client → Daftar Proyek
  ├── Tambah → Isi form → Simpan → Proyek baru
  ├── Detail → Lihat info, anggota, task, file
  ├── Edit → Ubah field → Update
  ├── Ubah Status → Draft/Berjalan/Review/Selesai
  ├── Kelola Anggota → Tambah/hapus Team Member
  └── Hapus → Konfirmasi → Data terhapus
```

### 3. Manajemen Task
File: `docs/flow-task.puml`

```
PM/SA → Tambah Task → Isi form → Simpan → Task baru
Team Member → Detail Task → Update Progress (0-100%)
  ├── Progress ≥ 100 → Status otomatis Done
  └── Progress < 100 → Status tetap In Progress
Client → Review → Approve atau Ajukan Revisi
```

### 4. Kanban Board (Drag & Drop)
File: `docs/flow-kanban.puml`

```
User → Pilih Proyek → Board terbuka (3 kolom)
  └── Drag kartu → Drop ke kolom lain
       ├── Ke "In Progress" → status = in_progress
       ├── Ke "Done" → status = done, progress = 100%
       └── Ke "To Do" → status = to_do
Counter badge otomatis terupdate (tanpa reload)
```

### 5. Alur Revisi
File: `docs/flow-revisi.puml`

```
Client → Pilih task → Isi deskripsi → Ajukan Revisi
  → Task otomatis In Progress
  → Status revisi: Menunggu
PM/Team → Lihat revisi → Diproses → Selesai
  → Client review → Approve atau Ajukan lagi
```

### 6. Laporan & Export
File: `docs/flow-laporan.puml`

```
SA/PM/Client → Halaman Laporan
  → Atur filter (tanggal, status, prioritas, assignee)
  → Export CSV atau PDF (Proyek atau Task)
```

### 7. Alur Proses Kerja (End-to-End)
File: `docs/flow-alur-proses-kerja.puml`

Alur menyeluruh dari awal hingga proyek selesai:

```
Super Admin
  → Buat akun PM, Team Member, Client

Project Manager
  → Buat proyek (Draft → Berjalan)
  → Tambah anggota tim
  → Buat task → Assign ke Team Member

Team Member
  → Kerjakan task
  → Update Progress (0–100%)
  → Drag ke In Progress / Done di Kanban

Client
  → Review hasil
  → Approve ✓ atau Ajukan Revisi ✗

Project Manager / Team Member
  → Proses revisi → Client review → Loop hingga approve

Project Manager
  → Semua task Done → Status proyek → Review → Selesai
  → Export laporan CSV/PDF

Super Admin
  → Monitor seluruh aktivitas dari Dashboard
```

---

## File PlantUML

Untuk merender diagram, gunakan salah satu:

1. **VS Code** — instal extension "PlantUML"
2. **Online** — paste kode ke https://www.plantuml.com/plantuml/
3. **CLI** — `java -jar plantuml.jar docs/*.puml`

| File | Isi |
|------|-----|
| `docs/use-case-diagram.puml` | Use Case Diagram (semua aktor & use case) |
| `docs/flow-login-register.puml` | Flowchart Login & Registrasi |
| `docs/flow-proyek.puml` | Flowchart Manajemen Proyek |
| `docs/flow-task.puml` | Flowchart Manajemen Task |
| `docs/flow-kanban.puml` | Flowchart Kanban Board |
| `docs/flow-revisi.puml` | Flowchart Alur Revisi |
| `docs/flow-laporan.puml` | Flowchart Laporan & Export |
| `docs/flow-alur-proses-kerja.puml` | Flowchart Alur Proses Kerja (End-to-End) |
