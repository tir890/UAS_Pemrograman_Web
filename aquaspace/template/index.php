<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AquaSpace - Virtual Aquarium</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light fixed-top mt-3 mx-4 glass-card" style="z-index: 999;">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold text-primary" href="index.php">
            🐠 AquaSpace
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                
                <li class="nav-item">
                    <a class="nav-link fw-bold" href="index.php?mod=home/index">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="index.php?mod=fish/index">Katalog Ikan</a>
                </li>

                <?php if (isset($_SESSION['login'])): ?>
                    
                    <?php if ($_SESSION['role'] == 'user'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?mod=collection/index">Aquarium Saya</a>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item ms-3">
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-muted small">Hi, <?= $_SESSION['nama']; ?></span>
                            <a class="btn btn-danger btn-sm rounded-pill px-3" href="index.php?mod=user/logout">Logout</a>
                        </div>
                    </li>

                <?php else: ?>
                    <li class="nav-item ms-2">
                        <a class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm" href="index.php?mod=user/login">Login</a>
                    </li>
                <?php endif; ?>
                
            </ul>
        </div>
    </div>
</nav>

<div style="height: 100px;"></div>