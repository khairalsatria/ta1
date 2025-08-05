@extends('landing.layout.main')

@section('title', 'Tambah Testimonial')

@section('content')

<!-- Header Start -->
<div class="jumbotron jumbotron-fluid page-header position-relative overlay-bottom mb-5">
    <div class="container text-center py-5">
        <h1 class="text-white display-4 fw-bold" style="text-shadow: 2px 2px 10px rgba(0,0,0,0.7);">Tambah Testimonial</h1>
        <div class="d-inline-flex text-white mt-3 fw-semibold">
            <p class="m-0 text-uppercase"><a class="text-white" href="{{ url('/') }}">Home</a></p>
            <i class="fa fa-angle-double-right pt-1 px-3"></i>
            <p class="m-0 text-uppercase text-white">Testimonial</p>
        </div>
    </div>
</div>
<!-- Header End -->

<!-- Form Start -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-10">
            @if(session('success'))
                <div class="alert alert-success text-center fw-semibold shadow-sm rounded-3">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif

            <div class="card border-0 shadow rounded-4">
                <div class="card-body p-4">
                    <h4 class="text-center mb-4 fw-bold text-success">
                        <i class="fas fa-star me-2"></i>Berikan Testimonial Anda
                    </h4>

                    <form action="{{ route('siswa.testimonial.store') }}" method="POST">
                        @csrf

                        {{-- Pilih Program --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Pilih Program</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-book-open"></i></span>
                                <select name="program_id" class="form-control" required>
                                    <option value="">-- Pilih Program --</option>
                                    @foreach($programs as $program)
                                        <option value="{{ $program->id }}">{{ $program->nama_program }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Rating --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Rating (0–5)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-star-half-alt"></i></span>
                                <input type="number" name="rating" class="form-control" min="0" max="5" required>
                            </div>
                        </div>

                        {{-- Komentar --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Komentar</label>
                            <textarea name="komentar" class="form-control" rows="4" required placeholder="Tulis komentar Anda..."></textarea>
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="btn btn-success w-100 rounded-pill fw-bold">
                            <i class="fas fa-paper-plane me-2"></i> Kirim Testimonial
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Form End -->

<!-- Styles -->
<style>
    .form-control:focus {
        border-color: #28a745;
        box-shadow: 0 0 8px rgba(40, 167, 69, 0.25);
    }

    .input-group-text {
        width: 45px;
        justify-content: center;
        border-radius: 0.375rem 0 0 0.375rem;
    }

    .alert-success {
        background-color: #e9f7ec;
        color: #218838;
        border: none;
        padding: 0.75rem 1.25rem;
    }
</style>

@endsection
