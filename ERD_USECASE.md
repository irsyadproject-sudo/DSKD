# ERD & Use Case Diagram — Sistem Informasi Toko Motor Online

---

## 1. ENTITY RELATIONSHIP DIAGRAM (ERD)

### 1.1 ERD Visual (Crow's Foot Notation)

```
┌─────────────────────┐       ┌─────────────────────┐
│      CATEGORIES      │       │      SUPPLIERS       │
├─────────────────────┤       ├─────────────────────┤
│ PK id               │       │ PK id               │
│    name             │       │    name             │
│    description      │       │    phone            │
│    status           │       │    address          │
│    created_at       │       │    created_at       │
│    updated_at       │       │    updated_at       │
└────────┬────────────┘       └────────┬────────────┘
         │ 1                           │ 1
         │                             │
         │ *                           │ *
┌────────┴────────────┐       ┌────────┴────────────┐
│      PRODUCTS        │       │      STOCK_INS       │
├─────────────────────┤       ├─────────────────────┤
│ PK id               │◄──────│ FK product_id       │
│ FK category_id  ────────┐   │ FK supplier_id  ────────┐
│    name             │   │   │    tanggal_masuk    │   │
│    price            │   │   │    qty              │   │
│    stock            │   │   │    keterangan       │   │
│    description      │   │   │    created_at       │   │
│    image            │   │   │    updated_at       │   │
│    created_at       │   │   └─────────────────────┘   │
│    updated_at       │   │                             │
└──┬───┬───┬──────────┘   │                             │
   │   │   │              │                             │
   │   │   │              │                             │
   │   │   │   *          │                             │
   │   │   │◄─────────────┘                             │
   │   │   │                                             │
   │   │   │                                             │
   │   │   │  *                                          │
   │   │   ├──────────────┐                              │
   │   │   │              │                              │
   │   │   │              ▼                              │
   │   │   │  ┌─────────────────────┐                   │
   │   │   │  │   STOCK_OUTS        │                   │
   │   │   │  ├─────────────────────┤                   │
   │   │   │  │ PK id               │                   │
   │   │   │  │ FK product_id       │                   │
   │   │   │  │    tanggal_keluar   │                   │
   │   │   │  │    qty              │                   │
   │   │   │  │    alasan           │                   │
   │   │   │  │    keterangan       │                   │
   │   │   │  │    created_at       │                   │
   │   │   │  │    updated_at       │                   │
   │   │   │  └─────────────────────┘                   │
   │   │   │                                             │
   │   │   │  *                                           │
   │   │   ├──────────────┐                              │
   │   │   │              ▼                              │
   │   │   │  ┌─────────────────────┐                   │
   │   │   │  │  STOCK_HISTORIES    │                   │
   │   │   │  ├─────────────────────┤                   │
   │   │   │  │ PK id               │                   │
   │   │   │  │ FK product_id       │                   │
   │   │   │  │    type (in/out/sale)│                   │
   │   │   │  │    qty              │                   │
   │   │   │  │    stock_before     │                   │
   │   │   │  │    stock_after      │                   │
   │   │   │  │    reference_id     │                   │
   │   │   │  │    reference_type   │                   │
   │   │   │  │    created_at       │                   │
   │   │   │  └─────────────────────┘                   │
   │   │   │                                             │
   │   │   │  *                                           │
   │   │   ├──────────────┐                              │
   │   │   │              ▼                              │
   │   │   │  ┌─────────────────────┐                   │
   │   │   │  │   ORDER_ITEMS       │                   │
   │   │   │  ├─────────────────────┤                   │
   │   │   │  │ PK id               │                   │
   │   │   │  │ FK order_id         │                   │
   │   │   │  │ FK product_id       │                   │
   │   │   │  │    qty              │                   │
   │   │   │  │    price            │                   │
   │   │   │  │    subtotal         │                   │
   │   │   │  │    created_at       │                   │
   │   │   │  │    updated_at       │                   │
   │   │   │  └──────────┬──────────┘                   │
   │   │   │             │ *                             │
   │   │   │             │                               │
   │   │   │             │ 1                             │
   │   │   │             ▼                               │
   │   │   │  ┌─────────────────────┐  ┌──────────────┐ │
   │   │   │  │      ORDERS         │  │   USERS      │ │
   │   │   │  ├─────────────────────┤  ├──────────────┤ │
   │   │   │  │ PK id               │  │ PK id        │ │
   │   │   │  │ FK user_id     ────────── name        │ │
   │   │   │  │ FK shipping_address │  │    email     │ │
   │   │   │  │    order_number     │  │    role      │ │
   │   │   │  │    total            │  │    password  │ │
   │   │   │  │    status           │  │    ...       │ │
   │   │   │  │    payment_status   │  │              │ │
   │   │   │  │    created_at       │  │              │ │
   │   │   │  │    updated_at       │  │              │ │
   │   │   │  └──────┬──────┬───────┘  └──────┬───────┘ │
   │   │   │         │      │                 │         │
   │   │   │         │      │ 1               │ 1       │
   │   │   │         │      │                 │         │
   │   │   │         │ *    │                 │ *       │
   │   │   │         │      │                 │         │
   │   │   │         ▼      │                 │         │
   │   │   │  ┌──────────┐ │                 │         │
   │   │   │  │ PAYMENTS │ │                 │         │
   │   │   │  ├──────────┤ │                 │         │
   │   │   │  │ PK id    │ │                 │         │
   │   │   │  │FKorder_id│ │                 │         │
   │   │   │  │   ...    │ │                 │         │
   │   │   │  └──────────┘ │                 │         │
   │   │   │               │                 │         │
   │   │   │               ▼                 │         │
   │   │   │  ┌──────────────────────┐       │         │
   │   │   │  │ SHIPPING_ADDRESSES   │       │         │
   │   │   │  ├──────────────────────┤       │         │
   │   │   │  │ PK id                │       │         │
   │   │   │  │ FK user_id     ──────────────┘         │
   │   │   │  │    recipient_name  │                   │
   │   │   │  │    phone           │                   │
   │   │   │  │    address         │                   │
   │   │   │  │    city            │                   │
   │   │   │  │    province        │                   │
   │   │   │  │    postal_code     │                   │
   │   │   │  │    created_at      │                   │
   │   │   │  │    updated_at      │                   │
   │   │   │  └──────────────────────┘                 │
   │   │   │                                           │
   │   │   │  *                                         │
   │   │   ├──────────────┐                            │
   │   │   │              ▼                            │
   │   │   │  ┌─────────────────────┐                  │
   │   │   │  │     CART_ITEMS      │                  │
   │   │   │  ├─────────────────────┤                  │
   │   │   │  │ PK id               │                  │
   │   │   │  │ FK cart_id          │                  │
   │   │   │  │ FK product_id       │                  │
   │   │   │  │    qty              │                  │
   │   │   │  │    price            │                  │
   │   │   │  │    created_at       │                  │
   │   │   │  │    updated_at       │                  │
   │   │   │  └──────────┬──────────┘                  │
   │   │   │             │ *                            │
   │   │   │             │                              │
   │   │   │             │ 1                            │
   │   │   │             ▼                              │
   │   │   │  ┌─────────────────────┐                  │
   │   │   │  │       CARTS         │                  │
   │   │   │  ├─────────────────────┤                  │
   │   │   │  │ PK id               │                  │
   │   │   │  │ FK user_id     ──────┘                 │
   │   │   │  │    created_at       │                  │
   │   │   │  │    updated_at       │                  │
   │   │   │  └─────────────────────┘                  │
```

### 1.2 Tabel Relasi (Text Format)

```
┌──────────────────────────────────────────────────────────────────┐
│                    RELATIONSHIP MATRIX                            │
├──────────────────────────────────────────────────────────────────┤
│                                                                  │
│  users (1) ──────────── (*) carts                                │
│  carts (1) ──────────── (*) cart_items                           │
│  cart_items (*) ─────── (1) products                             │
│                                                                  │
│  users (1) ──────────── (*) shipping_addresses                   │
│  users (1) ──────────── (*) orders                               │
│  shipping_addresses (1) ─ (*) orders                             │
│  orders (1) ─────────── (*) order_items                          │
│  orders (1) ─────────── (1) payments                             │
│  order_items (*) ────── (1) products                             │
│                                                                  │
│  categories (1) ─────── (*) products                             │
│  suppliers (1) ──────── (*) stock_ins                            │
│  products (1) ───────── (*) stock_ins                            │
│  products (1) ───────── (*) stock_outs                           │
│  products (1) ───────── (*) stock_histories                      │
│                                                                  │
│  stock_histories ────── (polymorphic) ─── StockIn / StockOut / Order │
│                                                                  │
└──────────────────────────────────────────────────────────────────┘
```

### 1.3 Detail Tabel

#### USERS
| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | BIGINT (PK) | Auto Increment |
| name | VARCHAR | Nama pengguna |
| email | VARCHAR | Unique, untuk login |
| role | ENUM('admin','customer') | Default: 'customer' |
| email_verified_at | TIMESTAMP | Nullable |
| password | VARCHAR | Hashed (bcrypt) |
| remember_token | VARCHAR | Untuk "Ingat Saya" |
| created_at | TIMESTAMP | Waktu pembuatan |
| updated_at | TIMESTAMP | Waktu pembaruan |

#### CATEGORIES
| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | BIGINT (PK) | Auto Increment |
| name | VARCHAR | Nama kategori |
| description | TEXT | Deskripsi (nullable) |
| status | ENUM('active','inactive') | Default: 'active' |
| created_at | TIMESTAMP | |
| updated_at | TIMESTAMP | |

#### SUPPLIERS
| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | BIGINT (PK) | Auto Increment |
| name | VARCHAR | Nama pemasok |
| phone | VARCHAR | Telepon (nullable) |
| address | TEXT | Alamat (nullable) |
| created_at | TIMESTAMP | |
| updated_at | TIMESTAMP | |

#### PRODUCTS
| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | BIGINT (PK) | Auto Increment |
| category_id | BIGINT (FK) | → categories.id, CASCADE delete |
| name | VARCHAR | Nama produk/motor |
| price | DECIMAL(10,2) | Harga jual |
| stock | INTEGER | Stok tersedia, Default: 0 |
| description | TEXT | Deskripsi (nullable) |
| image | VARCHAR | Path gambar (nullable) |
| created_at | TIMESTAMP | |
| updated_at | TIMESTAMP | |

#### STOCK_INS
| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | BIGINT (PK) | Auto Increment |
| product_id | BIGINT (FK) | → products.id, CASCADE delete |
| supplier_id | BIGINT (FK) | → suppliers.id, SET NULL delete |
| tanggal_masuk | DATE | Tanggal stok masuk |
| qty | INTEGER | Jumlah masuk |
| keterangan | TEXT | Keterangan (nullable) |
| created_at | TIMESTAMP | |
| updated_at | TIMESTAMP | |

#### STOCK_OUTS
| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | BIGINT (PK) | Auto Increment |
| product_id | BIGINT (FK) | → products.id, CASCADE delete |
| tanggal_keluar | DATE | Tanggal stok keluar |
| qty | INTEGER | Jumlah keluar |
| alasan | ENUM('rusak','hilang','kadaluarsa','lainnya') | Default: 'lainnya' |
| keterangan | TEXT | Keterangan (nullable) |
| created_at | TIMESTAMP | |
| updated_at | TIMESTAMP | |

#### STOCK_HISTORIES
| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | BIGINT (PK) | Auto Increment |
| product_id | BIGINT (FK) | → products.id, CASCADE delete |
| type | ENUM('in','out','sale') | Tipe mutasi stok |
| qty | INTEGER | Jumlah perubahan |
| stock_before | INTEGER | Stok sebelum perubahan |
| stock_after | INTEGER | Stok sesudah perubahan |
| reference_id | UNSIGNED BIGINT | Polymorphic (nullable) |
| reference_type | VARCHAR | Polymorphic: StockIn/StockOut/Order (nullable) |
| created_at | TIMESTAMP | |
| updated_at | TIMESTAMP | |

#### CARTS
| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | BIGINT (PK) | Auto Increment |
| user_id | BIGINT (FK) | → users.id, CASCADE delete |
| created_at | TIMESTAMP | |
| updated_at | TIMESTAMP | |

#### CART_ITEMS
| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | BIGINT (PK) | Auto Increment |
| cart_id | BIGINT (FK) | → carts.id, CASCADE delete |
| product_id | BIGINT (FK) | → products.id, CASCADE delete |
| qty | INTEGER | Jumlah item, Default: 1 |
| price | DECIMAL(10,2) | Harga saat ditambahkan |
| created_at | TIMESTAMP | |
| updated_at | TIMESTAMP | |

#### SHIPPING_ADDRESSES
| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | BIGINT (PK) | Auto Increment |
| user_id | BIGINT (FK) | → users.id, CASCADE delete |
| recipient_name | VARCHAR | Nama penerima |
| phone | VARCHAR | Telepon |
| address | TEXT | Alamat lengkap |
| city | VARCHAR | Kota |
| province | VARCHAR | Provinsi |
| postal_code | VARCHAR | Kode pos |
| created_at | TIMESTAMP | |
| updated_at | TIMESTAMP | |

#### ORDERS
| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | BIGINT (PK) | Auto Increment |
| user_id | BIGINT (FK) | → users.id, CASCADE delete |
| shipping_address_id | BIGINT (FK) | → shipping_addresses.id, SET NULL delete |
| order_number | VARCHAR | Unique: ORD-YYYYMMDD-XXXX |
| total | DECIMAL(10,2) | Total harga |
| status | ENUM('pending','processed','shipped','completed','cancelled') | Default: 'pending' |
| payment_status | ENUM('unpaid','pending','paid','rejected') | Default: 'unpaid' |
| created_at | TIMESTAMP | |
| updated_at | TIMESTAMP | |

#### ORDER_ITEMS
| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | BIGINT (PK) | Auto Increment |
| order_id | BIGINT (FK) | → orders.id, CASCADE delete |
| product_id | BIGINT (FK) | → products.id, CASCADE delete |
| qty | INTEGER | Jumlah yang dibeli |
| price | DECIMAL(10,2) | Harga satuan saat beli |
| subtotal | DECIMAL(10,2) | qty × price |
| created_at | TIMESTAMP | |
| updated_at | TIMESTAMP | |

#### PAYMENTS
| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | BIGINT (PK) | Auto Increment |
| order_id | BIGINT (FK) | → orders.id, CASCADE delete |
| midtrans_transaction_id | VARCHAR | ID transaksi Midtrans (nullable) |
| payment_method | VARCHAR | Metode pembayaran (nullable) |
| proof | VARCHAR | Path bukti upload (nullable) |
| uploaded_at | TIMESTAMP | Waktu upload bukti (nullable) |
| status | VARCHAR(50) | Status: pending/settlement/verified/rejected/deny/expire/cancel |
| admin_notes | TEXT | Catatan admin (nullable) |
| verified_at | TIMESTAMP | Waktu verifikasi (nullable) |
| rejected_at | TIMESTAMP | Waktu penolakan (nullable) |
| rejected_reason | TEXT | Alasan penolakan (nullable) |
| transaction_id | VARCHAR | ID transaksi dari Midtrans (nullable) |
| snap_token | VARCHAR | Token Snap Midtrans (nullable) |
| payment_type | VARCHAR | Tipe pembayaran dari Midtrans (nullable) |
| transaction_status | VARCHAR | Status transaksi Midtrans (nullable) |
| fraud_status | VARCHAR | Status fraud check (nullable) |
| paid_at | TIMESTAMP | Waktu pembayaran berhasil (nullable) |
| created_at | TIMESTAMP | |
| updated_at | TIMESTAMP | |

---

## 2. USE CASE DIAGRAM

### 2.1 Aktor (Actors)

| Aktor | Deskripsi |
|-------|-----------|
| **Admin** | Pengelola toko yang mengelola produk, stok, pesanan, pembayaran, dan laporan |
| **Pelanggan** | Pembeli yang melakukan pencarian produk, belanja, dan pembayaran |
| **Sistem** | Proses otomatis (webhook Midtrans, validasi stok, generate nomor pesanan) |
| **Midtrans** | Payment gateway eksternal untuk pemrosesan pembayaran online |

### 2.2 Use Case Diagram (ASCII Art)

```
┌─────────────────────────────────────────────────────────────────────────────────────┐
│                                                                                     │
│                        USE CASE DIAGRAM                                             │
│                    Sistem Informasi Toko Motor Online                                │
│                                                                                     │
│  ┌──────────┐                                        ┌──────────┐                   │
│  │          │                                        │          │                   │
│  │  ADMIN   │                                        │PELANGGAN │                   │
│  │          │                                        │          │                   │
│  └────┬─────┘                                        └────┬─────┘                   │
│       │                                                    │                         │
│       │                                                    │                         │
│  ╔════╪══════════════════════════════════════════════════════╪═════════════════╗     │
│  ║    │          SISTEM TOKO MOTOR ONLINE                    │                 ║     │
│  ║    │                                                    │                 ║     │
│  ║    │                                                    │                 ║     │
│  ║    ▼                                                    ▼                 ║     │
│  ║ ┌──────────────────────────┐  ┌──────────────────────────────────┐       ║     │
│  ║ │ UC-01: Login             │  │ UC-10: Registrasi Akun           │       ║     │
│  ║ └──────────────────────────┘  └──────────────────────────────────┘       ║     │
│  ║    │                                                        │             ║     │
│  ║    ▼                                                        ▼             ║     │
│  ║ ┌──────────────────────────┐  ┌──────────────────────────────────┐       ║     │
│  ║ │ UC-02: Lihat Dashboard   │  │ UC-11: Lihat Katalog Produk      │       ║     │
│  ║ └──────────────────────────┘  └──────────────────────────────────┘       ║     │
│  ║    │                                                        │             ║     │
│  ║    ▼                                                        ▼             ║     │
│  ║ ┌──────────────────────────┐  ┌──────────────────────────────────┐       ║     │
│  ║ │ UC-03: Kelola Kategori   │  │ UC-12: Cari & Filter Produk      │       ║     │
│  ║ │    (CRUD)                │  └──────────────────────────────────┘       ║     │
│  ║ └──────────────────────────┘    │                                        ║     │
│  ║    │                            ▼                                        ║     │
│  ║    ▼                      ┌──────────────────────────────────┐           ║     │
│  ║ ┌──────────────────────────┐  │ UC-13: Lihat Detail Produk     │           ║     │
│  ║ │ UC-04: Kelola Produk     │  └──────────────────────────────────┘       ║     │
│  ║ │    (CRUD + Upload Gambar)│    │                                        ║     │
│  ║ └──────────────────────────┘    ▼                                        ║     │
│  ║    │                      ┌──────────────────────────────────┐           ║     │
│  ║    ▼                      │ UC-14: Kelola Keranjang Belanja   │           ║     │
│  ║ ┌──────────────────────────┐  │    ├ Tambah ke Keranjang     │           ║     │
│  ║ │ UC-05: Catat Stok Masuk  │  │    ├ Ubah Jumlah             │           ║     │
│  ║ └──────────────────────────┘  │    ├ Hapus Item              │           ║     │
│  ║    │                            │    └ Kosongkan Keranjang    │           ║     │
│  ║    ▼                            └──────────────────────────────────┘       ║     │
│  ║ ┌──────────────────────────┐    │                                        ║     │
│  ║ │ UC-06: Catat Stok Keluar │    ▼                                        ║     │
│  ║ └──────────────────────────┘  ┌──────────────────────────────────┐       ║     │
│  ║    │                            │ UC-15: Checkout                  │       ║     │
│  ║    ▼                            │    ├ Pilih Alamat               │       ║     │
│  ║ ┌──────────────────────────┐  │    ├ Pilih Metode Bayar        │       ║     │
│  ║ │ UC-07: Lihat Riwayat Stok│  │    └ Konfirmasi Pesanan       │       ║     │
│  ║ └──────────────────────────┘  └──────────────────────────────────┘       ║     │
│  ║    │                            │                                        ║     │
│  ║    ▼                            ▼                                        ║     │
│  ║ ┌──────────────────────────┐  ┌──────────────────────────────────┐       ║     │
│  ║ │ UC-08: Kelola Pesanan    │  │ UC-16: Bayar (Midtrans Snap)     │       ║     │
│  ║ │    ├ Lihat Daftar         │  └──────────────────────────────────┘       ║     │
│  ║ │    ├ Lihat Detail         │    │                                        ║     │
│  ║ │    └ Ubah Status          │    ▼                                        ║     │
│  ║ └──────────────────────────┘  ┌──────────────────────────────────┐       ║     │
│  ║    │                            │ UC-17: Upload Bukti Pembayaran   │       ║     │
│  ║    ▼                            └──────────────────────────────────┘       ║     │
│  ║ ┌──────────────────────────┐    │                                        ║     │
│  ║ │ UC-09: Kelola Pembayaran │    ▼                                        ║     │
│  ║ │    ├ Verifikasi Bayar    │  ┌──────────────────────────────────┐       ║     │
│  ║ │    ├ Tolak Bayar         │  │ UC-18: Lihat Riwayat Pesanan     │       ║     │
│  ║ │    └ Download Bukti      │  └──────────────────────────────────┘       ║     │
│  ║ └──────────────────────────┘    │                                        ║     │
│  ║    │                            ▼                                        ║     │
│  ║    ▼                      ┌──────────────────────────────────┐           ║     │
│  ║ ┌──────────────────────────┐  │ UC-19: Lihat Detail Pesanan     │           ║     │
│  ║ │ UC-20: Laporan Stok      │  └──────────────────────────────────┘       ║     │
│  ║ └──────────────────────────┘    │                                        ║     │
│  ║    │                            ▼                                        ║     │
│  ║    ▼                      ┌──────────────────────────────────┐           ║     │
│  ║ ┌──────────────────────────┐  │ UC-21: Batalkan Pesanan         │           ║     │
│  ║ │ UC-22: Laporan Penjualan │  └──────────────────────────────────┘       ║     │
│  ║ └──────────────────────────┘    │                                        ║     │
│  ║    │                            ▼                                        ║     │
│  ║    ▼                      ┌──────────────────────────────────┐           ║     │
│  ║ ┌──────────────────────────┐  │ UC-23: Kelola Alamat Pengiriman  │           ║     │
│  ║ │ UC-24: Lihat Statistik   │  │    ├ Tambah Alamat              │           ║     │
│  ║ │    (Dashboard)           │  │    ├ Ubah Alamat               │           ║     │
│  ║ └──────────────────────────┘  │    └ Hapus Alamat              │           ║     │
│  ║    │                            └──────────────────────────────────┘       ║     │
│  ║    ▼                            │                                        ║     │
│  ║ ┌──────────────────────────┐    ▼                                        ║     │
│  ║ │ UC-25: Logout (Admin)    │  ┌──────────────────────────────────┐       ║     │
│  ║ └──────────────────────────┘  │ UC-26: Ubah Profil               │       ║     │
│  ║                                └──────────────────────────────────┘       ║     │
│  ║                                  │                                        ║     │
│  ║                                  ▼                                        ║     │
│  ║                                ┌──────────────────────────────────┐       ║     │
│  ║                                │ UC-27: Logout (Pelanggan)        │       ║     │
│  ║                                └──────────────────────────────────┘       ║     │
│  ║                                                                           ║     │
│  ║  ═══════════════════════════════════════════════════════════════════════  ║     │
│  ║                                                                           ║     │
│  ║  USE CASE SISTEM & EKSTERNAL:                                             ║     │
│  ║                                                                           ║     │
│  ║  ┌──────────────────────────────────────────────┐                        ║     │
│  ║  │ UC-28: Proses Webhook Midtrans                │                        ║     │
│  ║  │    ├ Verifikasi Tanda Tangan SHA-512           │                        ║     │
│  ║  │    ├ Update Status Pembayaran                  │                        ║     │
│  ║  │    ├ Update Status Pesanan                     │                        ║     │
│  ║  │    └ Kembalikan Stok (jika gagal/expired)     │                        ║     │
│  ║  └──────────────────────────────────────────────┘                        ║     │
│  ║                                                                           ║     │
│  ║  ┌──────────────────────────────────────────────┐                        ║     │
│  ║  │ UC-29: Validasi Stok                          │                        ║     │
│  ║  │    ├ Saat Tambah ke Keranjang                  │                        ║     │
│  ║  │    └ Saat Checkout                             │                        ║     │
│  ║  └──────────────────────────────────────────────┘                        ║     │
│  ║                                                                           ║     │
│  ║  ┌──────────────────────────────────────────────┐                        ║     │
│  ║  │ UC-30: Generate Nomor Pesanan Unik            │                        ║     │
│  ║  │    Format: ORD-YYYYMMDD-XXXX                  │                        ║     │
│  ║  └──────────────────────────────────────────────┘                        ║     │
│  ║                                                                           ║     │
│  ║  ┌──────────────────────────────────────────────┐                        ║     │
│  ║  │ UC-31: Otomatis Update Stok                   │                        ║     │
│  ║  │    ├ Kurangi Stok saat Checkout                │                        ║     │
│  ║  │    ├ Kembalikan Stok saat Batal               │                        ║     │
│  ║  │    └ Catat Stock History                       │                        ║     │
│  ║  └──────────────────────────────────────────────┘                        ║     │
│  ║                                                                           ║     │
│  ╚═══════════════════════════════════════════════════════════════════════════╝     │
│                                                                                     │
│  ┌──────────┐                                                                      │
│  │          │                                                                      │
│  │ MIDTRANS │──── UC-32: Memproses Pembayaran Online                              │
│  │          │──── UC-33: Mengirim Notifikasi Webhook                               │
│  └──────────┘                                                                      │
│                                                                                     │
└─────────────────────────────────────────────────────────────────────────────────────┘
```

### 2.3 Use Case per Aktor (Table)

#### ADMIN

| Kode | Use Case | Deskripsi | Relasi |
|------|----------|-----------|--------|
| UC-01 | Login | Masuk ke sistem dengan email & password | — |
| UC-02 | Lihat Dashboard | Menampilkan statistik: total produk, pelanggan, pesanan, pendapatan, grafik penjualan | — |
| UC-03 | Kelola Kategori | CRUD kategori produk (tambah, lihat, ubah, hapus) | — |
| UC-04 | Kelola Produk | CRUD produk dengan upload gambar dan pemilihan kategori | `<<include>>` UC-03 |
| UC-05 | Catat Stok Masuk | Mencatat penerimaan stok dari pemasok | `<<include>>` UC-31 |
| UC-06 | Catat Stok Keluar | Mencatat pengeluaran stok (rusak/hilang/kadaluarsa) | `<<include>>` UC-31 |
| UC-07 | Lihat Riwayat Stok | Menampilkan riwayat perubahan stok per produk | — |
| UC-08 | Kelola Pesanan | Melihat daftar pesanan, detail, dan mengubah status | `<<include>>` UC-31 |
| UC-09 | Kelola Pembayaran | Verifikasi/tolak pembayaran manual, download bukti | — |
| UC-20 | Laporan Stok | Menampilkan laporan stok dengan filter kategori dan status | — |
| UC-22 | Laporan Penjualan | Menampilkan laporan penjualan dengan filter tanggal & produk terlaris | — |
| UC-24 | Lihat Statistik | Menampilkan statistik dashboard (stok minimum, grafik) | — |
| UC-25 | Logout | Keluar dari sesi admin | — |

#### PELANGGAN

| Kode | Use Case | Deskripsi | Relasi |
|------|----------|-----------|--------|
| UC-10 | Registrasi Akun | Membuat akun baru dengan nama, email, password | — |
| UC-01 | Login | Masuk ke sistem dengan email & password | — |
| UC-11 | Lihat Katalog Produk | Menampilkan daftar motor/produk dengan grid | — |
| UC-12 | Cari & Filter Produk | Mencari produk berdasarkan nama, kategori, merek, tahun | `<<include>>` UC-11 |
| UC-13 | Lihat Detail Produk | Menampilkan informasi lengkap produk + produk terkait | — |
| UC-14 | Kelola Keranjang | Menambah, mengubah qty, menghapus item di keranjang | `<<extend>>` UC-29 |
| UC-15 | Checkout | Memproses pesanan: pilih alamat, metode bayar, konfirmasi | `<<include>>` UC-29, `<<include>>` UC-30, `<<include>>` UC-31 |
| UC-16 | Bayar (Midtrans Snap) | Membuka pop-up pembayaran Midtrans | — |
| UC-17 | Upload Bukti Pembayaran | Mengunggah bukti transfer manual | — |
| UC-18 | Lihat Riwayat Pesanan | Menampilkan daftar pesanan dengan status | — |
| UC-19 | Lihat Detail Pesanan | Menampilkan detail pesanan termasuk status pembayaran & pengiriman | — |
| UC-21 | Batalkan Pesanan | Membatalkan pesanan dengan pengembalian stok otomatis | `<<include>>` UC-31 |
| UC-23 | Kelola Alamat | CRUD alamat pengiriman (tambah, ubah, hapus) | — |
| UC-26 | Ubah Profil | Memperbarui nama dan email | — |
| UC-27 | Logout | Keluar dari sesi pelanggan | — |

#### SISTEM (Automated)

| Kode | Use Case | Deskripsi | Trigger |
|------|----------|-----------|---------|
| UC-28 | Proses Webhook Midtrans | Verifikasi signature, update status bayar/pesanan, kembalikan stok | HTTP POST dari Midtrans |
| UC-29 | Validasi Stok | Memeriksa ketersediaan stok | Saat tambah keranjang / checkout |
| UC-30 | Generate Nomor Pesanan | Membuat nomor unik ORD-YYYYMMDD-XXXX | Saat checkout |
| UC-31 | Otomatis Update Stok | Kurangi stok saat jual, kembalikan saat batal | Saat checkout / batal / webhook |

#### MIDTRANS (External)

| Kode | Use Case | Deskripsi |
|------|----------|-----------|
| UC-32 | Proses Pembayaran | Memproses transaksi pembayaran online pelanggan |
| UC-33 | Kirim Notifikasi Webhook | Mengirim notifikasi status transaksi ke server |

### 2.4 Include & Extend Relationships

```
┌─────────────────────────────────────────────────────────┐
│              RELASI INCLUDE & EXTEND                      │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  UC-04 (Kelola Produk) ──<<include>>──▶ UC-03 (Kelola   │
│                                         Kategori)        │
│                                                          │
│  UC-05 (Stok Masuk) ──<<include>>──▶ UC-31 (Update Stok)│
│                                                          │
│  UC-06 (Stok Keluar) ──<<include>>──▶ UC-31            │
│                                                          │
│  UC-08 (Kelola Pesanan) ──<<include>>──▶ UC-31          │
│                                                          │
│  UC-15 (Checkout) ──<<include>>──▶ UC-29 (Validasi Stok)│
│  UC-15 (Checkout) ──<<include>>──▶ UC-30 (Gen No.Pesanan│
│  UC-15 (Checkout) ──<<include>>──▶ UC-31 (Update Stok)  │
│                                                          │
│  UC-21 (Batal Pesanan) ──<<include>>──▶ UC-31           │
│                                                          │
│  UC-14 (Keranjang) ──<<extend>>──▶ UC-29 (Validasi Stok)│
│  (hanya saat produk sudah habis / stok tidak cukup)      │
│                                                          │
└─────────────────────────────────────────────────────────┘
```

### 2.5 Alur Proses Utama (Main Flow)

#### Alur Pembelian Pelanggan:
```
Pelanggan                  Sistem                    Midtrans
   │                         │                          │
   │── 1. Registrasi/Login ──▶│                          │
   │                         │                          │
   │── 2. Browse Katalog ────▶│                          │
   │◀── 3. Tampilkan Produk ──│                          │
   │                         │                          │
   │── 4. Tambah ke Cart ────▶│── 5. Validasi Stok ──────│
   │◀── 6. Konfirmasi ────────│                          │
   │                         │                          │
   │── 7. Checkout ──────────▶│── 8. Gen No. Pesanan ────│
   │                         │── 9. Kurangi Stok ────────│
   │                         │── 10. Buat Order ─────────│
   │◀── 11. Tampilkan Bayar ──│                          │
   │                         │                          │
   │── 12. Pilih Metode ─────▶│── 13. Init Midtrans ────▶│
   │◀── 14. Snap Token ───────│◀── 15. Response ─────────│
   │                         │                          │
   │── 16. Bayar ────────────▶│                          │
   │◀── 17. Status Bayar ─────│◀── 18. Webhook ──────────│
   │                         │── 19. Update Status ──────│
   │                         │── 20. Update Stok ────────│
   │                         │                          │
   │◀── 21. Lihat Status ─────│                          │
```

#### Alur Verifikasi Admin:
```
Admin                      Sistem                   Pelanggan
   │                         │                          │
   │── 1. Lihat Pembayaran ──▶│                          │
   │◀── 2. Daftar Pending ────│                          │
   │                         │                          │
   │── 3. Lihat Detail ──────▶│                          │
   │◀── 4. Detail + Bukti ────│                          │
   │                         │                          │
   │── 5. Verifikasi/Tolak ──▶│── 6. Update Status ──────│
   │                         │── 7. Update Order ────────│
   │                         │── 8. Notifikasi ─────────▶│
```

---

## 3. RINGKASAN

| Aspek | Jumlah |
|-------|--------|
| Total Tabel (Bisnis) | 13 tabel inti |
| Total Aktor | 4 (Admin, Pelanggan, Sistem, Midtrans) |
| Total Use Case | 33 |
| Use Case Admin | 13 |
| Use Case Pelanggan | 15 |
| Use Case Sistem (Otomatis) | 4 |
| Use Case Midtrans (Eksternal) | 2 |

---

*Dokumen ini dihasilkan berdasarkan analisis kode sumber Aplikasi Toko Motor Online (Laravel 13)*
