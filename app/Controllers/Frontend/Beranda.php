<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;

class Beranda extends BaseController
{
    public function index()
    {

        $beritaModel = new \App\Models\Berita\BeritaModel();
        $berita = $beritaModel->where('status', 1)->orderBy('created_at', 'desc')->findAll(3);

        // Load jadwal pelayanan from JadwalModel (or create one if you don't have)
        // $jadwalModel = new \App\Models\JadwalModel();
        // $jadwal = $jadwalModel->findAll();

        return view('frontend/beranda', [
            'title' => 'Beranda',
            'berita' => $berita,
        ]);
    }
}
