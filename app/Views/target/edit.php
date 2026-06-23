<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- HEADER -->
<div class="d-flex align-items-center mb-4">
    <a href="<?= base_url('target') ?>" class="btn btn-sm btn-outline-secondary me-3">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h4 class="mb-0 fw-bold" style="color:#229799">Edit Target</h4>
</div>

<!-- FORM -->
<div class="card border-0 shadow-sm" style="max-width: 500px">
    <div class="card-body p-4">
        <form action="<?= base_url('target/update/' . $target['id']) ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Nama Goal</label>
                <input type="text" name="nama_goal" class="form-control"
                       value="<?= $target['nama_goal'] ?>"
                       placeholder="Contoh: Beli hp">
            </div>

            <div class="mb-3">
                <label class="form-label">Target Nominal</label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" name="target_nominal" class="form-control"
                           value="<?= $target['target_nominal'] ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Target Selesai</label>
                <input type="date" name="target_selesai" class="form-control"
                       value="<?= $target['target_selesai'] ?>" >
            </div>

                <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-auth">Simpan</button>
                <a href="<?= base_url('target') ?>" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>