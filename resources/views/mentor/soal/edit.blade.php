@extends('mentor.layout.main')

@section('title', 'Edit Soal')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-md-6">
                <h3>Edit Soal - {{ $kelas->nama_kelas }}</h3>
            </div>
            <div class="col-md-6">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('mentor.soal.index', ['kelas_id' => $kelas->id, 'pertemuan_ke' => $soal->pertemuan_ke]) }}">Soal</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Form Edit Soal</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('mentor.soal.update', $soal->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Pertanyaan --}}
                    <div class="form-group mb-3">
                        <label for="pertanyaan">Pertanyaan</label>
                        <textarea name="pertanyaan" id="pertanyaan" rows="3"
                            class="form-control @error('pertanyaan') is-invalid @enderror" required>{{ old('pertanyaan', $soal->pertanyaan) }}</textarea>
                        @error('pertanyaan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Gambar Soal --}}
                    <div class="form-group mb-3">
                        <label>Gambar Soal Sebelumnya</label><br>
                        @if($soal->gambar_soal)
                            <img src="{{ asset('storage/' . $soal->gambar_soal) }}" alt="Gambar Soal" class="img-fluid mb-2" style="max-width: 300px;">
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="gambar_soal">Upload Gambar Soal Baru (Opsional)</label>
                        <input type="file" id="gambar_soal" name="gambar_soal" class="form-control @error('gambar_soal') is-invalid @enderror">
                        @error('gambar_soal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Pilihan Jawaban --}}
                    @foreach(['a', 'b', 'c', 'd'] as $opt)
    <div class="form-group mb-3">
        <label for="pilihan_{{ $opt }}">Pilihan {{ strtoupper($opt) }} (Teks)</label>
        <input type="text" id="pilihan_{{ $opt }}" name="pilihan_{{ $opt }}"
            class="form-control @error('pilihan_'.$opt) is-invalid @enderror"
            value="{{ old('pilihan_'.$opt, $soal->{'pilihan_'.$opt}) }}" required>
        @error('pilihan_'.$opt)<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    {{-- Gambar Lama --}}
    <div class="form-group mb-2">
        <label>Gambar Pilihan {{ strtoupper($opt) }} Sebelumnya:</label><br>
        @php $gambarOpt = 'gambar_pilihan_'.$opt; @endphp
        @if($soal->$gambarOpt)
            <img src="{{ asset('storage/' . $soal->$gambarOpt) }}" alt="Gambar Pilihan {{ strtoupper($opt) }}" style="max-width: 200px;">
        @else
            <span class="text-muted">-</span>
        @endif
    </div>

    {{-- Upload Baru --}}
    <div class="form-group mb-3">
        <label for="gambar_pilihan_{{ $opt }}">Upload Gambar Baru Pilihan {{ strtoupper($opt) }} (Opsional)</label>
        <input type="file" id="gambar_pilihan_{{ $opt }}" name="gambar_pilihan_{{ $opt }}" class="form-control @error('gambar_pilihan_'.$opt) is-invalid @enderror">
        @error('gambar_pilihan_'.$opt)<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
@endforeach


                    {{-- Jawaban Benar --}}
                    <div class="form-group mb-3">
                        <label for="jawaban_benar">Jawaban Benar</label>
                        <select name="jawaban_benar" id="jawaban_benar" class="form-control @error('jawaban_benar') is-invalid @enderror" required>
                            @foreach(['a', 'b', 'c', 'd'] as $opt)
                                <option value="{{ $opt }}" {{ old('jawaban_benar', $soal->jawaban_benar) == $opt ? 'selected' : '' }}>
                                    {{ strtoupper($opt) }}
                                </option>
                            @endforeach
                        </select>
                        @error('jawaban_benar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('mentor.soal.index', ['kelas_id' => $kelas->id, 'pertemuan_ke' => $soal->pertemuan_ke]) }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
