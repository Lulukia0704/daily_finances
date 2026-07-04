<?php 

namespace App\Controllers;

// use App\Models\PiutangModel; 

class Piutang extends BaseController
{
    public function index(): string
    {
        // $user_id = session()->get('user_id');
        // $piutangModel = new PiutangModel();
        // $piutangs = $piutangModel->getAllPiutangByUser($user_id);

        $data = [
            'title' => 'Daftar Piutang',
            'activeMenu' => 'piutang',
        //     'piutangs' => $piutangs,
        ];

        return view('Piutang/index', $data);
    }
}
?>