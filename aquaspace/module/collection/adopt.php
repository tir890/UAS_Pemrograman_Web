<?php
// Pastikan hanya user yang boleh akses
if (!isset($_SESSION['login'])) {
    header("Location: index.php?mod=user/login");
    exit;
}

// Ambil ID ikan yang mau diadopsi
$fish_id = $_GET['fish_id'];
$user_id = $_SESSION['user_id'];

// (Opsional) Cek dulu apakah user sudah punya ikan ini? 
// Kalau mau boleh punya banyak, hapus bagian pengecekan ini.
/*
$cek = $db->query("SELECT * FROM collections WHERE user_id='$user_id' AND fish_id='$fish_id'");
if ($cek->num_rows > 0) {
    echo "<script>alert('Kamu sudah punya ikan ini di aquarium!'); window.location='index.php?mod=fish/index';</script>";
    exit;
}
*/

// Simpan ke Aquarium User
// Kita biarkan 'custom_name' kosong dulu atau diisi nama asli ikannya
$ikan_asli = $db->get("fishes", "id='$fish_id'");
$nama_default = $ikan_asli['name'];

$data = [
    'user_id' => $user_id,
    'fish_id' => $fish_id,
    'custom_name' => $nama_default // Nama awal disamakan
];

$simpan = $db->insert("collections", $data);

if ($simpan) {
    echo "<script>alert('Berhasil diadopsi! Ikan sudah masuk ke Aquarium kamu.'); window.location='index.php?mod=collection/index';</script>";
} else {
    echo "<script>alert('Gagal mengadopsi ikan.'); window.location='index.php?mod=fish/index';</script>";
}
?>