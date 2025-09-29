<?php

if (!function_exists('getMenuUrl')) {
    function getMenuUrl(array $menu): string
    {
        // Jika menu memiliki children, dianggap parent → return #
        if (!empty($menu['children'])) {
            return '#';
        }

        switch ($menu['type']) {
            case 'page':
                $slug = !empty($menu['slug']) ? $menu['slug'] : '';
                $parent = !empty($menu['parent_name']) ? strtolower($menu['parent_name']) : '';
                if ($parent && $slug) {
                    return base_url(urlencode($parent) . '/' . urlencode($slug));
                } elseif ($slug) {
                    return base_url(urlencode($slug));
                } else {
                    return '#';
                }

            case 'special':
                $key = !empty($menu['special_key']) ? $menu['special_key'] : '';
                return $key !== '' ? base_url($key) : '#';

            case 'custom':
                $url = !empty($menu['url']) ? $menu['url'] : '';
                return $url !== '' ? $url : '#';

            default:
                return '#';
        }
    }
}
