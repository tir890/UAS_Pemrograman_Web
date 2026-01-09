# UAS Pemrograman Web

Nama : Tiara Hayatul Khoir

Kelas : TI.24.A.5

NIM : 312410474

Mata Kuliah : Pemrograman Web

# 🐠 AquaSpace - Virtual Aquarium Manager

**AquaSpace** adalah aplikasi berbasis web untuk mengelola koleksi ikan hias virtual. Aplikasi ini dibangun menggunakan **PHP Native (Konsep OOP)** dengan menerapkan desain antarmuka bergaya **Frutiger Aero** (estetika web tahun 2000-an yang futuristik, glossy, dan bertema alam).

Proyek ini dibuat untuk memenuhi tugas **UAS Pemrograman Web** dengan fokus pada implementasi CRUD, Autentikasi (Login/Register), Routing App, dan Manajemen Database.

---

## 📋 Fitur Aplikasi

Aplikasi ini memiliki dua peran pengguna (*Role*) dengan hak akses berbeda:

### 1. Fitur Umum

* **Routing System:** Menggunakan `.htaccess` untuk URL yang bersih (*Pretty URL*).
* **Authentication:** Sistem Login dan Logout menggunakan Session.
* **Responsive Design:** Tampilan adaptif menggunakan Bootstrap 5.

### 2. Role Admin (Pengelola)

* **Dashboard Admin:** Melihat statistik jumlah spesies ikan.
* **Manajemen Katalog (CRUD):**
* Menambah spesies ikan baru (termasuk upload gambar).
* Mengedit data ikan.
* Menghapus data ikan dari katalog.


* **Validasi Data:** Mencegah input data kosong.

### 3. Role User (Pengunjung/Kolektor)

* **Registrasi:** Mendaftar akun baru.
* **Katalog Ikan:** Melihat daftar ikan dengan fitur:
* **Pagination:** Membatasi tampilan data per halaman.
* **Search & Filter:** Mencari ikan berdasarkan nama atau tipe air (Tawar/Laut).


* **Adopsi Ikan:** Menambahkan ikan dari katalog ke koleksi pribadi ("Aquarium Saya").
* **Manajemen Koleksi:** Melihat ikan yang dimiliki dan melepas ikan (Hapus dari koleksi).

---

## 🛠️ Teknologi yang Digunakan

* **Bahasa Pemrograman:** PHP 8.x (Native dengan gaya OOP).
* **Database:** MySQL / MariaDB.
* **Frontend:** HTML5, CSS3 (Custom Glassmorphism), Bootstrap 5.
* **Server:** Apache (XAMPP).
* **Tools:** Visual Studio Code, phpMyAdmin.

---

## 📂 Struktur Folder (MVC Sederhana)

```text
/aquaspace
├── .htaccess             # Konfigurasi Routing
├── index.php             # Main Router (Pintu Masuk Aplikasi)
├── /assets               # File statis (CSS, Gambar, JS)
├── /class                # Class PHP (Database Connection)
├── /config               # Konfigurasi Database
├── /module               # Logika Aplikasi (Controller/View)
│   ├── /fish             # Modul CRUD Ikan (Admin)
│   ├── /user             # Modul Auth (Login/Register)
│   ├── /collection       # Modul Koleksi User
│   └── /home             # Halaman Dashboard
└── /template             # Header & Footer Layout

```

---

## 🚀 Cara Instalasi & Menjalankan

Ikuti langkah berikut untuk menjalankan proyek di komputer lokal:

1. **Clone/Download:**
Simpan folder `aquaspace` ke dalam direktori server lokal (contoh: `C:\xampp\htdocs\aquaspace`).
2. **Buat Database:**
* Buka **phpMyAdmin** (`http://localhost/phpmyadmin`).
* Buat database baru dengan nama: `aquaspace`.
* Import file SQL berikut (atau jalankan query ini di tab SQL):


```sql
-- Tabel Users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Fishes (Katalog)
CREATE TABLE fishes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    type ENUM('Air Tawar', 'Air Laut') NOT NULL,
    rarity ENUM('Common', 'Rare', 'Legendary') NOT NULL,
    image VARCHAR(255),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Collections (Transaksi)
CREATE TABLE collections (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    fish_id INT,
    custom_name VARCHAR(100),
    adopted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (fish_id) REFERENCES fishes(id) ON DELETE CASCADE
);

-- Akun Admin Default
INSERT INTO users (username, password, role) VALUES ('admin', 'admin', 'admin');

```


3. **Konfigurasi Database:**
Pastikan file `class/database.php` sudah sesuai dengan settingan XAMPP kamu (User: root, Pass: kosong).
4. **Jalankan Aplikasi:**
Buka browser dan akses: `http://localhost/aquaspace`

---

## 📸 Alur Aplikasi & Screenshot

**1. Halaman Login & Register**
Pengguna masuk ke sistem. Jika belum punya akun, user dapat mendaftar.
> ![Login](https://github.com/tir890/UAS_Pemrograman_Web/blob/7aaa3299969122ff1e9c46730297c845d9f6af95/login-uas.png)

**2. Dashboard Utama**
Halaman sambutan yang menampilkan statistik dan navigasi utama.
> !Dashboard](https://github.com/tir890/UAS_Pemrograman_Web/blob/7aaa3299969122ff1e9c46730297c845d9f6af95/dashboard-aquaspace.png)

**3. Katalog Ikan (Fitur Search & Pagination)**
Admin dapat mengelola data, User hanya dapat melihat dan mencari.
> ![Katalog](https://github.com/tir890/UAS_Pemrograman_Web/blob/5f05b529cfb1a254da7d03d9822f99a0f0e9e2ef/katalog-ikan-uas.png)

**4. Aquarium Saya (Khusus User)**
Menampilkan koleksi ikan yang sudah diadopsi dalam tampilan Grid/Kartu.
> ![Aquarium](https://github.com/tir890/UAS_Pemrograman_Web/blob/7aaa3299969122ff1e9c46730297c845d9f6af95/katalog-ikan-aquaspace.png)

---
