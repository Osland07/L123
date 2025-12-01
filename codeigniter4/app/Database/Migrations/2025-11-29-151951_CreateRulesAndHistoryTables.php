<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRulesAndHistoryTables extends Migration
{
    public function up()
    {
        // 1. Tabel Aturan (Rules)
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
            'risk_factor_id' => [ // Relasi ke Faktor Risiko
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'risk_level_id' => [ // Relasi ke Tingkat Risiko
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('risk_factor_id', 'risk_factors', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('risk_level_id', 'risk_levels', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('rules');

        // 2. Tabel Riwayat Skrining (History)
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id' => [ // ID User yang melakukan (bisa null jika guest)
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'client_name' => [ // Nama pengisi (jika guest/manual)
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'result_level' => [ // Hasil Tingkat Risiko (Disimpan string biar aman kalau master dihapus)
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'score' => [ // Nilai/Skor (Opsional)
                'type'       => 'INT',
                'default'    => 0
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('screenings');
    }

    public function down()
    {
        $this->forge->dropTable('rules');
        $this->forge->dropTable('screenings');
    }
}