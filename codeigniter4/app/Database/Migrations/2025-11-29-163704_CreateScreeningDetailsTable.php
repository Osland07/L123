<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateScreeningDetailsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'screening_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'risk_factor_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('screening_id', 'screenings', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('risk_factor_id', 'risk_factors', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('screening_details');
    }

    public function down()
    {
        $this->forge->dropTable('screening_details');
    }
}