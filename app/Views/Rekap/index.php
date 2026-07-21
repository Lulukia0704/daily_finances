<?php $this->extend('layouts/main')?>
<?php $this->section('content') ?>

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-bold" style="color:#229799">Rekap Bulanan</h4>
</div>

<!-- FILTER -->
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body py-2">
        <form method="get" action="<?= base_url('rekap') ?>">
            <!-- Menggunakan susunan flex yang aman dan rapi untuk mobile -->
            <div class="d-flex flex-wrap align-items-center gap-2">
                <div>
                    <a href="<?= base_url('rekap') ?>" 
                    class="btn btn-sm <?= !$tahun || $tahun == date('Y') ? 'btn-auth' : 'btn-outline-secondary' ?>">
                        Tahun Ini
                    </a>
                </div>
                <div class="d-flex align-items-center gap-2 ms-sm-2">
                    <label class="text-muted mb-0 text-nowrap" style="font-size:13px">Pilih Tahun:</label>
                    <select name="tahun" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                        <?php foreach ($tahunList as $t): ?>
                            <option value="<?= $t ?>" <?= $tahun == $t ? 'selected' : '' ?>>
                                <?= $t ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- TABEL -->
<div class="card border-0 shadow-sm">
    <!-- Menambahkan pembungkus table-responsive agar tabel aman di-scroll di HP -->
    <div class="card-body p-0 table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 5%">No</th>
                    <th style="min-width: 100px;">Bulan</th>
                    <th class="text-end" style="min-width: 140px;">Total Pemasukan</th>
                    <th class="text-end" style="min-width: 140px;">Total Pengeluaran</th>
                    <th class="text-end" style="min-width: 130px;">Selisih</th>
                    <th class="text-end" style="min-width: 110px;">% Pengeluaran</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rekap as $r): ?>
                <tr class="<?= $r['selisih'] < 0 ? 'table-danger' : '' ?>">
                    <td><?= $r['bulan'] ?></td>
                    <td class="text-nowrap"><?= $r['nama_bulan'] ?></td>
                    <td class="text-end text-success text-nowrap">
                        <?= $r['total_pemasukan'] > 0 
                            ? 'Rp ' . number_format($r['total_pemasukan'], 0, ',', '.') 
                            : '-' ?>
                    </td>
                    <td class="text-end text-danger text-nowrap">
                        <?= $r['total_pengeluaran'] > 0 
                            ? 'Rp ' . number_format($r['total_pengeluaran'], 0, ',', '.') 
                            : '-' ?>
                    </td>
                    <td class="text-end text-nowrap <?= $r['selisih'] < 0 ? 'text-danger' : 'text-success' ?>">
                        <?= $r['selisih'] != 0 
                            ? 'Rp ' . number_format(abs($r['selisih']), 0, ',', '.') 
                            : '-' ?>
                    </td>
                    <td class="text-end text-nowrap">
                        <?= $r['persen'] > 0 ? $r['persen'] . '%' : '-' ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <!-- TOTAL -->
            <tfoot class="table-light fw-bold">
                <tr>
                    <td colspan="2" class="text-nowrap">Total</td>
                    <td class="text-end text-success text-nowrap">
                        Rp <?= number_format(array_sum(array_column($rekap, 'total_pemasukan')), 0, ',', '.') ?>
                    </td>
                    <td class="text-end text-danger text-nowrap">
                        Rp <?= number_format(array_sum(array_column($rekap, 'total_pengeluaran')), 0, ',', '.') ?>
                    </td>
                    <td class="text-end text-nowrap">
                        <?php 
                        $totalSelisih = array_sum(array_column($rekap, 'total_pemasukan')) - 
                                       array_sum(array_column($rekap, 'total_pengeluaran'));
                        ?>
                        <span class="<?= $totalSelisih < 0 ? 'text-danger' : 'text-success' ?>">
                            Rp <?= number_format(abs($totalSelisih), 0, ',', '.') ?>
                        </span>
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<?= $this->endSection() ?>