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
        $levels = [
            [
                'code'        => 'H01',
                'name'        => 'Risiko hipertensi rendah',
                'description' => 'Tidak ditemukan faktor risiko signifikan atau hanya ditemukan sedikit faktor risiko yang mudah dikelola. Tekanan darah cenderung normal.',
                'suggestion'  => 'Pertahankan gaya hidup sehat: diet seimbang, olahraga teratur, hindari rokok dan alkohol. Lakukan pemeriksaan tekanan darah setidaknya setahun sekali.',
            ],
            [
                'code'        => 'H02',
                'name'        => 'Risiko hipertensi sedang',
                'description' => 'Ditemukan beberapa faktor risiko yang memerlukan perhatian lebih. Tekanan darah mungkin sudah mulai meningkat (pre-hipertensi).',
                'suggestion'  => 'Segera perbaiki gaya hidup: kurangi garam dan lemak, tingkatkan aktivitas fisik, kelola stres. Pertimbangkan konsultasi dengan dokter untuk pemantauan lebih lanjut.',
            ],
            [
                'code'        => 'H03',
                'name'        => 'Risiko hipertensi tinggi',
                'description' => 'Ditemukan banyak faktor risiko signifikan dan/atau tekanan darah sudah termasuk kategori hipertensi. Sangat berisiko tinggi terkena komplikasi.',
                'suggestion'  => 'Wajib segera konsultasi dan ikuti anjuran dokter. Lakukan pemeriksaan tekanan darah secara rutin, patuhi pengobatan, dan terapkan gaya hidup sehat secara ketat.',
            ],
        ];

        foreach ($levels as $level) {
            RiskLevel::firstOrCreate(['code' => $level['code']], $level);
        }
    }
}
