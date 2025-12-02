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
        $fileName = 'riwayat-skrining-' . date('Y-m-d_H-i') . '.xlsx';
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\ScreeningExport, $fileName);
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