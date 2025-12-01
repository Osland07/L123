<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RiskFactor;
use Illuminate\Http\Request;

class RiskFactorController extends Controller
{
    public function index(Request $request)
    {
        $query = RiskFactor::query();

        if ($request->has('q')) {
            $q = $request->q;
            $query->where('name', 'like', "%{$q}%")
                  ->orWhere('code', 'like', "%{$q}%");
        }

        $riskFactors = $query->paginate(10)->withQueryString();
        return view('admin.risk-factors.index', compact('riskFactors'));
    }

    public function create()
    {
        $newCode = RiskFactor::generateCode();
        return view('admin.risk-factors.create', compact('newCode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'question_text' => 'required|string',
        ]);

        RiskFactor::create([
            'code' => RiskFactor::generateCode(),
            'name' => $request->name,
            'question_text' => $request->question_text,
        ]);

        return redirect()->route('admin.risk-factors.index')->with('success', 'Faktor risiko berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $riskFactor = RiskFactor::findOrFail($id);
        return view('admin.risk-factors.edit', compact('riskFactor'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string',
            'question_text' => 'required|string',
        ]);

        $riskFactor = RiskFactor::findOrFail($id);
        $riskFactor->update($request->all());

        return redirect()->route('admin.risk-factors.index')->with('success', 'Faktor risiko berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $riskFactor = RiskFactor::findOrFail($id);
        $riskFactor->delete();

        return redirect()->route('admin.risk-factors.index')->with('success', 'Faktor risiko berhasil dihapus.');
    }
}