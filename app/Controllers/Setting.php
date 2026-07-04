<?php

namespace App\Controllers;

use Config\Database;

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
}