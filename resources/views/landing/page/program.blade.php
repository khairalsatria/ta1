@extends('landing.layout.main')

@section('title', 'Program')

@section('content')
<!-- Header Start -->
<div class="jumbotron jumbotron-fluid page-header position-relative overlay-bottom mb-5">
    <div class="container text-center py-5">
        <h1 class="text-white display-4 font-weight-bold" style="text-shadow: 2px 2px 10px rgba(0,0,0,0.7);">Programs</h1>
        <div class="d-inline-flex text-white mt-3 font-weight-semibold">
            <p class="m-0 text-uppercase"><a class="text-white" href="{{ url('/') }}">Home</a></p>
            <i class="fa fa-angle-double-right pt-1 px-3"></i>
            <p class="m-0 text-uppercase text-white">Programs</p>
        </div>
    </div>
</div>
<!-- Header End -->

<!-- Courses Start -->
<div class="container py-5">
    <div class="text-center mb-5">
        <h6 class="text-success text-uppercase font-weight-bold mb-2">Our Programs</h6>
        <h1 class="display-5 font-weight-bold text-dark">Discover Programs That Empower You</h1>
        <p class="text-muted mx-auto" style="max-width: 600px;">Explore various programs taught by experienced instructors and join hundreds of successful learners today.</p>
    </div>

    <div class="row">
        @foreach ($programs as $program)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card course-card border-0 shadow-sm h-100 rounded-3 overflow-hidden">
                <a href="{{ route('landing.page.detail-program', $program->id) }}" style="text-decoration: none; color: inherit;">
                    <div class="course-img-wrapper position-relative">
                        <img class="img-fluid w-100 h-100 object-fit-cover" src="{{ asset('storage/' . $program->gambar) }}" alt="{{ $program->nama_program }}">
                        <span class="badge-type position-absolute top-0 start-0 m-3 px-3 py-2 text-white rounded-pill">{{ $program->tipe_program }}</span>
                    </div>
                    <div class="card-body p-4">
                        <h5 class="card-title font-weight-bold text-dark mb-2">{{ $program->nama_program }}</h5>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge-instruktur text-muted small d-flex align-items-center">
                                <i class="fa fa-user mr-2 text-success"></i> {{ $program->instruktur }}
                            </span>
                            <span class="badge-rating text-warning small d-flex align-items-center">
    <i class="fa fa-star mr-1"></i>
    {{ is_numeric($program->rating) ? $program->rating . ' / 5' : 'Belum ada' }}
</span>

                        </div>
                    </div>
                </a>
            </div>
        </div>
        @endforeach
    </div>

    <div class="col-12 text-center mt-4">
        {{ $programs->links('pagination::bootstrap-5') }}
    </div>
</div>
<!-- Courses End -->

<style>
    .course-card {
        transition: all 0.3s ease;
        background-color: #ffffff;
    }

    .course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1);
    }

    .course-img-wrapper {
        height: 220px;
        overflow: hidden;
        position: relative;
    }

    .course-img-wrapper img {
        transition: transform 0.4s ease;
        object-fit: cover;
    }

    .course-img-wrapper:hover img {
        transform: scale(1.07);
    }

    .badge-type {
        background: #28a745;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .badge-instruktur,
    .badge-rating {
        background-color: #f8f9fa;
        border-radius: 20px;
        padding: 6px 12px;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .badge-rating i {
        color: #ffc107;
    }

    @media (max-width: 576px) {
        .course-card .card-body {
            padding: 1rem;
        }

        .course-card h5 {
            font-size: 1.1rem;
        }

        .badge-instruktur,
        .badge-rating {
            font-size: 0.75rem;
            padding: 4px 10px;
        }
    }
</style>
@endsection
