@extends('layouts.app')

@section('title', 'Mulai Skrining')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- Header -->
        <div class="bg-[#001B48] p-8 text-center">
            <div class="w-16 h-16 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="stethoscope" class="w-8 h-8 text-white"></i>
            </div>
            <h1 class="text-2xl font-bold text-white mb-2">Skrining Risiko Hipertensi</h1>
            <p class="text-blue-200 text-sm max-w-lg mx-auto">
                Jawablah pertanyaan berikut dengan jujur sesuai kondisi kesehatan Anda saat ini untuk mendapatkan hasil analisis yang akurat.
            </p>
        </div>

        <div class="p-8">
            @if(!$isProfileComplete)
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 rounded-r">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i data-lucide="alert-triangle" class="h-5 w-5 text-yellow-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                Profil Anda belum lengkap (Nama, Umur, Jenis Kelamin). 
                                <a href="{{ route('client.profile.index') }}" class="font-medium underline hover:text-yellow-600">Lengkapi Profil</a> terlebih dahulu untuk hasil yang lebih akurat.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('client.screening.store') }}" method="POST">
                @csrf
                
                <div class="space-y-6">
                    @foreach($factors as $index => $factor)
                    <div class="p-4 rounded-xl border border-gray-200 hover:border-[#E3943B] transition bg-gray-50/50">
                        <label class="flex items-start cursor-pointer">
                            <div class="flex items-center h-5 mt-1">
                                <input type="checkbox" name="answers[]" value="{{ $factor->id }}" class="w-5 h-5 text-[#E3943B] border-gray-300 rounded focus:ring-[#E3943B]">
                            </div>
                            <div class="ml-4">
                                <span class="block text-sm font-bold text-[#001B48] mb-1">{{ $factor->name }}</span>
                                @if($factor->question_text)
                                    <span class="block text-sm text-gray-600 italic">"{{ $factor->question_text }}"</span>
                                @endif
                            </div>
                        </label>
                    </div>
                    @endforeach
                </div>

                <div class="mt-10 border-t border-gray-100 pt-6 flex justify-end">
                    <button type="submit" class="inline-flex items-center px-8 py-4 bg-[#E3943B] text-white font-bold rounded-xl hover:bg-orange-600 transition shadow-lg transform hover:-translate-y-0.5">
                        <i data-lucide="check-circle" class="w-5 h-5 mr-2"></i>
                        Lihat Hasil Analisis
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection