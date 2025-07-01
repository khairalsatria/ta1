@php use Illuminate\Support\Facades\Auth; @endphp

@extends('siswa.layout.main')

@section('title', 'My Class Siswa')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Kelas Saya</h3>
                <p class="text-subtitle text-muted">Lihat daftar kelas yang sedang kamu ikuti dan akses materi pembelajarannya.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('siswa.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Kelas Saya</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Card Daftar Kelas -->
        <div class="card">
            <div class="card-header">
                <h4>📚 Daftar Kelas</h4>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @forelse($kelasList as $k)
                        <li class="list-group-item">
                            <a href="{{ route('siswa.kelas-saya', ['kelas_id' => $k->kelas_id]) }}">
                                {{ $k->kelasGenze->nama_kelas ?? 'Nama Kelas Tidak Ditemukan' }}
                            </a>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">Belum terdaftar di kelas manapun.</li>
                    @endforelse
                </ul>
            </div>
        </div>

@if($kelasDipilihId)
    <div class="card border-start border-4 border-primary shadow-sm mb-4">
        <div class="card-body d-flex align-items-center">
            <div class="me-3">
                <i class="bi bi-mortarboard-fill fs-3 text-primary"></i>
            </div>
            <div>
                <h5 class="mb-1 fw-bold text-white">Kelas Aktif :
                    <span class="text-white">
                        {{ $kelasList->firstWhere('kelas_id', $kelasDipilihId)->kelasGenze->nama_kelas ?? '-' }}
                    </span>
                </h5>
                <p class="mb-0 text-muted small">Berikut adalah materi, progress, dan pertemuan dari kelas ini.</p>
            </div>
        </div>
    </div>

    <!-- Card Progress -->
            <div class="card mt-4">
                <div class="card-header">
                    <h4>📈 Progress Kelas</h4>
                </div>
                <div class="card-body">
                    <p class="mb-2">Pertemuan: {{ $pertemuanSudahDilakukan }} dari {{ $totalPertemuan }}</p>
                    <div class="progress">
                        <div class="progress-bar bg-success" style="width: {{ $progress }}%" role="progressbar">
                            {{ $progress }}%
                        </div>
                    </div>
                </div>
            </div>
@endif




            <!-- Card Jadwal Berikutnya -->
            @if(isset($materiBerikutnya))
                <div class="card mt-4 border-warning">
                    <div class="card-header  text-white">
                        📅 Pertemuan Berikutnya
                    </div>
                    <div class="card-body">
                        <p class="mb-1"><strong>Pertemuan {{ $materiBerikutnya->pertemuan_ke }}:</strong> {{ $materiBerikutnya->judul ?? '-' }}</p>
                        @if($materiBerikutnya->link_zoom)
                            <p>🔗 Zoom: <a href="{{ $materiBerikutnya->link_zoom }}" class="text-primary" target="_blank">Gabung Zoom</a></p>
                        @endif
                        <p class="text-muted">
                            📅 Tanggal: {{ \Carbon\Carbon::parse($materiBerikutnya->tanggal_pertemuan)->translatedFormat('l, d M Y H:i') }}
                        </p>
                    </div>

                </div>
            @endif
        <!-- Card Materi -->
        @if($kelasDipilihId && $materi->isNotEmpty())
            <div class="card mt-4">
                <div class="card-header">
                    <h4>📖 Materi Kelas: {{ $kelasList->firstWhere('kelas_id', $kelasDipilihId)->kelasGenze->nama_kelas ?? '' }}</h4>
                </div>
                <div class="card-body">
                    @foreach($materi->sortBy('pertemuan_ke') as $m)
                        <div class="mb-4 border-bottom pb-3">
                            <h5 class="text-primary">Pertemuan {{ $m->pertemuan_ke }}: {{ $m->judul }}</h5>
                            <ul class="list-unstyled ms-3">
                                @if($m->file_pdf)
                                    <li>📄 <a href="{{ asset('storage/' . $m->file_pdf) }}" target="_blank">Download Materi (PDF)</a></li>
                                @endif
                                @if($m->link_zoom)
                                    <li>🔗 <a href="{{ $m->link_zoom }}" target="_blank" class="text-success">Gabung Zoom</a></li>
                                @endif
                                @if($m->link_rekaman)
                                    <li>▶️ <a href="{{ $m->link_rekaman }}" target="_blank" class="text-purple">Lihat Rekaman</a></li>
                                @endif
                            </ul>

                            @php
                                $jumlahSoal = \App\Models\SoalLatihan::where('kelas_id', $kelasDipilihId)
                                    ->where('pertemuan_ke', $m->pertemuan_ke)->count();
                                $pernahJawab = \App\Models\JawabanSoalLatihan::where('user_id', Auth::id())
                                    ->whereHas('soal', fn($q) => $q->where('kelas_id', $kelasDipilihId)
                                                                 ->where('pertemuan_ke', $m->pertemuan_ke))
                                    ->exists();
                            @endphp

                            @if($jumlahSoal > 0)
                                @if(!$pernahJawab)
                                    <a href="{{ route('siswa.latihan.show', [$kelasDipilihId, $m->pertemuan_ke]) }}" class="btn btn-primary btn-sm mt-2">
                                        ✍️ Kerjakan Soal
                                    </a>
                                @else
                                    <p class="text-success mt-2">✅ Soal sudah dikerjakan.</p>
                                @endif
                            @endif

                            @if(isset($riwayatNilai[$m->pertemuan_ke]))
                                @php
                                    $jawaban = $riwayatNilai[$m->pertemuan_ke];
                                    $total = $jawaban->count();
                                    $benar = $jawaban->where('benar', true)->count();
                                    $skor = round($benar / max($total, 1) * 100);
                                @endphp
                                <p class="mt-1 text-muted">🎯 Skor: <strong>{{ $skor }}</strong> ({{ $benar }} dari {{ $total }} benar)</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>


        @else
            {{--  --}}
        @endif
    </section>
</div>
@endsection
