@extends('landing.layout.main')

@section('title', 'Team')

@section('content')

<!-- Header Start -->
<div class="jumbotron jumbotron-fluid page-header position-relative overlay-bottom" style="margin-bottom: 90px;">
    <div class="container text-center py-5">
        <h1 class="text-white display-1">Contact</h1>
        <div class="d-inline-flex text-white mb-5">
            <p class="m-0 text-uppercase"><a class="text-white" href="">Home</a></p>
            <i class="fa fa-angle-double-right pt-1 px-3"></i>
            <p class="m-0 text-uppercase">Contact</p>
        </div>
    </div>
</div>
<!-- Header End -->


<!-- Contact Start -->
    <!-- Contact Start -->
@php
use App\Models\Kontak;
$kontaks = Kontak::all();
@endphp

<div class="container-fluid py-5">
<div class="container py-5">
    <div class="section-title position-relative mb-5 text-center">
        <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">Our Contact</h6>
        <h1 class="text-center mb-5">Find Us on Social Media</h1>
    </div>

    <div class="row justify-content-center mt-3">
        @foreach ($kontaks as $kontak)
            @php
                $tipe = strtolower($kontak->kontak);
                $link = in_array($tipe, ['whatsapp','instagram', 'facebook', 'tiktok']) ? $kontak->link : null;

                switch ($tipe) {
                    case 'alamat':
                        $icon = ['fas', 'fa-map-marker-alt']; $warna = '#dc3545'; break;
                    case 'telepon':
                        $icon = ['fas', 'fa-phone-alt']; $warna = '#6c757d'; break;
                    case 'email':
                        $icon = ['fas', 'fa-envelope']; $warna = '#ffc107'; break;
                    case 'instagram':
                        $icon = ['fab', 'fa-instagram']; $warna = '#C13584'; break;
                    case 'facebook':
                        $icon = ['fab', 'fa-facebook-f']; $warna = '#1877F2'; break;
                    case 'tiktok':
                        $icon = ['fab', 'fa-tiktok']; $warna = '#010101'; break;
                    case 'whatsapp':
                        $icon = ['fab', 'fa-whatsapp']; $warna = '#25D366'; break;
                    default:
                        $icon = ['fas', 'fa-info-circle']; $warna = '#0d6efd'; break;
                }
            @endphp

            <div class="col-6 col-md-3 col-lg-2 mb-4 d-flex justify-content-center animate-fade-up">
                @if ($link)
                    <a href="{{ $link }}" target="_blank" class="text-decoration-none text-dark w-100">
                @endif

                <div class="contact-card text-center d-flex flex-column align-items-center p-3 rounded shadow-sm h-100 transition">
                    <div class="btn-icon mb-3 d-flex align-items-center justify-content-center rounded-circle shadow"
                         style="width: 70px; height: 70px; background-color: {{ $warna }}">
                        <i class="{{ $icon[0] }} {{ $icon[1] }} fa-2x text-white"></i>
                    </div>
                    <h6 class="mb-1">{{ ucfirst($tipe) }}</h6>
                    <p class="m-0 small text-muted text-wrap">{{ $kontak->isi }}</p>
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
.contact-card {
    background: #ffffff;
    transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
}

.contact-card:hover {
    transform: translateY(-6px);
    background-color: rgba(108, 117, 125, 0.1); /* Warna abu-abu transparan */
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
}

.btn-icon:hover {
    transform: rotate(10deg) scale(1.1);
}

.section-title h1 {
    font-weight: bold;
    letter-spacing: 1px;
}

.animate-fade-up {
    opacity: 0;
    transform: translateY(20px);
    animation: fadeUp 0.6s ease-out forwards;
}

@keyframes fadeUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
<!-- Contact End -->


@endsection
