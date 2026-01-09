<?php
// 1. Inisialisasi Role & User
$role = $_SESSION['role'] ?? 'guest';
$user_id = $_SESSION['user_id'] ?? null;

// ==========================================
// LOGIKA PAGINATION & PENCARIAN
// ==========================================

// A. Tentukan Batas Data per Halaman
$batas = 5; // Tampilkan 5 ikan per halaman
$halaman = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

// B. Tangkap Kata Kunci Pencarian
$keyword = "";
$where_sql = "";

if (isset($_GET['q'])) {
    $keyword = $_GET['q'];
    // Filter berdasarkan Nama Ikan ATAU Tipe Air
    $where_sql = "WHERE name LIKE '%$keyword%' OR type LIKE '%$keyword%'";
}

// C. Hitung Total Data (Untuk Pagination)
$query_total = "SELECT count(*) as total FROM fishes $where_sql";
$result_total = $db->query($query_total)->fetch_assoc();
$total_data = $result_total['total'];
$total_halaman = ceil($total_data / $batas);

// D. Ambil Data Utama (Dengan Limit & Filter)
// Query digabung: Filter dulu ($where_sql), baru urutkan, baru batasi ($halaman_awal, $batas)
$query_data = "SELECT * FROM fishes $where_sql ORDER BY id DESC LIMIT $halaman_awal, $batas";
$data_ikan = $db->query($query_data);

// Hitung nomor urut tabel agar melanjutkan halaman sebelumnya
$nomor = $halaman_awal + 1;
?>

<div class="container mt-5">
    
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h2 class="text-primary fw-bold">
                <?= ($role == 'admin') ? '🛠️ Kelola Ikan' : '🐠 Katalog Ikan'; ?>
            </h2>
            <p class="text-muted small">Menampilkan <?= $data_ikan->num_rows; ?> dari <?= $total_data; ?> data ikan.</p>
        </div>
        <div class="col-md-6 text-md-end">
            <?php if ($role == 'admin'): ?>
                <a href="index.php?mod=fish/add" class="btn btn-primary rounded-pill px-4 shadow-sm">
                    + Tambah Spesies
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="card glass-card border-0 mb-4 p-3 shadow-sm">
        <form action="index.php" method="GET" class="row g-2 align-items-center">
            <input type="hidden" name="mod" value="fish/index">
            
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text bg-white border-0 rounded-start-pill ps-3">🔍</span>
                    <input type="text" name="q" class="form-control border-0 rounded-end-pill py-2" 
                           placeholder="Cari nama ikan atau tipe air..." 
                           value="<?= $keyword; ?>">
                </div>
            </div>
            <div class="col-md-2 d-grid">
                <button type="submit" class="btn btn-info text-white rounded-pill fw-bold">Cari</button>
            </div>
        </form>
    </div>

    <div class="card border-0 shadow-sm glass-card mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Visual</th>
                            <th>Nama Ikan</th>
                            <th>Tipe Air</th>
                            <th>Kelangkaan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($data_ikan && $data_ikan->num_rows > 0) {
                            while ($row = $data_ikan->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td><?= $nomor++; ?></td>
                                    <td>
                                        <?php if (!empty($row['image'])): ?>
                                            <img src="assets/img/<?= $row['image']; ?>" width="60" class="img-fluid rounded">
                                        <?php else: ?>
                                            <span class="text-muted small">No Image</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="fw-bold text-primary"><?= $row['name']; ?></td>
                                    <td>
                                        <span class="badge <?= ($row['type'] == 'Air Tawar') ? 'bg-success' : 'bg-info'; ?>">
                                            <?= $row['type']; ?>
                                        </span>
                                    </td>
                                    <td><?= $row['rarity']; ?></td>
                                    <td>
                                        <?php if ($role == 'admin'): ?>
                                            <a href="index.php?mod=fish/edit&id=<?= $row['id']; ?>" class="btn btn-sm btn-warning text-white rounded-pill">Edit</a>
                                            <a href="index.php?mod=fish/delete&id=<?= $row['id']; ?>" class="btn btn-sm btn-danger rounded-pill" onclick="return confirm('Hapus data?');">Hapus</a>
                                        <?php elseif ($role == 'user'): ?>
                                            <a href="index.php?mod=collection/adopt&fish_id=<?= $row['id']; ?>" class="btn btn-sm btn-info text-white rounded-pill px-3 shadow-sm" onclick="return confirm('Adopsi ikan ini?');">💙 Adopsi</a>
                                        <?php else: ?>
                                            <a href="index.php?mod=user/login" class="btn btn-sm btn-outline-primary rounded-pill">Login</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center py-5 text-muted'>Ikan yang dicari tidak ditemukan :(</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php if ($total_halaman > 1): ?>
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            
            <li class="page-item <?= ($halaman <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link rounded-pill px-3 me-2" href="index.php?mod=fish/index&page=<?= $halaman - 1; ?>&q=<?= $keyword; ?>">
                    &laquo; Prev
                </a>
            </li>

            <?php for ($x = 1; $x <= $total_halaman; $x++): ?>
                <li class="page-item <?= ($halaman == $x) ? 'active' : ''; ?>">
                    <a class="page-link rounded-pill px-3 me-2" href="index.php?mod=fish/index&page=<?= $x; ?>&q=<?= $keyword; ?>">
                        <?= $x; ?>
                    </a>
                </li>
            <?php endfor; ?>

            <li class="page-item <?= ($halaman >= $total_halaman) ? 'disabled' : ''; ?>">
                <a class="page-link rounded-pill px-3" href="index.php?mod=fish/index&page=<?= $halaman + 1; ?>&q=<?= $keyword; ?>">
                    Next &raquo;
                </a>
            </li>
            
        </ul>
    </nav>
    <?php endif; ?>

</div>