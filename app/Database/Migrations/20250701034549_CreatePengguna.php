<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePengguna extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'username' => ['type' => 'VARCHAR', 'constraint' => 50],
            'password' => ['type' => 'VARCHAR', 'constraint' => 255],
            'email' => ['type' => 'VARCHAR', 'constraint' => 100],
            'created_at' => ['type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP']
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pengguna');
    }

    public function down()
    {
        $this->forge->dropTable('pengguna');
    }
}
