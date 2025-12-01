<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddQuestionTextToRiskFactors extends Migration
{
    public function up()
    {
        $this->forge->addColumn('risk_factors', [
            'question_text' => [
                'type'       => 'TEXT',
                'null'       => true,
                'after'      => 'name',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('risk_factors', 'question_text');
    }
}