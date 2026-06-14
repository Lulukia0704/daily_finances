<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daily Finances — <?= $title ?? 'Dashboard' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
</head>
<body>

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-md-2 sidebar px-0">
            
            <!-- Logo -->
            <div class="sidebar-logo text-center py-4">
                <h5 class="text-white fw-bold mb-0">DAILY</h5>
                <h5 class="text-white fw-bold">FINANCES</h5>
                <hr class="border-secondary">
                <p class="text-white mb-0" style="font-size: 17px">
                Hi, <?= session()->get('user_nama')?>!</p>
            </div>

            <!-- Menu -->
            <nav class="nav flex-column px-3">
                <a href="<?= base_url('dashboard') ?>" class="nav-link <?= $activeMenu == 'dashboard' ? 'active' : '' ?>">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
                <a href="<?= base_url('transaksi') ?>" class="nav-link <?= $activeMenu == 'transaksi' ? 'active' : '' ?>">
                    <i class="bi bi-journal-text me-2"></i> Transaksi
                </a>
                <a href="<?= base_url('kategori') ?>" class="nav-link <?= $activeMenu == 'kategori' ? 'active' : '' ?>">
                    <i class="bi bi-tags me-2"></i> Kategori
                </a>
                <a href="<?= base_url('rekap') ?>" class="nav-link <?= $activeMenu == 'rekap' ? 'active' : '' ?>">
                    <i class="bi bi-calendar3 me-2"></i> Rekap Bulanan
                </a>
                <a href="<?= base_url('target') ?>" class="nav-link <?= $activeMenu == 'target' ? 'active' : '' ?>">
                    <i class="bi bi-bullseye me-2"></i> Target
                </a>
                <a href="<?= base_url('piutang') ?>" class="nav-link <?= $activeMenu == 'piutang' ? 'active' : '' ?>">
                    <i class="bi bi-people me-2"></i> Piutang
                </a>
            </nav>

            <!-- Bottom Menu -->
            <div class="sidebar-bottom px-3">
                <hr class="border-secondary">
                <a href="<?= base_url('setting') ?>" class="nav-link <?= $activeMenu == 'setting' ? 'active' : '' ?>">
                    <i class="bi bi-gear me-2"></i> Setting
                </a>
                <a href="#" class="nav-link text-danger" data-bs-toggle="modal" data-bs-target="#modalLogout">
                    <i class="bi bi-box-arrow-right me-2"></i> Keluar
                </a>
            </div>

        </div>

        <!-- KONTEN UTAMA -->
        <div class="col-md-10 main-content">
            <?= $this->renderSection('content') ?>
        </div>

    </div>
</div>

<!-- MODAL LOGOUT -->
<div class="modal fade" id="modalLogout" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center py-4">
                <i class="bi bi-box-arrow-right text-danger fs-1"></i>
                <h5 class="mt-3">Yakin ingin keluar?</h5>
                <p class="text-muted">Kamu harus login lagi untuk masuk ke aplikasi.</p>
                <div class="d-flex gap-2 justify-content-center mt-3">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href="<?= base_url('logout') ?>" class="btn btn-danger">Ya, Keluar</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>