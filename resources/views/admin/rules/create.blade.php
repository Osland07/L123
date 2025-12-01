@extends('layouts.admin')

@section('title', 'Tambah Aturan')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
        <form action="{{ route('admin.rules.store') }}" method="POST">
            @csrf
            <div class="space-y-6">
                <!-- Kode -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Kode</label>
                    <input type="text" value="{{ $newCode }}" readonly class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 text-gray-500 shadow-sm p-2">
                </div>

                <!-- Risk Level -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tingkat Risiko (Hasil)</label>
                    <select name="risk_level_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#001B48] focus:ring-[#001B48] p-2">
                        <option value="">-- Pilih Tingkat Risiko --</option>
                        @foreach($levels as $level)
                            <option value="{{ $level->id }}">{{ $level->name }} ({{ $level->code }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Required Factor -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Faktor Utama Wajib (Opsional)</label>
                    <select name="required_factor_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#001B48] focus:ring-[#001B48] p-2">
                        <option value="">-- Tidak Ada --</option>
                        @foreach($factors as $factor)
                            <option value="{{ $factor->id }}">{{ $factor->code }} - {{ Str::limit($factor->name, 50) }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Jika dipilih, faktor ini HARUS ada agar aturan ini berlaku.</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Min Other Factors -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Min. Faktor Lain</label>
                        <input type="number" name="min_other_factors" value="0" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#001B48] focus:ring-[#001B48] p-2">
                    </div>
                    <!-- Max Other Factors -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Max. Faktor Lain</label>
                        <input type="number" name="max_other_factors" value="99" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#001B48] focus:ring-[#001B48] p-2">
                    </div>
                </div>

                <!-- Priority -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Prioritas</label>
                    <input type="number" name="priority" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#001B48] focus:ring-[#001B48] p-2" placeholder="Contoh: 1">
                    <p class="text-xs text-gray-500 mt-1">Semakin kecil angka, semakin tinggi prioritas pengecekan.</p>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-3 pt-4">
                    <a href="{{ route('admin.rules.index') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">Batal</a>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#E3943B] hover:bg-orange-600">Simpan Data</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection