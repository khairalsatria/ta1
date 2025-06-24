@extends('landing.layout.main')

@section('title', 'Contact')

@section('content')

<!-- Header Start -->
<div class="jumbotron jumbotron-fluid page-header position-relative overlay-bottom mb-5">
    <div class="container text-center py-5">
        <h1 class="text-white display-4 font-weight-bold" style="text-shadow: 2px 2px 10px rgba(0,0,0,0.7);">Contact</h1>
        <div class="d-inline-flex text-white mt-3 font-weight-semibold">
            <p class="m-0 text-uppercase"><a class="text-white" href="{{ url('/') }}">Home</a></p>
            <i class="fa fa-angle-double-right pt-1 px-3"></i>
            <p class="m-0 text-uppercase text-white">Contact</p>
        </div>
    </div>
</div>
<!-- Header End -->

@php
use App\Models\Kontak;
$kontaks = Kontak::all();
@endphp

<!-- Contact Start -->
<div class="container-fluid py-5 bg-white ">
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
