<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropPhoneAddressFromUserProfiles extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('user_profiles', ['phone', 'address']);
    }

    public function down()
    {
        // Re-add the columns if migration is rolled back
        $this->forge->addColumn('user_profiles', [
            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'address' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);
    }
}