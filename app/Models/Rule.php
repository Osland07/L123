<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    protected $fillable = [
        'code', 
        'risk_level_id', 
        'required_factor_id', 
        'min_other_factors', 
        'max_other_factors', 
        'priority'
    ];

    public function riskLevel()
    {
        return $this->belongsTo(RiskLevel::class);
    }

    public function requiredFactor()
    {
        return $this->belongsTo(RiskFactor::class, 'required_factor_id');
    }

    public static function generateCode()
    {
        $last = self::orderBy('id', 'DESC')->first();
        if (!$last) return 'R01';
        $num = (int) substr($last->code, 1);
        return 'R' . str_pad((string)($num + 1), 2, '0', STR_PAD_LEFT);
    }
}