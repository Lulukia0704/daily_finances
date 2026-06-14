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

    public function getAllKategoriByUser($userId)
    {
       return $this->db->table('kategori k')
            ->select('k.id, k.nama, k.jenis, k.is_default, COALESCE(uk.status,"NONAKTIF") as status, COALESCE(uk.anggaran_bulanan, 0) as anggaran_bulanan')
            ->join('user_kategori uk', 'uk.kategori_id = k.id AND uk.user_id = ' . $userId, 'left') 
            ->orderBy('uk.status', 'ASC')
            ->orderBy('k.jenis', 'ASC')
            ->orderBy('k.nama', 'ASC')
            ->get()
            ->getResultArray();
    }
}   

?>