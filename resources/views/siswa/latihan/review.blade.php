@php use Illuminate\Support\Facades\Auth; @endphp
@extends('siswa.layout.main')

@section('title', 'Review Soal Pertemuan ' . $pertemuanKe)

@push('styles')
<style>
    /* Metric Cards */
    .metric-card {
        border-radius: .75rem;
        background: #fff;
        box-shadow: 0 0.25rem 0.5rem rgba(0,0,0,.08);
        padding: 1rem;
        text-align: center;
        height: 100%;
    }
    .metric-card .icon {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:1.25rem;
        color:#fff;
        margin-bottom:.5rem;
    }
    .metric-value { font-size: 1.75rem; font-weight: bold; }
    .metric-label { color: #6c757d; font-size: .9rem; }

    .icon-total { background:#0d6efd; }
    .icon-correct { background:#20c997; }
    .icon-score { background:#ffc107; color: #000; }

    /* List group highlight */
    .list-group-item {
        transition: all .2s ease-in-out;
    }
    .list-group-item:hover {
        background-color: #f8f9fa;
    }
</style>
@endpush

@section('content')
@php
    // Hitung total dan skor siswa
    $totalSoal   = $soalList->count();
    $jumlahBenar = 0;
    foreach ($soalList as $soal) {
        $jawab = $soal->jawaban->first();
        if ($jawab && $jawab->benar) $jumlahBenar++;
    }
    $skor = $totalSoal > 0 ? round(($jumlahBenar / $totalSoal) * 100) : 0;
@endphp

<div class="page-heading mb-4 d-flex justify-content-between align-items-center flex-wrap">
    <div>
        <h3 class="mb-1 text-primary">🔍 Review Soal - Pertemuan {{ $pertemuanKe }}</h3>
        <p class="text-muted mb-0">Kelas: <strong>{{ $kelas->nama_kelas }}</strong></p>
        @if($materi)
            <small class="text-muted d-block">Materi: <strong>{{ $materi->judul }}</strong></small>
        @endif
    </div>
    <a href="{{ route('siswa.kelas-saya', ['kelas_id' => $kelas->id]) }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left-circle"></i> Kembali
    </a>
</div>

{{-- Rekap Jawaban --}}
<div class="row g-3 mb-4">
    <div class="col-4 col-md-4">
        <div class="metric-card">
            <div class="icon icon-total"><i class="bi bi-list-task"></i></div>
            <div class="metric-value">{{ $totalSoal }}</div>
            <div class="metric-label">Total Soal</div>
        </div>
    </div>
    <div class="col-4 col-md-4">
        <div class="metric-card">
            <div class="icon icon-correct"><i class="bi bi-check-circle"></i></div>
            <div class="metric-value">{{ $jumlahBenar }}</div>
            <div class="metric-label">Jawaban Benar</div>
        </div>
    </div>
    <div class="col-4 col-md-4">
        <div class="metric-card">
            <div class="icon icon-score"><i class="bi bi-bar-chart-fill"></i></div>
            <div class="metric-value">{{ $skor }}%</div>
            <div class="metric-label">Skor</div>
        </div>
    </div>
</div>

@if($soalList->isEmpty())
    <div class="alert alert-warning">Belum ada soal untuk pertemuan ini.</div>
@else
    @foreach($soalList as $i => $soal)
        @php
            $jawabanSiswa   = $soal->jawaban->first();
            $jawabanDipilih = strtoupper($jawabanSiswa->jawaban_dipilih ?? '');
            $kunci          = strtoupper($soal->jawaban_benar ?? '');
            $pilihanList = [
                'A' => $soal->pilihan_a ?? '',
                'B' => $soal->pilihan_b ?? '',
                'C' => $soal->pilihan_c ?? '',
                'D' => $soal->pilihan_d ?? '',
            ];
        @endphp
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Soal {{ $i + 1 }}</h5>
            </div>
            <div class="card-body">
                <p class="fw-bold fs-5">{{ $soal->pertanyaan }}</p>

                <div class="list-group mb-3">
                    @foreach($pilihanList as $huruf => $teksPilihan)
                        @php
                            $isKunci  = ($huruf === $kunci);
                            $isJawab  = ($huruf === $jawabanDipilih);
                            $bg = '';
                            if ($isKunci && $isJawab) $bg = 'background-color:#d1e7dd;';
                            elseif ($isKunci) $bg = 'background-color:#d1e7dd;';
                            elseif ($isJawab) $bg = 'background-color:#cfe2ff;';
                        @endphp
                        <div class="list-group-item d-flex justify-content-between align-items-center" style="{{ $bg }}">
                            <span><strong>{{ $huruf }}.</strong> {{ $teksPilihan === '' ? '-' : $teksPilihan }}</span>
                            <span>
                                @if($isJawab)
                                    <span class="badge bg-primary me-1">Jawaban Kamu</span>
                                @endif
                                @if($isKunci)
                                    <span class="badge bg-success">Kunci</span>
                                @endif
                            </span>
                        </div>
                    @endforeach
                </div>

                @if($jawabanSiswa)
                    <p class="mt-2">
                        Jawaban Kamu: <strong>{{ $jawabanDipilih ?: '-' }}</strong>
                        @if($jawabanSiswa->benar)
                            <span class="badge bg-success">Benar</span>
                        @else
                            <span class="badge bg-danger">Salah</span>
                        @endif
                    </p>
                @endif
            </div>
        </div>
    @endforeach
@endif
@endsection
        