@extends('landing.layout.main')

@section('title', 'Status Pendaftaran')

@section('content')

<!-- Header Start -->
<div class="jumbotron jumbotron-fluid page-header position-relative overlay-bottom mb-5">
    <div class="container text-center py-5">
        <h1 class="text-white display-4 font-weight-bold" style="text-shadow: 2px 2px 10px rgba(0,0,0,0.7);">Status Pendaftaran</h1>
        <div class="d-inline-flex text-white mt-3 font-weight-semibold">
            <p class="m-0 text-uppercase"><a class="text-white" href="{{ url('/') }}">Home</a></p>
            <i class="fa fa-angle-double-right pt-1 px-3"></i>
            <p class="m-0 text-uppercase text-white">Status</p>
        </div>
    </div>
</div>
<!-- Header End -->

<!-- Content Start -->
<div class="container py-5">
    <div class="card shadow-sm border-0 rounded-4 p-4 mx-auto" style="max-width: 720px;">
        <h4 class="text-success font-weight-bold mb-4 text-center">Informasi Pendaftaran Anda</h4>

        <div class="row mb-3">
            <div class="col-md-6 mb-3">
                <div class="bg-light rounded p-3 h-100 shadow-sm">
                    <div class="text-muted small">Program</div>
                    <h5 class="mb-0 text-dark">{{ $pendaftaran->program->nama_program }}</h5>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="bg-light rounded p-3 h-100 shadow-sm">
                    <div class="text-muted small">Harga</div>
                    <h5 class="mb-0 text-dark">Rp{{ number_format($pendaftaran->harga, 0, ',', '.') }}</h5>
                </div>
            </div>
        </div>

        <!-- Status -->
        <div class="text-center my-3">
            <div class="text-muted small mb-2">Status</div>
            @php
                $badgeClass = match($pendaftaran->status) {
                    'menunggu' => 'bg-warning',
                    'diterima' => 'bg-success',
                    'ditolak' => 'bg-danger',
                    default => 'bg-secondary'
                };
            @endphp
            <span class="badge {{ $badgeClass }} py-2 px-4 rounded-pill text-uppercase shadow-sm">
                {{ ucfirst($pendaftaran->status) }}
            </span>
        </div>

        <!-- Jadwal / Upload -->
        @php $tampilkanTombolBayar = false; @endphp

        {{-- Jadwal Konfirmasi untuk GenZE Class --}}
        @if ($pendaftaran->pendaftaranClass && $pendaftaran->pendaftaranClass->jadwalKonfirmasi)
            <div class="text-center mt-4">
                <div class="text-muted small">Jadwal Ditetapkan (GenZE Class)</div>
                <p class="fw-bold text-success mb-0">{{ $pendaftaran->pendaftaranClass->jadwalKonfirmasi->jadwalkelas }}</p>
            </div>
            @php $tampilkanTombolBayar = true; @endphp

        {{-- Jadwal Alternatif Ditawarkan --}}
        @elseif ($pendaftaran->pendaftaranClass && $pendaftaran->pendaftaranClass->jadwalAlternatif && $pendaftaran->pendaftaranClass->status_alternatif === 'ditawarkan')
            <div class="alert alert-warning text-center mt-4">
                <div class="text-muted small mb-2">Jadwal Alternatif Ditawarkan oleh Admin</div>
                <p class="fw-bold text-dark mb-3">{{ $pendaftaran->pendaftaranClass->jadwalAlternatif->jadwalkelas }}</p>

                <form action="{{ route('siswa.pendaftaran.genze-class.responAlternatif', $pendaftaran->pendaftaranClass->id) }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="respon" value="terima">
                    <button type="submit" class="btn btn-success btn-sm px-3 me-2">
                        <i class="bi bi-check-circle"></i> Setuju
                    </button>
                </form>

                <form action="{{ route('siswa.pendaftaran.genze-class.responAlternatif', $pendaftaran->pendaftaranClass->id) }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="respon" value="tolak">
                    <button type="submit" class="btn btn-danger btn-sm px-3">
                        <i class="bi bi-x-circle"></i> Tolak
                    </button>
                </form>
            </div>

        {{-- GenZE Guide - Paket 2 --}}
        @elseif ($pendaftaran->pendaftaranGuide)
            @php $guide = $pendaftaran->pendaftaranGuide; @endphp
            @if ($guide->paket_guide == 2 && $guide->jadwalKonfirmasi)
                <div class="text-center mt-4">
                    <div class="text-muted small">Jadwal Ditetapkan (GenZE Guide - Paket 2)</div>
                    <p class="fw-bold text-success mb-0">{{ $guide->jadwalKonfirmasi->jadwalguide2 }}</p>
                </div>
                @php $tampilkanTombolBayar = true; @endphp
            @elseif (in_array($guide->paket_guide, [1, 3]) && $guide->file_upload)
                <div class="text-center mt-4">
                    <div class="text-muted small">File Upload (GenZE Guide - Paket {{ $guide->paket_guide }})</div>
                    <a href="{{ asset('storage/' . $guide->file_upload) }}" target="_blank" class="btn btn-outline-success mt-2">
                        <i class="bi bi-file-earmark-arrow-down"></i> Lihat File
                    </a>
                </div>
                @php $tampilkanTombolBayar = true; @endphp
            @endif

        {{-- GenZE Learn --}}
        @elseif ($pendaftaran->pendaftaranLearn)
            <div class="text-center mt-4">
                <div class="text-muted small">Asal Instansi (GenZE Learn)</div>
                <p class="fw-bold text-success mb-0">{{ $pendaftaran->pendaftaranLearn->asal_instansi }}</p>
            </div>
            @php $tampilkanTombolBayar = true; @endphp

        {{-- Belum ada konfirmasi apapun --}}
        @else
            <div class="alert alert-info text-center mt-4">
                Jadwal atau data belum dikonfirmasi admin. Silakan tunggu informasi selanjutnya.
            </div>
        @endif

        <!-- Tombol Bayar -->
        @if ($tampilkanTombolBayar && $pendaftaran->link_pembayaran)
            <div class="text-center mt-5">
                <p class="text-muted mb-2">Lanjutkan ke pembayaran:</p>
                <button id="pay-button" class="btn btn-success px-4 py-2 rounded-pill fw-semibold shadow">
                    <i class="bi bi-credit-card me-1"></i> Bayar Sekarang
                </button>
            </div>

            <script src="https://app.sandbox.midtrans.com/snap/snap.js"
                data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
            <script>
                document.getElementById('pay-button').addEventListener('click', function () {
                    snap.pay('{{ $pendaftaran->link_pembayaran }}');
                });
            </script>
        @endif
    </div>
</div>
<!-- Content End -->
<!-- Tombol Kembali -->
<div class="text-center mt-4">
    <a href="{{ route('siswa.pendaftaran.riwayat') }}" class="btn btn-outline-secondary px-4 py-2 rounded-pill fw-semibold shadow-sm">
        <i class="bi bi-arrow-left"></i> Kembali ke Riwayat
    </a>
</div>

@endsection
