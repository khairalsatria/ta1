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
                    @php
    // Filter hanya kelas yang memiliki relasi kelasGenze
    $kelasValid = $kelasList->filter(fn($k) => $k->kelasGenze);
@endphp

@if($kelasValid->isEmpty())
    <li class="list-group-item text-muted">Belum terdaftar di kelas manapun.</li>
@else
    @foreach($kelasValid as $k)
        <li class="list-group-item">
            <a href="{{ route('siswa.kelas-saya', ['kelas_id' => $k->kelas_id]) }}">
                {{ $k->kelasGenze->nama_kelas }}
            </a>
        </li>
    @endforeach
@endif


                </ul>
            </div>
        </div>
        @if(isset($statusKelas) && $statusKelas === 'aktif')
    {{-- tampilkan konten kelas --}}
@elseif(isset($statusKelas) && $statusKelas === 'selesai')
    <div class="alert alert-info mt-3">
        🎉 Anda telah menyelesaikan seluruh pertemuan untuk kelas ini.
        <br>
       <a href="{{ url('/program') }}" class="btn btn-primary mt-2">🔁 Daftar Ulang Program</a>

    </div>
@endif

@if($kelasDipilihId && isset($statusKelas) && $statusKelas === 'aktif')
    <!-- Card Kelas Aktif -->
    <div class="card border-start border-4 border-primary shadow-sm mb-4">
        <div class="card-body d-flex align-items-center">
            <div class="me-3">
                <i class="bi bi-mortarboard-fill fs-3 text-primary"></i>
            </div>
            <div>
                <h5 class="mb-1 fw-bold ">Kelas Aktif :
                    <span>
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
        ->where('pertemuan_ke', $m->pertemuan_ke)
        ->count();

    $pernahJawab = \App\Models\JawabanSoalLatihan::where('user_id', Auth::id())
        ->whereHas('soal', function ($q) use ($kelasDipilihId, $m) {
            $q->where('kelas_id', $kelasDipilihId)
              ->where('pertemuan_ke', $m->pertemuan_ke);
        })
        ->exists();
@endphp

@if($jumlahSoal > 0)
    @if(!$pernahJawab)
        <a href="{{ route('siswa.latihan.show.per.soal', [$kelasDipilihId, $m->pertemuan_ke]) }}" class="btn btn-primary btn-sm mt-2">
            ✍️ Kerjakan Soal
        </a>
    @else
        <p class="text-success mt-2 mb-2">✅ Soal sudah dikerjakan.</p>
        <a href="{{ route('siswa.kelas.review', [$kelasDipilihId, $m->pertemuan_ke]) }}" class="btn btn-outline-info btn-sm mt-1">
            🔍 Review Soal
        </a>
    @endif
@endif


                            @if(isset($riwayatNilai[$m->pertemuan_ke]))
    @php
        $jawaban = $riwayatNilai[$m->pertemuan_ke];
        $total = $jawaban->count();
        $benar = $jawaban->where('benar', true)->count();
        $skor = round($benar / max($total,1) * 100);
    @endphp
    <p class="mt-1 text-muted">
        🎯 Skor: <strong>{{ $skor }}</strong> ({{ $benar }} / {{ $total }})
    </p>

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
