<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVisiMisi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'visi' => ['type' => 'TEXT'],
            'misi' => ['type' => 'TEXT'],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('visi_misi');
    }

    public function down()
    {
        $this->forge->dropTable('visi_misi');
    }
}
