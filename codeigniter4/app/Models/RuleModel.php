<?php

namespace App\Models;

use CodeIgniter\Model;

class RuleModel extends Model
{
    protected $table            = 'rules';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['code', 'risk_level_id', 'required_factor_id', 'min_other_factors', 'max_other_factors', 'priority'];
    protected $useTimestamps    = true;

    // Ambil data lengkap dengan Join
    public function getRulesWithRelations()
    {
        return $this->select('rules.*, rf.name as factor_name, rl.name as level_name')
                    ->join('risk_levels as rl', 'rl.id = rules.risk_level_id')
                    ->join('risk_factors as rf', 'rf.id = rules.required_factor_id', 'left') // Left join krn required_factor bisa null
                    ->orderBy('rules.priority', 'ASC')
                    ->findAll();
    }

    public function generateCode()
    {
        $last = $this->orderBy('id', 'DESC')->first();
        if (!$last) return 'R01';
        $num = (int) substr($last['code'], 1);
        return 'R' . str_pad((string)($num + 1), 2, '0', STR_PAD_LEFT);
    }
}
