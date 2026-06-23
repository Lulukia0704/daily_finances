<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-bold" style="color:#229799">Target</h4>
    <button class="btn btn-auth" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-lg me-1"></i> Tambah Goal
    </button>
</div>

<!-- PESAN -->
<?php if (session()->getFlashdata('sukses')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?= session()->getFlashdata('sukses') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- FILTER -->
<div class="mb-3">
    <button class="btn btn-sm filter-btn <?= !$filter ? 'active' : '' ?>" 
            onclick="window.location='<?= base_url('target') ?>'">Semua</button>
    <button class="btn btn-sm filter-btn <?= $filter == 'tercapai' ? 'active' : '' ?>"
            onclick="window.location='<?= base_url('target?filter=tercapai') ?>'">Tercapai</button>
    <button class="btn btn-sm filter-btn <?= $filter == 'belum' ? 'active' : '' ?>"
            onclick="window.location='<?= base_url('target?filter=belum') ?>'">Belum Tercapai</button>
</div>

<!-- TABEL -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width:40px">No</th>
                    <th style="width:200px" >Nama Target</th>
                    <th class="text-end" style="width:150px">Target Nominal</th>
                    <th class="text-end" style="width:150px">Sudah Terkumpul</th>
                    <th class="text-end" style="width:120px">Sisa</th>
                    <th style="width:120px">Target Selesai</th>
                    <th style="width:100px">Status</th>
                    <th style="width:90px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($target)): ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            Belum ada target
                        </td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($target as $t): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $t['nama_goal'] ?></td>
                        <td class="text-end text-success">
                            Rp <?= number_format($t['target_nominal'], 0, ',', '.') ?>
                        </td>
                        <td class="text-end">
                            Rp <?= number_format($t['sudah_terkumpul'], 0, ',', '.') ?>
                        </td>
                        <td class="text-end text-danger">
                            Rp <?= number_format($t['sisa'], 0, ',', '.') ?>
                        </td>
                        <td class="text-nowrap">
                            <?= !empty($t['target_selesai']) 
                                ? date('d M Y', strtotime($t['target_selesai'])) 
                                : '-' ?>
                        </td>
                        <td>
                            <?php if ($t['status'] == 'Tercapai'): ?>
                                <span class="badge bg-success">Tercapai</span>
                            <?php elseif ($t['status'] == 'Terlambat'): ?>
                                <span class="badge bg-danger">Terlambat</span>
                            <?php elseif ($t['status'] == 'On Track'): ?>
                                <span class="badge bg-warning text-dark">On Track</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Berjalan</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-nowrap">
                            <a href="<?= base_url('target/edit/' . $t['id']) ?>" 
                               class="btn btn-sm btn-outline-primary me-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="<?= base_url('target/hapus/' . $t['id']) ?>" 
                               class="btn btn-sm btn-outline-danger"
                               onclick="return confirm('Yakin ingin menghapus?')">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- PAGINATION -->
<?php 
$totalPage = ceil($total / $perPage);
if ($totalPage > 1): ?>
<nav class="mt-3">
    <ul class="pagination">
        <?php for ($i = 1; $i <= $totalPage; $i++): ?>
        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
            <a class="page-link" href="<?= base_url('target') ?>?filter=<?= $filter ?>&page=<?= $i ?>">
                <?= $i ?>
            </a>
        </li>
        <?php endfor; ?>
    </ul>
</nav>
<?php endif; ?>

<!-- MODAL TAMBAH -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Tambah Goal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('target/simpan') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label">Nama Goal</label>
                        <input type="text" name="nama_goal" class="form-control" 
                               placeholder="Contoh: Beli HP" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Target Nominal</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="target_nominal" class="form-control" 
                                   placeholder="0" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Target Selesai <span class="text-muted">(opsional)</span></label>
                        <input type="date" name="target_selesai" class="form-control">
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-auth">Simpan</button>
                        <button type="button" class="btn btn-outline-secondary" 
                                data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>