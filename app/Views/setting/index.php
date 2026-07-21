<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!-- HEADER -->
<div class="mb-4">
    <h4 class="mb-0 fw-bold" style="color:#229799">Pengaturan</h4>
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

<!-- SECTION 1: Ubah Nama -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <h6 class="fw-bold mb-3 pb-2 border-bottom" style="color:#229799">
            <i class="bi bi-person me-2"></i>Ubah Nama
        </h6>
        <form action="<?= base_url('setting/ubah-nama') ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Nama Baru</label>
                <input type="text" name="nama" class="form-control"
                       value="<?= esc($user['nama']) ?>" required>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-auth">Simpan Nama</button>
            </div>
        </form>
    </div>
</div>

<!-- SECTION 2: Ubah Email -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <h6 class="fw-bold mb-3 pb-2 border-bottom" style="color:#229799">
            <i class="bi bi-envelope me-2"></i>Ubah Email
        </h6>
        <form action="<?= base_url('setting/ubah-email') ?>" method="post" id="formEmail">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Email Baru</label>
                <input type="email" name="email" class="form-control"
                       value="<?= esc($user['email']) ?>" required>
            </div>
            <div class="d-flex justify-content-end align-items-center gap-2">
                <small class="text-muted"><i class="bi bi-lock me-1"></i>Memerlukan konfirmasi password</small>
                <button type="button" class="btn btn-auth" onclick="bukaModal('formEmail')">Simpan Email</button>
            </div>
        </form>
    </div>
</div>

<!-- SECTION 3: Ganti Password -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <h6 class="fw-bold mb-3 pb-2 border-bottom" style="color:#229799">
            <i class="bi bi-lock me-2"></i>Ganti Password
        </h6>
        <form action="<?= base_url('setting/ganti-password') ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Password Lama</label>
                <input type="password" name="password_lama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password Baru</label>
                <input type="password" name="password_baru" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Konfirmasi Password Baru</label>
                <input type="password" name="konfirmasi_password" class="form-control" required>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-auth">Ganti Password</button>
            </div>
        </form>
    </div>
</div>

<!-- SECTION 4: Export Data -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <h6 class="fw-bold mb-3 pb-2 border-bottom" style="color:#229799">
            <i class="bi bi-download me-2"></i>Export Data
        </h6>
        <p class="text-muted small">Pilih data dan format yang ingin diexport.</p>
        <form action="<?= base_url('setting/export') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="row g-3 mb-3">
                <!-- 1. PILIHAN DATA (Teks Statis dengan Input Hidden agar data tetap terkirim ke backend) -->
                <div class="col-12 col-md-6">
                    <label class="form-label fw-bold">Data yang Diexport</label>
                    <input type="hidden" name="data" value="rekap">
                    <div class="form-control bg-light text-muted">📄 Rekap Bulanan</div>
                </div>

                <!-- 2. PILIHAN FORMAT FILE -->
                <div class="col-12 col-md-6">
                    <label class="form-label">Format</label>
                    <select name="format" class="form-select">
                        <option value="pdf">PDF</option>
                        <option value="excel">Excel</option>
                        <option value="word">Word</option>
                    </select>
                </div>

                <!-- 3. PERIODE: DROPDOWN BULAN & TAHUN (Berdampingan secara responsif) -->
                <div class="col-12">
                    <label class="form-label">Periode</label>
                    <div class="row g-2">
                        <!-- Dropdown Bulan -->
                        <div class="col-6">
                            <select name="bulan" class="form-select">
                                <option value="all">Semua Bulan</option>
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                        <!-- Dropdown Tahun -->
                        <div class="col-6">
                            <select name="tahun" class="form-select">
                                <!-- Opsi dinamis: Menampilkan tahun saat ini sampai beberapa tahun ke belakang -->
                                <?php 
                                $tahun_sekarang = date('Y');
                                for ($i = $tahun_sekarang; $i >= $tahun_sekarang - 5; $i--): 
                                ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-auth">
                    <i class="bi bi-download me-1"></i> Export
                </button>
            </div>
        </form>
    </div>
</div>

<!-- SECTION 5: Hapus Semua Data -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <h6 class="fw-bold mb-3 pb-2 border-bottom text-danger">
            <i class="bi bi-trash me-2"></i>Hapus Semua Data
        </h6>
        <p class="text-muted small">Tindakan ini tidak bisa dibatalkan. Semua data transaksi akan dihapus permanen.</p>
        <form action="<?= base_url('setting/hapus-data') ?>" method="post" id="formHapus">
            <?= csrf_field() ?>
            <div class="d-flex justify-content-end align-items-center gap-2">
                <small class="text-muted"><i class="bi bi-lock me-1"></i>Memerlukan konfirmasi password</small>
                <button type="button" class="btn btn-danger" onclick="bukaModal('formHapus')">
                    <i class="bi bi-trash me-1"></i> Hapus Semua Data
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL KONFIRMASI PASSWORD -->
<div class="modal fade" id="modalKonfirmasi" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Konfirmasi Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted small">Masukkan password untuk melanjutkan.</p>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" id="inputKonfirmasiPassword" 
                           name="konfirmasi_password" class="form-control">
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" 
                        data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-auth" onclick="submitForm()">Konfirmasi</button>
            </div>
        </div>
    </div>
</div>

<script>
let formTarget = null;

function bukaModal(formId) {
    formTarget = document.getElementById(formId);
    document.getElementById('inputKonfirmasiPassword').value = '';
    new bootstrap.Modal(document.getElementById('modalKonfirmasi')).show();
}

function submitForm() {
    if (!formTarget) return;
    
    // Tambahkan input password ke form
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'password_konfirmasi';
    input.value = document.getElementById('inputKonfirmasiPassword').value;
    formTarget.appendChild(input);
    
    formTarget.submit();
}
</script>

<?= $this->endSection() ?>