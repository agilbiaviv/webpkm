<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table = 'menu';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'url', 'icon', 'parent_id', 'urutan', 'is_active'];

    public function getMenus()
    {
        return $this->where('is_active', 1)->orderBy('parent_id', 'ASC')->orderBy('urutan', 'ASC')->findAll();
    }

    public function getMenuByUrl($url)
    {
        return $this->where('url', $url)->first();
    }
}
