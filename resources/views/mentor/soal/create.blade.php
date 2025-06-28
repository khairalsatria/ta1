@extends('mentor.layout.main')

@section('content')
<h2 class="text-xl font-bold mb-4">Tambah Soal Latihan untuk {{ $kelas->nama_kelas }}</h2>

<form action="{{ route('mentor.soal.store') }}" method="POST">
    @csrf
    <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">

    <label>Pertemuan Ke:</label>
    <input type="number" name="pertemuan_ke" min="1" max="8" class="form-control mb-2" required>

    <label>Pertanyaan:</label>
    <textarea name="pertanyaan" class="form-control mb-2" required></textarea>

    @foreach(['a', 'b', 'c', 'd'] as $opt)
        <label>Pilihan {{ strtoupper($opt) }}:</label>
        <input type="text" name="pilihan_{{ $opt }}" class="form-control mb-2" required>
    @endforeach

    <label>Jawaban Benar (a/b/c/d):</label>
    <input type="text" name="jawaban_benar" maxlength="1" class="form-control mb-2" required>

    <button class="btn btn-primary mt-3">Simpan Soal</button>
</form>
@endsection
