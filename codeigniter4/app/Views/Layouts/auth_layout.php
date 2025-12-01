<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> - TensiTrack</title>
    
    <!-- Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Poppins', 'sans-serif'] },
                    colors: {
                        brand: {
                            blue: '#001B48',
                            orange: '#E3943B',
                            white: '#FFFFFF',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
        /* Custom Scrollbar untuk form panjang */
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 10px; }
    </style>
</head>
<body class="bg-gray-50 h-screen w-full overflow-hidden flex flex-col justify-center items-center">

    <!-- Auth Container -->
    <div class="w-full max-w-md px-4 h-full max-h-screen flex flex-col justify-center">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100 flex flex-col max-h-[90vh]">
            
            <!-- Header: Logo & Welcome (Fixed Height) -->
            <div class="bg-[#001B48] p-6 text-center relative overflow-hidden flex-shrink-0">
                <!-- Decor -->
                <div class="absolute top-0 left-0 w-24 h-24 bg-[#E3943B] rounded-full opacity-20 -translate-x-10 -translate-y-10 blur-2xl"></div>
                <div class="absolute bottom-0 right-0 w-32 h-32 bg-blue-400 rounded-full opacity-20 translate-x-10 translate-y-10 blur-2xl"></div>

                <a href="/" class="inline-flex items-center justify-center relative z-10 mb-2">
                    <img src="/logo.png" alt="TensiTrack Logo" class="h-12 w-auto">
                    <span class="ml-3 text-2xl font-bold text-white tracking-wide">Tensi<span class="text-[#E3943B]">Track</span></span>
                </a>
                
                <div class="relative z-10">
                    <?= $this->renderSection('header') ?>
                </div>
            </div>

            <!-- Form Area (Scrollable) -->
            <div class="p-6 md:p-8 overflow-y-auto custom-scrollbar">
                <?= $this->renderSection('main') ?>
            </div>
            
        </div>

        <!-- Simple Footer -->
        <div class="text-center py-4 text-gray-400 text-[10px] flex-shrink-0">
            &copy; <?= date('Y') ?> TensiTrack. All rights reserved.
        </div>
    </div>

</body>
</html>