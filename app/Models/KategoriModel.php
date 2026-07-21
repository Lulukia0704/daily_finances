<?php 

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table      = 'kategori';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'nama',
        'jenis',
        'anggaran_bulanan',
        'is_default',
    ];

    public function getAllKategoriByUser($user_id)
    {
      return $this->db->table('kategori k')
        ->select('k.id, k.nama, k.jenis, k.is_default, k.is_piutang,
                  COALESCE(uk.status, "NONAKTIF") as status,
                  COALESCE(uk.anggaran_bulanan, 0) as anggaran_bulanan')
        ->join('user_kategori uk', 
               'uk.kategori_id = k.id AND uk.user_id = ' . $user_id, 
               'left')
        ->where('k.is_piutang', 0) // ← sembunyikan kategori piutang
        ->orderBy('CASE WHEN uk.status = \'AKTIF\' THEN 0 ELSE 1 END', 'ASC')
        ->orderBy('k.jenis', 'ASC')
        ->orderBy('k.nama', 'ASC')
        ->get()
        ->getResultArray();
    }
}   

?>