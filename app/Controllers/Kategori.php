<?php

namespace App\Controllers;

use App\Models\KategoriModel;

class Kategori extends BaseController
{
    public function index():string
    {
        $kategoriModel = new KategoriModel();
        $user_id = session()->get('user_id');

        $data = [
            'title' => 'Kategori',
            'activeMenu' => 'kategori',
            'kategori' => $kategoriModel->getAllKategoriByUser($user_id),
        ];

        return view('kategori/index', $data);
    }
    public function toggle($kategori_id)
    {
        $user_id = session()->get('user_id');
        
        $db = \Config\Database::connect();
        
        // Cek apakah sudah ada di user_kategori
        $existing = $db->table('user_kategori')
            ->where('user_id', $user_id)
            ->where('kategori_id', $kategori_id)
            ->get()
            ->getRowArray();
        
        if ($existing) {
            // Sudah ada → toggle statusnya
            $newStatus = $existing['status'] == 'AKTIF' ? 'NONAKTIF' : 'AKTIF';
            $db->table('user_kategori')
                ->where('user_id', $user_id)
                ->where('kategori_id', $kategori_id)
                ->update(['status' => $newStatus]);
        } else {
            // Belum ada → insert baru dengan status AKTIF
            $db->table('user_kategori')->insert([
                'user_id'     => $user_id,
                'kategori_id' => $kategori_id,
                'status'      => 'AKTIF'
            ]);
        }
        
        return redirect()->to(base_url('kategori'));
    }
        public function edit($kategori_id)
    {
        $user_id = session()->get('user_id');
        $db = \Config\Database::connect();

        // Ambil data kategori + anggaran user
        $kategori = $db->table('kategori k')
            ->select('k.id, k.nama, k.jenis, COALESCE(uk.anggaran_bulanan, 0) as anggaran_bulanan, COALESCE(uk.status, "NONAKTIF") as status')
            ->join('user_kategori uk', 'uk.kategori_id = k.id AND uk.user_id = ' . $user_id, 'left')
            ->where('k.id', $kategori_id)
            ->get()
            ->getRowArray();

        $data = [
            'title'      => 'Edit Kategori',
            'activeMenu' => 'kategori',
            'kategori'   => $kategori,
        ];

        return view('kategori/edit', $data);
    }

    public function update($kategori_id)
    {
        $user_id = session()->get('user_id');
        $anggaran = $this->request->getPost('anggaran_bulanan');

        $db = \Config\Database::connect();

        // Cek apakah sudah ada di user_kategori
        $existing = $db->table('user_kategori')
            ->where('user_id', $user_id)
            ->where('kategori_id', $kategori_id)
            ->get()
            ->getRowArray();

        if ($existing) {
            // Update anggaran
            $db->table('user_kategori')
                ->where('user_id', $user_id)
                ->where('kategori_id', $kategori_id)
                ->update(['anggaran_bulanan' => $anggaran]);
        } else {
            // Insert baru
            $db->table('user_kategori')->insert([
                'user_id'          => $user_id,
                'kategori_id'      => $kategori_id,
                'status'           => 'NONAKTIF',
                'anggaran_bulanan' => $anggaran
            ]);
        }

        return redirect()->to(base_url('kategori'))->with('sukses', 'Anggaran berhasil diperbarui!');
    }

}

?>