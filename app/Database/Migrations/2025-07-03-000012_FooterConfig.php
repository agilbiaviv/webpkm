<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FooterConfig extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama_instansi'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'alamat'          => ['type' => 'TEXT', 'null' => true],
            'telepon'         => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'whatsapp'        => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'email'           => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'facebook'        => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'instagram'       => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'youtube'         => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'maps_embed_url'  => ['type' => 'TEXT', 'null' => true],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('footer_config');
    }

    public function down()
    {
        $this->forge->dropTable('footer_config');
    }
}
