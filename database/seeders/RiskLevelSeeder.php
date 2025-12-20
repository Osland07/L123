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
                'description' => 'Tidak ditemukan faktor risiko yang signifikan. Kondisi kesehatan dan tekanan darah Anda saat ini berada dalam rentang normal.',
                'suggestion'  => 'Pertahankan gaya hidup sehat Anda. Tetap konsumsi makanan bergizi dan lakukan olahraga rutin untuk menjaga kondisi ini.',
            ],
            [
                'code'        => 'H02',
                'name'        => 'Risiko ringan',
                'description' => 'Ditemukan sedikit faktor risiko yang perlu diperhatikan. Meskipun belum berbahaya, ini adalah peringatan dini bagi kesehatan Anda.',
                'suggestion'  => 'Mulai kurangi kebiasaan buruk seperti konsumsi garam berlebih atau kurang tidur. Lakukan pemantauan mandiri terhadap tekanan darah Anda.',
            ],
            [
                'code'        => 'H03',
                'name'        => 'Risiko sedang',
                'description' => 'Ditemukan beberapa faktor risiko yang cukup signifikan yang dapat memicu kenaikan tekanan darah dalam waktu dekat.',
                'suggestion'  => 'Segera perbaiki gaya hidup. Kurangi asupan kafein, garam, dan kelola stres dengan lebih baik. Disarankan konsultasi ringan dengan tenaga kesehatan.',
            ],
            [
                'code'        => 'H04',
                'name'        => 'Risiko berat',
                'description' => 'Ditemukan banyak faktor risiko gabungan dan/atau tekanan darah sudah dalam kategori pre-hipertensi tinggi. Risiko terkena hipertensi kronis sangat besar.',
                'suggestion'  => 'Wajib segera konsultasi dengan dokter. Lakukan perubahan gaya hidup secara total dan rutinlah melakukan pemeriksaan tekanan darah di fasilitas kesehatan.',
            ],
        ];

        foreach ($levels as $level) {
            RiskLevel::create($level);
        }
    }
}