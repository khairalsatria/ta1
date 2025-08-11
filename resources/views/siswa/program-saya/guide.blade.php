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

        @if($pendaftaranGuides->count() > 0)
            @foreach($pendaftaranGuides as $guide)
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1 text-primary fw-bold">
                                {{ $guide->paketGuide->paket_guide ?? $guide->paket_guide }}
                            </h5>
                            <small class="text-muted">
                                Harga: Rp{{ number_format($guide->pendaftaran->harga, 0, ',', '.') }}
                            </small><br>
                            <small>
                                Status:
                                @switch($guide->pendaftaran->status)
                                    @case('pending')
                                        <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split"></i> Pending</span>
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
                            </small>
                        </div>
                        <button class="btn btn-outline-primary btn-sm"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#detail-{{ $guide->id }}"
                                aria-expanded="false"
                                aria-controls="detail-{{ $guide->id }}">
                            <i class="bi bi-eye"></i> Lihat Detail
                        </button>
                    </div>

                    <div class="collapse" id="detail-{{ $guide->id }}">
                        <div class="card-body border-top">
                            {{-- Paket 2: Jadwal & Zoom --}}
                            @if($guide->paket_guide == 2)
                                <h6 class="fw-bold text-primary"><i class="bi bi-calendar-check"></i> Jadwal</h6>
                                <ul class="list-group mb-2">
                                    @forelse($guide->jadwalguide2_pilihan ?? [] as $jadwal)
                                        <li class="list-group-item"><i class="bi bi-clock"></i> {{ $jadwal }}</li>
                                    @empty
                                        <li class="list-group-item text-muted">Belum ada jadwal.</li>
                                    @endforelse
                                </ul>
                                <p><strong>Jadwal Konfirmasi:</strong>
                                    {{ $guide->jadwalKonfirmasi->jadwalguide2 ?? 'Belum dikonfirmasi' }}
                                </p>

                                @if($guide->pendaftaran->status == 'diterima')
                                    <h6 class="fw-bold text-primary"><i class="bi bi-camera-video"></i> Link Zoom</h6>
                                    @forelse($guide->hasilFiles as $hf)
                                        @if($hf->link_zoom)
                                            <a href="{{ $hf->link_zoom }}" target="_blank" class="btn btn-outline-primary btn-sm mb-1">
                                                <i class="bi bi-camera-video"></i> Join Zoom {{ $hf->keterangan ? ' - '.$hf->keterangan : '' }}
                                            </a>
                                        @endif
                                    @empty
                                        <p class="text-muted">Belum ada link Zoom.</p>
                                    @endforelse
                                @endif
                            @endif

                            {{-- Paket 1 & 3: File Upload & Hasil --}}
                            @if(in_array($guide->paket_guide, [1,3]))
                                <h6 class="fw-bold text-primary mt-3"><i class="bi bi-file-earmark-text"></i> File Siswa</h6>
                                @if($guide->file_upload)
                                    <a href="{{ asset('storage/' . $guide->file_upload) }}" target="_blank" class="btn btn-outline-info btn-sm">
                                        <i class="bi bi-download"></i> Lihat File
                                    </a>
                                @else
                                    <p class="text-muted">Belum ada file diunggah.</p>
                                @endif

                                <h6 class="fw-bold text-primary mt-3"><i class="bi bi-folder-check"></i> File Hasil Admin</h6>
                                @if ($guide->hasilFiles->count() > 0)
                                    <ul class="list-group">
                                        @foreach($guide->hasilFiles as $file)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <a href="{{ asset('storage/' . $file->file_hasil) }}" target="_blank" class="text-primary">
                                                        <i class="bi bi-file-earmark-arrow-down"></i> {{ basename($file->file_hasil) }}
                                                    </a>
                                                    @if ($file->keterangan)
                                                        <small class="text-muted d-block">({{ $file->keterangan }})</small>
                                                    @endif
                                                </div>
                                                <span class="badge  text-muted">{{ $file->created_at->format('d M Y') }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-muted">Belum ada file hasil admin.</p>
                                @endif
                            @endif

                            {{-- Tombol Bayar --}}
                            @if($guide->pendaftaran->status == 'pending' && $guide->pendaftaran->link_pembayaran)
                                <a href="{{ $guide->pendaftaran->link_pembayaran }}" target="_blank" class="btn btn-success mt-3">
                                    <i class="bi bi-credit-card"></i> Bayar Sekarang
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- Pagination --}}
            @if($pendaftaranGuides->hasPages())
                <div class="mt-4 d-flex justify-content-center">
                    {{ $pendaftaranGuides->links('pagination::bootstrap-5') }}
                </div>
            @endif
        @else
            <p class="text-muted">Belum ada pendaftaran GenZE Guide.</p>
        @endif
    </section>
</div>
@endsection
