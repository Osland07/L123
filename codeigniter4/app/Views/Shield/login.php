<?= $this->extend('Layouts/auth_layout') ?>

<?= $this->section('title') ?>Login<?= $this->endSection() ?>

<?= $this->section('header') ?>
    <h2 class="text-white text-lg font-medium">Selamat Datang Kembali</h2>
    <p class="text-blue-200 text-sm">Masuk untuk mengelola kesehatan Anda.</p>
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

    <?php if (session('message') !== null) : ?>
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 text-sm mb-6 rounded-r">
            <?= session('message') ?>
        </div>
    <?php endif ?>

    <form action="<?= url_to('login') ?>" method="post" class="space-y-6">
        <?= csrf_field() ?>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-bold text-[#001B48] mb-2">Email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i data-lucide="mail" class="w-5 h-5 text-gray-400"></i>
                </div>
                <input type="email" class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-300 focus:border-[#E3943B] focus:ring-[#E3943B] transition shadow-sm text-sm" name="email" inputmode="email" autocomplete="email" placeholder="nama@email.com" value="<?= old('email') ?>" required>
            </div>
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-bold text-[#001B48] mb-2">Password</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i data-lucide="lock" class="w-5 h-5 text-gray-400"></i>
                </div>
                <input type="password" class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-300 focus:border-[#E3943B] focus:ring-[#E3943B] transition shadow-sm text-sm" name="password" inputmode="text" autocomplete="current-password" placeholder="••••••••" required>
            </div>
        </div>

        <!-- Remember Me -->
        <?php if (setting('Auth.sessionConfig')['allowRemembering']): ?>
            <div class="flex items-center justify-between">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="remember" class="form-checkbox h-4 w-4 text-[#E3943B] border-gray-300 rounded focus:ring-[#E3943B] focus:ring-offset-0" <?php if (old('remember')): ?> checked <?php endif ?>>
                    <span class="ml-2 text-sm text-gray-600 font-medium">Ingat Saya</span>
                </label>
                
                <?php if (setting('Auth.allowMagicLinkLogins')) : ?>
                    <a href="<?= url_to('magic-link') ?>" class="text-sm text-[#E3943B] hover:text-orange-700 font-bold">Lupa Password?</a>
                <?php endif ?>
            </div>
        <?php endif; ?>

        <!-- Submit Button -->
        <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg text-sm font-bold text-white bg-[#001B48] hover:bg-blue-900 focus:outline-none focus:ring-4 focus:ring-blue-200 transition transform hover:-translate-y-0.5">
            Masuk Sekarang
        </button>

        <!-- Register Link -->
        <?php if (setting('Auth.allowRegistration')) : ?>
            <p class="text-center text-sm text-gray-600 mt-8">
                Belum punya akun? 
                <a href="<?= url_to('register') ?>" class="font-bold text-[#E3943B] hover:text-orange-700 ml-1">Daftar disini</a>
            </p>
        <?php endif ?>

    </form>

    <!-- Inisialisasi Ikon Lucide manual karena di layout auth mungkin belum ada scriptnya -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>lucide.createIcons();</script>

<?= $this->endSection() ?>