<?php

namespace App\Controllers\Admin\profil;

use App\Controllers\BaseController;
use App\Controllers\MenuController;
use App\Models\Profil\StrukturOrganisasiModel;

class ProfilController extends BaseController
{
    protected $menuController;
    protected $strukturModel;

    public function __construct()
    {
        $this->menuController = new MenuController();
        $this->strukturModel = new StrukturOrganisasiModel();
    }

    public function index()
    {
        $currentUrl = '/profil';
        $breadcrumbs = $this->menuController->getBreadcrumb($currentUrl);
        // print_r(count($breadcrumbs));
        return $this->loadAdminView('admin/profil', [
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function sambutan()
    {
        $currentUrl = '/profil/sambutan';
        $breadcrumbs = $this->menuController->getBreadcrumb($currentUrl);
        $sambutanModel = new \App\Models\Profil\SambutanModel();
        $sambutan = $sambutanModel->first(); // because it's probably only one row

        return $this->loadAdminView('admin/profil/sambutan', [
            'breadcrumbs' => $breadcrumbs,
            'sambutan' => $sambutan
        ]);
    }

    public function visiMisi()
    {
        $currentUrl = '/profil/visi-misi';
        $breadcrumbs = $this->menuController->getBreadcrumb($currentUrl);
        $visiMisiModel = new \App\Models\Profil\VisiMisiModel();
        $data = $visiMisiModel->first();

        return $this->loadAdminView('admin/profil/visi_misi', [
            'breadcrumbs' => $breadcrumbs,
            'data' => $data
        ]);
    }

    public function strukturOrganisasi()
    {
        $currentUrl = '/profil/struktur-organisasi';
        $data = $this->strukturModel
            ->orderBy('parent_id', 'ASC')
            ->orderBy('urutan', 'ASC')
            ->findAll();

        $breadcrumbs = $this->menuController->getBreadcrumb($currentUrl);
        return $this->loadAdminView('admin/profil/struktur_organisasi', [
            'breadcrumbs' => $breadcrumbs,
            'struktur' => $data
        ]);
    }
}
