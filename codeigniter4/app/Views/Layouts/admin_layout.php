<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?></title>
    
    <!-- Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS (No Build) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            blue: '#001B48',
                            orange: '#E3943B',
                            white: '#FFFFFF',
                        },
                        border: '#e4e4e7', 
                        background: '#f8fafc', // Slate 50
                        foreground: '#001B48', // Text using Dark Blue for readability instead of pure black
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { font-family: 'Poppins', sans-serif; }
        [x-cloak] { display: none !important; }
        /* Custom SweetAlert Font */
        .swal2-popup { font-family: 'Poppins', sans-serif !important; }
    </style>
</head>
<body class="bg-background text-foreground antialiased">

    <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">
        
        <!-- Sidebar (Biru #001B48) -->
        <aside class="absolute inset-y-0 left-0 z-50 w-64 bg-brand-blue text-white transition-transform duration-300 ease-in-out lg:static lg:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            
            <!-- Logo Area -->
            <div class="flex items-center justify-center h-24 border-b border-white/10">
                <a href="/admin" class="flex items-center">
                    <img src="/logo.png" alt="Logo" class="h-12 w-auto mr-3">
                    <span class="text-2xl font-bold tracking-wide text-white">Tensi<span class="text-brand-orange">Track</span></span>
                </a>
            </div>

            <!-- Menu -->
            <nav class="p-4 space-y-2">
                <div class="px-4 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                    Menu Utama
                </div>

                <!-- Dashboard -->
                <?php $uri = service('uri'); ?>
                <a href="/admin" class="flex items-center px-4 py-3 text-sm font-medium <?= $uri->getSegment(2) == '' ? 'text-brand-orange bg-white/10' : 'text-gray-300 hover:text-brand-orange hover:bg-white/5' ?> rounded-lg transition-colors">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 mr-3"></i>
                    Dashboard
                </a>

                <!-- Manajemen Pengguna -->
                <a href="/admin/users" class="flex items-center px-4 py-3 text-sm font-medium <?= $uri->getSegment(2) == 'users' ? 'text-brand-orange bg-white/10' : 'text-gray-300 hover:text-brand-orange hover:bg-white/5' ?> rounded-lg transition-colors">
                    <i data-lucide="users" class="w-5 h-5 mr-3"></i>
                    Manajemen Pengguna
                </a>
                
                <!-- Tingkat Risiko -->
                <a href="/admin/risk-levels" class="flex items-center px-4 py-3 text-sm font-medium <?= $uri->getSegment(2) == 'risk-levels' ? 'text-brand-orange bg-white/10' : 'text-gray-300 hover:text-brand-orange hover:bg-white/5' ?> rounded-lg transition-colors">
                    <i data-lucide="bar-chart-3" class="w-5 h-5 mr-3"></i>
                    Tingkat Risiko
                </a>

                <!-- Faktor Risiko -->
                <a href="/admin/risk-factors" class="flex items-center px-4 py-3 text-sm font-medium <?= $uri->getSegment(2) == 'risk-factors' ? 'text-brand-orange bg-white/10' : 'text-gray-300 hover:text-brand-orange hover:bg-white/5' ?> rounded-lg transition-colors">
                    <i data-lucide="activity" class="w-5 h-5 mr-3"></i>
                    Faktor Risiko
                </a>

                <!-- Aturan Diagnosa -->
                <a href="/admin/rules" class="flex items-center px-4 py-3 text-sm font-medium <?= $uri->getSegment(2) == 'rules' ? 'text-brand-orange bg-white/10' : 'text-gray-300 hover:text-brand-orange hover:bg-white/5' ?> rounded-lg transition-colors">
                    <i data-lucide="git-merge" class="w-5 h-5 mr-3"></i>
                    Aturan Diagnosa
                </a>

                <!-- Riwayat Skrining -->
                <a href="/admin/history" class="flex items-center px-4 py-3 text-sm font-medium <?= $uri->getSegment(2) == 'history' ? 'text-brand-orange bg-white/10' : 'text-gray-300 hover:text-brand-orange hover:bg-white/5' ?> rounded-lg transition-colors">
                    <i data-lucide="history" class="w-5 h-5 mr-3"></i>
                    Riwayat Skrining
                </a>

                <!-- Kembali ke Beranda -->
                <a href="/" class="flex items-center px-4 py-3 text-sm font-medium text-gray-300 hover:text-brand-orange hover:bg-white/5 rounded-lg transition-colors">
                    <i data-lucide="home" class="w-5 h-5 mr-3"></i>
                    Beranda
                </a>
            </nav>

            <!-- Bottom Actions -->
            <div class="absolute bottom-0 w-full p-4 border-t border-white/10 bg-[#00153a]">
                <a href="/logout" class="flex items-center justify-center px-4 py-3 text-sm font-bold text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors shadow-md">
                    <i data-lucide="log-out" class="w-5 h-5 mr-2"></i>
                    Keluar
                </a>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col overflow-hidden relative">
            
            <!-- Top Header (White for contrast) -->
            <header class="h-16 flex items-center justify-between px-6 bg-white border-b border-border shadow-sm">
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-md hover:bg-gray-100 text-brand-blue">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
                
                <div class="flex items-center space-x-4 ml-auto">
                    <div class="text-right hidden md:block">
                        <div class="text-sm font-bold text-brand-blue">Administrator</div>
                        <div class="text-xs text-brand-orange">Super Admin</div>
                    </div>
                    <div class="w-10 h-10 bg-brand-blue text-brand-orange rounded-full flex items-center justify-center font-bold border-2 border-brand-orange">
                        A
                    </div>
                </div>
            </header>

            <!-- Content Scrollable Area -->
            <main class="flex-1 overflow-y-auto p-6 lg:p-8">
                <?= $this->renderSection('content') ?>
            </main>

        </div>
        
        <!-- Mobile Overlay -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity 
             class="fixed inset-0 z-40 bg-black/50 lg:hidden"></div>
    </div>

    <!-- Panggil File JS Kustom -->
    <script src="/js/app.js"></script>

    <script>
        // Paksa render ikon jika app.js belum sempat
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
        
        // Check for Flashdata Success
        <?php if (session()->getFlashdata('message')) : ?>
            showToast('success', '<?= session()->getFlashdata('message') ?>');
        <?php endif; ?>

        // Check for Flashdata Error
        <?php if (session()->getFlashdata('error')) : ?>
            showToast('error', '<?= session()->getFlashdata('error') ?>');
        <?php endif; ?>
        
        // Check for Validation Errors (Array)
        <?php if (session()->getFlashdata('errors')) : ?>
            showToast('error', 'Terjadi kesalahan validasi', 'Silakan periksa kembali inputan Anda.');
        <?php endif; ?>
    </script>
</body>
</html>