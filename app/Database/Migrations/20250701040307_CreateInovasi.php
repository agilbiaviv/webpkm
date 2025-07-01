<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInovasi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'judul' => ['type' => 'VARCHAR', 'constraint' => 255],
            'deskripsi' => ['type' => 'TEXT', 'null' => true],
            'dibuat_pada' => ['type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('inovasi');
    }

    public function down()
    {
        $this->forge->dropTable('inovasi');
    }
}
