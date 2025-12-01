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
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
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
                        }
                    },
                    animation: {
                        'slide-left': 'slideLeft 1s ease-out forwards',
                        'slide-right': 'slideRight 1s ease-out forwards',
                        'fade-up': 'fadeUp 0.8s ease-out forwards',
                    },
                    keyframes: {
                        slideLeft: {
                            '0%': { opacity: '0', transform: 'translateX(50px)' },
                            '100%': { opacity: '1', transform: 'translateX(0)' },
                        },
                        slideRight: {
                            '0%': { opacity: '0', transform: 'translateX(-50px)' },
                            '100%': { opacity: '1', transform: 'translateX(0)' },
                        },
                        fadeUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js Plugins -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <!-- Alpine.js Core -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body x-data="{ mobileMenuOpen: false, ...$store.global }" class="bg-gray-50 text-[#001B48] text-base antialiased flex flex-col min-h-screen">

    <!-- Navbar (Biru) -->
    <nav class="bg-brand-blue sticky top-0 z-50 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="flex items-center">
                        <img src="/logo.png" alt="Logo" class="h-14 w-auto">
                        <span class="ml-3 text-2xl font-bold text-white tracking-wide">Tensi<span class="text-brand-orange">Track</span></span>
                    </a>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-8">
                        <a href="/" class="text-brand-orange hover:text-white px-3 py-2 rounded-md text-base font-bold transition-colors whitespace-nowrap">Home</a>
                        
                        <!-- Dropdown Layanan -->
                        <div x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" class="relative">
                            <button class="text-brand-orange hover:text-white px-3 py-2 rounded-md text-base font-bold transition-colors flex items-center whitespace-nowrap">
                                Layanan <i data-lucide="chevron-down" class="ml-1 w-4 h-4"></i>
                            </button>
                            
                            <div x-show="open" x-transition.opacity.duration.200
                                 class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                                <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                    <button @click="if(window.location.pathname !== '/') { window.location.href = '/#kalkulator-bmi'; } else { document.getElementById('kalkulator-bmi').scrollIntoView({ behavior: 'smooth', block: 'center' }); open = false; }" class="block w-full text-left px-4 py-2 text-base text-gray-700 hover:bg-gray-100" role="menuitem">Kalkulator BMI</button>
                                    <a href="/#diagnosis" class="block w-full text-left px-4 py-2 text-base text-gray-700 hover:bg-gray-100" role="menuitem">Skrining Hipertensi</a>
                                </div>
                            </div>
                        </div>

                        <a href="/#alur-interaksi" @click.prevent="if(window.location.pathname !== '/') { window.location.href = '/#alur-interaksi'; } else { document.getElementById('alur-interaksi').scrollIntoView({ behavior: 'smooth', block: 'center' }); }" class="text-brand-orange hover:text-white px-3 py-2 rounded-md text-base font-bold transition-colors whitespace-nowrap">Alur Kerja</a>
                    </div>
                </div>

                <!-- Auth Buttons (Desktop) -->
                <div class="hidden md:flex items-center space-x-4">
                    <?php if (auth()->loggedIn()) : ?>
                        <a href="/profile" class="text-white bg-brand-orange px-4 py-2 rounded-full font-bold hover:bg-orange-600 transition flex items-center">
                            <i data-lucide="user" class="w-4 h-4 mr-2"></i> Profil Saya
                        </a>
                        <a href="/logout" class="bg-[#E3943B] text-white px-6 py-2 rounded-full font-bold hover:bg-orange-600 transition shadow-md">
                            Keluar
                        </a>
                    <?php else : ?>
                        <a href="/login" class="bg-[#E3943B] text-white px-6 py-2 rounded-full font-bold hover:bg-orange-600 transition shadow-md">
                            Login
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Mobile menu button -->
                <div class="-mr-2 flex md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="bg-brand-blue inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-white/10 focus:outline-none">
                        <i x-show="!mobileMenuOpen" data-lucide="menu" class="w-6 h-6"></i>
                        <i x-show="mobileMenuOpen" data-lucide="x" class="w-6 h-6"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" x-collapse class="md:hidden bg-brand-blue border-t border-white/10">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="/" class="text-brand-orange hover:text-white block px-3 py-2 rounded-md text-base font-bold">Home</a>
                <button @click="if(window.location.pathname !== '/') { window.location.href = '/#kalkulator-bmi'; } else { document.getElementById('kalkulator-bmi').scrollIntoView({ behavior: 'smooth', block: 'center' }); mobileMenuOpen = false; }" class="text-brand-orange hover:text-white block w-full text-left px-3 py-2 rounded-md text-base font-bold">Kalkulator BMI</button>
                
                <?php if (auth()->loggedIn()) : ?>
                    <a href="/#diagnosis" class="text-brand-orange hover:text-white block w-full text-left px-3 py-2 rounded-md text-base font-bold">Skrining Hipertensi</a>
                <?php else : ?>
                    <a href="/login" class="text-brand-orange hover:text-white block px-3 py-2 rounded-md text-base font-bold">Skrining Hipertensi</a>
                <?php endif; ?>
                
                <button @click="if(window.location.pathname !== '/') { window.location.href = '/#alur-interaksi'; } else { document.getElementById('alur-interaksi').scrollIntoView({ behavior: 'smooth', block: 'center' }); mobileMenuOpen = false; }" class="text-brand-orange hover:text-white block w-full text-left px-3 py-2 rounded-md text-base font-bold">Alur Kerja</button>

                <?php if (auth()->loggedIn()) : ?>
                    <a href="/profile" @click="mobileMenuOpen = false" class="text-white bg-brand-orange block px-3 py-2 rounded-md text-base font-medium mt-4 text-center">Profil Saya</a>
                    <a href="/logout" @click="mobileMenuOpen = false" class="text-white bg-[#E3943B] block px-3 py-2 rounded-md text-base font-medium mt-2 text-center">Keluar</a>
                <?php else : ?>
                    <a href="/login" @click="mobileMenuOpen = false" class="text-white bg-[#E3943B] block px-3 py-2 rounded-md text-base font-medium mt-4 text-center">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow">
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Footer (Hidden on Screening Page) -->
    <?php $uri = service('uri'); ?>
    <?php if ($uri->getSegment(1) != 'screening') : ?>
    <footer class="bg-brand-blue text-white py-12 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 mb-8">
                
                <!-- Column 1: Logo & Explanation (Full width on mobile) -->
                <div class="lg:col-span-1">
                    <a href="/" class="flex items-center mb-4">
                        <img src="/logo.png" alt="Logo" class="h-10 w-auto">
                        <span class="ml-2 text-xl font-bold text-white tracking-wide">Tensi<span class="text-brand-orange">Track</span></span>
                    </a>
                    <p class="text-sm text-gray-300 leading-relaxed">
                        TensiTrack membantu Anda memprediksi potensi risiko hipertensi berdasarkan gaya hidup Anda.
                        Deteksi dini untuk hidup yang lebih sehat.
                    </p>
                </div>

                <!-- Wrapper for Links (Side-by-side on mobile, separate cols on desktop) -->
                <div class="col-span-1 lg:col-span-2 grid grid-cols-2 gap-8">
                    <!-- Column 2: Tautan Cepat -->
                    <div>
                        <h4 class="text-lg font-bold text-white mb-4">Tautan Cepat</h4>
                        <ul class="space-y-3">
                            <li><a href="/" class="text-gray-300 hover:text-white transition-colors text-sm">Home</a></li>
                            <li><a href="/#alur-interaksi" class="text-gray-300 hover:text-white transition-colors text-sm">Alur Kerja</a></li>
                            <li><a href="/#faq" class="text-gray-300 hover:text-white transition-colors text-sm">FAQ</a></li>
                        </ul>
                    </div>

                    <!-- Column 3: Layanan Kami -->
                    <div>
                        <h4 class="text-lg font-bold text-white mb-4">Layanan Kami</h4>
                        <ul class="space-y-3">
                            <li><a href="/#kalkulator-bmi" class="text-gray-300 hover:text-white transition-colors text-sm">Kalkulator BMI</a></li>
                            <li><a href="/#diagnosis" class="text-gray-300 hover:text-white transition-colors text-sm">Skrining Hipertensi</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Column 4: Kontak Kami (Full width on mobile) -->
                <div class="lg:col-span-1">
                    <h4 class="text-lg font-bold text-white mb-4">Kontak Kami</h4>
                    <ul class="space-y-3 text-sm text-gray-300">
                        <li class="flex items-center"><i data-lucide="mail" class="w-4 h-4 mr-2 text-brand-orange"></i> info@tensitrack.com</li>
                        <li class="flex items-center"><i data-lucide="phone" class="w-4 h-4 mr-2 text-brand-orange"></i> +62 812 3456 7890</li>
                        <li class="flex items-start"><i data-lucide="map-pin" class="w-4 h-4 mr-2 text-brand-orange mt-1"></i> Jl. Kesehatan No. 123, Kota Sehat, Indonesia</li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-700 pt-6 text-center">
                <p class="text-sm text-gray-400">&copy; <?= date('Y') ?> TensiTrack. All rights reserved.</p>
            </div>
        </div>
    </footer>
    <?php endif; ?>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
