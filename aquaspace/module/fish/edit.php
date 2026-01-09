<?php
// 1. Ambil ID dari URL
$id = $_GET['id'];

// 2. Ambil data ikan yang mau diedit
$data = $db->get("fishes", "id='$id'");

// Kalau data tidak ditemukan, tendang balik
if (!$data) {
    echo "<script>alert('Ikan tidak ditemukan!'); window.location='index.php?mod=fish/index';</script>";
    exit;
}

// 3. Proses Simpan Perubahan
if (isset($_POST['submit'])) {
    
    $update_data = [
        'name'        => $_POST['name'],
        'type'        => $_POST['type'],
        'rarity'      => $_POST['rarity'],
        'description' => $_POST['description']
    ];

    // Cek apakah user upload gambar baru?
    if (!empty($_FILES['image']['name'])) {
        $nama_file_asli = $_FILES['image']['name'];
        $tmp_file = $_FILES['image']['tmp_name'];
        $nama_file_baru = time() . "_" . $nama_file_asli;

        // Upload gambar baru
        if (move_uploaded_file($tmp_file, "assets/img/" . $nama_file_baru)) {
            $update_data['image'] = $nama_file_baru; // Masukkan nama file baru ke data update
            
            // (Opsional) Hapus gambar lama biar server gak penuh
            if (file_exists("assets/img/" . $data['image'])) {
                unlink("assets/img/" . $data['image']);
            }
        }
    }

    // Eksekusi Update
    $update = $db->update('fishes', $update_data, "id='$id'");

    if ($update) {
        echo "<script>alert('Data ikan berhasil diperbarui!'); window.location='index.php?mod=fish/index';</script>";
    } else {
        echo "<script>alert('Gagal mengupdate data!');</script>";
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card glass-card border-0 shadow-lg">
                <div class="card-header bg-transparent border-0 pt-4">
                    <h3 class="text-primary fw-bold text-center">Edit Data Ikan</h3>
                </div>
                <div class="card-body p-4">
                    <form action="" method="POST" enctype="multipart/form-data">
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Ikan</label>
                            <input type="text" name="name" class="form-control rounded-pill" value="<?= $data['name']; ?>" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tipe Habitat</label>
                                <select name="type" class="form-select rounded-pill">
                                    <option value="Air Tawar" <?= ($data['type'] == 'Air Tawar') ? 'selected' : ''; ?>>Air Tawar</option>
                                    <option value="Air Laut" <?= ($data['type'] == 'Air Laut') ? 'selected' : ''; ?>>Air Laut</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tingkat Rarity</label>
                                <select name="rarity" class="form-select rounded-pill">
                                    <option value="Common" <?= ($data['rarity'] == 'Common') ? 'selected' : ''; ?>>Common</option>
                                    <option value="Rare" <?= ($data['rarity'] == 'Rare') ? 'selected' : ''; ?>>Rare</option>
                                    <option value="Legendary" <?= ($data['rarity'] == 'Legendary') ? 'selected' : ''; ?>>Legendary</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Foto Ikan (Biarkan kosong jika tidak diganti)</label>
                            <div class="d-flex align-items-center gap-3">
                                <?php if (!empty($data['image'])): ?>
                                    <img src="assets/img/<?= $data['image']; ?>" width="50" class="rounded border">
                                <?php endif; ?>
                                <input type="file" name="image" class="form-control rounded-pill">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi Singkat</label>
                            <textarea name="description" class="form-control" rows="3"><?= $data['description']; ?></textarea>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" name="submit" class="btn btn-warning text-white rounded-pill py-2 fw-bold">
                                Simpan Perubahan
                            </button>
                            <a href="index.php?mod=fish/index" class="btn btn-light rounded-pill py-2 text-muted">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>