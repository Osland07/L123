<!DOCTYPE html>
<html>
<head>
    <title>Laporan Aturan Diagnosa</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; text-align: center; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { margin: 0; font-size: 18px; color: #001B48; }
        .header p { margin: 5px 0 0; color: #666; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Data Aturan Diagnosa TensiTrack</h1>
        <p>Dicetak pada: {{ date('d F Y, H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">Pri</th>
                <th style="width: 10%">Kode</th>
                <th style="width: 20%">Hasil Risiko</th>
                <th style="width: 25%">Faktor Wajib</th>
                <th style="width: 20%">Min. Faktor Lain</th>
                <th style="width: 20%">Max. Faktor Lain</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rules as $rule)
            <tr>
                <td class="text-center">{{ $rule->priority }}</td>
                <td class="text-center">{{ $rule->code }}</td>
                <td>{{ $rule->riskLevel->name }}</td>
                <td>{{ $rule->requiredFactor ? $rule->requiredFactor->name : '-' }}</td>
                <td class="text-center">{{ $rule->min_other_factors }}</td>
                <td class="text-center">{{ $rule->max_other_factors >= 99 ? 'Tak Terbatas' : $rule->max_other_factors }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
