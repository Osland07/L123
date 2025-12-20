<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\RiskFactor;
use App\Models\Screening;
use App\Models\ScreeningDetail;
use App\Models\RiskLevel;
use App\Models\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class RealHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = base_path('riwayat-skrining-2025-12-19_21-41.xlsx');

        if (!file_exists($file)) {
            $this->command->error("File Excel tidak ditemukan: $file");
            return;
        }

        $this->command->info("Mengimpor & Menghitung Ulang Data Skrining...");

        // Load Rules untuk Engine Diagnosa
        // Menggunakan "with('riskFactors')" sesuai update terbaru kita
        $rules = Rule::with('riskFactors')->orderBy('priority', 'ASC')->get();
        
        // Load Default Risk Level (H01 - Tidak Berisiko)
        $defaultRisk = RiskLevel::where('code', 'H01')->first();

        try {
            $spreadsheet = IOFactory::load($file);
            $data = $spreadsheet->getActiveSheet()->toArray();
            $headers = array_shift($data); // Skip header

            $riskFactorMap = RiskFactor::all()->pluck('id', 'name')->toArray();

            // Referensi ID Faktor Penting untuk Logika Otomatis
            $e01 = RiskFactor::where('code', 'E01')->first(); // Tensi
            $e08 = RiskFactor::where('code', 'E08')->first(); // Obesitas (BMI)

            foreach ($data as $row) {
                if (empty($row[2])) continue;

                $tanggalStr = $row[1];
                $nama = $row[2];
                $gender = $row[3] == 'Laki-laki' ? 'L' : 'P';
                $usia = (int) $row[4];
                $tinggi = (float) $row[5];
                $berat = (float) $row[6];
                $tensi = $row[8]; // "120/80"
                $faktorTerpilihText = $row[9];

                // Parse Tensi
                $systolic = 0; $diastolic = 0;
                if (str_contains($tensi, '/')) {
                    list($systolic, $diastolic) = explode('/', $tensi);
                }

                // 1. Setup User & Profile
                $email = Str::slug($nama, '_') . '@tensitrack.com';
                $user = User::firstOrCreate(
                    ['email' => $email],
                    [
                        'name' => $nama,
                        'password' => Hash::make('password'),
                    ]
                );

                UserProfile::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'full_name' => $nama, 'gender' => $gender, 'age' => $usia,
                        'height' => $tinggi, 'weight' => $berat,
                        'systolic' => (int) $systolic, 'diastolic' => (int) $diastolic,
                    ]
                );

                // 2. Kumpulkan ID Faktor Risiko (Inputan User + Otomatis Sistem)
                $selectedFactorIds = [];

                // a. Dari Text Excel (Jawaban Manual)
                $faktorList = explode("\n", $faktorTerpilihText);
                foreach ($faktorList as $fRaw) {
                    $fName = trim(preg_replace('/^\d+\.\s*/', '', $fRaw));
                    if (empty($fName)) continue;

                    foreach ($riskFactorMap as $nameInDb => $id) {
                        $cleanDbName = str_replace(['–', '-'], '-', $nameInDb);
                        $cleanFName = str_replace(['–', '-'], '-', $fName);
                        if (stripos($cleanDbName, $cleanFName) !== false || stripos($cleanFName, $cleanDbName) !== false) {
                            $selectedFactorIds[] = $id;
                            break;
                        }
                    }
                }

                // b. Logika Otomatis Sistem (Sesuai Controller)
                // Cek Tensi (E01)
                if ($e01 && (($systolic >= 121) || ($diastolic >= 81))) {
                    $selectedFactorIds[] = $e01->id;
                }
                // Cek BMI (E08)
                if ($e08 && $tinggi > 0 && $berat > 0) {
                    $h_m = $tinggi / 100;
                    $bmi = $berat / ($h_m * $h_m);
                    if ($bmi >= 25) {
                        $selectedFactorIds[] = $e08->id;
                    }
                }

                // Hapus duplikat
                $finalFactors = array_unique($selectedFactorIds);

                // 3. JALANKAN ENGINE DIAGNOSA (Hitung Ulang Risiko)
                $diagnosedLevelName = 'Tidak diketahui';
                
                // (Logika ini copas dari runDiagnosis di Controller yang baru)
                $foundRule = false;
                foreach ($rules as $rule) {
                    // Cek Required Factors (Pivot)
                    $requiredIds = $rule->riskFactors->pluck('id')->toArray();
                    
                    // Apakah punya semua required factors?
                    $missing = array_diff($requiredIds, $finalFactors);
                    if (!empty($missing)) continue;

                    // Hitung Sisa Faktor
                    $others = array_diff($finalFactors, $requiredIds);
                    
                    // Exclude Tensi E01 manual logic agar konsisten dengan controller
                    if (empty($requiredIds) && $e01) { 
                        $others = array_diff($others, [$e01->id]); 
                    }

                    $count = count($others);

                    if ($count >= $rule->min_other_factors && $count <= $rule->max_other_factors) {
                        $diagnosedLevelName = $rule->riskLevel->name;
                        $foundRule = true;
                        break; 
                    }
                }

                if (!$foundRule && $defaultRisk) {
                    $diagnosedLevelName = $defaultRisk->name;
                }

                // 4. Simpan Hasil Diagnosa Baru
                $createdAt = null;
                try { $createdAt = Carbon::createFromFormat('d/m/Y H:i', $tanggalStr); } catch (
Exception $e) { $createdAt = now(); }

                // Cek existing agar tidak duplikat
                $existing = Screening::where('user_id', $user->id)->where('created_at', $createdAt)->first();
                
                if (!$existing) {
                    $screening = Screening::create([
                        'user_id' => $user->id,
                        'client_name' => $nama,
                        'snapshot_age' => $usia,
                        'snapshot_height' => $tinggi,
                        'snapshot_weight' => $berat,
                        'snapshot_systolic' => (int) $systolic,
                        'snapshot_diastolic' => (int) $diastolic,
                        'result_level' => $diagnosedLevelName, // Hasil Hitungan Sistem
                        'score' => count($finalFactors),
                        'created_at' => $createdAt,
                    ]);

                    foreach ($finalFactors as $fid) {
                        ScreeningDetail::create([
                            'screening_id' => $screening->id,
                            'risk_factor_id' => $fid,
                        ]);
                    }
                }
            }
            
            $this->command->info("Selesai! Data berhasil diimpor dan dihitung ulang oleh sistem.");

        } catch (
Exception $e) {
            $this->command->error("Error: " . $e->getMessage());
        }
    }
}
