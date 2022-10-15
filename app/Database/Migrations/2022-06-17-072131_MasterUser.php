<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MasterUser extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_user'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'username'       => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'fullname'       => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'email'       => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'password'       => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'token'       => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'level_id'       => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'image'       => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'nip_lama_user'       => [
                'type'       => 'VARCHAR',
                'constraint' => 9,
            ],
            'is_active'       => [
                'type'       => 'VARCHAR',
                'constraint' => 1,
            ],

        ]);
        $this->forge->addKey('id_user', true);
        $this->forge->createTable('tbl_user');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_user');
    }
}
