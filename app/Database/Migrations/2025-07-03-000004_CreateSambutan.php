<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSambutan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'nama_kepala' => ['type' => 'VARCHAR', 'constraint' => 255],
            'foto_kepala' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'isi_sambutan' => ['type' => 'TEXT'],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('sambutan');
    }

    public function down()
    {
        $this->forge->dropTable('sambutan');
    }
}
