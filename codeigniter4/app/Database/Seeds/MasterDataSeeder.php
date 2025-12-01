<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\RiskFactorModel;
use App\Models\RiskLevelModel;

class MasterDataSeeder extends Seeder
{
    public function run()
    {
        $riskFactorModel = new RiskFactorModel();
        $riskLevelModel = new RiskLevelModel();

        // Data Tingkat Risiko
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
            // Cek jika sudah ada, agar tidak duplikat saat seeder dijalankan berkali-kali
            if (!$riskLevelModel->where('code', $level['code'])->first()) {
                $riskLevelModel->save($level);
            }
        }

        // Data Faktor Risiko
        $factors = [
            [
                'code' => 'E01',
                'name' => 'Tekanan darah yang terukur mengalami peningkatan (sistolik 120 – 139 mmHg) dan/atau (diastolik 80 – 89 mmHg)',
            ],
            [
                'code' => 'E02',
                'name' => 'Terdapat anggota keluarga inti (ayah, ibu, kakak/adik) yang memiliki riwayat penyakit tekanan darah tinggi (hipertensi)',
            ],
            [
                'code' => 'E03',
                'name' => 'Indeks massa tubuh termasuk dalam kategori obesitas (IMT ≥ 25)',
            ],
            [
                'code' => 'E04',
                'name' => 'Memiliki kebiasaan merokok (tembakau/elektrik)',
            ],
            [
                'code' => 'E05',
                'name' => 'Memiliki kebiasaan mengonsumsi minuman beralkohol',
            ],
            [
                'code' => 'E06',
                'name' => 'Memiliki kebiasaan mengonsumsi minuman berenergi seperti kratindeng, extrajoss',
            ],
            [
                'code' => 'E07',
                'name' => 'Memiliki kebiasaan mengonsumsi minuman kafein seperti kopi atau teh kental',
            ],
            [
                'code' => 'E08',
                'name' => 'Memiliki kebiasaan mengonsumsi makanan tinggi garam dan lemak seperti mie instan, chiki, keripik, gorengan, sosis, nugget, basreng',
            ],
            [
                'code' => 'E09',
                'name' => 'Jarang melakukan aktivitas fisik atau berolahraga seperti jogging, senam, bersepeda',
            ],
            [
                'code' => 'E10',
                'name' => 'Memiliki pola istirahat yang tidak teratur (sering begadang)',
            ],
            [
                'code' => 'E11',
                'name' => 'Sering merasa stres ekstrim, tertekan, atau cemas berlebih',
            ],
        ];

        foreach ($factors as $factor) {
            if (!$riskFactorModel->where('code', $factor['code'])->first()) {
                $riskFactorModel->save($factor);
            }
        }
    }
}