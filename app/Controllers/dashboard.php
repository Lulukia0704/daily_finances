<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index(): string
    {
        $user_id = session()->get('user_id');
        $db = \Config\Database::connect();

        // Saldo keseluruhan (semua waktu)
        $saldoQuery = $db->table('transaksi')
            ->select("
                SUM(CASE WHEN tipe = 'Pemasukan' THEN jumlah ELSE 0 END) as total_masuk,
                SUM(CASE WHEN tipe = 'Pengeluaran' THEN jumlah ELSE 0 END) as total_keluar
            ")
            ->where('user_id', $user_id)
            ->get()
            ->getRowArray();

        $saldo = ($saldoQuery['total_masuk'] ?? 0) - ($saldoQuery['total_keluar'] ?? 0);

        // Pemasukan & Pengeluaran BULAN INI
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
            
    // Bar Chart - Pengeluaran per Kategori bulan ini
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

            // Pie Chart - Komposisi Kebutuhan vs Keinginan bulan ini
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

        // Time Series - default 7 hari terakhir
        $periode = $this->request->getGet('periode') ?? 'bulanan';

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

        $data = [
            'title'       => 'Dashboard',
            'activeMenu'  => 'dashboard',
            'saldo'       => $saldo,
            'pemasukan'   => $bulanIni['pemasukan'] ?? 0,
            'pengeluaran' => $bulanIni['pengeluaran'] ?? 0,
            'barChart'    => $barChart,
            'pieChart'    => $pieChart,
            'timeSeries'  => $timeSeriesRaw,
            'periode'     => $periode,
        ];

        

        return view('dashboard/index', $data);
    }
}