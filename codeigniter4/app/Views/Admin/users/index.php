<?= $this->extend('Layouts/admin_layout') ?>

<?= $this->section('title') ?> <?= $title ?> <?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Header Section -->
<div class="mb-6">
    <h1 class="text-2xl font-bold text-brand-blue"><?= $title ?></h1>
    <p class="text-sm text-gray-500">Kelola akun pengguna terdaftar.</p>
</div>

<!-- Toolbar: Actions & Search -->
<div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
    
    <!-- Kiri: Tombol -->
    <div class="flex gap-2 w-full md:w-auto">
        <a href="/admin/users/new" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-brand-blue text-white text-sm font-medium rounded-lg hover:bg-blue-900 transition shadow-sm leading-none">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>Tambah Pengguna</span>
        </a>
    </div>

    <!-- Kanan: Search -->
    <div class="w-full md:w-auto">
        <form action="" method="get" class="relative">
            <input type="text" name="keyword" value="<?= esc($keyword ?? '') ?>" placeholder="Cari username..." 
                   class="w-full md:w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-blue focus:border-transparent text-sm">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
            </div>
        </form>
    </div>
</div>

<!-- Table -->
<div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Username</th>
                    <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Terdaftar</th>
                    <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (empty($users)): ?>
                    <tr><td colspan="4" class="px-6 py-4 text-center text-gray-500">Tidak ada pengguna.</td></tr>
                <?php else: ?>
                    <?php foreach ($users as $u): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-brand-orange align-top text-center">
                            <?= esc($u->username) ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 align-top text-center">
                            <?= esc($u->email) ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 align-top text-center">
                            <?= $u->created_at ? $u->created_at->humanize() : '-' ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium align-top">
                            <div class="flex justify-center gap-2">
                                <a href="/admin/users/edit/<?= $u->id ?>" class="inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-orange-50 text-[#E3943B] border border-orange-200 rounded-md hover:bg-orange-100 transition leading-none">
                                    <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                                    <span>Edit</span>
                                </a>
                                <?php if($u->id != auth()->id()): // Proteksi hapus diri sendiri ?>
                                <a href="/admin/users/delete/<?= $u->id ?>" onclick="return confirm('Yakin ingin menghapus user ini?')" class="inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-red-50 text-red-600 border border-red-200 rounded-md hover:bg-red-100 transition leading-none">
                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                    <span>Hapus</span>
                                </a>
                                <?php endif; ?>
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
