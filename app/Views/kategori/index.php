<?php $this->extend('layouts/main') ?>
<?php $this->section('content') ?>

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-bold" style="color:#229799">Kategori</h4>
</div>

<!-- PESAN SUKSES/ERROR -->
<?php if (session()->getFlashdata('sukses')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('sukses') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- FILTER -->
<div class="mb-3 d-flex flex-wrap gap-1">
    <button class="btn btn-sm filter-btn active" data-filter="semua">Semua</button>
    <button class="btn btn-sm filter-btn" data-filter="aktif">Aktif</button>
    <button class="btn btn-sm filter-btn" data-filter="nonaktif">Nonaktif</button>
</div>

<!-- TABEL -->
<div class="card border-0 shadow-sm">
    <!-- table-responsive agar background web abu-abu tidak terpotong putih saat di-scroll -->
    <div class="card-body p-0 table-responsive">
        <table class="table table-hover mb-0" id="tabelKategori">
            <thead class="table-light">
                <tr>
                    <th style="width: 5%">No</th>
                    <th>Nama Kategori</th>
                    <th>Jenis</th>
                    <th>Anggaran Bulanan</th>
                    <th>Status</th>
                    <th class="text-center" style="width: 15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($kategori)): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            Belum ada kategori
                        </td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($kategori as $k): ?>
                    <tr data-status="<?= strtolower($k['status']) ?>">
                        <td><?= $no++ ?></td>
                        <td><?= $k['nama'] ?></td>
                        <td>
                            <?php if ($k['jenis'] == 'Kebutuhan'): ?>
                                <span class="badge bg-primary"><?= $k['jenis'] ?></span>
                            <?php elseif ($k['jenis'] == 'Keinginan'): ?>
                                <span class="badge bg-warning text-dark"><?= $k['jenis'] ?></span>
                            <?php else: ?>
                                <span class="badge bg-success"><?= $k['jenis'] ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="text-nowrap">
                            <?= $k['anggaran_bulanan'] > 0 
                                ? 'Rp ' . number_format($k['anggaran_bulanan'], 0, ',', '.') 
                                : '<span class="text-muted">-</span>' ?>
                        </td>
                        <td>
                            <?php if ($k['status'] == 'AKTIF'): ?>
                                <span class="badge bg-success">Aktif</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Nonaktif</span>
                            <?php endif; ?>
                        </td>
                        <!-- Memaksa tombol aksi sejajar menyamping -->
                        <td style="white-space: nowrap; text-align: center; vertical-align: middle;">
                            <div class="d-inline-flex gap-1">
                                <a href="<?= base_url('kategori/edit/' . $k['id']) ?>" 
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="<?= base_url('kategori/toggle/' . $k['id']) ?>" 
                                   class="btn btn-sm <?= $k['status'] == 'AKTIF' ? 'btn-outline-danger' : 'btn-outline-success' ?>">
                                    <i class="bi bi-<?= $k['status'] == 'AKTIF' ? 'x-circle' : 'check-circle' ?>"></i>
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

<!-- Script Filter -->
<script>
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        // Update tombol aktif
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');

        const filter = this.dataset.filter;
        document.querySelectorAll('#tabelKategori tbody tr').forEach(row => {
            if (filter === 'semua') {
                row.style.display = '';
            } else {
                row.style.display = row.dataset.status === filter ? '' : 'none';
            }
        });
    });
});
</script>

<?= $this->endSection() ?>