<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RiskLevel;

class RiskLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kosongkan tabel agar bersih
        RiskLevel::truncate();

        $levels = [
            [
                'code'        => 'H01',
                'name'        => 'Tidak Berisiko',
                'description' => 'Kondisi kesehatan Anda sangat baik. Tidak ditemukan faktor risiko signifikan yang dapat memicu hipertensi saat ini.',
                'suggestion'  => 'Pertahankan gaya hidup sehat ini! Tetap rutin berolahraga dan konsumsi makanan bergizi seimbang.',
            ],
            [
                'code'        => 'H02',
                'name'        => 'Risiko Rendah',
                'description' => 'Mulai waspada. Ditemukan sedikit faktor risiko yang jika dibiarkan dapat berkembang menjadi masalah serius.',
                'suggestion'  => 'Lakukan perubahan kecil mulai hari ini: Kurangi sedikit garam, tidur lebih teratur, dan mulai rutin jalan kaki.',
            ],
            [
                'code'        => 'H03',
                'name'        => 'Risiko Sedang',
                'description' => 'Peringatan Kuning! Anda memiliki beberapa kebiasaan atau kondisi yang secara medis terbukti memicu hipertensi.',
                'suggestion'  => 'Segera perbaiki pola hidup secara disiplin. Kurangi drastis kafein & rokok. Pantau tekanan darah seminggu sekali.',
            ],
            [
                'code'        => 'H04',
                'name'        => 'Risiko Tinggi',
                'description' => 'Anda memiliki akumulasi faktor risiko yang tergolong tinggi. Meskipun mungkin belum ada gejala, kondisi ini menempatkan tubuh Anda bekerja lebih keras dari seharusnya, yang berpotensi memicu masalah kesehatan kardiovaskular di masa depan.',
                'suggestion'  => 'Sangat disarankan untuk melakukan konsultasi dengan tenaga medis sebagai langkah antisipasi. Mulailah perbaiki pola makan, aktivitas fisik, dan istirahat Anda dari sekarang demi kesehatan jangka panjang.',
            ],
        ];

        foreach ($levels as $level) {
            RiskLevel::create($level);
        }
    }
}