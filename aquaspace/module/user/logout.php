<?php
// Hapus semua session
session_destroy();
session_unset();

// Lempar balik ke halaman login
echo "<script>alert('Berhasil Logout. Sampai jumpa!'); window.location='index.php?mod=user/login';</script>";
?>