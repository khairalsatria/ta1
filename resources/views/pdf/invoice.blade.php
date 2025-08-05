<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Invoice Pendaftaran Program</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.4;
            color: #1a1a1a;
            background: #f5f5f5;
            padding: 20px;
        }

        .invoice-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border: 2px solid #22c55e;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            color: white;
            padding: 20px;
            text-align: center;
        }

        .company-info {
            background: #f0fdf4;
            padding: 15px 20px;
            border-bottom: 1px solid #dcfce7;
            font-size: 12px;
            color: #374151;
            line-height: 1.5;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo-container {
            flex-shrink: 0;
            width: 60px;
            height: 60px;
            background: #e5e7eb;
            border: 2px dashed #9ca3af;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            text-align: center;
            color: #6b7280;
        }

        .logo-container img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            border-radius: 4px;
        }

        .company-details {
            flex: 1;
        }

        .company-details .address {
            margin-bottom: 5px;
        }

        .document-title {
            background: #22c55e;
            color: white;
            padding: 10px 20px;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
        }

        .participant-info {
            padding: 15px 20px;
            background: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
        }

        .participant-info h3 {
            font-size: 16px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 5px;
        }

        .participant-info .role {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .participant-info .contact {
            color: #374151;
            font-size: 12px;
        }

        .print-date {
            text-align: right;
            padding: 10px 20px;
            font-size: 12px;
            color: #6b7280;
            background: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
        }

        .details-section {
            padding: 20px;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .details-table th {
            background: #22c55e;
            color: white;
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
            border: 1px solid #16a34a;
        }

        .details-table td {
            padding: 12px 15px;
            border: 1px solid #d1d5db;
            font-size: 13px;
            vertical-align: top;
        }

        .details-table tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .amount {
            text-align: right;
            font-weight: 600;
            color: #059669;
        }

        .summary-section {
            border-top: 2px solid #22c55e;
            padding-top: 15px;
            margin-top: 20px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            font-size: 14px;
        }

        .summary-row.total {
            font-weight: bold;
            font-size: 16px;
            color: #059669;
            border-top: 1px solid #d1d5db;
            padding-top: 12px;
            margin-top: 10px;
        }

        .notes {
            margin-top: 20px;
            padding: 15px;
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            border-radius: 4px;
        }

        .notes strong {
            color: #92400e;
        }

        .footer {
            margin-top: 30px;
            padding: 20px;
            background: #f0fdf4;
            text-align: center;
            font-size: 12px;
            color: #374151;
            border-top: 1px solid #dcfce7;
        }

        /* Print styles */
        @media print {
            body {
                background: white;
                padding: 0;
            }

            .invoice-container {
                box-shadow: none;
                border: 1px solid #000;
            }
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .invoice-container {
                margin: 10px;
            }

            .company-info {
                padding: 15px;
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }

            .logo-container {
                width: 50px;
                height: 50px;
            }

            .details-section {
                padding: 15px;
            }

            .details-table th,
            .details-table td {
                padding: 8px 10px;
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Company Info with Logo -->
        {{-- <div class="company-info">
            {{-- <div class="logo-container">
                <!-- Placeholder untuk logo -->
                <span>LOGO</span>
                <!-- Uncomment baris di bawah dan ganti src dengan path logo Anda -->

                <img src="{{ asset('storage/logos/logo.png') }}" alt="Company Logo">
            </div> --}}
            {{-- <div class="company-details">
                <div class="address">Jalan Seberang Padang Utara I, Seberang Padang, Kec. Padang Selatan,</div>
                <div class="address">Kota Padang, Sumatera Barat 25214</div>
                <div>0813-7413-7266</div>
            </div>
        </div> --}}

        <!-- Document Title -->
        <div class="document-title">
            Invoice Pendaftaran Program
        </div>

        <!-- Participant Info -->
        <div class="participant-info">
            <h3>{{ $pendaftaran->user->name ?? 'Peserta Program' }}</h3>
            <div class="role">{{ $pendaftaran->program->nama_program ?? '-' }}</div>
            <div class="contact">{{ $pendaftaran->user->email ?? '-' }}</div>
        </div>

        <!-- Print Date -->
        <div class="print-date">
            Tanggal Cetak<br>
            {{ date('n/j/Y') }}
        </div>

        <!-- Details Section -->
        <div class="details-section">
            <!-- Details Table -->
            <table class="details-table">
                <thead>
                    <tr>
                        <th>Rincian</th>
                        <th>Tanggal Pendaftaran</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <strong>{{ $pendaftaran->program->nama_program ?? 'Program Pembelajaran' }}</strong><br>
                            <small style="color: #6b7280;">{{ $pendaftaran->program->tipe_program ?? 'Tipe Program' }}</small>
                        </td>
                        <td>{{ $pendaftaran->created_at->format('j/n/y') }}</td>
                        <td class="amount">Rp{{ number_format($pendaftaran->harga, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- Notes -->
            <div class="notes">
                <strong>Notes:</strong> Invoice untuk pendaftaran program pembelajaran. Status pembayaran: <strong>{{ ucfirst($pendaftaran->status) }}</strong>
            </div>

            <!-- Summary Section -->
            <div class="summary-section">
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span>Rp{{ number_format($pendaftaran->harga, 0, ',', '.') }}</span>
                </div>
                <div class="summary-row">
                    <span>Adjustments</span>
                    <span>-</span>
                </div>
                <div class="summary-row total">
                    <span>Total Pembayaran</span>
                    <span>Rp{{ number_format($pendaftaran->harga, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Additional Info -->
            <div style="margin-top: 25px; padding: 15px; background: #f0fdf4; border-radius: 8px; border: 1px solid #bbf7d0;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; font-size: 13px;">
                    <div>
                        <strong style="color: #059669;">ID Transaksi:</strong><br>
                        #{{ str_pad($pendaftaran->id, 6, '0', STR_PAD_LEFT) }}
                    </div>
                    <div>
                        <strong style="color: #059669;">Status:</strong><br>
                        <span style="background: #dcfce7; color: #16a34a; padding: 2px 8px; border-radius: 12px; font-size: 11px; font-weight: 600;">
                            {{ ucfirst($pendaftaran->status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <strong>GenZE Official</strong><br>
            Platform Pembelajaran Terdepan untuk Generasi Masa Depan<br>
            Jalan Seberang Padang Utara I, Seberang Padang, Kec. Padang Selatan<br>
            Kota Padang, Sumatera Barat 25214<br>
            0813-7413-7266<br>
            <small>© {{ date('Y') }} GenZE Official. All rights reserved.</small>
        </div>
    </div>
</body>
</html>
