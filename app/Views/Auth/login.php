<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daily Finances — Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= base_url('/assets/css/style.css')?> " rel="stylesheet">
    <!-- <link href="http://localhost/daily_finances/public/assets/css/style.css" rel="stylesheet"> -->
</head>
<body class="auth-body">

    <div class="container min-vh-100 d-flex align-items-center justify-content-center">
        <div class="card auth-card">
            <div class="card-body p-4">

                <!-- {{-- JUDUL --}} -->
                <div class="text-center mb-4">
                    <h3 class="auth-title">Daily Finances</h3>
                    <p class="auth-subtitle">Masuk ke akunmu</p>
                </div>

                <!-- ALERT -->
                <?php if (session()->getFlashdata('sukses')): ?>
                    <div class="alert alert-success" role="alert">
                        <?= session()->getFlashdata('sukses') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <!-- {{-- LOGIN GOOGLE --}} -->
                <div class="d-grid mb-3">
                    <a href="<?= base_url('auth/google') ?>" class="btn btn-outline-secondary d-flex align-items-center justify-content-center gap-2">
                        <img src="https://www.google.com/favicon.ico" width="18" height="18" alt="Google">
                        Masuk dengan Google
                    </a>
                </div>

            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>