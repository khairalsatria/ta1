@extends('admin.layout.main')
@section('content')

<h2 class="text-xl font-bold mb-4">Konfirmasi Jadwal GenZE Class</h2>

<p>Nama: <strong>{{ $pendaftaranClass->pendaftaran->user->name }}</strong></p>

{{-- Form Konfirmasi Jadwal --}}
<form action="{{ route('admin.pendaftaran.classes.konfirmasi', $pendaftaranClass->id) }}" method="POST">
    @csrf
    @method('PUT')
    <label class="block mt-4 mb-2">Pilih Jadwal:</label>
    <select name="jadwal_konfirmasi" class="border p-2 rounded w-full">
        @foreach($jadwalPilihan as $jadwal)
            <option value="{{ $jadwal->id_jadwalkelas }}">
                {{ $jadwal->jadwalkelas }}
            </option>
        @endforeach
    </select>
    <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">Konfirmasi</button>
</form>

{{-- Form Tetapkan Kelas --}}
@if ($pendaftaranClass->jadwalkelas_konfirmasi)
    <hr class="my-6">
    <h3 class="text-lg font-semibold mb-2">Tetapkan Kelas</h3>

    <form method="POST" action="{{ route('admin.pendaftaran.assignKelas', $pendaftaranClass->id) }}">
        @csrf
        <label for="kelas_id" class="block mb-2">Pilih Kelas:</label>
        <select name="kelas_id" class="border p-2 rounded w-full">
            @foreach($daftar_kelas as $kelas)
                <option value="{{ $kelas->id }}"
                    @selected($pendaftaranClass->kelas_id == $kelas->id)>
                    {{ $kelas->nama_kelas }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="mt-4 bg-green-500 text-white px-4 py-2 rounded">Tetapkan Kelas</button>
    </form>
@endif

@endsection
