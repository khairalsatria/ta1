@extends('admin.layout.main')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Daftar Pendaftaran</h3>
                <p class="text-subtitle text-muted">Tabel pendaftaran dengan fitur pencarian dan sort otomatis.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Daftar Pendaftaran</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Data Pendaftaran</h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th>Status</th>
                            <th>Konfirmasi Jadwal</th>
                            <th>Verifikasi Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendaftaranList as $index => $pendaftaran)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $pendaftaran->nama }}</td>
                                <td>{{ $pendaftaran->email }}</td>
                                <td>{{ $pendaftaran->nohp }}</td>
                                <td>
                                    @php
                                        $status = $pendaftaran->status_pembayaran;
                                        $badgeClass = match($status) {
                                            'menunggu_jadwal' => 'bg-secondary',
                                            'menunggu_pembayaran' => 'bg-warning text-dark',
                                            'pembayaran_berhasil' => 'bg-success',
                                            'pembayaran_ditolak' => 'bg-danger',
                                            default => 'bg-light text-dark'
                                        };
                                        $label = ucwords(str_replace('_', ' ', $status));
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">{{ $label }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.pendaftaran.show', $pendaftaran->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-calendar-check"></i> Konfirmasi
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.pendaftaran.showVerifikasiPembayaranForm', $pendaftaran->id) }}" class="btn btn-sm btn-outline-warning">
                                        <i class="bi bi-credit-card-2-front"></i> Verifikasi
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </section>
</div>
@endsection
