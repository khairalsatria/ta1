@extends('mentor.layout.main')

@section('title', 'Tambah Soal')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Tambah Soal Latihan</h3>
                <p class="text-subtitle text-muted">Buat soal latihan untuk {{ $kelas->nama_kelas }}</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('mentor.kelas.index') }}">Kelas</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('mentor.soal.index', ['kelas_id' => $kelas->id, 'pertemuan_ke' => 1]) }}">Soal</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah Soal</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Form Tambah Soal</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('mentor.soal.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">

                    <div class="mb-3">
                        <label class="form-label">Pertemuan Ke:</label>
                        <input type="number" name="pertemuan_ke" min="1" max="8" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pertanyaan:</label>
                        <textarea name="pertanyaan" rows="4" class="form-control" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Upload Gambar Soal (Opsional):</label>
                        <input type="file" name="gambar_soal" class="form-control">
                    </div>

                    <hr>
                    <h6>Pilihan Jawaban</h6>
                    @foreach(['a', 'b', 'c', 'd'] as $opt)
    <div class="mb-3">
        <label class="form-label">Pilihan {{ strtoupper($opt) }} (Teks):</label>
        <input type="text" name="pilihan_{{ $opt }}" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Gambar Pilihan {{ strtoupper($opt) }} (Opsional):</label>
        <input type="file" name="gambar_pilihan_{{ $opt }}" class="form-control">
    </div>
@endforeach


                    <div class="mb-3">
                        <label class="form-label">Jawaban Benar (a/b/c/d):</label>
                        <select name="jawaban_benar" class="form-control" required>
                            <option value="">-- Pilih Jawaban Benar --</option>
                            <option value="a">A</option>
                            <option value="b">B</option>
                            <option value="c">C</option>
                            <option value="d">D</option>
                        </select>
                    </div>

                    <button class="btn btn-primary">Simpan Soal</button>
                    <a href="{{ route('mentor.soal.index', ['kelas_id' => $kelas->id, 'pertemuan_ke' => 1]) }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
