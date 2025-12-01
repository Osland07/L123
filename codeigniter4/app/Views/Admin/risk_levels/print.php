<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Tingkat Risiko</title>
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
    <h1>Laporan Data Tingkat Risiko</h1>
    
    <table>
        <thead>
            <tr>
                <th style="width: 10%;">Kode</th>
                <th style="width: 20%;">Nama</th>
                <th style="width: 35%;">Keterangan</th>
                <th style="width: 35%;">Saran</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($risks as $item): ?>
            <tr>
                <td style="text-align: center;"><b><?= esc($item['code']) ?></b></td>
                <td><?= esc($item['name']) ?></td>
                <td><?= esc($item['description']) ?></td>
                <td><?= esc($item['suggestion']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: <?= date('d-m-Y H:i') ?>
    </div>
</body>
</html>
