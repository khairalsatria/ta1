@extends('landing.layout.main')

@section('title', $blog->judul)

@section('content')
<!-- Header Start -->
<div class="jumbotron jumbotron-fluid page-header position-relative overlay-bottom mb-5">
    <div class="container text-center py-5">
        <h1 class="text-white display-4 fw-bold" style="text-shadow: 2px 2px 10px rgba(0,0,0,0.7);">Detail Artikel</h1>
        <div class="d-inline-flex text-white mt-3 fw-semibold">
            <p class="m-0 text-uppercase"><a class="text-white" href="{{ url('/') }}">Home</a></p>
            <i class="fa fa-angle-double-right pt-1 px-3"></i>
            <p class="m-0 text-uppercase text-white">Blog Detail</p>
        </div>
    </div>
</div>
<!-- Header End -->

<!-- Blog Detail Start -->
<div class="container py-5">
    <div class="row">
        <div class="col-lg-9 mx-auto">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    <!-- Tombol kembali di kanan atas -->
                    <div class="d-flex justify-content-end mb-3">
                        <a href="{{ route('landing.page.blog') }}" class="btn btn-sm btn-outline-secondary rounded-pill shadow-sm">
                            <i class="fa fa-arrow-left me-1"></i> Kembali ke Blog
                        </a>
                    </div>

                    <h2 class="fw-bold mb-3 text-dark">{{ $blog->judul }}</h2>
                    <div class="mb-3 text-muted small">
                        <i class="fa fa-calendar-alt me-1 text-success"></i> {{ \Carbon\Carbon::parse($blog->tanggal_posting)->translatedFormat('d F Y') }} |
                        <i class="fa fa-user me-1 text-success"></i> {{ $blog->user->name }} |
                        <i class="fa fa-folder me-1 text-success"></i> {{ $blog->kategoriBlog->kategori_blog ?? 'Uncategorized' }}
                    </div>

                    <img src="{{ asset('storage/' . $blog->gambar) }}"
                        class="img-fluid rounded-3 shadow-sm mb-4 w-100"
                        style="max-height: 450px; object-fit: cover;"
                        alt="{{ $blog->judul }}">

                    <div class="blog-content text-dark fs-6 lh-lg">
                        {!! $blog->isi !!}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Blog Detail End -->

<style>
.blog-content p {
    margin-bottom: 1.2rem;
    text-align: justify;
}

.blog-content h2, .blog-content h3 {
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.blog-content img {
    max-width: 100%;
    height: auto;
    margin: 20px 0;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}
</style>
@endsection
