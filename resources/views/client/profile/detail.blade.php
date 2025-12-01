@extends('layouts.app')

@section('title', 'Detail Hasil Skrining')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-[#001B48]">Hasil Analisis</h1>
        <a href="{{ route('client.profile.index') }}" class="text-sm font-medium text-gray-500 hover:text-[#E3943B] flex items-center">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-1"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        
        <!-- Header Hasil -->
        <div class="p-8 text-center bg-gray-50 border-b border-gray-200">
            <p class="text-sm text-gray-500 uppercase tracking-wide font-bold mb-2">Tingkat Risiko Anda</p>
            
            @php
                $colorClass = 'text-green-600';
                $bgClass = 'bg-green-100';
                if (stripos($screening->result_level, 'tinggi') !== false) {
                    $colorClass = 'text-red-600';
                    $bgClass = 'bg-red-100';
                } elseif (stripos($screening->result_level, 'sedang') !== false) {
                    $colorClass = 'text-yellow-600';
                    $bgClass = 'bg-yellow-100';
                }
            @endphp

            <h2 class="text-4xl font-extrabold {{ $colorClass }} mb-4">{{ $screening->result_level }}</h2>
            
            <div class="inline-flex items-center px-4 py-2 rounded-full {{ $bgClass }} {{ $colorClass }} text-sm font-bold">
                Skor Faktor: {{ $screening->score }}
            </div>
        </div>

        <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <!-- Kiri: Saran -->
            <div>
                <h3 class="text-lg font-bold text-[#001B48] mb-4 flex items-center">
                    <i data-lucide="lightbulb" class="w-5 h-5 mr-2 text-[#E3943B]"></i> Saran & Rekomendasi
                </h3>
                <div class="prose prose-sm text-gray-600 bg-blue-50 p-6 rounded-xl border border-blue-100">
                    @if($riskLevel)
                        <p class="mb-4 font-medium">{{ $riskLevel->description }}</p>
                        <p>{{ $riskLevel->suggestion }}</p>
                    @else
                        <p>Data saran tidak ditemukan untuk tingkat risiko ini.</p>
                    @endif
                </div>
                
                <div class="mt-6">
                    <a href="{{ route('client.pdf.print', $screening->id) }}" target="_blank" class="w-full inline-flex justify-center items-center px-4 py-3 bg-[#001B48] text-white font-bold rounded-xl hover:bg-blue-900 transition shadow-md">
                        <i data-lucide="printer" class="w-4 h-4 mr-2"></i> Cetak Hasil PDF
                    </a>
                </div>
            </div>

            <!-- Kanan: Detail Faktor -->
            <div>
                <h3 class="text-lg font-bold text-[#001B48] mb-4 flex items-center">
                    <i data-lucide="list" class="w-5 h-5 mr-2 text-[#E3943B]"></i> Faktor Risiko Terdeteksi
                </h3>
                
                @if($screening->details->isEmpty())
                    <div class="text-center py-8 text-gray-400 italic border-2 border-dashed border-gray-200 rounded-xl">
                        Tidak ada faktor risiko yang ditemukan.
                    </div>
                @else
                    <ul class="space-y-3">
                        @foreach($screening->details as $detail)
                            <li class="flex items-start p-3 rounded-lg bg-gray-50 border border-gray-100">
                                <i data-lucide="check-circle" class="w-5 h-5 text-red-500 mr-3 mt-0.5 flex-shrink-0"></i>
                                <span class="text-sm text-gray-700 font-medium">{{ $detail->riskFactor->name }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

        </div>
        
        <div class="bg-gray-50 px-8 py-4 text-center text-xs text-gray-400 border-t border-gray-200">
            Skrining dilakukan pada {{ $screening->created_at->format('d F Y, H:i') }}
        </div>

    </div>
</div>
@endsection