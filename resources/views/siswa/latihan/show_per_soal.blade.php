@extends('siswa.layout.main')

@section('title', 'Latihan Soal - Pertemuan ' . $pertemuan)

@section('content')
@php
    $index = $index ?? 0;
@endphp

<div class="container py-5">
    <div class="text-center mb-4">
        <h4 class="fw-bold">✍️ Soal {{ $index + 1 }} dari {{ count($soal) }}</h4>
        <p class="text-muted">Kelas: <strong>{{ $kelas_nama }}</strong> | Pertemuan <strong>{{ $pertemuan }}</strong></p>
    </div>

    <form method="POST" action="{{ route('siswa.latihan.submit.per.soal', [$kelas_id, $pertemuan, $index]) }}">
        @csrf

        <div class="card shadow-sm border-start border-4 border-primary mb-4">
            <div class="card-body">
                <h5 class="fw-semibold">{{ $currentSoal->pertanyaan }}</h5>

@if($currentSoal->gambar_soal)
    <img src="{{ asset('storage/' . $currentSoal->gambar_soal) }}" alt="Gambar Soal" class="img-fluid my-3" style="max-height: 250px;">
@endif


                <div class="mt-3">
                    @foreach(['a', 'b', 'c', 'd'] as $opt)
                        <div class="form-check mb-2 ps-4">
                            <input class="form-check-input" type="radio" name="jawaban" id="opt_{{ $opt }}" value="{{ $opt }}" required>
                            <label class="form-check-label" for="opt_{{ $opt }}">
                                <strong>{{ strtoupper($opt) }}.</strong> {{ $currentSoal['pilihan_' . $opt] }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

       <div class="d-flex justify-content-between align-items-center mt-4">
    {{-- Tombol Sebelumnya --}}
    @if($index > 0)
        <a href="{{ route('siswa.latihan.show.per.soal', [$kelas_id, $pertemuan, $index - 1]) }}" class="btn btn-outline-secondary">
            ⬅️ Sebelumnya
        </a>
    @else
        <div></div> {{-- Spacer jika di soal pertama --}}
    @endif

    {{-- Tombol Selanjutnya / Selesai --}}
    <button type="submit" class="btn btn-primary">
        {{ ($index + 1 == count($soal)) ? '✅ Selesai' : 'Selanjutnya ➡️' }}
    </button>
</div>

    </form>
</div>
@endsection
