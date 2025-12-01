<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Hasil Skrining - TensiTrack</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            color: #333;
            line-height: 1.6;
            background-color: #fff; 
            margin: 0;
        }
        .container {
            width: 100%;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 24px;
            margin: 0;
            color: #001B48;
        }
        .divider {
            border-top: 2px solid #001B48;
            margin: 20px 0;
        }
        .identity-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .identity-table td {
            padding: 5px;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #001B48;
            margin-bottom: 10px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        .risk-level {
            text-align: center;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .risk-level-title {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .risk-level-name {
            font-size: 28px;
            font-weight: bold;
        }
        .risk-factors table {
            width: 100%;
            border-collapse: collapse;
        }
        .risk-factors th, .risk-factors td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .risk-factors th {
            background-color: #f2f2f2;
        }
        .suggestion {
            background: #e6f7ff;
            border-left: 4px solid #005f99;
            padding: 15px;
            border-radius: 5px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>TensiTrack - Laporan Hasil Skrining</h1>
        </div>

        <div class="divider"></div>

        <table class="identity-table">
            <tr>
                <td style="width: 15%"><strong>Nama</strong></td>
                <td style="width: 35%">: {{ $screening->client_name }}</td>
                <td style="width: 15%"><strong>Tanggal</strong></td>
                <td style="width: 35%">: {{ $screening->created_at->format('d F Y') }}</td>
            </tr>
            <tr>
                <td><strong>Usia</strong></td>
                <td>: {{ $screening->snapshot_age }} Tahun</td>
                <td><strong>Tensi</strong></td>
                <td>: {{ $screening->snapshot_systolic }}/{{ $screening->snapshot_diastolic }} mmHg</td>
            </tr>
        </table>

        <div class="section">
            <h2 class="section-title">Hasil Analisis</h2>
            @php
                $isHigh = stripos($screening->result_level, 'tinggi') !== false;
                $isMed = stripos($screening->result_level, 'sedang') !== false;
                $bg = $isHigh ? '#fff5f5' : ($isMed ? '#fffbeb' : '#f0fff4');
                $color = $isHigh ? '#c53030' : ($isMed ? '#b7791f' : '#2f855a');
            @endphp
            <div class="risk-level" style="background-color: {{ $bg }}; color: {{ $color }};">
                <div class="risk-level-title">Tingkat Risiko Hipertensi</div>
                <div class="risk-level-name">{{ $screening->result_level }}</div>
            </div>
        </div>

        <div class="section">
            <h2 class="section-title">Keterangan Medis</h2>
            <p style="text-align: justify;">
                {{ $riskLevel ? $riskLevel->description : 'Tidak ada keterangan tersedia.' }}
            </p>
        </div>

        @if(!$screening->details->isEmpty())
        <div class="section risk-factors">
            <h2 class="section-title">Faktor Risiko Terdeteksi</h2>
            <table>
                <thead>
                    <tr>
                        <th style="width: 15%">Kode</th>
                        <th>Nama Faktor Risiko</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($screening->details as $detail)
                    <tr>
                        <td>{{ $detail->riskFactor->code }}</td>
                        <td>{{ $detail->riskFactor->name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        <div class="section">
            <h2 class="section-title">Saran & Rekomendasi</h2>
            <div class="suggestion">
                {!! $riskLevel ? nl2br(e($riskLevel->suggestion)) : 'Tidak ada saran tersedia.' !!}
            </div>
        </div>
        
        <div style="margin-top: 50px; text-align: center; font-size: 12px; color: #888;">
            <p>Dicetak secara otomatis oleh sistem TensiTrack pada {{ date('d F Y H:i') }}</p>
        </div>
    </div>
</body>
</html>
