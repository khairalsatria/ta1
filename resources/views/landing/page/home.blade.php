@extends('landing.layout.main')

@section('title', 'Home')

@section('content')

<!-- Header Start -->
<div class="jumbotron jumbotron-fluid page-header position-relative overlay-bottom mb-5">
    <div class="container text-center py-5">
        <h1 class="text-white display-4 font-weight-bold" style="text-shadow: 2px 2px 10px rgba(0,0,0,0.7);">
            Empowering the Next Generation of Learners
        </h1>
        <h2 class="text-white font-weight-normal mb-4">Achieve More with GenZE</h2>
    </div>
</div>
<!-- Header End -->

<!-- About Start -->
<div class="container py-5">
    <div class="row align-items-center">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <div class="rounded overflow-hidden shadow-sm" style="max-height: 400px;">
                <img src="{{ asset('assets2/img/about.jpg') }}" class="img-fluid w-100 h-100" style="object-fit: cover;" alt="About GenZE">
            </div>
        </div>
        <div class="col-lg-6">
            <h6 class="text-success text-uppercase font-weight-bold mb-2">About Us</h6>
            <h2 class="display-5 font-weight-bold text-dark mb-4">First Choice for Online Education Anywhere</h2>
            <p class="text-muted">Kami hadir untuk memberikan akses pendidikan berkualitas tinggi di mana pun kamu berada. Dengan pengajar profesional dan materi terkini, kami membimbingmu mencapai masa depan yang lebih cerah.</p>
            <div class="row text-center mt-4">
                <div class="col-6 col-md-3 mb-3">
                    <div class="bg-success text-white py-3 rounded shadow">
                        <h3 class="mb-1" data-toggle="counter-up">123</h3>
                        <small>Subjects</small>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="bg-primary text-white py-3 rounded shadow">
                        <h3 class="mb-1" data-toggle="counter-up">1234</h3>
                        <small>Programs</small>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="bg-secondary text-white py-3 rounded shadow">
                        <h3 class="mb-1" data-toggle="counter-up">123</h3>
                        <small>Instructors</small>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="bg-warning text-white py-3 rounded shadow">
                        <h3 class="mb-1" data-toggle="counter-up">1234</h3>
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
        <div class="col-lg-6 mb-4 mb-lg-0 order-2 order-lg-1">
            <h6 class="text-success text-uppercase font-weight-bold mb-2">Why Choose Us?</h6>
            <h2 class="display-5 font-weight-bold text-dark mb-4">Why You Should Start Learning with Us?</h2>
            <p class="text-muted mb-4">Kami menyediakan sistem pembelajaran modern, materi berkualitas, dan dukungan penuh untuk pengembangan dirimu. Mulailah perjalanan belajarmu bersama GenZE.</p>
            <div class="d-flex mb-3">
                <div class="btn-icon bg-primary text-white mr-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="fa fa-graduation-cap"></i>
                </div>
                <div>
                    <h5>Skilled Instructors</h5>
                    <p class="text-muted mb-0">Tim pengajar kami berpengalaman di bidangnya dan siap membimbingmu secara optimal.</p>
                </div>
            </div>
            <div class="d-flex mb-3">
                <div class="btn-icon bg-secondary text-white mr-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="fa fa-certificate"></i>
                </div>
                <div>
                    <h5>International Certificate</h5>
                    <p class="text-muted mb-0">Dapatkan sertifikat resmi yang diakui dan dapat meningkatkan kredibilitasmu.</p>
                </div>
            </div>
            <div class="d-flex">
                <div class="btn-icon bg-warning text-white mr-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="fa fa-book-reader"></i>
                </div>
                <div>
                    <h5>Online Classes</h5>
                    <p class="text-muted mb-0">Akses pembelajaran kapan saja dan di mana saja melalui platform digital kami.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-6 order-1 order-lg-2">
            <div class="rounded overflow-hidden shadow-sm" style="max-height: 400px;">
                <img src="{{ asset('assets2/img/feature.jpg') }}" class="img-fluid w-100 h-100" style="object-fit: cover;" alt="Why Choose Us">
            </div>
        </div>
    </div>
</div>
<!-- Feature End -->

<!-- Program Start -->
<div class="container-fluid py-5 bg-light">
    <div class="row justify-content-center">
        <div class="col-lg-8 text-center mb-5">
            <h6 class="text-success text-uppercase font-weight-bold mb-2">Our Programs</h6>
            <h2 class="display-5 font-weight-bold">Checkout New Releases of Our Programs</h2>
            <p class="text-muted">Temukan program terbaru kami yang dirancang untuk membantumu berkembang.</p>
        </div>
    </div>

    <div class="owl-carousel courses-carousel px-4">
        @foreach ($programs as $program)
        <div class="card card-strong border-0 rounded-4 overflow-hidden h-100 bg-white">
            <div class="position-relative" style="height: 220px;">
                <img src="{{ asset('storage/' . $program->gambar) }}"
                     class="w-100 h-100 object-fit-cover"
                     alt="{{ $program->nama_program }}">
                <span class="badge badge-program position-absolute top-0 start-0 m-3 px-3 py-2 rounded-pill text-white">
                    {{ $program->tipe_program }}
                </span>
            </div>
            <div class="card-body px-4 py-3">
                <h5 class="fw-bold text-dark">{{ $program->nama_program }}</h5>
                <div class="d-flex justify-content-between text-muted small">
                    <span><i class="fa fa-user me-1 text-success"></i>{{ $program->instruktur }}</span>
                    <span><i class="fa fa-star me-1 text-warning"></i>{{ $program->rating }}</span>
                </div>
            </div>
            <div class="card-footer bg-white border-0 text-center pb-4">
                <a href="{{ route('landing.page.detail-program', $program->id) }}" class="btn btn-primary btn-sm px-4 rounded-pill">Course Detail</a>
            </div>
        </div>
        @endforeach
    </div>
</div>


<!-- Program End -->



<!-- Media Partner Start -->
@php
    use App\Models\MediaPartner;
    $mediaPartners = MediaPartner::all();
@endphp

@if ($mediaPartners->count())
<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 text-center mb-4">
            <h6 class="text-primary text-uppercase font-weight-bold mb-2">Our Partners</h6>
            <h2 class="display-6 font-weight-bold">Trusted Media Partners</h2>
            <p class="text-muted">Kami berkolaborasi dengan berbagai media terpercaya untuk menjangkau lebih banyak pelajar.</p>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center align-items-center">
            @foreach($mediaPartners as $partner)
            <div class="col-4 col-md-2 mb-4 d-flex justify-content-center">
                <img src="{{ asset('storage/' . $partner->logo) }}"
                     alt="{{ $partner->nama }}"
                     class="img-fluid partner-logo">
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif
<!-- Media Partner End -->


<!-- Styles -->
<style>
    .courses-carousel .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .courses-carousel .card:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .object-fit-cover {
        object-fit: cover;
    }

    .partner-logo {
        max-width: 120px;
        height: auto;
        object-fit: contain;
        transition: transform 0.3s ease;
    }

    .partner-logo:hover {
        transform: scale(1.05);
    }

    .courses-carousel .badge {
        font-size: 0.75rem;
        font-weight: 600;
    }
</style>


<!-- Mentor Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h6 class="text-success text-uppercase font-weight-bold mb-2">Team</h6>
            <h2 class="display-5 font-weight-bold text-dark">Meet Our Mentors</h2>
            <p class="text-muted mx-auto" style="max-width: 600px;">
                Inilah para mentor terbaik kami yang akan membimbing Anda dalam setiap perjalanan belajar.
            </p>
        </div>

        <div class="row g-4 justify-content-center">
            @foreach ($mentors as $mentor)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card team-card border-0 shadow-sm rounded-4 h-100 overflow-hidden transition hover-zoom">
                    <div class="team-img-wrapper position-relative" style="height: 280px;">
                        <img class="w-100 h-100 object-fit-cover"
                             src="{{ $mentor->photo ? asset('storage/' . $mentor->photo) : asset('assets2/img/team-1.jpg') }}"
                             alt="{{ $mentor->name }}">
                    </div>
                    <div class="card-body text-center py-4">
                        <h5 class="fw-bold mb-1">{{ $mentor->name }}</h5>
                        <p class="text-muted small mb-3">Mentor GenZE Class</p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="#" class="text-muted"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="text-muted"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="text-muted"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" class="text-muted"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="text-muted"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($mentors->isEmpty())
        <div class="text-center mt-4">
            <p class="text-muted">Belum ada mentor yang ditampilkan.</p>
        </div>
        @endif
    </div>
</div>
<!-- Mentor End -->

<style>
    .team-card {
        transition: all 0.3s ease-in-out;
        background: #fff;
    }

    .team-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
    }

    .team-img-wrapper img {
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .hover-zoom:hover img {
        transform: scale(1.05);
    }

    .card-body i {
        font-size: 1rem;
        transition: color 0.2s;
    }

    .card-body a:hover i {
        color: #28a745;
    }

    @media (max-width: 576px) {
        .team-img-wrapper {
            height: 240px;
        }
    }
</style>


   <!-- Testimonial & FAQ Start -->
<div class="container-fluid py-5 bg-light">
    <div class="container py-5">
        <!-- Section Title -->
        <div class="text-center mb-5">
            <h6 class="text-success text-uppercase font-weight-bold mb-2">Testimonial & FAQ</h6>
            <h2 class="display-5 font-weight-bold text-dark">Apa Kata Mereka?</h2>
            <p class="text-muted mx-auto" style="max-width: 600px;">
                Simak pengalaman para siswa kami serta jawaban dari pertanyaan yang sering diajukan.
            </p>
        </div>

        <!-- Testimonials -->
        <div class="row g-4 justify-content-center mb-5">
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-4 bg-white">
                    <i class="fa fa-3x fa-quote-left text-success mb-3"></i>
                    <p class="text-muted">Saya sangat terbantu dengan GenZE Class. Materinya lengkap dan mentornya ramah!</p>
                    <div class="d-flex align-items-center mt-4">
                        <img src="{{ asset('assets2/img/testimonial-1.jpg') }}" class="rounded-circle me-3" width="50" height="50" alt="">
                        <div>
                            <h6 class="fw-bold mb-0">Rina Aulia</h6>
                            <small class="text-muted">Siswa SMA</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-4 bg-white">
                    <i class="fa fa-3x fa-quote-left text-success mb-3"></i>
                    <p class="text-muted">Belajarnya seru dan fleksibel. Saya bisa ikut kelas Zoom dari rumah.</p>
                    <div class="d-flex align-items-center mt-4">
                        <img src="{{ asset('assets2/img/testimonial-2.jpg') }}" class="rounded-circle me-3" width="50" height="50" alt="">
                        <div>
                            <h6 class="fw-bold mb-0">Andi Saputra</h6>
                            <small class="text-muted">Siswa SMP</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="row align-items-stretch">
            <div class="col-md-7 mb-4 mb-md-0">
                <div id="faqAccordion">
                    @php
                        $faqs = [
                            ['question' => 'Apa itu GenZE Class?', 'answer' => 'GenZE Class adalah program bimbingan belajar yang menyediakan kelas online dan offline.'],
                            ['question' => 'Bagaimana cara mendaftar?', 'answer' => 'Isi form pendaftaran di website dan pilih jadwal yang sesuai.'],
                            ['question' => 'Apakah saya bisa memilih lebih dari satu jadwal?', 'answer' => 'Ya, Anda bisa memilih hingga 3 pilihan jadwal.'],
                            ['question' => 'Apa yang saya dapat setelah bergabung?', 'answer' => 'Akses materi PDF, soal latihan, rekaman sesi, dan Zoom Meeting untuk belajar.']
                        ];
                    @endphp

                    @foreach($faqs as $index => $faq)
                    <div class="card border-0 mb-3 shadow-sm">
                        <div class="card-header bg-white p-3 d-flex justify-content-between align-items-center cursor-pointer"
                             data-bs-toggle="collapse"
                             data-bs-target="#faq{{ $index }}"
                             aria-expanded="false"
                             aria-controls="faq{{ $index }}">
                            <span class="fw-semibold">{{ $faq['question'] }}</span>
                            <span class="text-success fs-5">+</span>
                        </div>
                        <div id="faq{{ $index }}" class="collapse" data-bs-parent="#faqAccordion">
                            <div class="card-body text-muted">
                                {{ $faq['answer'] }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="col-md-5 text-center">
                <img src="{{ asset('assets2/img/faq.png') }}" class="img-fluid mb-3" style="max-width: 300px;" alt="FAQ Illustration">
                <h5 class="fw-bold">Masih Ada Pertanyaan?</h5>
                <p class="text-muted">Hubungi tim kami jika pertanyaan Anda belum terjawab.</p>
            </div>
        </div>
    </div>
</div>

<!-- Styles -->
<style>
    .card-header:hover {
        background-color: #f8f9fa;
    }

    .cursor-pointer {
        cursor: pointer;
    }

    .card-body i {
        font-size: 1rem;
        transition: color 0.2s;
    }

    .card-body a:hover i {
        color: #28a745;
    }
</style>
<!-- Testimonial & FAQ End -->


 <!-- Contact Start -->
<div class="container-fluid py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h6 class="text-success text-uppercase font-weight-bold mb-2">Our Contact</h6>
            <h2 class="display-5 font-weight-bold text-dark">Connect With Us</h2>
            <p class="text-muted mx-auto" style="max-width: 600px;">
                Hubungi kami melalui berbagai platform media sosial atau informasi kontak resmi lainnya. Kami siap membantu Anda!
            </p>
        </div>

        <div class="row justify-content-center">
            @forelse ($kontaks as $kontak)
                @php
                    $tipe = strtolower($kontak->kontak);
                    $link = in_array($tipe, ['whatsapp','instagram','facebook','tiktok']) ? $kontak->link : null;

                    switch ($tipe) {
                        case 'alamat': $icon = ['fas', 'fa-map-marker-alt']; $warna = '#dc3545'; break;
                        case 'telepon': $icon = ['fas', 'fa-phone-alt']; $warna = '#6c757d'; break;
                        case 'email': $icon = ['fas', 'fa-envelope']; $warna = '#ffc107'; break;
                        case 'instagram': $icon = ['fab', 'fa-instagram']; $warna = '#C13584'; break;
                        case 'facebook': $icon = ['fab', 'fa-facebook-f']; $warna = '#1877F2'; break;
                        case 'tiktok': $icon = ['fab', 'fa-tiktok']; $warna = '#000000'; break;
                        case 'whatsapp': $icon = ['fab', 'fa-whatsapp']; $warna = '#25D366'; break;
                        default: $icon = ['fas', 'fa-info-circle']; $warna = '#0d6efd'; break;
                    }
                @endphp

                <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4 d-flex justify-content-center">
                    @if ($link)
                        <a href="{{ $link }}" target="_blank" class="text-decoration-none text-dark w-100 h-100">
                    @endif

                    <div class="contact-card text-center p-4 shadow-sm rounded-3 h-100 d-flex flex-column justify-content-center align-items-center">
                        <div class="icon-circle mb-3 d-flex align-items-center justify-content-center" style="background-color: {{ $warna }}">
                            <i class="{{ $icon[0] }} {{ $icon[1] }} fa-lg text-white"></i>
                        </div>
                        <h6 class="mb-1 text-capitalize">{{ $tipe }}</h6>
                        <p class="text-muted small text-wrap mb-0 text-center">{{ $kontak->isi }}</p>
                    </div>

                    @if ($link)
                        </a>
                    @endif
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">Belum ada kontak yang tersedia.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
<!-- Contact End -->

<style>
.contact-card {
    transition: all 0.3s ease-in-out;
    background-color: #fff;
}

.contact-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1);
}

.icon-circle {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    transition: 0.3s ease;
}

.icon-circle:hover {
    transform: scale(1.1) rotate(5deg);
}

@media (max-width: 576px) {
    .contact-card {
        padding: 1rem;
    }

    .icon-circle {
        width: 50px;
        height: 50px;
    }

    .contact-card h6 {
        font-size: 0.9rem;
    }

    .contact-card p {
        font-size: 0.75rem;
    }
}
</style>


@endsection
