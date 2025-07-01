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
        $currentUrl = '/inovasi';
        $breadcrumbs = $this->menuController->getBreadcrumb($currentUrl);
        return $this->loadAdminView('admin/inovasi', [
            'breadcrumbs' => $breadcrumbs
        ]);
    }

}
