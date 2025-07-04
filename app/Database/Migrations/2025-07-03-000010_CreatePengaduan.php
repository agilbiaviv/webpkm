<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePengaduan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'pengguna_id' => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'keluhan' => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('pengguna_id', 'pengguna', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pengaduan');
    }

    public function down()
    {
        $this->forge->dropTable('pengaduan');
    }
}
