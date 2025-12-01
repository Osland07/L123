<?= $this->extend('Layouts/admin_layout') ?>

<?= $this->section('title') ?>
Detail Riwayat
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Tentukan Warna & Ikon -->
<?php 
    $isHigh = stripos($screening['result_level'], 'tinggi') !== false;
    $isMed = stripos($screening['result_level'], 'sedang') !== false;
    
    $bgClass = $isHigh ? 'bg-red-50' : ($isMed ? 'bg-yellow-50' : 'bg-green-50');
    $textClass = $isHigh ? 'text-red-600' : ($isMed ? 'text-yellow-600' : 'text-green-600');
    $borderClass = $isHigh ? 'border-red-200' : ($isMed ? 'border-yellow-200' : 'border-green-200');
    $icon = $isHigh ? 'alert-triangle' : ($isMed ? 'alert-circle' : 'check-circle');
?>

<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-brand-blue">Detail Riwayat Skrining</h1>
        <p class="text-sm text-gray-500">Analisis lengkap hasil skrining pengguna.</p>
    </div>
    <div class="flex gap-2">
        <a href="/admin/history" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition shadow-sm leading-none">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali</span>
        </a>
                <a href="/admin/history/pdf/<?= $screening['id'] ?>/view" target="_blank" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition shadow-sm leading-none">
            <i data-lucide="file-text" class="w-4 h-4"></i>
            <span>Lihat PDF</span>
        </a>
        <a href="/admin/history/pdf/<?= $screening['id'] ?>/download" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-brand-blue text-white text-sm font-medium rounded-lg hover:bg-blue-900 transition shadow-sm leading-none">
            <i data-lucide="download" class="w-4 h-4"></i>
            <span>Unduh PDF</span>
        </a>
    </div>
</div>

<!-- Container 3 Kolom (Adaptasi dari Client Detail) -->
<div class="h-[calc(100vh-10rem)] bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden flex flex-col print:h-auto print:border-none print:shadow-none">
    
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-0 h-full">
        
        <!-- KOLOM 1: PROFIL & HASIL (30%) -->
        <div class="lg:col-span-4 flex flex-col border-r border-gray-100 h-full overflow-y-auto bg-gray-50/50">
            
            <!-- Kartu Hasil -->
            <div class="p-8 text-center border-b border-gray-100 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-2 <?= str_replace('text-', 'bg-', explode(' ', $textClass)[0]) ?>"></div>
                <div class="w-20 h-20 rounded-full <?= $bgClass ?> flex items-center justify-center mb-4 mx-auto">
                    <i data-lucide="<?= $icon ?>" class="w-10 h-10 <?= $textClass ?>"></i>
                </div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Risiko Hipertensi</p>
                <h2 class="text-2xl font-extrabold <?= $textClass ?> leading-tight">
                    <?= esc($screening['result_level']) ?>
                </h2>
                <p class="text-xs text-gray-500 mt-2">
                    Tanggal: <?= date('d M Y, H:i', strtotime($screening['created_at'])) ?>
                </p>
            </div>

            <!-- Data Pasien -->
            <div class="p-6">
                <h3 class="text-sm font-bold text-[#001B48] mb-4 flex items-center pb-2 border-b border-gray-200">
                    <i data-lucide="user" class="w-4 h-4 mr-2 text-gray-400"></i> Data Pasien
                </h3>
                <div class="space-y-4 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Nama</span>
                        <span class="font-bold text-gray-800"><?= esc($screening['client_name']) ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Umur</span>
                        <span class="font-bold text-gray-800"><?= esc($profile['age'] ?? '-') ?> Tahun</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Jenis Kelamin</span>
                        <span class="font-bold text-gray-800"><?= ($profile['gender'] ?? '-') == 'L' ? 'Laki-laki' : 'Perempuan' ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">BMI</span>
                        <span class="font-bold text-gray-800"><?= $bmi ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Tensi</span>
                        <span class="font-bold text-gray-800"><?= $tensi ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- KOLOM 2: ANALISIS & FAKTOR (70%) -->
        <div class="lg:col-span-8 flex flex-col h-full bg-white">
            
            <!-- Analisis -->
            <div class="p-8 border-b border-gray-100 flex-shrink-0">
                <h3 class="text-base font-bold text-[#001B48] mb-4 flex items-center">
                    <i data-lucide="activity" class="w-5 h-5 mr-2 text-[#E3943B]"></i> Analisis & Rekomendasi
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-xs font-bold text-gray-500 uppercase mb-2">Keterangan Medis</h4>
                        <p class="text-gray-700 text-sm leading-relaxed text-justify">
                            <?= $riskLevelData ? esc($riskLevelData['description']) : 'Tidak ada keterangan.' ?>
                        </p>
                    </div>
                    <div class="bg-blue-50 p-4 rounded-lg border-l-4 border-[#001B48]">
                        <h4 class="text-xs font-bold text-[#001B48] uppercase mb-2">Saran Dokter</h4>
                        <div class="text-gray-800 text-sm leading-relaxed text-justify">
                            <?= $riskLevelData ? nl2br(esc($riskLevelData['suggestion'])) : 'Tidak ada saran.' ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Faktor Risiko -->
            <div class="p-8 flex-grow overflow-y-auto custom-scrollbar">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-bold text-[#001B48] flex items-center">
                        <i data-lucide="list-checks" class="w-4 h-4 mr-2 text-gray-400"></i> Faktor Risiko Terdeteksi
                    </h3>
                    <span class="bg-red-100 text-red-700 text-xs font-bold px-2 py-0.5 rounded-full"><?= count($details) ?></span>
                </div>

                <?php if (empty($details)): ?>
                    <p class="text-gray-400 italic text-sm text-center py-8">Tidak ditemukan faktor risiko signifikan lainnya.</p>
                <?php else: ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <?php foreach ($details as $d): ?>
                        <div class="p-3 rounded-lg border border-gray-100 hover:border-red-100 transition flex items-start bg-gray-50">
                            <i data-lucide="alert-circle" class="w-4 h-4 text-red-500 mr-2 mt-0.5 flex-shrink-0"></i>
                            <div>
                                <span class="text-[10px] font-bold text-[#E3943B] block mb-0.5">[<?= esc($d['code']) ?>]</span>
                                <p class="text-xs font-bold text-gray-800 leading-tight"><?= esc($d['name']) ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

<style>
    /* Scrollbar Halus */
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #9ca3af; }

    @media print {
        .no-print, nav, aside { display: none !important; }
        body { background-color: white; color: black; }
        .grid { display: block !important; }
        .h-\[calc\(100vh-10rem\)\] { height: auto !important; overflow: visible !important; border: none !important; box-shadow: none !important; }
        .overflow-y-auto { height: auto !important; overflow: visible !important; }
        .lg\:col-span-4, .lg\:col-span-8 { width: 100% !important; display: block !important; margin-bottom: 20px; }
        .bg-gray-50\/50 { background: white !important; }
        .bg-gray-50 { background: white !important; border: 1px solid #eee !important; }
    }
</style>

<script>
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>

<?= $this->endSection() ?>
