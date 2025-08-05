@extends('landing.layout.main')

@section('title', 'Riwayat Pendaftaran')

@section('content')

<!-- Header -->
<div class="jumbotron jumbotron-fluid page-header position-relative overlay-bottom mb-5">
    <div class="container text-center py-5">
        <h1 class="text-white display-4 font-weight-bold" style="text-shadow: 2px 2px 10px rgba(0,0,0,0.7);">
            Riwayat Pendaftaran
        </h1>
        <div class="d-inline-flex text-white mt-3 font-weight-semibold">
            <p class="m-0 text-uppercase"><a class="text-white" href="{{ url('/') }}">Home</a></p>
            <i class="fa fa-angle-double-right pt-1 px-3"></i>
            <p class="m-0 text-uppercase text-white">Riwayat</p>
        </div>
    </div>
</div>

<!-- Content -->
<div class="container py-5">
    <div class="card shadow border-0 rounded-4 p-4">
        <h4 class="text-dark font-weight-bold mb-4">Riwayat Pendaftaran</h4>

        @if($riwayat->count())
            <div class="table-responsive">
                <table class="table table-borderless align-middle">
                    <thead class="text-muted small text-uppercase bg-light">
                        <tr>
                            <th>#</th>
                            <th>Program</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayat as $i => $item)
                            @php
                                $badgeClass = match($item->status) {
                                    'menunggu' => 'bg-warning-subtle text-warning',
                                    'diterima' => 'bg-success-subtle text-success',
                                    'ditolak' => 'bg-danger-subtle text-danger',
                                    default => 'bg-secondary-subtle text-secondary'
                                };
                            @endphp
                            <tr class="border-bottom">
                                <td>{{ $i + 1 }}</td>
                                <td class="fw-semibold">{{ $item->program->nama_program }}</td>
                                <td>Rp{{ number_format($item->harga, 0, ',', '.') }}</td>
                                <td><span class="badge {{ $badgeClass }} rounded-pill px-3 py-2 text-capitalize">
                                    {{ $item->status }}</span></td>
                                <td>{{ $item->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('siswa.pendaftaran.status', $item->id) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                        <i class="bi bi-eye me-1"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $riwayat->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="alert alert-info text-center mb-0">
                Anda belum memiliki riwayat pendaftaran.
            </div>
        @endif
    </div>
</div>

@endsection
