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
        $factors = [
            [
                'code' => 'E01',
                'name' => 'Tekanan darah yang terukur mengalami peningkatan (sistolik 120 – 139 mmHg) dan/atau (diastolik 80 – 89 mmHg)',
                'question_text' => 'Apakah Anda memiliki riwayat tekanan darah sistolik antara 120-139 mmHg atau diastolik antara 80-89 mmHg?',
                'medical_explanation' => 'Tekanan darah yang meningkat, meskipun belum mencapai ambang hipertensi, menandakan risiko lebih tinggi untuk berkembang menjadi hipertensi penuh di masa mendatang dan memerlukan perhatian serta perubahan gaya hidup.',
            ],
            [
                'code' => 'E02',
                'name' => 'Terdapat anggota keluarga inti (ayah, ibu, kakak/adik) yang memiliki riwayat penyakit tekanan darah tinggi (hipertensi)',
                'question_text' => 'Apakah ada anggota keluarga inti Anda (ayah, ibu, kakak/adik) yang memiliki riwayat tekanan darah tinggi (hipertensi)?',
                'medical_explanation' => 'Riwayat hipertensi dalam keluarga menunjukkan adanya kecenderungan genetik. Faktor keturunan dapat meningkatkan risiko Anda terkena hipertensi, meskipun gaya hidup tetap memegang peran penting.',
            ],
            [
                'code' => 'E03',
                'name' => 'Indeks massa tubuh termasuk dalam kategori obesitas (IMT ≥ 25)',
                'question_text' => 'Apakah Indeks Massa Tubuh (IMT) Anda termasuk dalam kategori obesitas (IMT ≥ 25)?',
                'medical_explanation' => 'Obesitas (IMT ≥ 25) membebani jantung dan pembuluh darah. Kelebihan berat badan seringkali terkait dengan peningkatan volume darah, resistensi insulin, dan peradangan, yang semuanya berkontribusi pada peningkatan tekanan darah.',
            ],
            [
                'code' => 'E04',
                'name' => 'Memiliki kebiasaan merokok (tembakau/elektrik)',
                'question_text' => 'Apakah Anda memiliki kebiasaan merokok (tembakau, elektrik, atau sejenisnya)?',
                'medical_explanation' => 'Zat kimia dalam rokok, seperti nikotin, merusak dinding pembuluh darah, menyempitkannya, dan membuat jantung bekerja lebih keras. Ini secara langsung meningkatkan tekanan darah dan risiko penyakit kardiovaskular.',
            ],
            [
                'code' => 'E05',
                'name' => 'Memiliki kebiasaan mengonsumsi minuman beralkohol',
                'question_text' => 'Apakah Anda memiliki kebiasaan mengonsumsi minuman beralkohol?',
                'medical_explanation' => 'Konsumsi alkohol berlebihan dapat meningkatkan tekanan darah dengan memicu pelepasan hormon yang menyempitkan pembuluh darah, serta dapat merusak organ-organ yang terlibat dalam pengaturan tekanan darah.',
            ],
            [
                'code' => 'E06',
                'name' => 'Memiliki kebiasaan mengonsumsi minuman berenergi seperti kratindeng, extrajoss',
                'question_text' => 'Apakah Anda sering mengonsumsi minuman berenergi (seperti Kratingdaeng, Extra Joss, dll)?',
                'medical_explanation' => 'Minuman berenergi umumnya mengandung kafein tinggi dan stimulan lain yang dapat meningkatkan detak jantung dan tekanan darah secara akut. Konsumsi rutin dapat berkontribusi pada risiko hipertensi.',
            ],
            [
                'code' => 'E07',
                'name' => 'Memiliki kebiasaan mengonsumsi minuman kafein seperti kopi atau teh kental',
                'question_text' => 'Apakah Anda sering mengonsumsi minuman berkafein tinggi (seperti kopi atau teh kental)?',
                'medical_explanation' => 'Kafein dapat menyebabkan peningkatan tekanan darah sementara. Pada individu yang sensitif atau dengan konsumsi berlebihan, ini dapat berkontribusi pada pengembangan hipertensi jangka panjang.',
            ],
            [
                'code' => 'E08',
                'name' => 'Memiliki kebiasaan mengonsumsi makanan tinggi garam dan lemak seperti mie instan, chiki, keripik, gorengan, sosis, nugget, basreng',
                'question_text' => 'Apakah Anda sering mengonsumsi makanan tinggi garam dan lemak (misal: mie instan, chiki, keripik, gorengan, sosis, nugget)?',
                'medical_explanation' => 'Diet tinggi garam menyebabkan tubuh menahan cairan, yang meningkatkan volume darah dan tekanan pada pembuluh darah. Makanan tinggi lemak jenuh juga berkontribusi pada aterosklerosis (pengerasan pembuluh darah).',
            ],
            [
                'code' => 'E09',
                'name' => 'Jarang melakukan aktivitas fisik atau berolahraga seperti jogging, senam, bersepeda',
                'question_text' => 'Apakah Anda jarang melakukan aktivitas fisik atau berolahraga (misal: jogging, senam, bersepeda)?',
                'medical_explanation' => 'Kurangnya aktivitas fisik dapat menyebabkan peningkatan berat badan, penurunan kebugaran jantung, dan efek negatif pada pembuluh darah, semuanya meningkatkan risiko hipertensi.',
            ],
            [
                'code' => 'E10',
                'name' => 'Memiliki pola istirahat yang tidak teratur (sering begadang)',
                'question_text' => 'Apakah Anda memiliki pola istirahat yang tidak teratur atau sering begadang?',
                'medical_explanation' => 'Tidur yang tidak cukup atau pola tidur yang buruk dapat mengganggu regulasi hormon stres dan tekanan darah. Kurang tidur kronis dikaitkan dengan peningkatan risiko hipertensi.',
            ],
            [
                'code' => 'E11',
                'name' => 'Sering merasa stres ekstrim, tertekan, atau cemas berlebih',
                'question_text' => 'Apakah Anda sering merasa stres ekstrem, tertekan, atau cemas berlebihan?',
                'medical_explanation' => 'Stres kronis memicu respons "lawan atau lari" tubuh, menyebabkan peningkatan detak jantung dan penyempitan pembuluh darah. Hormon stres yang dilepaskan dapat meningkatkan tekanan darah secara terus-menerus.',
            ],
        ];

        foreach ($factors as $factor) {
            RiskFactor::updateOrCreate(['code' => $factor['code']], $factor);
        }
    }
}
