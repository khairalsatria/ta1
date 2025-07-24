@extends('siswa.layout.main')

@section('title', 'GenZE Learn Saya')

@section('content')
<div class="page-heading mb-4">
    <h3 class="fw-bold">📘 GenZE Learn Saya</h3>
    <p class="text-muted">Lihat detail program dan akses sertifikat Anda.</p>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(!$detail)
        {{-- LIST PROGRAM --}}
        <div class="row">
            @forelse($learns as $item)
                @php $event = $item->pendaftaran->program->genzeLearnEvent ?? null; @endphp
                <div class="col-md-6">
                    <div class="card shadow-sm mb-4 h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->pendaftaran->program->nama_program }}</h5>
                            <p class="mb-1"><i class="bi bi-calendar-event"></i> <strong>Tanggal:</strong> {{ $event->tanggal_event ?? '-' }}</p>
                            <p class="mb-1"><i class="bi bi-clock"></i> <strong>Jam:</strong> {{ $event->jam_event ?? '-' }}</p>
                            <a href="{{ route('siswa.program-saya.learn') }}?id={{ $item->pendaftaran->id }}" class="btn btn-sm btn-outline-primary mt-2">
                                <i class="bi bi-eye"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning text-center">
                        Belum ada program GenZE Learn yang diikuti.
                    </div>
                </div>
            @endforelse
        </div>
    @else
        {{-- DETAIL PROGRAM --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-info-circle-fill me-1"></i> Detail Program</h5>
                <a href="{{ route('siswa.program-saya.learn') }}" class="btn btn-sm btn-light">
                    <i class="bi bi-arrow-left-circle"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <h4 class="fw-bold">{{ $learn->pendaftaran->program->nama_program }}</h4>
                <p><i class="bi bi-person-badge"></i> <strong>Instruktur:</strong> {{ $learn->pendaftaran->program->instruktur ?? '-' }}</p>
                <p><i class="bi bi-calendar-event"></i> <strong>Tanggal Event:</strong> {{ $event->tanggal_event ?? '-' }}</p>
                <p><i class="bi bi-clock"></i> <strong>Jam Event:</strong> {{ $event->jam_event ?? '-' }}</p>
                <p><i class="bi bi-camera-video"></i> <strong>Link Zoom:</strong>
                    @if($event && $event->link_zoom)
                        <a href="{{ $event->link_zoom }}" target="_blank">{{ $event->link_zoom }}</a>
                    @else
                        <span class="text-muted">Belum tersedia</span>
                    @endif
                </p>
            </div>
            <div class="card-footer bg-white">
                @if($learn->sertifikat)
                    <a href="{{ route('siswa.program-saya.learn.sertifikat', $learn->pendaftaran->id) }}" class="btn btn-success">
                        <i class="bi bi-download"></i> Unduh Sertifikat
                    </a>
                @else
                    <button class="btn btn-secondary" disabled>
                        <i class="bi bi-file-earmark-x"></i> Sertifikat belum tersedia
                    </button>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection
