<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class InovasiController extends BaseController
{
    protected $menuController;
    public function __construct() {}

    public function index()
    {
        $data = [
            'title' => 'Inovasi',
            'breadcrumbs' => [
                ['name' => 'Beranda', 'url' => 'admin/beranda'],
                ['name' => 'Inovasi', 'active' => true]
            ]
        ];
        return view('admin/inovasi', $data);
    }
}
