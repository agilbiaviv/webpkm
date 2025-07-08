<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Controllers\MenuController;

class BerandaController extends BaseController
{
    protected $menuController;
    public function __construct()
    {
        $this->menuController = new MenuController();
    }

    public function index()
    {
        $data = [
            'title' => 'Beranda',
            'breadcrumbs' => [
                ['name' => 'Beranda', 'active' => true]
            ]
        ];
        return $this->loadAdminView('admin/beranda', $data);
    }
}
