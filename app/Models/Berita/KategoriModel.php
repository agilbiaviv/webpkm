<?php

namespace App\Models\Berita;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table = 'kategori_berita';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_kategori', 'slug', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
