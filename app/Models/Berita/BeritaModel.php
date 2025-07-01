<?php

namespace App\Models\Berita;

use CodeIgniter\Model;

class BeritaModel extends Model
{
    protected $table = 'berita';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'judul_berita',
        'slug',
        'deskripsi',
        'tanggal_berita',
        'foto',
        'caption_foto',
        'status',
        'author_id',
        'kategori_id',
        'tags',
        'view_count',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true;

    public function getBerita($id = null, $status = null)
    {
        if ($id) {
            return $this->where('id', $id)->first();
        }
        if ($status !== null) {
            return $this->where('status', $status)->findAll();
        }
        return $this->findAll();
    }

    public function increaseViewCount($id)
    {
        $this->where('id', $id)->set('view_count', 'view_count + 1', false)->update();
    }

    public function getRekomendasiBerita($kategori_id, $current_id, $limit = 4)
    {
        return $this->where('kategori_id', $kategori_id)
            ->where('id !=', $current_id)
            ->where('status', 1)
            ->orderBy('view_count', 'DESC')
            ->limit($limit)
            ->find();
    }
}
