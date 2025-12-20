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
        .badge { padding: 2px 6px; border-radius: 4px; font-weight: bold; font-size: 10px; }
        .bg-red { background-color: #fecaca; color: #991b1b; }
        .bg-orange { background-color: #ffedd5; color: #9a3412; }
        .bg-blue { background-color: #dbeafe; color: #1e40af; }
        .bg-green { background-color: #dcfce7; color: #166534; }
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
                <th style="width: 25%">Hasil Risiko</th>
                <th style="width: 30%">Kondisi Faktor Utama</th>
                <th style="width: 15%">Min. Lain</th>
                <th style="width: 15%">Max. Lain</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rules as $rule)
            <tr>
                <td class="text-center">{{ $rule->priority }}</td>
                <td class="text-center">{{ $rule->code }}</td>
                <td>
                    @php
                        $r = strtolower($rule->riskLevel->name);
                        $color = 'bg-green';
                        if (stripos($r, 'berat') !== false) $color = 'bg-red';
                        elseif (stripos($r, 'sedang') !== false) $color = 'bg-orange';
                        elseif (stripos($r, 'rendah') !== false) $color = 'bg-blue';
                    @endphp
                    <span class="badge {{ $color }}">{{ $rule->riskLevel->name }}</span>
                </td>
                <td>
                    @if($rule->riskFactors->count() > 0)
                        <strong>{{ $rule->operator }}</strong>: 
                        {{ $rule->riskFactors->pluck('code')->join(', ') }}
                    @else
                        <span style="color: #999; font-style: italic;">Tidak ada</span>
                    @endif
                </td>
                <td class="text-center">{{ $rule->min_other_factors }}</td>
                <td class="text-center">{{ $rule->max_other_factors >= 99 ? '∞' : $rule->max_other_factors }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
