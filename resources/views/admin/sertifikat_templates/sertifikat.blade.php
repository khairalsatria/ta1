<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat</title>
    @php
        // Pastikan font GreatVibes-Regular.ttf ada di public/fonts/
        $fontPath = public_path('fonts/GreatVibes-Regular.ttf');
        $fontData = file_exists($fontPath) ? base64_encode(file_get_contents($fontPath)) : '';
    @endphp
    <style>
        @page {
            margin: 0;
            size: A4 landscape;
        }
        html, body {
            margin: 0;
            padding: 0;
            width: 297mm;
            height: 210mm;
        }
        .sertifikat-wrapper {
            position: relative;
            width: 297mm;
            height: 210mm;
        }
        .sertifikat-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 297mm;
            height: 210mm;
            z-index: 1;
        }
        .sertifikat-text {
            position: absolute;
            width: 100%;
            text-align: center;
            z-index: 2;
        }

        /* === FONT CUSTOM === */
        @font-face {
            font-family: 'GreatVibes';
            src: url(data:font/truetype;charset=utf-8;base64,{{ $fontData }}) format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        /* === NAMA PESERTA === */
        .nama {
            top: 85mm;
            font-size: 15mm;
            color: #d4a017; /* warna emas */
            font-family: 'GreatVibes', cursive;
        }
    </style>
</head>
<body>
    <div class="sertifikat-wrapper">
        <img src="{{ public_path('storage/' . $templatePath) }}" class="sertifikat-bg" alt="Template Sertifikat">
        <div class="sertifikat-text nama">
            {{ $nama }}
        </div>
    </div>
</body>
</html>
