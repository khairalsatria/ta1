@extends('mentor.layout.main')

@section('title', 'Siswa & Progress Kelas')

@section('content')
<div class="page-heading mb-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h3 class="mb-1 text-primary fw-bold">
                👩‍🎓 Siswa Kelas : <span class="">{{ $kelas->nama_kelas }}</span>
            </h3>
            <p class="text-muted mb-0">
                Program: <span class="badge bg-primary">{{ $kelas->program->nama_program ?? '-' }}</span>
            </p>
        </div>
        <a href="{{ route('mentor.kelas.index') }}" class="btn btn-outline-secondary btn-sm shadow-sm">
            <i class="bi bi-arrow-left-circle"></i> Kembali
        </a>
    </div>
</div>

{{-- Ringkasan Kelas --}}
<div class="page-content">
    <section class="row">
        <div class="col-12 mb-4">
            <div class="row g-3">

                {{-- Total Pertemuan --}}
                <div class="col-12 col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="stats-icon blue mb-3">
                                <i class="iconly-boldCalendar"></i>
                            </div>
                            <h6 class="text-muted mb-1">Total Pertemuan</h6>
                            <h3 class="font-extrabold mb-3">{{ $totalPertemuan }}</h3>
                        </div>
                    </div>
                </div>

                {{-- Siswa Terdaftar --}}
                <div class="col-12 col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="stats-icon blue mb-3">
                                <i class="iconly-boldUser"></i>
                            </div>
                            <h6 class="text-muted mb-1">Siswa Terdaftar</h6>
                            <h3 class="font-extrabold mb-3">{{ $kelas->siswa_count ?? $kelas->siswa->count() }}</h3>
                        </div>
                    </div>
                </div>

                {{-- Pertemuan Selesai --}}
                <div class="col-12 col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="stats-icon blue mb-3">
                                <i class="iconly-boldTick-Square"></i>
                            </div>
                            <h6 class="text-muted mb-1">Pertemuan Selesai</h6>
                            <h3 class="font-extrabold mb-3">{{ $pertemuanSudahDilakukan }}</h3>
                        </div>
                    </div>
                </div>

            </div> {{-- /row g-3 --}}
        </div>
    </section>
</div>



{{-- Filter & Search --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-center">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control"
                       placeholder="Cari nama siswa..."
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100">
                    <i class="bi bi-search"></i> Cari
                </button>
            </div>
            @if(request('search'))
                <div class="col-md-2">
                    <a href="{{ route('mentor.kelas.siswa', $kelas->id) }}"
                       class="btn btn-outline-secondary w-100">
                        <i class="bi bi-x-circle"></i> Reset
                    </a>
                </div>
            @endif
        </form>
    </div>
</div>

{{-- Daftar Siswa --}}
<div class="card border-0 shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-semibold">
            <i class="bi bi-people"></i> Daftar Siswa & Skor
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle mb-0">
                <thead class="table text-center">
                    <tr>
                        <th style="width:40px;">No</th></th>
                        <th>Nama Siswa</th>
                        {{-- <th>Email</th> --}}
                        <th style="width:180px;">Progress</th>
                        <th style="width:120px;">Pertemuan</th>
                        @foreach($pertemuanRange as $pKe)
                            <th style="min-width:80px;">
                                <div class="d-flex flex-column align-items-center">
                                    <span class="fw-semibold">P{{ $pKe }}</span>
                                    <a href="{{ route('mentor.kelas.soal.detail', [$kelas->id, $pKe]) }}"
                                       class="btn btn-xs btn-outline-primary btn-sm mt-1 px-2 py-1">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </div>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                @forelse($siswaData as $i => $row)
                    <tr>
                        <td class="fw-bold text-center">{{ $siswaData->firstItem() + $i }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar bg-primary text-white rounded-circle me-2 d-flex justify-content-center align-items-center"
                                     style="width:32px; height:32px;">
                                    {{ strtoupper(substr(optional($row->user)->name, 0, 1)) }}
                                </div>
                                <span class="fw-medium">{{ optional($row->user)->name ?? '-' }}</span>
                            </div>
                        </td>
                        {{-- <td>{{ optional($row->user)->email ?? '-' }}</td> --}}
                        <td>
                            <div class="progress" style="height:16px;">
                                <div class="progress-bar
                                    {{ $row->progress >= 75 ? 'bg-success' : ($row->progress >= 50 ? 'bg-warning' : 'bg-danger') }}"
                                    style="width: {{ $row->progress }}%;">
                                    @if($row->progress > 0)
                                        {{ $row->progress }}%
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="text-center fw-medium">
                            {{ $row->pertemuan_selesai }} / {{ $row->total_pertemuan }}
                        </td>

                        {{-- Skor per pertemuan --}}
                        @foreach($row->pertemuan_scores as $ps)
                            <td class="text-center">
                                @if(!is_null($ps['skor']))
                                    <span class="badge {{ $ps['skor'] >= 75 ? 'bg-success' : 'bg-warning' }}">
                                        {{ $ps['skor'] }}%
                                    </span>
                                    <small class="d-block text-muted">{{ $ps['benar'] }}/{{ $ps['total'] }}</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ 5 + count($pertemuanRange) }}"
                            class="text-center text-muted py-4">
                            <i class="bi bi-exclamation-circle"></i> Belum ada siswa terdaftar.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Pagination --}}
@if($siswaData instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div class="mt-3 d-flex justify-content-center">
        {{ $siswaData->appends(request()->query())->links() }}
    </div>
@endif

@endsection

