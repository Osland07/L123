<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropBirthDateFromUserProfiles extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('user_profiles', 'birth_date');
    }

    public function down()
    {
        // Re-add the column if migration is rolled back
        $this->forge->addColumn('user_profiles', [
            'birth_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
        ]);
    }
}