@extends('landing.layout.main')

@section('title', 'Program')

@section('content')
<!-- Header Start -->
<div class="jumbotron jumbotron-fluid page-header position-relative overlay-bottom" style="margin-bottom: 90px;">
    <div class="container text-center py-5">
        <h1 class="text-white display-1">Courses</h1>
        <div class="d-inline-flex text-white mb-5">
            <p class="m-0 text-uppercase"><a class="text-white" href="{{ url('/') }}">Home</a></p>
            <i class="fa fa-angle-double-right pt-1 px-3"></i>
            <p class="m-0 text-uppercase">Courses</p>
        </div>
    </div>
</div>
<!-- Header End -->

<!-- Courses Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="row mx-0 justify-content-center">
            <div class="col-lg-8">
                <div class="section-title text-center position-relative mb-5">
                    <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">Our Courses</h6>
                    <h1 class="display-4">Checkout New Releases Of Our Courses</h1>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($programs as $program)
            <div class="col-lg-4 col-md-6 pb-4">
                <a class="courses-list-item position-relative d-block overflow-hidden mb-2"
                    href="{{ route('landing.page.detail-program', $program->id) }}">
                    <img class="img-fluid w-100"
                        src="{{ asset('storage/' . $program->gambar) }}"
                        alt="{{ $program->nama_program }}"
                        style="height: 250px; object-fit: cover;">
                    <div class="courses-text">
                        <h4 class="text-center text-white px-3">{{ $program->nama_program }}</h4>
                        <div class="border-top w-100 mt-3">
                            <div class="d-flex justify-content-between p-4">
                                <span class="text-white"><i class="fa fa-user mr-2"></i>{{ $program->instruktur }}</span>
                                <span class="text-white"><i class="fa fa-star mr-2"></i>{{ $program->rating }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach

            <div class="col-lg-4 col-md-6 pb-4">
                <div class="courses-list-item position-relative d-block overflow-hidden mb-2">
                    <img class="img-fluid w-100"
                        src="{{ asset('assets2/img/lainnya.jpg') }}"
                        alt="Tunggu Program Lainnya"
                        style="height: 250px; object-fit: cover;">
                    <div class="courses-text">
                        <h4 class="text-center text-white px-3">Coming Soon</h4>
                        <div class="border-top w-100 mt-3">
                            <div class="d-flex justify-content-center p-4">
                                <span class="text-white">Segera Hadir</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-12">
            {{ $programs->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>

<!-- Courses End -->
@endsection
