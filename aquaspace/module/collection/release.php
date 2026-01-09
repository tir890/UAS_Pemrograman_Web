<?php
if (!isset($_SESSION['login'])) {
    exit;
}

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// HAPUS DATA (Hanya jika ikan itu milik user yang sedang login)
// Kita tambahkan "AND user_id = ..." untuk keamanan, biar user A ga bisa hapus ikan user B
$hapus = $db->delete("collections", "WHERE id='$id' AND user_id='$user_id'");

if ($hapus) {
    echo "<script>alert('Ikan telah dilepas ke laut bebas. Bye bye! 👋'); window.location='index.php?mod=collection/index';</script>";
} else {
    echo "<script>alert('Gagal melepas ikan.'); window.location='index.php?mod=collection/index';</script>";
}
?>