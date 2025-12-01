@extends('layouts.admin')

@section('title', 'Edit Aturan')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
        <form action="{{ route('admin.rules.update', $rule->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <!-- Kode -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Kode</label>
                    <input type="text" value="{{ $rule->code }}" readonly class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 text-gray-500 shadow-sm p-2">
                </div>

                <!-- Risk Level -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tingkat Risiko (Hasil)</label>
                    <select name="risk_level_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#001B48] focus:ring-[#001B48] p-2">
                        @foreach($levels as $level)
                            <option value="{{ $level->id }}" {{ $rule->risk_level_id == $level->id ? 'selected' : '' }}>{{ $level->name }} ({{ $level->code }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Required Factor -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Faktor Utama Wajib (Opsional)</label>
                    <select name="required_factor_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#001B48] focus:ring-[#001B48] p-2">
                        <option value="">-- Tidak Ada --</option>
                        @foreach($factors as $factor)
                            <option value="{{ $factor->id }}" {{ $rule->required_factor_id == $factor->id ? 'selected' : '' }}>{{ $factor->code }} - {{ Str::limit($factor->name, 50) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Min Other Factors -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Min. Faktor Lain</label>
                        <input type="number" name="min_other_factors" value="{{ $rule->min_other_factors }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#001B48] focus:ring-[#001B48] p-2">
                    </div>
                    <!-- Max Other Factors -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Max. Faktor Lain</label>
                        <input type="number" name="max_other_factors" value="{{ $rule->max_other_factors }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#001B48] focus:ring-[#001B48] p-2">
                    </div>
                </div>

                <!-- Priority -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Prioritas</label>
                    <input type="number" name="priority" value="{{ $rule->priority }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#001B48] focus:ring-[#001B48] p-2">
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-3 pt-4">
                    <a href="{{ route('admin.rules.index') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">Batal</a>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#001B48] hover:bg-blue-900">Perbarui Data</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection