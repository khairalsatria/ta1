@extends('siswa.layout.main')

@section('title', 'Tambah Testimonial')

@section('content')
<div class="page-heading">
    <h3>Tambah Testimonial</h3>
</div>

<form action="{{ route('siswa.testimonial.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="program_id" class="form-label">Pilih Program</label>
        <select name="program_id" class="form-control" required>
            <option value="">-- Pilih Program --</option>
            @foreach($programs as $program)
                <option value="{{ $program->id }}">{{ $program->nama_program }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="rating" class="form-label">Rating (0–5)</label>
        <input type="number" name="rating" class="form-control" min="0" max="5" required>
    </div>

    <div class="mb-3">
        <label for="komentar" class="form-label">Komentar</label>
        <textarea name="komentar" class="form-control" rows="4" required></textarea>
    </div>

    <button type="submit" class="btn btn-success">Kirim</button>
</form>
@endsection
