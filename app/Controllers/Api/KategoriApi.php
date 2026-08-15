<?php

namespace App\Controllers\Api; // BERBEDA: namespace Api

use App\Models\KategoriModel;

class KategoriApi extends BaseController
{
    public function index() // BERBEDA: hapus ': string'
    {
        $user_id = $this->request->user_id; // 🔄 BERBEDA: dari JWT bukan session
        $kategoriModel = new KategoriModel();

        $kategori = $kategoriModel->getAllKategoriByUser($user_id);

        // BERBEDA: return JSON bukan view()
        // title dan activeMenu tidak dikirim karena Flutter yang handle UI
        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Data kategori berhasil diambil!',
            'data'    => array_values($kategori) // array_values supaya index array rapi di JSON
        ])->setStatusCode(200);
    }

    public function toggle($kategori_id)
    {
        $user_id = $this->request->user_id; // BERBEDA: dari JWT
        $db = \Config\Database::connect();

        $existing = $db->table('user_kategori')
            ->where('user_id', $user_id)
            ->where('kategori_id', $kategori_id)
            ->get()
            ->getRowArray();

        if ($existing) {
            $newStatus = $existing['status'] == 'AKTIF' ? 'NONAKTIF' : 'AKTIF';
            $db->table('user_kategori')
                ->where('user_id', $user_id)
                ->where('kategori_id', $kategori_id)
                ->update(['status' => $newStatus]);
        } else {
            $newStatus = 'AKTIF';
            $db->table('user_kategori')->insert([
                'user_id'     => $user_id,
                'kategori_id' => $kategori_id,
                'status'      => 'AKTIF'
            ]);
        }

        // BERBEDA: return JSON + status baru, bukan redirect()
        // Flutter butuh tahu status baru untuk update UI nya
        return $this->response->setJSON([
            'status'     => true,
            'message'    => 'Status kategori berhasil diubah!',
            'new_status' => $newStatus // BERBEDA: kirim status baru ke Flutter
        ])->setStatusCode(200);
    }

    public function edit($kategori_id) // BERBEDA: fungsi edit = ambil data 1 kategori
    {
        $user_id = $this->request->user_id; // BERBEDA: dari JWT
        $db = \Config\Database::connect();

        $kategori = $db->table('kategori k')
            ->select('k.id, k.nama, k.jenis, 
                      COALESCE(uk.anggaran_bulanan, 0) as anggaran_bulanan, 
                      COALESCE(uk.status, "NONAKTIF") as status')
            ->join('user_kategori uk', 
                   'uk.kategori_id = k.id AND uk.user_id = ' . $user_id, 'left')
            ->where('k.id', $kategori_id)
            ->get()
            ->getRowArray();

        if (!$kategori) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Kategori tidak ditemukan!'
            ])->setStatusCode(404);
        }

        // BERBEDA: return JSON data kategori, bukan view()
        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Data kategori berhasil diambil!',
            'data'    => $kategori
        ])->setStatusCode(200);
    }

    public function update($kategori_id)
    {
        $user_id  = $this->request->user_id; // BERBEDA: dari JWT
        $anggaran = $this->request->getPost('anggaran_bulanan');
        $db       = \Config\Database::connect();

        $existing = $db->table('user_kategori')
            ->where('user_id', $user_id)
            ->where('kategori_id', $kategori_id)
            ->get()
            ->getRowArray();

        if ($existing) {
            $db->table('user_kategori')
                ->where('user_id', $user_id)
                ->where('kategori_id', $kategori_id)
                ->update(['anggaran_bulanan' => $anggaran]);
        } else {
            $db->table('user_kategori')->insert([
                'user_id'          => $user_id,
                'kategori_id'      => $kategori_id,
                'status'           => 'NONAKTIF',
                'anggaran_bulanan' => $anggaran
            ]);
        }

        // BERBEDA: return JSON bukan redirect()
        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Anggaran berhasil diperbarui!'
        ])->setStatusCode(200);
    }
}