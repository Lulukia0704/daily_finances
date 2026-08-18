<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daily Finances — Login</title>

    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= base_url('/assets/css/style.css') ?> " rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            /* Background gradien radial yang sangat lembut dan premium */
            background-color: #f4f9f9;
            background-image:
                radial-gradient(circle at top right, #d1ecec, transparent 40%),
                radial-gradient(circle at bottom left, #e8f5f5, transparent 40%);
            min-height: 100vh;
        }

        /* Kartu Login */
        .auth-card {
            max-width: 420px;
            width: 100%;
            border-radius: 1.5rem !important;
            /* Melengkung modern */
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            /* Efek glass tipis */
            box-shadow: 0 20px 40px rgba(34, 151, 153, 0.08) !important;
        }

        /* Ikon Logo Utama */
        .brand-icon {
            width: 75px;
            height: 75px;
            background: linear-gradient(135deg, #229799 0%, #30b1b4 100%);
            color: white;
            border-radius: 22px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 25px rgba(34, 151, 153, 0.3);
            transform: rotate(-5deg);
            /* Desain asimetris modern */
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .brand-icon i {
            transform: rotate(5deg);
            /* Mengembalikan rotasi ikon ke posisi lurus */
            transition: all 0.3s ease;
        }

        .brand-icon:hover {
            transform: rotate(0deg) scale(1.05);
            /* Interaksi saat di-hover */
        }

        .brand-icon:hover i {
            transform: rotate(0deg);
        }

        /* Tombol Login Google */
        .btn-google {
            border: 1px solid #e2e8f0;
            background-color: #ffffff;
            color: #334155;
            font-weight: 600;
            font-size: 15px;
            border-radius: 50rem;
            padding: 14px 20px;
            transition: all 0.2s ease-in-out;
            cursor: pointer;
        }

        .btn-google:hover {
            background-color: #f8fafc;
            border-color: #cbd5e1;
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.05);
            color: #0f172a;
        }

        /* Mengatur font spasi judul */
        .tracking-tight {
            letter-spacing: -0.5px;
        }
    </style>
</head>

<body>

    <div class="container min-vh-100 d-flex align-items-center justify-content-center px-3">
        <div class="card auth-card border-0">
            <div class="card-body p-4 p-sm-5">

                <!-- JUDUL & LOGO -->
                <div class="text-center mb-5 mt-2">
                    <div class="brand-icon mb-4">
                        <i class="bi bi-wallet2 fs-1"></i>
                    </div>
                    <h3 class="fw-bold text-dark tracking-tight mb-2">Daily Finances</h3>
                    <p class="text-secondary small mb-0">Masuk untuk mengelola keuangan cerdasmu hari ini.</p>
                </div>

                <!-- ALERT PESAN -->
                <?php if (session()->getFlashdata('sukses')): ?>
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 d-flex align-items-center mb-4"
                        style="font-size: 14px;" role="alert">
                        <i class="bi bi-check-circle-fill fs-5 me-2 text-success"></i>
                        <div><?= session()->getFlashdata('sukses') ?></div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 d-flex align-items-center mb-4"
                        style="font-size: 14px;" role="alert">
                        <i class="bi bi-exclamation-triangle-fill fs-5 me-2 text-danger"></i>
                        <div><?= session()->getFlashdata('error') ?></div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- LOGIN GOOGLE -->
                <div class="d-grid mb-4">
                    <a href="<?= base_url('auth/google') ?>"
                        class="btn-google text-decoration-none d-flex align-items-center justify-content-center gap-3">
                        <img src="https://www.google.com/favicon.ico" width="22" height="22" alt="Google Logo">
                        <span>Lanjutkan dengan Google</span>
                    </a>
                </div>

                <!-- TRUST BADGE / FOOTER -->
                <div class="text-center mt-5 pt-4 border-top border-light">
                    <p class="text-muted mb-0 d-flex align-items-center justify-content-center gap-1"
                        style="font-size: 12px; font-weight: 500;">
                        <i class="bi bi-shield-check text-success fs-6"></i>
                        Autentikasi aman dan terenkripsi via Google
                    </p>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>