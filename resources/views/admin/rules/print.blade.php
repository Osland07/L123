<!DOCTYPE html>
<html>
<head>
    <title>Laporan Aturan Diagnosa</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: center; } /* Semua border hitam & rata tengah */
        th { background-color: #f2f2f2; font-weight: bold; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { margin: 0; font-size: 18px; color: #000; } /* Judul Hitam */
        .header p { margin: 5px 0 0; color: #333; }
        .text-left { text-align: left !important; } /* Helper jika butuh rata kiri spesifik */
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
                <th style="width: 10%">Prioritas</th>
                <th style="width: 10%">Kode</th>
                <th style="width: 20%">Hasil Risiko</th>
                <th style="width: 30%">Kondisi Faktor Utama</th>
                <th style="width: 15%">Min. Lain</th>
                <th style="width: 15%">Max. Lain</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rules as $rule)
            <tr>
                <td>{{ $rule->priority }}</td>
                <td>{{ $rule->code }}</td>
                <td>{{ $rule->riskLevel->name }}</td>
                <td>
                    @if($rule->riskFactors->count() > 0)
                        <strong>{{ $rule->operator }}</strong>: 
                        {{ $rule->riskFactors->pluck('code')->join(', ') }}
                    @else
                        <span style="color: #666; font-style: italic;">Tidak ada</span>
                    @endif
                </td>
                <td>{{ $rule->min_other_factors }}</td>
                <td>{{ $rule->max_other_factors >= 99 ? '∞' : $rule->max_other_factors }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>