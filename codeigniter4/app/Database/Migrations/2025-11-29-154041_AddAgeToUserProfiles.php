<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAgeToUserProfiles extends Migration
{
    public function up()
    {
        $this->forge->addColumn('user_profiles', [
            'age' => [
                'type'       => 'INT',
                'constraint' => 3,
                'null'       => true,
                'after'      => 'full_name' // Menempatkan kolom setelah full_name
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('user_profiles', 'age');
    }
}