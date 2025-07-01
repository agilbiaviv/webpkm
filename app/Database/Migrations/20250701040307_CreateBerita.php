<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBerita extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'judul_berita' => ['type' => 'VARCHAR', 'constraint' => 255],
            'slug' => ['type' => 'VARCHAR', 'constraint' => 255, 'unique' => true],
            'deskripsi' => ['type' => 'TEXT'],
            'tanggal_berita' => ['type' => 'DATE'],
            'foto' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'caption_foto' => ['type' => 'TEXT', 'null' => true],
            'status' => ['type' => 'TINYINT', 'default' => 1],
            'author_id' => ['type' => 'INT'],
            'kategori_id' => ['type' => 'INT'],
            'tags' => ['type' => 'TEXT', 'null' => true],
            'view_count' => ['type' => 'INT', 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'default' => 'CURRENT_TIMESTAMP'],
            'updated_at' => ['type' => 'DATETIME', 'default' => 'CURRENT_TIMESTAMP'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('kategori_id', 'kategori_berita', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('author_id', 'pengguna', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('berita');
    }

    public function down()
    {
        $this->forge->dropTable('berita');
    }
}
