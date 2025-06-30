@extends('siswa.layout.main')

@section('title', 'Status Pendaftaran')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center fw-bold">Program yang Kamu Daftarkan</h2>

    @if($pendaftarans->isEmpty())
        <div class="text-center py-5">
            <img src="{{ asset('images/empty-state.svg') }}" alt="Belum ada program" style="max-width: 300px;" class="mb-4">
            <h5 class="text-muted">Kamu belum mendaftar program apa pun.</h5>
            <a href="{{ url('/program') }}" class="btn btn-outline-primary mt-3">Lihat Program</a>
        </div>
    @else
        <div class="row g-4">
            @foreach($pendaftarans as $pendaftaran)
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100 rounded-4">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title mb-2 text-primary fw-semibold">
                                {{ $pendaftaran->program->nama_program ?? 'Program Tidak Diketahui' }}
                            </h5>

                            <p class="mb-1">
                                <strong>Status:</strong>
                                @php
                                    $badgeClass = match($pendaftaran->status) {
                                        'pending' => 'warning text-dark',
                                        'verifikasi', 'confirmed' => 'success',
                                        'cancelled' => 'danger',
                                        default => 'secondary'
                                    };
                                @endphp
                                <span class="badge rounded-pill bg-{{ $badgeClass }}">
                                    {{ ucfirst($pendaftaran->status) }}
                                </span>
                            </p>

                            <p class="mb-1"><strong>Harga:</strong> Rp{{ number_format($pendaftaran->harga, 0, ',', '.') }}</p>

                            {{-- Detail berdasarkan tipe program --}}
                            @if($pendaftaran->pendaftaranClass && $pendaftaran->pendaftaranClass->jadwalKonfirmasi)
                                <p class="mb-1"><strong>Jadwal:</strong> {{ $pendaftaran->pendaftaranClass->jadwalKonfirmasi->jadwalkelas }}</p>
                            @elseif($pendaftaran->pendaftaranGuide)
                                @php $guide = $pendaftaran->pendaftaranGuide; @endphp
                                @if ($guide->paket_guide == 2 && $guide->jadwalKonfirmasi)
                                    <p class="mb-1"><strong>Jadwal:</strong> {{ $guide->jadwalKonfirmasi->jadwalguide2 }}</p>
                                @elseif (in_array($guide->paket_guide, [1, 3]) && $guide->file_upload)
                                    <p class="mb-1"><strong>File:</strong>
                                        <a href="{{ asset('storage/' . $guide->file_upload) }}" target="_blank">Lihat File</a>
                                    </p>
                                @endif
                            @elseif($pendaftaran->pendaftaranLearn)
                                <p class="mb-1"><strong>Instansi:</strong> {{ $pendaftaran->pendaftaranLearn->asal_instansi }}</p>
                            @else
                                <p class="mb-1 text-muted">Belum dikonfirmasi oleh admin.</p>
                            @endif

                            {{-- Tombol Bayar --}}
                            @if($pendaftaran->link_pembayaran)
                                <a href="#" onclick="snap.pay('{{ $pendaftaran->link_pembayaran }}')" class="btn btn-sm btn-outline-success mt-auto w-100">
                                    💳 Bayar Sekarang
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
@endsection
