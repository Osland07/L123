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
        $screenings = \App\Models\Screening::latest()->get();
        
        $pdf = Pdf::loadView('admin.history.print', compact('screenings'));
        return $pdf->stream('laporan-riwayat-skrining.pdf');
    }

    public function export()
    {
        $fileName = 'riwayat-skrining-' . date('Y-m-d_H-i') . '.csv';
        $screenings = \App\Models\Screening::latest()->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['No', 'Tanggal', 'Nama Client', 'Usia (Th)', 'Tensi (mmHg)', 'Hasil Risiko', 'Skor'];

        $callback = function() use($screenings, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($screenings as $key => $s) {
                $row['No']  = $key + 1;
                $row['Tanggal']    = $s->created_at->format('d/m/Y H:i');
                $row['Nama Client']  = $s->client_name;
                $row['Usia']  = $s->snapshot_age;
                $row['Tensi']  = $s->snapshot_systolic . '/' . $s->snapshot_diastolic;
                $row['Hasil Risiko']  = $s->result_level;
                $row['Skor']  = $s->score;

                fputcsv($file, array_values($row));
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
        //
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