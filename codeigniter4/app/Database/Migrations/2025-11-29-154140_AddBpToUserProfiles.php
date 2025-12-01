<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBpToUserProfiles extends Migration
{
    public function up()
    {
        $this->forge->addColumn('user_profiles', [
            'systolic' => [
                'type'       => 'INT',
                'constraint' => 3,
                'null'       => true,
                'after'      => 'weight'
            ],
            'diastolic' => [
                'type'       => 'INT',
                'constraint' => 3,
                'null'       => true,
                'after'      => 'systolic'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('user_profiles', ['systolic', 'diastolic']);
    }
}