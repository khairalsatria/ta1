@extends('mentor.layout.main')

@section('title', 'Detail Soal Pertemuan ' . $pertemuanKe)

@push('styles')
<style>
    /* ===== Metric Cards ===== */
    .metric-card {
        border: none;
        border-radius: .75rem;
        box-shadow: 0 0.25rem 0.5rem rgba(0,0,0,.08);
        background: #fff;
        height: 100%;
        text-align:center;
        padding:1rem;
        position:relative;
    }
    .metric-card .metric-icon {
        width:40px;
        height:40px;
        border-radius:50%;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:1.25rem;
        color:#fff;
        margin:0 auto .5rem;
    }
    .metric-icon-total { background:#0d6efd; }
    .metric-icon-users { background:#20c997; }
    .metric-icon-done  { background:#ffc107; color:#000; }
    .metric-icon-avg   { background:#6f42c1; }

    .metric-value { font-size:1.75rem; font-weight:700; line-height:1; margin-bottom:.25rem; }
    .metric-label { font-size:.85rem; color:#6c757d; margin-bottom:.75rem; }
    .metric-card .progress { height:6px; border-radius:3px; background:rgba(0,0,0,.08); }

    /* List-group highlight for pilihan */
    .review-pilihan .is-kunci   { background-color:#d1e7dd!important; }
    .review-pilihan .is-jawaban { background-color:#cfe2ff!important; }
    .review-pilihan .is-kunci.is-jawaban { background-color:#d1e7dd!important; }

    /* Accordion tweaks */
    .soal-accordion .accordion-button:not(.collapsed) {
        background:#0d6efd;
        color:#fff;
    }
    .soal-accordion .accordion-button.collapsed {
        background:#f8f9fa;
        color:#0d6efd;
    }
    .soal-accordion .accordion-button .badge {
        margin-left:auto;
    }

    /* Table compact */
    .table-xs td, .table-xs th { padding:.4rem .5rem; }
</style>
@endpush

@section('content')
@php
    /*
    |--------------------------------------------------------------------------
    | Fallback metric calculation (jika controller belum kirim variabel)
    |--------------------------------------------------------------------------
    */
    $totalSiswaKelas = $totalSiswaKelas ?? ($kelas->siswa_count ?? $kelas->siswa()->count());
    $totalSoal       = $totalSoal       ?? $soalList->count();
    $totalSiswaMenjawab = $totalSiswaMenjawab ?? ($jawabanPerUser->count() ?? 0);

    // Avg skor per siswa yang menjawab
    $avgSkor = $avgSkor ?? 0;
    if (!isset($avgSkor) || $avgSkor === null) {
        if ($jawabanPerUser->isNotEmpty()) {
            $jumlahSkor = 0;
            $responden  = 0;
            foreach ($jawabanPerUser as $jawabanUser) {
                $total = $jawabanUser->count();
                if ($total > 0) {
                    $benar = $jawabanUser->where('benar', 1)->count();
                    $jumlahSkor += round(($benar / $total) * 100);
                    $responden++;
                }
            }
            $avgSkor = $responden ? round($jumlahSkor / $responden) : 0;
        }
    }

    $pctDone = $pctDone ?? ($totalSiswaKelas > 0 ? round(($totalSiswaMenjawab / $totalSiswaKelas) * 100) : 0);
@endphp

<div class="page-heading mb-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h3 class="mb-1 text-primary fw-bold">
                📝 Detail Soal - Pertemuan {{ $pertemuanKe }}
            </h3>
            <p class="text-muted mb-0">
                Kelas: <strong>{{ $kelas->nama_kelas }}</strong>
            </p>
            @if($materi)
                <small class="text-muted d-block">
                    Judul: <strong>{{ $materi->judul }}</strong>
                </small>
            @endif
        </div>
        <a href="{{ route('mentor.kelas.siswa', $kelas->id) }}" class="btn btn-outline-secondary btn-sm shadow-sm">
            <i class="bi bi-arrow-left-circle"></i> Kembali
        </a>
    </div>
</div>

{{-- ===== Summary Metrics ===== --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="metric-card">
            <div class="metric-icon metric-icon-total"><i class="bi bi-list-check"></i></div>
            <div class="metric-value">{{ $totalSoal }}</div>
            <div class="metric-label">Total Soal</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="metric-card">
            <div class="metric-icon metric-icon-users"><i class="bi bi-people-fill"></i></div>
            <div class="metric-value">{{ $totalSiswaKelas }}</div>
            <div class="metric-label">Total Siswa Kelas</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="metric-card">
            <div class="metric-icon metric-icon-done"><i class="bi bi-check2-circle"></i></div>
            <div class="metric-value">{{ $totalSiswaMenjawab }}</div>
            <div class="metric-label">Siswa Menjawab</div>
            <div class="progress mt-auto">
                <div class="progress-bar bg-warning"
                     style="width:{{ $pctDone }}%"
                     role="progressbar"
                     aria-valuenow="{{ $pctDone }}" aria-valuemin="0" aria-valuemax="100">
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="metric-card">
            <div class="metric-icon metric-icon-avg"><i class="bi bi-graph-up"></i></div>
            <div class="metric-value">{{ $avgSkor }}%</div>
            <div class="metric-label">Rata-rata Skor</div>
            <div class="progress mt-auto">
                <div class="progress-bar bg-success"
                     style="width:{{ $avgSkor }}%"
                     role="progressbar"
                     aria-valuenow="{{ $avgSkor }}" aria-valuemin="0" aria-valuemax="100">
                </div>
            </div>
        </div>
    </div>
</div>
{{-- ===== /Summary Metrics ===== --}}

{{-- Rekap Per Siswa (yang sudah menjawab) --}}
@if($jawabanPerUser->isNotEmpty())
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold">
                <i class="bi bi-people"></i> Rekap Jawaban Siswa
            </h5>
            <small class="text-muted">Hanya siswa yang sudah menjawab.</small>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 table-xs">
                    <thead class="table text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Email</th>
                            <th>Benar</th>
                            <th>Total</th>
                            <th>Skor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jawabanPerUser as $userId => $jawabanUser)
                            @php
                                $user  = $jawabanUser->first()->user ?? null;
                                $total = $jawabanUser->count();
                                $benar = $jawabanUser->where('benar', 1)->count();
                                $skor  = $total ? round(($benar / $total) * 100) : 0;
                            @endphp
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-start">{{ $user->name ?? 'Tidak Diketahui' }}</td>
                                <td>{{ $user->email ?? '-' }}</td>
                                <td>{{ $benar }}</td>
                                <td>{{ $total }}</td>
                                <td>
                                    <span class="badge {{ $skor >= 75 ? 'bg-success' : 'bg-warning' }}">
                                        {{ $skor }}%
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                        @if($jawabanPerUser->isEmpty())
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada jawaban.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif

{{-- Daftar Soal & Jawaban Detail --}}
@if($soalList->isEmpty())
    <div class="alert alert-warning">Belum ada soal untuk pertemuan ini.</div>
@else
    <div class="accordion soal-accordion mb-4" id="soalAccordion">
        @foreach($soalList as $i => $soal)
            @php
                // Urutkan jawaban per soal berdasarkan nama siswa
                $jawabanSorted = $soal->jawaban->sortBy(fn($j) => strtolower($j->user->name ?? ''));

                // Map pilihan
                $pilihanList = [
                    'A' => $soal->pilihan_a ?? '',
                    'B' => $soal->pilihan_b ?? '',
                    'C' => $soal->pilihan_c ?? '',
                    'D' => $soal->pilihan_d ?? '',
                ];

                // Hitung distribusi benar/salah
                $totalJawabSoal = $jawabanSorted->count();
                $totalBenarSoal = $jawabanSorted->where('benar', 1)->count();
                $pctBenarSoal   = $totalJawabSoal ? round(($totalBenarSoal / $totalJawabSoal) * 100) : 0;
            @endphp

            <div class="accordion-item mb-2 border-0 shadow-sm">
                <h2 class="accordion-header" id="heading-{{ $soal->id }}">
                    <button class="accordion-button collapsed bg-primary text-white"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#collapse-{{ $soal->id }}"
                            aria-expanded="false"
                            aria-controls="collapse-{{ $soal->id }}">
                        <span class="me-2">Soal {{ $i + 1 }}</span>
                        <span class="badge bg-light text-dark border ms-auto">
                            Benar: {{ $totalBenarSoal }}/{{ $totalJawabSoal }} ({{ $pctBenarSoal }}%)
                        </span>
                    </button>
                </h2>
                <div id="collapse-{{ $soal->id }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $soal->id }}" data-bs-parent="#soalAccordion">
                    <div class="accordion-body">
                        <p class="fw-bold fs-5 mb-3">
    {{ $soal->pertanyaan }}
</p>

{{-- Gambar soal --}}
@if($soal->gambar_soal)
    <div class="mb-3">
        <a href="{{ asset('storage/' . $soal->gambar_soal) }}" target="_blank">
            <img src="{{ asset('storage/' . $soal->gambar_soal) }}" alt="Gambar Soal" style="max-width: 200px; height: auto; cursor: pointer;">
        </a>
    </div>
@endif

{{-- Pilihan A-D dengan highlight kunci --}}
<div class="list-group mb-4 review-pilihan">
    @foreach($pilihanList as $huruf => $teksPilihan)
        @php
            $isKunci = (strtoupper($huruf) === strtoupper($soal->jawaban_benar ?? ''));
            $gbrOpt  = 'gambar_pilihan_' . strtolower($huruf);
        @endphp
        <div class="list-group-item d-flex flex-column {{ $isKunci ? 'is-kunci' : '' }}">
            <div class="d-flex justify-content-between align-items-center w-100">
                <span>
                    <strong>{{ $huruf }}.</strong> {{ $teksPilihan === '' ? '-' : $teksPilihan }}
                </span>
                @if($isKunci)
                    <span class="badge bg-success">Kunci</span>
                @endif
            </div>

            {{-- Gambar opsi --}}
            @if($soal->$gbrOpt)
                <div class="mt-2">
                    <a href="{{ asset('storage/' . $soal->$gbrOpt) }}" target="_blank">
                        <img src="{{ asset('storage/' . $soal->$gbrOpt) }}" alt="Gambar Pilihan {{ $huruf }}" style="max-width: 120px; height: auto; cursor: pointer;">
                    </a>
                </div>
            @endif
        </div>
    @endforeach
</div>

                        {{-- Jawaban siswa untuk soal ini --}}
                        <h6 class="text-secondary mb-2">Jawaban Siswa:</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped align-middle table-xs mb-0">
                                <thead class="table text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Siswa</th>
                                        <th>Jawaban</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($jawabanSorted as $j => $jawaban)
                                        @php
                                            $huruf = strtoupper($jawaban->jawaban_dipilih ?? '');
                                            $teks  = $pilihanList[$huruf] ?? '';
                                        @endphp
                                        <tr class="text-center">
                                            <td>{{ $j + 1 }}</td>
                                            <td class="text-start">{{ $jawaban->user->name ?? 'Tidak Diketahui' }}</td>
                                            <td>{{ $huruf }}{{ $teks ? '. '.$teks : '' }}</td>
                                            <td>
                                                @if($jawaban->benar)
                                                    <span class="badge bg-success">Benar</span>
                                                @else
                                                    <span class="badge bg-danger">Salah</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">Belum ada jawaban siswa.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
