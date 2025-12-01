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
            /* Provide a background to see the scaled page */
            background-color: #f0f0f0; 
            height: 100vh;
            margin: 0;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #eee;
            padding: 30px;
            border-radius: 10px;
            
            /* New scaling styles */
            background-color: #fff; /* Ensure container has a white background */
            transform: scale(0.75);
            transform-origin: top center; /* Scale from the top and horizontally center */
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            max-width: 150px;
            margin-bottom: 10px;
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
        .identity {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 14px;
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
        .risk-factors ul {
            list-style: none;
            padding: 0;
        }
        .risk-factors li {
            background: #f9f9f9;
            border: 1px solid #eee;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 8px;
            font-size: 14px;
        }
        .suggestion {
            background: #e6f7ff;
            border-left: 4px solid #005f99;
            padding: 15px;
            border-radius: 5px;
            font-size: 14px;
        }
        @media print {
            @page {
                size: A4;
                margin: 10mm;
            }
            body { 
                margin: 0;
                font-size: 9pt; /* Further reduce base font size */
                line-height: 1.4; /* Tighten line height */
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                height: 277mm;
                overflow: hidden;
            }
            .container { 
                width: 100%;
                border: none; 
                box-shadow: none; 
                margin: 0;
                padding: 0;
            }
            .section {
                page-break-inside: avoid;
                margin-bottom: 10px; /* Further reduce space */
            }
            .section-title {
                font-size: 12pt; /* Further reduce title size */
                margin-bottom: 4px;
            }
            .header img {
                max-width: 80px; /* Further reduce logo */
            }
            .risk-level-name {
                font-size: 18pt; /* Further reduce risk level font size */
            }
            .risk-factors td, .risk-factors th {
                padding: 4px; /* Further reduce table padding */
            }
            .suggestion {
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="<?= FCPATH . 'logo-tensitrack.png' ?>" alt="TensiTrack Logo">
            <h1>TensiTrack - Hasil Skrining</h1>
        </div>

        <div class="divider"></div>

        <div class="identity">
            <div><strong>Nama:</strong> <?= esc($screening['client_name']) ?></div>
            <div><strong>Tanggal:</strong> <?= date('d F Y', strtotime($screening['created_at'])) ?></div>
        </div>

        <div class="section">
            <h2 class="section-title">Hasil Analisis</h2>
            <div class="risk-level" style="background-color: <?= $isHigh ? '#fff5f5' : ($isMed ? '#fffbeb' : '#f0fff4') ?>; color: <?= $isHigh ? '#c53030' : ($isMed ? '#b7791f' : '#2f855a') ?>;">
                <div class="risk-level-title">Tingkat Risiko Hipertensi</div>
                <div class="risk-level-name"><?= esc($screening['result_level']) ?></div>
            </div>
        </div>

        <div class="section">
            <h2 class="section-title">Keterangan</h2>
            <p><?= $riskLevelData ? esc($riskLevelData['description']) : 'Tidak ada keterangan.' ?></p>
        </div>

        <?php if (!empty($details)): ?>
        <div class="section risk-factors">
            <h2 class="section-title">Faktor Risiko yang Terdeteksi</h2>
            <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                <thead>
                    <tr style="background-color: #f2f2f2;">
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: left; width: 20%;">Kode</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Faktor Risiko</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($details as $d): ?>
                    <tr>
                        <td style="border: 1px solid #ddd; padding: 8px;"><?= esc($d['code']) ?></td>
                        <td style="border: 1px solid #ddd; padding: 8px;"><?= esc($d['name']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>

        <div class="section">
            <h2 class="section-title">Saran Penatalaksanaan</h2>
            <div class="suggestion">
                <?= $riskLevelData ? nl2br(esc($riskLevelData['suggestion'])) : 'Tidak ada saran.' ?>
            </div>
        </div>
    </div>

    <script>
        // Automatically trigger print dialog
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
