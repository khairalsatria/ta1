@extends('admin.layout.main')
@section('content')
<h2 class="text-xl font-bold mb-4">Konfirmasi Jadwal GenZE Class</h2>
<p>Nama: <strong>{{ $pendaftaranClass->pendaftaran->user->name }}</strong></p>

<form action="{{ route('admin.pendaftaran.classes.konfirmasi', $pendaftaranClass->id) }}" method="POST">
    @csrf
    @method('PUT')
    <label class="block mt-4 mb-2">Pilih Jadwal:</label>
    <select name="jadwal_konfirmasi" class="border p-2 rounded w-full">
        @foreach($jadwalPilihan as $jadwal)
            <<option value="{{ $jadwal->id_jadwalkelas }}">
                {{ $jadwal->jadwalkelas }}
            </option>
        @endforeach
    </select>
    <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">Konfirmasi</button>
</form>
@endsection
