<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="mx-auto" style="max-width: 850px;">
    <!-- HEADER -->
    <div class="d-flex align-items-center mb-4 gap-3">
        <a href="<?= base_url('piutang') ?>"
            class="btn btn-light border rounded-circle shadow-sm d-flex align-items-center justify-content-center"
            style="width: 40px; height: 40px;" data-bs-toggle="tooltip" title="Kembali">
            <i class="bi bi-arrow-left text-secondary"></i>
        </a>
        <div class="d-flex align-items-center gap-2">
            <div class="bg-opacity-10 p-2 rounded-3" style="background-color: #229799; color: #229799;">
                <i class="bi bi-receipt fs-5"></i>
            </div>
            <h4 class="mb-0 fw-bold" style="color:#229799">Detail Piutang</h4>
        </div>
        <button onclick="window.print()" class="btn btn-auth rounded-pill px-4 shadow-sm ms-auto d-print-none">
            <i class="bi bi-printer me-1"></i> Cetak Struk
        </button>
    </div>

    <!-- MAIN CARD (INVOICE AREA) -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" id="printArea">
        <div class="card-body p-4 p-md-5">

            <!-- Header Struk (Hanya terlihat saat diprint) -->
            <div class="text-center mb-4 pb-3 border-bottom border-2 border-dashed d-none d-print-block">
                <h3 class="fw-bold text-dark mb-1">Daily Finances</h3>
                <p class="text-muted mb-0">Laporan Rincian Piutang / Hutang</p>
            </div>

            <!-- INFO PEMINJAM & STATUS -->
            <div class="row g-4 mb-5">
                <!-- Kolom Kiri: Info Peminjam -->
                <div class="col-12 col-md-6">
                    <h6 class="fw-bold text-secondary mb-3 pb-2 border-bottom"><i
                            class="bi bi-person-lines-fill me-2"></i>Informasi Peminjam</h6>
                    <div class="d-flex flex-column gap-2 small fs-6">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Nama Peminjam</span>
                            <span class="fw-bold text-dark"><?= $piutang['nama_peminjam'] ?></span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Tanggal Pinjam</span>
                            <span class="text-dark"><?= date('d M Y', strtotime($piutang['tanggal_pinjam'])) ?></span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Jumlah Pinjam</span>
                            <span class="fw-bold text-primary">Rp
                                <?= number_format($piutang['jumlah_pinjam'], 0, ',', '.') ?></span>
                        </div>
                        <?php if (!empty($piutang['keterangan'])): ?>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Keterangan</span>
                                <span class="text-dark text-end ms-3"><?= $piutang['keterangan'] ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Kolom Kanan: Info Pembayaran & Status -->
                <div class="col-12 col-md-6">
                    <h6 class="fw-bold text-secondary mb-3 pb-2 border-bottom"><i class="bi bi-wallet2 me-2"></i>Status
                        Pembayaran</h6>
                    <div class="d-flex flex-column gap-2 small fs-6">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Sudah Dibayar</span>
                            <span class="text-success fw-bold bg-success bg-opacity-10 px-2 py-1 rounded-2">
                                Rp <?= number_format($sudah_dibayar, 0, ',', '.') ?>
                            </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Sisa Hutang</span>
                            <span class="text-danger fw-bold bg-danger bg-opacity-10 px-2 py-1 rounded-2">
                                Rp <?= number_format(max(0, $sisa_hutang), 0, ',', '.') ?>
                            </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-1">
                            <span class="text-muted">Status</span>
                            <div>
                                <?php if ($status == 'Lunas'): ?>
                                    <span
                                        class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-1 rounded-pill fw-medium"><i
                                            class="bi bi-check-circle me-1"></i> Lunas</span>
                                <?php elseif ($status == 'Lebih Bayar'): ?>
                                    <span
                                        class="badge bg-warning bg-opacity-10 text-dark border border-warning border-opacity-25 px-3 py-1 rounded-pill fw-medium"><i
                                            class="bi bi-info-circle me-1"></i> Lebih Bayar</span>
                                <?php else: ?>
                                    <span
                                        class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-1 rounded-pill fw-medium"><i
                                            class="bi bi-clock-history me-1"></i> Belum Lunas</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIWAYAT PEMBAYARAN -->
            <h6 class="fw-bold text-secondary mb-3"><i class="bi bi-clock-history me-2"></i>Riwayat Pembayaran</h6>
            <div class="table-responsive border rounded-3 overflow-hidden">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-muted">
                        <tr>
                            <th class="ps-4" style="width:50px">No</th>
                            <th style="min-width:140px">Tanggal Bayar</th>
                            <th class="text-end" style="min-width:160px">Jumlah Bayar</th>
                            <th style="min-width:200px">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        <?php if (empty($riwayat)): ?>
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <div class="text-muted d-flex flex-column align-items-center">
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mb-3"
                                            style="width: 50px; height: 50px;">
                                            <i class="bi bi-receipt-cutoff fs-3"></i>
                                        </div>
                                        <h6 class="fw-semibold mb-0">Belum ada riwayat pembayaran</h6>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1;
                            foreach ($riwayat as $r): ?>
                                <tr>
                                    <td class="ps-4 text-muted"><?= $no++ ?></td>
                                    <td class="text-nowrap text-secondary fw-medium">
                                        <i
                                            class="bi bi-calendar2-event me-2 opacity-50"></i><?= date('d M Y', strtotime($r['tanggal_bayar'])) ?>
                                    </td>
                                    <td class="text-end text-success fw-semibold text-nowrap">
                                        Rp <?= number_format($r['jumlah_bayar'], 0, ',', '.') ?>
                                    </td>
                                    <td class="text-secondary">
                                        <?= $r['keterangan'] ?: '<i class="text-muted opacity-50">-</i>' ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                    <tfoot class="bg-light border-top">
                        <tr>
                            <td colspan="2" class="ps-4 fw-bold text-secondary py-3 text-nowrap">Total Dibayar</td>
                            <td class="text-end fw-bold text-success text-nowrap fs-6">
                                Rp <?= number_format($sudah_dibayar, 0, ',', '.') ?>
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>
    </div>
</div>

<!-- CSS Print Khusus -->
<style>
    /* Utilities border dashed khusus invoice */
    .border-dashed {
        border-style: dashed !important;
    }

    @media print {
        body {
            background-color: white !important;
        }

        .sidebar,
        nav,
        .d-print-none,
        .btn {
            display: none !important;
        }

        .main-content {
            margin-left: 0 !important;
            padding: 0 !important;
        }

        .card {
            box-shadow: none !important;
            border: none !important;
            border-radius: 0 !important;
        }

        .card-body {
            padding: 0 !important;
        }

        .bg-opacity-10 {
            background-color: transparent !important;
        }

        /* Memaksa warna tetap muncul saat print di beberapa browser */
        .text-success {
            color: #198754 !important;
        }

        .text-danger {
            color: #dc3545 !important;
        }

        .text-primary {
            color: #0d6efd !important;
        }

        .badge {
            border: 1px solid #ccc !important;
            color: #000 !important;
            background-color: transparent !important;
        }
    }
</style>

<!-- Script opsional untuk tooltip tombol kembali -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>

<?= $this->endSection() ?>