<?php

namespace App\Controllers\Api;

use App\Models\TransaksiModel;
use App\Models\KategoriModel;

class TransaksiApi extends BaseController
{
    public function index()  // 🔄 BERBEDA: hapus ': string'
    {
        $user_id = $this->request->user_id; // 🔄 BERBEDA: dari JWT bukan session
        $db = \Config\Database::connect();

        $kategori = $this->request->getGet('kategori');
        $tipe     = $this->request->getGet('tipe');
        $dari     = $this->request->getGet('dari');
        $sampai   = $this->request->getGet('sampai');
        $perPage  = $this->request->getGet('per_page') ?? 20;
        $page     = $this->request->getGet('page') ?? 1;

        $builder = $db->table('transaksi t')
            ->select('t.id, t.tanggal, t.keterangan, t.jumlah, t.tipe, 
                    k.nama as kategori_nama')
            ->join('kategori k', 'k.id = t.kategori_id', 'left')
            ->where('t.user_id', $user_id);

        if (!empty($kategori)) {
            if ($kategori == 'piutang_masuk') {
                $builder->like('t.keterangan', 'Piutang')
                        ->where('t.tipe', 'PEMASUKAN');
            } elseif ($kategori == 'piutang_keluar') {
                $builder->like('t.keterangan', 'Piutang')
                        ->where('t.tipe', 'PENGELUARAN');
            } else {
                $builder->where('t.kategori_id', $kategori);
            }
        }
        if (!empty($tipe)) $builder->where('t.tipe', $tipe);
        if (!empty($dari)) $builder->where('t.tanggal >=', $dari);
        if (!empty($sampai)) $builder->where('t.tanggal <=', $sampai);

        $total     = $builder->countAllResults(false);
        $transaksi = $builder->orderBy('t.tanggal', 'DESC')
                             ->orderBy('t.created_at', 'DESC')
                             ->limit($perPage, ($page - 1) * $perPage) // 🔄 BERBEDA: pakai limit() bukan array_slice()
                             ->get()
                             ->getResultArray();

        // 🔄 BERBEDA: return JSON dengan pagination info, bukan view()
        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Data transaksi berhasil diambil!',
            'data'    => $transaksi,
            'pagination' => [ // 🔄 BERBEDA: kirim info pagination ke Flutter
                'total'    => (int) $total,
                'page'     => (int) $page,
                'per_page' => (int) $perPage,
                'total_page' => ceil($total / $perPage)
            ]
        ])->setStatusCode(200);
    }

    public function simpan()
    {
        $user_id     = $this->request->user_id; // 🔄 BERBEDA: dari JWT
        $kategori_id = $this->request->getPost('kategori_id');
        $keterangan  = $this->request->getPost('keterangan');
        $kategori_id = !empty($kategori_id) ? $kategori_id : null;

        $target_id = null;
        if ($kategori_id) {
            $db  = \Config\Database::connect();
            $kat = $db->table('kategori')->where('id', $kategori_id)->get()->getRowArray();
            if ($kat && $kat['nama'] === 'Target' && !empty($keterangan)) {
                $target = $db->table('target')
                    ->where('user_id', $user_id)
                    ->where('nama_goal', $keterangan)
                    ->get()->getRowArray();
                if ($target) $target_id = $target['id'];
            }
        }

        $transaksiModel = new TransaksiModel();
        $transaksiModel->save([
            'user_id'     => $user_id,
            'tanggal'     => $this->request->getPost('tanggal'),
            'kategori_id' => $kategori_id,
            'target_id'   => $target_id,
            'keterangan'  => $keterangan,
            'jumlah'      => $this->request->getPost('jumlah'),
            'tipe'        => $this->request->getPost('tipe'),
        ]);

        // 🔄 BERBEDA: return JSON bukan redirect()
        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Transaksi berhasil ditambahkan!'
        ])->setStatusCode(201);
    }

    public function hapus($id)
    {
        $user_id = $this->request->user_id; // 🔄 BERBEDA: dari JWT
        $transaksiModel = new TransaksiModel();

        $transaksi = $transaksiModel->where('id', $id)
                                    ->where('user_id', $user_id)
                                    ->first();

        if (!$transaksi) {
            // 🔄 BERBEDA: return JSON error bukan redirect()
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Transaksi tidak ditemukan!'
            ])->setStatusCode(404);
        }

        $transaksiModel->delete($id);

        // 🔄 BERBEDA: return JSON bukan redirect()
        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Transaksi berhasil dihapus!'
        ])->setStatusCode(200);
    }

    public function edit($id) // 🔄 BERBEDA: di API fungsi edit = ambil data 1 transaksi (GET)
    {
        $user_id = $this->request->user_id; // 🔄 BERBEDA: dari JWT
        $db = \Config\Database::connect();

        $transaksi = $db->table('transaksi t')
            ->select('t.*, k.nama as kategori_nama')
            ->join('kategori k', 'k.id = t.kategori_id', 'left')
            ->where('t.id', $id)
            ->where('t.user_id', $user_id)
            ->get()
            ->getRowArray();

        if (!$transaksi) {
            // 🔄 BERBEDA: return JSON error bukan redirect()
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Transaksi tidak ditemukan!'
            ])->setStatusCode(404);
        }

        // 🔄 BERBEDA: return JSON data transaksi, bukan view()
        // Flutter yang handle tampilan form edit, bukan server
        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Data transaksi berhasil diambil!',
            'data'    => $transaksi
        ])->setStatusCode(200);
    }

    public function update($id)
    {
        $user_id     = $this->request->user_id; // 🔄 BERBEDA: dari JWT
        $kategori_id = $this->request->getPost('kategori_id');
        $kategori_id = !empty($kategori_id) ? $kategori_id : null;

        $transaksiModel = new TransaksiModel();

        // 🔄 BERBEDA: validasi kepemilikan data dulu
        $transaksi = $transaksiModel->where('id', $id)
                                    ->where('user_id', $user_id)
                                    ->first();

        if (!$transaksi) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Transaksi tidak ditemukan!'
            ])->setStatusCode(404);
        }

        $transaksiModel->update($id, [
            'tanggal'     => $this->request->getPost('tanggal'),
            'kategori_id' => $kategori_id,
            'keterangan'  => $this->request->getPost('keterangan'),
            'jumlah'      => $this->request->getPost('jumlah'),
            'tipe'        => $this->request->getPost('tipe'),
        ]);

        // 🔄 BERBEDA: return JSON bukan redirect()
        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Transaksi berhasil diperbarui!'
        ])->setStatusCode(200);
    }
}