<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table      = 'transaksi';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'user_id',
        'tanggal',
        'kategori_id',
        'keterangan',
        'jumlah',
        'tipe'
    ];
}