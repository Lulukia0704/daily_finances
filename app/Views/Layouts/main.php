<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daily Finances — <?= $title ?? 'Dashboard' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
    
    <style>
        /* Tombol hamburger melayang di pojok kiri atas (HANYA muncul di HP/Tablet) */
        .hamburger-trigger {
            position: fixed;
            top: 12px;
            left: 12px;
            z-index: 1050; 
            background-color: #229799; 
            color: white;
            border: none;
            border-radius: 8px;
            padding: 8px 12px;
            display: none; /* Sembunyikan di monitor besar */
            box-shadow: 0 4px 12px rgba(34, 151, 153, 0.3);
            transition: all 0.2s ease;
        }

        .hamburger-trigger:hover {
            background-color: #1b7a7c;
        }

        /* --------------------------------------------------
        STYLE OFFCANVAS (MENCONTEK 100% STYLE ASLIMU)
        ----------------------------------------------------- */
        .mobile-sidebar-bg {
            background-color: #229799 !important; /* Warna hijau toska aslimu */
            border: none !important;
            width: 280px; /* Default lebar laci */
        }

        /* Styling Link di dalam Offcanvas */
        .mobile-sidebar-bg .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            border-radius: 8px;
            margin-bottom: 4px;
            padding: 10px 12px;
            font-size: 14px;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.2s ease;
        }

        /* Efek Hover */
        .mobile-sidebar-bg .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.15) !important;
            color: white !important;
        }

        /* Efek Menu Aktif */
        .mobile-sidebar-bg .nav-link.active {
            background-color: white !important;
            color: #229799 !important;
            font-weight: 600;
        }

        /* --------------------------------------------------
        MEDIA QUERY UNTUK TABLET (max-width: 991.98px)
        ----------------------------------------------------- */
        @media (max-width: 991.98px) {
            /* Ukuran font menu sidebar sedikit mengecil di Tablet */
            .mobile-sidebar-bg .nav-link {
                font-size: 13px !important;
            }
            /* Ukuran judul logo di Tablet */
            .mobile-sidebar-bg #mobileSidebarLabel {
                font-size: 1rem !important; 
            }
        }

        /* --------------------------------------------------
        MEDIA QUERY UNTUK HP / MOBILE (max-width: 767.98px)
        ----------------------------------------------------- */
        @media (max-width: 767.98px) {
            /* Munculkan tombol hamburger */
            .hamburger-trigger {
                display: block;
            }
            .hamburger-trigger i {
                font-size: 1.2rem !important;
            }

            /* Sembunyikan sidebar desktop */
            .sidebar {
                display: none !important;
            }

            /* Reset margin kiri konten utama di HP */
            .main-content {
                margin-left: 0 !important;
                padding-top: 65px !important; 
                padding-left: 12px !important;
                padding-right: 12px !important;
            }

            /* Lebar laci menu disisakan 20% ruang kosong di kanan agar tidak full layar */
            .mobile-sidebar-bg {
                width: 70% !important; 
                max-width: 300px;      
            }

            /* Beri jarak kiri di header agar tulisan tidak ditumpuk tombol hamburger melayang */
            .mobile-sidebar-bg .offcanvas-header {
                padding-left: 65px !important; 
            }

            /* 🎯 FONT RESPONSIVE KHUSUS MOBILE (Mencegah teks kepotong) */
            .mobile-sidebar-bg #mobileSidebarLabel {
                font-size: 0.9rem !important; /* Ukuran pas untuk layar HP kecil */
                letter-spacing: 0.3px;
                white-space: nowrap; /* Memaksa teks tetap satu baris horizontal */
            }

            .mobile-sidebar-bg .user-greeting {
                font-size: 0.78rem !important; /* Teks "Hi, user" ikut mengecil secara proporsional */
            }

            .mobile-sidebar-bg .nav-link {
                font-size: 12.5px !important; /* Font menu sedikit lebih rapat & manis di HP */
                padding: 8px 10px;
            }
        }
    </style>
</head>
<body>

<!-- TOMBOL HAMBURGER MELAYANG (Otomatis hilang di desktop) -->
<button class="hamburger-trigger" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar">
    <i class="bi bi-list"></i>
</button>

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR UTAMA (Desktop) -->
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
        <div class="col-12 col-md-10 main-content">
            <?= $this->renderSection('content') ?>
        </div>

    </div>
</div>

<!-- SIDEBAR OFFCANVAS (Laci Menu HP - 100% Senada dengan Desain Asli & Full Screen di Mobile) -->
<div class="offcanvas offcanvas-start mobile-sidebar-bg text-white" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
    <div class="offcanvas-header justify-content-between align-items-center py-4 px-3">
        <div>
            <h5 class="text-white fw-bold mb-0" id="mobileSidebarLabel">DAILY FINANCES</h5>
            <small class="text-white-50 user-greeting">Hi, <?= session()->get('user_nama')?>!</small>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column justify-content-between px-0 pt-0">
        
        <!-- Menu List -->
        <nav class="nav flex-column px-3">
            <hr class="border-light opacity-25 mt-0">
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
        <div class="px-3 mb-4">
            <hr class="border-light opacity-25">
            <a href="<?= base_url('setting') ?>" class="nav-link <?= $activeMenu == 'setting' ? 'active' : '' ?>">
                <i class="bi bi-gear me-2"></i> Setting
            </a>
            <a href="#" class="nav-link text-white bg-danger bg-opacity-25" data-bs-toggle="modal" data-bs-target="#modalLogout" data-bs-dismiss="offcanvas">
                <i class="bi bi-box-arrow-right me-2"></i> Keluar
            </a>
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