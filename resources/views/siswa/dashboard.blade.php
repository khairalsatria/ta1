@php use Illuminate\Support\Facades\Auth; @endphp

@extends('siswa.layout.main') {{-- Jika ada layout khusus siswa, ganti ke siswa.layout.main --}}

@section('title', 'Dashboard Siswa')

@section('content')
<div class="page-heading mb-4 d-flex justify-content-between align-items-center">
    <h3 class="font-bold mb-0">Selamat Datang, {{ Auth::user()->name }}</h3>
    <a href="{{ url('/profile') }}" class="btn btn-outline-primary btn-sm">
        <i class="iconly-boldSetting"></i> Account Setting
    </a>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12 mb-5">
            <div class="row g-3">

                {{-- Total Program Status Menunggu --}}
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="stats-icon purple mb-3">
                                <i class="iconly-boldTime-Circle"></i>
                            </div>
                            <h6 class="text-muted mb-1">Pendaftaran Diproses</h6>
                            <h3 class="font-extrabold mb-3">{{ $totalProgramMenunggu }}</h3>
                            <a href="{{ route('siswa.program-saya.index') }}" class="btn btn-outline-primary btn-sm mt-auto">
                                List Pendaftaran
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Total Program Diterima --}}
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="stats-icon green mb-3">
                                <i class="iconly-boldTick-Square"></i>
                            </div>
                            <h6 class="text-muted mb-1">Pendaftaran Diterima</h6>
                            <h3 class="font-extrabold mb-3">{{ $totalProgramDiterima }}</h3>
                            <a href="{{ route('siswa.program-saya.index') }}" class="btn btn-outline-primary btn-sm mt-auto">
                                List Pendaftaran
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Total Semua Kelas Diikuti (Icon Pencil) --}}
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="stats-icon blue mb-3">
                                <i class="iconly-boldEdit-Square"></i> {{-- Icon pensil --}}
                            </div>
                            <h6 class="text-muted mb-1">Kelas Diikuti</h6>
                            <h3 class="font-extrabold mb-0">{{ $jumlahKelasIkut }}</h3>
                            <a href="{{ route('siswa.kelas-saya') }}" class="btn btn-outline-primary btn-sm mt-auto">
                                List Kelas
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Total GenZE Class Diikuti (Icon Buku) --}}
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body d-flex flex-column align-items-start">
                            <div class="stats-icon blue mb-3">
                                <i class="iconly-boldPaper"></i> {{-- Icon buku --}}
                            </div>
                            <h6 class="text-muted mb-1">GenZE Class</h6>
                            <h3 class="font-extrabold mb-0">{{ $totalGenzeClass }}</h3>
                        </div>
                    </div>
                </div>

                {{-- Total GenZE Guide Diikuti (Icon Paper) --}}
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body d-flex flex-column align-items-start">
                            <div class="stats-icon red mb-3">
                                <i class="iconly-boldMessage"></i>
                            </div>
                            <h6 class="text-muted mb-1">GenZE Guide</h6>
                            <h3 class="font-extrabold mb-0">{{ $totalGenzeGuide }}</h3>
                        </div>
                    </div>
                </div>

                {{-- Total GenZE Learn Diikuti (Icon Mic) --}}
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body d-flex flex-column align-items-start">
                            <div class="stats-icon purple mb-3">
                                <i class="iconly-boldVoice"></i>
                            </div>
                            <h6 class="text-muted mb-1">GenZE Learn</h6>
                            <h3 class="font-extrabold mb-0">{{ $totalGenzeLearn }}</h3>
                        </div>
                    </div>
                </div>

            </div><!-- /row metrics -->
        </div>
    </section>
</div>
@endsection
