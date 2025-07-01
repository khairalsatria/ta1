@extends('siswa.layout.main')

@section('title', 'Latihan Soal - Pertemuan ' . $pertemuan)

@section('content')
<div class="container py-4">
    <!-- Heading Section -->
    <div class="text-center mb-5">
        <h2 class="fw-bold text-white">✍️ Latihan Soal</h2>
        <p class="text-muted">Pertemuan <strong>{{ $pertemuan }}</strong> | Kelas: <span class="text-primary fw-semibold">{{ $kelas_nama ?? 'Tidak Diketahui' }}</span></p>
    </div>

    <form method="POST" action="{{ route('siswa.latihan.submit', [$kelas_id, $pertemuan]) }}">
        @csrf

        @foreach($soal as $index => $s)
            <div class="card mb-4 shadow-sm border-start border-3 border-primary">
                <div class="card-body">
                    <div class="mb-3">
                        <span class="badge bg-primary mb-2">Soal {{ $index + 1 }}</span>
                        <h5 class="fw-semibold">{{ $s->pertanyaan }}</h5>
                    </div>

                    <div class="row gy-2">
                        @foreach(['a', 'b', 'c', 'd'] as $opt)
                            <div class="col-12">
                                <div class="form-check ps-4">
                                    <input class="form-check-input me-2" type="radio" name="soal_{{ $s->id }}" id="soal_{{ $s->id }}_{{ $opt }}" value="{{ $opt }}" required>
                                    <label class="form-check-label w-100" for="soal_{{ $s->id }}_{{ $opt }}">
                                        <strong>{{ strtoupper($opt) }}.</strong> {{ $s['pilihan_' . $opt] }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach

        <div class="d-flex justify-content-end mt-4">
            <button type="submit" class="btn btn-success btn-lg shadow-sm">
                <i class="bi bi-clipboard-check me-2"></i> Submit & Lihat Skor
            </button>
        </div>
    </form>
</div>
@endsection
