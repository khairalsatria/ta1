@extends('siswa.layout.main')

@section('content')
<div class="container">
    <h1>Dashboard Siswa</h1>

    <h2>Detail Pendaftaran</h2>
    <p>Nama: {{ $pendaftaran->nama }}</p>
    <p>Email: {{ $email }}</p>
    <p>No HP: {{ $pendaftaran->nohp }}</p>
    <p>Kelas: {{ $pendaftaran->kelas }}</p>
    <p>Jenjang Pendidikan: {{ $pendaftaran->jenjangPendidikan->jenjang_pendidikan ?? '-' }}</p>
    <p>Mata Pelajaran: {{ $pendaftaran->mataPelajaran->mata_pelajaran ?? '-' }}</p>

    {{-- Tampilkan status pembayaran --}}
    <p>Status Pembayaran: <strong>{{ ucfirst(str_replace('_', ' ', $pendaftaran->status_pembayaran)) }}</strong></p>

    @if($jadwalKonfirmasi)
        <h3>Jadwal yang Dikonfirmasi</h3>
        <p>Jadwal: {{ $jadwalKonfirmasi->jadwalkelas }}</p>

        {{-- Form upload hanya jika status belum "pembayaran_berhasil" --}}
        @if($pendaftaran->status_pembayaran !== 'pembayaran_berhasil')
            <h3>Upload Bukti Pembayaran</h3>
            <form action="{{ route('siswa.pendaftaran.uploadBukti', $pendaftaran->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="bukti_pembayaran">Bukti Pembayaran (jpg, jpeg, png, pdf max 2MB)</label>
                    <input type="file" name="bukti_pembayaran" class="form-control" required>
                    @error('bukti_pembayaran')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        @else
            <p><strong>Bukti pembayaran telah diterima. Terima kasih!</strong></p>
        @endif
    @else
        <p>Jadwal belum dikonfirmasi. Silakan tunggu konfirmasi dari admin.</p>
    @endif
</div>
@endsection
