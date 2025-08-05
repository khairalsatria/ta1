@extends('mentor.layout.main')

@section('content')
<div class="container">
    <h4>Edit Soal - {{ $kelas->nama_kelas }}</h4>

    <form action="{{ route('mentor.soal.update', $soal->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="pertanyaan" class="form-label">Pertanyaan</label>
            <textarea name="pertanyaan" class="form-control" required>{{ old('pertanyaan', $soal->pertanyaan) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="pilihan_a" class="form-label">Pilihan A</label>
            <input type="text" name="pilihan_a" class="form-control" value="{{ old('pilihan_a', $soal->pilihan_a) }}" required>
        </div>

        <div class="mb-3">
            <label for="pilihan_b" class="form-label">Pilihan B</label>
            <input type="text" name="pilihan_b" class="form-control" value="{{ old('pilihan_b', $soal->pilihan_b) }}" required>
        </div>

        <div class="mb-3">
            <label for="pilihan_c" class="form-label">Pilihan C</label>
            <input type="text" name="pilihan_c" class="form-control" value="{{ old('pilihan_c', $soal->pilihan_c) }}" required>
        </div>

        <div class="mb-3">
            <label for="pilihan_d" class="form-label">Pilihan D</label>
            <input type="text" name="pilihan_d" class="form-control" value="{{ old('pilihan_d', $soal->pilihan_d) }}" required>
        </div>

        <div class="mb-3">
            <label for="jawaban_benar" class="form-label">Jawaban Benar</label>
            <select name="jawaban_benar" class="form-control" required>
                <option value="a" {{ $soal->jawaban_benar == 'a' ? 'selected' : '' }}>A</option>
                <option value="b" {{ $soal->jawaban_benar == 'b' ? 'selected' : '' }}>B</option>
                <option value="c" {{ $soal->jawaban_benar == 'c' ? 'selected' : '' }}>C</option>
                <option value="d" {{ $soal->jawaban_benar == 'd' ? 'selected' : '' }}>D</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Update Soal</button>
        <a href="{{ route('mentor.soal.index', ['kelas_id' => $soal->kelas_id, 'pertemuan_ke' => $soal->pertemuan_ke]) }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
