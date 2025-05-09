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
                <a class="courses-list-item d-block position-relative overflow-hidden mb-2 rounded-lg shadow-sm" href="{{ route('landing.page.detail-program', $program->id) }}" style="text-decoration: none; color: inherit; background: rgba(255, 255, 255, 0.8); backdrop-filter: saturate(180%) blur(12px); border-radius: 16px; transition: all 0.4s ease;">
                    <div class="img-wrapper position-relative overflow-hidden rounded-top-lg" style="height: 250px;">
                        <img class="img-fluid w-100 h-100 object-fit-cover" src="{{ asset('storage/' . $program->gambar) }}" alt="{{ $program->nama_program }}" style="transition: transform 0.5s ease;">
                        <div class="img-overlay position-absolute w-100 h-100 top-0 left-0" style="background: linear-gradient(180deg, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.6) 100%); transition: background 0.5s ease;"></div>
                    </div>
                    <div class="courses-text px-3 py-4 text-center">
                        <h4 class="text-dark font-weight-bold mb-3" style="color:font-size: 1.35rem; transition: color 0.4s;">{{ $program->nama_program }}</h4>
                        <div class="d-flex justify-content-center align-items-center gap-4">
                            <span class="badge badge-success d-flex align-items-center px-3 py-2 rounded-pill shadow-sm" style="gap: 0.5rem; font-weight: 600;">
                                <i class="fa fa-user" style="color: #fff;"></i> {{ $program->instruktur }}
                            </span>
                            <span class="badge badge-success-light d-flex align-items-center px-3 py-2 rounded-pill shadow-sm" style="gap: 0.5rem; font-weight: 600; color: #28a745; background-color: #e6f4ea;">
                                <i class="fa fa-star"></i> {{ $program->rating }}
                            </span>
                        </div>
                    </div>
                </a>
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
    .courses-list-item:hover {
        background: rgba(255, 255, 255, 1) !important;
        box-shadow: 0 10px 30px rgb(40 167 69 / 0.3); /* lighter green shadow */
        transform: translateY(-8px);
        text-decoration: none;
        color: #212529 !important;
    }
    .courses-list-item:hover .img-wrapper img {
        transform: scale(1.1);
    }
    .courses-list-item:hover .img-overlay {
        background: linear-gradient(180deg, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.2) 100%);
    }
    .courses-list-item:hover h4 {
        color: #28a745 !important;
        text-decoration: underline;
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
    }
    @media (max-width: 576px) {
        .badge {
            font-size: 0.8rem !important;
            padding: 0.4rem 0.8rem !important;
            gap: 0.3rem !important;
        }
        .courses-text h4 {
            font-size: 1.15rem !important;
        }
    }
</style>
@endsection
