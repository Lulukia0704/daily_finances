<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="mx-auto" style="max-width: 550px;">
    <!-- HEADER -->
    <div class="d-flex align-items-center mb-4 gap-3">
        <a href="<?= base_url('transaksi') ?>" class="btn btn-light border rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;" data-bs-toggle="tooltip" title="Kembali">
            <i class="bi bi-arrow-left text-secondary"></i>
        </a>
        <div class="d-flex align-items-center gap-2">
            <div class="bg-opacity-10 p-2 rounded-3" style="background-color: #229799; color: #229799;">
                <i class="bi bi-pencil-square fs-5"></i>
            </div>
            <h4 class="mb-0 fw-bold" style="color:#229799">Edit Transaksi</h4>
        </div>
    </div>

    <!-- FORM CARD -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4 p-md-5">
            <form action="<?= base_url('transaksi/update/' . $transaksi['id']) ?>" method="post">
                <?= csrf_field() ?>

                <!-- TIPE TRANSAKSI -->
                <div class="mb-4">
                    <label class="form-label fw-semibold text-secondary small mb-2">Tipe Transaksi</label>
                    <div class="d-flex gap-2">
                        <input type="radio" class="btn-check" name="tipe" id="pemasukan" value="Pemasukan" <?= $transaksi['tipe'] == 'Pemasukan' ? 'checked' : '' ?>>
                        <label class="btn btn-outline-success flex-fill rounded-3 py-2 fw-medium" for="pemasukan">
                            <i class="bi bi-graph-up-arrow me-1"></i> Pemasukan
                        </label>

                        <input type="radio" class="btn-check" name="tipe" id="pengeluaran" value="Pengeluaran" <?= $transaksi['tipe'] == 'Pengeluaran' ? 'checked' : '' ?>>
                        <label class="btn btn-outline-danger flex-fill rounded-3 py-2 fw-medium" for="pengeluaran">
                            <i class="bi bi-graph-down-arrow me-1"></i> Pengeluaran
                        </label>
                    </div>
                </div>

                <!-- TANGGAL -->
                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary small mb-1">Tanggal</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-calendar-date text-muted"></i></span>
                        <input type="date" name="tanggal" class="form-control border-start-0 ps-0" value="<?= $transaksi['tanggal'] ?>" required>
                    </div>
                </div>

                <!-- KATEGORI -->
                <div class="mb-3" id="fieldKategori" <?= $transaksi['tipe'] == 'Pemasukan' ? 'style="display:none"' : '' ?>>
                    <label class="form-label fw-semibold text-secondary small mb-1">Kategori</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-grid text-muted"></i></span>
                        <select name="kategori_id" class="form-select border-start-0 ps-0">
                            <option value="">Pilih Kategori</option>
                            <?php foreach ($kategoriAktif as $k): ?>
                                <option value="<?= $k['id'] ?>" <?= $transaksi['kategori_id'] == $k['id'] ? 'selected' : '' ?>>
                                    <?= $k['nama'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- KETERANGAN -->
                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary small mb-1">Keterangan</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-card-text text-muted"></i></span>
                        <input type="text" name="keterangan" class="form-control border-start-0 ps-0" value="<?= $transaksi['keterangan'] ?>" placeholder="Contoh: Makan siang, Gaji, dll">
                    </div>
                </div>

                <!-- JUMLAH -->
                <div class="mb-4">
                    <label class="form-label fw-semibold text-secondary small mb-1">Jumlah</label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-light fw-bold text-muted border-end-0">Rp</span>
                        <input type="number" name="jumlah" class="form-control fw-bold border-start-0 ps-0" value="<?= $transaksi['jumlah'] ?>" placeholder="0" required>
                    </div>
                </div>

                <!-- TOMBOL AKSI -->
                <div class="d-flex gap-2 pt-3 border-top mt-4">
                    <button type="submit" class="btn btn-auth w-100 rounded-pill py-2 fw-semibold">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                    <a href="<?= base_url('transaksi') ?>" class="btn btn-light border w-100 rounded-pill py-2 fw-semibold text-center text-decoration-none text-dark">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
// Logika tetap sama persis
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

// Inisialisasi Tooltip Bootstrap untuk tombol kembali (opsional)
document.addEventListener("DOMContentLoaded", function(){
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});
</script>

<?= $this->endSection() ?>