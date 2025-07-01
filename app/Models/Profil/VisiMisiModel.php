<?php

namespace App\Models\Profil;

use CodeIgniter\Model;

class VisiMisiModel extends Model
{
    protected $table = 'visi_misi';
    protected $primaryKey = 'id';
    protected $allowedFields = ['visi', 'misi'];
}
