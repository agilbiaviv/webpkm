<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PageModel;

class PageController extends BaseController
{
    protected $pageModel;

    public function __construct()
    {
        $this->pageModel = new PageModel();
    }

    // List semua page
    public function index()
    {
        $data = [
            'title' => 'Manajemen Halaman',
            'breadcrumbs' => [
                ['name' => 'Beranda', 'url' => 'admin/beranda'],
                ['name' => 'Manajemen Halaman', 'active' => true]
            ]
        ];
        $data['pages'] = $this->pageModel->findAll();
        return view('admin/pages/index', $data);
    }

    // Form tambah page
    public function create()
    {
        $data = [
            'title' => 'Manajemen Halaman',
            'breadcrumbs' => [
                ['name' => 'Beranda', 'url' => 'admin/beranda'],
                ['name' => 'Manajemen Halaman', 'active' => true]
            ]
        ];
        return view('admin/pages/form', $data);
    }

    public function fetchData()
    {
        try {
            if (!$this->request->isAJAX()) {
                return $this->response->setStatusCode(403, 'Forbidden');
            }

            $request = service('request');
            $pageModel = new \App\Models\PageModel();

            $draw   = (int) $request->getPost('draw');
            $start  = (int) $request->getPost('start');
            $length = (int) $request->getPost('length');
            $search = $request->getPost('search')['value'];

            $query = $pageModel->db->table('pages')
                ->select('*');

            if (!empty($search)) {
                $query->groupStart()
                    ->like('pages.title', $search)
                    ->orLike('pages.slug', $search)
                    ->orLike('pages.content', $search)
                    ->groupEnd();
            }

            // Total records tanpa filter
            $totalRecords = $pageModel->countAll();

            // Total records dengan filter
            $totalFiltered = $query->countAllResults(false);

            // Ambil data dengan pagination
            $pageData = $query->limit($length, $start)->get()->getResultArray();

            return $this->response->setJSON([
                "draw" => intval($draw),
                "recordsTotal" => $totalRecords,
                "recordsFiltered" => $totalFiltered,
                "data" => $pageData,
                "csrf_hash" => csrf_hash()
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Fetch Data Error (Pages): ' . $e->getMessage());
            return $this->response->setStatusCode(500, 'Internal Server Error')->setJSON([
                'error' => $e->getMessage()
            ]);
        }
    }

    // Simpan page baru
    public function store()
    {
        $slug = url_title($this->request->getPost('title'), '-', true);

        // Validate input
        if (!$this->validate([
            'title' => 'required|min_length[3]',
            'content'    => 'required',
            'image' => 'if_exist|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]'
            // 'tags'          => 'required' //for later
        ])) {
            return redirect()->back()->withInput()->with('error', 'Harap isi form dengan benar!');
        }

        $newName  = null;
        // Handle image upload
        $file = $this->request->getFile('image');
        if ($file && $file->getError() !== UPLOAD_ERR_NO_FILE) {
            if ($file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(FCPATH . 'uploads/pages/', $newName);
            } else {
                return redirect()->back()->with('error', 'Gagal mengunggah foto.');
            }
        }

        $this->pageModel->save([
            'title'   => $this->request->getPost('title'),
            'slug'    => $slug,
            'image'   => $newName,
            'content' => $this->request->getPost('content'),
            'status'  => $this->request->getPost('status') ?? 'published',
        ]);

        return redirect()->to('/admin/page-manager')->with('success', 'Halaman berhasil ditambahkan');
    }

    // Form edit page
    public function edit($id)
    {
        $data = [
            'title' => 'Manajemen Halaman',
            'breadcrumbs' => [
                ['name' => 'Beranda', 'url' => 'admin/beranda'],
                ['name' => 'Manajemen Halaman', 'active' => true]
            ]
        ];
        $data['page'] = $this->pageModel->find($id);
        return view('admin/pages/form', $data);
    }

    // Update page
    public function update($id)
    {
        $slug = url_title($this->request->getPost('title'), '-', true);
        // Validate input
        if (!$this->validate([
            'title' => 'required|min_length[3]',
            'content'    => 'required',
            'image' => 'if_exist|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]'
            // 'tags'          => 'required' //for later
        ])) {
            return redirect()->back()->withInput()->with('error', 'Harap isi form dengan benar!');
        }
        // Ambil data lama
        $page = $this->pageModel->find($id);
        if (!$page) {
            return redirect()->to('/admin/page-manager')->with('error', 'Halaman tidak ditemukan');
        }

        $newName = $page['image']; // default pakai gambar lama

        // Handle image upload (opsional)
        $file = $this->request->getFile('image');
        if ($file && $file->getError() !== UPLOAD_ERR_NO_FILE) {
            if ($file->isValid() && !$file->hasMoved()) {
                // hapus gambar lama kalau ada
                if (!empty($page['image']) && file_exists(FCPATH . 'uploads/pages/' . $page['image'])) {
                    unlink(FCPATH . 'uploads/pages/' . $page['image']);
                }

                $newName = $file->getRandomName();
                $file->move(FCPATH . 'uploads/pages/', $newName);
            } else {
                return redirect()->back()->with('error', 'Gagal mengunggah foto.');
            }
        }

        $this->pageModel->update($id, [
            'title'   => $this->request->getPost('title'),
            'slug'    => $slug,
            'content' => $this->request->getPost('content'),
            'status'  => $this->request->getPost('status') ?? 'published',
            'image'   => $newName, // tetap gambar lama kalau nggak ada upload baru
        ]);

        return redirect()->to('/admin/page-manager')->with('success', 'Halaman berhasil diperbarui');
    }


    // Hapus page
    // Hapus page
    public function delete($id)
    {
        $page = $this->pageModel->find($id);
        if (!$page) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'message' => 'Halaman tidak ditemukan',
                'csrf_hash' => csrf_hash()
            ]);
        }

        // Hapus file gambar kalau ada
        if (!empty($page['image'])) {
            $filePath = FCPATH . 'uploads/pages/' . $page['image'];
            if (is_file($filePath)) {
                @unlink($filePath);
            }
        }

        // Hapus data dari database
        $this->pageModel->delete($id);

        return $this->response->setStatusCode(200)->setJSON([
            'status' => 'success',
            'message' => 'Halaman berhasil dihapus!',
            'csrf_hash' => csrf_hash()
        ]);
    }
}
