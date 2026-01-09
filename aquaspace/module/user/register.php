<?php
// Jika sudah login, ngapain daftar lagi? Tendang ke home.
if (isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 1. Cek apakah username sudah ada?
    $cek = $db->get("users", "username='$username'");
    
    if ($cek) {
        $error = "Username sudah dipakai, cari nama lain ya!";
    } else {
        // 2. Simpan data user baru
        // Role otomatis diisi 'user'
        $data_baru = [
            'username' => $username,
            'password' => $password, // Di dunia nyata ini harus di-hash (dienkripsi)
            'role'     => 'user'
        ];

        $simpan = $db->insert("users", $data_baru);

        if ($simpan) {
            echo "<script>alert('Pendaftaran Berhasil! Silakan Login.'); window.location='index.php?mod=user/login';</script>";
        } else {
            $error = "Gagal mendaftar, coba lagi nanti.";
        }
    }
}
?>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card glass-card border-0 shadow-lg p-4" style="width: 400px;">
        <div class="text-center mb-4">
            <h1 style="font-size: 3rem;">📝</h1>
            <h3 class="fw-bold text-primary">Daftar Akun</h3>
            <p class="text-muted small">Mulai koleksi ikan virtualmu</p>
        </div>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger rounded-pill text-center py-2 text-small">
                <?= $error; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="mb-3">
                <label class="form-label fw-bold small text-muted">USERNAME BARU</label>
                <input type="text" name="username" class="form-control rounded-pill" placeholder="Pilih username unik" required>
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-bold small text-muted">PASSWORD</label>
                <input type="password" name="password" class="form-control rounded-pill" placeholder="Rahasia dong" required>
            </div>

            <button type="submit" name="register" class="btn btn-success w-100 rounded-pill fw-bold shadow-sm">
                Daftar Sekarang
            </button>
        </form>
        
        <div class="text-center mt-4">
            <small class="text-muted">Sudah punya akun? <a href="index.php?mod=user/login" class="text-primary fw-bold text-decoration-none">Login disini</a></small>
        </div>
    </div>
</div>