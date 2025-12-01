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
            ],
            [
                'code' => 'E02',
                'name' => 'Terdapat anggota keluarga inti (ayah, ibu, kakak/adik) yang memiliki riwayat penyakit tekanan darah tinggi (hipertensi)',
                'question_text' => 'Apakah ada anggota keluarga inti Anda (ayah, ibu, kakak/adik) yang memiliki riwayat tekanan darah tinggi (hipertensi)?',
            ],
            [
                'code' => 'E03',
                'name' => 'Indeks massa tubuh termasuk dalam kategori obesitas (IMT ≥ 25)',
                'question_text' => 'Apakah Indeks Massa Tubuh (IMT) Anda termasuk dalam kategori obesitas (IMT ≥ 25)?',
            ],
            [
                'code' => 'E04',
                'name' => 'Memiliki kebiasaan merokok (tembakau/elektrik)',
                'question_text' => 'Apakah Anda memiliki kebiasaan merokok (tembakau, elektrik, atau sejenisnya)?',
            ],
            [
                'code' => 'E05',
                'name' => 'Memiliki kebiasaan mengonsumsi minuman beralkohol',
                'question_text' => 'Apakah Anda memiliki kebiasaan mengonsumsi minuman beralkohol?',
            ],
            [
                'code' => 'E06',
                'name' => 'Memiliki kebiasaan mengonsumsi minuman berenergi seperti kratindeng, extrajoss',
                'question_text' => 'Apakah Anda sering mengonsumsi minuman berenergi (seperti Kratingdaeng, Extra Joss, dll)?',
            ],
            [
                'code' => 'E07',
                'name' => 'Memiliki kebiasaan mengonsumsi minuman kafein seperti kopi atau teh kental',
                'question_text' => 'Apakah Anda sering mengonsumsi minuman berkafein tinggi (seperti kopi atau teh kental)?',
            ],
            [
                'code' => 'E08',
                'name' => 'Memiliki kebiasaan mengonsumsi makanan tinggi garam dan lemak seperti mie instan, chiki, keripik, gorengan, sosis, nugget, basreng',
                'question_text' => 'Apakah Anda sering mengonsumsi makanan tinggi garam dan lemak (misal: mie instan, chiki, keripik, gorengan, sosis, nugget)?',
            ],
            [
                'code' => 'E09',
                'name' => 'Jarang melakukan aktivitas fisik atau berolahraga seperti jogging, senam, bersepeda',
                'question_text' => 'Apakah Anda jarang melakukan aktivitas fisik atau berolahraga (misal: jogging, senam, bersepeda)?',
            ],
            [
                'code' => 'E10',
                'name' => 'Memiliki pola istirahat yang tidak teratur (sering begadang)',
                'question_text' => 'Apakah Anda memiliki pola istirahat yang tidak teratur atau sering begadang?',
            ],
            [
                'code' => 'E11',
                'name' => 'Sering merasa stres ekstrim, tertekan, atau cemas berlebih',
                'question_text' => 'Apakah Anda sering merasa stres ekstrem, tertekan, atau cemas berlebihan?',
            ],
        ];

        foreach ($factors as $factor) {
            RiskFactor::firstOrCreate(['code' => $factor['code']], $factor);
        }
    }
}
