<?php

namespace App\Controllers\Admin\berita;

use App\Controllers\BaseController;
use App\Models\Berita\KategoriModel;

class KategoriController extends BaseController
{
    public function store()
    {

        if ($this->request->getMethod() !== 'POST') {
            return $this->response->setStatusCode(403)->setJSON(['success' => false, 'message' => 'Forbidden']);
        }

        $kategoriModel = new KategoriModel();
        $nama_kategori = $this->request->getPost('nama_kategori');

        if (!$nama_kategori) {
            log_message('error', 'Kategori kosong');
            return $this->response->setJSON(['success' => false, 'message' => 'Nama kategori harus diisi!']);
        }

        if ($kategoriModel->where('nama_kategori', $nama_kategori)->first()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Kategori sudah ada! silahkan pilih kategori ..']);
        }

        $slug = url_title($nama_kategori, '-', true);
        $kategoriModel->insert([
            'nama_kategori' => $nama_kategori,
            'slug' => $slug,
        ]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Kategori berhasil ditambahkan!',
            'id' => $kategoriModel->insertID(),
            'csrf_hash' => csrf_hash()
        ]);
    }

    public function fetch()
    {
        $kategoriModel = new KategoriModel();
        $data = $kategoriModel->findAll(); // Get all categories
        return $this->response->setJSON($data);
    }
}
