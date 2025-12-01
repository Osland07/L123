<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rule;
use App\Models\RiskLevel;
use App\Models\RiskFactor;
use Illuminate\Http\Request;

class RuleController extends Controller
{
    public function index(Request $request)
    {
        $query = Rule::with(['riskLevel', 'requiredFactor'])
                    ->orderBy('priority', 'ASC');

        if ($request->has('q')) {
            $q = $request->q;
            $query->where('code', 'like', "%{$q}%");
        }

        $rules = $query->paginate(10)->withQueryString();
        return view('admin.rules.index', compact('rules'));
    }

    public function create()
    {
        $newCode = Rule::generateCode();
        $levels = RiskLevel::all();
        $factors = RiskFactor::all();
        return view('admin.rules.create', compact('newCode', 'levels', 'factors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'risk_level_id' => 'required|exists:risk_levels,id',
            'min_other_factors' => 'required|numeric|min:0',
            'priority' => 'required|numeric|min:1',
        ]);

        Rule::create([
            'code' => Rule::generateCode(),
            'risk_level_id' => $request->risk_level_id,
            'required_factor_id' => $request->required_factor_id,
            'min_other_factors' => $request->min_other_factors,
            'max_other_factors' => $request->max_other_factors ?: 99,
            'priority' => $request->priority,
        ]);

        return redirect()->route('admin.rules.index')->with('success', 'Aturan berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $rule = Rule::findOrFail($id);
        $levels = RiskLevel::all();
        $factors = RiskFactor::all();
        return view('admin.rules.edit', compact('rule', 'levels', 'factors'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'risk_level_id' => 'required|exists:risk_levels,id',
            'min_other_factors' => 'required|numeric|min:0',
            'priority' => 'required|numeric|min:1',
        ]);

        $rule = Rule::findOrFail($id);
        $rule->update([
            'risk_level_id' => $request->risk_level_id,
            'required_factor_id' => $request->required_factor_id,
            'min_other_factors' => $request->min_other_factors,
            'max_other_factors' => $request->max_other_factors ?: 99,
            'priority' => $request->priority,
        ]);

        return redirect()->route('admin.rules.index')->with('success', 'Aturan berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $rule = Rule::findOrFail($id);
        $rule->delete();

        return redirect()->route('admin.rules.index')->with('success', 'Aturan berhasil dihapus.');
    }
}