<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class AdminController extends BaseController
{
    public function index()
{
    return $this->loadView('admin/index', [
        'title' => 'Dashboard',
        'breadcrumb' => [
            ['label' => 'Dashboard', 'url' => '/admin'],
        ],
    ]);
}

public function berita()
{
    return $this->loadView('admin/berita', [
        'title' => 'Kelola Berita',
        'breadcrumb' => [
            ['label' => 'Dashboard', 'url' => '/admin'],
            ['label' => 'Kelola Berita', 'url' => '/admin/berita'],
        ],
    ]);
}

public function layanan()
{
    return $this->loadView('admin/layanan', [
        'title' => 'Kelola Layanan',
        'breadcrumb' => [
            ['label' => 'Dashboard', 'url' => '/admin'],
            ['label' => 'Kelola Layanan', 'url' => '/admin/layanan'],
        ],
    ]);
}

public function pengaduan()
{
    return $this->loadView('admin/pengaduan', [
        'title' => 'Kelola Pengaduan',
        'breadcrumb' => [
            ['label' => 'Dashboard', 'url' => '/admin'],
            ['label' => 'Kelola Pengaduan', 'url' => '/admin/pengaduan'],
        ],
    ]);
}

public function galeri()
{
    return $this->loadView('admin/galeri', [
        'title' => 'Kelola Galeri',
        'breadcrumb' => [
            ['label' => 'Dashboard', 'url' => '/admin'],
            ['label' => 'Kelola Galeri', 'url' => '/admin/galeri'],
        ],
    ]);
}

public function profil()
{
    return $this->loadView('admin/profil', [
        'title' => 'Kelola Profil',
        'breadcrumb' => [
            ['label' => 'Dashboard', 'url' => '/admin'],
            ['label' => 'Kelola Profil', 'url' => '/admin/profil'],
        ],
    ]);
}

public function inovasi()
{
    return $this->loadView('admin/inovasi', [
        'title' => 'Kelola Inovasi',
        'breadcrumb' => [
            ['label' => 'Dashboard', 'url' => '/admin'],
            ['label' => 'Kelola Inovasi', 'url' => '/admin/inovasi'],
        ],
    ]);
}

}
