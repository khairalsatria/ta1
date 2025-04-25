@extends('admin.layout.main')

@section('content')
<div class="container">
    <h1>Daftar Pendaftaran</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>No HP</th>
                <th>Status</th>
                <th>Aksi Konfirmasi Jadwal</th>
                <th>Aksi Verifikasi Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pendaftaranList as $pendaftaran)
                <tr>
                    <td>{{ $pendaftaran->nama }}</td>
                    <td>{{ $pendaftaran->email }}</td>
                    <td>{{ $pendaftaran->nohp }}</td>
                    <td>{{ $pendaftaran->status_pembayaran}}</td>
                    <td>
                        <a href="{{ route('admin.pendaftaran.show', $pendaftaran->id) }}" class="btn btn-primary">Konfirmasi Jadwal</a>
                    </td>
                    <td>
                        <a href="{{ route('admin.pendaftaran.showVerifikasiPembayaranForm', $pendaftaran->id) }}" class="btn btn-warning">Verifikasi Pembayaran</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
