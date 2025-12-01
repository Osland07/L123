<?= $this->extend('Layouts/auth_layout') ?>

<?= $this->section('title') ?>Daftar Akun<?= $this->endSection() ?>

<?= $this->section('header') ?>
    <h2 class="text-white text-lg font-medium">Bergabunglah Bersama Kami</h2>
    <p class="text-blue-200 text-sm">Buat akun baru untuk memulai perjalanan sehat Anda.</p>
<?= $this->endSection() ?>

<?= $this->section('main') ?>

    <?php if (session('error') !== null) : ?>
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 text-sm mb-6 rounded-r flex items-start">
            <i data-lucide="alert-circle" class="w-5 h-5 mr-2 mt-0.5"></i>
            <div><?= session('error') ?></div>
        </div>
    <?php elseif (session('errors') !== null) : ?>
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 text-sm mb-6 rounded-r">
            <?php if (is_array(session('errors'))) : ?>
                <?php foreach (session('errors') as $error) : ?>
                    <?= $error ?>
                    <br>
                <?php endforeach ?>
            <?php else : ?>
                <?= session('errors') ?>
            <?php endif ?>
        </div>
    <?php endif ?>

    <form action="<?= url_to('register') ?>" method="post" class="space-y-5">
        <?= csrf_field() ?>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-bold text-[#001B48] mb-2">Email</label>
            <input type="email" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#E3943B] focus:ring-[#E3943B] transition shadow-sm text-sm" name="email" inputmode="email" autocomplete="email" placeholder="nama@email.com" value="<?= old('email') ?>" required>
        </div>

        <!-- Nama Lengkap -->
        <div>
            <label for="full_name" class="block text-sm font-bold text-[#001B48] mb-2">Nama Lengkap</label>
            <input type="text" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#E3943B] focus:ring-[#E3943B] transition shadow-sm text-sm" name="full_name" inputmode="text" placeholder="Nama Lengkap Anda" value="<?= old('full_name') ?>" required>
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-bold text-[#001B48] mb-2">Password</label>
            <input type="password" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#E3943B] focus:ring-[#E3943B] transition shadow-sm text-sm" name="password" inputmode="text" autocomplete="new-password" placeholder="••••••••" required>
        </div>

        <!-- Password Confirm -->
        <div>
            <label for="password_confirm" class="block text-sm font-bold text-[#001B48] mb-2">Konfirmasi Password</label>
            <input type="password" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#E3943B] focus:ring-[#E3943B] transition shadow-sm text-sm" name="password_confirm" inputmode="text" autocomplete="new-password" placeholder="••••••••" required>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg text-sm font-bold text-white bg-[#001B48] hover:bg-blue-900 focus:outline-none focus:ring-4 focus:ring-blue-200 transition transform hover:-translate-y-0.5 mt-6">
            Daftar Akun
        </button>

        <!-- Login Link -->
        <p class="text-center text-sm text-gray-600 mt-6">
            Sudah punya akun? 
            <a href="<?= url_to('login') ?>" class="font-bold text-[#E3943B] hover:text-orange-700 ml-1">Masuk disini</a>
        </p>

    </form>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>lucide.createIcons();</script>

<?= $this->endSection() ?>