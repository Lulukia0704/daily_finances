<?= $this->extend('layouts/main')?>
<?= $this->section('content') ?>

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-bold" style="color:#229799">Rekap Bulanan</h4>
    <a href="#" class="btn btn-auth">
        <i class="bi bi-file-pdf me-1"></i> Convert PDF
    </a>
</div>

<!-- FILTER -->
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body py-2">
        <form method="get" action="<?= base_url('rekap') ?>">
            <div class="row g-2 align-items-center">
                <div class="col-auto">
                    <a href="<?= base_url('rekap') ?>" 
                    class="btn btn-sm <?= !$tahun || $tahun == date('Y') ? 'btn-auth' : 'btn-outline-secondary' ?>">
                        Tahun Ini
                    </a>
                </div>
                <div class="col-auto">
                    <label class="text-muted mb-0" style="font-size:13px">Pilih Tahun:</label>
                </div>
                <div class="col-auto">
                    <select name="tahun" class="form-select form-select-sm" onchange="this.form.submit()">
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
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Bulan</th>
                    <th class="text-end">Total Pemasukan</th>
                    <th class="text-end">Total Pengeluaran</th>
                    <th class="text-end">Selisih</th>
                    <th class="text-end">% Pengeluaran</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rekap as $r): ?>
                <tr class="<?= $r['selisih'] < 0 ? 'table-danger' : '' ?>">
                    <td><?= $r['bulan'] ?></td>
                    <td><?= $r['nama_bulan'] ?></td>
                    <td class="text-end text-success">
                        <?= $r['total_pemasukan'] > 0 
                            ? 'Rp ' . number_format($r['total_pemasukan'], 0, ',', '.') 
                            : '-' ?>
                    </td>
                    <td class="text-end text-danger">
                        <?= $r['total_pengeluaran'] > 0 
                            ? 'Rp ' . number_format($r['total_pengeluaran'], 0, ',', '.') 
                            : '-' ?>
                    </td>
                    <td class="text-end <?= $r['selisih'] < 0 ? 'text-danger' : 'text-success' ?>">
                        <?= $r['selisih'] != 0 
                            ? 'Rp ' . number_format(abs($r['selisih']), 0, ',', '.') 
                            : '-' ?>
                    </td>
                    <td class="text-end">
                        <?= $r['persen'] > 0 ? $r['persen'] . '%' : '-' ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <!-- TOTAL -->
            <tfoot class="table-light fw-bold">
                <tr>
                    <td colspan="2">Total</td>
                    <td class="text-end text-success">
                        Rp <?= number_format(array_sum(array_column($rekap, 'total_pemasukan')), 0, ',', '.') ?>
                    </td>
                    <td class="text-end text-danger">
                        Rp <?= number_format(array_sum(array_column($rekap, 'total_pengeluaran')), 0, ',', '.') ?>
                    </td>
                    <td class="text-end">
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