@extends('mentor.layout.main')

@section('content')
<div class="container">
    <h4>Edit Soal - {{ $kelas->nama_kelas }}</h4>

    <form action="{{ route('mentor.soal.update', $soal->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="pertanyaan" class="form-label">Pertanyaan</label>
            <textarea name="pertanyaan" class="form-control" required>{{ old('pertanyaan', $soal->pertanyaan) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="gambar_soal" class="form-label">Gambar Soal (Opsional)</label>
            <input type="file" name="gambar_soal" class="form-control">

            @if($soal->gambar_soal)
                <p class="mt-2">Gambar Saat Ini:</p>
                <img src="{{ asset('storage/' . $soal->gambar_soal) }}" alt="Gambar Soal" class="img-fluid" style="max-width: 300px;">
            @endif
        </div>

        @foreach(['a', 'b', 'c', 'd'] as $opt)
        <div class="mb-3">
            <label for="pilihan_{{ $opt }}" class="form-label">Pilihan {{ strtoupper($opt) }}</label>
            <input type="text" name="pilihan_{{ $opt }}" class="form-control"
                value="{{ old('pilihan_' . $opt, $soal->{'pilihan_' . $opt}) }}" required>
        </div>
        @endforeach

        <div class="mb-3">
            <label for="jawaban_benar" class="form-label">Jawaban Benar</label>
            <select name="jawaban_benar" class="form-control" required>
                @foreach(['a','b','c','d'] as $opt)
                    <option value="{{ $opt }}" {{ $soal->jawaban_benar == $opt ? 'selected' : '' }}>
                        {{ strtoupper($opt) }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Update Soal</button>
        <a href="{{ route('mentor.soal.index', ['kelas_id' => $soal->kelas_id, 'pertemuan_ke' => $soal->pertemuan_ke]) }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
