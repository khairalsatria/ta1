@extends('siswa.layout.main')

@section('title', 'GenZE Learn Saya')

@section('content')
<div class="page-heading">
    <div class="row align-items-center mb-3">
        <div class="col-md-6">
            <h2 class="fw-bold mb-1"><i class="bi bi-journal-bookmark-fill text-primary me-2"></i> GenZE Learn Saya</h2>
            <p class="text-muted mb-0">Lihat detail program Anda dan unduh sertifikat jika tersedia.</p>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-md-end mb-0">
                    <li class="breadcrumb-item active" aria-current="page">GenZE Learn</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="section">
        @if(session('error'))
            <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
        @endif

        {{-- LIST PROGRAM --}}
        @if(!$detail)
            <div class="row g-4">
                @forelse($learns as $item)
                    @php $event = $item->pendaftaran->program->genzeLearnEvent ?? null; @endphp
                    <div class="col-lg-6 col-md-12">
                        <div class="card h-100 shadow-sm border-0 hover-shadow transition-all">
                            <div class="card-body">
                                <h5 class="fw-bold text-primary mb-2">
                                    {{ $item->pendaftaran->program->nama_program }}
                                </h5>
                                <div class="small text-muted mb-3">
                                    <div><i class="bi bi-calendar-event me-1 text-primary"></i> <strong>Tanggal:</strong> {{ $event->tanggal_event ?? '-' }}</div>
                                    <div><i class="bi bi-clock me-1 text-primary"></i> <strong>Jam:</strong> {{ $event->jam_event ?? '-' }}</div>
                                </div>
                                <a href="{{ route('siswa.program-saya.learn') }}?id={{ $item->pendaftaran->id }}"
                                   class="btn btn-primary btn-sm">
                                    <i class="bi bi-eye"></i> Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-warning text-center shadow-sm border-0">
                            <i class="bi bi-exclamation-circle me-1"></i> Belum ada program GenZE Learn yang diikuti.
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
           @if ($learns->hasPages())
    <div class="mt-4 d-flex justify-content-center">
        {{ $learns->links('vendor.pagination.bootstrap-5') }}
    </div>
@endif


        @else
            {{-- DETAIL PROGRAM --}}
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
    {{-- Header --}}
    <div class="card-header text-white d-flex justify-content-between align-items-center p-3"
        >
        <h5 class="mb-0 fw-bold">
            <i class="bi bi-info-circle-fill me-2"></i> Detail Program
        </h5>
        <a href="{{ route('siswa.program-saya.learn') }}" class="btn btn-sm btn-light rounded-pill shadow-sm px-3">
            <i class="bi bi-arrow-left-circle me-1"></i> Kembali
        </a>
    </div>

    {{-- Body --}}
    <div class="card-body p-4">
        <h3 class="fw-bold text-primary mb-3">{{ $learn->pendaftaran->program->nama_program }}</h3>

        <div class="row g-3">
            <div class="col-md-6">
                <div class="info-box p-3 rounded-3 shadow-sm  h-100">
                    <p class="mb-2"><i class="bi bi-person-badge-fill text-primary me-2 fs-5"></i>
                        <strong>Instruktur:</strong> {{ $learn->pendaftaran->program->instruktur ?? '-' }}
                    </p>
                    <p class="mb-2"><i class="bi bi-calendar-event-fill text-success me-2 fs-5"></i>
                        <strong>Tanggal Event:</strong> {{ $event->tanggal_event ?? '-' }}
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-box p-3 rounded-3 shadow-sm  h-100">
                    <p class="mb-2"><i class="bi bi-clock-fill text-warning me-2 fs-5"></i>
                        <strong>Jam Event:</strong> {{ $event->jam_event ?? '-' }}
                    </p>
                    <p class="mb-0"><i class="bi bi-camera-video-fill text-danger me-2 fs-5"></i>
                        <strong>Link Zoom:</strong>
                        @if($event && $event->link_zoom)
                            <a href="{{ $event->link_zoom }}" target="_blank"
                               class="text-decoration-none fw-semibold text-primary hover-underline">
                               Klik di sini
                            </a>
                        @else
                            <span class="text-muted">Belum tersedia</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="card-footer  d-flex justify-content-end p-3">
        @if($learn->sertifikat)
            <a href="{{ route('siswa.program-saya.learn.sertifikat', $learn->pendaftaran->id) }}"
               class="btn btn-success rounded-pill shadow-sm px-4 py-2 hover-scale">
                <i class="bi bi-download me-2"></i> Unduh Sertifikat
            </a>
        @else
            <button class="btn btn-secondary rounded-pill shadow-sm px-4 py-2" disabled>
                <i class="bi bi-file-earmark-x me-2"></i> Sertifikat belum tersedia
            </button>
        @endif
    </div>
</div>
        @endif
    </section>
</div>

{{-- CSS tambahan untuk efek hover --}}
<style>
    .hover-shadow:hover {
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,.15) !important;
        transform: translateY(-2px);
    }
    .transition-all {
        transition: all 0.3s ease;
    }
</style>
@endsection
