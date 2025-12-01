<?= $this->extend('Layouts/admin_layout') ?>
<?= $this->section('title') ?> <?= $title ?> <?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-brand-blue"><?= $title ?></h1>
        <p class="text-sm text-gray-500">Isi formulir untuk mendaftarkan pengguna baru.</p>
    </div>
    
    <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
        <!-- Tampilkan Error Validasi -->
        <?php if (session()->has('errors')) : ?>
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r text-sm">
                <ul class="list-disc list-inside">
                <?php foreach (session('errors') as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach ?>
                </ul>
            </div>
        <?php endif ?>

        <form action="/admin/users/create" method="post">
            <?= csrf_field() ?>
            <div class="space-y-6">
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" name="username" value="<?= old('username') ?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-brand-blue focus:border-brand-blue" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="<?= old('email') ?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-brand-blue focus:border-brand-blue" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-brand-blue focus:border-brand-blue" required>
                    <p class="text-xs text-gray-500 mt-1">Minimal 8 karakter.</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Role (Hak Akses)</label>
                    <select name="role" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-brand-blue focus:border-brand-blue">
                        <option value="client">Client (Pengguna Biasa)</option>
                        <option value="admin">Admin (Pengelola Sistem)</option>
                    </select>
                </div>

                <div class="flex justify-end space-x-3 pt-4">
                    <a href="/admin/users" class="btn-secondary px-4 py-2 border rounded-md text-gray-700 hover:bg-gray-50 font-medium text-sm">Batal</a>
                    <button type="submit" class="bg-brand-orange text-white px-4 py-2 rounded-md hover:bg-orange-600 font-medium text-sm shadow-sm transition">Simpan Pengguna</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
