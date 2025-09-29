<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table = 'menus';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name',
        'slug',
        'type',
        'page_id',
        'special_key',
        'url',
        'parent_id',
        'position',
        'status'
    ];
}
