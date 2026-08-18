<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!-- HEADER -->
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div class="d-flex align-items-center gap-2">
        <div class="bg-opacity-10 p-2 rounded-3" style="background-color: #229799; color: #229799;">
            <i class="bi bi-box-arrow-right fs-4"></i>
        </div>
        <h4 class="mb-0 fw-bold" style="color:#229799">Data Piutang</h4>
    </div>
    <button class="btn btn-auth shadow-sm px-4 rounded-pill" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-circle me-1"></i> Tambah Piutang
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

<!-- FILTER & SEARCH -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-3">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <!-- Filter Kategori -->
            <div class="d-flex flex-wrap gap-2">
                <button
                    class="btn btn-sm rounded-pill px-4 fw-medium <?= !$filter ? 'btn-auth shadow-sm' : 'btn-light border text-secondary' ?>"
                    onclick="window.location='<?= base_url('piutang') ?>'">
                    <i class="bi bi-collection me-1"></i> Semua
                </button>
                <button
                    class="btn btn-sm rounded-pill px-4 fw-medium <?= $filter == 'belum' ? 'btn-auth shadow-sm' : 'btn-light border text-secondary' ?>"
                    onclick="window.location='<?= base_url('piutang?filter=belum') ?>'">
                    <i class="bi bi-hourglass-split me-1"></i> Belum Lunas
                </button>
                <button
                    class="btn btn-sm rounded-pill px-4 fw-medium <?= $filter == 'lunas' ? 'btn-auth shadow-sm' : 'btn-light border text-secondary' ?>"
                    onclick="window.location='<?= base_url('piutang?filter=lunas') ?>'">
                    <i class="bi bi-check2-all me-1"></i> Lunas
                </button>
            </div>

            <!-- Pencarian -->
            <form method="get" action="<?= base_url('piutang') ?>" class="d-flex gap-2">
                <input type="hidden" name="filter" value="<?= $filter ?>">
                <div class="input-group input-group-sm rounded-pill overflow-hidden border">
                    <span class="input-group-text bg-white border-0 text-muted ps-3"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control border-0 shadow-none px-2"
                        placeholder="Cari nama peminjam..." value="<?= $search ?>">
                    <button type="submit"
                        class="btn btn-light border-start text-secondary px-3 hover-bg-light">Cari</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- TABEL -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
    <div class="card-body p-0 table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-muted">
                <tr>
                    <th class="ps-4" style="width:40px">No</th>
                    <th style="min-width:160px">Nama Peminjam</th>
                    <th style="min-width:120px">Tgl Pinjam</th>
                    <th class="text-end" style="min-width:140px">Jml Pinjam</th>
                    <th class="text-end" style="min-width:140px">Sudah Dibayar</th>
                    <th class="text-end" style="min-width:140px">Sisa Hutang</th>
                    <th class="text-center" style="min-width:120px">Status</th>
                    <th class="text-center pe-4" style="width:140px">Aksi</th>
                </tr>
            </thead>
            <tbody class="border-top-0">
                <?php if (empty($piutang)): ?>
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <div class="text-muted d-flex flex-column align-items-center">
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mb-3"
                                    style="width: 60px; height: 60px;">
                                    <i class="bi bi-people fs-2"></i>
                                </div>
                                <h6 class="fw-semibold mb-1">Belum ada data piutang</h6>
                                <small>Data piutang yang Anda catat akan muncul di sini.</small>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1;
                    foreach ($piutang as $p): ?>
                        <tr>
                            <td class="ps-4 text-muted"><?= $no++ ?></td>
                            <td class="fw-medium text-dark">
                                <i class="bi bi-person-circle text-secondary me-2 opacity-50"></i><?= $p['nama_peminjam'] ?>
                            </td>
                            <td class="text-nowrap text-secondary">
                                <?= date('d M Y', strtotime($p['tanggal_pinjam'])) ?>
                            </td>
                            <td class="text-end text-nowrap fw-semibold text-primary">
                                Rp <?= number_format($p['jumlah_pinjam'], 0, ',', '.') ?>
                            </td>
                            <td class="text-end text-nowrap">
                                <span class="text-success fw-semibold bg-success bg-opacity-10 px-2 py-1 rounded-2">
                                    Rp <?= number_format($p['sudah_dibayar'], 0, ',', '.') ?>
                                </span>
                            </td>
                            <td class="text-end text-nowrap">
                                <?php if ($p['sisa_hutang'] > 0): ?>
                                    <span class="text-danger fw-semibold bg-danger bg-opacity-10 px-2 py-1 rounded-2">
                                        Rp <?= number_format(max(0, $p['sisa_hutang']), 0, ',', '.') ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if ($p['status'] == 'Lunas'): ?>
                                    <span
                                        class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 rounded-pill fw-normal"><i
                                            class="bi bi-check-circle me-1"></i> Lunas</span>
                                <?php elseif ($p['status'] == 'Lebih Bayar'): ?>
                                    <span
                                        class="badge bg-warning bg-opacity-10 text-dark border border-warning border-opacity-25 px-2 py-1 rounded-pill fw-normal"><i
                                            class="bi bi-info-circle me-1"></i> Lebih Bayar</span>
                                <?php else: ?>
                                    <span
                                        class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1 rounded-pill fw-normal"><i
                                            class="bi bi-clock-history me-1"></i> Belum Lunas</span>
                                <?php endif; ?>
                            </td>
                            <td class="pe-4 text-center text-nowrap">
                                <div class="d-inline-flex gap-1">
                                    <!-- Tombol Detail -->
                                    <a href="<?= base_url('piutang/detail/' . $p['id']) ?>"
                                        class="btn btn-sm btn-light border text-secondary rounded-circle"
                                        data-bs-toggle="tooltip" title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <!-- Tombol Bayar -->
                                    <?php if ($p['status'] != 'Lunas'): ?>
                                        <button class="btn btn-sm btn-auth rounded-circle shadow-sm" data-bs-toggle="modal"
                                            data-bs-target="#modalBayar" data-id="<?= $p['id'] ?>"
                                            data-nama="<?= $p['nama_peminjam'] ?>" data-sisa="<?= $p['sisa_hutang'] ?>"
                                            data-bs-toggle="tooltip" title="Catat Pembayaran">
                                            <i class="bi bi-wallet2"></i>
                                        </button>
                                    <?php endif; ?>

                                    <!-- Tombol Hapus -->
                                    <a href="<?= base_url('piutang/hapus/' . $p['id']) ?>"
                                        class="btn btn-sm btn-light border text-danger rounded-circle" data-bs-toggle="tooltip"
                                        title="Hapus Piutang" onclick="return confirm('Yakin ingin menghapus piutang ini?')">
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

<!-- MODAL TAMBAH PIUTANG -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-bottom px-4 pt-4 pb-3">
                <h5 class="modal-title fw-bold" style="color:#229799">
                    <i class="bi bi-box-arrow-right me-2"></i>Tambah Piutang
                </h5>
                <button type="button" class="btn-close bg-light rounded-circle p-2" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="<?= base_url('piutang/simpan') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small mb-1">Nama Peminjam</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i
                                    class="bi bi-person text-muted"></i></span>
                            <input type="text" name="nama_peminjam" class="form-control border-start-0 ps-0"
                                placeholder="Nama lengkap peminjam" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small mb-1">Tanggal Pinjam</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i
                                    class="bi bi-calendar-event text-muted"></i></span>
                            <input type="date" name="tanggal_pinjam" class="form-control border-start-0 ps-0"
                                value="<?= date('Y-m-d') ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small mb-1">Jumlah Pinjam</label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-light fw-bold text-muted border-end-0">Rp</span>
                            <input type="number" name="jumlah_pinjam" class="form-control fw-bold border-start-0 ps-0"
                                placeholder="0" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary small mb-1">Keterangan <span
                                class="fw-normal text-muted">(opsional)</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i
                                    class="bi bi-card-text text-muted"></i></span>
                            <input type="text" name="keterangan" class="form-control border-start-0 ps-0"
                                placeholder="Contoh: untuk beli motor">
                        </div>
                    </div>

                    <div class="d-flex gap-2 pt-2 border-top mt-4">
                        <button type="submit" class="btn btn-auth w-100 rounded-pill py-2 fw-semibold">
                            <i class="bi bi-save me-1"></i> Simpan
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

<!-- MODAL CATAT PEMBAYARAN -->
<div class="modal fade" id="modalBayar" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-bottom px-4 pt-4 pb-3">
                <h5 class="modal-title fw-bold" style="color:#229799">
                    <i class="bi bi-wallet2 me-2"></i>Catat Pembayaran
                </h5>
                <button type="button" class="btn-close bg-light rounded-circle p-2" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formBayar" action="" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small mb-1">Peminjam</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i
                                    class="bi bi-person text-muted"></i></span>
                            <input type="text" id="namaPeminjam" class="form-control border-start-0 ps-0 bg-white"
                                readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small mb-1">Sisa Hutang</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-danger fw-semibold">Rp</span>
                            <input type="text" id="sisaHutang"
                                class="form-control border-start-0 ps-0 bg-white text-danger fw-semibold" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small mb-1">Jumlah Bayar</label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-light fw-bold text-muted border-end-0">Rp</span>
                            <input type="number" name="jumlah_bayar" class="form-control fw-bold border-start-0 ps-0"
                                placeholder="0" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small mb-1">Tanggal Bayar</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i
                                    class="bi bi-calendar-check text-muted"></i></span>
                            <input type="date" name="tanggal_bayar" class="form-control border-start-0 ps-0"
                                value="<?= date('Y-m-d') ?>" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary small mb-1">Keterangan <span
                                class="fw-normal text-muted">(opsional)</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i
                                    class="bi bi-card-text text-muted"></i></span>
                            <input type="text" name="keterangan" class="form-control border-start-0 ps-0"
                                placeholder="Contoh: transfer bank">
                        </div>
                    </div>

                    <div class="d-flex gap-2 pt-2 border-top mt-4">
                        <button type="submit" class="btn btn-auth w-100 rounded-pill py-2 fw-semibold">
                            <i class="bi bi-save me-1"></i> Simpan Pembayaran
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
    // Logic Set data ke modal bayar tetap sama 100%
    const modalBayar = document.getElementById('modalBayar');
    modalBayar.addEventListener('show.bs.modal', function (e) {
        const btn = e.relatedTarget;
        const id = btn.dataset.id;
        const nama = btn.dataset.nama;
        const sisa = parseInt(btn.dataset.sisa).toLocaleString('id-ID');

        document.getElementById('namaPeminjam').value = nama;
        document.getElementById('sisaHutang').value = sisa;
        document.getElementById('formBayar').action = `<?= base_url('piutang/bayar/') ?>${id}`;
    });

    // Inisialisasi Tooltip Bootstrap (membuat tulisan melayang saat tombol di-hover)
    document.addEventListener("DOMContentLoaded", function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>

<?= $this->endSection() ?>