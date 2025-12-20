@extends('layouts.admin')

@section('title', 'Edit Aturan Diagnosa')

@section('content')
<div class="w-full animate-fade-up">
    <!-- Header Page -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-brand-blue">Edit Aturan Diagnosa</h2>
            <p class="text-sm text-gray-500">Sesuaikan logika sistem pakar untuk perhitungan risiko hipertensi.</p>
        </div>
        <a href="{{ route('admin.rules.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-brand-blue transition ease-in-out duration-150">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.rules.update', $rule->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            
            <!-- PANEL KIRI: KONFIGURASI DASAR -->
            <div class="xl:col-span-1 space-y-6">
                <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                        <h3 class="font-bold text-gray-800 flex items-center gap-2">
                            <i data-lucide="settings" class="w-5 h-5 text-brand-orange"></i>
                            Konfigurasi Dasar
                        </h3>
                    </div>
                    <div class="p-6 space-y-5">
                        <!-- Kode -->
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Kode Aturan</label>
                            <input type="text" value="{{ $rule->code }}" readonly class="w-full rounded-lg border-gray-300 bg-gray-100 text-gray-500 font-mono text-sm cursor-not-allowed">
                        </div>

                        <!-- Prioritas -->
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Prioritas (1 = Tertinggi)</label>
                            <input type="number" name="priority" value="{{ $rule->priority }}" class="w-full rounded-lg border-gray-300 focus:border-brand-blue focus:ring-brand-blue shadow-sm text-sm font-bold" min="1">
                        </div>

                        <!-- Risk Level -->
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Tingkat Risiko (Output)</label>
                            <select name="risk_level_id" class="w-full rounded-lg border-gray-300 focus:border-brand-blue focus:ring-brand-blue shadow-sm text-sm">
                                @foreach($levels as $level)
                                    <option value="{{ $level->id }}" {{ $rule->risk_level_id == $level->id ? 'selected' : '' }}>
                                        {{ $level->name }} ({{ $level->code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="bg-brand-blue text-white shadow-sm rounded-xl p-6 relative overflow-hidden">
                    <i data-lucide="info" class="absolute -right-4 -bottom-4 w-24 h-24 text-white/5"></i>
                    <h4 class="font-bold mb-2 flex items-center gap-2">
                        <i data-lucide="help-circle" class="w-4 h-4"></i>
                        Tips Prioritas
                    </h4>
                    <p class="text-xs text-blue-100 leading-relaxed">
                        Sistem akan memeriksa aturan mulai dari angka prioritas terkecil. Pastikan aturan yang paling spesifik memiliki angka prioritas lebih kecil.
                    </p>
                </div>
            </div>

            <!-- PANEL KANAN: LOGIKA DIAGNOSA -->
            <div class="xl:col-span-2 space-y-6">
                
                <!-- KONDISI FAKTOR UTAMA -->
                <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                        <h3 class="font-bold text-gray-800 flex items-center gap-2">
                            <i data-lucide="git-branch" class="w-5 h-5 text-brand-blue"></i>
                            Kondisi Faktor Utama (Wajib)
                        </h3>
                    </div>
                    <div class="p-6">
                        <!-- Tipe Logika -->
                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Metode Pengecekan</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" x-data="{ operator: '{{ $rule->operator }}' }">
                                <label class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none transition-all" :class="operator === 'AND' ? 'border-brand-blue ring-1 ring-brand-blue' : 'border-gray-200'">
                                    <input type="radio" name="operator" value="AND" class="sr-only" @click="operator = 'AND'" {{ $rule->operator == 'AND' ? 'checked' : '' }}>
                                    <span class="flex flex-1">
                                        <span class="flex flex-col">
                                            <span class="block text-sm font-bold text-gray-900">WAJIB SEMUA (AND)</span>
                                            <span class="mt-1 flex items-center text-xs text-gray-500">User harus memiliki semua faktor yang dipilih.</span>
                                        </span>
                                    </span>
                                    <i data-lucide="check-circle" class="h-5 w-5 text-brand-blue" x-show="operator === 'AND'"></i>
                                </label>
                                <label class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none transition-all" :class="operator === 'OR' ? 'border-brand-orange ring-1 ring-brand-orange' : 'border-gray-200'">
                                    <input type="radio" name="operator" value="OR" class="sr-only" @click="operator = 'OR'" {{ $rule->operator == 'OR' ? 'checked' : '' }}>
                                    <span class="flex flex-1">
                                        <span class="flex flex-col">
                                            <span class="block text-sm font-bold text-gray-900">SALAH SATU (OR)</span>
                                            <span class="mt-1 flex items-center text-xs text-gray-500">User cukup memiliki salah satu faktor.</span>
                                        </span>
                                    </span>
                                    <i data-lucide="check-circle" class="h-5 w-5 text-brand-orange" x-show="operator === 'OR'"></i>
                                </label>
                            </div>
                        </div>

                        <!-- Multi Select Chips -->
                        <div class="relative mt-4">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Daftar Faktor Risiko Wajib</label>
                            
                            <select id="hiddenSelect" name="risk_factor_ids[]" multiple class="hidden">
                                @foreach($factors as $factor)
                                    <option value="{{ $factor->id }}" {{ $rule->riskFactors->contains($factor->id) ? 'selected' : '' }}>
                                        {{ $factor->code }} - {{ $factor->name }}
                                    </option>
                                @endforeach
                            </select>

                            <div class="w-full min-h-[60px] p-3 rounded-xl border-2 border-dashed border-gray-300 focus-within:border-brand-blue bg-gray-50/50 flex flex-wrap gap-2 cursor-text transition-colors" onclick="document.getElementById('searchInput').focus()">
                                <div id="chipsContainer" class="flex flex-wrap gap-2"></div>
                                <input type="text" id="searchInput" placeholder="Cari & Tambah Faktor..." class="flex-grow min-w-[200px] text-sm border-none focus:ring-0 p-1 bg-transparent text-gray-700">
                            </div>

                            <div id="dropdownList" class="absolute z-50 w-full mt-2 bg-white border border-gray-200 rounded-xl shadow-2xl max-h-72 overflow-y-auto hidden">
                                @foreach($factors as $factor)
                                    <div class="dropdown-item px-5 py-4 hover:bg-brand-blue hover:text-white cursor-pointer group border-b border-gray-50 last:border-b-0 transition-colors" 
                                         data-id="{{ $factor->id }}" 
                                         data-text="{{ $factor->code }} - {{ $factor->name }}">
                                        <div class="flex items-center justify-between">
                                            <div class="flex flex-col">
                                                <span class="font-bold text-brand-blue group-hover:text-white">{{ $factor->code }}</span>
                                                <span class="text-xs text-gray-500 group-hover:text-blue-100">{{ $factor->name }}</span>
                                            </div>
                                            <i data-lucide="plus" class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SYARAT TAMBAHAN (SIMPLIFIED) -->
                <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                        <h3 class="font-bold text-gray-800 flex items-center gap-2">
                            <i data-lucide="hash" class="w-5 h-5 text-brand-orange"></i>
                            Jumlah Faktor Lainnya (E03 - E12)
                        </h3>
                    </div>
                    <div class="p-6">
                        <!-- Alert Info Simple -->
                        <div class="bg-blue-50 border border-blue-100 rounded-lg p-3 mb-5 flex items-start gap-3">
                            <i data-lucide="info" class="w-5 h-5 text-brand-blue mt-0.5 flex-shrink-0"></i>
                            <p class="text-sm text-blue-800 leading-snug">
                                <strong>Catatan:</strong> Input di bawah ini <u>TIDAK MENGHITUNG</u> faktor <strong>Tensi (E01)</strong> dan <strong>Keluarga (E02)</strong>. Hanya menghitung jumlah faktor risiko sisanya.
                            </p>
                        </div>

                        <!-- Grid Input Simple -->
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Minimal Jumlah</label>
                                <div class="relative">
                                    <input type="number" name="min_other_factors" value="{{ $rule->min_other_factors }}" 
                                           class="w-full pl-4 pr-12 py-2.5 rounded-lg border-gray-300 focus:border-brand-blue focus:ring-brand-blue shadow-sm font-bold text-gray-700 text-lg" 
                                           min="0">
                                    <span class="absolute right-4 top-3 text-xs text-gray-400 font-medium">Faktor</span>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Maksimal Jumlah</label>
                                <div class="relative">
                                    <input type="number" name="max_other_factors" value="{{ $rule->max_other_factors }}" 
                                           class="w-full pl-4 pr-12 py-2.5 rounded-lg border-gray-300 focus:border-brand-blue focus:ring-brand-blue shadow-sm font-bold text-gray-700 text-lg" 
                                           min="0">
                                    <span class="absolute right-4 top-3 text-xs text-gray-400 font-medium">Faktor</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FORM ACTIONS -->
                <div class="flex justify-end items-center gap-4 bg-gray-50 p-6 rounded-xl border border-gray-200">
                    <button type="submit" class="px-10 py-3 bg-brand-blue text-white rounded-lg font-bold hover:bg-blue-900 transition-all shadow-lg shadow-blue-900/20 flex items-center gap-2">
                        <i data-lucide="save" class="w-5 h-5"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') lucide.createIcons();

    // --- 2. Multi Select Logic --- 
    const hiddenSelect = document.getElementById('hiddenSelect');
    const chipsContainer = document.getElementById('chipsContainer');
    const searchInput = document.getElementById('searchInput');
    const dropdownList = document.getElementById('dropdownList');
    const dropdownItems = document.querySelectorAll('.dropdown-item');

    // Init Render
    refreshChips();

    // Show Dropdown
    searchInput.addEventListener('focus', () => {
        dropdownList.classList.remove('hidden');
        filterDropdown();
    });

    // Hide Dropdown Logic
    document.addEventListener('click', (e) => {
        const isClickInside = searchInput.contains(e.target) || dropdownList.contains(e.target) || chipsContainer.contains(e.target);
        if (!isClickInside) {
            dropdownList.classList.add('hidden');
        }
    });

    searchInput.addEventListener('input', filterDropdown);

    function filterDropdown() {
        const query = searchInput.value.toLowerCase();
        dropdownItems.forEach(item => {
            const text = item.dataset.text.toLowerCase();
            const id = item.dataset.id;
            const isSelected = Array.from(hiddenSelect.options).find(opt => opt.value == id && opt.selected);
            
            if (text.includes(query) && !isSelected) {
                item.classList.remove('hidden');
            } else {
                item.classList.add('hidden');
            }
        });
    }

    dropdownItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const id = this.dataset.id;
            const option = Array.from(hiddenSelect.options).find(opt => opt.value == id);
            
            if (option) {
                option.selected = true;
                refreshChips();
                searchInput.value = '';
                searchInput.focus();
                filterDropdown();
            }
        });
    });

    function refreshChips() {
        chipsContainer.innerHTML = '';
        const selectedOptions = Array.from(hiddenSelect.options).filter(opt => opt.selected);

        selectedOptions.forEach(opt => {
            const textParts = opt.text.split('-');
            const code = textParts[0].trim();
            const name = textParts[1] ? textParts[1].trim() : '';

            const chip = document.createElement('div');
            // Style Chip sesuai Brand
            chip.className = 'flex items-center bg-brand-blue text-white text-xs rounded px-2 py-1 gap-2 shadow-sm animate-fade-up';
            chip.innerHTML = `
                <span class="font-bold">${code}</span>
                <span class="opacity-80 truncate max-w-[150px] hidden sm:inline">${name}</span>
                <button type="button" class="hover:text-brand-orange focus:outline-none" data-id="${opt.value}">
                    &times;
                </button>
            `;
            
            chip.querySelector('button').addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                opt.selected = false;
                refreshChips();
                filterDropdown(); // Refresh list agar item muncul lagi di dropdown
            });

            chipsContainer.appendChild(chip);
        });
    }
});
</script>
@endsection