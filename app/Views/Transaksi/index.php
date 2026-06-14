<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-bold" style="color:#229799">Transaksi</h4>
    <button class="btn btn-auth" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-lg me-1"></i> Tambah Transaksi
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
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body py-2">
        <form method="get" action="<?= base_url('transaksi') ?>">
            <div class="row g-2 align-items-center">
                <div class="col-md-2">
                    <select name="kategori" class="form-select form-select-sm">
                    <option value="">Semua Kategori</option>
                    <?php foreach ($kategoriAktif as $k): ?>
                        <option value="<?= $k['id'] ?>"
                            <?= $filter['kategori'] == $k['id'] ? 'selected' : '' ?>>
                            <?= $k['nama'] ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="tipe" class="form-select form-select-sm">
                        <option value="">Semua Tipe</option>
                        <option value="Pemasukan" <?= $filter['tipe'] == 'Pemasukan' ? 'selected' : '' ?>>Pemasukan</option>
                        <option value="Pengeluaran" <?= $filter['tipe'] == 'Pengeluaran' ? 'selected' : '' ?>>Pengeluaran</option>
                    </select>
                </div>
                <div class="col-md-2">
                <input type="date" name="dari" class="form-control form-control-sm" 
                        value="<?= $filter['dari'] ?>">

                </div>
                <div class="col-auto">
                    <span class="text-muted">s/d</span>
                </div>
                <div class="col-md-2">
                <input type="date" name="sampai" class="form-control form-control-sm"
                        value="<?= $filter['sampai'] ?>">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-sm btn-auth">Cari</button>
                    <a href="<?= base_url('transaksi') ?>" class="btn btn-sm btn-outline-secondary">Reset</a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- TABEL -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Kategori</th>
                    <th>Keterangan</th>
                    <th class="text-end">Pemasukan</th>
                    <th class="text-end">Pengeluaran</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($transaksi)): ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            Belum ada transaksi
                        </td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($transaksi as $t): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= date('d/m/Y', strtotime($t['tanggal'])) ?></td>
                        <td><span class="badge bg-secondary"><?= $t['kategori_nama'] ?></span></td>
                        <td><?= $t['keterangan'] ?></td>
                        <td class="text-end text-success">
                            <?= $t['tipe'] == 'Pemasukan' ? 'Rp ' . number_format($t['jumlah'], 0, ',', '.') : '-' ?>
                        </td>
                        <td class="text-end text-danger">
                            <?= $t['tipe'] == 'Pengeluaran' ? 'Rp ' . number_format($t['jumlah'], 0, ',', '.') : '-' ?>
                        </td>
                        <td class="text-end">
                        <a href="<?= base_url('transaksi/edit/' . $t['id']) ?>"
                            class="btn btn-sm btn-outline-primary me-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="<?= base_url('transaksi/hapus/' . $t['id']) ?>"
                            class="btn btn-sm btn-outline-danger"
                            onclick="return confirm('Yakin ingin menghapus transaksi ini?')">
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

<!-- MODAL TAMBAH TRANSAKSI -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Tambah Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('transaksi/simpan') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" 
                               value="<?= date('Y-m-d') ?>" required>
                    </div>

                    <div class="mb-3" id="fieldKategori">
                        <label class="form-label">Kategori</label>
                        <select name="kategori_id" class="form-select" required>
                            <option value="">Pilih Kategori</option>
                            <?php foreach ($kategoriAktif as $k): ?>
                                <option value="<?= $k['id'] ?>"><?= $k['nama'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <input type="text" name="keterangan" class="form-control" 
                               placeholder="Contoh: Beli ayam">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jumlah</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="jumlah" class="form-control" 
                                   placeholder="0" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tipe</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" 
                                       name="tipe" value="Pemasukan" id="pemasukan">
                                <label class="form-check-label text-success" for="pemasukan">
                                    📈 Pemasukan
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" 
                                       name="tipe" value="Pengeluaran" id="pengeluaran" checked>
                                <label class="form-check-label text-danger" for="pengeluaran">
                                    📉 Pengeluaran
                                </label>
                            </div>
                        </div>
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
// Sembunyikan/tampilkan kategori berdasarkan tipe
document.querySelectorAll('input[name="tipe"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const kategoriField = document.getElementById('fieldKategori');
        const kategoriSelect = document.querySelector('select[name="kategori_id"]');
        
        if (this.value === 'Pemasukan') {
            kategoriField.style.display = 'none';
            kategoriSelect.removeAttribute('required');
            kategoriSelect.value = '';
        } else {
            kategoriField.style.display = 'block';
            kategoriSelect.setAttribute('required', 'required');
        }
    });
});
</script>
<?= $this->endSection() ?>