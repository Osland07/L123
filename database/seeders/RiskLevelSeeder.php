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
                'description' => 'BAHAYA (Zona Merah)! Kombinasi faktor risiko Anda sangat tinggi. Kemungkinan besar hipertensi akan atau sudah menyerang.',
                'suggestion'  => 'Wajib konsultasi ke dokter SEGERA. Jangan tunda. Perubahan gaya hidup total diperlukan untuk mencegah stroke/jantung.',
            ],
        ];

        foreach ($levels as $level) {
            RiskLevel::create($level);
        }
    }
}