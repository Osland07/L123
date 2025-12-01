<?php

namespace App\Models;

use CodeIgniter\Model;

class ScreeningDetailModel extends Model
{
    protected $table            = 'screening_details';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['screening_id', 'risk_factor_id'];
}
