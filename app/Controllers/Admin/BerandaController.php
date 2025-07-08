<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class BerandaController extends BaseController
{
    public function __construct() {}

    public function index()
    {
        $data = [
            'title' => 'Beranda',
            'breadcrumbs' => [
                ['name' => 'Beranda', 'active' => true]
            ]
        ];
        return view('admin/beranda', $data);
    }
}
