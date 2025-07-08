<?php

namespace App\Models;

use CodeIgniter\Model;

class FooterConfigModel extends Model
{
    protected $table            = 'footer_config';
    protected $primaryKey       = 'id';

    protected $allowedFields    = [
        'id',
        'nama_instansi',
        'alamat',
        'telepon',
        'whatsapp',
        'email',
        'facebook',
        'instagram',
        'tiktok',
        'youtube',
        'maps_embed_url',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
