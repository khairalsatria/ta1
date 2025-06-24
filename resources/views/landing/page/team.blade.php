@extends('landing.layout.main')

@section('title', 'Team')

@section('content')

<!-- Header Start -->
<div class="jumbotron jumbotron-fluid page-header position-relative overlay-bottom mb-5">
    <div class="container text-center py-5">
        <h1 class="text-white display-4 font-weight-bold" style="text-shadow: 2px 2px 10px rgba(0,0,0,0.7);">Team</h1>
        <div class="d-inline-flex text-white mt-3 font-weight-semibold">
            <p class="m-0 text-uppercase"><a class="text-white" href="{{ url('/') }}">Home</a></p>
            <i class="fa fa-angle-double-right pt-1 px-3"></i>
            <p class="m-0 text-uppercase text-white">Team</p>
        </div>
    </div>
</div>
<!-- Header End -->

<!-- Team Section Start -->
<div class="container py-5">
    <div class="text-center mb-5">
        <h6 class="text-success text-uppercase font-weight-bold mb-2">Our Mentors</h6>
        <h1 class="display-5 font-weight-bold text-dark">Meet the People Behind GenZE</h1>
        <p class="text-muted mx-auto" style="max-width: 600px;">Get to know our dedicated mentors who are passionate about helping you reach your academic and career goals.</p>
    </div>

    <div class="row">
        @foreach ($mentors as $mentor)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card team-card border-0 shadow-sm h-100 rounded-3 overflow-hidden">
                <div class="team-img-wrapper position-relative">
                    <img class="img-fluid w-100 team-img"
                        src="{{ $mentor->photo ? asset('storage/' . $mentor->photo) : asset('assets2/img/team-1.jpg') }}"
                        alt="{{ $mentor->name }}">
                    <span class="badge-role position-absolute top-0 start-0 m-3 px-3 py-2 text-white rounded-pill">Mentor</span>
                </div>
                <div class="card-body p-4 text-center">
                    <h5 class="card-title font-weight-bold text-dark mb-2">{{ $mentor->name }}</h5>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle" title="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle" title="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<!-- Team Section End -->

<style>
    .team-card {
        transition: all 0.3s ease;
        background-color: #ffffff;
    }

    .team-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1);
    }

    .team-img-wrapper {
        aspect-ratio: 4 / 3;
        overflow: hidden;
        position: relative;
        background-color: #f0f0f0;
    }

    .team-img-wrapper img.team-img {
        object-fit: cover;
        width: 100%;
        height: 100%;
        transition: transform 0.4s ease;
        display: block;
    }

    .team-img-wrapper:hover img.team-img {
        transform: scale(1.05);
    }

    .badge-role {
        background: #28a745;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .btn-outline-secondary:hover {
        background-color: #198754;
        border-color: #198754;
        color: #fff;
    }

    @media (max-width: 576px) {
        .team-card .card-body {
            padding: 1rem;
        }

        .team-card h5 {
            font-size: 1.1rem;
        }

        .btn-sm {
            font-size: 0.75rem;
        }
    }
</style>

@endsection
