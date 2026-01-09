<?php
// Cek apakah tombol simpan sudah ditekan?
if (isset($_POST['submit'])) {
    
    // 1. Persiapan Upload Gambar
    $nama_file_foto = "";
    if (!empty($_FILES['image']['name'])) {
        $nama_file_asli = $_FILES['image']['name'];
        $tmp_file = $_FILES['image']['tmp_name'];
        
        // Buat nama unik biar ga bentrok (misal: 170923_nemo.png)
        $nama_file_foto = time() . "_" . $nama_file_asli;
        
        // Pindahkan file ke folder assets/img
        // Pastikan folder assets/img sudah ada ya!
        move_uploaded_file($tmp_file, "assets/img/" . $nama_file_foto);
    }

    // 2. Siapkan Data untuk dimasukkan ke Database
    $data = [
        'name'        => $_POST['name'],
        'type'        => $_POST['type'],
        'rarity'      => $_POST['rarity'],
        'description' => $_POST['description'],
        'image'       => $nama_file_foto // Simpan nama filenya saja
    ];

    // 3. Eksekusi Simpan dengan Class Database
    // Insert ke tabel 'fishes'
    $simpan = $db->insert('fishes', $data);

    if ($simpan) {
        // Jika sukses, kembali ke halaman list
        echo "<script>alert('Berhasil menangkap ikan baru!'); window.location='index.php?mod=fish/index';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan data!');</script>";
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card glass-card border-0 shadow-lg">
                <div class="card-header bg-transparent border-0 pt-4">
                    <h3 class="text-primary fw-bold text-center">Tambah Koleksi Ikan</h3>
                </div>
                <div class="card-body p-4">
                    <form action="" method="POST" enctype="multipart/form-data">
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Ikan</label>
                            <input type="text" name="name" class="form-control rounded-pill" placeholder="Contoh: Clownfish" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tipe Habitat</label>
                                <select name="type" class="form-select rounded-pill">
                                    <option value="Air Tawar">Air Tawar</option>
                                    <option value="Air Laut">Air Laut</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tingkat Rarity</label>
                                <select name="rarity" class="form-select rounded-pill">
                                    <option value="Common">Common (Biasa)</option>
                                    <option value="Rare">Rare (Langka)</option>
                                    <option value="Legendary">Legendary (Sangat Langka)</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Foto Ikan</label>
                            <input type="file" name="image" class="form-control rounded-pill">
                            <div class="form-text text-muted">Format: JPG/PNG. Pastikan background transparan biar bagus!</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi Singkat</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Ceritakan sedikit tentang ikan ini..."></textarea>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" name="submit" class="btn btn-primary rounded-pill py-2 fw-bold">
                                Simpan ke Kolam
                            </button>
                            <a href="index.php?mod=fish/index" class="btn btn-light rounded-pill py-2 text-muted">
                                Batal
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>