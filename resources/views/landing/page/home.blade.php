@extends('landing.layout.main')

@section('title', 'Home')

@section('content')
       <!-- Header Start -->
    <div class="jumbotron jumbotron-fluid position-relative overlay-bottom" style="margin-bottom: 90px;">
        <div class="container text-center my-5 py-5">
            <h1 class="text-white mt-4 mb-4">Learn From Home</h1>
            <h1 class="text-white display-1 mb-5">Education Courses</h1>
            <div class="mx-auto mb-5" style="width: 100%; max-width: 600px;">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-light bg-white text-body px-4 dropdown-toggle" type="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">Courses</button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Courses 1</a>
                            <a class="dropdown-item" href="#">Courses 2</a>
                            <a class="dropdown-item" href="#">Courses 3</a>
                        </div>
                    </div>
                    <input type="text" class="form-control border-light" style="padding: 30px 25px;" placeholder="Keyword">
                    <div class="input-group-append">
                        <button class="btn btn-secondary px-4 px-lg-5">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->


    <!-- About Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-5 mb-5 mb-lg-0" style="min-height: 500px;">
                    <div class="position-relative h-100">
                        <img class="position-absolute w-100 h-100" src="assets2/img/about.jpg" style="object-fit: cover;">
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="section-title position-relative mb-4">
                        <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">About Us</h6>
                        <h1 class="display-4">First Choice For Online Education Anywhere</h1>
                    </div>
                    <p>Tempor erat elitr at rebum at at clita aliquyam consetetur. Diam dolor diam ipsum et, tempor voluptua sit consetetur sit. Aliquyam diam amet diam et eos sadipscing labore. Clita erat ipsum et lorem et sit, sed stet no labore lorem sit. Sanctus clita duo justo et tempor consetetur takimata eirmod, dolores takimata consetetur invidunt magna dolores aliquyam dolores dolore. Amet erat amet et magna</p>
                    <div class="row pt-3 mx-0">
                        <div class="col-3 px-0">
                            <div class="bg-success text-center p-4">
                                <h1 class="text-white" data-toggle="counter-up">123</h1>
                                <h6 class="text-uppercase text-white">Available<span class="d-block">Subjects</span></h6>
                            </div>
                        </div>
                        <div class="col-3 px-0">
                            <div class="bg-primary text-center p-4">
                                <h1 class="text-white" data-toggle="counter-up">1234</h1>
                                <h6 class="text-uppercase text-white">Online<span class="d-block">Courses</span></h6>
                            </div>
                        </div>
                        <div class="col-3 px-0">
                            <div class="bg-secondary text-center p-4">
                                <h1 class="text-white" data-toggle="counter-up">123</h1>
                                <h6 class="text-uppercase text-white">Skilled<span class="d-block">Instructors</span></h6>
                            </div>
                        </div>
                        <div class="col-3 px-0">
                            <div class="bg-warning text-center p-4">
                                <h1 class="text-white" data-toggle="counter-up">1234</h1>
                                <h6 class="text-uppercase text-white">Happy<span class="d-block">Students</span></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->


    <!-- Feature Start -->
    <div class="container-fluid bg-image" style="margin: 90px 0;">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 my-5 pt-5 pb-lg-5">
                    <div class="section-title position-relative mb-4">
                        <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">Why Choose Us?</h6>
                        <h1 class="display-4">Why You Should Start Learning with Us?</h1>
                    </div>
                    <p class="mb-4 pb-2">Aliquyam accusam clita nonumy ipsum sit sea clita ipsum clita, ipsum dolores amet voluptua duo dolores et sit ipsum rebum, sadipscing et erat eirmod diam kasd labore clita est. Diam sanctus gubergren sit rebum clita amet.</p>
                    <div class="d-flex mb-3">
                        <div class="btn-icon bg-primary mr-4">
                            <i class="fa fa-2x fa-graduation-cap text-white"></i>
                        </div>
                        <div class="mt-n1">
                            <h4>Skilled Instructors</h4>
                            <p>Labore rebum duo est Sit dolore eos sit tempor eos stet, vero vero clita magna kasd no nonumy et eos dolor magna ipsum.</p>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="btn-icon bg-secondary mr-4">
                            <i class="fa fa-2x fa-certificate text-white"></i>
                        </div>
                        <div class="mt-n1">
                            <h4>International Certificate</h4>
                            <p>Labore rebum duo est Sit dolore eos sit tempor eos stet, vero vero clita magna kasd no nonumy et eos dolor magna ipsum.</p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="btn-icon bg-warning mr-4">
                            <i class="fa fa-2x fa-book-reader text-white"></i>
                        </div>
                        <div class="mt-n1">
                            <h4>Online Classes</h4>
                            <p class="m-0">Labore rebum duo est Sit dolore eos sit tempor eos stet, vero vero clita magna kasd no nonumy et eos dolor magna ipsum.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5" style="min-height: 500px;">
                    <div class="position-relative h-100">
                        <img class="position-absolute w-100 h-100" src="assets2/img/feature.jpg" style="object-fit: cover;">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Feature Start -->


    <!-- Program Start -->
    <div class="container-fluid px-0 py-5">
        <div class="row mx-0 justify-content-center pt-5">
            <div class="col-lg-6">
                <div class="section-title text-center position-relative mb-4">
                    <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">Our Courses</h6>
                    <h1 class="display-4">Checkout New Releases Of Our Courses</h1>
                </div>
            </div>
        </div>

        <div class="owl-carousel courses-carousel">
            @foreach ($programs as $program)
            <div class="courses-item position-relative">
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
                    <div class="w-100 bg-white text-center p-4">
                        <a class="btn btn-primary" href="{{ route('landing.page.detail-program', $program->id) }}">Course Detail</a>
                    </div>
                </div>
            </div>
            @endforeach

            <div class="courses-item position-relative">
                <img class="img-fluid w-100"
                    src="{{ asset('assets2/img/lainnya.jpg') }}"
                    alt=Tunggu Program Lainnya
                    style="height: 250px; object-fit: cover;">
                <div class="courses-text">
                    <h4 class="text-center text-white px-3">Coming Soon</h4>
                    <div class="border-top w-100 mt-3">
                        <div class="d-flex justify-content-center p-4">
                            <span class="text-white">Segera Hadir</span>
                        </div>
                    </div>
                    <div class="w-100 bg-white text-center p-4">
                        <a class="btn btn-primary" href="">Loading</a>
                    </div>
                </div>
            </div>
        </div>

        @php
    use App\Models\MediaPartner;
    $mediaPartners = MediaPartner::all();
@endphp

<div class="row justify-content-center bg-image mx-0 mb-5">
    <div class="col-lg-8 py-5">
        <div class="p-5 my-5">
            <h1 class="text-center mb-5">Our Trusted Partners</h1>
            <div class="row">
                @forelse($mediaPartners as $partner)
                    <div class="col-4 col-md-2 mb-4 d-flex justify-content-center">
                        <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->nama }}" class="img-fluid logo-size">
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p>Belum ada media partner.</p>
                    </div>
                @endforelse
                @forelse($mediaPartners as $partner)
                    <div class="col-4 col-md-2 mb-4 d-flex justify-content-center">
                        <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->nama }}" class="img-fluid logo-size">
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p>Belum ada media partner.</p>
                    </div>
                @endforelse

            </div>

        </div>
    </div>
</div>

<style>
    .logo-size {
        width: 100%;
        max-width: 150px;
        height: auto;
        object-fit: contain;
    }
</style>


    </div>
    <!-- Program End -->


    <!-- Mentor Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="section-title text-center position-relative mb-5">
                <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">Instructors</h6>
                <h1 class="display-4">Meet Our Instructors</h1>
            </div>
            <div class="owl-carousel team-carousel position-relative" style="padding: 0 30px;">
                @foreach ($mentors as $mentor)
    <div class="team-item">
        <img
            class="img-fluid w-100"
            src="{{ $mentor->photo ? asset('storage/' . $mentor->photo) : asset('assets2/img/team-1.jpg') }}"
            alt="{{ $mentor->name }}"
            style="height: 300px; object-fit: cover; border-radius: 5px;">
        <div class="bg-light text-center p-4">
            <h5 class="mb-3">{{ $mentor->name }}</h5>
            <p class="mb-2">Mentor GenZE Class</p>
            <div class="d-flex justify-content-center">
                <a class="mx-1 p-1" href="#"><i class="fab fa-twitter"></i></a>
                <a class="mx-1 p-1" href="#"><i class="fab fa-facebook-f"></i></a>
                <a class="mx-1 p-1" href="#"><i class="fab fa-linkedin-in"></i></a>
                <a class="mx-1 p-1" href="#"><i class="fab fa-instagram"></i></a>
                <a class="mx-1 p-1" href="#"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
    </div>
@endforeach

            </div>
        </div>
    </div>
    <!-- Mentor End -->


    <!-- Testimonial Start -->
    <div class="container-fluid bg-image py-5" style="margin: 90px 0;">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-5 mb-5 mb-lg-0">
                    <div class="section-title position-relative mb-4">
                        <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">Testimonial</h6>
                        <h1 class="display-4">What Say Our Students</h1>
                    </div>
                    <p class="m-0">Dolor est dolores et nonumy sit labore dolores est sed rebum amet, justo duo ipsum sanctus dolore magna rebum sit et. Diam lorem ea sea at. Nonumy et at at sed justo est nonumy tempor. Vero sea ea eirmod, elitr ea amet diam ipsum at amet. Erat sed stet eos ipsum diam</p>
                </div>
                <div class="col-lg-7">
                    <div class="owl-carousel testimonial-carousel">
                        <div class="bg-white p-5">
                            <i class="fa fa-3x fa-quote-left text-primary mb-4"></i>
                            <p>Sed et elitr ipsum labore dolor diam, ipsum duo vero sed sit est est ipsum eos clita est ipsum. Est nonumy tempor at kasd. Sed at dolor duo ut dolor, et justo erat dolor magna sed stet amet elitr duo lorem</p>
                            <div class="d-flex flex-shrink-0 align-items-center mt-4">
                                <img class="img-fluid mr-4" src="assets2/img/testimonial-2.jpg" alt="">
                                <div>
                                    <h5>Student Name</h5>
                                    <span>Web Design</span>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white p-5">
                            <i class="fa fa-3x fa-quote-left text-primary mb-4"></i>
                            <p>Sed et elitr ipsum labore dolor diam, ipsum duo vero sed sit est est ipsum eos clita est ipsum. Est nonumy tempor at kasd. Sed at dolor duo ut dolor, et justo erat dolor magna sed stet amet elitr duo lorem</p>
                            <div class="d-flex flex-shrink-0 align-items-center mt-4">
                                <img class="img-fluid mr-4" src="assets2/img/testimonial-1.jpg" alt="">
                                <div>
                                    <h5>Student Name</h5>
                                    <span>Web Design</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial Start -->


    <!-- Contact Start -->
    @php
    use App\Models\Kontak;
    $kontaks = Kontak::all();
@endphp

<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="section-title position-relative mb-5 text-center">
            <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">Our Contact</h6>
            <h1 class="display-4">Find Us On Social Media</h1>
        </div>
        <div class="row justify-content-center mt-3">
            <!-- Kolom Kiri: Semua Info Kontak -->
            @foreach ($kontaks as $kontak)
                @php
                    $tipe = strtolower($kontak->kontak);
                    $icon = 'fa-info-circle';
                    $warna = 'primary';
                    $link = in_array($tipe, ['whatsapp','instagram', 'facebook', 'tiktok']) ? $kontak->link : null;

                    switch ($tipe) {
                        case 'alamat':
                            $icon = 'fa-map-marker-alt'; $warna = 'primary'; break;
                        case 'telepon':
                            $icon = 'fa-phone-alt'; $warna = 'secondary'; break;
                        case 'email':
                            $icon = 'fa-envelope'; $warna = 'warning'; break;
                        case 'instagram':
                            $icon = 'fab fa-instagram'; $warna = 'danger'; break;
                        case 'facebook':
                            $icon = 'fab fa-facebook-f'; $warna = 'primary'; break;
                        case 'tiktok':
                            $icon = 'fab fa-tiktok'; $warna = 'dark'; break;
                    }
                @endphp

                <div class="col-4 col-md-2 mb-4 d-flex justify-content-center">
                    @if ($link)
                        <a href="{{ $link }}" target="_blank" class="text-decoration-none text-dark">
                    @endif
                        <div class="text-center d-flex flex-column align-items-center">
                            <!-- Logo/Icon -->
                            <div class="btn-icon bg-{{ $warna }} mb-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 70px; height: 70px;">
                                <i class="fa fa-2x {{ $icon }} text-white"></i>
                            </div>
                            <!-- Teks Kontak -->
                            <div>
                                <h5 class="mb-2">{{ ucfirst($tipe) }}</h5>
                                <p class="m-0">{{ $kontak->isi }}</p>
                            </div>
                        </div>
                    @if ($link)
                        </a>
                    @endif
                </div>
            @endforeach

            @if($kontaks->isEmpty())
                <div class="col-12 text-center">
                    <p>Belum ada kontak yang ditampilkan.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .logo-size {
        width: 100%;
        max-width: 150px;
        height: auto;
        object-fit: contain;
    }
    .btn-icon {
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>









    <!-- Contact End -->
@endsection
