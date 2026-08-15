<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\UserModel;
use Firebase\JWT\JWT;

class AuthApi extends BaseController
{
    public function register()
    {
        $nama       = $this->request->getPost('nama');
        $email      = $this->request->getPost('email');
        $password   = $this->request->getPost('password');
        $konfirmasi = $this->request->getPost('konfirmasi');

        // Validasi
        if (empty($nama) || empty($email) || empty($password)) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Semua field wajib diisi!'
            ])->setStatusCode(422);
        }

        if ($password !== $konfirmasi) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Kata sandi tidak cocok!'
            ])->setStatusCode(422);
        }

        // Cek email sudah terdaftar
        $userModel = new UserModel();
        if ($userModel->where('email', $email)->first()) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Email sudah terdaftar!'
            ])->setStatusCode(422);
        }

        // Simpan
        $userModel->save([
            'nama'     => $nama,
            'email'    => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Akun berhasil dibuat! Silakan masuk.'
        ])->setStatusCode(201);
    }

    public function login()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if (!$user) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Email tidak terdaftar!'
            ])->setStatusCode(401);
        }

        if (!password_verify($password, $user['password'])) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Kata sandi salah!'
            ])->setStatusCode(401);
        }

        // Generate JWT token
        $payload = [
            'iss'     => 'daily-finances',
            'iat'     => time(),
            'exp'     => time() + (60 * 60 * 24 * 7), // 7 hari
            'user_id' => $user['id'],
            'nama'    => $user['nama'],
            'email'   => $user['email'],
        ];

        $token = JWT::encode($payload, getenv('JWT_SECRET_KEY'), 'HS256');

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Login berhasil!',
            'data'    => [
                'token' => $token,
                'user'  => [
                    'id'    => $user['id'],
                    'nama'  => $user['nama'],
                    'email' => $user['email'],
                ]
            ]
        ])->setStatusCode(200);
    }

    public function logout()
    {
        // Di REST API tidak ada session
        // Token dibuang dari sisi Flutter/mobile
        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Berhasil keluar!'
        ])->setStatusCode(200);
    }

    public function me()
    {
        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Token valid!',
            'data'    => [
                'user_id' => $this->request->user_id
            ]
        ]);
    }
}