<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-bold" style="color:#229799">Dashboard</h4>
    <span class="text-muted"><?= date('l, d F Y') ?></span>
</div>

<!-- KARTU RINGKASAN -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <p class="text-muted mb-1" style="font-size:13px">💰 Saldo Saat Ini</p>
                <h4 class="mb-0 fw-bold">Rp <?= number_format($saldo, 0, ',', '.') ?></h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <p class="text-muted mb-1" style="font-size:13px">📈 Pemasukan Bulan Ini</p>
                <h4 class="mb-0 fw-bold text-success">Rp <?= number_format($pemasukan, 0, ',', '.') ?></h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <p class="text-muted mb-1" style="font-size:13px">📉 Pengeluaran Bulan Ini</p>
                <h4 class="mb-0 fw-bold text-danger">Rp <?= number_format($pengeluaran, 0, ',', '.') ?></h4>
            </div>
        </div>
    </div>
</div>

<!-- CHART -->
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Total Pengeluaran per Kategori</h6>
                <canvas id="barChart" style="max-height:200px"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Komposisi Pengeluaran</h6>
                <canvas id="pieChart" style="max-height:200px"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- TIME SERIES -->
<div class="row g-3 mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0">Pemasukan vs Pengeluaran</h6>
                    <div class="btn-group btn-group-sm">
                        <a href="<?= base_url('dashboard?periode=7hari') ?>" 
                        class="btn <?= $periode == '7hari' ? 'btn-auth' : 'btn-outline-secondary' ?>">
                            7 Hari
                        </a>
                        <a href="<?= base_url('dashboard?periode=bulanan') ?>" 
                        class="btn <?= $periode == 'bulanan' ? 'btn-auth' : 'btn-outline-secondary' ?>">
                            Bulanan
                        </a>
                        <a href="<?= base_url('dashboard?periode=tahunan') ?>" 
                        class="btn <?= $periode == 'tahunan' ? 'btn-auth' : 'btn-outline-secondary' ?>">
                            Tahunan
                        </a>
                    </div>
                </div>
                <canvas id="timeChart" style="max-height:300px"></canvas>
            </div>
        </div>
    </div>
</div>
<!-- TARGET & PIUTANG -->
<div class="row g-3">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3">🎯 Target Tabungan</h6>
                <?php if (empty($targetBelumTercapai)): ?>
                    <p class="text-muted mb-0">Belum ada target.</p>
                <?php else: ?>
                    <ul class="list-unstyled mb-2">
                        <?php foreach ($targetBelumTercapai as $t): ?>
                            <?php
                                $sisa = $t['target_nominal'] - $t['sudah_terkumpul'];
                                $isOverdue = !empty($t['target_selesai']) && strtotime($t['target_selesai']) < strtotime(date('Y-m-d'));
                                $isSoon = !empty($t['target_selesai']) && !$isOverdue
                                    && strtotime($t['target_selesai']) <= strtotime('+30 days');
                            ?>
                            <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <span>
                                    <?= $t['nama_goal'] ?>
                                    <?php if ($isOverdue): ?>
                                        <span class="badge bg-danger ms-1">Terlambat</span>
                                    <?php elseif ($isSoon): ?>
                                        <span class="badge bg-warning text-dark ms-1">Segera</span>
                                    <?php endif; ?>
                                </span>
                                <span class="text-danger fw-semibold text-nowrap">
                                    Rp <?= number_format($sisa, 0, ',', '.') ?>
                                </span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php if ($targetTotal > 5): ?>
                        <a href="<?= base_url('target') ?>" class="small">Lihat semua (<?= $targetTotal ?>) →</a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3">🤝 Piutang Belum Lunas</h6>
                <?php if (empty($piutangBelumLunas)): ?>
                    <p class="text-muted mb-0">Belum ada piutang.</p>
                <?php else: ?>
                    <ul class="list-unstyled mb-2">
                        <?php foreach ($piutangBelumLunas as $p): ?>
                            <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <span><?= $p['nama_peminjam'] ?></span>
                                <span class="text-danger fw-semibold text-nowrap">
                                    Rp <?= number_format($p['sisa_hutang'], 0, ',', '.') ?>
                                </span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php if ($piutangTotal > 5): ?>
                        <a href="<?= base_url('piutang') ?>" class="small">Lihat semua (<?= $piutangTotal ?>) →</a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// BAR CHART - Pengeluaran per Kategori
const barCtx = document.getElementById('barChart').getContext('2d');
new Chart(barCtx, {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_column($barChart, 'kategori')) ?>,
        datasets: [{
            label: 'Pengeluaran',
            data: <?= json_encode(array_column($barChart, 'total')) ?>,
            backgroundColor: '#48CFCB'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false, // 👈 DITAMBAHKAN: Paksa Bar Chart ikuti tinggi div pembungkus
        plugins: { legend: { display: false } }
    }
});

// PIE CHART - Komposisi Kebutuhan vs Keinginan
const pieCtx = document.getElementById('pieChart').getContext('2d');
new Chart(pieCtx, {
    type: 'pie',
    data: {
        labels: <?= json_encode(array_column($pieChart, 'jenis')) ?>,
        datasets: [{
            data: <?= json_encode(array_column($pieChart, 'total')) ?>,
            backgroundColor: ['#229799', '#48CFCB']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false, // 👈 DIUBAH: Dari true menjadi false agar tidak menggembung!
        plugins: { legend: { position: 'top' } }
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
                tension: 0.4
            },
            {
                label: 'Pengeluaran',
                data: <?= json_encode(array_column($timeSeries, 'pengeluaran')) ?>,
                borderColor: '#e74c3c',
                backgroundColor: 'rgba(231,76,60,0.1)',
                fill: true,
                tension: 0.4
            }
        ]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'top' } },
        scales: {
            y: { ticks: { callback: val => 'Rp ' + val.toLocaleString('id-ID') } }
        }
    }
});
</script>
<?= $this->endSection() ?>