<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\RiskFactorModel;
use App\Models\RiskLevelModel;
use App\Models\RuleModel;
use App\Models\ScreeningModel;
use App\Models\UserProfileModel;

use App\Models\ScreeningDetailModel; // Add Model

class ClientScreeningController extends BaseController
{
    protected $factorModel;
    protected $ruleModel;
    protected $screeningModel;
    protected $screeningDetailModel; // Add Property
    protected $profileModel;
    protected $riskLevelModel;

    public function __construct()
    {
        $this->factorModel = new RiskFactorModel();
        $this->ruleModel = new RuleModel();
        $this->screeningModel = new ScreeningModel();
        $this->screeningDetailModel = new ScreeningDetailModel(); // Init Model
        $this->profileModel = new UserProfileModel();
        $this->riskLevelModel = new RiskLevelModel();
    }

    public function index()
    {
        $userId = auth()->id();
        $profile = $this->profileModel->where('user_id', $userId)->first();

        // Daftar kode yang akan di-exclude (dihilangkan dari kuis)
        $excludedCodes = ['E03']; // E03 (BMI) selalu auto karena TB/BB wajib di profil

        // Cek Tensi di Profil
        // Jika data tensi lengkap, hitung otomatis (exclude E01 dari kuis)
        // Jika tidak lengkap, tanyakan E01 di kuis
        if ($profile && $profile['systolic'] && $profile['diastolic']) {
            $excludedCodes[] = 'E01';
        }

        // Ambil faktor risiko selain yang di-exclude
        $factors = $this->factorModel->whereNotIn('code', $excludedCodes)->findAll();

        $data = [
            'title'   => 'Mulai Skrining',
            'factors' => $factors,
        ];

        return view('Client/screening/index', $data);
    }

    public function result()
    {
        try {
            $userId = auth()->id();
            $profile = $this->profileModel->where('user_id', $userId)->first(); // Fetch profile
            
            $answers = $this->request->getPost('answers'); // Array ID faktor yang dijawab YA
            
            if (!$answers) $answers = [];
            // Casting ke integer
            $answers = array_map('intval', $answers);

            $autoFactors = []; // Initialize autoFactors

            // 1. Cek Faktor Otomatis (E01 & E03)
            if ($profile) {
                // Cek E01 (Tensi): Hanya otomatis jika data profil ada.
                if ($profile['systolic'] && $profile['diastolic']) {
                    $sys = $profile['systolic'];
                    $dia = $profile['diastolic'];
                    // Logika Baru: Mulai dari Hipertensi Derajat 1 (>= 140/90)
                    if (($sys >= 140) || ($dia >= 90)) {
                        $e01 = $this->factorModel->where('code', 'E01')->first();
                        if ($e01) $autoFactors[] = (int)$e01['id'];
                    }
                }

                // Cek E03 (BMI): Selalu otomatis dari profil
                if ($profile['height'] && $profile['weight']) {
                    $h = $profile['height'] / 100;
                    $bmi = $profile['weight'] / ($h * $h);
                    if ($bmi >= 25) {
                        $e03 = $this->factorModel->where('code', 'E03')->first();
                        if ($e03) $autoFactors[] = (int)$e03['id'];
                    }
                }
            }

            // Gabungkan jawaban manual user dan otomatis
            $finalFactors = array_unique(array_merge($answers, $autoFactors));
            
            // 2. Jalankan Engine Diagnosa
            $e01Ref = $this->factorModel->where('code', 'E01')->first();
            $e01RefId = $e01Ref ? (int)$e01Ref['id'] : null;
            
            $diagnosis = $this->runDiagnosis($finalFactors, $e01RefId);

            // 3. Simpan Hasil
            $screeningId = $this->screeningModel->insert([
                'user_id'            => $userId,
                'client_name'        => ($profile && isset($profile['full_name'])) ? $profile['full_name'] : auth()->user()->username,
                'snapshot_age'       => $profile['age'] ?? 0,
                'snapshot_height'    => $profile['height'] ?? 0,
                'snapshot_weight'    => $profile['weight'] ?? 0,
                'snapshot_systolic'  => $profile['systolic'] ?? 0,
                'snapshot_diastolic' => $profile['diastolic'] ?? 0,
                'result_level'       => $diagnosis['name'],
                'score'              => count($finalFactors),
                'created_at'         => date('Y-m-d H:i:s')
            ]);

            // 4. Simpan Detail Jawaban
            foreach ($finalFactors as $factorId) {
                $this->screeningDetailModel->save([
                    'screening_id'   => $screeningId,
                    'risk_factor_id' => $factorId
                ]);
            }
            
            return redirect()->to('/detail/' . $screeningId);

        } catch (\Exception $e) {
            // Catch generic Exception to catch everything including DB errors
             return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function runDiagnosis($selectedFactorIds, $tensiFactorId = null)
    {
        // Ambil semua aturan, urutkan berdasarkan prioritas (1 duluan)
        $rules = $this->ruleModel->orderBy('priority', 'ASC')->findAll();

        foreach ($rules as $rule) {
            // 1. Cek Required Factor
            if ($rule['required_factor_id']) {
                if (!in_array((int)$rule['required_factor_id'], $selectedFactorIds)) {
                    continue; // Syarat wajib tidak terpenuhi
                }
            }

            // 2. Hitung Faktor Lain (Count Others)
            $otherFactors = $selectedFactorIds;
            if ($rule['required_factor_id']) {
                $otherFactors = array_diff($selectedFactorIds, [(int)$rule['required_factor_id']]);
            } else {
                // Jika tidak ada required factor, kecualikan E01 (Tensi) dari hitungan jika ada
                if ($tensiFactorId) {
                    $otherFactors = array_diff($selectedFactorIds, [$tensiFactorId]);
                }
            }
            
            $count = count($otherFactors);

            // 3. Cek Range Jumlah
            if ($count >= $rule['min_other_factors'] && $count <= $rule['max_other_factors']) {
                return $this->riskLevelModel->find($rule['risk_level_id']);
            }
        }

        // Default: Rendah
        $default = $this->riskLevelModel->where('code', 'H01')->first();
        return $default ? $default : ['name' => 'Risiko Tidak Diketahui']; // Safety fallback
    }
}