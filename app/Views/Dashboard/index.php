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
                <h4 class="mb-0 fw-bold">Rp 0</h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <p class="text-muted mb-1" style="font-size:13px">📈 Pemasukan Bulan Ini</p>
                <h4 class="mb-0 fw-bold text-success">Rp 0</h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <p class="text-muted mb-1" style="font-size:13px">📉 Pengeluaran Bulan Ini</p>
                <h4 class="mb-0 fw-bold text-danger">Rp 0</h4>
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
                <canvas id="barChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Komposisi Pengeluaran</h6>
                <canvas id="pieChart"></canvas>
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
                        <button class="btn btn-outline-secondary">7 Hari</button>
                        <button class="btn btn-outline-secondary">Bulanan</button>
                        <button class="btn btn-outline-secondary">Tahunan</button>
                    </div>
                </div>
                <canvas id="timeChart"></canvas>
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

<?= $this->endSection() ?>