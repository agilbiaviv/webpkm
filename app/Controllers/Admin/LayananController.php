<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class LayananController extends BaseController
{
    protected $menuController;
    public function __construct() {}

    public function index()
    {
        $data = [
            'title' => 'Layanan Kesehatan',
            'breadcrumbs' => [
                ['name' => 'Beranda', 'url' => 'admin/beranda'],
                ['name' => 'Layanan Kesehatan', 'active' => true]
            ]
        ];
        return view('admin/layanan/index', $data);
    }

    public function rawatJalan()
    {
        $data = [
            'title' => 'Layanan Kesehatan',
            'breadcrumbs' => [
                ['name' => 'Beranda', 'url' => 'admin/beranda'],
                ['name' => 'Layanan Kesehatan', 'url' => '#'],
                ['name' => 'Layanan Kesehatan', 'active' => true]
            ]
        ];
        return view('admin/layanan/rawat-jalan', $data);
    }
}
