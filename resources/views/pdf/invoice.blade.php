<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice Pendaftaran</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
            color: #333;
        }
        h1 {
            color: #4CAF50;
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        p {
            font-size: 14px;
            line-height: 1.6;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
        @media print {
            body {
                background-color: white;
                color: black;
            }
            table {
                box-shadow: none;
            }
            .footer {
                page-break-after: always;
            }
        }
    </style>
</head>
<body>
    <h1>Invoice Pendaftaran Program</h1>
    <p>Halo {{ $pendaftaran->user->name ?? 'Peserta' }},</p>
    <p>Terima kasih atas pendaftaran Anda. Berikut detail pembayaran:</p>

    <table>
        <tr>
            <th>Program</th>
            <td>{{ $pendaftaran->program->nama_program ?? '-' }}</td>
        </tr>
        <tr>
            <th>Jenis Program</th>
            <td>{{ $pendaftaran->program->tipe_program ?? '-' }}</td>
        </tr>
        <tr>
            <th>Harga</th>
            <td>Rp{{ number_format($pendaftaran->harga, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{ ucfirst($pendaftaran->status) }}</td>
        </tr>
        <tr>
            <th>Tanggal Pendaftaran</th>
            <td>{{ $pendaftaran->created_at->format('d M Y H:i') }}</td>
        </tr>
    </table>

    <p>Silakan simpan dokumen ini sebagai bukti pembayaran.</p>

    <div class="footer">
        <p>Hormat kami,<br>GenZE Official</p>
    </div>
</body>
</html>
