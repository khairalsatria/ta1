<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            background: white;
            color: #000;
            line-height: 1.4;
            padding: 20px;
        }

        .container {
            max-width: 21cm;
            margin: 0 auto;
            background: white;
            padding: 40px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
        }

        .company-name {
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .report-title {
            font-size: 16px;
            font-weight: bold;
            margin: 10px 0;
        }

        .report-period {
            font-size: 14px;
            margin-bottom: 10px;
        }

        .financial-summary {
            margin: 30px 0;
        }

        .summary-title {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 15px;
            text-decoration: underline;
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .summary-table td {
            padding: 8px 15px;
            border: 1px solid #000;
            font-size: 13px;
        }

        .summary-table .label {
            font-weight: bold;
            background-color: #f5f5f5;
            width: 60%;
        }

        .summary-table .amount {
            text-align: right;
            font-family: 'Courier New', monospace;
        }

        .transaction-detail {
            margin-top: 30px;
        }

        .detail-title {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 15px;
            text-decoration: underline;
        }

        .detail-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        .detail-table th {
            background-color: #000;
            color: white;
            padding: 10px 8px;
            text-align: center;
            font-weight: bold;
            border: 1px solid #000;
        }

        .detail-table td {
            padding: 8px;
            border: 1px solid #000;
            vertical-align: top;
        }

        .detail-table .no-col {
            width: 5%;
            text-align: center;
        }

        .detail-table .date-col {
            width: 12%;
            text-align: center;
        }

        .detail-table .type-col {
            width: 15%;
            text-align: center;
        }

        .detail-table .desc-col {
            width: 45%;
        }

        .detail-table .amount-col {
            width: 23%;
            text-align: right;
            font-family: 'Courier New', monospace;
        }

        .detail-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .income {
            color: #000;
        }

        .expense {
            color: #000;
        }

        .total-row {
            font-weight: bold;
            background-color: #e0e0e0 !important;
        }

        .signature-section {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }

        .signature-box {
            text-align: center;
            width: 200px;
        }

        .signature-title {
            font-size: 12px;
            margin-bottom: 60px;
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
        }

        .signature-name {
            font-size: 12px;
            font-weight: bold;
        }

        .footer-info {
            margin-top: 30px;
            font-size: 10px;
            text-align: center;
            color: #666;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }

        .page-break {
            page-break-before: always;
        }

        @media print {
            body {
                padding: 0;
            }
            .container {
                padding: 20px;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            .detail-table {
                font-size: 10px;
            }

            .detail-table th, .detail-table td {
                padding: 6px 4px;
            }

            .signature-section {
                flex-direction: column;
                gap: 30px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="company-name">GenZE</div>
            <div class="report-title">LAPORAN KEUANGAN</div>
            <div class="report-period">
                Periode {{ \Carbon\Carbon::parse($tanggalAwal)->translatedFormat('d F Y') }} s/d {{ \Carbon\Carbon::parse($tanggalAkhir)->translatedFormat('d F Y') }}
            </div>
        </div>

        <!-- Financial Summary -->
        <div class="financial-summary">
            <div class="summary-title">Ringkasan Keuangan</div>
            <table class="summary-table">
                <tr>
                    <td class="label">PEMASUKAN</td>
                    <td class="amount"></td>
                </tr>
                <tr>
                    <td class="label">&nbsp;&nbsp;• Pemasukan Manual</td>
                    <td class="amount">Rp {{ number_format($totalPemasukanManual, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="label">&nbsp;&nbsp;• Pemasukan Pendaftaran</td>
                    <td class="amount">Rp {{ number_format($totalPemasukanPendaftaran, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="label"><strong>TOTAL PEMASUKAN</strong></td>
                    <td class="amount"><strong>Rp {{ number_format($totalPemasukanManual + $totalPemasukanPendaftaran, 0, ',', '.') }}</strong></td>
                </tr>
                <tr>
                    <td class="label"><strong>TOTAL PENGELUARAN</strong></td>
                    <td class="amount"><strong>Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</strong></td>
                </tr>
                <tr style="background-color: #d0d0d0;">
                    <td class="label"><strong>SALDO AKHIR</strong></td>
                    <td class="amount"><strong>Rp {{ number_format($totalSaldo, 0, ',', '.') }}</strong></td>
                </tr>
            </table>
        </div>

        <!-- Transaction Details -->
        <div class="transaction-detail">
            <div class="detail-title">Detail Transaksi</div>
            <table class="detail-table">
                <thead>
                    <tr>
                        <th class="no-col">NO</th>
                        <th class="date-col">TANGGAL</th>
                        <th class="type-col">JENIS TRANSAKSI</th>
                        <th class="desc-col">KETERANGAN</th>
                        <th class="amount-col">JUMLAH (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($keuangans as $k)
                    <tr>
                        <td class="no-col">{{ $loop->iteration }}</td>
                        <td class="date-col">{{ \Carbon\Carbon::parse($k->tanggal)->format('d/m/Y') }}</td>
                        <td class="type-col">{{ strtoupper($k->jenis_transaksi) }}</td>
                        <td class="desc-col">{{ $k->keterangan }}</td>
                        <td class="amount-col {{ $k->jenis_transaksi == 'pemasukan' ? 'income' : 'expense' }}">
                            {{ $k->jenis_transaksi == 'pengeluaran' ? '(' : '' }}{{ number_format($k->jumlah, 0, ',', '.') }}{{ $k->jenis_transaksi == 'pengeluaran' ? ')' : '' }}
                        </td>
                    </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="4" style="text-align: center;"><strong>TOTAL SALDO</strong></td>
                        <td class="amount-col"><strong>{{ number_format($totalSaldo, 0, ',', '.') }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Signature Section -->
        {{-- <div class="signature-section">
            <div class="signature-box">
                <div class="signature-title">Disiapkan Oleh:</div>
                <div class="signature-name">Bagian Keuangan</div>
            </div>
            <div class="signature-box">
                <div class="signature-title">Disetujui Oleh:</div>
                <div class="signature-name">Manajer Keuangan</div>
            </div>
            <div class="signature-box">
                <div class="signature-title">Mengetahui:</div>
                <div class="signature-name">Direktur</div>
            </div>
        </div> --}}

        <!-- Footer -->
        <div class="footer-info">
            <p>Laporan ini dibuat secara otomatis pada {{ date('d F Y, H:i') }} WIB</p>
            {{-- <p>Halaman 1 dari 1</p> --}}
        </div>
    </div>
</body>
</html>
