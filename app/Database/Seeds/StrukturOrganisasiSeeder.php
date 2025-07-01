<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class StrukturOrganisasiSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id'        => 1,
                'nama'      => 'Dr. Agus Santoso',
                'jabatan'   => 'Kepala Puskesmas',
                'foto'      => 'kepala.jpg',
                'urutan'    => 1,
                'parent_id' => null
            ],
            [
                'id'        => 2,
                'nama'      => 'Siti Aminah, SKM',
                'jabatan'   => 'Wakil Kepala',
                'foto'      => 'wakil.jpg',
                'urutan'    => 2,
                'parent_id' => 1
            ],
            [
                'id'        => 3,
                'nama'      => 'Rina Kurniawati, A.Md.Kep',
                'jabatan'   => 'Kepala Unit Keperawatan',
                'foto'      => 'rina.jpg',
                'urutan'    => 3,
                'parent_id' => 2
            ],
            [
                'id'        => 4,
                'nama'      => 'Budi Setiawan, S.Kom',
                'jabatan'   => 'IT & Data Manager',
                'foto'      => 'budi.jpg',
                'urutan'    => 4,
                'parent_id' => 2
            ],
            [
                'id'        => 5,
                'nama'      => 'Dewi Larasati',
                'jabatan'   => 'Staf Administrasi',
                'foto'      => 'dewi.jpg',
                'urutan'    => 5,
                'parent_id' => 4
            ]
        ];

        // Simple batch insert
        $this->db->table('struktur_organisasi')->insertBatch($data);
    }
}
