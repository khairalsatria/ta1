@extends('mentor.layout.main')
@section('title', 'Edit Materi')

@section('content')
<div class="container">
    <h4 class="mb-4">Edit Materi Pertemuan</h4>

    <form action="{{ route('mentor.materi.update', $materi->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="kelas_id">Kelas</label>
            <select name="kelas_id" class="form-control" required>
                @foreach ($semua_kelas as $kelas)
                    <option value="{{ $kelas->id }}" {{ $materi->kelas_id == $kelas->id ? 'selected' : '' }}>
                        {{ $kelas->nama_kelas }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Pertemuan Ke</label>
            <input type="number" name="pertemuan_ke" class="form-control" value="{{ $materi->pertemuan_ke }}" min="1" max="8" required>
        </div>

        <div class="form-group">
            <label>Judul</label>
            <input type="text" name="judul" class="form-control" value="{{ $materi->judul }}" required>
        </div>

        <div class="form-group">
            <label>Tanggal Pertemuan</label>
            <input type="date" name="tanggal_pertemuan" class="form-control" value="{{ $materi->tanggal_pertemuan }}" required>
        </div>

        <div class="form-group">
            <label>File PDF Sebelumnya</label><br>
            @if($materi->file_pdf)
                <a href="{{ asset('storage/' . $materi->file_pdf) }}" target="_blank">Lihat File</a>
            @else
                <p>-</p>
            @endif
        </div>

        <div class="form-group">
            <label>Upload File PDF Baru (Opsional)</label>
            <input type="file" name="file_pdf" class="form-control-file">
        </div>

        <div class="form-group">
            <label>Link Zoom</label>
            <input type="url" name="link_zoom" class="form-control" value="{{ $materi->link_zoom }}">
        </div>

        <div class="form-group">
            <label>Link Rekaman</label>
            <input type="url" name="link_rekaman" class="form-control" value="{{ $materi->link_rekaman }}">
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('mentor.materi.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
