<?php

namespace App\Controllers;

use App\Models\TargetModel;

class Target extends BaseController
{
    public function index(): string
    {
        $user_id    = session()->get('user_id');
        $targetModel = new TargetModel();
        $targetRaw  = $targetModel->getTargetByUser($user_id);

        // Hitung sisa, persen, status
        $target = [];
        foreach ($targetRaw as $t) {
            $sisa   = $t['target_nominal'] - $t['sudah_terkumpul'];
            $persen = $t['target_nominal'] > 0 
                      ? round(($t['sudah_terkumpul'] / $t['target_nominal']) * 100, 1) 
                      : 0;

            // Hitung status
            if ($persen >= 100) {
                $status = 'Tercapai';
            } elseif (!empty($t['target_selesai']) && strtotime($t['target_selesai']) < time()) {
                $status = 'Terlambat';
            } elseif (!empty($t['target_selesai'])) {
                $status = 'On Track';
            } else {
                $status = 'Berjalan';
            }

            $target[] = array_merge($t, [
                'sisa'   => $sisa,
                'persen' => $persen,
                'status' => $status,
            ]);
        }

        // Filter
        $filter = $this->request->getGet('filter');
        if ($filter == 'tercapai') {
            $target = array_filter($target, fn($t) => $t['status'] == 'Tercapai');
        } elseif ($filter == 'belum') {
            $target = array_filter($target, fn($t) => $t['status'] != 'Tercapai');
        }

        // Search
        $search = $this->request->getGet('search');
        if (!empty($search)) {
            $target = array_filter($target, fn($t) => 
                stripos($t['nama_goal'], $search) !== false);
        }

        $data = [
            'title'      => 'Target',
            'activeMenu' => 'target',
            'target'     => $target,
            'filter'     => $filter,
            'search'     => $search,
        ];

        return view('target/index', $data);
    }

    public function simpan()
    {
        $user_id = session()->get('user_id');

        $targetModel = new TargetModel();
        $targetModel->save([
            'user_id'        => $user_id,
            'nama_goal'      => $this->request->getPost('nama_goal'),
            'target_nominal' => $this->request->getPost('target_nominal'),
            'target_selesai' => $this->request->getPost('target_selesai') ?: null,
        ]);

        return redirect()->to(base_url('target'))->with('sukses', 'Target berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $user_id = session()->get('user_id');

        $targetModel = new TargetModel();
        $target = $targetModel->getTargetById($id, $user_id);

        if (!$target) {
            return redirect()->to(base_url('target'))->with('error', 'Target tidak ditemukan!');
        }

        $data = [
            'title'      => 'Edit Target',
            'activeMenu' => 'target',
            'target'     => $target,
        ];

        return view('target/edit', $data);
    }

    public function update($id)
    {
        $user_id = session()->get('user_id');

        $targetModel = new TargetModel();
        $target = $targetModel->getTargetById($id, $user_id);

        if (!$target) {
            return redirect()->to(base_url('target'))->with('error', 'Target tidak ditemukan!');
        }

        $targetModel->update($id, [
            'nama_goal'      => $this->request->getPost('nama_goal'),
            'target_nominal' => $this->request->getPost('target_nominal'),
            'target_selesai' => $this->request->getPost('target_selesai') ?: null,
        ]);

        return redirect()->to(base_url('target'))->with('sukses', 'Target berhasil diperbarui!');
    }

    public function hapus($id)
    {
        $user_id = session()->get('user_id');

        $targetModel = new TargetModel();
        $target = $targetModel->getTargetById($id, $user_id);

        if (!$target) {
            return redirect()->to(base_url('target'))->with('error', 'Target tidak ditemukan!');
        }

        $targetModel->delete($id);

        return redirect()->to(base_url('target'))->with('sukses', 'Target berhasil dihapus!');
    }   

    public function getGoals()
    {
        $user_id = session()->get('user_id');
        $targetModel = new TargetModel();
        $targets = $targetModel->select('id, nama_goal')
                                 ->where('user_id', $user_id)
                                 ->findAll();

        return $this->response->setJSON($targets);
    }
}