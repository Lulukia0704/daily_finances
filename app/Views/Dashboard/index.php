<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- HEADER -->
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div class="d-flex align-items-center gap-2">
        <div class="bg-opacity-10 p-2 rounded-3" style="background-color: #229799; color: #229799;">
            <i class="bi bi-grid-1x2-fill fs-4"></i>
        </div>
        <h4 class="mb-0 fw-bold" style="color:#229799">Dashboard Overview</h4>
    </div>
    <div class="bg-white border px-4 py-2 rounded-pill shadow-sm d-flex align-items-center">
        <i class="bi bi-calendar2-week text-secondary me-2"></i>
        <span class="text-dark fw-medium fs-6"><?= date('l, d F Y') ?></span>
    </div>
</div>

<!-- KARTU RINGKASAN (SUMMARY CARDS) -->
<div class="row g-3 mb-4">
    <!-- Card Saldo -->
    <div class="col-12 col-md-4">
        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden"
            style="background: linear-gradient(135deg, #229799 0%, #30b1b4 100%);">
            <div class="card-body p-4 position-relative">
                <i class="bi bi-wallet2 position-absolute opacity-25"
                    style="font-size: 5rem; right: -10px; bottom: -15px; color: white;"></i>
                <p class="text-white text-opacity-75 mb-1 fw-medium small">Total Saldo Saat Ini</p>
                <h3 class="mb-0 fw-bold text-white tracking-tight">Rp <?= number_format($saldo, 0, ',', '.') ?></h3>
            </div>
        </div>
    </div>
    <!-- Card Pemasukan -->
    <div class="col-12 col-md-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4 d-flex align-items-center gap-3">
                <div class="bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center rounded-circle"
                    style="width: 50px; height: 50px;">
                    <i class="bi bi-arrow-down-left fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-1 fw-medium small">Pemasukan Bulan Ini</p>
                    <h4 class="mb-0 fw-bold text-success">Rp <?= number_format($pemasukan, 0, ',', '.') ?></h4>
                </div>
            </div>
        </div>
    </div>
    <!-- Card Pengeluaran -->
    <div class="col-12 col-md-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4 d-flex align-items-center gap-3">
                <div class="bg-danger bg-opacity-10 text-danger d-flex align-items-center justify-content-center rounded-circle"
                    style="width: 50px; height: 50px;">
                    <i class="bi bi-arrow-up-right fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-1 fw-medium small">Pengeluaran Bulan Ini</p>
                    <h4 class="mb-0 fw-bold text-danger">Rp <?= number_format($pengeluaran, 0, ',', '.') ?></h4>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CHARTS ROW 1 (BAR & PIE) -->
<div class="row g-3 mb-4">
    <!-- Bar Chart -->
    <div class="col-12 col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-bar-chart-fill text-secondary me-2"></i>Pengeluaran
                    per Kategori</h6>
            </div>
            <div class="card-body p-4">
                <!-- Wrapper relatif penting agar maintainAspectRatio: false di JS bekerja sempurna -->
                <div style="position: relative; height: 260px; width: 100%;">
                    <canvas id="barChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <!-- Pie Chart -->
    <div class="col-12 col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-pie-chart-fill text-secondary me-2"></i>Komposisi
                    Pengeluaran</h6>
            </div>
            <div class="card-body p-4 d-flex align-items-center justify-content-center">
                <div style="position: relative; height: 260px; width: 100%;">
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- TIME SERIES CHART -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                    <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-graph-up text-secondary me-2"></i>Arus Kas:
                        Pemasukan vs Pengeluaran</h6>

                    <!-- Segmented Control Button (Gaya Modern) -->
                    <div class="bg-light p-1 rounded-pill d-inline-flex border">
                        <a href="<?= base_url('dashboard?periode=7hari') ?>"
                            class="btn btn-sm rounded-pill fw-medium px-3 <?= $periode == '7hari' ? 'btn-auth shadow-sm' : 'text-muted border-0' ?>">
                            7 Hari
                        </a>
                        <a href="<?= base_url('dashboard?periode=bulanan') ?>"
                            class="btn btn-sm rounded-pill fw-medium px-3 <?= $periode == 'bulanan' ? 'btn-auth shadow-sm' : 'text-muted border-0' ?>">
                            Bulanan
                        </a>
                        <a href="<?= base_url('dashboard?periode=tahunan') ?>"
                            class="btn btn-sm rounded-pill fw-medium px-3 <?= $periode == 'tahunan' ? 'btn-auth shadow-sm' : 'text-muted border-0' ?>">
                            Tahunan
                        </a>
                    </div>
                </div>
                <div style="position: relative; height: 320px; width: 100%;">
                    <canvas id="timeChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- TARGET & PIUTANG -->
<div class="row g-3 mb-4">

    <!-- Target Tabungan -->
    <div class="col-12 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div
                class="card-header bg-white border-bottom pt-4 pb-3 px-4 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-bullseye text-primary me-2"></i>Target Menabung</h6>
                <?php if ($targetTotal > 5): ?>
                    <a href="<?= base_url('target') ?>" class="text-decoration-none small fw-medium text-auth">Lihat
                        Semua</a>
                <?php endif; ?>
            </div>
            <div class="card-body p-0">
                <?php if (empty($targetBelumTercapai)): ?>
                    <div class="text-center py-5">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-2"
                            style="width: 50px; height: 50px;">
                            <i class="bi bi-flag text-muted fs-4"></i>
                        </div>
                        <p class="text-muted small mb-0">Belum ada target yang sedang berjalan.</p>
                    </div>
                <?php else: ?>
                    <div class="list-group list-group-flush rounded-bottom-4">
                        <?php foreach ($targetBelumTercapai as $t): ?>
                            <?php
                            $sisa = $t['target_nominal'] - $t['sudah_terkumpul'];
                            $isOverdue = !empty($t['target_selesai']) && strtotime($t['target_selesai']) < strtotime(date('Y-m-d'));
                            $isSoon = !empty($t['target_selesai']) && !$isOverdue && strtotime($t['target_selesai']) <= strtotime('+30 days');
                            ?>
                            <div class="list-group-item px-4 py-3 border-bottom border-light">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1 text-dark fw-medium"><?= $t['nama_goal'] ?></h6>
                                        <div class="d-flex gap-2">
                                            <?php if ($isOverdue): ?>
                                                <span
                                                    class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 rounded-pill"
                                                    style="font-size: 11px;">Terlambat</span>
                                            <?php elseif ($isSoon): ?>
                                                <span
                                                    class="badge bg-warning bg-opacity-10 text-dark border border-warning border-opacity-25 px-2 rounded-pill"
                                                    style="font-size: 11px;">Segera Berakhir</span>
                                            <?php else: ?>
                                                <span class="badge bg-light text-secondary border px-2 rounded-pill"
                                                    style="font-size: 11px;">Berjalan</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <span class="d-block text-muted" style="font-size: 12px;">Kurang</span>
                                        <span class="text-primary fw-bold">Rp <?= number_format($sisa, 0, ',', '.') ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Piutang Belum Lunas -->
    <div class="col-12 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div
                class="card-header bg-white border-bottom pt-4 pb-3 px-4 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-people-fill text-warning me-2"></i>Piutang Belum
                    Lunas</h6>
                <?php if ($piutangTotal > 5): ?>
                    <a href="<?= base_url('piutang') ?>" class="text-decoration-none small fw-medium text-auth">Lihat
                        Semua</a>
                <?php endif; ?>
            </div>
            <div class="card-body p-0">
                <?php if (empty($piutangBelumLunas)): ?>
                    <div class="text-center py-5">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-2"
                            style="width: 50px; height: 50px;">
                            <i class="bi bi-check2-all text-muted fs-4"></i>
                        </div>
                        <p class="text-muted small mb-0">Hore! Tidak ada piutang yang nyangkut.</p>
                    </div>
                <?php else: ?>
                    <div class="list-group list-group-flush rounded-bottom-4">
                        <?php foreach ($piutangBelumLunas as $p): ?>
                            <div class="list-group-item px-4 py-3 border-bottom border-light">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-secondary bg-opacity-10 text-secondary d-flex align-items-center justify-content-center rounded-circle"
                                            style="width: 40px; height: 40px;">
                                            <i class="bi bi-person fw-bold"></i>
                                        </div>
                                        <h6 class="mb-0 text-dark fw-medium"><?= $p['nama_peminjam'] ?></h6>
                                    </div>
                                    <div class="text-end">
                                        <span class="d-block text-muted" style="font-size: 12px;">Sisa Hutang</span>
                                        <span class="text-danger fw-bold">Rp
                                            <?= number_format($p['sisa_hutang'], 0, ',', '.') ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>

<!-- LIBRARY CHART.JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    /* SEMUA LOGIKA JS TETAP SAMA PERSIS, HANYA PEMANGGILANNYA LEBIH AMAN DI DALAM DIV RELATIF */

    // BAR CHART - Pengeluaran per Kategori
    const barCtx = document.getElementById('barChart').getContext('2d');
    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_column($barChart, 'kategori')) ?>,
            datasets: [{
                label: 'Pengeluaran',
                data: <?= json_encode(array_column($barChart, 'total')) ?>,
                backgroundColor: '#48CFCB',
                borderRadius: 6 // Tambahan visual: Ujung bar sedikit melengkung
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { border: { display: false }, grid: { color: 'rgba(0,0,0,0.05)' } },
                x: { border: { display: false }, grid: { display: false } }
            }
        }
    });

    // PIE CHART - Komposisi Kebutuhan vs Keinginan
    const pieCtx = document.getElementById('pieChart').getContext('2d');
    new Chart(pieCtx, {
        type: 'doughnut', // Diubah menjadi doughnut agar lebih modern (opsional, jika ingin pie ganti ke 'pie')
        data: {
            labels: <?= json_encode(array_column($pieChart, 'jenis')) ?>,
            datasets: [{
                data: <?= json_encode(array_column($pieChart, 'total')) ?>,
                backgroundColor: ['#229799', '#48CFCB'],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%', // Membuat lubang di tengah
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } }
            }
        }
    });

    // TIME SERIES CHART
    const timeCtx = document.getElementById('timeChart').getContext('2d');
    new Chart(timeCtx, {
        type: 'line',
        data: {
            labels: <?= json_encode(array_column($timeSeries, 'label')) ?>,
            datasets: [
                {
                    label: 'Pemasukan',
                    data: <?= json_encode(array_column($timeSeries, 'pemasukan')) ?>,
                    borderColor: '#229799',
                    backgroundColor: 'rgba(34,151,153,0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2,
                    pointRadius: 3,
                    pointBackgroundColor: '#fff'
                },
                {
                    label: 'Pengeluaran',
                    data: <?= json_encode(array_column($timeSeries, 'pengeluaran')) ?>,
                    borderColor: '#e74c3c',
                    backgroundColor: 'rgba(231,76,60,0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2,
                    pointRadius: 3,
                    pointBackgroundColor: '#fff'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'top', labels: { usePointStyle: true } } },
            scales: {
                y: {
                    border: { display: false },
                    grid: { color: 'rgba(0,0,0,0.05)' },
                    ticks: { callback: val => 'Rp ' + val.toLocaleString('id-ID') }
                },
                x: {
                    border: { display: false },
                    grid: { display: false }
                }
            }
        }
    });
</script>
<?= $this->endSection() ?>