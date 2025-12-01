<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Screening;
use App\Models\RiskLevel;
use App\Models\RiskFactor;
use App\Models\Rule;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 1. Hitung Total
        $totalScreenings = Screening::count();
        $totalUsers = User::where('role', 'client')->count(); // Hanya hitung pasien
        $totalRiskFactors = RiskFactor::count();
        $totalRiskLevels = RiskLevel::count();
        $totalRules = Rule::count();

        // 2. Hitung Distribusi Risiko
        $riskCounts = [
            'Rendah' => 0,
            'Sedang' => 0,
            'Tinggi' => 0,
        ];

        // Ambil semua result_level untuk dihitung
        $results = Screening::pluck('result_level');

        foreach ($results as $level) {
            if (stripos($level, 'rendah') !== false) {
                $riskCounts['Rendah']++;
            } elseif (stripos($level, 'sedang') !== false) {
                $riskCounts['Sedang']++;
            } elseif (stripos($level, 'tinggi') !== false) {
                $riskCounts['Tinggi']++;
            }
        }

        // 3. Hitung Persentase
        $riskPercentages = [
            'Rendah' => $totalScreenings > 0 ? round(($riskCounts['Rendah'] / $totalScreenings) * 100) : 0,
            'Sedang' => $totalScreenings > 0 ? round(($riskCounts['Sedang'] / $totalScreenings) * 100) : 0,
            'Tinggi' => $totalScreenings > 0 ? round(($riskCounts['Tinggi'] / $totalScreenings) * 100) : 0,
        ];

        $riskLevelColors = [
            'Rendah' => 'bg-green-500',
            'Sedang' => 'bg-yellow-500',
            'Tinggi' => 'bg-red-500',
        ];

        // 4. Aktivitas Terbaru (5 Terakhir)
        $latestScreenings = Screening::latest()->limit(5)->get();

        return view('admin.dashboard', compact(
            'totalScreenings',
            'totalUsers',
            'totalRiskFactors',
            'totalRiskLevels',
            'totalRules',
            'riskCounts',
            'riskPercentages',
            'riskLevelColors',
            'latestScreenings'
        ));
    }
}