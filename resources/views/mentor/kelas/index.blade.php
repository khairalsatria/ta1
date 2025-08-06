@extends('mentor.layout.main')

@section('title', 'List Kelas Mentor')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Daftar Kelas Anda</h3>
                <p class="text-subtitle text-muted">Kelas yang Anda ampu sebagai mentor.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('mentor.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Kelas Saya</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section id="basic-list-group">
        <div class="row match-height">
            @if($kelas->isEmpty())
                <div class="col-12">
                    <div class="alert alert-warning text-center">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        Anda belum mengajar kelas manapun saat ini.
                    </div>
                </div>
            @else
                @foreach($kelas as $k)
                    <div class="col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4 class="card-title">{{ $k->nama_kelas }}</h4>
                                <span class="badge bg-primary">
                                    Program: {{ $k->program->nama_program ?? '-' }}
                                </span>
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    <li class="list-group-item">
    📅 Jadwal: {{ $k->jadwalKelas->jadwalkelas ?? 'Belum diatur' }}
</li>

                                    <li class="list-group-item">
                                        👨‍🎓 <strong>{{ $k->siswa_count }}</strong> Siswa Terdaftar
                                    </li>
                                    <li class="list-group-item">
                                        📚 <strong>{{ $k->materi_count }}</strong> / 8 Pertemuan
                                    </li>
                                    <li class="list-group-item">
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('mentor.kelas.show', $k->id) }}" class="btn btn-primary btn-sm">
                                                <i class="bi bi-eye me-1"></i> Detail Kelas
                                            </a>
                                            <a href="{{ route('mentor.materi.create', ['kelas_id' => $k->id]) }}"
   class="btn btn-success btn-sm">
    <i class="bi bi-plus-circle"></i> Tambah Materi
</a>

                                            <a href="{{ route('mentor.soal.create', ['kelas_id' => $k->id]) }}" class="btn btn-warning btn-sm">
            <i class="bi bi-question-circle"></i> Tambah Soal
        </a>
         <a href="{{ route('mentor.kelas.siswa', $k->id) }}" class="btn btn-info btn-sm">
            <i class="bi bi-people"></i> Siswa & Progress
        </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </section>
</div>
@endsection
