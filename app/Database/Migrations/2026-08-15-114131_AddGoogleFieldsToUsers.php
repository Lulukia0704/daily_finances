<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddGoogleFieldsToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'google_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 191,
                'null'       => true,
                'unique'     => true,
                'after'      => 'email',
            ],
            'foto' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'google_id',
            ],
        ]);

        $this->forge->modifyColumn('users', [
            'password' => [
                'name'       => 'password',
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['google_id', 'foto']);

        $this->forge->modifyColumn('users', [
            'password' => [
                'name'       => 'password',
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
        ]);
    }
}