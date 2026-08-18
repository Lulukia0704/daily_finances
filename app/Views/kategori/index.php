<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!-- HEADER -->
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div class="d-flex align-items-center gap-2">
        <div class="bg-opacity-10 p-2 rounded-3" style="background-color: #229799; color: #229799;">
            <i class="bi bi-tags-fill fs-4"></i>
        </div>
        <h4 class="mb-0 fw-bold" style="color:#229799">Data Kategori</h4>
    </div>
</div>

<!-- PESAN SUKSES/ERROR -->
<?php if (session()->getFlashdata('sukses')): ?>
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 d-flex align-items-center"
        role="alert">
        <i class="bi bi-check-circle-fill fs-5 me-2 text-success"></i>
        <div><?= session()->getFlashdata('sukses') ?></div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 d-flex align-items-center"
        role="alert">
        <i class="bi bi-exclamation-triangle-fill fs-5 me-2 text-danger"></i>
        <div><?= session()->getFlashdata('error') ?></div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- FILTER INTERAKTIF -->
<div class="mb-4 d-flex flex-wrap gap-2">
    <button class="btn btn-sm rounded-pill px-4 fw-medium filter-btn btn-auth shadow-sm" data-filter="semua">
        <i class="bi bi-collection me-1"></i> Semua
    </button>
    <button class="btn btn-sm rounded-pill px-4 fw-medium filter-btn btn-light border text-secondary"
        data-filter="aktif">
        <i class="bi bi-check2-circle me-1"></i> Aktif
    </button>
    <button class="btn btn-sm rounded-pill px-4 fw-medium filter-btn btn-light border text-secondary"
        data-filter="nonaktif">
        <i class="bi bi-x-circle me-1"></i> Nonaktif
    </button>
</div>

<!-- TABEL -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
    <div class="card-body p-0 table-responsive">
        <table class="table table-hover align-middle mb-0" id="tabelKategori">
            <thead class="table-light text-muted">
                <tr>
                    <th class="ps-4" style="width: 5%">No</th>
                    <th style="min-width: 180px;">Nama Kategori</th>
                    <th style="min-width: 140px;">Jenis</th>
                    <th class="text-end" style="min-width: 160px;">Anggaran Bulanan</th>
                    <th class="text-center" style="min-width: 120px;">Status</th>
                    <th class="text-center pe-4" style="width: 120px;">Aksi</th>
                </tr>
            </thead>
            <tbody class="border-top-0">
                <?php if (empty($kategori)): ?>
                    <tr class="empty-state-row">
                        <td colspan="6" class="text-center py-5">
                            <div class="text-muted d-flex flex-column align-items-center">
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mb-3"
                                    style="width: 60px; height: 60px;">
                                    <i class="bi bi-tags fs-2"></i>
                                </div>
                                <h6 class="fw-semibold mb-1">Belum ada kategori</h6>
                                <small>Kategori yang Anda buat akan muncul di sini.</small>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1;
                    foreach ($kategori as $k): ?>
                        <tr data-status="<?= strtolower($k['status']) ?>" class="data-row">
                            <td class="ps-4 text-muted"><?= $no++ ?></td>
                            <td class="fw-medium text-dark"><?= $k['nama'] ?></td>
                            <td>
                                <?php if ($k['jenis'] == 'Kebutuhan'): ?>
                                    <span
                                        class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2 py-1 rounded-pill fw-medium">
                                        <i class="bi bi-bag me-1"></i> <?= $k['jenis'] ?>
                                    </span>
                                <?php elseif ($k['jenis'] == 'Keinginan'): ?>
                                    <span
                                        class="badge bg-warning bg-opacity-10 text-dark border border-warning border-opacity-25 px-2 py-1 rounded-pill fw-medium">
                                        <i class="bi bi-star me-1"></i> <?= $k['jenis'] ?>
                                    </span>
                                <?php else: ?>
                                    <span
                                        class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 rounded-pill fw-medium">
                                        <i class="bi bi-bookmark me-1"></i> <?= $k['jenis'] ?>
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end text-nowrap">
                                <?php if ($k['anggaran_bulanan'] > 0): ?>
                                    <span class="text-secondary fw-semibold">
                                        Rp <?= number_format($k['anggaran_bulanan'], 0, ',', '.') ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-muted opacity-50">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if ($k['status'] == 'AKTIF'): ?>
                                    <span
                                        class="badge bg-success bg-opacity-10 text-success px-2 py-1 rounded-2 fw-medium">Aktif</span>
                                <?php else: ?>
                                    <span
                                        class="badge bg-secondary bg-opacity-10 text-secondary px-2 py-1 rounded-2 fw-medium">Nonaktif</span>
                                <?php endif; ?>
                            </td>
                            <td class="pe-4 text-center">
                                <div class="d-inline-flex gap-2">
                                    <a href="<?= base_url('kategori/edit/' . $k['id']) ?>"
                                        class="btn btn-sm btn-light border text-primary rounded-circle" data-bs-toggle="tooltip"
                                        title="Edit Kategori">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="<?= base_url('kategori/toggle/' . $k['id']) ?>"
                                        class="btn btn-sm btn-light border <?= $k['status'] == 'AKTIF' ? 'text-danger' : 'text-success' ?> rounded-circle"
                                        data-bs-toggle="tooltip"
                                        title="<?= $k['status'] == 'AKTIF' ? 'Nonaktifkan Kategori' : 'Aktifkan Kategori' ?>">
                                        <i class="bi bi-<?= $k['status'] == 'AKTIF' ? 'x-circle' : 'check2-circle' ?>"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Script Filter Kategori & Tooltip -->
<script>
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            // Reset semua tombol menjadi desain non-aktif
            document.querySelectorAll('.filter-btn').forEach(b => {
                b.classList.remove('btn-auth', 'shadow-sm');
                b.classList.add('btn-light', 'border', 'text-secondary');
            });

            // Ubah tombol yang diklik menjadi desain aktif
            this.classList.remove('btn-light', 'border', 'text-secondary');
            this.classList.add('btn-auth', 'shadow-sm');

            const filter = this.dataset.filter;

            // Filter baris yang memiliki class 'data-row'
            document.querySelectorAll('#tabelKategori tbody tr.data-row').forEach(row => {
                if (filter === 'semua') {
                    row.style.display = '';
                } else {
                    row.style.display = row.dataset.status === filter ? '' : 'none';
                }
            });
        });
    });

    // Inisialisasi Tooltip Bootstrap (memunculkan label melayang pada tombol aksi)
    document.addEventListener("DOMContentLoaded", function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>

<?= $this->endSection() ?>