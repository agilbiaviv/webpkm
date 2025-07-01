<?php

namespace App\Controllers;

use App\Models\MenuModel;

class MenuController extends BaseController
{
    protected $menuModel;

    public function __construct()
    {
        $this->menuModel = new MenuModel();
    }

    public function getMenu()
    {
        $menus = $this->menuModel->getMenus();

        // Organize into hierarchical structure
        $menuTree = [];
        foreach ($menus as $menu) {
            if ($menu['parent_id'] == NULL) {
                $menu['submenu'] = [];
                $menuTree[$menu['id']] = $menu;
            } else {
                $menuTree[$menu['parent_id']]['submenu'][] = $menu;
            }
        }

        return $menuTree;
    }

    public function getBreadcrumb($currentUrl)
    {
        $menu = $this->menuModel->getMenuByUrl($currentUrl);

        if (!$menu) {
            return [['name' => 'Beranda']];
        }

        $breadcrumbs = [['name' => 'Beranda', 'url' => '/admin/beranda']];

        if ($menu['parent_id']) {
            // Get parent menu
            $parent = $this->menuModel->find($menu['parent_id']);
            if ($parent) {
                $breadcrumbs[] = ['name' => $parent['title'], 'url' => $parent['url'], 'active' => true];
            }
        }

        $breadcrumbs[] = ['name' => $menu['title'], 'active' => true];

        return $breadcrumbs;
    }
}
