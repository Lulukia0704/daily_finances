<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="mx-auto" style="max-width: 550px;">
    <!-- HEADER -->
    <div class="d-flex align-items-center mb-4 gap-3">
        <a href="<?= base_url('kategori') ?>"
            class="btn btn-light border rounded-circle shadow-sm d-flex align-items-center justify-content-center"
            style="width: 40px; height: 40px;" data-bs-toggle="tooltip" title="Kembali">
            <i class="bi bi-arrow-left text-secondary"></i>
        </a>
        <div class="d-flex align-items-center gap-2">
            <div class="bg-opacity-10 p-2 rounded-3" style="background-color: #229799; color: #229799;">
                <i class="bi bi-pencil-square fs-5"></i>
            </div>
            <h4 class="mb-0 fw-bold" style="color:#229799">Edit Kategori</h4>
        </div>
    </div>

    <!-- FORM CARD -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4 p-md-5">

            <!-- INFO KATEGORI (Tampil sebagai Box Elegan) -->
            <div class="d-flex flex-column align-items-center bg-light p-4 rounded-4 mb-4 border">
                <span class="text-muted small fw-medium mb-1">Nama Kategori</span>
                <h4 class="fw-bold text-dark mb-3"><?= $kategori['nama'] ?></h4>

                <?php if ($kategori['jenis'] == 'Kebutuhan'): ?>
                    <span
                        class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-2 rounded-pill fw-medium">
                        <i class="bi bi-bag me-1"></i> <?= $kategori['jenis'] ?>
                    </span>
                <?php elseif ($kategori['jenis'] == 'Keinginan'): ?>
                    <span
                        class="badge bg-warning bg-opacity-10 text-dark border border-warning border-opacity-25 px-3 py-2 rounded-pill fw-medium">
                        <i class="bi bi-star me-1"></i> <?= $kategori['jenis'] ?>
                    </span>
                <?php else: ?>
                    <span
                        class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 rounded-pill fw-medium">
                        <i class="bi bi-bookmark me-1"></i> <?= $kategori['jenis'] ?>
                    </span>
                <?php endif; ?>
            </div>

            <!-- FORM EDIT -->
            <form action="<?= base_url('kategori/update/' . $kategori['id']) ?>" method="post">
                <?= csrf_field() ?>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-secondary small mb-1">Anggaran Bulanan</label>
                    <div
                        class="input-group input-group-lg <?= $kategori['status'] == 'NONAKTIF' ? 'opacity-50' : '' ?>">
                        <span class="input-group-text bg-light fw-bold text-muted border-end-0">Rp</span>
                        <input type="number" name="anggaran_bulanan" class="form-control fw-bold border-start-0 ps-0"
                            value="<?= $kategori['anggaran_bulanan'] ?>" placeholder="0"
                            <?= $kategori['status'] == 'NONAKTIF' ? 'disabled' : '' ?>>
                    </div>

                    <!-- Pesan Bantuan/Peringatan -->
                    <?php if ($kategori['status'] == 'NONAKTIF'): ?>
                        <div class="mt-2 small text-danger fw-medium d-flex align-items-center">
                            <i class="bi bi-exclamation-circle-fill me-1"></i> Aktifkan kategori ini dulu sebelum mengatur
                            anggaran.
                        </div>
                    <?php else: ?>
                        <div class="mt-2 small text-muted d-flex align-items-center">
                            <i class="bi bi-info-circle me-1"></i> Kosongkan atau isi 0 jika tidak ingin memakai anggaran.
                        </div>
                    <?php endif; ?>
                </div>

                <!-- TOMBOL AKSI -->
                <div class="d-flex gap-2 pt-3 border-top mt-5">
                    <button type="submit" class="btn btn-auth w-100 rounded-pill py-2 fw-semibold">
                        <i class="bi bi-save me-1"></i> Simpan
                    </button>
                    <a href="<?= base_url('kategori') ?>"
                        class="btn btn-light border w-100 rounded-pill py-2 fw-semibold text-center text-decoration-none text-dark">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

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