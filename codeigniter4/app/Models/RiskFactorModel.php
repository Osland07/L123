<?php

namespace App\Models;

use CodeIgniter\Model;

class RiskFactorModel extends Model
{
    protected $table            = 'risk_factors';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['code', 'name', 'question_text'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Fungsi generate kode otomatis (E01, E02...)
    public function generateCode()
    {
        $last = $this->orderBy('id', 'DESC')->first();

        if (!$last) {
            return 'E01';
        }

        $lastCode = $last['code'];
        $number   = (int) substr($lastCode, 1);
        $nextNumber = $number + 1;

        return 'E' . str_pad((string)$nextNumber, 2, '0', STR_PAD_LEFT);
    }
}
