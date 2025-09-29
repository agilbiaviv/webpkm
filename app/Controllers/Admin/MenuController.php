<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MenuModel;
use App\Models\PageModel;

class MenuController extends BaseController
{
    protected $menuModel;

    public function __construct()
    {
        $this->menuModel = new MenuModel();
    }

    // List semua menu
    public function index()
    {
        $data = [
            'title' => 'Manajemen Menu',
            'breadcrumbs' => [
                ['name' => 'Beranda', 'url' => 'admin/beranda'],
                ['name' => 'Manajemen Menu', 'active' => true]
            ]
        ];
        return view('admin/menu/index', $data);
    }

    // Fetch data untuk DataTables
    public function fetchData()
    {
        try {
            if (!$this->request->isAJAX()) {
                return $this->response->setStatusCode(403, 'Forbidden');
            }

            $request = service('request');

            $draw   = (int) $request->getPost('draw');
            $start  = (int) $request->getPost('start');
            $length = (int) $request->getPost('length');
            $search = $request->getPost('search')['value'];

            $query = $this->menuModel->db->table('menus')
                ->select('menus.*, parent.name as parent_name')
                ->join('menus as parent', 'parent.id = menus.parent_id', 'left');

            if (!empty($search)) {
                $query->groupStart()
                    ->like('name', $search)
                    ->orLike('url', $search)
                    ->orLike('position', $search)
                    ->groupEnd();
            }

            $totalRecords = $this->menuModel->countAll();
            $totalFiltered = $query->countAllResults(false);

            $menuData = $query
                ->orderBy('position', 'ASC')
                ->limit($length, $start)
                ->get()
                ->getResultArray();

            return $this->response->setJSON([
                "draw" => intval($draw),
                "recordsTotal" => $totalRecords,
                "recordsFiltered" => $totalFiltered,
                "data" => $menuData,
                "csrf_hash" => csrf_hash()
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Fetch Data Error (Menus): ' . $e->getMessage());
            return $this->response->setStatusCode(500, 'Internal Server Error')->setJSON([
                'error' => $e->getMessage()
            ]);
        }
    }

    // Form tambah menu
    public function create()
    {
        $pagesModel = new PageModel();
        $data = [
            'title' => 'Tambah Menu',
            'breadcrumbs' => [
                ['name' => 'Beranda', 'url' => 'admin/beranda'],
                ['name' => 'Manajemen Menu', 'url' => 'admin/menu-manager'],
                ['name' => 'Tambah', 'active' => true]
            ],
            'menus' => $this->menuModel->where('url', '#')->findAll(), // untuk dropdown parent
            'pages' => $pagesModel->where('status', 'published')->findAll()
        ];
        return view('admin/menu/form', $data);
    }

    // Simpan menu baru
    public function store()
    {
        $slug = url_title($this->request->getPost('name'), '-', true);

        if (!$this->validate([
            'name'     => 'required|min_length[3]',
            'position' => 'required',
        ])) {
            return redirect()->back()->withInput()->with('error', 'Harap isi form dengan benar!');
        }

        $this->menuModel->save([
            'name'      => $this->request->getPost('name'),
            'slug'      => $slug,
            'type'      => $this->request->getPost('type'),
            'special_key' => $this->request->getPost('special_key') ?: null,
            'page_id'   => $this->request->getPost('page_id') ?: null,
            'url'       => $this->request->getPost('url'),
            'parent_id' => $this->request->getPost('parent_id') ?: null,
            'position'  => $this->request->getPost('position'),
            'status'    => $this->request->getPost('status') ?? 'active',
        ]);

        return redirect()->to('/admin/menu-manager')->with('success', 'Menu berhasil ditambahkan');
    }

    // Form edit menu
    public function edit($id)
    {
        $pagesModel = new PageModel();
        $menu = $this->menuModel->find($id);
        if (!$menu) {
            return redirect()->to('/admin/menu-manager')->with('error', 'Menu tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Menu',
            'breadcrumbs' => [
                ['name' => 'Beranda', 'url' => 'admin/beranda'],
                ['name' => 'Manajemen Menu', 'url' => 'admin/menu-manager'],
                ['name' => 'Edit', 'active' => true]
            ],
            'menu'  => $menu,
            'menus' => $this->menuModel->where('id !=', $id)->where('url', '#')->findAll(),
            'pages' => $pagesModel->where('status', 'published')->findAll()

        ];
        return view('admin/menu/form', $data);
    }

    // Update menu
    public function update($id)
    {
        $slug = url_title($this->request->getPost('name'), '-', true);

        if (!$this->validate([
            'name'     => 'required|min_length[3]',
            'position' => 'required',
        ])) {
            return redirect()->back()->withInput()->with('error', 'Harap isi form dengan benar!');
        }

        $menu = $this->menuModel->find($id);
        if (!$menu) {
            return redirect()->to('/admin/menu-manager')->with('error', 'Menu tidak ditemukan');
        }

        $this->menuModel->update($id, [
            'name'      => $this->request->getPost('name'),
            'slug'      => $slug,
            'type'      => $this->request->getPost('type'),
            'special_key' => $this->request->getPost('special_key') ?: null,
            'page_id'   => $this->request->getPost('page_id') ?: null,
            'url'       => $this->request->getPost('url'),
            'parent_id' => $this->request->getPost('parent_id') ?: null,
            'position'  => $this->request->getPost('position'),
            'status'    => $this->request->getPost('status') ?? 'active',
        ]);

        return redirect()->to('/admin/menu-manager')->with('success', 'Menu berhasil diperbarui');
    }

    // Hapus menu
    public function delete($id)
    {
        $menu = $this->menuModel->find($id);
        if (!$menu) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'message' => 'Menu tidak ditemukan',
                'csrf_hash' => csrf_hash()
            ]);
        }

        $this->menuModel->delete($id);

        return $this->response->setStatusCode(200)->setJSON([
            'status' => 'success',
            'message' => 'Menu berhasil dihapus!',
            'csrf_hash' => csrf_hash()
        ]);
    }
}
