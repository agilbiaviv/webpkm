<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKategoriBerita extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'nama_kategori' => ['type' => 'VARCHAR', 'constraint' => 100],
            'slug' => ['type' => 'VARCHAR', 'constraint' => 100],
            'created_at' => ['type' => 'DATETIME', 'default' => 'CURRENT_TIMESTAMP'],
            'updated_at' => ['type' => 'DATETIME', 'default' => 'CURRENT_TIMESTAMP'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('nama_kategori');
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('kategori_berita');
    }

    public function down()
    {
        $this->forge->dropTable('kategori_berita');
    }
}
