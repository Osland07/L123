<?= $this->extend('Layouts/admin_layout') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-brand-blue"><?= $title ?></h1>
        <p class="text-sm text-gray-500">Perbarui informasi data faktor risiko.</p>
    </div>

    <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
        <form action="/admin/risk-factors/update/<?= $factor['id'] ?>" method="post">
            <?= csrf_field() ?>

            <div class="space-y-6">
                <!-- Kode (Otomatis) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Kode</label>
                    <input type="text" value="<?= esc($factor['code']) ?>" readonly class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 text-gray-500 shadow-sm sm:text-sm p-2">
                </div>

                <!-- Nama -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Faktor Risiko (Medis)</label>
                    <input type="text" name="name" id="name" value="<?= esc($factor['name']) ?>" required class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-brand-blue focus:ring-brand-blue sm:text-sm p-2">
                </div>

                <!-- Teks Pertanyaan -->
                <div>
                    <label for="question_text" class="block text-sm font-medium text-gray-700">Teks Pertanyaan (UX)</label>
                    <textarea name="question_text" id="question_text" rows="2" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-brand-blue focus:ring-brand-blue sm:text-sm p-2"><?= esc($factor['question_text']) ?></textarea>
                    <p class="text-xs text-gray-500 mt-1">Teks ini yang akan muncul saat skrining user.</p>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-3 pt-4">
                    <a href="/admin/risk-factors" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-brand-blue hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue">
                        Perbarui Data
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
