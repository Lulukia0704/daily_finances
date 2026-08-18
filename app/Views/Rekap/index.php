<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!-- HEADER -->
<div class="d-flex align-items-center gap-3 mb-4">
    <div class="bg-opacity-10 p-2 rounded-3" style="background-color: #229799; color: #229799;">
        <i class="bi bi-journal-text fs-4"></i>
    </div>
    <h4 class="mb-0 fw-bold" style="color:#229799">Rekap Bulanan</h4>
</div>

<!-- FILTER -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-3">
        <form method="get" action="<?= base_url('rekap') ?>">
            <div class="d-flex flex-wrap align-items-center gap-3">

                <!-- Tombol Tahun Ini -->
                <a href="<?= base_url('rekap') ?>"
                    class="btn btn-sm rounded-pill px-4 fw-medium <?= !$tahun || $tahun == date('Y') ? 'btn-auth shadow-sm' : 'btn-light border text-secondary' ?>">
                    <i class="bi bi-calendar-check me-1"></i> Tahun Ini
                </a>

                <!-- Dropdown Pilih Tahun -->
                <div class="input-group input-group-sm" style="width: 200px;">
                    <span class="input-group-text bg-light border-end-0"><i
                            class="bi bi-calendar3 text-muted"></i></span>
                    <select name="tahun" class="form-select border-start-0 ps-0 fw-medium"
                        onchange="this.form.submit()">
                        <?php foreach ($tahunList as $t): ?>
                            <option value="<?= $t ?>" <?= $tahun == $t ? 'selected' : '' ?>>
                                Tahun <?= $t ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>
        </form>
    </div>
</div>

<!-- TABEL REKAPITULASI -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
    <div class="card-body p-0 table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-muted">
                <tr>
                    <th class="ps-4" style="width: 5%">Bulan</th>
                    <th style="min-width: 120px;">Nama Bulan</th>
                    <th class="text-end" style="min-width: 140px;">Pemasukan</th>
                    <th class="text-end" style="min-width: 140px;">Pengeluaran</th>
                    <th class="text-end" style="min-width: 130px;">Selisih (Net)</th>
                    <th class="text-center pe-4" style="min-width: 120px;">Rasio Pengeluaran</th>
                </tr>
            </thead>
            <tbody class="border-top-0">
                <?php foreach ($rekap as $r): ?>
                    <tr>
                        <!-- Angka Bulan -->
                        <td class="ps-4 text-muted fw-medium"><?= str_pad($r['bulan'], 2, '0', STR_PAD_LEFT) ?></td>

                        <!-- Nama Bulan -->
                        <td class="text-nowrap fw-bold text-dark"><?= $r['nama_bulan'] ?></td>

                        <!-- Pemasukan -->
                        <td class="text-end text-nowrap">
                            <?= $r['total_pemasukan'] > 0
                                ? '<span class="text-success fw-semibold"><i class="bi bi-arrow-down-short"></i> Rp ' . number_format($r['total_pemasukan'], 0, ',', '.') . '</span>'
                                : '<span class="text-muted opacity-50">-</span>' ?>
                        </td>

                        <!-- Pengeluaran -->
                        <td class="text-end text-nowrap">
                            <?= $r['total_pengeluaran'] > 0
                                ? '<span class="text-danger fw-semibold"><i class="bi bi-arrow-up-short"></i> Rp ' . number_format($r['total_pengeluaran'], 0, ',', '.') . '</span>'
                                : '<span class="text-muted opacity-50">-</span>' ?>
                        </td>

                        <!-- Selisih -->
                        <td class="text-end text-nowrap">
                            <?php if ($r['selisih'] < 0): ?>
                                <!-- Defisit (Merah) -->
                                <span class="text-danger fw-bold bg-danger bg-opacity-10 px-2 py-1 rounded-2">
                                    - Rp <?= number_format(abs($r['selisih']), 0, ',', '.') ?>
                                </span>
                            <?php elseif ($r['selisih'] > 0): ?>
                                <!-- Surplus (Hijau) -->
                                <span class="text-success fw-bold bg-success bg-opacity-10 px-2 py-1 rounded-2">
                                    + Rp <?= number_format($r['selisih'], 0, ',', '.') ?>
                                </span>
                            <?php else: ?>
                                <span class="text-muted opacity-50">-</span>
                            <?php endif; ?>
                        </td>

                        <!-- Persen Pengeluaran -->
                        <td class="text-center pe-4 text-nowrap">
                            <?php if ($r['persen'] > 0): ?>
                                <!-- Mewarnai badge berdasarkan besarnya persentase -->
                                <?php
                                $badgeClass = 'bg-secondary text-secondary border-secondary';
                                if ($r['persen'] >= 80)
                                    $badgeClass = 'bg-danger text-danger border-danger';
                                elseif ($r['persen'] >= 50)
                                    $badgeClass = 'bg-warning text-dark border-warning';
                                else
                                    $badgeClass = 'bg-success text-success border-success';
                                ?>
                                <span
                                    class="badge <?= $badgeClass ?> bg-opacity-10 border border-opacity-25 px-2 py-1 rounded-pill fw-medium">
                                    <?= $r['persen'] ?>%
                                </span>
                            <?php else: ?>
                                <span class="text-muted opacity-50">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

            <!-- TOTAL KESELURUHAN -->
            <tfoot class="bg-light border-top">
                <tr>
                    <td colspan="2" class="ps-4 fw-bold text-secondary py-3 text-nowrap">TOTAL KESELURUHAN</td>
                    <td class="text-end fw-bold text-success text-nowrap fs-6">
                        Rp <?= number_format(array_sum(array_column($rekap, 'total_pemasukan')), 0, ',', '.') ?>
                    </td>
                    <td class="text-end fw-bold text-danger text-nowrap fs-6">
                        Rp <?= number_format(array_sum(array_column($rekap, 'total_pengeluaran')), 0, ',', '.') ?>
                    </td>
                    <td class="text-end text-nowrap fs-6">
                        <?php
                        $totalSelisih = array_sum(array_column($rekap, 'total_pemasukan')) - array_sum(array_column($rekap, 'total_pengeluaran'));
                        ?>
                        <?php if ($totalSelisih < 0): ?>
                            <span class="text-danger fw-bold bg-danger bg-opacity-10 px-2 py-1 rounded-2">
                                - Rp <?= number_format(abs($totalSelisih), 0, ',', '.') ?>
                            </span>
                        <?php else: ?>
                            <span class="text-success fw-bold bg-success bg-opacity-10 px-2 py-1 rounded-2">
                                + Rp <?= number_format($totalSelisih, 0, ',', '.') ?>
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="pe-4"></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<?= $this->endSection() ?>