<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Controllers\MenuController;

class LayananController extends BaseController
{
    protected $menuController;
    public function __construct()
    {
        $this->menuController = new MenuController();
    }

    public function index()
    {
        $data = [
            'title' => 'Layanan Kesehatan',
            'breadcrumbs' => [
                ['name' => 'Beranda', 'url' => 'admin/beranda'],
                ['name' => 'Layanan Kesehatan', 'active' => true]
            ]
        ];
        return $this->loadAdminView('admin/layanan/index', $data);
    }

    public function rawatJalan()
    {
        $currentUrl = '/layanan/rawat-jalan';
        $breadcrumbs = $this->menuController->getBreadcrumb($currentUrl);
        return $this->loadAdminView('admin/layanan/rawat-jalan', [
            'breadcrumbs' => $breadcrumbs
        ]);
    }
}
