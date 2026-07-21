<?php

namespace App\Models;

use CodeIgniter\Model;

class PiutangModel extends Model
{
    protected $table      = 'piutang';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'user_id',
        'nama_peminjam',
        'tanggal_pinjam',
        'jumlah_pinjam',
        'keterangan'
    ];

    // Ambil semua piutang milik user beserta status
    public function getPiutangByUser($user_id)
    {
        return $this->db->table('piutang p')
            ->select('p.*,
                COALESCE(SUM(pp.jumlah_bayar), 0) as sudah_dibayar,
                p.jumlah_pinjam - COALESCE(SUM(pp.jumlah_bayar), 0) as sisa_hutang')
            ->join('pembayaran_piutang pp', 'pp.piutang_id = p.id', 'left')
            ->where('p.user_id', $user_id)
            ->groupBy('p.id')
            ->orderBy('p.tanggal_pinjam', 'DESC')
            ->get()
            ->getResultArray();
    }
}