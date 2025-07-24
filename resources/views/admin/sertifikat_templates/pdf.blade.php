<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            background: #fff;
        }
        .sertifikat-container {
            width: 100%;
            height: 100%;
            position: relative;
        }
        .sertifikat-container img {
            width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="sertifikat-container">
        <img src="{{ $imagePath }}" alt="Sertifikat">
    </div>
</body>
</html>
