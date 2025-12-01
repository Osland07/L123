<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ScreeningModel;
use App\Models\RiskLevelModel;
use App\Models\RiskFactorModel;
use App\Models\RuleModel;
use CodeIgniter\Shield\Models\UserModel;

class AdminDashboardController extends BaseController
{
    protected $screeningModel;
    protected $riskLevelModel;
    protected $riskFactorModel;
    protected $ruleModel;
    protected $userModel;

    public function __construct()
    {
        $this->screeningModel = new ScreeningModel();
        $this->riskLevelModel = new RiskLevelModel();
        $this->riskFactorModel = new RiskFactorModel();
        $this->ruleModel = new RuleModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Ambil semua hasil skrining
        $allScreenings = $this->screeningModel->findAll();
        $totalScreenings = count($allScreenings);
        
        // Ambil total user (Total Pasien)
        $totalUsers = $this->userModel->countAll();

        // Ambil total master data
        $totalRiskFactors = $this->riskFactorModel->countAll();
        $totalRiskLevels = $this->riskLevelModel->countAll();
        $totalRules = $this->ruleModel->countAll();

        // Inisialisasi hitungan
        $riskCounts = [
            'Rendah' => 0,
            'Sedang' => 0,
            'Tinggi' => 0,
        ];
        
        $riskLevelColors = [
            'Rendah' => 'bg-green-500', // Contoh warna hijau
            'Sedang' => 'bg-yellow-500', // Contoh warna kuning
            'Tinggi' => 'bg-red-500',   // Contoh warna merah
        ];

        // Hitung berdasarkan result_level
        foreach ($allScreenings as $screening) {
            if (strpos($screening['result_level'], 'rendah') !== false) {
                $riskCounts['Rendah']++;
            } elseif (strpos($screening['result_level'], 'sedang') !== false) {
                $riskCounts['Sedang']++;
            } elseif (strpos($screening['result_level'], 'tinggi') !== false) {
                $riskCounts['Tinggi']++;
            }
        }

        // Hitung persentase
        $riskPercentages = [
            'Rendah' => $totalScreenings > 0 ? round(($riskCounts['Rendah'] / $totalScreenings) * 100) : 0,
            'Sedang' => $totalScreenings > 0 ? round(($riskCounts['Sedang'] / $totalScreenings) * 100) : 0,
            'Tinggi' => $totalScreenings > 0 ? round(($riskCounts['Tinggi'] / $totalScreenings) * 100) : 0,
        ];

        // Ambil aktivitas terbaru (5 terakhir)
        $latestScreenings = $this->screeningModel->orderBy('created_at', 'DESC')->findAll(5);

        $data = [
            'title'             => 'Dashboard Admin',
            'total_screenings'  => $totalScreenings,
            'total_users'       => $totalUsers,
            'total_risk_factors'=> $totalRiskFactors,
            'total_risk_levels' => $totalRiskLevels,
            'total_rules'       => $totalRules,
            'risk_counts'       => $riskCounts,
            'risk_percentages'  => $riskPercentages,
            'risk_level_colors' => $riskLevelColors,
            'latest_screenings' => $latestScreenings,
        ];

        return view('Admin/dashboard', $data);
    }
}