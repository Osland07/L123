<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\RiskFactor;
use App\Models\RiskLevel;
use App\Models\Rule;
use App\Models\Screening;
use App\Models\ScreeningDetail;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScreeningController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $profile = UserProfile::where('user_id', $userId)->first();

        // Daftar kode yang akan di-exclude (dihilangkan dari kuis)
        // E03 (BMI) selalu auto karena TB/BB wajib di profil (jika ada)
        $excludedCodes = ['E03']; 

        // Cek Tensi di Profil
        // Jika data tensi lengkap, hitung otomatis (exclude E01 dari kuis)
        // Jika tidak lengkap, tanyakan E01 di kuis
        if ($profile && $profile->systolic && $profile->diastolic) {
            $excludedCodes[] = 'E01';
        }

        // Ambil faktor risiko selain yang di-exclude
        $factors = RiskFactor::whereNotIn('code', $excludedCodes)->get();

        // Cek Kelengkapan Profil (Nama, Umur, Gender Wajib)
        $isProfileComplete = $profile && $profile->full_name && $profile->age && $profile->gender;

        return view('client.screening.index', compact('factors', 'isProfileComplete'));
    }

    public function result(Request $request)
    {
        try {
            $userId = Auth::id();
            $profile = UserProfile::where('user_id', $userId)->first();
            
            $answers = $request->input('answers', []); // Array ID faktor yang dijawab YA
            
            // Casting ke integer
            $answers = array_map('intval', $answers);

            $autoFactors = [];

            // 1. Cek Faktor Otomatis (E01 & E03)
            if ($profile) {
                // Cek E01 (Tensi): Hanya otomatis jika data profil ada.
                if ($profile->systolic && $profile->diastolic) {
                    $sys = $profile->systolic;
                    $dia = $profile->diastolic;
                    // Logika Baru: Mulai dari Hipertensi Derajat 1 (>= 140/90)
                    if (($sys >= 140) || ($dia >= 90)) {
                        $e01 = RiskFactor::where('code', 'E01')->first();
                        if ($e01) $autoFactors[] = (int)$e01->id;
                    }
                }

                // Cek E03 (BMI): Selalu otomatis dari profil
                if ($profile->height && $profile->weight) {
                    $h = $profile->height / 100;
                    $bmi = $profile->weight / ($h * $h);
                    if ($bmi >= 25) {
                        $e03 = RiskFactor::where('code', 'E03')->first();
                        if ($e03) $autoFactors[] = (int)$e03->id;
                    }
                }
            }

            // Gabungkan jawaban manual user dan otomatis
            $finalFactors = array_unique(array_merge($answers, $autoFactors));
            
            // 2. Jalankan Engine Diagnosa
            $e01Ref = RiskFactor::where('code', 'E01')->first();
            $e01RefId = $e01Ref ? (int)$e01Ref->id : null;
            
            $diagnosis = $this->runDiagnosis($finalFactors, $e01RefId);

            // 3. Simpan Hasil
            $screening = Screening::create([
                'user_id'            => $userId,
                'client_name'        => $profile ? $profile->full_name : Auth::user()->name,
                'snapshot_age'       => $profile->age ?? 0,
                'snapshot_height'    => $profile->height ?? 0,
                'snapshot_weight'    => $profile->weight ?? 0,
                'snapshot_systolic'  => $profile->systolic ?? 0,
                'snapshot_diastolic' => $profile->diastolic ?? 0,
                'result_level'       => $diagnosis->name,
                'score'              => count($finalFactors),
            ]);

            // 4. Simpan Detail Jawaban
            foreach ($finalFactors as $factorId) {
                ScreeningDetail::create([
                    'screening_id'   => $screening->id,
                    'risk_factor_id' => $factorId
                ]);
            }
            
            return redirect()->route('client.profile.detail', $screening->id);

        } catch (\Exception $e) {
             return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function runDiagnosis($selectedFactorIds, $tensiFactorId = null)
    {
        // Ambil semua aturan, urutkan berdasarkan prioritas (1 duluan)
        $rules = Rule::orderBy('priority', 'ASC')->get();

        foreach ($rules as $rule) {
            // 1. Cek Required Factor
            if ($rule->required_factor_id) {
                if (!in_array((int)$rule->required_factor_id, $selectedFactorIds)) {
                    continue; // Syarat wajib tidak terpenuhi
                }
            }

            // 2. Hitung Faktor Lain (Count Others)
            $otherFactors = $selectedFactorIds;
            if ($rule->required_factor_id) {
                $otherFactors = array_diff($selectedFactorIds, [(int)$rule->required_factor_id]);
            } else {
                // Jika tidak ada required factor, kecualikan E01 (Tensi) dari hitungan jika ada
                if ($tensiFactorId) {
                    $otherFactors = array_diff($selectedFactorIds, [$tensiFactorId]);
                }
            }
            
            $count = count($otherFactors);

            // 3. Cek Range Jumlah
            if ($count >= $rule->min_other_factors && $count <= $rule->max_other_factors) {
                return RiskLevel::find($rule->risk_level_id);
            }
        }

        // Default: Rendah
        $default = RiskLevel::where('code', 'H01')->first();
        // Create a dummy object if default not found to avoid error, though H01 should exist
        return $default ? $default : (object)['name' => 'Risiko Tidak Diketahui']; 
    }
}
