@extends('admin.layout.main')

@section('content')
<div class="container">
    <h1>Detail Pendaftaran</h1>
    <p><strong>Nama:</strong> {{ $pendaftaran->nama }}</p>
    <p><strong>Email:</strong> {{ $pendaftaran->email }}</p>
    <p><strong>No HP:</strong> {{ $pendaftaran->nohp }}</p>
    <p><strong>Status:</strong> {{ $pendaftaran->status }}</p>
    <p><strong>Jadwal Pilihan:</strong> {{ implode(', ', (array) $pendaftaran->jadwal_pilihan) }}</p>

    <form action="{{ route('admin.pendaftaran.konfirmasiJadwal', $pendaftaran->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="jadwal_konfirmasi">Pilih Jadwal Konfirmasi:</label>
            <select name="jadwal_konfirmasi" id="jadwal_konfirmasi" class="form-control" required>
                @foreach($jadwalKelas as $jadwal)
                    <option value="{{ $jadwal->id_jadwalkelas }}">{{ $jadwal->jadwalkelas }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Konfirmasi Jadwal</button>
    </form>
</div>
@endsection
