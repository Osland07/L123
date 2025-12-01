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