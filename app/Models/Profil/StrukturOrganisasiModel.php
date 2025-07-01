<?php

namespace App\Models\Profil;

use CodeIgniter\Model;

class StrukturOrganisasiModel extends Model
{
    protected $table = 'struktur_organisasi';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama',
        'jabatan',
        'foto',
        'urutan',
        'parent_id',
    ];
    protected $useTimestamps = true;
}
