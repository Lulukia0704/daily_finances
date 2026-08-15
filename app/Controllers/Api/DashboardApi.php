<?php

namespace App\Controllers\Api; // 🔄 BERBEDA: namespace Api

use App\Controllers\BaseController;

class DashboardApi extends BaseController
{
    public function index()  // 🔄 BERBEDA: hapus ': string' karena return JSON bukan string HTML
    {
        $user_id = $this->request->user_id; // 🔄 BERBEDA: ambil dari JWT token, bukan session()->get()
        $db = \Config\Database::connect();

        // Saldo keseluruhan — SAMA
        $saldoQuery = $db->table('transaksi')
            ->select("
                SUM(CASE WHEN tipe = 'Pemasukan' THEN jumlah ELSE 0 END) as total_masuk,
                SUM(CASE WHEN tipe = 'Pengeluaran' THEN jumlah ELSE 0 END) as total_keluar
            ")
            ->where('user_id', $user_id)
            ->get()
            ->getRowArray();

        $saldo = ($saldoQuery['total_masuk'] ?? 0) - ($saldoQuery['total_keluar'] ?? 0);

        // Pemasukan & Pengeluaran bulan ini — SAMA
        $bulanIni = $db->table('transaksi')
            ->select("
                SUM(CASE WHEN tipe = 'Pemasukan' THEN jumlah ELSE 0 END) as pemasukan,
                SUM(CASE WHEN tipe = 'Pengeluaran' THEN jumlah ELSE 0 END) as pengeluaran
            ")
            ->where('user_id', $user_id)
            ->where('MONTH(tanggal)', date('m'))
            ->where('YEAR(tanggal)', date('Y'))
            ->get()
            ->getRowArray();

        // Bar Chart — SAMA
        $barChart = $db->table('transaksi t')
            ->select('k.nama as kategori, SUM(t.jumlah) as total')
            ->join('kategori k', 'k.id = t.kategori_id')
            ->where('t.user_id', $user_id)
            ->where('t.tipe', 'Pengeluaran')
            ->where('MONTH(t.tanggal)', date('m'))
            ->where('YEAR(t.tanggal)', date('Y'))
            ->groupBy('k.id')
            ->orderBy('total', 'DESC')
            ->get()
            ->getResultArray();

        // Pie Chart — SAMA
        $pieChart = $db->table('transaksi t')
            ->select('k.jenis, SUM(t.jumlah) as total')
            ->join('kategori k', 'k.id = t.kategori_id')
            ->where('t.user_id', $user_id)
            ->where('t.tipe', 'Pengeluaran')
            ->where('MONTH(t.tanggal)', date('m'))
            ->where('YEAR(t.tanggal)', date('Y'))
            ->groupBy('k.jenis')
            ->get()
            ->getResultArray();

        // Time Series
        $periode = $this->request->getGet('periode') ?? 'bulanan'; // 🔄 BERBEDA: Flutter kirim via query param

        if ($periode == '7hari') {
            $timeSeriesRaw = $db->table('transaksi')
                ->select("DATE(tanggal) as label,
                    SUM(CASE WHEN tipe = 'Pemasukan' THEN jumlah ELSE 0 END) as pemasukan,
                    SUM(CASE WHEN tipe = 'Pengeluaran' THEN jumlah ELSE 0 END) as pengeluaran")
                ->where('user_id', $user_id)
                ->where('tanggal >=', date('Y-m-d', strtotime('-7 days')))
                ->groupBy('DATE(tanggal)')
                ->orderBy('DATE(tanggal)', 'ASC')
                ->get()->getResultArray();
        } elseif ($periode == 'bulanan') {
            $timeSeriesRaw = $db->table('transaksi')
                ->select("DATE_FORMAT(tanggal, '%Y-%m') as label,
                    SUM(CASE WHEN tipe = 'Pemasukan' THEN jumlah ELSE 0 END) as pemasukan,
                    SUM(CASE WHEN tipe = 'Pengeluaran' THEN jumlah ELSE 0 END) as pengeluaran")
                ->where('user_id', $user_id)
                ->where('tanggal >=', date('Y-m-d', strtotime('-6 months')))
                ->groupBy("DATE_FORMAT(tanggal, '%Y-%m')")
                ->orderBy('label', 'ASC')
                ->get()->getResultArray();
        } else {
            $timeSeriesRaw = $db->table('transaksi')
                ->select("YEAR(tanggal) as label,
                    SUM(CASE WHEN tipe = 'Pemasukan' THEN jumlah ELSE 0 END) as pemasukan,
                    SUM(CASE WHEN tipe = 'Pengeluaran' THEN jumlah ELSE 0 END) as pengeluaran")
                ->where('user_id', $user_id)
                ->groupBy('YEAR(tanggal)')
                ->orderBy('YEAR(tanggal)', 'ASC')
                ->get()->getResultArray();
        }

        // 🔄 BERBEDA: return JSON bukan view() + $data array tidak ada title/activeMenu
        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Data dashboard berhasil diambil!',
            'data'    => [
                'saldo'       => (int) $saldo,
                'pemasukan'   => (int) ($bulanIni['pemasukan'] ?? 0),
                'pengeluaran' => (int) ($bulanIni['pengeluaran'] ?? 0),
                'bar_chart'   => $barChart,
                'pie_chart'   => $pieChart,
                'time_series' => $timeSeriesRaw,
                'periode'     => $periode,
            ]
        ])->setStatusCode(200);
    }
}