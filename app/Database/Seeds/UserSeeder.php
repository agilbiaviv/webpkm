<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'username' => 'admin',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'email' => 'admin@puskesmas.local',
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->db->table('pengguna')->insert($data);
    }
}
