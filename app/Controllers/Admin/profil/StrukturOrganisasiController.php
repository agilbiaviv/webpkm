<?php

namespace App\Controllers\Admin\profil;

use App\Controllers\BaseController;
use App\Models\Profil\StrukturOrganisasiModel;

class StrukturOrganisasiController extends BaseController
{
    protected $strukturModel;

    public function __construct()
    {
        $this->strukturModel = new StrukturOrganisasiModel();
    }

    // public function index()
    // {
    //     $data = [
    //         'title' => 'Struktur Organisasi',
    //         'breadcrumbs' => [
    //             ['name' => 'Beranda', 'url' => 'admin/beranda'],
    //             ['name' => 'Profil', 'url' => '#'],
    //             ['name' => 'Strukutur Organisasi', 'active' => true]
    //         ],
    //         'struktur' => $this->strukturModel->findAll()
    //     ];
    //     return view('admin/profil/struktur-organisasi', $data);
    // }

    public function create()
    {
        $data = [
            'title' => 'Struktur Organisasi',
            'breadcrumbs' => [
                ['name' => 'Beranda', 'url' => 'admin/beranda'],
                ['name' => 'Profil', 'url' => '#'],
                ['name' => 'Strukutur Organisasi', 'active' => true]
            ],
            'strukturList' => $this->strukturModel->findAll()
        ];

        return view('admin/profil/struktur_organisasi_form', $data);
    }

    public function store()
    {
        if (!$this->validate([
            'nama' => 'required|min_length[3]',
            'jabatan' => 'required',
            'foto' => 'uploaded[foto]|max_size[foto,2048]|is_image[foto]|mime_in[foto,image/png,image/jpg,image/jpeg]',
            'urutan' => 'required'
        ])) {
            return redirect()->back()->withInput()->with('error', 'Harap isi form dengan benar!');
        }

        $file = $this->request->getFile('foto');
        $newName = $file->getRandomName();
        $file->move(FCPATH . 'uploads/struktur/', $newName);

        $parentId = $this->request->getPost('parent_id');
        $parentId = ($parentId === null || trim($parentId) === '') ? null : $parentId;

        $data = [
            'nama' => $this->request->getPost('nama'),
            'jabatan' => $this->request->getPost('jabatan'),
            'foto' => $newName,
            'parent_id' => $parentId,
            'urutan' => $this->request->getPost('urutan')
        ];

        $this->strukturModel->insert($data);

        return redirect()->to(base_url('admin/profil/struktur-organisasi'))->with('success', 'Data struktur berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $struktur = $this->strukturModel->find($id);

        if (!$struktur) {
            return redirect()->to('/admin/profil/struktur-organisasi')->with('error', 'Data tidak ditemukan.');
        }

        $data = [
            'title' => 'Struktur Organisasi',
            'breadcrumbs' => [
                ['name' => 'Beranda', 'url' => 'admin/beranda'],
                ['name' => 'Profil', 'url' => '#'],
                ['name' => 'Strukutur Organisasi', 'active' => true]
            ],
            'struktur' => $struktur,
            'strukturList' => $this->strukturModel->where('id !=', $id)->findAll()
        ];

        return view('admin/profil/struktur_organisasi_form', $data);
    }

    public function update($id)
    {
        $struktur = $this->strukturModel->find($id);

        if (!$struktur) {
            return redirect()->to('/admin/profil/struktur-organisasi')->with('error', 'Data tidak ditemukan.');
        }

        if (!$this->validate([
            'nama' => 'required|min_length[3]',
            'jabatan' => 'required',
            'foto' => 'max_size[foto,2048]|is_image[foto]|mime_in[foto,image/png,image/jpg,image/jpeg]',
            'urutan' => 'required'
        ])) {
            return redirect()->back()->withInput()->with('error', 'Harap isi form dengan benar!');
        }

        $file = $this->request->getFile('foto');

        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/struktur/', $newName);

            // Delete old image
            if (!empty($struktur['foto']) && file_exists(FCPATH . 'uploads/struktur/' . $struktur['foto'])) {
                unlink(FCPATH . 'uploads/struktur/' . $struktur['foto']);
            }
        } else {
            $newName = $struktur['foto']; // Keep old image
        }

        $parentId = $this->request->getPost('parent_id');
        $parentId = ($parentId === null || trim($parentId) === '') ? null : $parentId;

        $data = [
            'nama' => $this->request->getPost('nama'),
            'jabatan' => $this->request->getPost('jabatan'),
            'foto' => $newName,
            'parent_id' => $parentId,
            'urutan' => $this->request->getPost('urutan')
        ];

        $this->strukturModel->update($id, $data);

        return redirect()->to(base_url('admin/profil/struktur-organisasi'))->with('success', 'Data struktur berhasil diperbarui.');
    }

    public function delete($id)
    {
        $struktur = $this->strukturModel->find($id);

        if (!$struktur) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak ditemukan.']);
        }

        // Delete image file
        $filePath = FCPATH . 'uploads/struktur/' . $struktur['foto'];
        if (file_exists($filePath) && is_file($filePath)) {
            unlink($filePath);
        }

        $this->strukturModel->delete($id);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Data berhasil dihapus.',
            'csrf_hash' => csrf_hash()
        ]);
    }

    public function chartData()
    {

        $struktur = $this->strukturModel->findAll();

        $dataMap = [];
        foreach ($struktur as $row) {
            $dataMap[$row['id']] = [
                'id' => $row['id'],
                'nama' => $row['nama'],
                'jabatan' => $row['jabatan'],
                'foto' => $row['foto'] ?? null,
                'parent_id' => $row['parent_id'],
                'children' => []
            ];
        }

        foreach ($struktur as $row) {
            if ($row['parent_id'] && isset($dataMap[$row['parent_id']])) {
                $dataMap[$row['parent_id']]['children'][] = &$dataMap[$row['id']];
            }
        }

        // Get root nodes (no parent)
        $tree = [];
        foreach ($dataMap as $item) {
            if ($item['parent_id'] === null) {
                $tree[] = $item;
            }
        }

        // return $this->response->setJSON(count($tree) === 1 ? $tree[0] : $tree);
        return $this->response->setJSON($tree);
    }
}
