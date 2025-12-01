<?= $this->extend('Layouts/admin_layout') ?>

<?= $this->section('title') ?>
Dashboard Admin
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="flex flex-col h-full overflow-hidden">
    <!-- Header -->
    <div class="flex-shrink-0 mb-4">
        <h1 class="text-2xl font-bold tracking-tight text-[#001B48]">Dashboard</h1>
        <p class="text-xs text-gray-500">Ringkasan performa sistem.</p>
    </div>

    <!-- Baris 1: Statistik Ringkas (4 Kolom) -->
    <div class="flex-shrink-0 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
        <!-- Total Pasien -->
        <div class="p-3 bg-white rounded-xl border border-gray-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[10px] font-medium text-gray-500 uppercase">Total Pasien</p>
                <p class="text-xl font-bold text-[#001B48]"><?= $total_users ?></p>
            </div>
            <div class="p-1.5 bg-blue-50 rounded-lg">
                <i data-lucide="users" class="w-5 h-5 text-blue-600"></i>
            </div>
        </div>

        <!-- Faktor Risiko -->
        <div class="p-3 bg-white rounded-xl border border-gray-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[10px] font-medium text-gray-500 uppercase">Faktor Risiko</p>
                <p class="text-xl font-bold text-[#001B48]"><?= $total_risk_factors ?></p>
            </div>
            <div class="p-1.5 bg-orange-50 rounded-lg">
                <i data-lucide="clipboard-list" class="w-5 h-5 text-[#E3943B]"></i>
            </div>
        </div>

        <!-- Tingkat Risiko -->
        <div class="p-3 bg-white rounded-xl border border-gray-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[10px] font-medium text-gray-500 uppercase">Tingkat Risiko</p>
                <p class="text-xl font-bold text-[#001B48]"><?= $total_risk_levels ?></p>
            </div>
            <div class="p-1.5 bg-red-50 rounded-lg">
                <i data-lucide="bar-chart-2" class="w-5 h-5 text-red-600"></i>
            </div>
        </div>

        <!-- Total Aturan -->
        <div class="p-3 bg-white rounded-xl border border-gray-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[10px] font-medium text-gray-500 uppercase">Total Aturan</p>
                <p class="text-xl font-bold text-[#001B48]"><?= $total_rules ?></p>
            </div>
            <div class="p-1.5 bg-green-50 rounded-lg">
                <i data-lucide="git-branch" class="w-5 h-5 text-green-600"></i>
            </div>
        </div>
    </div>

    <!-- Baris 2: Grid Utama (Distribusi & Aktivitas) - Mengisi sisa ruang -->
    <div class="flex-grow grid grid-cols-1 lg:grid-cols-12 gap-4 min-h-0">
        
        <!-- Kolom Kiri: Distribusi Risiko (40%) -->
        <div class="lg:col-span-5 bg-white rounded-xl border border-gray-200 shadow-sm p-4 flex flex-col h-full overflow-hidden">
            <h3 class="text-sm font-bold text-[#001B48] mb-4 flex-shrink-0">Distribusi Risiko</h3>
            
            <div class="space-y-4 flex-grow flex flex-col justify-center overflow-y-auto">
                <?php foreach (['Tinggi', 'Sedang', 'Rendah'] as $level) : ?>
                    <?php
                        $percentage = $risk_percentages[$level];
                        $colorClass = $level == 'Tinggi' ? 'bg-red-500' : ($level == 'Sedang' ? 'bg-yellow-500' : 'bg-green-500');
                    ?>
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-xs font-medium text-gray-700"><?= $level ?></span>
                            <span class="text-xs font-bold text-gray-900"><?= $percentage ?>%</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-xl h-20">
                            <div class="<?= $colorClass ?> h-20 rounded-xl transition-all duration-1000 ease-out" style="width: <?= $percentage ?>%;"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <?php if ($total_screenings == 0) : ?>
                    <p class="text-center text-xs text-gray-400 italic mt-4">Belum ada data.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Kolom Kanan: Aktivitas Terbaru (60%) -->
        <div class="lg:col-span-7 bg-white rounded-xl border border-gray-200 shadow-sm flex flex-col h-full overflow-hidden">
            <div class="p-4 border-b border-gray-100 bg-gray-50 flex-shrink-0">
                <h3 class="text-sm font-bold text-[#001B48]">Aktivitas Terbaru</h3>
            </div>
            
            <div class="flex-grow overflow-y-auto p-0">
                <?php if (empty($latest_screenings)) : ?>
                    <div class="h-full flex items-center justify-center text-gray-400 text-xs italic p-8">
                        Belum ada riwayat skrining.
                    </div>
                <?php else : ?>
                    <div class="divide-y divide-gray-100">
                        <?php foreach ($latest_screenings as $screening) : ?>
                            <div class="p-3 flex items-center justify-between hover:bg-gray-50 transition">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 text-[#001B48] flex items-center justify-center text-xs font-bold">
                                        <?= strtoupper(substr($screening['client_name'], 0, 1)) ?>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-gray-800"><?= esc($screening['client_name']) ?></p>
                                        <p class="text-[10px] text-gray-500"><?= date('d M, H:i', strtotime($screening['created_at'])) ?></p>
                                    </div>
                                </div>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold <?= stripos($screening['result_level'], 'tinggi') !== false ? 'bg-red-100 text-red-700' : (stripos($screening['result_level'], 'sedang') !== false ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') ?>">
                                    <?= esc($screening['result_level']) ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>