@php use Illuminate\Support\Facades\Auth; @endphp

@extends('siswa.layout.main')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="page-heading">
    <h3>Selamat Datang, {{ Auth::user()->name }}</h3>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12 col-lg-9">
            <div class="row">
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                    <div class="stats-icon purple mb-2">
                                        <i class="iconly-boldShow"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Total Program</h6>
                                    <h6 class="font-extrabold mb-0">{{ $totalProgram }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                    <div class="stats-icon blue mb-2">
                                        <i class="iconly-boldProfile"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">GenZE Class</h6>
                                    <h6 class="font-extrabold mb-0">{{ $jumlahClass }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                    <div class="stats-icon green mb-2">
                                        <i class="iconly-boldAdd-User"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">GenZE Guide</h6>
                                    <h6 class="font-extrabold mb-0">{{ $jumlahGuide }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                    <div class="stats-icon red mb-2">
                                        <i class="iconly-boldBookmark"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">GenZE Learn</h6>
                                    <h6 class="font-extrabold mb-0">{{ $jumlahLearn }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="fw-bold">Jumlah Kelas yang Kamu Ikuti</h5>
                            <h3 class="text-success fw-bold">{{ $jumlahKelasIkut }}</h3>
                            <a href="{{ route('siswa.dashboard') }}" class="btn btn-outline-primary btn-sm mt-3">Lihat Detail Kelas</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-3">
            <div class="card">
                <div class="card-body py-4 px-5">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-xl">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff" alt="Avatar">
                        </div>
                        <div class="ms-3 name">
                            <h5 class="font-bold mb-0">{{ Auth::user()->name }}</h5>
                            <h6 class="text-muted mb-0">{{ Auth::user()->username }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
