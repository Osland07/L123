<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RiskFactor;

class RiskFactorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan tabel kosong sebelum diisi ulang agar tidak duplikat
        RiskFactor::truncate();

        $factors = [
            // --- KATEGORI MEDIS (A) ---
            [
                'code' => 'E01',
                'category' => 'MEDIS',
                'name' => 'Tekanan darah meningkat (121-139 / 81-89 mmHg)',
                'question_text' => 'Apakah Anda memiliki riwayat tekanan darah sistolik antara 121-139 mmHg atau diastolik antara 81-89 mmHg?',
                'medical_explanation' => 'Tekanan darah pre-hipertensi adalah sinyal peringatan dini. Pembuluh darah Anda mulai mengalami tekanan berlebih yang jika dibiarkan akan merusak organ vital.',
                'recommendation' => 'Lakukan pemantauan tekanan darah rutin setiap minggu. Mulai kurangi konsumsi garam < 1 sendok teh per hari.',
            ],
            [
                'code' => 'E02',
                'category' => 'MEDIS',
                'name' => 'Riwayat hipertensi pada keluarga inti',
                'question_text' => 'Apakah ada anggota keluarga inti Anda (ayah, ibu, kakak/adik) yang memiliki riwayat tekanan darah tinggi?',
                'medical_explanation' => 'Faktor genetik membuat tubuh Anda lebih sensitif terhadap garam dan stres. Risiko Anda terkena hipertensi 2-3x lebih tinggi dibanding orang tanpa riwayat keluarga.',
                'recommendation' => 'Karena Anda memiliki bakat genetik, Anda harus lebih ketat menjaga gaya hidup dibanding orang lain. Jangan remehkan kenaikan berat badan sedikitpun.',
            ],
            [
                'code' => 'E03',
                'category' => 'MEDIS',
                'name' => 'Obesitas (IMT ≥ 25)',
                'question_text' => 'Apakah Indeks Massa Tubuh (IMT) Anda termasuk dalam kategori obesitas (IMT ≥ 25)?',
                'medical_explanation' => 'Lemak tubuh berlebih, terutama di perut, memproduksi hormon yang mengeraskan pembuluh darah dan meningkatkan resistensi insulin.',
                'recommendation' => 'Targetkan penurunan berat badan 5-10% dalam 3 bulan ke depan. Fokus pada diet defisit kalori dan jalan kaki minimal 30 menit sehari.',
            ],
            [
                'code' => 'E12',
                'category' => 'MEDIS',
                'name' => 'Riwayat Diabetes / Gula Darah Tinggi',
                'question_text' => 'Apakah Anda memiliki riwayat diabetes atau kadar gula darah tinggi?',
                'medical_explanation' => 'Gula darah tinggi merusak lapisan dalam pembuluh darah (endotel) dan ginjal, yang merupakan organ pengatur tekanan darah utama.',
                'recommendation' => 'Kontrol gula darah Anda dengan ketat. Kurangi karbohidrat sederhana (nasi putih, tepung, gula pasir). Cek HbA1c setiap 3 bulan.',
            ],
            [
                'code' => 'E13',
                'category' => 'MEDIS',
                'name' => 'Riwayat Kolesterol Tinggi',
                'question_text' => 'Apakah Anda memiliki riwayat kolesterol tinggi (hiperkolesterolemia)?',
                'medical_explanation' => 'Kolesterol jahat (LDL) menumpuk menjadi plak di dinding arteri, membuat pembuluh darah kaku dan sempit, memaksa jantung memompa lebih kuat.',
                'recommendation' => 'Hindari makanan bersantan, jeroan, dan gorengan. Konsumsi oatmeal atau makanan berserat tinggi untuk mengikat kolesterol.',
            ],
            [
                'code' => 'E14',
                'category' => 'MEDIS',
                'name' => 'Riwayat Gangguan Ginjal',
                'question_text' => 'Apakah Anda pernah mengalami gangguan ginjal (infeksi saluran kemih berulang, batu ginjal)?',
                'medical_explanation' => 'Ginjal mengatur volume cairan dan garam di tubuh. Gangguan fungsi ginjal sedikit saja bisa langsung menyebabkan lonjakan tekanan darah.',
                'recommendation' => 'Perbanyak minum air putih minimal 2-3 liter per hari. Jangan menahan buang air kecil. Batasi konsumsi protein hewani berlebihan.',
            ],
            [
                'code' => 'E15',
                'category' => 'MEDIS',
                'name' => 'Sleep Apnea / Mendengkur Keras',
                'question_text' => 'Apakah Anda sering mendengkur keras saat tidur atau pernah mengalami henti napas sesaat saat tidur?',
                'medical_explanation' => 'Henti napas saat tidur (Sleep Apnea) menyebabkan penurunan oksigen drastis yang memicu pelepasan adrenalin, membuat tekanan darah tetap tinggi bahkan saat tidur.',
                'recommendation' => 'Jika Anda kelebihan berat badan, turunkan berat badan. Tidurlah dengan posisi miring. Jika parah, konsultasikan ke dokter THT.',
            ],

            // --- KATEGORI GAYA HIDUP (B) ---
            [
                'code' => 'E04',
                'category' => 'LIFESTYLE',
                'name' => 'Kebiasaan Merokok / Vape',
                'question_text' => 'Apakah Anda merokok (tembakau, elektrik/vape)?',
                'medical_explanation' => 'Nikotin menyebabkan penyempitan pembuluh darah seketika dan merusak dinding arteri secara permanen. Vape juga mengandung zat kimia berbahaya bagi jantung.',
                'recommendation' => 'Berhenti merokok adalah langkah terbaik. Jika sulit, kurangi jumlah batang rokok secara bertahap. Hindari merokok saat bangun tidur.',
            ],
            [
                'code' => 'E05',
                'category' => 'LIFESTYLE',
                'name' => 'Konsumsi Alkohol',
                'question_text' => 'Apakah Anda rutin mengonsumsi minuman beralkohol?',
                'medical_explanation' => 'Alkohol meningkatkan aktivitas saraf simpatis yang memacu jantung. Konsumsi rutin jangka panjang merusak otot jantung.',
                'recommendation' => 'Batasi konsumsi alkohol. Pria maksimal 2 gelas/hari, wanita 1 gelas/hari. Sebaiknya hindari sama sekali.',
            ],
            [
                'code' => 'E09',
                'category' => 'LIFESTYLE',
                'name' => 'Kurang Aktivitas Fisik (Sedenter)',
                'question_text' => 'Apakah Anda jarang berolahraga (kurang dari 30 menit, 3x seminggu)?',
                'medical_explanation' => 'Jantung yang tidak terlatih harus memompa lebih keras untuk mengalirkan darah, memberikan tekanan lebih besar pada arteri.',
                'recommendation' => 'Mulai olahraga ringan seperti jalan cepat, bersepeda, atau berenang selama 30 menit, minimal 3 kali seminggu.',
            ],
            [
                'code' => 'E10',
                'category' => 'LIFESTYLE',
                'name' => 'Pola Tidur Buruk / Begadang',
                'question_text' => 'Apakah Anda sering tidur larut malam atau tidur kurang dari 6-7 jam sehari?',
                'medical_explanation' => 'Saat tidur, tekanan darah tubuh seharusnya turun (dipping). Kurang tidur membuat tekanan darah terus tinggi selama 24 jam.',
                'recommendation' => 'Terapkan "Sleep Hygiene": Matikan gadget 1 jam sebelum tidur, gelapkan kamar, dan usahakan tidur & bangun di jam yang sama.',
            ],
            [
                'code' => 'E16',
                'category' => 'LIFESTYLE',
                'name' => 'Perokok Pasif',
                'question_text' => 'Apakah Anda sering terpapar asap rokok orang lain di lingkungan kerja atau rumah?',
                'medical_explanation' => 'Asap rokok orang lain (secondhand smoke) mengandung racun yang sama berbahayanya dan tetap dapat merusak pembuluh darah Anda.',
                'recommendation' => 'Hindari ruangan penuh asap rokok. Tegur dengan sopan atau menyingkirlah saat ada orang merokok di dekat Anda.',
            ],

            // --- KATEGORI POLA MAKAN (C) ---
            [
                'code' => 'E06',
                'category' => 'DIET',
                'name' => 'Minuman Berenergi',
                'question_text' => 'Apakah Anda sering mengonsumsi minuman berenergi (Kratingdaeng, Extra Joss, dll)?',
                'medical_explanation' => 'Kandungan kafein dosis tinggi dan taurin memicu lonjakan detak jantung dan tekanan darah secara akut.',
                'recommendation' => 'Ganti minuman berenergi dengan air kelapa muda atau jus buah segar tanpa gula sebagai penambah energi alami.',
            ],
            [
                'code' => 'E07',
                'category' => 'DIET',
                'name' => 'Kafein Berlebih (Kopi/Teh Kental)',
                'question_text' => 'Apakah Anda minum kopi lebih dari 2 gelas sehari atau teh yang sangat kental?',
                'medical_explanation' => 'Kafein memblokir hormon yang menjaga pembuluh darah tetap lebar, menyebabkan penyempitan sementara.',
                'recommendation' => 'Batasi kopi maksimal 1-2 cangkir per hari. Pilih kopi rendah kafein (decaf) jika memungkinkan.',
            ],
            [
                'code' => 'E08',
                'category' => 'DIET',
                'name' => 'Konsumsi Tinggi Garam (Asin)',
                'question_text' => 'Apakah Anda sering makan makanan asin, keripik, mie instan, atau makanan kaleng?',
                'medical_explanation' => 'Garam (Natrium) bersifat menarik air. Terlalu banyak garam membuat volume darah meningkat sehingga tekanan darah naik.',
                'recommendation' => 'Kurangi penggunaan garam dapur, saus sambal, dan kecap. Hindari makanan kemasan/kalengan. Perbanyak bumbu rempah alami.',
            ],
            [
                'code' => 'E17',
                'category' => 'DIET',
                'name' => 'Kurang Sayur & Buah',
                'question_text' => 'Apakah Anda jarang mengonsumsi sayur dan buah setiap hari?',
                'medical_explanation' => 'Sayur dan buah kaya Kalium, yang fungsinya menetralkan efek buruk Garam (Natrium) dan melemaskan pembuluh darah.',
                'recommendation' => 'Wajib makan pisang, alpukat, bayam, atau tomat setiap hari. Targetkan piring makan Anda setengahnya berisi sayur.',
            ],
            [
                'code' => 'E18',
                'category' => 'DIET',
                'name' => 'Minuman Manis / Gula Tinggi',
                'question_text' => 'Apakah Anda sering minum minuman manis (boba, soda, teh manis) hampir setiap hari?',
                'medical_explanation' => 'Gula berlebih (fruktosa) meningkatkan asam urat yang menghambat produksi Nitric Oxide (zat pelebar pembuluh darah).',
                'recommendation' => 'Batasi gula tambahan maksimal 4 sendok teh sehari. Pilih air putih atau teh tawar.',
            ],

            // --- KATEGORI PSIKOLOGIS (D) ---
            [
                'code' => 'E11',
                'category' => 'PSIKOLOGIS',
                'name' => 'Stres / Cemas Berlebih',
                'question_text' => 'Apakah Anda sering merasa stres berat, tertekan, atau cemas berlebihan?',
                'medical_explanation' => 'Stres kronis membanjiri tubuh dengan hormon kortisol dan adrenalin yang mempercepat detak jantung dan menyempitkan pembuluh darah.',
                'recommendation' => 'Luangkan waktu 15 menit sehari untuk relaksasi, meditasi, atau hobi. Jangan ragu curhat ke teman atau profesional jika beban terasa berat.',
            ],
            [
                'code' => 'E19',
                'category' => 'PSIKOLOGIS',
                'name' => 'Mudah Marah / Emosional',
                'question_text' => 'Apakah Anda termasuk orang yang mudah marah, tidak sabaran, atau sering memendam emosi?',
                'medical_explanation' => 'Sifat agresif/mudah marah dikaitkan dengan risiko hipertensi yang lebih tinggi pada usia muda karena reaktivitas kardiovaskular yang berlebihan.',
                'recommendation' => 'Latih manajemen amarah (Anger Management). Tarik napas dalam-dalam saat emosi terpancing.',
            ],
            [
                'code' => 'E20',
                'category' => 'PSIKOLOGIS',
                'name' => 'Penggunaan Obat Tertentu',
                'question_text' => 'Apakah Anda rutin mengonsumsi obat antinyeri (NSAID), steroid, atau pil KB?',
                'medical_explanation' => 'Beberapa obat seperti pereda nyeri (ibuprofen) dan steroid menyebabkan tubuh menahan air dan garam, memicu kenaikan tensi.',
                'recommendation' => 'Konsultasikan dengan dokter apakah ada alternatif obat yang lebih aman untuk tekanan darah. Jangan minum obat warung jangka panjang tanpa resep.',
            ],
        ];

        foreach ($factors as $factor) {
            RiskFactor::updateOrCreate(['code' => $factor['code']], $factor);
        }
    }
}