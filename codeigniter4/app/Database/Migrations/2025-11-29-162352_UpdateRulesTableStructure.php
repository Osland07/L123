<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateRulesTableStructure extends Migration
{
    public function up()
    {
        // Drop tabel lama (hati-hati, data lama hilang)
        $this->forge->dropTable('rules', true);

        // Buat tabel baru
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'code' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'unique'     => true,
            ],
            'risk_level_id' => [ // Output Diagnosa (H01, H02...)
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'required_factor_id' => [ // Faktor Wajib (E01), Boleh NULL jika tidak ada spesifik
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'min_other_factors' => [ // Jumlah minimal faktor lain yg harus ada
                'type'       => 'INT',
                'constraint' => 3,
                'default'    => 0,
            ],
            'max_other_factors' => [ // Jumlah maksimal faktor lain (optional, default 99)
                'type'       => 'INT',
                'constraint' => 3,
                'default'    => 99,
            ],
            'priority' => [ // Urutan eksekusi (1, 2, 3...)
                'type'       => 'INT',
                'constraint' => 3,
                'default'    => 10,
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('risk_level_id', 'risk_levels', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('required_factor_id', 'risk_factors', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('rules');
    }

    public function down()
    {
        $this->forge->dropTable('rules');
    }
}