<?php

namespace App\Controllers;

use App\Models\PiutangModel;

class Piutang extends BaseController
{
    public function index(): string
    {
        $user_id     = session()->get('user_id');
        $piutangModel = new PiutangModel();
        $piutangRaw  = $piutangModel->getPiutangByUser($user_id);

        // Hitung status
        $piutang = [];
        foreach ($piutangRaw as $p) {
            $sisa = $p['sisa_hutang'];

            if ($sisa <= 0 && $p['jumlah_pinjam'] > 0) {
                $status = $sisa < 0 ? 'Lebih Bayar' : 'Lunas';
            } else {
                $status = 'Belum Lunas';
            }

            $piutang[] = array_merge($p, ['status' => $status]);
        }

        // Filter
        $filter = $this->request->getGet('filter');
        if ($filter == 'lunas') {
            $piutang = array_filter($piutang, fn($p) => $p['status'] == 'Lunas');
        } elseif ($filter == 'belum') {
            $piutang = array_filter($piutang, fn($p) => $p['status'] == 'Belum Lunas');
        }

        // Search
        $search = $this->request->getGet('search');
        if (!empty($search)) {
            $piutang = array_filter($piutang, fn($p) =>
                stripos($p['nama_peminjam'], $search) !== false);
        }

        $data = [
            'title'      => 'Piutang',
            'activeMenu' => 'piutang',
            'piutang'    => $piutang,
            'filter'     => $filter,
            'search'     => $search ?? '',
        ];

        return view('piutang/index', $data);
    }

    public function simpan()
    {
        $user_id = session()->get('user_id');
        $db = \Config\Database::connect();

        // Simpan ke tabel piutang
        $piutangModel = new PiutangModel();
        $piutangModel->save([
            'user_id'       => $user_id,
            'nama_peminjam' => $this->request->getPost('nama_peminjam'),
            'tanggal_pinjam'=> $this->request->getPost('tanggal_pinjam'),
            'jumlah_pinjam' => $this->request->getPost('jumlah_pinjam'),
            'keterangan'    => $this->request->getPost('keterangan'),
        ]);

        // Ambil id piutang yang baru disimpan
        $piutang_id = $piutangModel->getInsertID();

        // Ambil id kategori Piutang Keluar
        $kategori = $db->table('kategori')
            ->where('nama', 'Piutang Keluar')
            ->get()->getRowArray();

        // Simpan ke tabel transaksi
        $db->table('transaksi')->insert([
            'user_id'     => $user_id,
            'tanggal'     => $this->request->getPost('tanggal_pinjam'),
            'kategori_id' => $kategori['id'],
            'keterangan'  => 'Piutang ke ' . $this->request->getPost('nama_peminjam'),
            'jumlah'      => $this->request->getPost('jumlah_pinjam'),
            'tipe'        => 'Pengeluaran',
        ]);

        return redirect()->to(base_url('piutang'))->with('sukses', 'Piutang berhasil ditambahkan!');
    }

    public function bayar($piutang_id)
    {
        $user_id = session()->get('user_id');
        $db = \Config\Database::connect();

        // Simpan ke tabel pembayaran_piutang
        $db->table('pembayaran_piutang')->insert([
            'piutang_id'   => $piutang_id,
            'jumlah_bayar' => $this->request->getPost('jumlah_bayar'),
            'tanggal_bayar'=> $this->request->getPost('tanggal_bayar'),
            'keterangan'   => $this->request->getPost('keterangan'),
        ]);

        // Ambil id kategori Piutang Masuk
        $kategori = $db->table('kategori')
            ->where('nama', 'Piutang Masuk')
            ->get()->getRowArray();

        // Ambil nama peminjam
        $piutang = $db->table('piutang')
            ->where('id', $piutang_id)
            ->get()->getRowArray();

        // Simpan ke tabel transaksi
        $db->table('transaksi')->insert([
            'user_id'     => $user_id,
            'tanggal'     => $this->request->getPost('tanggal_bayar'),
            'kategori_id' => $kategori['id'],
            'keterangan'  => 'Bayar piutang dari ' . $piutang['nama_peminjam'],
            'jumlah'      => $this->request->getPost('jumlah_bayar'),
            'tipe'        => 'Pemasukan',
        ]);

        return redirect()->to(base_url('piutang'))->with('sukses', 'Pembayaran berhasil dicatat!');
    }

    public function hapus($id)
    {
        $user_id = session()->get('user_id');
        $db = \Config\Database::connect();

        // Hapus pembayaran terkait
        $db->table('pembayaran_piutang')->where('piutang_id', $id)->delete();

        // Hapus transaksi terkait (piutang keluar)
        $db->table('transaksi')
            ->where('user_id', $user_id)
            ->where('kategori_id', function($db) {
                return $db->table('kategori')->select('id')->where('nama', 'Piutang Keluar');
            })
            ->delete();

        // Hapus piutang
        $piutangModel = new PiutangModel();
        $piutangModel->delete($id);

        return redirect()->to(base_url('piutang'))->with('sukses', 'Piutang berhasil dihapus!');
    }

    public function detail($id)
    {
        $user_id = session()->get('user_id');
        $db = \Config\Database::connect();

        // Ambil data piutang
        $piutang = $db->table('piutang')
            ->where('id', $id)
            ->where('user_id', $user_id)
            ->get()->getRowArray();

        if (!$piutang) {
            return redirect()->to(base_url('piutang'))->with('error', 'Data tidak ditemukan!');
        }

        // Ambil riwayat pembayaran
        $riwayat = $db->table('pembayaran_piutang')
            ->where('piutang_id', $id)
            ->orderBy('tanggal_bayar', 'ASC')
            ->get()->getResultArray();

        // Hitung total
        $sudah_dibayar = array_sum(array_column($riwayat, 'jumlah_bayar'));
        $sisa_hutang   = $piutang['jumlah_pinjam'] - $sudah_dibayar;

        // Status
        if ($sisa_hutang <= 0) {
            $status = $sisa_hutang < 0 ? 'Lebih Bayar' : 'Lunas';
        } else {
            $status = 'Belum Lunas';
        }

        $data = [
            'title'         => 'Detail Piutang',
            'activeMenu'    => 'piutang',
            'piutang'       => $piutang,
            'riwayat'       => $riwayat,
            'sudah_dibayar' => $sudah_dibayar,
            'sisa_hutang'   => $sisa_hutang,
            'status'        => $status,
        ];

        return view('piutang/detail', $data);
    }
}