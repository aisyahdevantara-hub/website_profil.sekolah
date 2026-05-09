# 🏫 Website Profil Sekolah — TK Al-Muhajirin

Website profil sekolah berbasis **PHP Native** dengan panel admin untuk mengelola konten secara dinamis. Dibangun menggunakan **XAMPP** (Apache + MySQL) sebagai environment development.

> Mendidik dengan Hati, Membentuk Karakter Islami yang Mandiri.

---

## 📋 Daftar Isi

- [Fitur](#-fitur)
- [Tech Stack](#-tech-stack)
- [Prasyarat](#-prasyarat)
- [Instalasi](#-instalasi)
- [Struktur Folder](#-struktur-folder)
- [Halaman Publik](#-halaman-publik)
- [Panel Admin](#-panel-admin)
- [Database](#-database)
- [Screenshot](#-screenshot)
- [Lisensi](#-lisensi)

---

## ✨ Fitur

### Halaman Publik (Front-end)
| Halaman | Deskripsi |
|---|---|
| **Beranda** | Hero banner, sambutan kepala sekolah, daftar pengurus, dan program kegiatan terbaru |
| **Tentang Sekolah** | Informasi profil dan sejarah sekolah |
| **Pengurus** | Galeri data guru & pengurus sekolah |
| **Fasilitas** | Galeri fasilitas yang tersedia |
| **Program/Kegiatan** | Daftar kegiatan sekolah dengan halaman detail |
| **Kontak** | Info kontak, integrasi Google Maps, tombol WhatsApp, dan form kirim pesan |
| **Login** | Halaman login untuk akses panel admin |

### Panel Admin (Back-end)
| Fitur | Deskripsi |
|---|---|
| **Dashboard** | Ringkasan data keseluruhan |
| **Data Pengurus** | CRUD data guru/pengurus sekolah |
| **Data Fasilitas** | CRUD data fasilitas |
| **Data Kegiatan** | CRUD data kegiatan/program |
| **Pesan Masuk** | Melihat & mengelola pesan dari pengunjung |
| **Identitas Sekolah** | Pengaturan nama, logo, favicon, kontak, dan Google Maps |
| **Tentang Sekolah** | Edit konten halaman tentang sekolah |
| **Kepala Sekolah** | Edit informasi & sambutan kepala sekolah |
| **Manajemen Pengguna** | CRUD akun pengguna *(khusus Super Admin)* |
| **Ubah Password** | Perubahan password akun yang sedang login |

### Fitur Lainnya
- 📱 **Responsive Design** — tampilan optimal di desktop & mobile
- 🔐 **Multi-level User** — hak akses `Super Admin` dan `Admin`
- 📝 **TinyMCE Editor** — rich text editor untuk konten kegiatan
- 📤 **Upload Gambar** — upload foto guru, fasilitas, kegiatan, dan identitas sekolah
- 💬 **Integrasi WhatsApp** — tombol kontak langsung ke WhatsApp

---

## 🛠 Tech Stack

| Teknologi | Keterangan |
|---|---|
| **PHP** | Bahasa pemrograman server-side (Native PHP) |
| **MySQL** | Database relasional via `mysqli` |
| **HTML/CSS** | Struktur & styling halaman |
| **JavaScript** | Interaksi UI (mobile menu, sidebar toggle) |
| **Poppins** | Google Fonts untuk tipografi |
| **Font Awesome 6** | Icon library untuk panel admin |
| **TinyMCE** | Rich text editor pada halaman admin |
| **XAMPP** | Local development environment (Apache + MySQL) |

---

## 📌 Prasyarat

Pastikan sudah terinstall di komputer kamu:

- [XAMPP](https://www.apachefriends.org/) v7.4+ (PHP ≥ 7.4, MySQL/MariaDB)
- Web browser modern (Chrome, Firefox, Edge, dll.)

---

## 🚀 Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/username/webtk_ujilev.git
```

Atau download ZIP dan extract ke folder `C:\xampp\htdocs\webtk_ujilev`.

### 2. Buat Database

1. Buka **phpMyAdmin** di `http://localhost/phpmyadmin`
2. Buat database baru dengan nama: **`db_sekolah`**
3. Import file SQL (jika tersedia) atau buat tabel-tabel berikut secara manual:

| Tabel | Deskripsi |
|---|---|
| `pengaturan` | Identitas & pengaturan sekolah (nama, logo, favicon, alamat, telepon, email, Google Maps, foto sekolah, foto & sambutan kepsek) |
| `pengguna` | Data akun admin (username, password MD5, nama, level) |
| `guru` | Data pengurus/guru (nama_lengkap, gambar) |
| `fasilitas` | Data fasilitas sekolah |
| `kegiatan` | Data kegiatan/program (judul, gambar, keterangan) |
| `pesan` | Pesan masuk dari pengunjung (nama_pengirim, nomor_wa, email, pesan) |

### 3. Konfigurasi Koneksi Database

Edit file `koneksi.php` jika diperlukan:

```php
$host = "localhost";
$user = "root";
$pass = "";          // Sesuaikan dengan password MySQL kamu
$db   = "db_sekolah";
$port = 3306;
```

### 4. Jalankan XAMPP

1. Buka **XAMPP Control Panel**
2. Start **Apache** dan **MySQL**
3. Akses website di browser: `http://localhost/webtk_ujilev/`
4. Akses panel admin: `http://localhost/webtk_ujilev/login.php`

---

## 📂 Struktur Folder

```
webtk_ujilev/
├── admin/                      # Panel Admin
│   ├── index.php               # Dashboard admin
│   ├── header.php              # Header & sidebar admin
│   ├── footer.php              # Footer admin
│   ├── guru.php                # Tabel data pengurus
│   ├── tambah-guru.php         # Form tambah pengurus
│   ├── edit-guru.php           # Form edit pengurus
│   ├── fasilitas.php           # Tabel data fasilitas
│   ├── tambah-fasilitas.php    # Form tambah fasilitas
│   ├── edit-fasilitas.php      # Form edit fasilitas
│   ├── kegiatan.php            # Tabel data kegiatan
│   ├── tambah-kegiatan.php     # Form tambah kegiatan
│   ├── edit-kegiatan.php       # Form edit kegiatan
│   ├── pengguna.php            # Manajemen pengguna (Super Admin)
│   ├── tambah-pengguna.php     # Form tambah pengguna
│   ├── edit-pengguna.php       # Form edit pengguna
│   ├── pesan.php               # Pesan masuk dari pengunjung
│   ├── identitas-sekolah.php   # Pengaturan identitas sekolah
│   ├── tentang-sekolah.php     # Edit halaman tentang
│   ├── kepala-sekolah.php      # Edit info kepala sekolah
│   ├── ubah-password.php       # Ubah password
│   ├── hapus.php               # Handler hapus data
│   └── logout.php              # Proses logout
│
├── assets/
│   └── css/
│       ├── style.css           # Stylesheet utama
│       ├── index-mobile.css    # Responsive CSS halaman publik
│       └── admin-mobile.css    # Responsive CSS panel admin
│
├── uploads/                    # Direktori upload gambar
│   ├── identitas/              # Logo, favicon, foto sekolah & kepsek
│   ├── guru/                   # Foto pengurus/guru
│   ├── fasilitas/              # Foto fasilitas
│   └── kegiatan/               # Foto kegiatan
│
├── index.php                   # Halaman beranda
├── header.php                  # Header & navigasi publik
├── footer.php                  # Footer publik
├── koneksi.php                 # Koneksi database
├── tentang-sekolah.php         # Halaman tentang sekolah
├── guru.php                    # Halaman daftar pengurus
├── fasilitas.php               # Halaman daftar fasilitas
├── kegiatan.php                # Halaman daftar kegiatan
├── detail-kegiatan.php         # Halaman detail kegiatan
├── kontak.php                  # Halaman kontak & form pesan
├── login.php                   # Halaman login admin
└── README.md                   # Dokumentasi proyek
```

---

## 🌐 Halaman Publik

| URL | Halaman |
|---|---|
| `/` atau `/index.php` | Beranda |
| `/tentang-sekolah.php` | Tentang Sekolah |
| `/guru.php` | Daftar Pengurus |
| `/fasilitas.php` | Daftar Fasilitas |
| `/kegiatan.php` | Daftar Kegiatan |
| `/detail-kegiatan.php?id=X` | Detail Kegiatan |
| `/kontak.php` | Kontak & Form Pesan |
| `/login.php` | Login Admin |

---

## 🔒 Panel Admin

### Hak Akses

| Level | Akses |
|---|---|
| **Super Admin** | Manajemen pengguna, ubah password, logout |
| **Admin** | Semua fitur manajemen data (pengurus, fasilitas, kegiatan, pesan, pengaturan sekolah), ubah password, logout |

### Mengakses Panel Admin

1. Buka `http://localhost/webtk_ujilev/login.php`
2. Masukkan **username** dan **password**
3. Setelah berhasil login, kamu akan diarahkan ke **Dashboard Admin**

---

## 🗄 Database

**Nama Database:** `db_sekolah`

**Charset:** `utf8mb4`

### Tabel Utama

#### `pengaturan`
Menyimpan identitas & konfigurasi sekolah:
- `nama` — Nama sekolah
- `logo`, `favicon`, `foto_sekolah` — File gambar
- `alamat`, `telepon`, `email` — Informasi kontak
- `google_maps` — Embed URL Google Maps
- `nama_kepsek`, `foto_kepsek`, `sambutan_kepsek` — Data kepala sekolah

#### `pengguna`
Menyimpan data akun login:
- `username`, `password` (MD5 hash)
- `nama`, `level` (Super Admin / Admin)

#### `guru`
Menyimpan data pengurus/guru:
- `nama_lengkap`, `gambar`

#### `kegiatan`
Menyimpan data kegiatan/program:
- `judul`, `gambar`, `keterangan`

#### `pesan`
Menyimpan pesan masuk dari form kontak:
- `nama_pengirim`, `nomor_wa`, `email`, `pesan`

---

## 📸 Screenshot

> *Tambahkan screenshot tampilan website di sini.*

---

## 📄 Lisensi

Copyright © 2026 — TK Al-Muhajirin. All Rights Reserved.
