<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- HEADER -->
<div class="d-flex align-items-center mb-4">
    <a href="<?= base_url('kategori') ?>" class="btn btn-sm btn-outline-secondary me-3">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h4 class="mb-0 fw-bold" style="color:#229799">Edit Kategori</h4>
</div>

<!-- FORM -->
<div class="card border-0 shadow-sm" style="max-width: 500px">
    <div class="card-body p-4">

        <!-- Info Kategori -->
        <div class="mb-4">
            <p class="text-muted mb-1" style="font-size:13px">Nama Kategori</p>
            <h5 class="fw-bold"><?= $kategori['nama'] ?></h5>
            <?php if ($kategori['jenis'] == 'Kebutuhan'): ?>
                <span class="badge bg-primary"><?= $kategori['jenis'] ?></span>
            <?php elseif ($kategori['jenis'] == 'Keinginan'): ?>
                <span class="badge bg-warning text-dark"><?= $kategori['jenis'] ?></span>
            <?php else: ?>
                <span class="badge bg-success"><?= $kategori['jenis'] ?></span>
            <?php endif; ?>
        </div>

        <form action="<?= base_url('kategori/update/' . $kategori['id']) ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label fw-bold">Anggaran Bulanan</label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" 
                        name="anggaran_bulanan" 
                        class="form-control" 
                        value="<?= $kategori['anggaran_bulanan'] ?>"
                        placeholder="0 = tidak pakai anggaran"
                        <?= $kategori['status'] == 'NONAKTIF' ? 'disabled' : '' ?>>
                </div>
                <?php if ($kategori['status'] == 'NONAKTIF'): ?>
                    <small class="text-danger">Aktifkan kategori ini dulu sebelum mengatur anggaran!</small>
                <?php else: ?>
                    <small class="text-muted">Kosongkan atau isi 0 jika tidak ingin memakai anggaran</small>
                <?php endif; ?>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-auth">Simpan</button>
                <a href="<?= base_url('kategori') ?>" class="btn btn-outline-secondary">Batal</a>
            </div>

        </form>
    </div>
</div>

<?= $this->endSection() ?>