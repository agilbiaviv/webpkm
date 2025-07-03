<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStrukturOrganisasi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'nama' => ['type' => 'VARCHAR', 'constraint' => 100],
            'jabatan' => ['type' => 'VARCHAR', 'constraint' => 100],
            'foto' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'urutan' => ['type' => 'INT', 'default' => 0],
            'parent_id' => ['type' => 'INT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('struktur_organisasi');
    }

    public function down()
    {
        $this->forge->dropTable('struktur_organisasi');
    }
}
