@extends('admin.layout.main')

@section('content')
<div class="container">
    <h1>Verifikasi Pembayaran</h1>
    <p><strong>Nama:</strong> {{ $pendaftaran->nama }}</p>
    <p><strong>Email:</strong> {{ $pendaftaran->email }}</p>
    <p><strong>No HP:</strong> {{ $pendaftaran->nohp }}</p>

    @if($pendaftaran->bukti_pembayaran)
        <div class="form-group">
            <label>Bukti Pembayaran:</label><br>
            <a href="{{ asset('storage/' . $pendaftaran->bukti_pembayaran) }}" target="_blank" class="btn btn-info">Lihat Bukti Pembayaran</a>
        </div>
    @else
        <p>Tidak ada bukti pembayaran yang diunggah.</p>
    @endif

    <form action="{{ route('admin.pendaftaran.verifikasiPembayaran', $pendaftaran->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="status_pembayaran">Status Pembayaran:</label>
            <select name="status_pembayaran" id="status_pembayaran" class="form-control" required>
                <option value="diterima">Diterima</option>
                <option value="ditolak">Ditolak</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Verifikasi Pembayaran</button>
    </form>
</div>
@endsection
