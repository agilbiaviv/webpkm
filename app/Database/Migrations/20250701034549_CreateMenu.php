<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMenu extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'title' => ['type' => 'VARCHAR', 'constraint' => 100],
            'url' => ['type' => 'VARCHAR', 'constraint' => 255],
            'icon' => ['type' => 'VARCHAR', 'constraint' => 255],
            'parent_id' => ['type' => 'INT', 'null' => true],
            'urutan' => ['type' => 'INT', 'default' => 0],
            'is_active' => ['type' => 'TINYINT', 'default' => 1]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('menu');
    }

    public function down()
    {
        $this->forge->dropTable('menu');
    }
}
