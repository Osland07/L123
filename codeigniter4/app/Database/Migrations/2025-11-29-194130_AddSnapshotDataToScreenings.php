<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSnapshotDataToScreenings extends Migration
{
    public function up()
    {
        $this->forge->addColumn('screenings', [
            'snapshot_age' => [
                'type'       => 'INT',
                'constraint' => 3,
                'null'       => true,
                'after'      => 'client_name'
            ],
            'snapshot_height' => [
                'type'       => 'INT',
                'constraint' => 3,
                'null'       => true,
                'after'      => 'snapshot_age'
            ],
            'snapshot_weight' => [
                'type'       => 'INT',
                'constraint' => 3,
                'null'       => true,
                'after'      => 'snapshot_height'
            ],
            'snapshot_systolic' => [
                'type'       => 'INT',
                'constraint' => 3,
                'null'       => true,
                'after'      => 'snapshot_weight'
            ],
            'snapshot_diastolic' => [
                'type'       => 'INT',
                'constraint' => 3,
                'null'       => true,
                'after'      => 'snapshot_systolic'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('screenings', ['snapshot_age', 'snapshot_height', 'snapshot_weight', 'snapshot_systolic', 'snapshot_diastolic']);
    }
}