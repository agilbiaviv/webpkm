<?php

namespace App\Models;

use CodeIgniter\Model;

class InovasiModel extends Model
{
    protected $table = 'inovasi';
    protected $primaryKey = 'id';
    protected $allowedFields = ['judul', 'deskripsi'];
}
