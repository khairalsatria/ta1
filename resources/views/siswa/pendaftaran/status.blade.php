@extends('landing.layout.main')

@section('title', 'Status Pendaftaran')

@section('content')
<style>
    /* Base and Layout */
    .page-heading {
        background: linear-gradient(135deg, #2ecc71, #27ae60);
        padding: 2rem 1rem;
        border-radius: 12px;
        color: #fff;
        margin-bottom: 2rem;
        text-align: center;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        user-select: none;
    }
    .page-heading h3 {
        font-weight: 700;
        font-size: 2.2rem;
        position: relative;
        display: inline-block;
        padding-bottom: 0.5rem;
        letter-spacing: 0.05em;
    }
    .page-heading h3::after {
        content: "";
        position: absolute;
        width: 50%;
        height: 3px;
        background: #a3e635;
        bottom: 0;
        left: 25%;
        border-radius: 2px;
        animation: underlineGlowGreen 2s ease-in-out infinite;
    }
    @keyframes underlineGlowGreen {
        0%, 100% {
            box-shadow: 0 0 8px #a3e635, 0 0 18px #a3e635;
        }
        50% {
            box-shadow: 0 0 16px #a3e635, 0 0 36px #a3e635;
        }
    }

    /* Card */
    .card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 16px 40px rgba(39, 174, 96, 0.15);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        max-width: 600px;
        margin: auto;
        padding: 2rem;
        font-size: 1rem;
    }
    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 24px 56px rgba(39, 174, 96, 0.3);
    }

    /* Section Titles */
    .text-muted {
        font-size: 0.9rem;
        letter-spacing: 0.05em;
        color: #678d58;
        margin-bottom: 0.3rem;
        text-transform: uppercase;
    }
    p.fw-bold {
        font-size: 1.2rem;
        color: #2f6627;
    }
    p.fw-semibold {
        font-weight: 600;
        font-size: 1.15rem;
    }

    /* Info Columns */
    .info-row {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }
    .info-col {
        flex: 1 1 45%;
        min-width: 180px;
        background: #e6f4ea;
        border-radius: 12px;
        padding: 1rem 1.5rem;
        box-shadow: inset 0 0 10px #b7d9b8cc;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: #2e7d32;
        font-weight: 600;
        font-size: 1.1rem;
    }
    .info-col i {
        font-size: 1.7rem;
        color: #4caf50;
        flex-shrink: 0;
        transition: color 0.3s ease;
    }
    .info-col:hover i {
        color: #2e7d32;
    }

    /* Status Badge */
    .badge {
        font-weight: 600 !important;
        font-size: 1rem !important;
        padding: 0.6em 1.1em !important;
        border-radius: 50px !important;
        text-transform: uppercase !important;
        box-shadow: 0 4px 10px rgba(0,0,0,0.07);
        transition: background 0.4s ease, box-shadow 0.4s ease;
        display: inline-block;
        min-width: 110px;
        text-align: center;
        letter-spacing: 0.08em;
        user-select: none;
    }
    .bg-warning {
        background: linear-gradient(45deg, #cddc39, #afb42b);
        color: #3e2723 !important;
        box-shadow: 0 4px 12px #cddc3988;
    }
    .bg-success {
        background: linear-gradient(45deg, #4caf50, #2e7d32);
        color: #e8f5e9 !important;
        box-shadow: 0 4px 12px #388e3c99;
    }
    .bg-danger {
        background: linear-gradient(45deg, #e57373, #c62828);
        color: #fff !important;
        box-shadow: 0 4px 12px #e5393599;
    }
    .bg-secondary {
        background: linear-gradient(45deg, #a5d6a7, #6b8e23);
        color: #eceff1 !important;
        box-shadow: 0 4px 12px #78909c99;
    }

    /* Schedule Section */
    .schedule-confirm {
        text-align: center;
        margin: 2rem 0 1.5rem;
    }
    .schedule-confirm h6 {
        color: #678d58;
        margin-bottom: 0.5rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        font-weight: 700;
    }
    .schedule-confirm p {
        color: #2e7d32;
        font-weight: 700;
        font-size: 1.25rem;
        text-shadow: 0 1px 2px #aed581;
    }

    /* Upload Form */
    form.mt-3 {
        max-width: 400px;
        margin: 1rem auto 0 auto;
    }
    label.form-label {
        font-weight: 600;
        color: #2e7d32;
    }
    input[type="file"].form-control {
        border: 2px solid #66bb6a;
        border-radius: 8px;
        padding: 0.5rem 0.75rem;
        transition: border-color 0.3s ease;
        cursor: pointer;
    }
    input[type="file"].form-control:hover,
    input[type="file"].form-control:focus {
        border-color: #2e7d32;
        outline: none;
    }

    button.btn-success {
        background: linear-gradient(90deg, #43a047, #2e7d32);
        border: none;
        padding: 0.65rem 1.8rem;
        font-weight: 700;
        font-size: 1.15rem;
        border-radius: 50px;
        box-shadow: 0 6px 12px #43a047aa;
        transition: background 0.4s ease, box-shadow 0.4s ease;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        user-select: none;
    }
    button.btn-success:hover {
        background: linear-gradient(90deg, #2e7d32, #145214);
        box-shadow: 0 8px 20px #2e7d32bb;
    }

    /* Info Alert */
    .alert-info {
        max-width: 520px;
        margin: 2rem auto 0 auto;
        background: #e8f5e9;
        border-color: #81c784;
        color: #2e7d32;
        font-weight: 600;
        letter-spacing: 0.05em;
        font-size: 1rem;
        box-shadow: 0 0 12px #81c78466;
        border-radius: 12px;
        text-align: center;
    }

    /* Responsive */
    @media (max-width: 576px) {
        .info-col {
            flex: 1 1 100%;
        }
        form.mt-3 {
            width: 100%;
            padding: 0 1rem;
        }
        button.btn-success {
            font-size: 1.05rem;
            padding: 0.65rem 1.3rem;
        }
    }
</style>
<div class="page-heading">
    <h3>Status Pendaftaran</h3>
</div>
<div class="card shadow-sm">
    <div class="info-row">
        <div class="info-col">
            <i class="bi bi-book-half"></i>
            <div>
                <div class="text-muted">Program</div>
                <p class="fw-bold mb-0">GenZE Class</p>
            </div>
        </div>
        <div class="info-col">
            <i class="bi bi-currency-dollar"></i>
            <div>
                <div class="text-muted">Harga</div>
                <p class="fw-bold mb-0">Rp{{ number_format($pendaftaran->harga, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <div class="text-center mb-4">
        <div class="text-muted mb-2">Status</div>
        @php
            $badge = match($pendaftaran->status) {
                'pending' => 'bg-warning',
                'confirmed' => 'bg-success',
                'cancelled' => 'bg-danger',
                default => 'bg-secondary'
            };
        @endphp
        <span class="badge {{ $badge }}">{{ ucfirst($pendaftaran->status) }}</span>
    </div>

    @if($pendaftaran->pendaftaranClass && $pendaftaran->pendaftaranClass->jadwalKonfirmasi)
    <div class="schedule-confirm">
        <h6>Jadwal Ditetapkan</h6>
        <p>{{ $pendaftaran->pendaftaranClass->jadwalKonfirmasi->jadwalkelas }}</p>

        <form action="{{ route('siswa.pendaftaran.upload', $pendaftaran->id) }}" method="POST" enctype="multipart/form-data" class="mt-3">
            @csrf
            <label for="bukti_pembayaran" class="form-label">Upload Bukti Pembayaran</label>
            <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="form-control" required>
            <button type="submit" class="btn btn-success mt-3">
                <i class="bi bi-upload me-1"></i> Upload
            </button>
        </form>
    </div>
    @else
    <div class="alert alert-info mt-4" role="alert">
        Jadwal belum dikonfirmasi oleh admin. Silakan tunggu informasi selanjutnya.
    </div>
    @endif
</div>

<div class="container">
    <h3>Status Pendaftaran Guide</h3>

    @if($pendaftaran)
        <p><strong>Paket:</strong> {{ $pendaftaran->paketGuide->nama_paket ?? '-' }}</p>
        <p><strong>Status:</strong>
            @if($pendaftaran->jadwalguide2_konfirmasi)
                Jadwal Dikonfirmasi: {{ $pendaftaran->jadwalKonfirmasi->hari }} - {{ $pendaftaran->jadwalKonfirmasi->jam }}
            @else
                Menunggu konfirmasi admin
            @endif
        </p>

        @if($pendaftaran->file_upload)
            <p><strong>File:</strong> <a href="{{ route('admin.guide.lihatfile', $pendaftaran->id) }}" target="_blank">Lihat File</a></p>
        @endif
    @else
        <p>Belum ada data pendaftaran.</p>
    @endif
</div>
@endsection
