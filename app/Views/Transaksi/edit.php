<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- HEADER -->
<div class="d-flex align-items-center mb-4">
    <a href="<?= base_url('transaksi') ?>" class="btn btn-sm btn-outline-secondary me-3">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h4 class="mb-0 fw-bold" style="color:#229799">Edit Transaksi</h4>
</div>

<!-- FORM -->
<div class="card border-0 shadow-sm" style="max-width: 500px">
    <div class="card-body p-4">
        <form action="<?= base_url('transaksi/update/' . $transaksi['id']) ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Tanggal</label>
                <input type="date" name="tanggal" class="form-control"
                       value="<?= $transaksi['tanggal'] ?>" required>
            </div>

            <div class="mb-3" id="fieldKategori" 
                 <?= $transaksi['tipe'] == 'Pemasukan' ? 'style="display:none"' : '' ?>>
                <label class="form-label">Kategori</label>
                <select name="kategori_id" class="form-select">
                    <option value="">Pilih Kategori</option>
                    <?php foreach ($kategoriAktif as $k): ?>
                        <option value="<?= $k['id'] ?>" 
                            <?= $transaksi['kategori_id'] == $k['id'] ? 'selected' : '' ?>>
                            <?= $k['nama'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <input type="text" name="keterangan" class="form-control"
                       value="<?= $transaksi['keterangan'] ?>"
                       placeholder="Contoh: Beli ayam">
            </div>

            <div class="mb-3">
                <label class="form-label">Jumlah</label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" name="jumlah" class="form-control"
                           value="<?= $transaksi['jumlah'] ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Tipe</label>
                <div class="d-flex gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio"
                               name="tipe" value="Pemasukan" id="pemasukan"
                               <?= $transaksi['tipe'] == 'Pemasukan' ? 'checked' : '' ?>>
                        <label class="form-check-label text-success" for="pemasukan">
                            📈 Pemasukan
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio"
                               name="tipe" value="Pengeluaran" id="pengeluaran"
                               <?= $transaksi['tipe'] == 'Pengeluaran' ? 'checked' : '' ?>>
                        <label class="form-check-label text-danger" for="pengeluaran">
                            📉 Pengeluaran
                        </label>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-auth">Simpan</button>
                <a href="<?= base_url('transaksi') ?>" class="btn btn-outline-secondary">Batal</a>
            </div>

        </form>
    </div>
</div>

<script>
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