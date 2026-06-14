<?php

namespace App\Controllers;

class dashboard extends BaseController
{
    public function index(): string
    {
        $data = [
            'title'         => 'Dashboard',
            'activeMenu'     => 'dashboard',
        ];

        return view('dashboard/index', $data);
    }
}
