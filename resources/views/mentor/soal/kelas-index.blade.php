@extends('mentor.layout.main')

@section('title', 'Daftar Kelas Anda')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-md-6">
                <h3>Daftar Kelas Anda</h3>
                <p class="text-subtitle text-muted">Pilih kelas dan pertemuan untuk mengelola soal</p>
            </div>
            <div class="col-md-6">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Kelas</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        @if($kelasList->isEmpty())
            <div class="alert alert-info">
                Belum ada kelas yang terdaftar.
            </div>
        @else
            <div class="accordion" id="accordionKelas">
                @foreach($kelasList as $kelas)
                    <div class="accordion-item mb-3  rounded border">
                        <h2 class="accordion-header " id="heading{{ $kelas->id }}">
                            <button class="accordion-button collapsed fw-bold bg-primary text-white"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{ $kelas->id }}">
                                <i class="bi bi-journal-text me-2 text-white"></i> {{ $kelas->nama_kelas }}
                            </button>
                        </h2>
                        <div id="collapse{{ $kelas->id }}"
                             class="accordion-collapse collapse"
                             data-bs-parent="#accordionKelas">
                            <div class="accordion-body">
                                <p class="mb-3 text-muted">Pilih pertemuan:</p>
                                <div class="d-flex flex-wrap gap-2">
                                    @for($i = 1; $i <= 8; $i++)
                                        <a href="{{ route('mentor.soal.index', ['kelas_id' => $kelas->id, 'pertemuan_ke' => $i]) }}"
                                           class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1 shadow-sm">
                                            Pertemuan {{ $i }}
                                        </a>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
</div>
@endsection
