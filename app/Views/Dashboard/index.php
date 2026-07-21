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
                <p class="text-muted">Belum ada target.</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3">🤝 Piutang Belum Lunas</h6>
                <p class="text-muted">Belum ada piutang.</p>
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