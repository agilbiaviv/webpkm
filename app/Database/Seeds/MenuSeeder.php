<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run()
    {
        $menuItems = [
            ['title' => 'Beranda', 'url' => '/beranda', 'icon' => 'home', 'parent_id' => null, 'urutan' => 1],
            ['title' => 'Profil', 'url' => '/profil', 'icon' => 'user', 'parent_id' => null, 'urutan' => 2],
            ['title' => 'Berita', 'url' => '/berita', 'icon' => 'user', 'parent_id' => null, 'urutan' => 3],
            ['title' => 'Sambutan Kepala Puskesmas', 'url' => '/profil/sambutan', 'icon' => '', 'parent_id' => 2, 'urutan' => 1],
            ['title' => 'Visi & Misi', 'url' => '/profil/visi-misi', 'icon' => '', 'parent_id' => 2, 'urutan' => 2],
            ['title' => 'Struktur Organisasi', 'url' => '/profil/struktur-organisasi', 'icon' => '', 'parent_id' => 2, 'urutan' => 3],
            ['title' => 'Inovasi', 'url' => '/inovasi', 'icon' => 'lightbulb', 'parent_id' => null, 'urutan' => 4],
            ['title' => 'Layanan Kesehatan', 'url' => '/layanan-kesehatan', 'icon' => 'hospital', 'parent_id' => null, 'urutan' => 5],
        ];

        $this->db->table('menu')->insertBatch($menuItems);
    }
}
