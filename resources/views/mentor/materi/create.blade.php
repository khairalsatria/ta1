@extends('mentor.layout.main')

@section('content')
<h2 class="text-xl font-bold mb-4">Upload Materi - {{ $kelas->nama_kelas }}</h2>

<form method="POST" action="{{ route('mentor.materi.store') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">

    <label for="tanggal_pertemuan">Tanggal Pertemuan:</label>
<input type="datetime-local" name="tanggal_pertemuan" class="form-control mb-3" required>


    <label>Pertemuan Ke:</label>
    <input type="number" name="pertemuan_ke" class="form-control mb-2" min="1" max="8" required>

    <label>Judul Materi:</label>
    <input type="text" name="judul" class="form-control mb-2" required>

    <label>Upload PDF:</label>
    <input type="file" name="file_pdf" class="form-control mb-2" accept="application/pdf">

    <label>Link Zoom (opsional):</label>
    <input type="url" name="link_zoom" class="form-control mb-2">

    <label>Link Rekaman (opsional):</label>
    <input type="url" name="link_rekaman" class="form-control mb-2">

    <button type="submit" class="btn btn-primary mt-3">Simpan Materi</button>
</form>
@endsection
