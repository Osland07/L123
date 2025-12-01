<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Aturan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h1 { text-align: center; margin-bottom: 20px; color: #001B48; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #001B48; color: #ffffff; text-align: center; font-weight: bold; }
        .footer { margin-top: 30px; text-align: right; font-size: 10px; color: #666; }
    </style>
</head>
<body>
    <h1>Laporan Basis Aturan</h1>
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">Prio</th>
                <th style="width: 10%;">Kode</th>
                <th>Syarat Faktor Utama</th>
                <th>Syarat Faktor Lain</th>
                <th>Hasil</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rules as $r): ?>
            <tr>
                <td style="text-align: center;"><?= $r['priority'] ?></td>
                <td style="text-align: center;"><b><?= $r['code'] ?></b></td>
                <td><?= $r['factor_name'] ? esc($r['factor_name']) : '-' ?></td>
                <td><?= $r['min_other_factors'] ?> s/d <?= $r['max_other_factors'] == 99 ? 'Tak Terbatas' : $r['max_other_factors'] ?></td>
                <td><?= $r['level_name'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="footer">Dicetak pada: <?= date('d-m-Y H:i') ?></div>
</body>
</html>