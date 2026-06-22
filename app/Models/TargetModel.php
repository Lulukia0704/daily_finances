<?php

namespace App\Models;

use CodeIgniter\Model;

class TargetModel extends Model
{
    protected $table = 'target';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = ['user_id', 'nama_goal', 'target_nominal', 'target_selesai'];
    
    public function getTargetByUser($user_id)
    {
        return $this->db->table('target t')
            ->select('t.*, COALESCE(SUM(tr.jumlah), 0) as sudah_terkumpul')
            ->join('transaksi tr', 'tr.target_id = t.id','left')
            ->where('t.user_id', $user_id)
            ->groupBy('t.id')
            ->orderBy('t.created_at', 'DESC')
            ->get()
            ->getResultArray();
    }
    
    public function getTargetById($id, $user_id)
    {
        return $this->where('id', $id)
                    ->where('user_id', $user_id)
                    ->first();
    }
}

?>