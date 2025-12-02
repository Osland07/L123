<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Screening::latest();

        if ($request->has('q')) {
            $q = $request->q;
            $query->where('client_name', 'like', "%{$q}%")
                  ->orWhere('result_level', 'like', "%{$q}%");
        }

        $screenings = $query->paginate(10)->withQueryString();
        return view('admin.history.index', compact('screenings'));
    }

    public function print()
    {
        $screenings = \App\Models\Screening::with('details.riskFactor')->latest()->get();
        
        $pdf = Pdf::loadView('admin.history.print', compact('screenings'));
        return $pdf->stream('laporan-riwayat-skrining.pdf');
    }

    public function export()
    {
        $fileName = 'riwayat-skrining-' . date('Y-m-d_H-i') . '.csv';
        $screenings = \App\Models\Screening::with(['details.riskFactor', 'user.profile'])->latest()->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'No', 
            'Tanggal', 
            'Nama Client', 
            'Jenis Kelamin', 
            'Usia (Th)', 
            'Tinggi (cm)', 
            'Berat (kg)', 
            'BMI', 
            'Tensi (mmHg)', 
            'Faktor Risiko Terpilih', 
            'Hasil Risiko'
        ];

        $callback = function() use($screenings, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($screenings as $key => $s) {
                // Calculate BMI
                $bmi = '-';
                if ($s->snapshot_height && $s->snapshot_weight) {
                    $h = $s->snapshot_height / 100;
                    $bmi = round($s->snapshot_weight / ($h * $h), 1);
                }

                // Get Gender
                $gender = $s->user && $s->user->profile ? ($s->user->profile->gender == 'L' ? 'Laki-laki' : 'Perempuan') : '-';

                // Get Risk Factors
                $factors = $s->details->map(function($detail, $index) {
                    return ($index + 1) . '. ' . ($detail->riskFactor ? $detail->riskFactor->name : '-');
                })->implode("\n");

                $row = [
                    $key + 1,
                    $s->created_at->format('d/m/Y H:i'),
                    $s->client_name,
                    $gender,
                    $s->snapshot_age,
                    $s->snapshot_height,
                    $s->snapshot_weight,
                    $bmi,
                    $s->snapshot_systolic . '/' . $s->snapshot_diastolic,
                    $factors ?: 'Tidak ada faktor risiko signifikan',
                    $s->result_level
                ];

                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        $screening = \App\Models\Screening::with('details.riskFactor')->findOrFail($id);
        $riskLevel = \App\Models\RiskLevel::where('name', $screening->result_level)->first(); 
        $profile = \App\Models\UserProfile::where('user_id', $screening->user_id)->first();

        // Calculate BMI from Snapshot
        $bmi = 0;
        if ($screening->snapshot_height && $screening->snapshot_weight) {
            $h = $screening->snapshot_height / 100;
            $bmi = round($screening->snapshot_weight / ($h * $h), 1);
        }

        // Format Tensi
        $tensi = $screening->snapshot_systolic . '/' . $screening->snapshot_diastolic;

        return view('admin.history.show', compact('screening', 'riskLevel', 'profile', 'bmi', 'tensi'));
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}