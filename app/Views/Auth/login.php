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

                <!-- {{-- FORM --}} -->
                <form action="<?= base_url('login')?>" method="post">

                <?=csrf_field()?>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="contoh@email.com">
                </div>

                <div class="mb-3">
                    <label class="form-label">Kata sandi</label>
                    <input type="password" name="password" class="form-control" placeholder="Password">
                </div>

                <button class="btn btn-auth w-100 mt-2">Masuk</button>
                
                </form>

                <div class="text-center mt-3">
                    <span class="text-muted" style="font-size:13px">Atau </span>
                    <a href="/daily_finances/public/register" class="auth-link">Daftar</a>
                </div>

                <div class="text-center mt-2">
                    <a href="#" class="auth-link">Lupa Kata sandi?</a>
                </div>

            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>