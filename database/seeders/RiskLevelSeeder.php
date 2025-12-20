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
                'name'        => 'Tidak berisiko',
                'description' => 'Kondisi kesehatan Anda sangat baik. Tidak ditemukan faktor risiko signifikan yang dapat memicu hipertensi saat ini.',
                'suggestion'  => 'Pertahankan gaya hidup sehat ini! Tetap rutin berolahraga dan konsumsi makanan bergizi seimbang.',
                // Warna: HIJAU (Green)
            ],
            [
                'code'        => 'H02',
                'name'        => 'Risiko ringan',
                'description' => 'Mulai waspada. Ditemukan sedikit faktor risiko yang jika dibiarkan dapat berkembang menjadi masalah serius.',
                'suggestion'  => 'Lakukan perubahan kecil mulai hari ini: Kurangi sedikit garam, tidur lebih teratur, dan mulai rutin jalan kaki.',
                // Warna: BIRU (Blue)
            ],
            [
                'code'        => 'H03',
                'name'        => 'Risiko sedang',
                'description' => 'Peringatan Kuning! Anda memiliki beberapa kebiasaan atau kondisi yang secara medis terbukti memicu hipertensi.',
                'suggestion'  => 'Segera perbaiki pola hidup secara disiplin. Kurangi drastis kafein & rokok. Pantau tekanan darah seminggu sekali.',
                // Warna: KUNING/ORANGE (Orange)
            ],
            [
                'code'        => 'H04',
                'name'        => 'Risiko berat',
                'description' => 'BAHAYA (Zona Merah)! Kombinasi faktor risiko Anda sangat tinggi. Kemungkinan besar hipertensi akan atau sudah menyerang.',
                'suggestion'  => 'Wajib konsultasi ke dokter SEGERA. Jangan tunda. Perubahan gaya hidup total diperlukan untuk mencegah stroke/jantung.',
                // Warna: MERAH (Red)
            ],
        ];

        foreach ($levels as $level) {
            RiskLevel::create($level);
        }
    }
}