<?php

namespace App\Controllers;

use App\Models\TransaksiModel;
use App\Models\KategoriModel;

class Transaksi extends BaseController
{
        public function index(): string
    {
        $user_id = session()->get('user_id');
        $db = \Config\Database::connect();

        // Ambil parameter filter dari URL
        $kategori = $this->request->getGet('kategori');
        $tipe     = $this->request->getGet('tipe');
        $dari     = $this->request->getGet('dari');
        $sampai   = $this->request->getGet('sampai');

        // Query dasar
        $builder = $db->table('transaksi t')
            ->select('t.id, t.tanggal, t.keterangan, t.jumlah, t.tipe, 
                    k.nama as kategori_nama')
            ->join('kategori k', 'k.id = t.kategori_id', 'left')
            ->where('t.user_id', $user_id);

        // Terapkan filter
        if (!empty($kategori)) {
            $builder->where('t.kategori_id', $kategori);
        }
        if (!empty($tipe)) {
            $builder->where('t.tipe', $tipe);
        }
        if (!empty($dari)) {
            $builder->where('t.tanggal >=', $dari);
        }
        if (!empty($sampai)) {
            $builder->where('t.tanggal <=', $sampai);
        }

        $transaksi = $builder->orderBy('t.tanggal', 'DESC')
                            ->orderBy('t.created_at', 'DESC')
                            ->get()
                            ->getResultArray();

        // Ambil kategori aktif untuk dropdown
        $kategoriModel = new \App\Models\KategoriModel();
        $kategoriData  = $kategoriModel->getAllKategoriByUser($user_id);
        $kategoriAktif = array_filter($kategoriData, fn($k) => $k['status'] == 'AKTIF');

        $data = [
            'title'         => 'Transaksi',
            'activeMenu'    => 'transaksi',
            'transaksi'     => $transaksi,
            'kategoriAktif' => $kategoriAktif,
            'filter'        => [
                'kategori' => $kategori,
                'tipe'     => $tipe,
                'dari'     => $dari,
                'sampai'   => $sampai,
            ]
        ];

        return view('transaksi/index', $data);
    }

    public function simpan()
    {
    $user_id     = session()->get('user_id');
    $kategori_id = $this->request->getPost('kategori_id');

    // Kalau kategori kosong (pemasukan) → set NULL
    $kategori_id = !empty($kategori_id) ? $kategori_id : null;

    $transaksiModel = new TransaksiModel();
    $transaksiModel->save([
        'user_id'     => $user_id,
        'tanggal'     => $this->request->getPost('tanggal'),
        'kategori_id' => $kategori_id,
        'keterangan'  => $this->request->getPost('keterangan'),
        'jumlah'      => $this->request->getPost('jumlah'),
        'tipe'        => $this->request->getPost('tipe'),
    ]);

    return redirect()->to(base_url('transaksi'))->with('sukses', 'Transaksi berhasil ditambahkan!');
    }

    public function hapus($id)
    {
    $user_id = session()->get('user_id');
    $transaksiModel = new TransaksiModel();

    // Pastikan transaksi milik user ini
    $transaksi = $transaksiModel->where('id', $id)
                                ->where('user_id', $user_id)
                                ->first();

    if (!$transaksi) {
        return redirect()->to(base_url('transaksi'))->with('error', 'Transaksi tidak ditemukan!');
    }

    $transaksiModel->delete($id);

    return redirect()->to(base_url('transaksi'))->with('sukses', 'Transaksi berhasil dihapus!');
    }

    public function edit($id)
    {
    $user_id = session()->get('user_id');
    $db = \Config\Database::connect();

    // Ambil data transaksi
    $transaksi = $db->table('transaksi t')
        ->select('t.*, k.nama as kategori_nama')
        ->join('kategori k', 'k.id = t.kategori_id', 'left')
        ->where('t.id', $id)
        ->where('t.user_id', $user_id)
        ->get()
        ->getRowArray();

    if (!$transaksi) {
        return redirect()->to(base_url('transaksi'))->with('error', 'Transaksi tidak ditemukan!');
    }

    // Ambil kategori aktif untuk dropdown
    $kategoriModel = new \App\Models\KategoriModel();
    $kategori = $kategoriModel->getAllKategoriByUser($user_id);
    $kategoriAktif = array_filter($kategori, fn($k) => $k['status'] == 'AKTIF');

    $data = [
        'title'         => 'Edit Transaksi',
        'activeMenu'    => 'transaksi',
        'transaksi'     => $transaksi,
        'kategoriAktif' => $kategoriAktif,
    ];

    return view('transaksi/edit', $data);
    }

    public function update($id)
    {
        $user_id     = session()->get('user_id');
        $kategori_id = $this->request->getPost('kategori_id');
        $kategori_id = !empty($kategori_id) ? $kategori_id : null;

        $transaksiModel = new TransaksiModel();
        $transaksiModel->update($id, [
            'tanggal'     => $this->request->getPost('tanggal'),
            'kategori_id' => $kategori_id,
            'keterangan'  => $this->request->getPost('keterangan'),
            'jumlah'      => $this->request->getPost('jumlah'),
            'tipe'        => $this->request->getPost('tipe'),
        ]);

        return redirect()->to(base_url('transaksi'))->with('sukses', 'Transaksi berhasil diperbarui!');
    }
}