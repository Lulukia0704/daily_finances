<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!-- HEADER -->
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div class="d-flex align-items-center gap-2">
        <div class="bg-opacity-10 p-2 rounded-3" style="background-color: #229799; color: #229799;">
            <i class="bi bi-bullseye fs-4"></i>
        </div>
        <h4 class="mb-0 fw-bold" style="color:#229799">Target & Goal</h4>
    </div>
    <button class="btn btn-auth shadow-sm px-4 rounded-pill" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-circle me-1"></i> Tambah Goal
    </button>
</div>

<!-- PESAN -->
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

<!-- FILTER -->
<div class="mb-4 d-flex flex-wrap gap-2">
    <button
        class="btn btn-sm rounded-pill px-4 fw-medium <?= !$filter ? 'btn-auth shadow-sm' : 'btn-light border text-secondary' ?>"
        onclick="window.location='<?= base_url('target') ?>'">
        <i class="bi bi-collection me-1"></i> Semua
    </button>
    <button
        class="btn btn-sm rounded-pill px-4 fw-medium <?= $filter == 'tercapai' ? 'btn-auth shadow-sm' : 'btn-light border text-secondary' ?>"
        onclick="window.location='<?= base_url('target?filter=tercapai') ?>'">
        <i class="bi bi-check2-circle me-1"></i> Tercapai
    </button>
    <button
        class="btn btn-sm rounded-pill px-4 fw-medium <?= $filter == 'belum' ? 'btn-auth shadow-sm' : 'btn-light border text-secondary' ?>"
        onclick="window.location='<?= base_url('target?filter=belum') ?>'">
        <i class="bi bi-hourglass-split me-1"></i> Belum Tercapai
    </button>
</div>

<!-- TABEL -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
    <div class="card-body p-0 table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-muted">
                <tr>
                    <th class="ps-4" style="width:40px">No</th>
                    <th style="min-width:200px">Nama Target</th>
                    <th class="text-end" style="min-width:140px">Target Nominal</th>
                    <th class="text-end" style="min-width:140px">Terkumpul</th>
                    <th class="text-end" style="min-width:120px">Sisa</th>
                    <th style="min-width:130px">Tenggat Waktu</th>
                    <th class="text-center" style="min-width:110px">Status</th>
                    <th class="text-center pe-4" style="width:90px">Aksi</th>
                </tr>
            </thead>
            <tbody class="border-top-0">
                <?php if (empty($target)): ?>
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <div class="text-muted d-flex flex-column align-items-center">
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mb-3"
                                    style="width: 60px; height: 60px;">
                                    <i class="bi bi-flag fs-2"></i>
                                </div>
                                <h6 class="fw-semibold mb-1">Belum ada target</h6>
                                <small>Mulai buat goal finansial Anda sekarang!</small>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1;
                    foreach ($target as $t): ?>
                        <tr>
                            <td class="ps-4 text-muted"><?= $no++ ?></td>
                            <td class="fw-medium text-dark"><?= $t['nama_goal'] ?></td>
                            <td class="text-end text-nowrap">
                                <span class="text-primary fw-semibold">
                                    Rp <?= number_format($t['target_nominal'], 0, ',', '.') ?>
                                </span>
                            </td>
                            <td class="text-end text-nowrap">
                                <span class="text-success fw-semibold bg-success bg-opacity-10 px-2 py-1 rounded-2">
                                    Rp <?= number_format($t['sudah_terkumpul'], 0, ',', '.') ?>
                                </span>
                            </td>
                            <td class="text-end text-nowrap">
                                <?php if ($t['sisa'] > 0): ?>
                                    <span class="text-danger fw-semibold bg-danger bg-opacity-10 px-2 py-1 rounded-2">
                                        Rp <?= number_format($t['sisa'], 0, ',', '.') ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-nowrap text-secondary">
                                <?= !empty($t['target_selesai'])
                                    ? '<i class="bi bi-calendar2-event me-1 opacity-50"></i> ' . date('d M Y', strtotime($t['target_selesai']))
                                    : '<span class="text-muted fst-italic">Tanpa batas waktu</span>' ?>
                            </td>
                            <td class="text-center">
                                <?php if ($t['status'] == 'Tercapai'): ?>
                                    <span
                                        class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 rounded-pill fw-normal"><i
                                            class="bi bi-check-circle me-1"></i> Tercapai</span>
                                <?php elseif ($t['status'] == 'Terlambat'): ?>
                                    <span
                                        class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1 rounded-pill fw-normal"><i
                                            class="bi bi-exclamation-circle me-1"></i> Terlambat</span>
                                <?php elseif ($t['status'] == 'On Track'): ?>
                                    <span
                                        class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-2 py-1 rounded-pill fw-normal"><i
                                            class="bi bi-graph-up me-1"></i> On Track</span>
                                <?php else: ?>
                                    <span
                                        class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 px-2 py-1 rounded-pill fw-normal"><i
                                            class="bi bi-arrow-right-circle me-1"></i> Berjalan</span>
                                <?php endif; ?>
                            </td>
                            <td class="pe-4 text-center">
                                <div class="d-inline-flex gap-2">
                                    <a href="<?= base_url('target/edit/' . $t['id']) ?>"
                                        class="btn btn-sm btn-light border text-primary rounded-circle" data-bs-toggle="tooltip"
                                        title="Edit Target">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="<?= base_url('target/hapus/' . $t['id']) ?>"
                                        class="btn btn-sm btn-light border text-danger rounded-circle" data-bs-toggle="tooltip"
                                        title="Hapus Target" onclick="return confirm('Yakin ingin menghapus target ini?')">
                                        <i class="bi bi-trash"></i>
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

<!-- PAGINATION -->
<?php
$totalPage = ceil($total / $perPage);
if ($totalPage > 1): ?>
    <nav class="d-flex justify-content-center mt-2">
        <ul class="pagination pagination-sm shadow-sm flex-wrap">
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

<!-- MODAL TAMBAH GOAL -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-bottom px-4 pt-4 pb-3">
                <h5 class="modal-title fw-bold" style="color:#229799">
                    <i class="bi bi-bullseye me-2"></i>Tambah Goal Baru
                </h5>
                <button type="button" class="btn-close bg-light rounded-circle p-2" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="<?= base_url('target/simpan') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small mb-1">Nama Goal</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i
                                    class="bi bi-flag text-muted"></i></span>
                            <input type="text" name="nama_goal" class="form-control border-start-0 ps-0"
                                placeholder="Contoh: Beli HP Baru" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small mb-1">Target Nominal</label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-light fw-bold text-muted border-end-0">Rp</span>
                            <input type="number" name="target_nominal" class="form-control fw-bold border-start-0 ps-0"
                                placeholder="0" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary small mb-1">Target Selesai <span
                                class="fw-normal text-muted">(opsional)</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i
                                    class="bi bi-calendar-check text-muted"></i></span>
                            <input type="date" name="target_selesai" class="form-control border-start-0 ps-0">
                        </div>
                    </div>

                    <div class="d-flex gap-2 pt-2 border-top mt-4">
                        <button type="submit" class="btn btn-auth w-100 rounded-pill py-2 fw-semibold">
                            <i class="bi bi-save me-1"></i> Simpan Goal
                        </button>
                        <button type="button" class="btn btn-light border w-100 rounded-pill py-2 fw-semibold"
                            data-bs-dismiss="modal">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Inisialisasi Tooltip Bootstrap untuk tombol di tabel
    document.addEventListener("DOMContentLoaded", function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>

<?= $this->endSection() ?>