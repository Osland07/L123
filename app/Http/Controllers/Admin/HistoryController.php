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

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('client_name', 'like', "%{$q}%")
                    ->orWhere('result_level', 'like', "%{$q}%");
            });
        }

        if ($request->filled('filter_risk')) {
            $query->where('result_level', 'like', "%" . $request->filter_risk . "%");
        }

        $screenings = $query->paginate(10)->withQueryString();

        if ($this->isMobile()) {
            return view('admin.history.mobile_index', compact('screenings'));
        }

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

    public function printPdf($id, $action = 'view')
    {
        $screening = \App\Models\Screening::with('details.riskFactor')->findOrFail($id);
        $riskLevel = \App\Models\RiskLevel::where('name', $screening->result_level)->first(); 

        $pdf = Pdf::loadView('client.profile.pdf', compact('screening', 'riskLevel'));
        
        if ($action == 'download') {
            return $pdf->download('laporan-skrining-' . $screening->client_name . '-' . $id . '.pdf');
        }
        return $pdf->stream('laporan-skrining-' . $screening->client_name . '-' . $id . '.pdf');
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
        $screening = \App\Models\Screening::findOrFail($id);
        $screening->delete();

        return redirect()->route('admin.history.index')->with('success', 'Data riwayat berhasil dihapus.');
    }
}