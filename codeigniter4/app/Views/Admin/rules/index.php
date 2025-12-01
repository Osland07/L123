<?= $this->extend('Layouts/admin_layout') ?>

<?= $this->section('title') ?> <?= $title ?> <?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Header Section -->
<div class="mb-6">
    <h1 class="text-2xl font-bold text-brand-blue"><?= $title ?></h1>
    <p class="text-sm text-gray-500">Tentukan logika diagnosa penyakit.</p>
</div>

<!-- Toolbar: Actions & Search -->
<div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
    
    <!-- Kiri: Tombol -->
    <div class="flex gap-2 w-full md:w-auto">
        <a href="/admin/rules/new" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-brand-blue text-white text-sm font-medium rounded-lg hover:bg-blue-900 transition shadow-sm leading-none">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>Tambah Aturan</span>
        </a>
        <a href="/admin/rules/print" target="_blank" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-gray-300 text-[#001B48] text-sm font-medium rounded-lg hover:bg-orange-50 hover:border-orange-200 transition shadow-sm leading-none">
            <i data-lucide="printer" class="w-4 h-4"></i>
            <span>Cetak PDF</span>
        </a>
    </div>

    <!-- Kanan: Search (Placeholder) -->
    <div class="w-full md:w-auto">
        <form action="" method="get" class="relative">
            <input type="text" name="keyword" value="<?= esc($keyword ?? '') ?>" placeholder="Cari kode..." 
                   class="w-full md:w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-blue focus:border-transparent text-sm">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
            </div>
        </form>
    </div>
</div>

<div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Prio</th>
                <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Kode</th>
                <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Syarat Faktor Utama</th>
                <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Syarat Faktor Lain</th>
                <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Hasil</th>
                <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php if (empty($rules)): ?>
                <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada aturan.</td></tr>
            <?php else: ?>
                <?php foreach ($rules as $r): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm text-gray-500 font-mono text-center"><?= $r['priority'] ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-brand-orange text-center"><?= $r['code'] ?></td>
                    <td class="px-6 py-4 text-sm text-gray-900 text-center">
                        <?= $r['factor_name'] ? esc($r['factor_name']) : '<span class="text-gray-400 italic">Tidak ada</span>' ?>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900 text-center">
                        <?= $r['min_other_factors'] ?> s/d <?= $r['max_other_factors'] == 99 ? 'Tak Terbatas' : $r['max_other_factors'] ?>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900 text-center">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                            <?= $r['level_name'] ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                        <div class="flex justify-center gap-2">
                            <a href="/admin/rules/edit/<?= $r['id'] ?>" class="inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-orange-50 text-[#E3943B] border border-orange-200 rounded-md hover:bg-orange-100 transition leading-none">
                                <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                                <span>Edit</span>
                            </a>
                            <a href="/admin/rules/delete/<?= $r['id'] ?>" onclick="return confirm('Hapus aturan ini?')" class="inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-red-50 text-red-600 border border-red-200 rounded-md hover:bg-red-100 transition leading-none">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                <span>Hapus</span>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
