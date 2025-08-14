@extends('landing.layout.main')

@section('title', 'Status Pendaftaran')

@section('content')

<!-- Header -->
<div class="jumbotron jumbotron-fluid page-header position-relative overlay-bottom mb-5">
    <div class="container text-center py-5">
        <h1 class="text-white display-4 fw-bold" style="text-shadow: 2px 2px 10px rgba(0,0,0,0.7);">Status Pendaftaran</h1>
        <div class="d-inline-flex text-white mt-3 fw-semibold">
            <p class="m-0 text-uppercase"><a class="text-white" href="{{ url('/') }}">Home</a></p>
            <i class="fa fa-angle-double-right pt-1 px-3"></i>
            <p class="m-0 text-uppercase text-white">Status</p>
        </div>
    </div>
</div>


<!-- Content -->
<div class="container py-5">
    <div class="card border-0 shadow rounded-4 p-4 mx-auto" style="max-width: 720px;">

        <!-- Tombol Kembali di kiri atas -->
        {{-- <div class="d-flex justify-content-start mb-3">
            <a href="{{ route('siswa.pendaftaran.riwayat') }}" class="btn btn-outline-secondary btn-sm rounded-pill shadow-sm">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div> --}}

        <h4 class="text-center text-success fw-bold mb-4">Detail Pendaftaran</h4>

        <div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="bg-light rounded p-3 shadow-sm h-100">
            <small class="text-muted">Program</small>
            <h5 class="mb-0">{{ $pendaftaran->program->nama_program }}</h5>
        </div>
    </div>
    <div class="col-md-6">
        <div class="bg-light rounded p-3 shadow-sm h-100">
            <small class="text-muted">Harga</small>
            <h5 class="mb-0">Rp{{ number_format($pendaftaran->harga, 0, ',', '.') }}</h5>
        </div>
    </div>
</div>

{{-- Tambahan: Mata Pelajaran & Kelas --}}
@if ($pendaftaran->pendaftaranClass)
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="bg-light rounded p-3 shadow-sm h-100">
            <small class="text-muted">Mata Pelajaran</small>
            <h5 class="mb-0">
                {{ $pendaftaran->pendaftaranClass->mataPelajaran->mata_pelajaran ?? '-' }}
            </h5>
        </div>
    </div>
    <div class="col-md-6">
        <div class="bg-light rounded p-3 shadow-sm h-100">
            <small class="text-muted">Kelas Siswa</small>
            <h5 class="mb-0">
                {{ $pendaftaran->pendaftaranClass->kelasGenze->nama_kelas ?? 'Belum ditetapkan' }}
            </h5>
        </div>
    </div>
</div>
@endif



        <!-- Status Badge -->
        <!-- Status Badge -->
@php
    $badgeClass = match($pendaftaran->status) {
        'menunggu' => 'bg-warning',
        'diterima' => 'bg-success',
        'ditolak' => 'bg-danger',
        default => 'bg-secondary'
    };
@endphp
<div class="text-center my-4">
    <small class="text-muted d-block mb-2">Status</small>
    <span class="badge {{ $badgeClass }} text-white rounded-pill py-2 px-4 text-uppercase shadow-sm">
        {{ ucfirst($pendaftaran->status) }}
    </span>
</div>

<!-- Notifikasi invoice jika sudah diterima -->
@if ($pendaftaran->status === 'diterima')
    <div class="alert alert-success text-center shadow-sm rounded-pill fw-semibold">
        <i class="bi bi-envelope-check me-2"></i>
        Invoice pembayaran telah dikirim ke email Anda ({{ $pendaftaran->user->email ?? '-' }}).
        <br>
        Silakan cek kotak masuk atau folder spam.
    </div>
@endif


        <!-- Conditional Information -->
        @php $tampilkanTombolBayar = false; @endphp

        @if ($pendaftaran->pendaftaranClass && $pendaftaran->pendaftaranClass->jadwalKonfirmasi)
            <div class="text-center mt-4">
                <small class="text-muted">Jadwal Ditetapkan (GenZE Class)</small>
                <p class="fw-semibold text-success mb-0">{{ $pendaftaran->pendaftaranClass->jadwalKonfirmasi->jadwalkelas }}</p>
            </div>
            @php $tampilkanTombolBayar = true; @endphp

        @elseif ($pendaftaran->pendaftaranClass && $pendaftaran->pendaftaranClass->jadwalAlternatif && $pendaftaran->pendaftaranClass->status_alternatif === 'ditawarkan')
            <div class="alert alert-warning text-center mt-4">
                <small class="text-muted d-block mb-2">Jadwal Alternatif Ditawarkan</small>
                <p class="fw-semibold">{{ $pendaftaran->pendaftaranClass->jadwalAlternatif->jadwalkelas }}</p>

                <form action="{{ route('siswa.pendaftaran.genze-class.responAlternatif', $pendaftaran->pendaftaranClass->id) }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="respon" value="terima">
                    <button class="btn btn-success btn-sm me-2"><i class="bi bi-check-circle"></i> Setuju</button>
                </form>

                <form action="{{ route('siswa.pendaftaran.genze-class.responAlternatif', $pendaftaran->pendaftaranClass->id) }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="respon" value="tolak">
                    <button class="btn btn-danger btn-sm"><i class="bi bi-x-circle"></i> Tolak</button>
                </form>
            </div>

        @elseif ($pendaftaran->pendaftaranGuide)
            @php $guide = $pendaftaran->pendaftaranGuide; @endphp

            @if ($guide->paket_guide == 2 && $guide->jadwalKonfirmasi)
                <div class="text-center mt-4">
                    <small class="text-muted">Jadwal Ditetapkan (GenZE Guide - Paket 2)</small>
                    <p class="fw-semibold text-success mb-0">{{ $guide->jadwalKonfirmasi->jadwalguide2 }}</p>
                </div>
                @php $tampilkanTombolBayar = true; @endphp

            @elseif (in_array($guide->paket_guide, [1, 3]) && $guide->file_upload)
                <div class="text-center mt-4">
                    <small class="text-muted">File Upload (GenZE Guide - Paket {{ $guide->paket_guide }})</small>
                    <a href="{{ asset('storage/' . $guide->file_upload) }}" target="_blank" class="btn btn-outline-success mt-2">
                        <i class="bi bi-file-earmark-arrow-down"></i> Lihat File
                    </a>
                </div>
                @php $tampilkanTombolBayar = true; @endphp
            @endif

        @elseif ($pendaftaran->pendaftaranLearn)
            <div class="text-center mt-4">
                <small class="text-muted">Asal Instansi (GenZE Learn)</small>
                <p class="fw-semibold text-success mb-0">{{ $pendaftaran->pendaftaranLearn->asal_instansi }}</p>
            </div>
            @php $tampilkanTombolBayar = true; @endphp

        @else
            <div class="alert alert-info text-center mt-4">
                Jadwal atau data belum dikonfirmasi oleh admin.
            </div>
        @endif

        <!-- Tombol Pembayaran -->
        @if ($tampilkanTombolBayar && $pendaftaran->link_pembayaran)
            <div class="text-center mt-5">
                <p class="text-muted mb-2">Lanjutkan ke pembayaran:</p>
                <button id="pay-button" class="btn btn-success px-4 py-2 rounded-pill fw-semibold shadow-sm">
                    <i class="bi bi-credit-card me-1"></i> Bayar Sekarang
                </button>
            </div>

            <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
            <script>
                document.getElementById('pay-button').addEventListener('click', function () {
                    snap.pay('{{ $pendaftaran->link_pembayaran }}');
                });
            </script>
        @endif
    </div>
</div>


@endsection
