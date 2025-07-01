<?php

namespace App\Controllers\Admin\profil;

use App\Controllers\BaseController;
use App\Models\Profil\SambutanModel;

class SambutanController extends BaseController
{
    protected $sambutanModel;

    public function __construct()
    {
        $this->sambutanModel = new SambutanModel();
    }

    public function save()
    {
        $id = $this->request->getPost('id'); // If you have hidden input for ID
        $fotoKepala = $this->request->getFile('foto_kepala');

        $data = [
            'isi_sambutan' => $this->request->getPost('isi_sambutan'),
            'nama_kepala' => $this->request->getPost('nama_kepala'), // if you add this to form
        ];

        if ($fotoKepala && $fotoKepala->isValid() && !$fotoKepala->hasMoved()) {
            $newName = $fotoKepala->getRandomName();
            $fotoKepala->move(FCPATH . 'uploads/sambutan', $newName);
            $data['foto_kepala'] = $newName;

            // Delete old photo if updating
            if (!empty($id)) {
                $oldData = $this->sambutanModel->find($id);
                if (!empty($oldData['foto_kepala']) && file_exists(FCPATH . 'uploads/sambutan/' . $oldData['foto_kepala'])) {
                    unlink(FCPATH . 'uploads/sambutan/' . $oldData['foto_kepala']);
                }
            }
        } else {
            return redirect()->to(base_url('admin/profil/sambutan'))->with('error', 'Upload foto gagal!');
        }

        if (empty($id)) {
            $this->sambutanModel->insert($data);
        } else {
            $this->sambutanModel->update($id, $data);
        }

        return redirect()->to(base_url('admin/profil/sambutan'))->with('success', 'Data sambutan berhasil disimpan.');
    }
}
