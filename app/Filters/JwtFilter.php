<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class JwtFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // === 1. TAMBAHKAN DUA BARIS KODE INI (Biar CORS & ngrok lolos) ===
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Authorization, Content-Type, X-Requested-With");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

        if ($request->getMethod() === 'options') {
            exit(0);
        }
        // ================================================================

        // --- KODE LAMA KAMU DI BAWAH INI (TETAPKAN) ---
        $header = $request->getHeaderLine('Authorization');

        if (empty($header)) {
            return response()->setJSON([
                'status'  => 401,
                'message' => 'Akses ditolak! Token Authorization tidak ditemukan.'
            ])->setStatusCode(401);
        }

        // Ambil token dari header "Bearer <token>"
        $token = null;
        if (preg_match('/Bearer\s(\S+)/', $header, $matches)) {
            $token = $matches[1];
        }

        if (!$token) {
            return response()->setJSON([
                'status'  => 401,
                'message' => 'Format token salah! Gunakan format Bearer <token>'
            ])->setStatusCode(401);
        }

        try {
            $key = getenv('JWT_SECRET_KEY');
            $decoded = JWT::decode($token, new Key($key, 'HS256'));

            // Menyimpan data user dari token ke dalam request agar bisa dipakai di Controller
            $request->user_id = $decoded->user_id;

        } catch (Exception $e) {
            return response()->setJSON([
                'status'  => 401,
                'message' => 'Token tidak valid atau sudah kedaluwarsa!'
            ])->setStatusCode(401);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu diisi
    }
}