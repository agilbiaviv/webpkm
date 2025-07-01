<?php

namespace App\Controllers\Admin\profil;

use App\Controllers\BaseController;
use App\Models\Profil\VisiMisiModel;

class VisiMisiController extends BaseController
{
    protected $visiMisiModel;

    public function __construct()
    {
        $this->visiMisiModel = new VisiMisiModel();
    }

    public function index()
    {
        $data = $this->visiMisiModel->first(); // Assuming only one row
        return $this->loadAdminView('admin/profil/visi-misi', ['data' => $data]);
    }

    public function save()
    {
        $id = $this->request->getPost('id');

        $data = [
            'visi' => $this->request->getPost('visi'),
            'misi' => $this->request->getPost('misi'),
        ];

        if (empty($id)) {
            $this->visiMisiModel->insert($data);
        } else {
            $this->visiMisiModel->update($id, $data);
        }

        return redirect()->to(base_url('admin/profil/visi-misi'))->with('success', 'Data Visi & Misi berhasil disimpan.');
    }
}
