@extends('admin.layout.main')

@section('content')
    <h1>Verifikasi Pembayaran</h1>

    <form action="{{ route('admin.pendaftaran.verifikasiPembayaran', $pendaftaran->id) }}" method="POST">
        @csrf
        <div>
            <label for="status_pembayaran">Status Pembayaran:</label>
            <select name="status_pembayaran" id="status_pembayaran" required>
                <option value="diterima">Diterima</option>
                <option value="ditolak">Ditolak</option>
            </select>
        </div>
        <button type="submit">Verifikasi Pembayaran</button>
    </form>

    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif
@endsection
