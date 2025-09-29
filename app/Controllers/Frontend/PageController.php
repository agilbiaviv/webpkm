<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\PageModel;

class PageController extends BaseController
{
    protected $pageModel;

    public function __construct()
    {
        $this->pageModel = new PageModel();
    }

    public function view($parent = null, $slug = null)
    {
        if ($slug === null) {
            // Jika child slug tidak ada, artinya ini halaman parent langsung
            $slug = $parent;
            $parent = null;
        }

        $page = $this->pageModel
            ->where('slug', $slug)
            ->first();

        if (!$page) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound($slug);
        }

        return view('frontend/page', [
            'page' => $page,
        ]);
    }
}
