<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\UserProfileModel;
use App\Models\ScreeningModel;
use App\Models\ScreeningDetailModel;
use App\Models\RiskLevelModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class ClientProfileController extends BaseController
{
    protected $profileModel;
    protected $screeningModel;
    protected $screeningDetailModel;
    protected $riskLevelModel;

    public function __construct()
    {
        $this->profileModel = new UserProfileModel();
        $this->screeningModel = new ScreeningModel();
        $this->screeningDetailModel = new ScreeningDetailModel();
        $this->riskLevelModel = new RiskLevelModel();
    }

    public function index()
    {
        $userId = auth()->id();
        
        // Ambil Profil
        $profile = $this->profileModel->where('user_id', $userId)->first();
        
        // Ambil Riwayat Skrining (Terbaru di atas)
        $history = $this->screeningModel->where('user_id', $userId)
                                        ->orderBy('created_at', 'DESC')
                                        ->findAll();

        // Ambil Hasil Terakhir (Prioritas: Input Manual Profil -> Riwayat Skrining)
        $latestResult = 'Belum ada data';
        if ($profile && $profile['systolic'] && $profile['diastolic']) {
            $latestResult = $profile['systolic'] . '/' . $profile['diastolic'] . ' mmHg';
        } elseif (!empty($history)) {
            $latestResult = $history[0]['result_level']; // Fallback ke hasil diagnosa sistem
        }

        // Hitung Umur & BMI
        $age = ($profile['age'] ?? '-') . ' Tahun';
        $bmi = 0;
        $bmiCategory = '-';

        if ($profile) {
            if ($profile['height'] && $profile['weight']) {
                $h_meter = $profile['height'] / 100;
                $bmi = $profile['weight'] / ($h_meter * $h_meter);
                $bmi = number_format($bmi, 1);

                // Standar BMI Kemenkes RI
                if ($bmi < 18.5) $bmiCategory = 'Kurus';
                elseif ($bmi <= 25.0) $bmiCategory = 'Normal';
                elseif ($bmi <= 27.0) $bmiCategory = 'Gemuk';
                else $bmiCategory = 'Obesitas';
            }
        }

        // Kategori Tensi (JNC 7 / Kemenkes) - Prioritas Kategori Tertinggi
        $tensiCategory = '-';
        if ($profile && $profile['systolic'] && $profile['diastolic']) {
            $sys = $profile['systolic'];
            $dia = $profile['diastolic'];

            // Kategori Tensi (Klasifikasi Lengkap & Umum)
            if ($sys < 90 || $dia < 60) {
                $tensiCategory = 'Hipotensi';
            } elseif ($sys >= 180 || $dia >= 110) {
                $tensiCategory = 'Hipertensi Derajat 3 (Krisis)';
            } elseif ($sys >= 160 || $dia >= 100) {
                $tensiCategory = 'Hipertensi Derajat 2';
            } elseif ($sys >= 140 || $dia >= 90) {
                $tensiCategory = 'Hipertensi Derajat 1';
            } elseif (($sys > 120 && $sys <= 139) || ($dia > 80 && $dia <= 89)) {
                $tensiCategory = 'Pre-Hipertensi'; // Gabungan Normal & Normal Tinggi untuk awam
            } else {
                $tensiCategory = 'Optimal (Normal)';
            }
        }

        $data = [
            'title'        => 'Profil Saya',
            'profile'      => $profile,
            'history'      => $history,
            'latest_result'=> $latestResult,
            'age'          => $age,
            'bmi'          => $bmi,
            'bmi_category' => $bmiCategory,
            'tensi_category'=> $tensiCategory
        ];

        return view('Client/profile/index', $data);
    }

    public function update()
    {
        $userId = auth()->id();
        
        // Validasi sederhana
        if (!$this->validate([
            'full_name' => 'required|min_length[3]',
            'age'       => 'required|numeric',
            'height'    => 'required|numeric',
            'weight'    => 'required|numeric',
            'systolic'  => 'permit_empty|numeric',
            'diastolic' => 'permit_empty|numeric',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Cek apakah profil sudah ada
        $existing = $this->profileModel->where('user_id', $userId)->first();

        $dataToSave = [
            'user_id'    => $userId,
            'full_name'  => $this->request->getPost('full_name'),
            'age'        => $this->request->getPost('age'),
            'gender'     => $this->request->getPost('gender'),
            'height'     => $this->request->getPost('height'),
            'weight'     => $this->request->getPost('weight'),
            'systolic'   => $this->request->getPost('systolic') ?: null,
            'diastolic'  => $this->request->getPost('diastolic') ?: null,
        ];

        if ($existing) {
            $this->profileModel->update($existing['id'], $dataToSave);
        } else {
            $this->profileModel->save($dataToSave);
        }

        return redirect()->to('/profile')->with('message', 'Profil berhasil diperbarui.');
    }

    public function detail($id)
    {
        $userId = auth()->id();
        
        // Ambil riwayat spesifik
        $screening = $this->screeningModel->where('id', $id)
                                          ->where('user_id', $userId)
                                          ->first();

        if (!$screening) {
            return redirect()->to('/profile')->with('error', 'Data riwayat tidak ditemukan.');
        }

        // Ambil Data Profil saat ini (sebagai snapshot sederhana)
        $profile = $this->profileModel->where('user_id', $userId)->first();

        // Ambil Info Level Risiko (Saran & Keterangan)
        $riskLevelData = $this->riskLevelModel->where('name', $screening['result_level'])->first();

        // Ambil Detail Jawaban (Faktor Risiko yang dipilih)
        $details = $this->screeningDetailModel->select('risk_factors.code, risk_factors.name, risk_factors.question_text')
                                              ->join('risk_factors', 'risk_factors.id = screening_details.risk_factor_id')
                                              ->where('screening_id', $id)
                                              ->findAll();

        // Hitung BMI & Tensi (Gunakan Snapshot jika ada, fallback ke profil saat ini untuk data lama)
        $height = $screening['snapshot_height'] ?? ($profile['height'] ?? null);
        $weight = $screening['snapshot_weight'] ?? ($profile['weight'] ?? null);
        $sys    = $screening['snapshot_systolic'] ?? ($profile['systolic'] ?? null);
        $dia    = $screening['snapshot_diastolic'] ?? ($profile['diastolic'] ?? null);
        $age    = $screening['snapshot_age'] ?? ($profile['age'] ?? '-');

        $bmi = '-';
        if ($height && $weight) {
            $h = $height / 100;
            $bmi = number_format($weight / ($h * $h), 1);
        }
        
        $tensi = '-';
        if ($sys && $dia) {
            $tensi = $sys . '/' . $dia . ' mmHg';
        }

        $data = [
            'title'         => 'Detail Riwayat',
            'screening'     => $screening,
            'profile'       => $profile, // Tetap kirim profil untuk data statis lain (gender, nama jika perlu)
            'riskLevelData' => $riskLevelData,
            'details'       => $details,
            'bmi'           => $bmi,
            'tensi'         => $tensi,
            'age_snapshot'  => $age
        ];

        return view('Client/profile/detail', $data);
    }

    public function pdf($id, $action = 'view')
    {
        $userId = auth()->id();
        
        $screening = $this->screeningModel->where('id', $id)
                                          ->where('user_id', $userId)
                                          ->first();

        if (!$screening) {
            return redirect()->to('/profile')->with('error', 'Data riwayat tidak ditemukan.');
        }

        // Ambil Info Level Risiko (Saran & Keterangan)
        $riskLevelData = $this->riskLevelModel->where('name', $screening['result_level'])->first();

        // Ambil Detail Jawaban (Faktor Risiko yang dipilih)
        $details = $this->screeningDetailModel->select('risk_factors.code, risk_factors.name, risk_factors.question_text')
                                              ->join('risk_factors', 'risk_factors.id = screening_details.risk_factor_id')
                                              ->where('screening_id', $id)
                                              ->findAll();
        
        // Tentukan Warna untuk view
        $isHigh = stripos($screening['result_level'], 'tinggi') !== false;
        $isMed = stripos($screening['result_level'], 'sedang') !== false;

        $data = [
            'title'         => 'Cetak Detail Riwayat Skrining',
            'screening'     => $screening,
            'riskLevelData' => $riskLevelData,
            'details'       => $details,
            'isHigh'        => $isHigh,
            'isMed'         => $isMed,
        ];

        $pdfOptions = new Options();
        $pdfOptions->set('isRemoteEnabled', false);
        
        // Definisikan path yang bisa ditulis untuk cache Dompdf
        $cachePath = WRITEPATH . 'cache/dompdf';

        // Set chroot untuk mengizinkan akses ke direktori proyek
        $pdfOptions->set('chroot', ROOTPATH);

        // Konfigurasi path cache font
        $pdfOptions->set('fontDir', $cachePath);
        $pdfOptions->set('fontCache', $cachePath);
        
        // Konfigurasi path temp
        $pdfOptions->set('tempDir', $cachePath);

        $dompdf = new Dompdf($pdfOptions);

        $dompdf->loadHtml(view('Client/profile/cetak', $data));
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'hasil-skrining-' . auth()->user()->username . '-' . date('Y-m-d') . '.pdf';

        if ($action === 'download') {
            $dompdf->stream($filename, ['Attachment' => 1]);
        } else {
            $dompdf->stream($filename, ['Attachment' => 0]);
        }
    }
}
