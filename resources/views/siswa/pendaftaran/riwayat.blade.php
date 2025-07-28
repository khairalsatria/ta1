@extends('landing.layout.main')

@section('title', 'Riwayat Pendaftaran')

@section('content')

<!-- Header -->
<div class="jumbotron jumbotron-fluid page-header position-relative overlay-bottom mb-5">
    <div class="container text-center py-5">
        <h1 class="text-white display-4 font-weight-bold" style="text-shadow: 2px 2px 10px rgba(0,0,0,0.7);">Riwayat Pendaftaran</h1>
        <div class="d-inline-flex text-white mt-3 font-weight-semibold">
            <p class="m-0 text-uppercase"><a class="text-white" href="{{ url('/') }}">Home</a></p>
            <i class="fa fa-angle-double-right pt-1 px-3"></i>
            <p class="m-0 text-uppercase text-white">Riwayat</p>
        </div>
    </div>
</div>

<!-- Content -->
<div class="container py-5">
    <div class="card shadow-sm border-0 rounded-4 p-4">
        <h4 class="text-dark font-weight-bold mb-4">Daftar Pendaftaran Anda</h4>

        @if($riwayat->count())
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr class="text-muted small">
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
                                    'menunggu' => 'bg-warning',
                                    'diterima' => 'bg-success',
                                    'ditolak' => 'bg-danger',
                                    default => 'bg-secondary'
                                };
                            @endphp
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $item->program->nama_program }}</td>
                                <td>Rp{{ number_format($item->harga, 0, ',', '.') }}</td>
                                <td><span class="badge {{ $badgeClass }} rounded-pill">{{ ucfirst($item->status) }}</span></td>
                                <td>{{ $item->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('siswa.pendaftaran.status', $item->id) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-eye"></i> Lihat
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info text-center mb-0">
                Anda belum memiliki riwayat pendaftaran.
            </div>
        @endif
    </div>
</div>

@endsection
