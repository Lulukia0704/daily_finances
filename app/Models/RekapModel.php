<?php 
namespace App\Models;
use CodeIgniter\Model;

class RekapModel extends Model
{
    protected $table = 'transaksi';
    protected $useTimestamps = 'false';

    
    public function getRekapBulanan($user_id, $tahun)
    {
        return $this->db->table('transaksi')
        ->select("MONTH(tanggal) as bulan, SUM(CASE WHEN tipe = 'pemasukan' THEN jumlah ELSE 0 END) as total_pemasukan, SUM(CASE WHEN tipe = 'pengeluaran' THEN jumlah ELSE 0 END) as total_pengeluaran")
        ->where('user_id', $user_id)
        ->where('YEAR(tanggal)', $tahun)
        ->groupBy('MONTH(tanggal)')
        ->orderBy('MONTH(tanggal)', 'ASC')
        ->get()
        ->getResultArray();
    }
}  
    ?>