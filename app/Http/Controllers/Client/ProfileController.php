<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = $user->profile ?? new UserProfile();
        
        // Hitung BMI & Kategori
        $bmi = 0;
        $bmi_category = '-';
        if ($profile->height && $profile->weight) {
            $h = $profile->height / 100;
            $bmi = round($profile->weight / ($h * $h), 1);
            if ($bmi < 18.5) $bmi_category = 'Kurus';
            elseif ($bmi <= 25) $bmi_category = 'Normal';
            elseif ($bmi <= 27) $bmi_category = 'Gemuk';
            else $bmi_category = 'Obesitas';
        }

        // Ambil Riwayat
        $history = \App\Models\Screening::where('user_id', $user->id)->latest()->get();
        
        // Ambil Latest Result
        $latest_result = $history->first()->result_level ?? '-';
        
        // Kategori Tensi (Logika Sederhana)
        $tensi_category = '-';
        if ($profile->systolic && $profile->diastolic) {
            $s = $profile->systolic;
            $d = $profile->diastolic;
            if ($s < 120 && $d < 80) $tensi_category = 'Normal';
            elseif ($s <= 139 || $d <= 89) $tensi_category = 'Normal Tinggi';
            else $tensi_category = 'Hipertensi';
        }

        return view('client.profile.index', compact(
            'user', 'profile', 'bmi', 'bmi_category', 
            'history', 'latest_result', 'tensi_category'
        ));
    }

    public function update(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'age' => 'required|integer|min:1|max:120',
            'gender' => 'required|in:L,P',
            'height' => 'required|numeric|min:50|max:250',
            'weight' => 'required|numeric|min:20|max:300',
            'systolic' => 'nullable|integer|min:50|max:250',
            'diastolic' => 'nullable|integer|min:30|max:150',
        ]);

        $user = Auth::user();

        // Update atau Create profil
        $profile = UserProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'full_name' => $request->full_name,
                'age' => $request->age,
                'gender' => $request->gender,
                'height' => $request->height,
                'weight' => $request->weight,
                'systolic' => $request->systolic,
                'diastolic' => $request->diastolic,
            ]
        );

        // Update nama di tabel users juga agar sinkron
        if ($user->name !== $request->full_name) {
            $user->update(['name' => $request->full_name]);
        }

        return redirect()->route('client.profile.index')->with('success', 'Profil berhasil diperbarui.');
    }

    public function detail($id)
    {
        $screening = \App\Models\Screening::with('details.riskFactor')->where('user_id', Auth::id())->findOrFail($id);
        $riskLevel = \App\Models\RiskLevel::where('name', $screening->result_level)->first(); 

        return view('client.profile.detail', compact('screening', 'riskLevel'));
    }

    public function printPdf($id)
    {
        $screening = \App\Models\Screening::with('details.riskFactor')->where('user_id', Auth::id())->findOrFail($id);
        $riskLevel = \App\Models\RiskLevel::where('name', $screening->result_level)->first(); 

        $pdf = Pdf::loadView('client.profile.pdf', compact('screening', 'riskLevel'));
        return $pdf->stream('hasil-skrining-' . $id . '.pdf');
    }
}
