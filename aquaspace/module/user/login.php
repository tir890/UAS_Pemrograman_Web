<?php
// Jika user sudah login, lempar ke dashboard
if (isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

// Proses Login saat tombol ditekan
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 1. Cek Username di Database
    $cek_user = $db->get("users", "username='$username'");

    // 2. Jika User Ditemukan
    if ($cek_user) {
        // 3. Cek Password
        if ($password == $cek_user['password']) {
            
            // 4. Set Session (Menyimpan status login)
            $_SESSION['login']   = true;
            $_SESSION['user_id'] = $cek_user['id'];
            $_SESSION['role']    = $cek_user['role']; // admin atau user
            $_SESSION['nama']    = $cek_user['username'];

            // PENTING: Pesan Alert sekarang Dinamis (sesuai nama user)
            $nama_panggilan = $cek_user['username'];
            echo "<script>alert('Login Berhasil! Selamat datang, $nama_panggilan.'); window.location='index.php';</script>";
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card glass-card border-0 shadow-lg p-4" style="width: 400px;">
        <div class="text-center mb-4">
            <h1 style="font-size: 3rem;">🐠</h1>
            <h3 class="fw-bold text-primary">AquaSpace</h3>
            <p class="text-muted small">Masuk untuk mengelola kolam</p>
        </div>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger rounded-pill text-center py-2 text-small">
                <?= $error; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="mb-3">
                <label class="form-label fw-bold small text-muted">USERNAME</label>
                <input type="text" name="username" class="form-control rounded-pill" placeholder="Masukan username" required>
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-bold small text-muted">PASSWORD</label>
                <input type="password" name="password" class="form-control rounded-pill" placeholder="Masukan password" required>
            </div>

            <button type="submit" name="login" class="btn btn-primary w-100 rounded-pill fw-bold shadow-sm">
                Masuk Sekarang
            </button>
        </form>
        
        <div class="text-center mt-4">
            <small class="text-muted">Belum punya aquarium? <a href="index.php?mod=user/register" class="text-primary fw-bold text-decoration-none">Daftar</a></small>
        </div>
    </div>
</div>