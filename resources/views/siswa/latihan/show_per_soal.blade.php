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

        {{-- Gambar soal --}}
        @if($currentSoal->gambar_soal)
            <div class="my-3">
                <a href="{{ asset('storage/' . $currentSoal->gambar_soal) }}" target="_blank">
                    <img src="{{ asset('storage/' . $currentSoal->gambar_soal) }}" alt="Gambar Soal"
                         class="img-fluid" style="max-height: 250px; cursor: pointer;">
                </a>
            </div>
        @endif

        <div class="mt-3">
            @foreach(['a', 'b', 'c', 'd'] as $opt)
                @php $gbrOpt = 'gambar_pilihan_' . $opt; @endphp
                <div class="form-check mb-3 ps-4">
                    <input class="form-check-input" type="radio" name="jawaban" id="opt_{{ $opt }}" value="{{ $opt }}" required>
                    <label class="form-check-label" for="opt_{{ $opt }}">
                        <strong>{{ strtoupper($opt) }}.</strong> {{ $currentSoal['pilihan_' . $opt] }}
                    </label>

                    {{-- Gambar opsi --}}
                    @if($currentSoal->$gbrOpt)
                        <div class="mt-2">
                            <a href="{{ asset('storage/' . $currentSoal->$gbrOpt) }}" target="_blank">
                                <img src="{{ asset('storage/' . $currentSoal->$gbrOpt) }}" alt="Gambar Pilihan {{ strtoupper($opt) }}"
                                     style="max-height: 150px; cursor: pointer;" class="img-fluid">
                            </a>
                        </div>
                    @endif
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
