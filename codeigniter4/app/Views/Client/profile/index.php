<?= $this->extend('Layouts/client_layout') ?>

<?= $this->section('title') ?>
Profil & Riwayat
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <?php if (session()->getFlashdata('error')): ?>
        <div class="mb-4 p-4 bg-red-100 text-red-700 border border-red-400 rounded-lg" role="alert">
            <p><?= session()->getFlashdata('error') ?></p>
        </div>
    <?php endif; ?>

    <!-- Header Mobile Only -->
    <div class="mb-6 lg:hidden">
        <h1 class="text-2xl font-bold text-[#001B48]">Halo, <?= esc(auth()->user()->username) ?></h1>
        <p class="text-gray-500 text-sm">Kelola profil dan pantau kesehatanmu.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- KOLOM KIRI: DATA DIRI (FORM) -->
        <div class="lg:col-span-5 bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-[#001B48] p-6 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold text-white">Data Diri</h2>
                    <p class="text-blue-200 text-xs">Pastikan data selalu valid.</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-white font-bold">
                    <i data-lucide="user" class="w-5 h-5"></i>
                </div>
            </div>

            <div class="p-6">
                <form action="/profile/update" method="post">
                    <?= csrf_field() ?>
                    <div class="space-y-4">
                        
                        <!-- Nama -->
                        <div class="border-b border-gray-200 pb-4 mb-4">
                            <label class="block text-base font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" name="full_name" value="<?= esc($profile['full_name'] ?? '') ?>" class="w-full rounded-lg border border-gray-400 focus:ring-[#E3943B] focus:border-[#E3943B] bg-white transition p-2 text-base" placeholder="Nama Anda" required>
                        </div>

                        <div class="grid grid-cols-2 gap-4 border-b border-gray-200 pb-4 mb-4">
                            <!-- Umur -->
                            <div>
                                <label class="block text-base font-medium text-gray-700 mb-1">Umur (Tahun)</label>
                                <input type="number" name="age" value="<?= esc($profile['age'] ?? '') ?>" class="w-full rounded-lg border border-gray-400 focus:ring-[#E3943B] focus:border-[#E3943B] bg-white transition p-2 text-base" required>
                            </div>
                            <!-- Gender -->
                            <div>
                                <label class="block text-base font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                                <select name="gender" class="w-full rounded-lg border border-gray-400 focus:ring-[#E3943B] focus:border-[#E3943B] bg-white transition p-2 text-base">
                                    <option value="L" <?= ($profile['gender'] ?? '') == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                    <option value="P" <?= ($profile['gender'] ?? '') == 'P' ? 'selected' : '' ?>>Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 border-b border-gray-200 pb-4 mb-4">
                            <!-- Tinggi -->
                            <div>
                                <label class="block text-base font-medium text-gray-700 mb-1">Tinggi (cm)</label>
                                <input type="number" name="height" value="<?= esc($profile['height'] ?? '') ?>" class="w-full rounded-lg border border-gray-400 focus:ring-[#E3943B] focus:border-[#E3943B] bg-white transition p-2 text-base" required>
                            </div>
                            <!-- Berat -->
                            <div>
                                <label class="block text-base font-medium text-gray-700 mb-1">Berat (kg)</label>
                                <input type="number" name="weight" value="<?= esc($profile['weight'] ?? '') ?>" class="w-full rounded-lg border border-gray-400 focus:ring-[#E3943B] focus:border-[#E3943B] bg-white transition p-2 text-base" placeholder="Masukkan nilai perkiraan jika tidak tahu pasti" required>
                            </div>
                        </div>

                        <!-- Tensi -->
                        <div class="pt-2 border-t border-dashed border-gray-200">
                            <label class="block text-base font-medium text-gray-700 mb-1">Tekanan Darah Terakhir (mmHg)</label>
                            <div class="flex items-center space-x-2">
                                <input type="number" name="systolic" placeholder="Sistolik (Atas)" value="<?= esc($profile['systolic'] ?? '') ?>" class="w-full rounded-lg border border-gray-400 focus:ring-[#E3943B] focus:border-[#E3943B] bg-white transition p-2 text-base">
                                <span class="text-xl font-bold text-gray-400">/</span>
                                <input type="number" name="diastolic" placeholder="Diastolik (Bawah)" value="<?= esc($profile['diastolic'] ?? '') ?>" class="w-full rounded-lg border border-gray-400 focus:ring-[#E3943B] focus:border-[#E3943B] bg-white transition p-2 text-base">
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Contoh: 120 / 80 (Opsional)</p>
                        </div>

                        <button type="submit" class="w-full py-3 bg-[#E3943B] text-white font-bold rounded-lg hover:bg-orange-600 transition shadow-md flex justify-center items-center mt-4">
                            <i data-lucide="save" class="w-4 h-4 mr-2"></i> Simpan Data Diri
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- KOLOM KANAN: STATISTIK & RIWAYAT -->
        <div class="lg:col-span-7 space-y-6">
            
            <!-- 1. Kartu Statistik (Grid 3 Kolom) -->
            <div class="grid grid-cols-3 gap-4">
                <!-- BMI -->
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 flex flex-col items-center justify-center text-center">
                    <span class="text-xs text-gray-500 font-semibold uppercase">Indeks Massa Tubuh</span>
                    <span class="text-2xl font-bold text-[#001B48] my-1"><?= $bmi ?></span>
                    <span class="text-xs px-2 py-0.5 rounded-full bg-gray-100 text-gray-600">BMI</span>
                </div>
                <!-- Kategori -->
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 flex flex-col items-center justify-center text-center">
                    <span class="text-xs text-gray-500 font-semibold uppercase">Kategori Berat</span>
                    <span class="text-lg font-bold text-[#001B48] my-1"><?= $bmi_category ?></span>
                    <?php if($bmi_category == 'Normal'): ?>
                        <i data-lucide="check-circle" class="w-5 h-5 text-green-500"></i>
                    <?php elseif($bmi_category == '-'): ?>
                        <i data-lucide="minus" class="w-5 h-5 text-gray-300"></i>
                    <?php else: ?>
                        <i data-lucide="alert-circle" class="w-5 h-5 text-yellow-500"></i>
                    <?php endif; ?>
                </div>
                <!-- Tensi -->
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 flex flex-col items-center justify-center text-center">
                    <span class="text-xs text-gray-500 font-semibold uppercase">Tensi Terakhir</span>
                    <span class="text-lg font-bold text-[#E3943B] mt-1"><?= esc($latest_result) ?></span>
                    
                    <?php 
                        $color = 'text-gray-400';
                        if ($tensi_category == 'Optimal' || $tensi_category == 'Normal' || $tensi_category == 'Optimal (Normal)') {
                            $color = 'text-green-600';
                        } elseif ($tensi_category == 'Normal Tinggi' || $tensi_category == 'Hipotensi') {
                            $color = 'text-yellow-600';
                        } elseif (stripos($tensi_category, 'Hipertensi') !== false) {
                            $color = 'text-red-600';
                        }
                    ?>
                    
                    <span class="text-xs font-bold <?= $color ?> mt-1"><?= $tensi_category ?></span>
                </div>
            </div>

            <!-- 2. Tabel Riwayat -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden flex flex-col h-[500px]"> <!-- Fixed Height -->
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="font-bold text-[#001B48]">Riwayat Skrining</h3>
                    <a href="/client/screening" class="text-xs font-medium text-[#E3943B] hover:underline flex items-center">
                        <i data-lucide="plus-circle" class="w-3 h-3 mr-1"></i> Skrining Baru
                    </a>
                </div>
                
                <div class="overflow-y-auto flex-grow p-0">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider w-16">No</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Hasil</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider w-40">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if (empty($history)): ?>
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                        Belum ada riwayat skrining. <br>
                                        <a href="/screening" class="text-[#E3943B] font-medium hover:underline mt-2 inline-block">Mulai Skrining Sekarang</a>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($history as $index => $h): ?>
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-base text-gray-500"><?= $index + 1 ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-base text-gray-900">
                                        <?= date('d M Y', strtotime($h['created_at'])) ?>
                                        <span class="block text-xs text-gray-400"><?= date('H:i', strtotime($h['created_at'])) ?> WIB</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                                            <?= stripos($h['result_level'], 'tinggi') !== false ? 'bg-red-100 text-red-800' : (stripos($h['result_level'], 'sedang') !== false ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') ?>">
                                            <?= esc($h['result_level']) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-base font-medium">
                                        <a href="/detail/<?= $h['id'] ?>" class="inline-flex items-center justify-center px-4 py-2 rounded-full bg-gray-100 text-[#001B48] text-sm font-bold hover:bg-[#001B48] hover:text-white transition shadow-sm">
                                            Detail <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>
