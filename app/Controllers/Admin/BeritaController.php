<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Controllers\MenuController;
use App\Models\Berita\BeritaModel;
use App\Models\Berita\KategoriModel;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\I18n\Time;

class BeritaController  extends BaseController
{
    protected $menuController;
    protected $beritaModel;

    public function __construct()
    {
        $this->menuController = new MenuController();
        $this->beritaModel = new BeritaModel();
    }

    public function index()
    {
        $currentUrl = '/berita';
        $breadcrumbs = $this->menuController->getBreadcrumb($currentUrl);
        return $this->loadAdminView('admin/berita/berita', [
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function fetchData()
    {
        try {
            if (!$this->request->isAJAX()) {
                return $this->response->setStatusCode(403, 'Forbidden');
            }

            $request = service('request');
            $beritaModel = new \App\Models\Berita\BeritaModel();

            $draw = (int) $request->getPost('draw');
            $start = (int) $request->getPost('start');
            $length = (int) $request->getPost('length');
            $search = $request->getPost('search')['value'];

            $query = $beritaModel->db->table('berita')
                ->select('berita.id, berita.judul_berita, pengguna.username AS author_name, kategori_berita.nama_kategori, berita.status, berita.tags, berita.view_count, berita.foto')
                ->join('pengguna', 'pengguna.id = berita.author_id', 'left')
                ->join('kategori_berita', 'kategori_berita.id = berita.kategori_id', 'left');

            if (!empty($search)) {
                $query->groupStart()
                    ->like('berita.judul_berita', $search)
                    ->orLike('pengguna.username', $search) // Cari berdasarkan username
                    ->orLike('kategori_berita.nama_kategori', $search) // Cari berdasarkan kategori
                    ->orLike('berita.tags', $search)
                    ->groupEnd();
            }

            // Get total records before filtering
            $totalRecords = $beritaModel->countAll();

            // Get filtered records count
            $totalFiltered = $query->countAllResults(false); // Ensure it doesn't reset query

            // Get paginated data
            $beritaData = $query->limit($length, $start)->get()->getResultArray();

            return $this->response->setJSON([
                "draw" => intval($draw),
                "recordsTotal" => $totalRecords,
                "recordsFiltered" => $totalFiltered,
                "data" => $beritaData,
                "csrf_hash" => csrf_hash() // ✅ CSRF Token Sent Separately
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Fetch Data Error: ' . $e->getMessage());
            return $this->response->setStatusCode(500, 'Internal Server Error')->setJSON([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function create()
    {
        $kategoriModel = new KategoriModel();
        $data['kategori'] = $kategoriModel->findAll(); // Ambil semua kategori

        $currentUrl = '/berita';
        $breadcrumbs = $this->menuController->getBreadcrumb($currentUrl);

        return $this->loadAdminView('admin/berita/berita_form', [
            'breadcrumbs' => $breadcrumbs,
            'kategori' => $data['kategori']
        ]);
    }

    public function save()
    {

        // Validate input
        if (!$this->validate([
            'kategori_id'  => 'required',
            'judul_berita' => 'required|min_length[3]',
            'tanggal_berita' => 'required|valid_date',
            'foto'         => 'uploaded[foto]|max_size[foto,2048]|is_image[foto]|mime_in[foto,image/png,image/jpg,image/jpeg]',
            'caption_foto' => 'required',
            'deskripsi'    => 'required',
            // 'tags'          => 'required' //for later
        ])) {
            return redirect()->back()->withInput()->with('error', 'Harap isi form dengan benar!');
        }

        // Handle image upload
        $file = $this->request->getFile('foto');
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/berita/', $newName);
        } else {
            return redirect()->back()->with('error', 'Gagal mengunggah foto.');
        }

        // Prepare data for database insertion
        $data = [
            'kategori_id'  => $this->request->getPost('kategori_id'),
            'judul_berita' => $this->request->getPost('judul_berita'),
            'slug'         => url_title($this->request->getPost('judul_berita'), '-', true),
            'tanggal_berita' => $this->request->getPost('tanggal_berita'),
            'foto'         => $newName,
            'caption_foto' => $this->request->getPost('caption_foto'),
            'deskripsi'    => $this->request->getPost('deskripsi'),
            'author_id'    => session()->get('user_id'),
            'status'       => 'draft', // Default status,
            'view_count' => 0,
            // 'tags' => $this->request->getPost('tags') //for later
        ];

        // Insert into the database
        $this->beritaModel->insert($data);

        return redirect()->to(base_url('admin/berita'))->with('success', 'Berita berhasil ditambahkan.');
    }

    public function show($slug)
    {
        $news = $this->beritaModel->where('slug', $slug)->first();

        if (!$news) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Berita tidak ditemukan');
        }

        // Update view count
        $this->beritaModel->update($news['id'], ['view_count' => $news['view_count'] + 1]);

        // Get recommended news (same category, exclude current news)
        $recommended = $this->beritaModel
            ->where('kategori_id', $news['kategori_id'])
            ->where('id !=', $news['id'])
            ->orderBy('created_at', 'DESC')
            ->limit(4)
            ->find();

        return view('frontend/berita_detail', [
            'berita' => $news,
            'recommended' => $recommended
        ]);
    }


    public function updateStatus()
    {
        $beritaModel = new \App\Models\Berita\BeritaModel();

        $id = $this->request->getPost('berita_id');
        $status = $this->request->getPost('status');

        if ($beritaModel->update($id, ['status' => $status])) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Status berhasil diubah!',
                'csrf_hash' => csrf_hash() // ✅ Send updated CSRF Token
            ]);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to update'], 400);
        }
    }

    public function edit($id)
    {
        $kategoriModel = new KategoriModel();
        $berita = $this->beritaModel->find($id);

        if (!$berita) {
            return redirect()->to('/admin/berita')->with('error', 'Berita tidak ditemukan.');
        }

        $currentUrl = '/berita';
        $breadcrumbs = $this->menuController->getBreadcrumb($currentUrl);

        return $this->loadAdminView('admin/berita/berita_form', [
            'breadcrumbs' => $breadcrumbs,
            'kategori' => $kategoriModel->findAll(),
            'berita' => $berita
        ]);
    }

    public function update($id)
    {
        $berita = $this->beritaModel->find($id);

        if (!$berita) {
            return redirect()->to('/admin/berita')->with('error', 'Berita tidak ditemukan.');
        }

        if (!$this->validate([
            'kategori_id'  => 'required',
            'judul_berita' => 'required|min_length[3]',
            'tanggal_berita' => 'required|valid_date',
            'foto'         => 'max_size[foto,2048]|is_image[foto]|mime_in[foto,image/png,image/jpg,image/jpeg]',
            'caption_foto' => 'required',
            'deskripsi'    => 'required',
        ])) {
            return redirect()->back()->withInput()->with('error', 'Harap isi form dengan benar!');
        }

        // Handle Image Upload
        $file = $this->request->getFile('foto');
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/berita/', $newName);

            // Delete old image
            if (!empty($berita['foto']) && file_exists(FCPATH . 'uploads/berita/' . $berita['foto'])) {
                unlink(FCPATH . 'uploads/berita/' . $berita['foto']);
            }
        } else {
            $newName = $berita['foto']; // Keep old image if no new upload
        }

        // Update Data
        $data = [
            'kategori_id'  => $this->request->getPost('kategori_id'),
            'judul_berita' => $this->request->getPost('judul_berita'),
            'slug'         => url_title($this->request->getPost('judul_berita'), '-', true),
            'tanggal_berita' => $this->request->getPost('tanggal_berita'),
            'foto'         => $newName,
            'caption_foto' => $this->request->getPost('caption_foto'),
            'deskripsi'    => $this->request->getPost('deskripsi'),
        ];

        $this->beritaModel->update($id, $data);

        return redirect()->to(base_url('admin/berita'))->with('success', 'Berita berhasil diperbarui.');
    }

    public function delete($id)
    {
        $beritaModel = new BeritaModel();
        $berita = $beritaModel->find($id);

        if (!$berita) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data not found.']);
        }

        // Delete associated image (if exists)
        $filePath = FCPATH . 'uploads/berita/' . $berita['foto'];
        if (file_exists($filePath) && is_file($filePath)) {
            unlink($filePath);
        }

        // Delete from database
        $beritaModel->delete($id);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Berita deleted successfully.',
            'csrf_hash' => csrf_hash()
        ]);
    }
}
