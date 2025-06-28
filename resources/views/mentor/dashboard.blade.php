@extends('mentor.layout.main')

@section('content')
<h2 class="text-xl font-bold mb-4">Dashboard Mentor</h2>

@if($kelas->isEmpty())
    <p class="text-gray-600">Anda belum memiliki kelas yang dikelola.</p>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($kelas as $k)
            <div class="border rounded p-4 shadow">
                <h3 class="text-lg font-semibold">{{ $k->nama_kelas }}</h3>
                <p>Program: {{ $k->program->nama_program ?? '-' }}</p>
                <p>Jumlah Siswa: {{ $k->siswa_count }}</p>
                <a href="{{ route('mentor.materi.create', $k->id) }}" class="inline-block mt-2 px-3 py-1 bg-blue-500 text-white rounded">Tambah Materi</a>
            </div>
        @endforeach
    </div>
@endif
@endsection
