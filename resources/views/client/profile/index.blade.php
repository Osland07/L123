@extends('layouts.app')

@section('title', 'Profil & Riwayat')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 border border-green-400 rounded-lg" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <!-- Header Mobile Only -->
    <div class="mb-6 lg:hidden">
        <h1 class="text-2xl font-bold text-[#001B48]">Halo, {{ auth()->user()->name }}</h1>
        <p class="text-gray-500 text-sm">Kelola profil dan pantau kesehatanmu.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- KOLOM KIRI: DATA DIRI (FORM) -->
        <div class="lg:col-span-5 bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-[#001B48] p-6 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold text-white">Data Diri</h2>
                    <p class="text-blue-200 text-xs">Pastikan data selalu valid.</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-white font-bold">
                    <i data-lucide="user" class="w-5 h-5"></i>
                </div>
            </div>

            <div class="p-6">
                <form action="{{ route('client.profile.update') }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        
                        <!-- Nama -->
                        <div class="border-b border-gray-200 pb-4 mb-4">
                            <label class="block text-base font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" name="full_name" value="{{ old('full_name', $profile->full_name ?? auth()->user()->name) }}" class="w-full rounded-lg border border-gray-400 focus:ring-[#E3943B] focus:border-[#E3943B] bg-white transition p-2 text-base" placeholder="Nama Anda" required>
                        </div>

                        <div class="grid grid-cols-2 gap-4 border-b border-gray-200 pb-4 mb-4">
                            <!-- Umur -->
                            <div>
                                <label class="block text-base font-medium text-gray-700 mb-1">Umur (Tahun)</label>
                                <input type="number" name="age" value="{{ old('age', $profile->age) }}" class="w-full rounded-lg border border-gray-400 focus:ring-[#E3943B] focus:border-[#E3943B] bg-white transition p-2 text-base" required>
                            </div>
                            <!-- Gender -->
                            <div>
                                <label class="block text-base font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                                <select name="gender" class="w-full rounded-lg border border-gray-400 focus:ring-[#E3943B] focus:border-[#E3943B] bg-white transition p-2 text-base">
                                    <option value="L" {{ old('gender', $profile->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('gender', $profile->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 border-b border-gray-200 pb-4 mb-4">
                            <!-- Tinggi -->
                            <div>
                                <label class="block text-base font-medium text-gray-700 mb-1">Tinggi (cm)</label>
                                <input type="number" name="height" value="{{ old('height', $profile->height) }}" class="w-full rounded-lg border border-gray-400 focus:ring-[#E3943B] focus:border-[#E3943B] bg-white transition p-2 text-base" required>
                            </div>
                            <!-- Berat -->
                            <div>
                                <label class="block text-base font-medium text-gray-700 mb-1">Berat (kg)</label>
                                <input type="number" name="weight" value="{{ old('weight', $profile->weight) }}" class="w-full rounded-lg border border-gray-400 focus:ring-[#E3943B] focus:border-[#E3943B] bg-white transition p-2 text-base" placeholder="0" required>
                            </div>
                        </div>

                        <!-- Tensi -->
                        <div class="pt-2 border-t border-dashed border-gray-200">
                            <label class="block text-base font-medium text-gray-700 mb-1">Tekanan Darah Terakhir (mmHg)</label>
                            <div class="flex items-center space-x-2">
                                <input type="number" name="systolic" placeholder="Sistolik" value="{{ old('systolic', $profile->systolic) }}" class="w-full rounded-lg border border-gray-400 focus:ring-[#E3943B] focus:border-[#E3943B] bg-white transition p-2 text-base">
                                <span class="text-xl font-bold text-gray-400">/</span>
                                <input type="number" name="diastolic" placeholder="Diastolik" value="{{ old('diastolic', $profile->diastolic) }}" class="w-full rounded-lg border border-gray-400 focus:ring-[#E3943B] focus:border-[#E3943B] bg-white transition p-2 text-base">
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Contoh: 120 / 80 (Opsional)</p>
                        </div>

                        <button type="submit" class="w-full py-3 bg-[#E3943B] text-white font-bold rounded-lg hover:bg-orange-600 transition shadow-md flex justify-center items-center mt-4">
                            <i data-lucide="save" class="w-4 h-4 mr-2"></i> Simpan Data Diri
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- KOLOM KANAN: STATISTIK & RIWAYAT -->
        <div class="lg:col-span-7 space-y-6">
            
            <!-- 1. Kartu Statistik (Grid 3 Kolom) -->
            <div class="grid grid-cols-3 gap-4">
                <!-- BMI -->
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 flex flex-col items-center justify-center text-center">
                    <span class="text-xs text-gray-500 font-semibold uppercase">Indeks Massa Tubuh</span>
                    <span class="text-2xl font-bold text-[#001B48] my-1">{{ $bmi }}</span>
                    <span class="text-xs px-2 py-0.5 rounded-full bg-gray-100 text-gray-600">BMI</span>
                </div>
                <!-- Kategori -->
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 flex flex-col items-center justify-center text-center">
                    <span class="text-xs text-gray-500 font-semibold uppercase">Kategori Berat</span>
                    <span class="text-lg font-bold text-[#001B48] my-1">{{ $bmi_category }}</span>
                    @if($bmi_category == 'Normal')
                        <i data-lucide="check-circle" class="w-5 h-5 text-green-500"></i>
                    @elseif($bmi_category == '-')
                        <i data-lucide="minus" class="w-5 h-5 text-gray-300"></i>
                    @else
                        <i data-lucide="alert-circle" class="w-5 h-5 text-yellow-500"></i>
                    @endif
                </div>
                <!-- Tensi -->
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 flex flex-col items-center justify-center text-center">
                    <span class="text-xs text-gray-500 font-semibold uppercase">Tensi Terakhir</span>
                    <span class="text-lg font-bold text-[#E3943B] mt-1">{{ $latest_result }}</span>
                    
                    @php 
                        $color = 'text-gray-400';
                        if ($tensi_category == 'Optimal' || $tensi_category == 'Normal' || $tensi_category == 'Normal Tinggi') {
                            $color = 'text-green-600';
                        } elseif (str_contains($tensi_category, 'Hipertensi')) {
                            $color = 'text-red-600';
                        }
                    @endphp
                    
                    <span class="text-xs font-bold {{ $color }} mt-1">{{ $tensi_category }}</span>
                </div>
            </div>

            <!-- 2. Tabel Riwayat -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden flex flex-col h-[500px]"> <!-- Fixed Height -->
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="font-bold text-[#001B48]">Riwayat Skrining</h3>
                    <!-- Link Skrining Baru -->
                    <a href="#" class="text-xs font-medium text-[#E3943B] hover:underline flex items-center">
                        <i data-lucide="plus-circle" class="w-3 h-3 mr-1"></i> Skrining Baru
                    </a>
                </div>
                
                <div class="overflow-y-auto flex-grow p-0">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider w-16">No</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Hasil</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider w-40">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($history as $index => $h)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-base text-gray-500">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-base text-gray-900">
                                        {{ $h->created_at->format('d M Y') }}
                                        <span class="block text-xs text-gray-400">{{ $h->created_at->format('H:i') }} WIB</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                                            {{ stripos($h->result_level, 'tinggi') !== false ? 'bg-red-100 text-red-800' : (stripos($h->result_level, 'sedang') !== false ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                            {{ $h->result_level }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-base font-medium">
                                        <a href="#" class="inline-flex items-center justify-center px-4 py-2 rounded-full bg-gray-100 text-[#001B48] text-sm font-bold hover:bg-[#001B48] hover:text-white transition shadow-sm">
                                            Detail <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                        Belum ada riwayat skrining. <br>
                                        <a href="#" class="text-[#E3943B] font-medium hover:underline mt-2 inline-block">Mulai Skrining Sekarang</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection