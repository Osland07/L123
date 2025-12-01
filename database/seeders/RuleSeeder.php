<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rule;
use App\Models\RiskFactor;
use App\Models\RiskLevel;

class RuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil ID yang diperlukan
        $e01 = RiskFactor::where('code', 'E01')->first();
        $h01 = RiskLevel::where('code', 'H01')->first(); // Rendah
        $h02 = RiskLevel::where('code', 'H02')->first(); // Sedang
        $h03 = RiskLevel::where('code', 'H03')->first(); // Tinggi

        if ($e01 && $h01 && $h02 && $h03) {
            // Bersihkan rule lama agar tidak duplikat jika di-seed ulang
            Rule::truncate();

            $rules = [
                [
                    'code' => 'R2',
                    'risk_level_id' => $h03->id, // Tinggi
                    'required_factor_id' => null,
                    'min_other_factors' => 5,
                    'max_other_factors' => 99,
                    'priority' => 1,
                ],
                [
                    'code' => 'R1',
                    'risk_level_id' => $h03->id, // Tinggi
                    'required_factor_id' => $e01->id, // Wajib E01
                    'min_other_factors' => 3,
                    'max_other_factors' => 99,
                    'priority' => 2,
                ],
                [
                    'code' => 'R4',
                    'risk_level_id' => $h02->id, // Sedang
                    'required_factor_id' => null,
                    'min_other_factors' => 3,
                    'max_other_factors' => 4,
                    'priority' => 3,
                ],
                [
                    'code' => 'R3',
                    'risk_level_id' => $h02->id, // Sedang
                    'required_factor_id' => $e01->id, // Wajib E01
                    'min_other_factors' => 0,
                    'max_other_factors' => 2,
                    'priority' => 4,
                ],
                [
                    'code' => 'R5',
                    'risk_level_id' => $h01->id, // Rendah
                    'required_factor_id' => null,
                    'min_other_factors' => 0,
                    'max_other_factors' => 2,
                    'priority' => 5,
                ],
            ];

            foreach ($rules as $rule) {
                Rule::create($rule);
            }
        }
    }
}
