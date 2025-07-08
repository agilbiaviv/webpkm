<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Controllers\MenuController;

class InovasiController extends BaseController
{
    protected $menuController;
    public function __construct()
    {
        $this->menuController = new MenuController();
    }

    public function index()
    {
        $data = [
            'title' => 'Inovasi',
            'breadcrumbs' => [
                ['name' => 'Beranda', 'url' => 'admin/beranda'],
                ['name' => 'Inovasi', 'active' => true]
            ]
        ];
        return $this->loadAdminView('admin/inovasi', $data);
    }
}
