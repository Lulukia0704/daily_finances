<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Daily Finances — <?= $title ?? 'Dashboard' ?></title>

    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            /* Background dasar aplikasi yang lembut */
        }

        /* --------------------------------------------------
        SIDEBAR DESKTOP MODERN
        ----------------------------------------------------- */
        .sidebar {
            background-color: #229799;
            height: 100vh;
            position: sticky;
            top: 0;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.05);
            z-index: 1020;
        }

        .sidebar-logo h5 {
            letter-spacing: 1px;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.7) !important;
            border-radius: 8px;
            margin: 2px 10px 4px 10px;
            /* Spasi sedikit dari tepi agar menyerupai tombol */
            padding: 12px 16px;
            font-size: 14.5px;
            font-weight: 500;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .nav-link i {
            font-size: 1.1rem;
            transition: transform 0.3s ease;
        }

        /* Hover Effect Desktop */
        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1) !important;
            color: #ffffff !important;
            transform: translateX(4px);
        }

        /* Active Effect Desktop */
        .nav-link.active {
            background-color: #ffffff !important;
            color: #229799 !important;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .nav-link.active i {
            transform: scale(1.1);
            /* Ikon sedikit membesar jika aktif */
        }

        /* Konten utama di sebelah kanan */
        .main-content {
            padding: 30px 40px;
            min-height: 100vh;
        }

        /* --------------------------------------------------
        TOMBOL HAMBURGER MOBILE
        ----------------------------------------------------- */
        .hamburger-trigger {
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1050;
            background-color: #ffffff;
            color: #229799;
            border: 1px solid rgba(34, 151, 153, 0.2);
            border-radius: 10px;
            padding: 8px 12px;
            display: none;
            /* Sembunyikan di PC */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: all 0.2s ease;
        }

        .hamburger-trigger:hover {
            background-color: #f1f1f1;
            transform: translateY(-2px);
        }

        /* --------------------------------------------------
        OFFCANVAS MOBILE SIDEBAR
        ----------------------------------------------------- */
        .mobile-sidebar-bg {
            background-color: #229799 !important;
            border-right: none !important;
            width: 280px;
            box-shadow: 5px 0 25px rgba(0, 0, 0, 0.2);
        }

        .mobile-sidebar-bg .btn-close-white {
            opacity: 0.8;
        }

        .mobile-sidebar-bg .btn-close-white:hover {
            opacity: 1;
            transform: rotate(90deg);
            transition: transform 0.3s ease;
        }

        /* --------------------------------------------------
        MEDIA QUERIES
        ----------------------------------------------------- */
        /* TABLET */
        @media (max-width: 991.98px) {
            .nav-link {
                font-size: 13.5px;
                padding: 10px 14px;
            }

            .sidebar-logo h5 {
                font-size: 1.1rem !important;
            }

            .main-content {
                padding: 25px 20px;
            }
        }

        /* MOBILE / HP */
        @media (max-width: 767.98px) {
            .hamburger-trigger {
                display: block;
            }

            .sidebar {
                display: none !important;
            }

            .main-content {
                padding-top: 75px !important;
                padding-left: 15px !important;
                padding-right: 15px !important;
                padding-bottom: 30px !important;
            }

            .mobile-sidebar-bg {
                width: 75% !important;
                max-width: 320px;
            }

            .mobile-sidebar-bg .offcanvas-header {
                padding-left: 20px !important;
            }

            .mobile-sidebar-bg #mobileSidebarLabel {
                font-size: 1rem !important;
                letter-spacing: 0.5px;
            }

            .mobile-sidebar-bg .user-greeting {
                font-size: 0.85rem !important;
            }

            .mobile-sidebar-bg .nav-link {
                margin: 2px 15px 4px 15px;
                /* Margin menu mobile */
            }
        }
    </style>
</head>

<body>

    <!-- TOMBOL HAMBURGER MELAYANG (Khusus Mobile) -->
    <button class="hamburger-trigger" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar"
        aria-controls="mobileSidebar">
        <i class="bi bi-list fs-5"></i>
    </button>

    <div class="container-fluid overflow-hidden p-0">
        <div class="row g-0 flex-nowrap">

            <!-- SIDEBAR UTAMA (Desktop) -->
            <div class="col-auto col-md-3 col-xl-2 sidebar">

                <!-- Logo & Greeting -->
                <div class="sidebar-logo text-center py-4 mt-2">
                    <div class="bg-white text-center d-inline-flex align-items-center justify-content-center rounded-3 mb-3 shadow-sm"
                        style="width: 50px; height: 50px; color: #229799;">
                        <i class="bi bi-wallet2 fs-3"></i>
                    </div>
                    <h5 class="text-white fw-bold mb-0">DAILY</h5>
                    <h5 class="text-white fw-bold">FINANCES</h5>
                    <div class="px-4 mt-3">
                        <hr class="border-light opacity-25">
                    </div>
                    <p class="text-white-50 mb-0 fw-medium small">Welcome back,</p>
                    <p class="text-white fw-semibold mb-0 fs-6"><?= session()->get('user_nama') ?></p>
                </div>

                <!-- Menu Navigation -->
                <nav class="nav flex-column flex-grow-1 overflow-auto mt-2 w-100">
                    <a href="<?= base_url('dashboard') ?>"
                        class="nav-link <?= $activeMenu == 'dashboard' ? 'active' : '' ?>">
                        <i class="bi bi-grid-1x2-fill me-3"></i> Dashboard
                    </a>
                    <a href="<?= base_url('transaksi') ?>"
                        class="nav-link <?= $activeMenu == 'transaksi' ? 'active' : '' ?>">
                        <i class="bi bi-journal-text me-3"></i> Transaksi
                    </a>
                    <a href="<?= base_url('kategori') ?>"
                        class="nav-link <?= $activeMenu == 'kategori' ? 'active' : '' ?>">
                        <i class="bi bi-tags-fill me-3"></i> Kategori
                    </a>
                    <a href="<?= base_url('rekap') ?>" class="nav-link <?= $activeMenu == 'rekap' ? 'active' : '' ?>">
                        <i class="bi bi-calendar3 me-3"></i> Rekap Bulanan
                    </a>
                    <a href="<?= base_url('target') ?>" class="nav-link <?= $activeMenu == 'target' ? 'active' : '' ?>">
                        <i class="bi bi-bullseye me-3"></i> Target Goal
                    </a>
                    <a href="<?= base_url('piutang') ?>"
                        class="nav-link <?= $activeMenu == 'piutang' ? 'active' : '' ?>">
                        <i class="bi bi-people-fill me-3"></i> Buku Piutang
                    </a>
                </nav>

                <!-- Bottom Menu -->
                <div class="sidebar-bottom w-100 pb-4 pt-2">
                    <div class="px-4">
                        <hr class="border-light opacity-25">
                    </div>
                    <a href="<?= base_url('setting') ?>"
                        class="nav-link <?= $activeMenu == 'setting' ? 'active' : '' ?>">
                        <i class="bi bi-gear-fill me-3"></i> Pengaturan
                    </a>
                    <a href="#" class="nav-link text-white mt-1 hover-logout"
                        style="background-color: rgba(255, 0, 0, 0.15);" data-bs-toggle="modal"
                        data-bs-target="#modalLogout">
                        <i class="bi bi-box-arrow-left me-3 text-white"></i> Keluar Akun
                    </a>
                </div>

            </div>

            <!-- KONTEN UTAMA (View Pages) -->
            <div class="col main-content overflow-auto" style="height: 100vh;">
                <?= $this->renderSection('content') ?>
            </div>

        </div>
    </div>

    <!-- SIDEBAR OFFCANVAS (Laci Menu HP) -->
    <div class="offcanvas offcanvas-start mobile-sidebar-bg" tabindex="-1" id="mobileSidebar"
        aria-labelledby="mobileSidebarLabel">
        <div class="offcanvas-header align-items-center py-4 px-4 border-bottom border-light border-opacity-10">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-white d-flex align-items-center justify-content-center rounded-3 shadow-sm"
                    style="width: 45px; height: 45px; color: #229799;">
                    <i class="bi bi-wallet2 fs-4"></i>
                </div>
                <div>
                    <h6 class="text-white fw-bold mb-0" id="mobileSidebarLabel">DAILY FINANCES</h6>
                    <small class="text-white-50 user-greeting">Hi, <?= session()->get('user_nama') ?></small>
                </div>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>

        <div class="offcanvas-body d-flex flex-column justify-content-between p-0">

            <!-- Menu List -->
            <nav class="nav flex-column mt-3">
                <a href="<?= base_url('dashboard') ?>"
                    class="nav-link <?= $activeMenu == 'dashboard' ? 'active' : '' ?>">
                    <i class="bi bi-grid-1x2-fill me-3"></i> Dashboard
                </a>
                <a href="<?= base_url('transaksi') ?>"
                    class="nav-link <?= $activeMenu == 'transaksi' ? 'active' : '' ?>">
                    <i class="bi bi-journal-text me-3"></i> Transaksi
                </a>
                <a href="<?= base_url('kategori') ?>" class="nav-link <?= $activeMenu == 'kategori' ? 'active' : '' ?>">
                    <i class="bi bi-tags-fill me-3"></i> Kategori
                </a>
                <a href="<?= base_url('rekap') ?>" class="nav-link <?= $activeMenu == 'rekap' ? 'active' : '' ?>">
                    <i class="bi bi-calendar3 me-3"></i> Rekap Bulanan
                </a>
                <a href="<?= base_url('target') ?>" class="nav-link <?= $activeMenu == 'target' ? 'active' : '' ?>">
                    <i class="bi bi-bullseye me-3"></i> Target Goal
                </a>
                <a href="<?= base_url('piutang') ?>" class="nav-link <?= $activeMenu == 'piutang' ? 'active' : '' ?>">
                    <i class="bi bi-people-fill me-3"></i> Buku Piutang
                </a>
            </nav>

            <!-- Bottom Menu -->
            <div class="mb-4 mt-auto">
                <div class="px-4">
                    <hr class="border-light opacity-25">
                </div>
                <a href="<?= base_url('setting') ?>" class="nav-link <?= $activeMenu == 'setting' ? 'active' : '' ?>">
                    <i class="bi bi-gear-fill me-3"></i> Pengaturan
                </a>
                <a href="#" class="nav-link text-white mt-2" style="background-color: rgba(255, 0, 0, 0.2);"
                    data-bs-toggle="modal" data-bs-target="#modalLogout" data-bs-dismiss="offcanvas">
                    <i class="bi bi-box-arrow-left me-3"></i> Keluar Akun
                </a>
            </div>
        </div>
    </div>

    <!-- MODAL LOGOUT ELEGAN -->
    <div class="modal fade" id="modalLogout" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-body text-center p-4 p-md-5">
                    <div class="d-inline-flex align-items-center justify-content-center bg-danger bg-opacity-10 rounded-circle mb-4"
                        style="width: 80px; height: 80px;">
                        <i class="bi bi-box-arrow-right text-danger fs-1"></i>
                    </div>
                    <h5 class="fw-bold mb-2 text-dark">Akhiri Sesi?</h5>
                    <p class="text-secondary small mb-4">Anda harus login kembali untuk masuk ke dashboard finansial
                        Anda.</p>

                    <div class="d-flex flex-column gap-2">
                        <a href="<?= base_url('logout') ?>" class="btn btn-danger rounded-pill fw-semibold py-2">Ya,
                            Keluar Akun</a>
                        <button type="button" class="btn btn-light border rounded-pill fw-semibold py-2"
                            data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>