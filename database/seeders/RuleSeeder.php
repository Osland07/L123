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
        $e01 = RiskFactor::where('code', 'E01')->first(); // Tensi
        
        $h01 = RiskLevel::where('code', 'H01')->first(); // Tidak berisiko
        $h02 = RiskLevel::where('code', 'H02')->first(); // Risiko ringan
        $h03 = RiskLevel::where('code', 'H03')->first(); // Risiko sedang
        $h04 = RiskLevel::where('code', 'H04')->first(); // Risiko berat

        if ($h01 && $h02 && $h03 && $h04) {
            // Hapus data lama (karena ada constraint foreign key, ini akan otomatis bersih)
            // Tapi untuk amannya kita truncate rules, tabel pivot akan ikut terhapus karena cascade
            // Schema::disableForeignKeyConstraints(); Rule::truncate(); ...
            // Kita pakai create biasa saja, karena migrate:fresh nanti membersihkan semuanya.
            
            // --- 1. RISIKO BERAT (H04) ---
            // R1: 5+ faktor apapun
            $r1 = Rule::create([
                'code' => 'R1',
                'risk_level_id' => $h04->id,
                'min_other_factors' => 5,
                'max_other_factors' => 99,
                'priority' => 1,
            ]);
            // Tidak ada required factors

            // R2: Tensi Tinggi (E01) + 3 faktor lain
            $r2 = Rule::create([
                'code' => 'R2',
                'risk_level_id' => $h04->id,
                'min_other_factors' => 3,
                'max_other_factors' => 99,
                'priority' => 2,
            ]);
            if ($e01) $r2->riskFactors()->attach($e01->id);


            // --- 2. RISIKO SEDANG (H03) ---
            // R3: 3-4 faktor apapun
            $r3 = Rule::create([
                'code' => 'R3',
                'risk_level_id' => $h03->id,
                'min_other_factors' => 3,
                'max_other_factors' => 4,
                'priority' => 3,
            ]);

            // R4: Tensi Tinggi (E01) + 1-2 faktor lain
            $r4 = Rule::create([
                'code' => 'R4',
                'risk_level_id' => $h03->id,
                'min_other_factors' => 1,
                'max_other_factors' => 2,
                'priority' => 4,
            ]);
            if ($e01) $r4->riskFactors()->attach($e01->id);


            // --- 3. RISIKO RINGAN (H02) ---
            // R5: 1-2 faktor apapun
            $r5 = Rule::create([
                'code' => 'R5',
                'risk_level_id' => $h02->id,
                'min_other_factors' => 1,
                'max_other_factors' => 2,
                'priority' => 5,
            ]);

            // R6: Hanya Tensi Tinggi (E01) saja (0 faktor lain)
            $r6 = Rule::create([
                'code' => 'R6',
                'risk_level_id' => $h02->id,
                'min_other_factors' => 0,
                'max_other_factors' => 0,
                'priority' => 6,
            ]);
            if ($e01) $r6->riskFactors()->attach($e01->id);


            // --- 4. TIDAK BERISIKO (H01) ---
            // R7: 0 faktor
            $r7 = Rule::create([
                'code' => 'R7',
                'risk_level_id' => $h01->id,
                'min_other_factors' => 0,
                'max_other_factors' => 0,
                'priority' => 7,
            ]);
        }
    }
}
