<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="mx-auto" style="max-width: 750px;">
    <!-- HEADER -->
    <div class="d-flex align-items-center gap-3 mb-4">
        <div class="bg-opacity-10 p-2 rounded-3" style="background-color: #229799; color: #229799;">
            <i class="bi bi-gear-fill fs-4"></i>
        </div>
        <h4 class="mb-0 fw-bold" style="color:#229799">Pengaturan</h4>
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

    <!-- SECTION 1: Ubah Nama -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
        <div class="card-header bg-white border-bottom pt-4 pb-3 px-4">
            <h6 class="fw-bold mb-0" style="color:#229799">
                <i class="bi bi-person-badge me-2"></i>Informasi Profil
            </h6>
        </div>
        <div class="card-body p-4">
            <form action="<?= base_url('setting/ubah-nama') ?>" method="post">
                <?= csrf_field() ?>
                <div class="mb-4">
                    <label class="form-label fw-semibold text-secondary small mb-1">Nama Lengkap</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i
                                class="bi bi-person text-muted"></i></span>
                        <input type="text" name="nama" class="form-control border-start-0 ps-0"
                            value="<?= esc($user['nama']) ?>" required>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-auth rounded-pill px-4 fw-semibold">
                        <i class="bi bi-save me-1"></i> Simpan Nama
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- SECTION 2: Ubah Email -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
        <div class="card-header bg-white border-bottom pt-4 pb-3 px-4">
            <h6 class="fw-bold mb-0" style="color:#229799">
                <i class="bi bi-envelope-at me-2"></i>Pengaturan Email
            </h6>
        </div>
        <div class="card-body p-4">
            <form action="<?= base_url('setting/ubah-email') ?>" method="post" id="formEmail">
                <?= csrf_field() ?>
                <div class="mb-4">
                    <label class="form-label fw-semibold text-secondary small mb-1">Email Saat Ini</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i
                                class="bi bi-envelope text-muted"></i></span>
                        <input type="email" name="email" class="form-control border-start-0 ps-0"
                            value="<?= esc($user['email']) ?>" required>
                    </div>
                </div>
                <div
                    class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 bg-light p-3 rounded-3 border">
                    <div class="text-muted small d-flex align-items-center">
                        <i class="bi bi-shield-lock fs-5 me-2 text-warning"></i>
                        <span>Perubahan email memerlukan konfirmasi <strong>password aktif</strong> Anda.</span>
                    </div>
                    <button type="button" class="btn btn-auth rounded-pill px-4 fw-semibold text-nowrap"
                        onclick="bukaModal('formEmail')">
                        Ubah Email
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- SECTION 3: Ganti Password -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
        <div class="card-header bg-white border-bottom pt-4 pb-3 px-4">
            <h6 class="fw-bold mb-0" style="color:#229799">
                <i class="bi bi-key me-2"></i>Keamanan Akun
            </h6>
        </div>
        <div class="card-body p-4">
            <form action="<?= base_url('setting/ganti-password') ?>" method="post">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary small mb-1">Password Lama</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i
                                class="bi bi-unlock text-muted"></i></span>
                        <input type="password" name="password_lama" class="form-control border-start-0 ps-0"
                            placeholder="Masukkan password lama" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary small mb-1">Password Baru</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i
                                class="bi bi-lock text-muted"></i></span>
                        <input type="password" name="password_baru" class="form-control border-start-0 ps-0"
                            placeholder="Buat password baru" required>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold text-secondary small mb-1">Konfirmasi Password Baru</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i
                                class="bi bi-check2-all text-muted"></i></span>
                        <input type="password" name="konfirmasi_password" class="form-control border-start-0 ps-0"
                            placeholder="Ulangi password baru" required>
                    </div>
                </div>
                <div class="d-flex justify-content-end border-top pt-3">
                    <button type="submit" class="btn btn-auth rounded-pill px-4 fw-semibold">
                        <i class="bi bi-shield-check me-1"></i> Perbarui Password
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- SECTION 4: Export Data -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
        <div class="card-header bg-white border-bottom pt-4 pb-3 px-4">
            <h6 class="fw-bold mb-0" style="color:#229799">
                <i class="bi bi-cloud-download me-2"></i>Export Laporan
            </h6>
        </div>
        <div class="card-body p-4">
            <p class="text-secondary small mb-4">Unduh rekap transaksi finansial Anda berdasarkan periode yang dipilih.
                Tersedia dalam berbagai format dokumen.</p>
            <form action="<?= base_url('setting/export') ?>" method="post">
                <?= csrf_field() ?>

                <div class="row g-3 mb-4">
                    <!-- PILIHAN DATA -->
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold text-secondary small mb-1">Tipe Data</label>
                        <input type="hidden" name="data" value="rekap">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i
                                    class="bi bi-file-earmark-text text-muted"></i></span>
                            <div class="form-control border-start-0 ps-0 bg-light text-muted fw-medium">Rekap Bulanan
                            </div>
                        </div>
                    </div>

                    <!-- PILIHAN FORMAT FILE -->
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold text-secondary small mb-1">Format File</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i
                                    class="bi bi-filetype-pdf text-muted"></i></span>
                            <select name="format" class="form-select border-start-0 ps-0">
                                <option value="pdf">Dokumen PDF (.pdf)</option>
                                <option value="excel">Microsoft Excel (.xlsx)</option>
                                <option value="word">Microsoft Word (.docx)</option>
                            </select>
                        </div>
                    </div>

                    <!-- PERIODE -->
                    <div class="col-12">
                        <label class="form-label fw-semibold text-secondary small mb-1">Periode Waktu</label>
                        <div class="row g-2">
                            <div class="col-12 col-sm-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i
                                            class="bi bi-calendar-month text-muted"></i></span>
                                    <select name="bulan" class="form-select border-start-0 ps-0">
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
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i
                                            class="bi bi-calendar text-muted"></i></span>
                                    <select name="tahun" class="form-select border-start-0 ps-0">
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
                </div>

                <div class="d-flex justify-content-end border-top pt-3">
                    <button type="submit" class="btn btn-auth rounded-pill px-4 fw-semibold">
                        <i class="bi bi-download me-1"></i> Unduh Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- SECTION 5: Hapus Semua Data (Danger Zone) -->
    <div class="card border border-danger border-opacity-25 shadow-sm rounded-4 mb-5 overflow-hidden">
        <div class="card-header bg-danger bg-opacity-10 border-danger border-opacity-25 pt-4 pb-3 px-4">
            <h6 class="fw-bold mb-0 text-danger">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>Zona Bahaya
            </h6>
        </div>
        <div class="card-body p-4 bg-white">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                <div>
                    <h6 class="fw-bold mb-1">Hapus Semua Data Transaksi</h6>
                    <p class="text-secondary small mb-0">Tindakan ini <strong>tidak bisa dibatalkan</strong>. Semua data
                        finansial Anda akan terhapus secara permanen dari server.</p>
                </div>
                <form action="<?= base_url('setting/hapus-data') ?>" method="post" id="formHapus">
                    <?= csrf_field() ?>
                    <button type="button" class="btn btn-danger rounded-pill px-4 fw-semibold text-nowrap"
                        onclick="bukaModal('formHapus')">
                        <i class="bi bi-trash3 me-1"></i> Hapus Data
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODAL KONFIRMASI PASSWORD -->
<div class="modal fade" id="modalKonfirmasi" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-bottom px-4 pt-4 pb-3">
                <h5 class="modal-title fw-bold text-dark">
                    <i class="bi bi-shield-lock text-warning me-2"></i>Konfirmasi Keamanan
                </h5>
                <button type="button" class="btn-close bg-light rounded-circle p-2" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <p class="text-secondary small mb-3">Untuk alasan keamanan, masukkan password aktif akun Anda guna
                    melanjutkan tindakan ini.</p>
                <div class="mb-2">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-key text-muted"></i></span>
                        <input type="password" id="inputKonfirmasiPassword" name="konfirmasi_password"
                            class="form-control border-start-0 ps-0" placeholder="Masukkan password Anda">
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top-0 px-4 pb-4 pt-0">
                <button type="button" class="btn btn-light border rounded-pill px-4 fw-semibold w-100 w-sm-auto"
                    data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-auth rounded-pill px-4 fw-semibold w-100 w-sm-auto"
                    onclick="submitForm()">Lanjutkan</button>
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

        // Tambahkan input password ke form (Logika bawaan)
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'password_konfirmasi';
        input.value = document.getElementById('inputKonfirmasiPassword').value;
        formTarget.appendChild(input);

        formTarget.submit();
    }
</script>

<?= $this->endSection() ?>