<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        h2, h4 { margin: 0; padding: 0; }
        .text-right { text-align: right; }
        .summary { margin-top: 20px; }
    </style>
</head>
<body>

<h4 style="text-align:center;">
    Laporan Keuangan Periode
    {{ \Carbon\Carbon::parse($tanggalAwal)->translatedFormat('F Y') }}
    -
    {{ \Carbon\Carbon::parse($tanggalAkhir)->translatedFormat('F Y') }}
</h4>


    <div class="summary">
        <p><strong>Pemasukan Manual:</strong> Rp {{ number_format($totalPemasukanManual, 0, ',', '.') }}</p>
        <p><strong>Pemasukan Pendaftaran:</strong> Rp {{ number_format($totalPemasukanPendaftaran, 0, ',', '.') }}</p>
        <p><strong>Pengeluaran:</strong> Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
        <p><strong>Saldo Akhir:</strong> Rp {{ number_format($totalSaldo, 0, ',', '.') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Keterangan</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($keuangans as $k)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($k->tanggal)->format('d M Y') }}</td>
                    <td>{{ ucfirst($k->jenis_transaksi) }}</td>
                    <td>{{ $k->keterangan }}</td>
                    <td class="text-right">Rp {{ number_format($k->jumlah, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
