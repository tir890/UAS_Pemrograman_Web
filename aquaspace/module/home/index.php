<?php
// Cek apakah user sudah login?
$is_login = isset($_SESSION['login']);
$nama_user = $is_login ? $_SESSION['nama'] : 'Pengunjung';
?>

<div class="container mt-5">
    <div class="p-5 mb-4 bg-light rounded-3 glass-card text-center border-0 shadow-sm">
        <div class="container-fluid py-3">
            <h1 class="display-5 fw-bold text-primary">Selamat Datang di AquaSpace! 🌊</h1>
            <p class="col-md-8 fs-4 mx-auto text-muted">
                Halo, <b><?= $nama_user; ?></b>! Kelola koleksi ikan virtualmu dan bangun akuarium impian sekarang juga.
            </p>
            
            <div class="d-flex justify-content-center gap-3 mt-4">
                <a href="index.php?mod=fish/index" class="btn btn-primary btn-lg rounded-pill px-4 shadow-sm">
                    🐟 Lihat Katalog Ikan
                </a>
                
                <?php if ($is_login): ?>
                    <a href="index.php?mod=collection/index" class="btn btn-outline-info btn-lg rounded-pill px-4">
                        🪣 Aquarium Saya
                    </a>
                <?php else: ?>
                    <a href="index.php?mod=user/login" class="btn btn-success btn-lg rounded-pill px-4 shadow-sm">
                        Login Sekarang
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="row align-items-md-stretch">
        <div class="col-md-6">
            <div class="h-100 p-5 text-white bg-info rounded-3 shadow-sm" style="background: linear-gradient(135deg, #0dcaf0 0%, #0d6efd 100%);">
                <h2>Total Spesies</h2>
                <p>Jelajahi berbagai jenis ikan unik dari seluruh samudra.</p>
                <?php 
                // Hitung jumlah ikan (Optional query)
                $total_ikan = $db->query("SELECT COUNT(*) as total FROM fishes")->fetch_assoc()['total'];
                ?>
                <h1 class="display-3 fw-bold"><?= $total_ikan; ?></h1>
                <p>Spesies Terdaftar</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="h-100 p-5 bg-light border rounded-3 glass-card shadow-sm">
                <h2 class="text-primary">Status Server</h2>
                <p>Sistem berjalan normal. Air akuarium jernih dan filter berfungsi dengan baik.</p>
                <hr>
                <ul class="list-unstyled">
                    <li>✅ Database: Terkoneksi</li>
                    <li>✅ Session: <?= $is_login ? 'Aktif (' . $_SESSION['role'] . ')' : 'Belum Login'; ?></li>
                    <li>✅ Cuaca: Cerah Berawan 🌤️</li>
                </ul>
            </div>
        </div>
    </div>
</div>