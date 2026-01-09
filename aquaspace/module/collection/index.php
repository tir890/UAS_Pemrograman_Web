<?php
// Cek Login
if (!isset($_SESSION['login'])) {
    header("Location: index.php?mod=user/login");
    exit;
}

$user_id = $_SESSION['user_id'];

// QUERY JOIN: Mengambil data koleksi DIGABUNG dengan data master ikan
// Tujuannya: Biar kita bisa tahu nama spesies dan gambarnya dari tabel fishes
$query = "SELECT 
            collections.id as collection_id, 
            collections.custom_name, 
            collections.adopted_at,
            fishes.name as species_name, 
            fishes.image, 
            fishes.type 
          FROM collections 
          JOIN fishes ON collections.fish_id = fishes.id 
          WHERE collections.user_id = '$user_id'
          ORDER BY collections.id DESC";

$data_aquarium = $db->query($query);
?>

<div class="container mt-5">
    <div class="text-center mb-5">
        <h2 class="text-primary fw-bold">🐠 Aquarium Milik <?= $_SESSION['nama']; ?></h2>
        <p class="text-muted">Rawat ikan-ikanmu dengan baik ya!</p>
    </div>

    <div class="row">
        <?php
        if ($data_aquarium && $data_aquarium->num_rows > 0) {
            while ($row = $data_aquarium->fetch_assoc()) {
        ?>
            <div class="col-md-4 mb-4">
                <div class="card glass-card border-0 h-100 shadow-sm" style="transition: transform 0.3s;">
                    <div class="card-body text-center p-4">
                        
                        <div class="mb-3" style="height: 120px; display: flex; align-items: center; justify-content: center;">
                            <?php if (!empty($row['image'])): ?>
                                <img src="assets/img/<?= $row['image']; ?>" alt="Ikan" class="img-fluid" style="max-height: 100px;">
                            <?php else: ?>
                                <span style="font-size: 4rem;">🐟</span>
                            <?php endif; ?>
                        </div>

                        <h4 class="fw-bold text-dark"><?= $row['custom_name']; ?></h4>
                        <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary mb-3">
                            Spesies: <?= $row['species_name']; ?>
                        </span>

                        <p class="small text-muted mb-4">
                            Tipe: <?= $row['type']; ?><br>
                            Diadopsi: <?= date('d M Y', strtotime($row['adopted_at'])); ?>
                        </p>

                        <div class="d-grid gap-2">
                            <a href="index.php?mod=collection/release&id=<?= $row['collection_id']; ?>" 
                               class="btn btn-outline-danger btn-sm rounded-pill"
                               onclick="return confirm('Yakin mau melepas <?= $row['custom_name']; ?> kembali ke laut?');">
                                👋 Lepas ke Laut
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        <?php 
            }
        } else { 
            // Tampilan Jika Aquarium Masih Kosong
        ?>
            <div class="col-12 text-center py-5">
                <div class="glass-card p-5 d-inline-block">
                    <h1 style="font-size: 5rem;">🪣</h1>
                    <h3 class="text-muted mt-3">Aquarium kamu masih kosong melompong.</h3>
                    <p class="mb-4">Ayo cari teman baru untuk berenang di sini!</p>
                    <a href="index.php?mod=fish/index" class="btn btn-primary rounded-pill px-5 shadow">
                        Pergi ke Pasar Ikan (Katalog)
                    </a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>