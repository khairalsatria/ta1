@extends('landing.layout.main')
@section('title', 'Pendaftaran Program')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Pendaftaran Program</h2>

    <div class="row">
        @foreach ($programs as $program)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title">{{ $program->nama_program }}</h5>
                            <p class="card-text">{{ $program->deskripsi }}</p>
                            <p class="fw-bold">Rp{{ number_format($program->harga, 0, ',', '.') }}</p>
                        </div>

                        <form action="{{ route('pendaftaran.program.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="tipe_program" value="{{ $program->id }}">
                            <button type="submit" class="btn btn-primary w-100 mt-3">Daftar</button>
                        </form>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
