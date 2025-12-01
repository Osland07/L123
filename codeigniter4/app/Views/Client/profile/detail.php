<?= $this->extend('Layouts/client_layout') ?>

<?= $this->section('title') ?>
Hasil Skrining
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Tentukan Warna & Ikon -->
<?php 
    $isHigh = stripos($screening['result_level'], 'tinggi') !== false;
    $isMed = stripos($screening['result_level'], 'sedang') !== false;
    
    $bgClass = $isHigh ? 'bg-red-50' : ($isMed ? 'bg-orange-50' : 'bg-green-50');
    $textClass = $isHigh ? 'text-red-600' : ($isMed ? 'text-orange-600' : 'text-green-600');
    $borderClass = $isHigh ? 'border-red-200' : ($isMed ? 'border-orange-200' : 'border-green-200');
    $icon = $isHigh ? 'alert-triangle' : ($isMed ? 'alert-circle' : 'shield-check');
?>

<!-- Container Utama: Full Height minus Navbar (80px) -->
<div class="h-[calc(100vh-5rem)] bg-gray-50 p-4 overflow-hidden flex flex-col print:h-auto print:overflow-visible">
    
    <!-- Header Kecil (Breadcrumb + Aksi) -->
    <div class="flex justify-between items-center mb-4 flex-shrink-0 px-2 no-print">
        <a href="/profile" class="inline-flex items-center text-gray-500 hover:text-[#001B48] transition font-bold text-sm">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i> Kembali
        </a>
        <div class="flex gap-2">
            <a href="/detail/pdf/<?= $screening['id'] ?>/view" target="_blank" class="text-[#001B48] hover:text-[#E3943B] font-bold text-sm transition">Lihat PDF</a>
            <a href="/detail/pdf/<?= $screening['id'] ?>/download" class="text-[#001B48] hover:text-[#E3943B] font-bold text-sm transition">Unduh PDF</a>
        </div>
    </div>

    <!-- Grid 3 Kolom -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 h-full overflow-hidden">
        
        <!-- KOLOM 1: PROFIL & HASIL (3 Kolom Grid) -->
        <div class="lg:col-span-3 flex flex-col gap-4 h-full overflow-y-auto custom-scrollbar pr-1">
            
            <!-- Kartu Hasil -->
            <div class="bg-white rounded-2xl shadow-sm border <?= $borderClass ?> p-6 text-center flex flex-col items-center justify-center flex-shrink-0 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-2 <?= str_replace('text-', 'bg-', explode(' ', $textClass)[0]) ?>"></div>
                <div class="w-16 h-16 rounded-full <?= $bgClass ?> flex items-center justify-center mb-3">
                    <i data-lucide="<?= $icon ?>" class="w-8 h-8 <?= $textClass ?>"></i>
                </div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Risiko Hipertensi</p>
                <h2 class="text-2xl font-extrabold <?= $textClass ?> leading-tight mt-1">
                    <?= esc($screening['result_level']) ?>
                </h2>
                <p class="text-xs text-gray-400 mt-2"><?= date('d M Y', strtotime($screening['created_at'])) ?></p>
            </div>

            <!-- Data Pasien -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 flex-grow">
                <h3 class="text-sm font-bold text-[#001B48] mb-4 flex items-center border-b border-gray-100 pb-2">
                    <i data-lucide="user" class="w-4 h-4 mr-2"></i> Pasien
                </h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-400 uppercase">Nama</p>
                        <p class="font-bold text-[#001B48] text-sm truncate"><?= esc($screening['client_name']) ?></p>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                    <span class="block text-xs text-gray-400 uppercase font-bold mb-1">Umur</span>
                    <span class="block text-base font-bold text-[#001B48]"><?= esc($age_snapshot) ?> Thn</span>
                </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase">Jenis Kelamin</p>
                            <p class="font-bold text-[#001B48] text-sm"><?= ($profile['gender'] ?? '-') == 'L' ? 'Laki-laki' : 'Perempuan' ?></p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <p class="text-xs text-gray-400 uppercase">BMI</p>
                            <p class="font-bold text-[#001B48] text-sm"><?= $bmi ?></p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase">Tensi</p>
                            <p class="font-bold text-[#001B48] text-sm truncate"><?= $tensi ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- KOLOM 2: ANALISIS & REKOMENDASI (5 Kolom Grid - Terlebar) -->
        <div class="lg:col-span-6 bg-white rounded-2xl shadow-sm border border-gray-200 p-6 flex flex-col h-full overflow-hidden">
            <h3 class="text-base font-bold text-[#001B48] mb-4 flex items-center flex-shrink-0 border-b border-gray-100 pb-3">
                <i data-lucide="file-text" class="w-5 h-5 mr-2 text-[#E3943B]"></i> Analisis & Rekomendasi
            </h3>
            
            <div class="overflow-y-auto custom-scrollbar pr-2 space-y-6">
                <!-- Keterangan -->
                <div>
                    <h4 class="text-xs font-bold text-gray-500 uppercase mb-2">Keterangan Medis</h4>
                    <p class="text-gray-700 text-sm leading-relaxed text-justify">
                        <?= $riskLevelData ? esc($riskLevelData['description']) : 'Tidak ada keterangan tersedia.' ?>
                    </p>
                </div>

                <!-- Saran -->
                <div class="bg-blue-50 p-5 rounded-xl border-l-4 border-[#001B48]">
                    <h4 class="text-xs font-bold text-[#001B48] uppercase mb-3">Saran</h4>
                    <div class="text-gray-800 text-sm leading-relaxed text-justify space-y-2">
                        <?= $riskLevelData ? nl2br(esc($riskLevelData['suggestion'])) : 'Tidak ada saran tersedia.' ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- KOLOM 3: FAKTOR RISIKO (3 Kolom Grid) -->
        <div class="lg:col-span-3 bg-white rounded-2xl shadow-sm border border-gray-200 p-5 flex flex-col h-full overflow-hidden">
            <div class="flex justify-between items-center mb-4 border-b border-gray-100 pb-3 flex-shrink-0">
                <h3 class="text-sm font-bold text-[#001B48] flex items-center">
                    <i data-lucide="clipboard-list" class="w-4 h-4 mr-2 text-gray-400"></i> Faktor Risiko
                </h3>
                <span class="bg-red-100 text-red-700 text-xs font-bold px-2 py-0.5 rounded-full"><?= count($details) ?></span>
            </div>
            
            <div class="overflow-y-auto custom-scrollbar pr-1">
                <?php if (empty($details)): ?>
                    <div class="h-full flex flex-col items-center justify-center text-center text-gray-400 py-8">
                        <i data-lucide="shield-check" class="w-10 h-10 mb-2 text-green-200"></i>
                        <p class="text-xs">Tidak ditemukan faktor risiko signifikan.</p>
                    </div>
                <?php else: ?>
                    <ul class="space-y-2">
                        <?php foreach ($details as $d): ?>
                        <li class="p-3 rounded-lg bg-gray-50 border border-gray-100 flex items-start">
                            <i data-lucide="alert-circle" class="w-4 h-4 text-red-500 mr-2 mt-0.5 flex-shrink-0"></i>
                            <div>
                                <span class="text-[10px] font-bold text-[#E3943B] block mb-0.5">[<?= esc($d['code']) ?>]</span>
                                <p class="text-xs font-bold text-gray-800 leading-tight"><?= esc($d['name']) ?></p>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<style>
    /* Scrollbar Halus */
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #d1d5db; }

    @media print {
        @page { margin: 2cm; size: A4 portrait; }
        body { background-color: white !important; color: black !important; font-family: serif; font-size: 12pt; }
        
        /* Sembunyikan elemen non-cetak */
        .no-print, nav, footer, .bg-gray-50, .overflow-hidden { display: none !important; }
        
        /* Reset Layout Container */
        .h-\[calc\(100vh-5rem\)\] { height: auto !important; padding: 0 !important; background: white !important; }
        .overflow-y-auto, .custom-scrollbar { overflow: visible !important; height: auto !important; }
        .grid { display: block !important; }
        .lg\:col-span-3, .lg\:col-span-6, .lg\:col-span-12 { width: 100% !important; display: block !important; }
        
        /* Styling Kartu menjadi Section Laporan */
        .bg-white, .rounded-2xl, .shadow-sm, .border { 
            background: white !important; 
            box-shadow: none !important; 
            border: none !important; 
            border-radius: 0 !important; 
            padding: 0 !important; 
            margin-bottom: 20px !important; 
        }

        /* Header Laporan (Logo & Judul) - Kita buat element khusus print */
        .print-header { display: block !important; text-align: center; margin-bottom: 30px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .print-header h1 { font-size: 24pt; margin: 0; color: #000; }
        .print-header p { font-size: 10pt; color: #555; }

        /* Styling Konten Spesifik */
        h1, h2, h3, h4 { color: #000 !important; page-break-after: avoid; }
        p, li { color: #000 !important; line-height: 1.5; }
        
        /* Section Borders */
        .section-print { border: 1px solid #ccc !important; padding: 15px !important; margin-bottom: 20px !important; border-radius: 5px !important; }
    }
</style>

<!-- Header Khusus Print (Tersembunyi di Layar) -->
<div class="print-header hidden">
    <h1>Laporan Hasil Skrining Hipertensi</h1>
    <p>TensiTrack - Sistem Pakar Deteksi Dini Hipertensi</p>
</div>

<script>
    lucide.createIcons();
</script>

<?= $this->endSection() ?>
