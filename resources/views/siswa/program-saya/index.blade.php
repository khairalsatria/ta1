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

    <section id="basic-list-group">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">📝 Program yang Kamu Daftarkan</h4>
                    </div>
                    <div class="card-body">
                        @if($pendaftarans->isEmpty())
                            <div class="text-center py-5">
                                <img src="{{ asset('images/empty-state.svg') }}" alt="Belum ada program" style="max-width: 280px;" class="mb-3">
                                <p class="text-muted fs-5">Kamu belum mendaftar program apa pun.</p>
                                <a href="{{ url('/program') }}" class="btn btn-primary mt-2">🌟 Lihat Program</a>
                            </div>
                        @else
                            <div class="list-group">
                                @foreach($pendaftarans as $pendaftaran)
                                    @php
                                        $badgeClass = match($pendaftaran->status) {
                                            'pending' => 'warning text-dark',
                                            'verifikasi', 'confirmed' => 'success',
                                            'cancelled' => 'danger',
                                            default => 'secondary'
                                        };
                                    @endphp

                                    <div class="list-group-item py-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h5 class="mb-0 text-primary">
                                                📚 {{ $pendaftaran->program->nama_program ?? 'Program Tidak Diketahui' }}
                                            </h5>
                                            <span class="badge bg-{{ $badgeClass }} rounded-pill text-capitalize">
                                                {{ $pendaftaran->status }}
                                            </span>
                                        </div>

                                        <ul class="mb-2 small text-muted ps-3">
                                            <li><strong><i class="bi bi-tag"></i> Harga:</strong> Rp{{ number_format($pendaftaran->harga, 0, ',', '.') }}</li>

                                            @if($pendaftaran->pendaftaranClass && $pendaftaran->pendaftaranClass->jadwalKonfirmasi)
                                                <li><strong><i class="bi bi-calendar-event"></i> Jadwal:</strong> {{ $pendaftaran->pendaftaranClass->jadwalKonfirmasi->jadwalkelas }}</li>
                                            @elseif($pendaftaran->pendaftaranGuide)
                                                @php $guide = $pendaftaran->pendaftaranGuide; @endphp
                                                @if ($guide->paket_guide == 2 && $guide->jadwalKonfirmasi)
                                                    <li><strong><i class="bi bi-clock-history"></i> Jadwal:</strong> {{ $guide->jadwalKonfirmasi->jadwalguide2 }}</li>
                                                @elseif (in_array($guide->paket_guide, [1, 3]) && $guide->file_upload)
                                                    <li><strong><i class="bi bi-file-earmark-text"></i> File:</strong>
                                                        <a href="{{ asset('storage/' . $guide->file_upload) }}" target="_blank">Lihat</a>
                                                    </li>
                                                @endif
                                            @elseif($pendaftaran->pendaftaranLearn)
                                                <li><strong><i class="bi bi-building"></i> Instansi:</strong> {{ $pendaftaran->pendaftaranLearn->asal_instansi }}</li>
                                            @else
                                                <li class="text-muted"><i class="bi bi-info-circle"></i> Menunggu konfirmasi admin</li>
                                            @endif
                                        </ul>

                                        @if($pendaftaran->link_pembayaran)
                                            <div class="text-end">
                                                <a href="#" onclick="snap.pay('{{ $pendaftaran->link_pembayaran }}')" class="btn btn-outline-success btn-sm">
                                                    💳 Bayar Sekarang
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            {{-- Pagination --}}
                            <div class="mt-4 d-flex justify-content-center">
                                {{ $pendaftarans->links('vendor.pagination.bootstrap-5') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
@endsection
