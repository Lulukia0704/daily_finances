<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!-- HEADER -->
<div class="d-flex align-items-center mb-4">
    <a href="<?= base_url('piutang') ?>" class="btn btn-sm btn-outline-secondary me-3">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h4 class="mb-0 fw-bold" style="color:#229799">Detail Piutang</h4>
    <button onclick="window.print()" class="btn btn-sm btn-auth ms-auto">
        <i class="bi bi-printer me-1"></i> Cetak Struk
    </button>
</div>

<!-- INFO PEMINJAM -->
<div class="card border-0 shadow-sm mb-4" id="printArea">
    <div class="card-body">

        <!-- Header Struk -->
        <div class="text-center mb-4 d-none d-print-block">
            <h4 class="fw-bold">Daily Finances</h4>
            <p class="text-muted mb-0">Struk Piutang</p>
            <hr>
        </div>

        <!-- Info -->
        <div class="row mb-4">
            <div class="col-md-6">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td class="text-muted" style="width:140px">Nama Peminjam</td>
                        <td>: <strong><?= $piutang['nama_peminjam'] ?></strong></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Tanggal Pinjam</td>
                        <td>: <?= date('d M Y', strtotime($piutang['tanggal_pinjam'])) ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Jumlah Pinjam</td>
                        <td>: <strong>Rp <?= number_format($piutang['jumlah_pinjam'], 0, ',', '.') ?></strong></td>
                    </tr>
                    <?php if (!empty($piutang['keterangan'])): ?>
                    <tr>
                        <td class="text-muted">Keterangan</td>
                        <td>: <?= $piutang['keterangan'] ?></td>
                    </tr>
                    <?php endif; ?>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td class="text-muted" style="width:140px">Sudah Dibayar</td>
                        <td>: <strong class="text-success">Rp <?= number_format($sudah_dibayar, 0, ',', '.') ?></strong></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Sisa Hutang</td>
                        <td>: <strong class="text-danger">Rp <?= number_format(max(0, $sisa_hutang), 0, ',', '.') ?></strong></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Status</td>
                        <td>:
                            <?php if ($status == 'Lunas'): ?>
                                <span class="badge bg-success">Lunas</span>
                            <?php elseif ($status == 'Lebih Bayar'): ?>
                                <span class="badge bg-warning text-dark">Lebih Bayar</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Belum Lunas</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <hr>

        <!-- Riwayat Pembayaran -->
        <h6 class="fw-bold mb-3">Riwayat Pembayaran</h6>
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th style="width:40px">No</th>
                    <th>Tanggal Bayar</th>
                    <th class="text-end">Jumlah Bayar</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($riwayat)): ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted py-3">
                            Belum ada pembayaran
                        </td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($riwayat as $r): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= date('d M Y', strtotime($r['tanggal_bayar'])) ?></td>
                        <td class="text-end text-success">
                            Rp <?= number_format($r['jumlah_bayar'], 0, ',', '.') ?>
                        </td>
                        <td><?= $r['keterangan'] ?? '-' ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
            <tfoot class="table-light fw-bold">
                <tr>
                    <td colspan="2">Total Dibayar</td>
                    <td class="text-end text-success">
                        Rp <?= number_format($sudah_dibayar, 0, ',', '.') ?>
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>

    </div>
</div>

<!-- CSS Print -->
<style>
@media print {
    .sidebar, .main-content > .d-flex, .btn, nav {
        display: none !important;
    }
    .main-content {
        margin-left: 0 !important;
        padding: 0 !important;
    }
    .card {
        box-shadow: none !important;
        border: none !important;
    }
}
</style>

<?= $this->endSection() ?>