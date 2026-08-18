<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="mx-auto" style="max-width: 550px;">
    <!-- HEADER -->
    <div class="d-flex align-items-center mb-4 gap-3">
        <a href="<?= base_url('target') ?>"
            class="btn btn-light border rounded-circle shadow-sm d-flex align-items-center justify-content-center"
            style="width: 40px; height: 40px;" data-bs-toggle="tooltip" title="Kembali">
            <i class="bi bi-arrow-left text-secondary"></i>
        </a>
        <div class="d-flex align-items-center gap-2">
            <div class="bg-opacity-10 p-2 rounded-3" style="background-color: #229799; color: #229799;">
                <i class="bi bi-bullseye fs-5"></i>
            </div>
            <h4 class="mb-0 fw-bold" style="color:#229799">Edit Target</h4>
        </div>
    </div>

    <!-- FORM CARD -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4 p-md-5">
            <form action="<?= base_url('target/update/' . $target['id']) ?>" method="post">
                <?= csrf_field() ?>

                <!-- NAMA GOAL -->
                <div class="mb-4">
                    <label class="form-label fw-semibold text-secondary small mb-1">Nama Goal</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i
                                class="bi bi-flag text-muted"></i></span>
                        <input type="text" name="nama_goal" class="form-control border-start-0 ps-0"
                            value="<?= $target['nama_goal'] ?>" placeholder="Contoh: Beli HP Baru" required>
                    </div>
                </div>

                <!-- TARGET NOMINAL -->
                <div class="mb-4">
                    <label class="form-label fw-semibold text-secondary small mb-1">Target Nominal</label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-light fw-bold text-muted border-end-0">Rp</span>
                        <input type="number" name="target_nominal" class="form-control fw-bold border-start-0 ps-0"
                            value="<?= $target['target_nominal'] ?>" placeholder="0" required>
                    </div>
                </div>

                <!-- TARGET SELESAI -->
                <div class="mb-4">
                    <label class="form-label fw-semibold text-secondary small mb-1">Target Selesai</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i
                                class="bi bi-calendar-check text-muted"></i></span>
                        <input type="date" name="target_selesai" class="form-control border-start-0 ps-0"
                            value="<?= $target['target_selesai'] ?>">
                    </div>
                </div>

                <!-- TOMBOL AKSI -->
                <div class="d-flex gap-2 pt-3 border-top mt-4">
                    <button type="submit" class="btn btn-auth w-100 rounded-pill py-2 fw-semibold">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                    <a href="<?= base_url('target') ?>"
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