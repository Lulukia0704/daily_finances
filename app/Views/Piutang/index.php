<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-bold" style="color:#229799">Piutang</h4>
    <button class="btn btn-auth" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-lg me-1"></i> Tambah Piutang
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

<!-- FILTER & SEARCH -->
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body py-2">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <button class="btn btn-sm filter-btn <?= !$filter ? 'active' : '' ?>"
                        onclick="window.location='<?= base_url('piutang') ?>'">Semua</button>
                <button class="btn btn-sm filter-btn <?= $filter == 'belum' ? 'active' : '' ?>"
                        onclick="window.location='<?= base_url('piutang?filter=belum') ?>'">Belum Lunas</button>
                <button class="btn btn-sm filter-btn <?= $filter == 'lunas' ? 'active' : '' ?>"
                        onclick="window.location='<?= base_url('piutang?filter=lunas') ?>'">Lunas</button>
            </div>
            <form method="get" action="<?= base_url('piutang') ?>" class="d-flex gap-2">
                <input type="hidden" name="filter" value="<?= $filter ?>">
                <input type="text" name="search" class="form-control form-control-sm"
                       placeholder="Cari nama peminjam..." value="<?= $search ?>">
                <button type="submit" class="btn btn-sm btn-auth">Cari</button>
            </form>
        </div>
    </div>
</div>

<!-- TABEL -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width:40px">No</th>
                    <th>Nama Peminjam</th>
                    <th style="width:120px">Tgl Pinjam</th>
                    <th class="text-end" style="width:140px">Jumlah Pinjam</th>
                    <th class="text-end" style="width:140px">Sudah Dibayar</th>
                    <th class="text-end" style="width:130px">Sisa Hutang</th>
                    <th style="width:100px">Status</th>
                    <th style="width:120px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($piutang)): ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            Belum ada piutang
                        </td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($piutang as $p): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $p['nama_peminjam'] ?></td>
                        <td class="text-nowrap">
                            <?= date('d M Y', strtotime($p['tanggal_pinjam'])) ?>
                        </td>
                        <td class="text-end">
                            Rp <?= number_format($p['jumlah_pinjam'], 0, ',', '.') ?>
                        </td>
                        <td class="text-end text-success">
                            Rp <?= number_format($p['sudah_dibayar'], 0, ',', '.') ?>
                        </td>
                        <td class="text-end text-danger">
                            Rp <?= number_format(max(0, $p['sisa_hutang']), 0, ',', '.') ?>
                        </td>
                        <td>
                            <?php if ($p['status'] == 'Lunas'): ?>
                                <span class="badge bg-success">Lunas</span>
                            <?php elseif ($p['status'] == 'Lebih Bayar'): ?>
                                <span class="badge bg-warning text-dark">Lebih Bayar</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Belum Lunas</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-nowrap">
                            <!-- Tombol Detail (baru) -->
                            <a href="<?= base_url('piutang/detail/' . $p['id']) ?>"
                            class="btn btn-sm btn-outline-secondary me-1">
                                <i class="bi bi-eye"></i>
                            </a>
                            <?php if ($p['status'] != 'Lunas'): ?>
                            <button class="btn btn-sm btn-auth me-1"
                                data-bs-toggle="modal"
                                data-bs-target="#modalBayar"
                                data-id="<?= $p['id'] ?>"
                                data-nama="<?= $p['nama_peminjam'] ?>"
                                data-sisa="<?= $p['sisa_hutang'] ?>">
                                <i class="bi bi-cash"></i>
                            </button>
                            <?php endif; ?>
                            <a href="<?= base_url('piutang/hapus/' . $p['id']) ?>"
                               class="btn btn-sm btn-outline-danger"
                               onclick="return confirm('Yakin ingin menghapus piutang ini?')">
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

<!-- MODAL TAMBAH PIUTANG -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Tambah Piutang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('piutang/simpan') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label">Nama Peminjam</label>
                        <input type="text" name="nama_peminjam" class="form-control"
                               placeholder="Nama lengkap peminjam" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Pinjam</label>
                        <input type="date" name="tanggal_pinjam" class="form-control"
                               value="<?= date('Y-m-d') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jumlah Pinjam</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="jumlah_pinjam" class="form-control"
                                   placeholder="0" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keterangan <span class="text-muted">(opsional)</span></label>
                        <input type="text" name="keterangan" class="form-control"
                               placeholder="Contoh: untuk beli motor">
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

<!-- MODAL CATAT PEMBAYARAN -->
<div class="modal fade" id="modalBayar" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Catat Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formBayar" action="" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label">Peminjam</label>
                        <input type="text" id="namaPeminjam" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Sisa Hutang</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" id="sisaHutang" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jumlah Bayar</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="jumlah_bayar" class="form-control"
                                   placeholder="0" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Bayar</label>
                        <input type="date" name="tanggal_bayar" class="form-control"
                               value="<?= date('Y-m-d') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keterangan <span class="text-muted">(opsional)</span></label>
                        <input type="text" name="keterangan" class="form-control"
                               placeholder="Contoh: transfer BCA">
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

<script>
// Set data ke modal bayar
const modalBayar = document.getElementById('modalBayar');
modalBayar.addEventListener('show.bs.modal', function(e) {
    const btn = e.relatedTarget;
    const id = btn.dataset.id;
    const nama = btn.dataset.nama;
    const sisa = parseInt(btn.dataset.sisa).toLocaleString('id-ID');

    document.getElementById('namaPeminjam').value = nama;
    document.getElementById('sisaHutang').value = sisa;
    document.getElementById('formBayar').action = `<?= base_url('piutang/bayar/') ?>${id}`;
});
</script>

<?= $this->endSection() ?>