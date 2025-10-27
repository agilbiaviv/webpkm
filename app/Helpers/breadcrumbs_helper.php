<?php
if (!function_exists('getBreadcrumbs')) {
    function getBreadcrumbs($menuId, $menuModel)
    {
        $breadcrumbs = [];

        // selalu tambahin Beranda
        // $breadcrumbs[] = [
        //     'label' => 'Beranda',
        //     'url' => base_url('/')
        // ];

        $menu = $menuModel->find($menuId);
        $parents = [];

        while ($menu) {
            $parents[] = [
                'label' => $menu['name'],
                'url' => getMenuUrl($menu),
            ];
            if (empty($menu['parent_id'])) {
                break;
            }
            $menu = $menuModel->find($menu['parent_id']);
        }

        // reverse biar urut dari parent → child
        $parents = array_reverse($parents);
        $breadcrumbs = array_merge($breadcrumbs, $parents);

        return $breadcrumbs;
    }
}
