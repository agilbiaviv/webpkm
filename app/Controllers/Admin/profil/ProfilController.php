<?php

namespace App\Controllers\Admin\profil;

use App\Controllers\BaseController;
use App\Models\Profil\StrukturOrganisasiModel;

class ProfilController extends BaseController
{
    protected $strukturModel;

    public function __construct()
    {
        $this->strukturModel = new StrukturOrganisasiModel();
    }

    // public function index()
    // {
    //     return redirect()->to(base_url('/admin/profil/sambutan'));
    // }

    public function sambutan()
    {
        $sambutanModel = new \App\Models\Profil\SambutanModel();
        $sambutan = $sambutanModel->first(); // because it's probably only one row

        $data = [
            'title' => 'Sambutan Kepala Puskesmas',
            'breadcrumbs' => [
                ['name' => 'Beranda', 'url' => 'admin/beranda'],
                ['name' => 'Profil', 'url' => '#'],
                ['name' => 'Sambutan Kepala Puskesmas', 'active' => true]
            ],
            'sambutan' => $sambutan
        ];
        return view('admin/profil/sambutan', $data);
    }

    public function visiMisi()
    {

        $visiMisiModel = new \App\Models\Profil\VisiMisiModel();
        $VisiMisi = $visiMisiModel->first();

        $data = [
            'title' => 'Visi dan Misi',
            'breadcrumbs' => [
                ['name' => 'Beranda', 'url' => 'admin/beranda'],
                ['name' => 'Profil', 'url' => '#'],
                ['name' => 'Visi dan Misi', 'active' => true]
            ],
            'data' => $VisiMisi
        ];

        return view('admin/profil/visi_misi', $data);
    }

    public function strukturOrganisasi()
    {

        $struktur = $this->strukturModel
            ->orderBy('parent_id', 'ASC')
            ->orderBy('urutan', 'ASC')
            ->findAll();

        $data = [
            'title' => 'Struktur Organisasi',
            'breadcrumbs' => [
                ['name' => 'Beranda', 'url' => 'admin/beranda'],
                ['name' => 'Profil', 'url' => '#'],
                ['name' => 'Strukutur Organisasi', 'active' => true]
            ],
            'struktur' => $struktur
        ];

        return view('admin/profil/struktur_organisasi', $data);
    }
}
