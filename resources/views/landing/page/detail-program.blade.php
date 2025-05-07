@extends('landing.layout.main')

@section('title', 'Detail Program')

@section('content')

<!-- Header Start -->
<div class="jumbotron jumbotron-fluid page-header position-relative overlay-bottom" style="margin-bottom: 90px;">
    <div class="container text-center py-5">
        <h1 class="text-white display-1">{{ $program->tipe_program }}</h1> <!-- Menampilkan nama program -->
        <div class="d-inline-flex text-white mb-5">
            {{-- <p class="m-0 text-uppercase"><a class="text-white" href="{{ route('beranda') }}">Beranda</a></p> --}}
            <i class="fa fa-angle-double-right pt-1 px-3"></i>
            <p class="m-0 text-uppercase">Detail Program</p>
        </div>
    </div>
</div>
<!-- Header End -->

<!-- Detail Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="row">
            <!-- Konten Kiri -->
            <div class="col-lg-8">
                <div class="mb-5">
                    <div class="section-title position-relative mb-5">
                        <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">Deskripsi Program</h6>
                        <h1 class="display-4">{{ $program->nama_program }}</h1>
                    </div>
                    <img class="img-fluid rounded w-100 mb-4" src="{{ asset('storage/' . $program->gambar) }}" alt="{{ $program->nama_program }}">
                    <p>{!! nl2br(e($program->deskripsi)) !!}</p>
                </div>
            </div>

            <!-- Sidebar Kanan -->
<div class="col-lg-4 mt-5 mt-lg-0">
    <div class="bg-primary mb-5 py-3">
        <h3 class="text-white py-3 px-4 m-0">Fitur Program</h3>
        <div class="d-flex justify-content-between border-bottom px-4">
            <h6 class="text-white my-3">Instruktur</h6>
            <h6 class="text-white my-3">{{ $program->instruktur }}</h6>
        </div>
        <div class="d-flex justify-content-between border-bottom px-4">
            <h6 class="text-white my-3">Tipe Kelas</h6>
            <h6 class="text-white my-3">{{ ucfirst($program->tipe_kelas) }}</h6>
        </div>
        <div class="d-flex justify-content-between border-bottom px-4">
            <h6 class="text-white my-3">Durasi</h6>
            <h6 class="text-white my-3">{{ $program->durasi }} Jam</h6>
        </div>
        <div class="d-flex justify-content-between border-bottom px-4">
            <h6 class="text-white my-3">Pendidikan</h6>
            <h6 class="text-white my-3">{{ $program->level }}</h6>
        </div>
        <div class="d-flex justify-content-between border-bottom px-4">
            <h6 class="text-white my-3">Rating</h6>
            <h6 class="text-white my-3">{{ $program->rating ?? '4.5' }}</h6>
        </div>
        <div class="py-3 px-4">
            <a href="{{ route('siswa.pendaftaran.genze-class.form', ['program_id' => $program->id]) }}" class="btn btn-block btn-secondary py-3 px-5">
                Enroll Now {{ $program->nama }}
            </a>
        </div>

    </div>

    <!-- Program Terkait Dipindahkan ke Sini -->
    <div class="mb-5">
        <h4 class="mb-4">Program Lainnya</h4>
        @foreach ($relatedPrograms as $related)
        <a class="d-flex align-items-center text-decoration-none mb-4" href="{{ route('landing.page.detail-program', $related->id) }}">
            <img class="img-fluid rounded" src="{{ asset('storage/' . $related->gambar) }}" alt="{{ $related->nama_program }}" style="width: 80px; height: 80px; object-fit: cover;">
            <div class="pl-3">
                <h6 class="text-dark mb-1">{{ $related->nama_program }}</h6>
                <div class="d-flex">
                    <small class="text-body mr-3"><i class="fa fa-user text-primary mr-2"></i>{{ $related->instruktur ?? 'Mentor' }}</small>
                    <small class="text-body"><i class="fa fa-star text-primary mr-2"></i>{{ $related->rating ?? '4.5' }}</small>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
</div>
    </div>
</div>

<!-- Detail End -->

@endsection
