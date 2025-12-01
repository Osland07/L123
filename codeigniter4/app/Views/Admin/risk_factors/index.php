<?= $this->extend('Layouts/admin_layout') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Header Section -->
<div class="mb-6">
    <h1 class="text-2xl font-bold text-brand-blue"><?= $title ?></h1>
    <p class="text-sm text-gray-500">Kelola data faktor risiko aplikasi.</p>
</div>

<!-- Toolbar: Actions & Search -->
<div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
    
    <!-- Kiri: Tombol -->
    <div class="flex gap-2 w-full md:w-auto">
        <a href="/admin/risk-factors/new" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-brand-blue text-white text-sm font-medium rounded-lg hover:bg-blue-900 transition shadow-sm leading-none">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>Tambah Data</span>
        </a>
        <a href="/admin/risk-factors/print" target="_blank" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-gray-300 text-[#001B48] text-sm font-medium rounded-lg hover:bg-orange-50 hover:border-orange-200 transition shadow-sm leading-none">
            <i data-lucide="printer" class="w-4 h-4"></i>
            <span>Cetak PDF</span>
        </a>
    </div>

    <!-- Kanan: Search -->
    <div class="w-full md:w-auto">
        <form action="" method="get" class="relative">
            <input type="text" name="keyword" value="<?= esc($keyword ?? '') ?>" placeholder="Cari data..." 
                   class="w-full md:w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-blue focus:border-transparent text-sm">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
            </div>
        </form>
    </div>
</div>

<!-- Alert Messages -->
<?php if (session()->getFlashdata('message')) : ?>
    <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700" role="alert">
        <p class="font-medium">Sukses!</p>
        <p><?= session()->getFlashdata('message') ?></p>
    </div>
<?php endif ?>

<!-- Table Section -->
<div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider w-24">Kode</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Faktor</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider w-48">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (empty($factors)): ?>
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">Tidak ada data.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($factors as $item): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-brand-orange align-top">
                            <?= esc($item['code']) ?>
                        </td>
                        <td class="px-6 py-4 whitespace-normal text-sm font-medium text-gray-900 max-w-md align-top">
                            <?= esc($item['name']) ?>
                            <?php if(!empty($item['question_text'])): ?>
                                <p class="text-xs text-gray-500 mt-1 font-normal">Q: <?= esc($item['question_text']) ?></p>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium align-top">
                            <div class="flex justify-end gap-2">
                                <a href="/admin/risk-factors/edit/<?= $item['id'] ?>" class="inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-orange-50 text-[#E3943B] border border-orange-200 rounded-md hover:bg-orange-100 transition leading-none">
                                    <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                                    <span>Edit</span>
                                </a>
                                <a href="/admin/risk-factors/delete/<?= $item['id'] ?>" onclick="return confirm('Yakin ingin menghapus?')" class="inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-red-50 text-red-600 border border-red-200 rounded-md hover:bg-red-100 transition leading-none">
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
</div>

<?= $this->endSection() ?>
