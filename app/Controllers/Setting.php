<?php

namespace App\Controllers;

use Config\Database;
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpWord\PhpWord;

class Setting extends BaseController
{
    public function index(): string
    {
        $user_id = session()->get('user_id');
        $db = \Config\Database::connect();
        $user = $db->table('users')->where('id', $user_id)->get()->getRowArray();

        $data = [
            'title'      => 'Pengaturan',
            'activeMenu' => 'setting',
            'user'       => $user,
        ];

        return view('setting/index', $data);
    }

    public function ubahNama()
    {
        $user_id = session()->get('user_id');
        $nama    = $this->request->getPost('nama');

        $db = \Config\Database::connect();
        $db->table('users')->where('id', $user_id)->update(['nama' => $nama]);

        session()->set('nama', $nama);

        return redirect()->to(base_url('setting'))->with('sukses', 'Nama berhasil diubah!');
    }

    public function ubahEmail()
    {
        $user_id  = session()->get('user_id');
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password_konfirmasi');

        $db   = \Config\Database::connect();
        $user = $db->table('users')->where('id', $user_id)->get()->getRowArray();

        // Cek password
        if (!password_verify($password, $user['password'])) {
            return redirect()->to(base_url('setting'))->with('error', 'Password salah!');
        }

        // Cek email sudah dipakai user lain
        $cek = $db->table('users')->where('email', $email)->where('id !=', $user_id)->get()->getRowArray();
        if ($cek) {
            return redirect()->to(base_url('setting'))->with('error', 'Email sudah digunakan!');
        }

        $db->table('users')->where('id', $user_id)->update(['email' => $email]);
        session()->set('email', $email);

        return redirect()->to(base_url('setting'))->with('sukses', 'Email berhasil diubah!');
    }

    public function gantiPassword()
    {
        $user_id          = session()->get('user_id');
        $password_lama    = $this->request->getPost('password_lama');
        $password_baru    = $this->request->getPost('password_baru');
        $konfirmasi       = $this->request->getPost('konfirmasi_password');

        $db   = \Config\Database::connect();
        $user = $db->table('users')->where('id', $user_id)->get()->getRowArray();

        // Cek password lama
        if (!password_verify($password_lama, $user['password'])) {
            return redirect()->to(base_url('setting'))->with('error', 'Password lama salah!');
        }

        // Cek konfirmasi password baru
        if ($password_baru !== $konfirmasi) {
            return redirect()->to(base_url('setting'))->with('error', 'Konfirmasi password tidak cocok!');
        }

        $hash = password_hash($password_baru, PASSWORD_DEFAULT);
        $db->table('users')->where('id', $user_id)->update(['password' => $hash]);

        return redirect()->to(base_url('setting'))->with('sukses', 'Password berhasil diganti!');
    }

    public function hapusData()
    {
        $user_id  = session()->get('user_id');
        $password = $this->request->getPost('password_konfirmasi');

        $db   = \Config\Database::connect();
        $user = $db->table('users')->where('id', $user_id)->get()->getRowArray();

        // Cek password
        if (!password_verify($password, $user['password'])) {
            return redirect()->to(base_url('setting'))->with('error', 'Password salah!');
        }

        $db->table('transaksi')->where('user_id', $user_id)->delete();

        return redirect()->to(base_url('setting'))->with('sukses', 'Semua data transaksi berhasil dihapus!');
    }
    public function export()
    {
        $user_id = session()->get('user_id');
        $format  = $this->request->getPost('format');
        $bulan   = $this->request->getPost('bulan');
        $tahun   = $this->request->getPost('tahun');
        $db      = \Config\Database::connect();

        // Query transaksi
        $builder = $db->table('transaksi t')
            ->select('t.tanggal, k.nama as kategori, t.keterangan, t.tipe, t.jumlah')
            ->join('kategori k', 'k.id = t.kategori_id', 'left')
            ->where('t.user_id', $user_id)
            ->where('YEAR(t.tanggal)', $tahun)
            ->orderBy('t.tanggal', 'ASC');

        if ($bulan != 'all') {
            $builder->where('MONTH(t.tanggal)', $bulan);
        }

        $transaksi = $builder->get()->getResultArray();

        // Nama file
        $namaBulan = [
            '01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April',
            '05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus',
            '09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'
        ];
        $periodeLabel = $bulan == 'all' ? $tahun : $namaBulan[$bulan] . '_' . $tahun;
        $namaFile = 'Laporan_Keuangan_' . $periodeLabel;

        if ($format == 'excel') {
            return $this->exportExcel($transaksi, $namaFile, $periodeLabel);
        } elseif ($format == 'word') {
            return $this->exportWord($transaksi, $namaFile, $periodeLabel);
        } else {
            return $this->exportPdf($transaksi, $namaFile, $periodeLabel);
        }
    }

    private function exportExcel($transaksi, $namaFile, $periode)
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A1', 'Laporan Keuangan - ' . $periode);
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

        // Kolom header
        $headers = ['No', 'Tanggal', 'Kategori', 'Keterangan', 'Pemasukan', 'Pengeluaran'];
        foreach ($headers as $i => $h) {
            $col = chr(65 + $i);
            $sheet->setCellValue($col . '3', $h);
            $sheet->getStyle($col . '3')->getFont()->setBold(true);
            $sheet->getStyle($col . '3')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('229799');
        }

        // Data
        $row = 4;
        $no = 1;
        $totalPemasukan = 0;
        $totalPengeluaran = 0;

        foreach ($transaksi as $t) {
            $pemasukan   = $t['tipe'] == 'Pemasukan' ? $t['jumlah'] : 0;
            $pengeluaran = $t['tipe'] == 'Pengeluaran' ? $t['jumlah'] : 0;
            $totalPemasukan   += $pemasukan;
            $totalPengeluaran += $pengeluaran;

            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, date('d/m/Y', strtotime($t['tanggal'])));
            $sheet->setCellValue('C' . $row, $t['kategori'] ?? '-');
            $sheet->setCellValue('D' . $row, $t['keterangan']);
            $sheet->setCellValue('E' . $row, $pemasukan > 0 ? $pemasukan : '');
            $sheet->setCellValue('F' . $row, $pengeluaran > 0 ? $pengeluaran : '');
            $row++;
        }

        // Total
        $sheet->setCellValue('D' . $row, 'TOTAL');
        $sheet->setCellValue('E' . $row, $totalPemasukan);
        $sheet->setCellValue('F' . $row, $totalPengeluaran);
        $sheet->getStyle('D' . $row . ':F' . $row)->getFont()->setBold(true);

        // Auto width
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Download
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $namaFile . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }

    private function exportWord($transaksi, $namaFile, $periode)
    {
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();

        // Judul
        $section->addText('Laporan Keuangan - ' . $periode,
            ['bold' => true, 'size' => 16],
            ['alignment' => 'center']
        );
        $section->addTextBreak(1);

        // Tabel
        $table = $section->addTable([
            'borderSize' => 6,
            'borderColor' => '229799',
            'cellMargin' => 80
        ]);

        // Header tabel
        $headers = ['No', 'Tanggal', 'Kategori', 'Keterangan', 'Pemasukan', 'Pengeluaran'];
        $table->addRow();
        foreach ($headers as $h) {
            $cell = $table->addCell(1500, ['bgColor' => '229799']);
            $cell->addText($h, ['bold' => true, 'color' => 'FFFFFF']);
        }

        // Data
        $no = 1;
        $totalPemasukan = 0;
        $totalPengeluaran = 0;

        foreach ($transaksi as $t) {
            $pemasukan   = $t['tipe'] == 'Pemasukan' ? 'Rp ' . number_format($t['jumlah'], 0, ',', '.') : '-';
            $pengeluaran = $t['tipe'] == 'Pengeluaran' ? 'Rp ' . number_format($t['jumlah'], 0, ',', '.') : '-';
            if ($t['tipe'] == 'Pemasukan') $totalPemasukan += $t['jumlah'];
            else $totalPengeluaran += $t['jumlah'];

            $table->addRow();
            $table->addCell(500)->addText($no++);
            $table->addCell(1500)->addText(date('d/m/Y', strtotime($t['tanggal'])));
            $table->addCell(2000)->addText($t['kategori'] ?? '-');
            $table->addCell(3000)->addText($t['keterangan']);
            $table->addCell(1500)->addText($pemasukan);
            $table->addCell(1500)->addText($pengeluaran);
        }

        // Total
        $table->addRow();
        $table->addCell(500)->addText('');
        $table->addCell(1500)->addText('');
        $table->addCell(2000)->addText('');
        $table->addCell(3000)->addText('TOTAL', ['bold' => true]);
        $table->addCell(1500)->addText('Rp ' . number_format($totalPemasukan, 0, ',', '.'), ['bold' => true]);
        $table->addCell(1500)->addText('Rp ' . number_format($totalPengeluaran, 0, ',', '.'), ['bold' => true]);

        // Download
        $writer = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: attachment;filename="' . $namaFile . '.docx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }

    private function exportPdf($transaksi, $namaFile, $periode)
    {
        $totalPemasukan = 0;
        $totalPengeluaran = 0;
        $rows = '';
        $no = 1;

        foreach ($transaksi as $t) {
            $pemasukan   = $t['tipe'] == 'Pemasukan' ? 'Rp ' . number_format($t['jumlah'], 0, ',', '.') : '-';
            $pengeluaran = $t['tipe'] == 'Pengeluaran' ? 'Rp ' . number_format($t['jumlah'], 0, ',', '.') : '-';
            if ($t['tipe'] == 'Pemasukan') $totalPemasukan += $t['jumlah'];
            else $totalPengeluaran += $t['jumlah'];

            $bg = $no % 2 == 0 ? '#f9f9f9' : '#ffffff';
            $rows .= "<tr style='background:$bg'>
                <td>{$no}</td>
                <td>" . date('d/m/Y', strtotime($t['tanggal'])) . "</td>
                <td>" . ($t['kategori'] ?? '-') . "</td>
                <td>{$t['keterangan']}</td>
                <td style='text-align:right'>$pemasukan</td>
                <td style='text-align:right'>$pengeluaran</td>
            </tr>";
            $no++;
        }

        $html = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; font-size: 12px; }
                h2 { text-align: center; color: #229799; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th { background: #229799; color: white; padding: 8px; text-align: left; }
                td { padding: 6px 8px; border-bottom: 1px solid #eee; }
                .total { font-weight: bold; background: #f0f0f0; }
                .text-right { text-align: right; }
            </style>
        </head>
        <body>
            <h2>Laporan Keuangan - {$periode}</h2>
            <p style='text-align:center'>Dicetak pada: " . date('d M Y H:i') . "</p>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Kategori</th>
                        <th>Keterangan</th>
                        <th>Pemasukan</th>
                        <th>Pengeluaran</th>
                    </tr>
                </thead>
                <tbody>
                    {$rows}
                    <tr class='total'>
                        <td colspan='4'>TOTAL</td>
                        <td class='text-right'>Rp " . number_format($totalPemasukan, 0, ',', '.') . "</td>
                        <td class='text-right'>Rp " . number_format($totalPengeluaran, 0, ',', '.') . "</td>
                    </tr>
                </tbody>
            </table>
        </body>
        </html>";

        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream($namaFile . '.pdf', ['Attachment' => true]);
        exit;
    }
}