<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Riwayat Skrining</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h1 { text-align: center; margin-bottom: 20px; color: #001B48; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        th { background-color: #001B48; color: #ffffff; text-align: center; font-weight: bold; }
        .footer { margin-top: 30px; text-align: right; font-size: 10px; color: #666; }
    </style>
</head>
<body>
    <h1>Laporan Riwayat Skrining</h1>
    <table>
        <thead>
            <tr>
                <th style="width: 20%;">Tanggal</th>
                <th>Nama Pengguna</th>
                <th>Jml Faktor</th>
                <th>Hasil Diagnosa</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($history as $h): ?>
            <tr>
                <td><?= date('d/m/Y H:i', strtotime($h['created_at'])) ?></td>
                <td><?= esc($h['client_name']) ?></td>
                <td><?= esc($h['score']) ?></td>
                <td><?= esc($h['result_level']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="footer">Dicetak pada: <?= date('d-m-Y H:i') ?></div>
</body>
</html>
