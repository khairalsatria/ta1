@php use Illuminate\Support\Facades\Auth; @endphp

@extends('siswa.layout.main')

@section('title', 'My Guide Program')

@section('content')
<div class="page-heading">
    <div class="page-title mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="fw-bold text-primary mb-1">
                    <i class="bi bi-flag-fill"></i> GenZE Guide Saya
                </h2>
                <p class="text-muted mb-0">
                    Lihat status pendaftaran, jadwal (untuk paket 2), link Zoom, dan file hasil.
                </p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a href="{{ route('siswa.dashboard') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left-circle"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>

    <section class="section">
        @if(session('success'))
            <div class="alert alert-success shadow-sm rounded">{{ session('success') }}</div>
        @endif

        <div class="card border-0 shadow-lg rounded-3">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-card-list"></i> Detail Pendaftaran
                </h5>
                @if($pendaftaranGuide)
                    <span class="badge bg-light text-primary">
                        Paket {{ $pendaftaranGuide->paketGuide->paket_guide ?? $pendaftaranGuide->paket_guide }}
                    </span>
                @endif
            </div>
            <div class="card-body">
                @if($pendaftaranGuide)
                    <div class="mb-3">
                        <p class="mb-1">
                            <strong>Harga:</strong>
                            <span class="text-success fw-semibold">
                                Rp{{ number_format($pendaftaranGuide->pendaftaran->harga, 0, ',', '.') }}
                            </span>
                        </p>
                        <p class="mb-1">
                            <strong>Status Pembayaran:</strong>
                            @switch($pendaftaranGuide->pendaftaran->status)
                                @case('pending')
                                    <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split"></i> Menunggu Pembayaran</span>
                                    @break
                                @case('paid')
                                    <span class="badge bg-success"><i class="bi bi-check-circle-fill"></i> Lunas</span>
                                    @break
                                @case('failed')
                                    <span class="badge bg-danger"><i class="bi bi-x-circle-fill"></i> Gagal</span>
                                    @break
                                @case('diterima')
                                    <span class="badge bg-info text-dark"><i class="bi bi-check-circle"></i> Diterima</span>
                                    @break
                                @default
                                    <span class="badge bg-secondary">-</span>
                            @endswitch
                        </p>
                    </div>

                    {{-- Paket 2: Jadwal dan Link Zoom --}}
                    @if($pendaftaranGuide->paket_guide == 2)
                        <div class="mt-3">
                            <h6 class="fw-bold text-primary"><i class="bi bi-calendar-check"></i> Jadwal</h6>
                            <ul class="list-group mb-2">
                                @forelse($pendaftaranGuide->jadwalguide2_pilihan ?? [] as $jadwal)
                                    <li class="list-group-item"><i class="bi bi-clock"></i> {{ $jadwal }}</li>
                                @empty
                                    <li class="list-group-item text-muted">Belum ada jadwal yang dipilih.</li>
                                @endforelse
                            </ul>
                            <p><strong>Jadwal Konfirmasi:</strong>
                                <span class="text-dark">
                                    {{ $pendaftaranGuide->jadwalKonfirmasi->jadwalguide2 ?? 'Belum dikonfirmasi' }}
                                </span>
                            </p>
                        </div>

                        @if($pendaftaranGuide->pendaftaran->status == 'diterima')
                            <div class="mt-3">
                                <h6 class="fw-bold text-primary"><i class="bi bi-camera-video"></i> Link Zoom</h6>
                                @forelse($pendaftaranGuide->hasilFiles as $hf)
                                    @if($hf->link_zoom)
                                        <a href="{{ $hf->link_zoom }}" class="btn btn-outline-primary btn-sm mt-1" target="_blank">
                                            <i class="bi bi-camera-video"></i> Join Zoom {{ $hf->keterangan ? ' - '.$hf->keterangan : '' }}
                                        </a>
                                    @endif
                                @empty
                                    <p class="text-muted">Belum ada link Zoom.</p>
                                @endforelse
                            </div>
                        @endif
                    @endif

                    {{-- Paket 1 & 3: File Upload dan File Hasil --}}
                    @if(in_array($pendaftaranGuide->paket_guide, [1,3]))
                        <div class="mt-4">
                            <h6 class="fw-bold text-primary"><i class="bi bi-file-earmark-text"></i> File Siswa</h6>
                            @if($pendaftaranGuide->file_upload)
                                <a href="{{ asset('storage/' . $pendaftaranGuide->file_upload) }}" target="_blank" class="btn btn-outline-info btn-sm">
                                    <i class="bi bi-download"></i> Lihat File
                                </a>
                            @else
                                <p class="text-muted">Belum ada file diunggah.</p>
                            @endif
                        </div>

                        <div class="mt-4">
                            <h6 class="fw-bold text-primary"><i class="bi bi-folder-check"></i> File Hasil dari Admin</h6>
                            @if ($pendaftaranGuide->hasilFiles->count() > 0)
                                <ul class="list-group">
                                    @foreach($pendaftaranGuide->hasilFiles as $file)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <a href="{{ asset('storage/' . $file->file_hasil) }}" target="_blank" class="text-primary">
                                                    <i class="bi bi-file-earmark-arrow-down"></i> {{ basename($file->file_hasil) }}
                                                </a>
                                                @if ($file->keterangan)
                                                    <small class="text-muted d-block">({{ $file->keterangan }})</small>
                                                @endif
                                            </div>
                                            <span class="badge bg-light text-muted">{{ $file->created_at->format('d M Y') }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">Belum ada file hasil dari admin.</p>
                            @endif
                        </div>
                    @endif

                    {{-- Tombol Bayar --}}
                    @if($pendaftaranGuide->pendaftaran->status == 'pending' && $pendaftaranGuide->pendaftaran->link_pembayaran)
                        <a href="{{ $pendaftaranGuide->pendaftaran->link_pembayaran }}"
                           target="_blank" class="btn btn-success mt-3">
                            <i class="bi bi-credit-card"></i> Bayar Sekarang
                        </a>
                    @endif
                @else
                    <p class="text-muted">Belum ada pendaftaran GenZE Guide.</p>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection
