<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGaleri extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'judul' => ['type' => 'VARCHAR', 'constraint' => 255],
            'deskripsi' => ['type' => 'TEXT', 'null' => true],
            'gambar_path' => ['type' => 'VARCHAR', 'constraint' => 255],
            'dibuat_pada' => ['type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP'],
            'diperbarui_pada' => ['type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('galeri');
    }

    public function down()
    {
        $this->forge->dropTable('galeri');
    }
}
