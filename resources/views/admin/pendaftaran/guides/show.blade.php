

@extends('admin.layout.main')

@section('title', 'Detail Pendaftaran Guide')

@section('content')
{{-- <div class="page-heading">
    <h2 class="text-xl font-bold mb-4">Detail Pendaftaran Guide</h2>

    <p>Nama: <strong>{{ $pendaftaran->pendaftaran->user->name ?? '-' }}</strong></p>
    <p>Paket: <strong>Paket {{ $pendaftaran->paket_guide }}</strong></p>

    @if ($pendaftaran->paket_guide == 2)
    <form action="{{ route('admin.pendaftaran.guides.konfirmasi', $pendaftaran->id) }}" method="POST" class="mt-4">
        @csrf
        @method('PUT')
        <label class="block mb-2 font-semibold">Pilih Jadwal Konfirmasi:</label>
        <select name="jadwalguide2_konfirmasi" class="border p-2 rounded w-full">
            @foreach ($jadwalTersedia as $jadwal)
                <option value="{{ $jadwal->id_jadwalguide2 }}">
                    {{ $jadwal->jadwalguide2 }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Konfirmasi</button>
    </form>
    @else
    <p class="mt-4">
        <strong>File Upload:</strong>
        <a href="{{ asset('storage/' . $pendaftaran->file_upload) }}" target="_blank" class="text-blue-500 underline hover:text-blue-700">
            Lihat File
        </a>
    </p>
    @endif
</div> --}}

<h2 class="text-xl font-bold mb-4">Detail Pendaftaran Guide</h2>

<p><strong>Nama:</strong> {{ $pendaftaran->pendaftaran->user->name ?? '-' }}</p>
<p><strong>Paket:</strong> Paket {{ $pendaftaran->paket_guide }}</p>

@if ($pendaftaran->paket_guide == 2)
    <form action="{{ route('admin.pendaftaran.guides.konfirmasi', $pendaftaran->id) }}" method="POST">
        @csrf
         <label for="jadwalguide2_konfirmasi" class="block font-semibold mb-2">Pilih Jadwal Konfirmasi</label>
    <select name="jadwalguide2_konfirmasi" id="jadwalguide2_konfirmasi" class="border p-2 rounded w-full" required>
        <option value="">-- Pilih Jadwal --</option>
        @foreach($jadwalTersedia as $jadwal)
            <option value="{{ $jadwal->id_jadwalguide2 }}"
                {{ $pendaftaran->jadwalguide2_konfirmasi == $jadwal->id_jadwalguide2 ? 'selected' : '' }}>
                {{ $jadwal->jadwalguide2 }}
            </option>
        @endforeach
    </select>
        <button type="submit" class="ml-2 bg-blue-500 text-white px-3 py-1">Konfirmasi</button>
    </form>
@else
    <p><strong>File Upload:</strong> <a href="{{ asset('storage/' . $pendaftaran->file_upload) }}" target="_blank" class="text-blue-500">Lihat File</a></p>
@endif
@endsection
