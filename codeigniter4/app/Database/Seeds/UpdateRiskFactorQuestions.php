<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\RiskFactorModel;

class UpdateRiskFactorQuestions extends Seeder
{
    public function run()
    {
        $riskFactorModel = new RiskFactorModel();

        $questions = [
            'E01' => 'Apakah Anda memiliki riwayat tekanan darah sistolik antara 120-139 mmHg atau diastolik antara 80-89 mmHg?',
            'E02' => 'Apakah ada anggota keluarga inti Anda (ayah, ibu, kakak/adik) yang memiliki riwayat tekanan darah tinggi (hipertensi)?',
            'E03' => 'Apakah Indeks Massa Tubuh (IMT) Anda termasuk dalam kategori obesitas (IMT \u2265 25)?', // Sesuai deskripsi E03
            'E04' => 'Apakah Anda memiliki kebiasaan merokok (tembakau, elektrik, atau sejenisnya)?',
            'E05' => 'Apakah Anda memiliki kebiasaan mengonsumsi minuman beralkohol?',
            'E06' => 'Apakah Anda sering mengonsumsi minuman berenergi (seperti Kratingdaeng, Extra Joss, dll)?',
            'E07' => 'Apakah Anda sering mengonsumsi minuman berkafein tinggi (seperti kopi atau teh kental)?',
            'E08' => 'Apakah Anda sering mengonsumsi makanan tinggi garam dan lemak (misal: mie instan, chiki, keripik, gorengan, sosis, nugget)?',
            'E09' => 'Apakah Anda jarang melakukan aktivitas fisik atau berolahraga (misal: jogging, senam, bersepeda)?',
            'E10' => 'Apakah Anda memiliki pola istirahat yang tidak teratur atau sering begadang?',
            'E11' => 'Apakah Anda sering merasa stres ekstrem, tertekan, atau cemas berlebihan?',
        ];

        foreach ($questions as $code => $text) {
            $riskFactorModel->where('code', $code)->set(['question_text' => $text])->update();
        }

        echo "Teks pertanyaan faktor risiko berhasil diperbarui.\n";
    }
}