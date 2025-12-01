<?php

namespace App\Models;

use CodeIgniter\Model;

class ScreeningModel extends Model
{
    protected $table            = 'screenings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['user_id', 'client_name', 'snapshot_age', 'snapshot_height', 'snapshot_weight', 'snapshot_systolic', 'snapshot_diastolic', 'result_level', 'score', 'created_at'];
    protected $useTimestamps    = false; // Matikan timestamp otomatis untuk hindari error SQL
}
