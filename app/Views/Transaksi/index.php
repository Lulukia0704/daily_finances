<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- HEADER -->
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div class="d-flex align-items-center gap-2">
        <div class="bg-opacity-10 p-2 rounded-3" style="background-color: #229799; color: #229799;">
            <i class="bi bi-wallet2 fs-4"></i>
        </div>
        <h4 class="mb-0 fw-bold" style="color:#229799">Data Transaksi</h4>
    </div>
    <button class="btn btn-auth shadow-sm px-4 rounded-pill" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-circle me-1"></i> Tambah Transaksi
    </button>
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

<!-- FILTER -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-3">
        <form method="get" action="<?= base_url('transaksi') ?>">
            <div class="row g-2 align-items-center row-cols-1 row-cols-sm-2 row-cols-md-auto">
                <div class="col">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-end-0"><i
                                class="bi bi-tags text-muted"></i></span>
                        <select name="kategori" class="form-select form-select-sm border-start-0 ps-0">
                            <option value="">Semua Kategori</option>
                            <?php foreach ($kategoriAktif as $k): ?>
                                <option value="<?= $k['id'] ?>" <?= $filter['kategori'] == $k['id'] ? 'selected' : '' ?>>
                                    <?= $k['nama'] ?>
                                </option>
                            <?php endforeach; ?>
                            <option value="piutang_masuk" <?= $filter['kategori'] == 'piutang_masuk' ? 'selected' : '' ?>>
                                Piutang Masuk</option>
                            <option value="piutang_keluar" <?= $filter['kategori'] == 'piutang_keluar' ? 'selected' : '' ?>>
                                Piutang Keluar</option>
                        </select>
                    </div>
                </div>

                <div class="col">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-end-0"><i
                                class="bi bi-arrow-left-right text-muted"></i></span>
                        <select name="tipe" class="form-select form-select-sm border-start-0 ps-0">
                            <option value="">Semua Tipe</option>
                            <option value="Pemasukan" <?= $filter['tipe'] == 'Pemasukan' ? 'selected' : '' ?>>Pemasukan
                            </option>
                            <option value="Pengeluaran" <?= $filter['tipe'] == 'Pengeluaran' ? 'selected' : '' ?>>
                                Pengeluaran</option>
                        </select>
                    </div>
                </div>

                <div class="col">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-end-0"><i
                                class="bi bi-calendar3 text-muted"></i></span>
                        <input type="date" name="dari" class="form-control form-control-sm border-start-0 ps-0"
                            value="<?= $filter['dari'] ?>">
                    </div>
                </div>

                <div class="col-auto text-center d-none d-md-block">
                    <span class="text-muted fw-bold">-</span>
                </div>

                <div class="col">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-end-0"><i
                                class="bi bi-calendar3 text-muted"></i></span>
                        <input type="date" name="sampai" class="form-control form-control-sm border-start-0 ps-0"
                            value="<?= $filter['sampai'] ?>">
                    </div>
                </div>

                <div class="col-md-auto ms-md-auto d-flex gap-2 justify-content-end mt-3 mt-md-0">
                    <button type="submit" class="btn btn-sm btn-auth flex-fill flex-sm-none px-3 rounded-pill">
                        <i class="bi bi-search"></i> Cari
                    </button>
                    <a href="<?= base_url('transaksi') ?>"
                        class="btn btn-sm btn-light border flex-fill flex-sm-none px-3 rounded-pill text-center">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- TABEL -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
    <div class="card-body p-0 table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-muted">
                <tr>
                    <th class="ps-4" style="width: 5%">No</th>
                    <th style="min-width: 100px;">Tanggal</th>
                    <th style="min-width: 120px;">Kategori</th>
                    <th style="min-width: 200px;">Keterangan</th>
                    <th class="text-end" style="min-width: 130px;">Pemasukan</th>
                    <th class="text-end" style="min-width: 130px;">Pengeluaran</th>
                    <th class="text-center pe-4" style="width: 10%">Aksi</th>
                </tr>
            </thead>
            <tbody class="border-top-0">
                <?php if (empty($transaksi)): ?>
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="text-muted d-flex flex-column align-items-center">
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mb-3"
                                    style="width: 60px; height: 60px;">
                                    <i class="bi bi-inbox fs-2"></i>
                                </div>
                                <h6 class="fw-semibold mb-1">Belum ada transaksi</h6>
                                <small>Data transaksi Anda pada filter ini masih kosong.</small>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1;
                    foreach ($transaksi as $t): ?>
                        <tr>
                            <td class="ps-4 text-muted"><?= $no++ ?></td>
                            <td class="text-nowrap fw-medium"><?= date('d M Y', strtotime($t['tanggal'])) ?></td>
                            <td>
                                <span
                                    class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 px-2 py-1 rounded-pill fw-normal">
                                    <i class="bi bi-tag-fill me-1 opacity-50"></i> <?= $t['kategori_nama'] ?>
                                </span>
                            </td>
                            <td class="text-secondary"><?= $t['keterangan'] ?></td>
                            <td class="text-end text-nowrap">
                                <?php if ($t['tipe'] == 'Pemasukan'): ?>
                                    <span class="text-success fw-semibold bg-success bg-opacity-10 px-2 py-1 rounded-2">
                                        + Rp <?= number_format($t['jumlah'], 0, ',', '.') ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end text-nowrap">
                                <?php if ($t['tipe'] == 'Pengeluaran'): ?>
                                    <span class="text-danger fw-semibold bg-danger bg-opacity-10 px-2 py-1 rounded-2">
                                        - Rp <?= number_format($t['jumlah'], 0, ',', '.') ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="pe-4 text-center">
                                <div class="d-inline-flex gap-2">
                                    <a href="<?= base_url('transaksi/edit/' . $t['id']) ?>"
                                        class="btn btn-sm btn-light border text-primary rounded-circle" data-bs-toggle="tooltip"
                                        title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="<?= base_url('transaksi/hapus/' . $t['id']) ?>"
                                        class="btn btn-sm btn-light border text-danger rounded-circle" data-bs-toggle="tooltip"
                                        title="Hapus" onclick="return confirm('Yakin ingin menghapus transaksi ini?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- PAGINATION -->
<?php
$totalPage = ceil($total / $perPage);
if ($totalPage > 1): ?>
    <nav class="d-flex justify-content-center mt-2">
        <ul class="pagination pagination-sm shadow-sm flex-wrap">
            <?php for ($i = 1; $i <= $totalPage; $i++): ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="<?= base_url('transaksi') ?>?page=<?= $i ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
<?php endif; ?>

<!-- MODAL TAMBAH TRANSAKSI -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-bottom px-4 pt-4 pb-3">
                <h5 class="modal-title fw-bold" style="color:#229799">
                    <i class="bi bi-plus-circle-dotted me-2"></i>Tambah Transaksi
                </h5>
                <button type="button" class="btn-close bg-light rounded-circle p-2" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="<?= base_url('transaksi/simpan') ?>" method="post">
                    <?= csrf_field() ?>

                    <!-- TIPE TRANSAKSI -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary small mb-2">Tipe Transaksi</label>
                        <div class="d-flex gap-2">
                            <input type="radio" class="btn-check" name="tipe" id="pemasukan" value="Pemasukan">
                            <label class="btn btn-outline-success flex-fill rounded-3 py-2 fw-medium" for="pemasukan">
                                <i class="bi bi-graph-up-arrow me-1"></i> Pemasukan
                            </label>

                            <input type="radio" class="btn-check" name="tipe" id="pengeluaran" value="Pengeluaran"
                                checked>
                            <label class="btn btn-outline-danger flex-fill rounded-3 py-2 fw-medium" for="pengeluaran">
                                <i class="bi bi-graph-down-arrow me-1"></i> Pengeluaran
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small mb-1">Tanggal</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i
                                    class="bi bi-calendar-date text-muted"></i></span>
                            <input type="date" name="tanggal" class="form-control border-start-0 ps-0"
                                value="<?= date('Y-m-d') ?>" required>
                        </div>
                    </div>

                    <div class="mb-3" id="fieldKategori">
                        <label class="form-label fw-semibold text-secondary small mb-1">Kategori</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i
                                    class="bi bi-grid text-muted"></i></span>
                            <select name="kategori_id" class="form-select border-start-0 ps-0" required>
                                <option value="">Pilih Kategori</option>
                                <?php foreach ($kategoriAktif as $k): ?>
                                    <option value="<?= $k['id'] ?>"><?= $k['nama'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small mb-1">Keterangan</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i
                                    class="bi bi-card-text text-muted"></i></span>
                            <input type="text" id="inputKeterangan" name="keterangan"
                                class="form-control border-start-0 ps-0" placeholder="Contoh: Makan siang, Gaji, dll">
                            <select id="dropdownGoal" name="keterangan" class="form-select border-start-0 ps-0 d-none">
                                <option value="">Pilih Goal...</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary small mb-1">Jumlah</label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-light fw-bold text-muted border-end-0">Rp</span>
                            <input type="number" name="jumlah" class="form-control fw-bold border-start-0 ps-0"
                                placeholder="0" required>
                        </div>
                    </div>

                    <div class="d-flex gap-2 pt-2 border-top mt-4">
                        <button type="submit" class="btn btn-auth w-100 rounded-pill py-2 fw-semibold">
                            <i class="bi bi-save me-1"></i> Simpan Transaksi
                        </button>
                        <button type="button" class="btn btn-light border w-100 rounded-pill py-2 fw-semibold"
                            data-bs-dismiss="modal">
                            Batal
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Logika Tipe Transaksi (Menampilkan/Menyembunyikan Kategori)
    document.querySelectorAll('input[name="tipe"]').forEach(radio => {
        radio.addEventListener('change', function () {
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

    // Logika Fetch Kategori "Target" -> Dropdown Goals
    const kategoriData = <?= json_encode(array_values($kategoriAktif)) ?>;
    const kategoriSelect = document.querySelector('select[name="kategori_id"]');
    const inputKeterangan = document.getElementById('inputKeterangan');
    const dropdownGoal = document.getElementById('dropdownGoal');
    let goalsLoaded = false;

    async function loadGoals() {
        if (goalsLoaded) return;
        const res = await fetch('<?= base_url('target/goals') ?>');
        const goals = await res.json();
        goals.forEach(g => {
            const opt = document.createElement('option');
            opt.value = g.nama_goal;
            opt.text = g.nama_goal;
            dropdownGoal.appendChild(opt);
        });
        goalsLoaded = true;
    }

    kategoriSelect.addEventListener('change', function () {
        const found = kategoriData.find(k => String(k.id) === String(this.value));
        if (found && found.nama === 'Target') {
            loadGoals();
            dropdownGoal.classList.remove('d-none');
            dropdownGoal.setAttribute('name', 'keterangan');
            inputKeterangan.classList.add('d-none');
            inputKeterangan.removeAttribute('name');
        } else {
            dropdownGoal.classList.add('d-none');
            dropdownGoal.removeAttribute('name');
            inputKeterangan.classList.remove('d-none');
            inputKeterangan.setAttribute('name', 'keterangan');
        }
    });

    // Inisialisasi Tooltip Bootstrap (Optional, membuat icon tabel jika disorot ada tulisannya)
    document.addEventListener("DOMContentLoaded", function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>

<?= $this->endSection() ?>