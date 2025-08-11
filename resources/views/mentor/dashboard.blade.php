@php use Illuminate\Support\Facades\Auth; @endphp

@extends('mentor.layout.main')

@section('title', 'Dashboard Mentor')

@section('content')
<div class="page-heading mb-4 d-flex justify-content-between align-items-center">
    <h3 class="font-bold mb-0">Selamat Datang, Mentor {{ Auth::user()->name }}</h3>
    <a href="{{ url('/profile') }}" class="btn btn-primary btn-sm">
        <i class="iconly-home "></i> Home
    </a>
</div>

<div class="page-content">
    <section class="row">
        <div class="col-12 mb-5">
            <div class="row g-3">

                {{-- Total Kelas Diampu --}}
                <div class="col-12 col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="stats-icon blue mb-3">
                                <i class="iconly-boldEdit-Square"></i> {{-- ikon pensil / kelas --}}
                            </div>
                            <h6 class="text-muted mb-1">Kelas Diampu</h6>
                            <h3 class="font-extrabold mb-3">{{ $totalKelasDiajar ?? 0 }}</h3>
                            {{-- <a href="{{ route('mentor.kelas.index') }}" class="btn btn-outline-primary btn-sm mt-auto"> --}}
                                {{-- List Kelas --}}
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Total Siswa Dibimbing --}}
                <div class="col-12 col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="stats-icon green mb-3">
                                <i class="iconly-boldUser"></i>
                            </div>
                            <h6 class="text-muted mb-1">Siswa Dibimbing</h6>
                            <h3 class="font-extrabold mb-3">{{ $totalSiswaDiajar ?? 0 }}</h3>
                            {{-- Ganti rute berikut dengan rute daftar siswa per mentor jika ada --}}
                            {{-- <a href="{{ route('mentor.siswa.index') }}" class="btn btn-outline-primary btn-sm mt-auto"> --}}
                                {{-- List Siswa --}}
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Total Materi / Pertemuan Dibuat --}}
                <div class="col-12 col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="stats-icon purple mb-3">
                                <i class="iconly-boldPaper"></i> {{-- ikon materi --}}
                            </div>
                            <h6 class="text-muted mb-1">Materi Dibuat</h6>
                            <h3 class="font-extrabold mb-3">{{ $totalMateriPertemuan ?? 0 }}</h3>
                            {{-- <a href="{{ route('mentor.materi.index') }}" class="btn btn-outline-primary btn-sm mt-auto"> --}}
                                {{-- Kelola Materi --}}
                            </a>
                        </div>
                    </div>
                </div>

            </div> {{-- /row g-3 --}}
        </div>
    </section>
</div>
@endsection
