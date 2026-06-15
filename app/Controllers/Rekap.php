<?php

namespace App\Controller;

use App\Models\RekapModel;

class Rekap extends BaseController
{
    public function index(): string 
    {
        $user_id = session()->get('user_id');
        $tahun = $this->request->getGet('tahun') ?? date('Y');

        $rekapModel = new RekapModel();
        $rekapRaw = $rekapModel->getRekapBulanan($user_id, $tahun);

        //array 12 bulan + isi 0 kalo gk ada transaksi
        $namaBulan =[
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        //Index hasil query berdasarkan bulan
        $rekapIndexed = [];
        foreach ($rekapRaw as $r) {
            $rekapIndexed[$r['bulan']] = $r;
        }
        
        //Buat 12 baris lengkapnya
        $rekap = [];
        for ($i = 1; $i <= 12; $i++) {
            $pemasukan = $rekapIndexed[$i]['total_pemasukan'] ?? 0;
            $pengeluaran = $rekapIndexed[$i]['total_pengeluaran'] ?? 0;
            $selisih = $pemasukan - $pengeluaran;

            $rekap[] = [
                'bulan' => $i,
                'nama_bulan' => $namaBulan[$i],
                'total_pemasukan' => $pemasukan,
                'total_pengeluaran' => $pengeluaran,
                'selisih' => $selisih,
                'selisih' => $selisih,
                'persen' => $pemasukan > 0 ? round(($selisih / $pemasukan) * 100, 2) : 0,
            ];
        }

        $data = [
            'title' => 'Rekap Bulanan',
            'activeMenu' => 'rekap',
            'rekap' => $rekap,
            'tahun' => $tahun,
            'tahunList' => range(date('Y'), date('Y') - 5),
        ];

        return view('rekap/index', $data);
    }
}


?>