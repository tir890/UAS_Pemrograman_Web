<?php
// 1. Ambil ID
$id = $_GET['id'];

// (Opsional) Ambil data dulu buat hapus gambarnya dari folder
$data = $db->get("fishes", "id='$id'");
if ($data && !empty($data['image'])) {
    if (file_exists("assets/img/" . $data['image'])) {
        unlink("assets/img/" . $data['image']); // Hapus file fisik
    }
}

// 2. Hapus dari Database
$delete = $db->delete("fishes", "WHERE id='$id'");

if ($delete) {
    echo "<script>alert('Ikan berhasil dilepas (Data Dihapus)!'); window.location='index.php?mod=fish/index';</script>";
} else {
    echo "<script>alert('Gagal menghapus data!'); window.location='index.php?mod=fish/index';</script>";
}
?>