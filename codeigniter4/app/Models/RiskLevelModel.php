<?php

namespace App\Models;

use CodeIgniter\Model;

class RiskLevelModel extends Model
{
    protected $table            = 'risk_levels';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['code', 'name', 'description', 'suggestion'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Fungsi generate kode otomatis (H01, H02...)
    public function generateCode()
    {
        $last = $this->orderBy('id', 'DESC')->first();

        if (!$last) {
            return 'H01';
        }

        $lastCode = $last['code'];
        $number   = (int) substr($lastCode, 1);
        $nextNumber = $number + 1;

        return 'H' . str_pad((string)$nextNumber, 2, '0', STR_PAD_LEFT);
    }
}
