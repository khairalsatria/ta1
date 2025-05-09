@extends('landing.layout.main')

@section('content')
<h2 class="text-xl font-bold mb-4">Detail Pendaftaran Guide</h2>

<p><strong>Nama:</strong> {{ $pendaftaran->pendaftaran->user->name ?? '-' }}</p>
<p><strong>Paket:</strong> Paket {{ $pendaftaran->paket_guide }}</p>

@if ($pendaftaran->paket_guide == 2)
    <form action="{{ route('admin.pendaftaran.guides.konfirmasi', $pendaftaran->id) }}" method="POST">
        @csrf
        <label for="jadwal">Pilih Jadwal Konfirmasi:</label>
        <select name="jadwalguide2_konfirmasi" class="border p-1">
            @foreach ($jadwalTersedia as $jadwal)
                <option value="{{ $jadwal->id_jadwalguide2 }}">{{ $jadwal->hari }} - {{ $jadwal->jam }}</option>
            @endforeach
        </select>
        <button type="submit" class="ml-2 bg-blue-500 text-white px-3 py-1">Konfirmasi</button>
    </form>
@else
    <p><strong>File Upload:</strong> <a href="{{ asset('storage/' . $pendaftaran->file_upload) }}" target="_blank" class="text-blue-500">Lihat File</a></p>
@endif
@endsection
