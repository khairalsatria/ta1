@extends('landing.layout.main')

@section('title', 'Program')

@section('content')
<!-- Header Start -->
<div class="jumbotron jumbotron-fluid page-header position-relative overlay-bottom" style="margin-bottom: 90px;">
    <div class="container text-center py-5">
        <h1 class="text-white display-1 font-weight-bold" style="text-shadow: 2px 2px 10px rgba(0,0,0,0.7);">Courses</h1>
        <div class="d-inline-flex text-white mb-5" style="font-weight: 600;">
            <p class="m-0 text-uppercase"><a class="text-white" href="{{ url('/') }}">Home</a></p>
            <i class="fa fa-angle-double-right pt-1 px-3"></i>
            <p class="m-0 text-uppercase text-white">Courses</p>
        </div>
    </div>
</div>
<!-- Header End -->

<!-- Courses Start -->
<div class="container-fluid py-5" style="background: #f8f9fa;">
    <div class="container py-5">
        <div class="row mx-0 justify-content-center">
            <div class="col-lg-8">
                <div class="section-title text-center position-relative mb-5">
                    <h6 class="d-inline-block position-relative text-success text-uppercase pb-2 font-weight-bold" style="letter-spacing: 0.15em;">Our Courses</h6>
                    <h1 class="display-4 font-weight-bold" style="color: #343a40;">Checkout New Releases Of Our Courses</h1>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($programs as $program)
            <div class="col-lg-4 col-md-6 pb-4">
                <div class="card courses-list-item shadow-sm rounded-lg overflow-hidden" style="transition: transform 0.3s;">
                    <a href="{{ route('landing.page.detail-program', $program->id) }}" style="text-decoration: none; color: inherit;">
                        <div class="img-wrapper position-relative overflow-hidden" style="height: 250px;">
                            <img class="img-fluid w-100 h-100 object-fit-cover" src="{{ asset('storage/' . $program->gambar) }}" alt="{{ $program->nama_program }}">
                        </div>
                        <div class="card-body text-center">
                            <h4 class="text-dark font-weight-bold mb-3" style="font-size: 1.35rem;">{{ $program->nama_program }}</h4>
                            <div class="d-flex justify-content-center align-items-center gap-4">
                                <span class="badge badge-success d-flex align-items-center px-3 py-2 rounded-pill shadow-sm">
                                    <i class="fa fa-user" style="color: #fff;"></i> {{ $program->instruktur }}
                                </span>
                                <span class="badge badge-success-light d-flex align-items-center px-3 py-2 rounded-pill shadow-sm">
                                    <i class="fa fa-star"></i> {{ $program->rating }}
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
</div>
<!-- Courses End -->

<style>
    .courses-list-item {
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .courses-list-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }
    .badge-success {
        background-color: #28a745 !important;
        color: #fff !important;
    }
    .badge-success-light {
        color: #28a745 !important;
        background-color: #e6f4ea !important;
    }
    .object-fit-cover {
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .img-wrapper:hover .object-fit-cover {
        transform: scale(1.05);
    }
    @media (max-width: 576px) {
        .badge {
            font-size: 0.8rem !important;
            padding: 0.4rem 0.8rem !important;
        }
        .card-body h4 {
            font-size: 1.15rem !important;
        }
    }
</style>
@endsection
