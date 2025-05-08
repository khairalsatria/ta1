@extends('landing.layout.main')

@section('title', 'Status Pendaftaran')

@section('content')
<div class="page-heading">
    <h3 class="mb-3">Status Pendaftaran</h3>
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <h6 class="text-muted">Program</h6>
                    <p class="fw-bold mb-0">GenZE Class</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted">Harga</h6>
                    <p class="fw-bold text-primary mb-0">Rp{{ number_format($pendaftaran->harga, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="mb-3">
                <h6 class="text-muted">Status</h6>
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
            <div class="mt-4">
                <h6 class="text-muted">Jadwal Ditetapkan</h6>
                <p class="fw-semibold text-success">{{ $pendaftaran->pendaftaranClass->jadwalKonfirmasi->jadwalkelas }}</p>

                <form action="{{ route('siswa.pendaftaran.upload', $pendaftaran->id) }}" method="POST" enctype="multipart/form-data" class="mt-3">
                    @csrf
                    <div class="mb-3">
                        <label for="bukti_pembayaran" class="form-label">Upload Bukti Pembayaran</label>
                        <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success">
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
    </div>
</div>
@endsection
