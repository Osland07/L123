<?= $this->extend('Layouts/admin_layout') ?>
<?= $this->section('title') ?> <?= $title ?> <?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-brand-blue"><?= $title ?></h1>
    </div>
    <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
        <form action="/admin/rules/create" method="post">
            <?= csrf_field() ?>
            <div class="space-y-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kode</label>
                        <input type="text" value="<?= $code ?>" readonly class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md shadow-sm p-2 text-gray-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Prioritas (1 = Tertinggi)</label>
                        <input type="number" name="priority" value="10" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-brand-blue focus:border-brand-blue">
                        <p class="text-xs text-gray-500 mt-1">Semakin kecil angka, semakin awal dieksekusi.</p>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Faktor Utama (Wajib Ada)</label>
                    <select name="required_factor_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-brand-blue focus:border-brand-blue">
                        <option value="">-- Tidak Ada Faktor Wajib --</option>
                        <?php foreach($factors as $f): ?>
                            <option value="<?= $f['id'] ?>"><?= $f['code'] ?> - <?= $f['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Pilih jika aturan ini mewajibkan satu faktor spesifik (misal E01).</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Min. Jumlah Faktor Lain</label>
                        <input type="number" name="min_other_factors" value="0" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-brand-blue focus:border-brand-blue">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Max. Jumlah Faktor Lain</label>
                        <input type="number" name="max_other_factors" value="99" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-brand-blue focus:border-brand-blue">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Maka Hasil Tingkat Risikonya</label>
                    <select name="risk_level_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-brand-blue focus:border-brand-blue" required>
                        <?php foreach($levels as $l): ?>
                            <option value="<?= $l['id'] ?>"><?= $l['code'] ?> - <?= $l['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="flex justify-end space-x-3 pt-4">
                    <a href="/admin/rules" class="btn-secondary px-4 py-2 border rounded-md">Batal</a>
                    <button type="submit" class="bg-brand-orange text-white px-4 py-2 rounded-md hover:bg-orange-600">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
