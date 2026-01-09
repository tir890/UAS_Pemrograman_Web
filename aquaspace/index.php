<?php
session_start();
// 1. Panggil Class Database & Form (Sesuai struktur kamu)
include "class/database.php";

// 2. Koneksi Database Global
$db = new Database();

// 3. Routing (Mengatur Alamat URL)
// URL Default: module/home/index.php (Kita buat nanti)
$mod = "home";
$act = "index";

if (isset($_GET['mod'])) {
    // Memecah URL. Contoh: fish/add 
    // parts[0] = fish (nama folder module)
    // parts[1] = add (nama file php)
    $parts = explode('/', rtrim($_GET['mod'], '/'));
    
    $mod = isset($parts[0]) ? $parts[0] : 'home';
    $act = isset($parts[1]) ? $parts[1] : 'index';
}

// 4. Controller (Memanggil file yang diminta)
// Cek apakah file ada di folder module?
$file = "module/" . $mod . "/" . $act . ".php";

if (file_exists($file)) {
    // 1. Panggil Header (Tampilan Atas)
    include "template/index.php"; 
    
    // 2. Panggil Konten (Halaman yang diminta)
    include $file;
    
    // 3. Panggil Footer (Tampilan Bawah) - TAMBAHKAN INI
    include "template/footer.php"; 
} else {
    echo "<h1>404 Not Found</h1>";
    echo "<p>Halaman tidak ditemukan.</p>";
}