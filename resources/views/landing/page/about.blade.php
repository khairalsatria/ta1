@extends('landing.layout.main')

@section('title', 'About')

@section('content')

<!-- Header Start -->
<div class="jumbotron jumbotron-fluid page-header position-relative overlay-bottom mb-5">
    <div class="container text-center py-5">
        <h1 class="text-white display-4 font-weight-bold" style="text-shadow: 2px 2px 10px rgba(0,0,0,0.7);">About</h1>
        <div class="d-inline-flex text-white mt-3 font-weight-semibold">
            <p class="m-0 text-uppercase"><a class="text-white" href="{{ url('/') }}">Home</a></p>
            <i class="fa fa-angle-double-right pt-1 px-3"></i>
            <p class="m-0 text-uppercase text-white">About</p>
        </div>
    </div>
</div>
<!-- Header End -->

<!-- About Start -->
<div class="container py-5">
    <div class="row align-items-center">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <div class="rounded overflow-hidden shadow-sm" style="aspect-ratio: 4/3;">
                <img src="{{ asset('assets2/img/about.jpg') }}" alt="About GenZE" class="img-fluid w-100 h-100 object-fit-cover">
            </div>
        </div>
        <div class="col-lg-6">
            <h6 class="text-success text-uppercase font-weight-bold mb-2">About Us</h6>
            <h2 class="display-5 font-weight-bold text-dark mb-3">Your First Choice For Online Education</h2>
            <p class="text-muted">GenZE hadir sebagai platform pembelajaran online yang memprioritaskan kualitas, fleksibilitas, dan keberhasilan siswa. Kami menggabungkan pengajar berpengalaman dengan materi yang up-to-date dan sistem interaktif.</p>
            <div class="row text-center mt-4">
                <div class="col-6 col-md-3 mb-3">
                    <div class="bg-success text-white py-3 rounded">
                        <h4 class="mb-1" data-toggle="counter-up">123</h4>
                        <small>Subjects</small>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="bg-primary text-white py-3 rounded">
                        <h4 class="mb-1" data-toggle="counter-up">1234</h4>
                        <small>Courses</small>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="bg-secondary text-white py-3 rounded">
                        <h4 class="mb-1" data-toggle="counter-up">123</h4>
                        <small>Instructors</small>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="bg-warning text-white py-3 rounded">
                        <h4 class="mb-1" data-toggle="counter-up">1234</h4>
                        <small>Students</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- About End -->

<!-- Feature Start -->
<div class="container py-5">
    <div class="row align-items-center">
        <div class="col-lg-6 order-2 order-lg-1">
            <h6 class="text-success text-uppercase font-weight-bold mb-2">Why Choose Us?</h6>
            <h2 class="display-5 font-weight-bold text-dark mb-3">Why Learn with GenZE?</h2>
            <p class="text-muted">Kami berkomitmen menghadirkan pengalaman belajar berkualitas tinggi dengan pendekatan yang humanis dan fleksibel.</p>
            <div class="d-flex mb-4">
                <div class="me-3">
                    <i class="fa fa-2x fa-graduation-cap text-primary"></i>
                </div>
                <div>
                    <h5 class="font-weight-bold">Skilled Instructors</h5>
                    <p class="mb-0">Mentor berpengalaman dan ahli di bidangnya siap membimbing Anda.</p>
                </div>
            </div>
            <div class="d-flex mb-4">
                <div class="me-3">
                    <i class="fa fa-2x fa-certificate text-secondary"></i>
                </div>
                <div>
                    <h5 class="font-weight-bold">Certified Courses</h5>
                    <p class="mb-0">Setiap program disertai sertifikat resmi sebagai bukti kompetensi.</p>
                </div>
            </div>
            <div class="d-flex">
                <div class="me-3">
                    <i class="fa fa-2x fa-book-reader text-warning"></i>
                </div>
                <div>
                    <h5 class="font-weight-bold">Flexible Learning</h5>
                    <p class="mb-0">Belajar kapan saja dan di mana saja sesuai kebutuhan Anda.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-6 order-1 order-lg-2 mb-4 mb-lg-0">
            <div class="rounded overflow-hidden shadow-sm" style="aspect-ratio: 4/3;">
                <img src="{{ asset('assets2/img/feature.jpg') }}" alt="Why Choose Us" class="img-fluid w-100 h-100 object-fit-cover">
            </div>
        </div>
    </div>
</div>
<!-- Feature End -->

<style>
    .object-fit-cover {
        object-fit: cover;
    }

    [data-toggle="counter-up"] {
        font-size: 1.75rem;
        font-weight: bold;
    }

    .rounded {
        border-radius: 12px;
    }

    @media (max-width: 576px) {
        h2.display-5 {
            font-size: 1.6rem;
        }
    }
</style>

@endsection
