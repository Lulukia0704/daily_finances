<?php 

namespace App\Controllers;

class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }
    public function register()
    {
        return view('auth/register');
    }
    public function prosesRegister()
    {
        // Ambil data dari form
        $nama     = $this->request->getPost('nama');
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $konfirmasi = $this->request->getPost('konfirmasi');

        // Cek password sama dengan konfirmasi
        if ($password !== $konfirmasi) {
            return redirect()->back()->with('error', 'Kata sandi tidak cocok!');
        }

        // Simpan ke database
        $userModel = new \App\Models\UserModel();
        $userModel->save([
            'nama'     => $nama,
            'email'    => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);
        
        return redirect()->to(base_url('login'))->with('sukses', 'Akun berhasil dibuat! Silakan masuk.');
    }
    public function prosesLogin()
    {
        // Ambil data dari form
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        // Cek di database
        $userModel = new \App\Models\UserModel();
        $user = $userModel->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Email tidak terdaftar!');
        }

        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'kata sandi salah!');
        }

        // Simpan session
        session()->set([
            'user_id' => $user['id'],
            'user_nama' => $user['nama'],
            'user_email' => $user['email'],
            'logged_in' => true
        ]);

        return redirect()->to(base_url('dashboard'));
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'))->with('sukses', 'Berhasil keluar!');
    }
}
 ?>