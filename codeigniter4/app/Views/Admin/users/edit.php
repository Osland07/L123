<?= $this->extend('Layouts/admin_layout') ?>
<?= $this->section('title') ?> <?= $title ?> <?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-brand-blue"><?= $title ?></h1>
    </div>
    <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
        <form action="/admin/users/update/<?= $user->id ?>" method="post">
            <?= csrf_field() ?>
            <div class="space-y-6">
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" name="username" value="<?= esc($user->username) ?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-brand-blue focus:border-brand-blue">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="<?= esc($user->email) ?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-brand-blue focus:border-brand-blue">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Password Baru (Opsional)</label>
                    <input type="password" name="password" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-brand-blue focus:border-brand-blue" placeholder="Isi jika ingin mengganti password">
                </div>

                <div class="flex justify-end space-x-3 pt-4">
                    <a href="/admin/users" class="btn-secondary px-4 py-2 border rounded-md">Batal</a>
                    <button type="submit" class="bg-brand-orange text-white px-4 py-2 rounded-md hover:bg-orange-600">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
