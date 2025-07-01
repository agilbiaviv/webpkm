<?php

namespace App\Models\Profil;

use CodeIgniter\Model;

class SambutanModel extends Model
{
    protected $table = 'sambutan';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'nama_kepala',
        'foto_kepala',
        'judul_sambutan',
        'isi_sambutan',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField = ''; // we don't have created_at, only updated_at
    protected $updatedField = 'updated_at';

    // Optional: Auto-validation rules (we can add later if needed)
}
