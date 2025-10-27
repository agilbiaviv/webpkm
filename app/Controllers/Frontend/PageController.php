<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\MenuModel;
use App\Models\PageModel;

class PageController extends BaseController
{
    protected $pageModel;
    protected $menuModel;

    public function __construct()
    {
        $this->pageModel = new PageModel();
        $this->menuModel = new MenuModel();
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

        $menu = $this->menuModel
            ->where('slug', $slug)
            ->first();

        if (!$menu) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound($slug);
        }

        $data['breadcrumbs'] = getBreadcrumbs($menu['id'], $this->menuModel);

        return view('frontend/page', [
            'page'        => $page,
            'breadcrumbs' => $data['breadcrumbs'],
        ]);
    }
}
