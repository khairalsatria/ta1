@php use Illuminate\Support\Facades\Auth; @endphp

@extends('siswa.layout.main')

@section('title', 'Status Pendaftaran')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Status Pendaftaran</h3>
                <p class="text-subtitle text-muted">Berikut daftar program yang telah kamu daftarkan dan statusnya.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Status Pendaftaran</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">

        {{-- Flash Success (jika ada) --}}
        @if(session('success'))
            <div class="alert alert-success shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- CARD UTAMA LIST PROGRAM --}}
        <div class="card">
            <div class="card-header">
                <h4>📝 Program yang Kamu Daftarkan</h4>
            </div>
            <div class="card-body">

                @if($pendaftarans->isEmpty())
                    <div class="text-center py-5">
                        <img src="{{ asset('images/empty-state.svg') }}" alt="Belum ada program" style="max-width:220px;" class="mb-3">
                        <p class="text-muted fs-5 mb-3">Kamu belum mendaftar program apa pun.</p>
                        <a href="{{ url('/program') }}" class="btn btn-primary px-4 py-2">
                            🌟 Lihat Program
                        </a>
                    </div>
                @else

                    {{-- Loop tiap pendaftaran sebagai “blok” mirip daftar materi di halaman kelas --}}
                    @foreach($pendaftarans as $pendaftaran)
                        @php
                            $badgeClass = match($pendaftaran->status) {
                                'pending' => 'bg-warning text-dark',
                                'verifikasi', 'confirmed' => 'bg-success',
                                'cancelled' => 'bg-danger',
                                default => 'bg-secondary'
                            };
                        @endphp

                        <div class="mb-4 pb-3 border-bottom pendaftar-item">

                            {{-- Judul + Status --}}
                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                                <h5 class="mb-2 text-primary fw-semibold">
                                    📚 {{ $pendaftaran->program->nama_program ?? 'Program Tidak Diketahui' }}
                                </h5>
                                @php
    $badgeClass = match($pendaftaran->status) {
        'diterima' => 'bg-success text-white',   // hijau
        'menunggu' => 'bg-warning text-dark',    // kuning
        'ditolak'  => 'bg-danger text-white',    // merah
        default    => 'bg-secondary text-white', // default abu-abu
    };
@endphp

<span class="badge {{ $badgeClass }} rounded-pill text-capitalize px-3 py-1 ">
    {{ $pendaftaran->status }}
</span>

                            </div>

                            {{-- Detail Utama --}}
                            <ul class="list-group small mb-2">
    @if($pendaftaran->pendaftaranClass && $pendaftaran->pendaftaranClass->jadwalKonfirmasi)
        <li class="list-group-item">
            📅 <strong>Jadwal:</strong> {{ $pendaftaran->pendaftaranClass->jadwalKonfirmasi->jadwalkelas }}
        </li>
        <li class="list-group-item">
            🏫 <strong>Kelas:</strong> {{ $pendaftaran->pendaftaranClass->kelas }}
        </li>
        <li class="list-group-item">
            📘 <strong>Mapel:</strong> {{ $pendaftaran->pendaftaranClass->mataPelajaran->mata_pelajaran }}
        </li>

    @elseif($pendaftaran->pendaftaranGuide)
        @php $guide = $pendaftaran->pendaftaranGuide; @endphp
        @if ($guide->paket_guide == 2 && $guide->jadwalKonfirmasi)
            <li class="list-group-item">
                ⏰ <strong>Jadwal:</strong> {{ $guide->jadwalKonfirmasi->jadwalguide2 }}
            </li>
        @elseif (in_array($guide->paket_guide, [1, 3]) && $guide->file_upload)
            <li class="list-group-item">
                📄 <strong>File:</strong> <a href="{{ asset('storage/' . $guide->file_upload) }}" target="_blank">Lihat</a>
            </li>
        @endif

    @elseif($pendaftaran->pendaftaranLearn)
        <li class="list-group-item">
            🏢 <strong>Instansi:</strong> {{ $pendaftaran->pendaftaranLearn->asal_instansi }}
        </li>

    @else
        <li class="list-group-item text-muted">
            ℹ️ Menunggu jadwal dikonfirmasi admin
        </li>
    @endif

    <li class="list-group-item">
        💰 <strong>Harga:</strong> Rp{{ number_format($pendaftaran->harga, 0, ',', '.') }}
    </li>
</ul>


                            {{-- Tombol Aksi (Bayar) --}}
                            @if($pendaftaran->link_pembayaran)
   @php
    $jadwalTerkonfirmasi = false;

    // Jika tipe program adalah Class
    if ($pendaftaran->pendaftaranClass && $pendaftaran->pendaftaranClass->jadwalKonfirmasi) {
        $jadwalTerkonfirmasi = true;
    }

    // Jika tipe program adalah Guide (paket 2 dengan jadwal konfirmasi)
    if ($pendaftaran->pendaftaranGuide && $pendaftaran->pendaftaranGuide->paket_guide == 2 && $pendaftaran->pendaftaranGuide->jadwalKonfirmasi) {
        $jadwalTerkonfirmasi = true;
    }

    // Jika tipe program adalah Learn, langsung true karena tidak ada konfirmasi jadwal
    if ($pendaftaran->pendaftaranLearn) {
        $jadwalTerkonfirmasi = true;
    }
@endphp

@if($jadwalTerkonfirmasi && $pendaftaran->status !== 'diterima')
    <div>
        <a href="#"
           onclick="snap.pay('{{ $pendaftaran->link_pembayaran }}')"
           class="btn btn-outline-success btn-sm">
            💳 Bayar Sekarang
        </a>
    </div>
@endif

@endif

                        </div>
                    @endforeach

                    {{-- Pagination --}}
                    <div class="mt-3 d-flex justify-content-center">
                        {{ $pendaftarans->links('vendor.pagination.bootstrap-5') }}
                    </div>

                @endif
            </div>
        </div>

    </section>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

{{-- Styling tambahan agar nuansanya mendekati halaman "Kelas Saya" --}}
<style>
    .pendaftar-item:last-of-type {
        border-bottom: none;
        padding-bottom: 0;
        margin-bottom: 0;
    }
    .pendaftar-item .badge {
        font-size: .75rem;
        letter-spacing: .3px;
    }
    .pendaftar-item h5 {
        font-size: 1.05rem;
    }
    .info-list a {
        text-decoration: none;
    }
    .info-list a:hover {
        text-decoration: underline;
    }
</style>
@endsection
