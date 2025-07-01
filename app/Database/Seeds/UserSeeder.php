<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel;

class UserSeeder extends Seeder
{
    public function run()
    {
        $userModel = new UserModel();

        $userModel->insert([
            'username' => 'admin',
            'email' => 'puskesmasujicoba@gmail.com',
            'password' => password_hash('pkm_ujicoba', PASSWORD_DEFAULT)
        ]);
    }
}
