@extends('landing.layout.main')

@section('title', 'Blog & Artikel GenZE')

@section('content')
<!-- Header Start -->
<div class="jumbotron jumbotron-fluid page-header position-relative overlay-bottom mb-5">
    <div class="container text-center py-5">
        <h1 class="text-white display-4 fw-bold" style="text-shadow: 2px 2px 10px rgba(0,0,0,0.7);">Blog & Artikel</h1>
        <div class="d-inline-flex text-white mt-3 fw-semibold">
            <p class="m-0 text-uppercase"><a class="text-white" href="{{ url('/') }}">Home</a></p>
            <i class="fa fa-angle-double-right pt-1 px-3"></i>
            <p class="m-0 text-uppercase text-white">Blog</p>
        </div>
    </div>
</div>
<!-- Header End -->

<!-- Blog List Start -->
<div class="container py-5">
    <div class="text-center mb-5">
        <h6 class="text-success text-uppercase fw-semibold mb-2">Blog</h6>
        <h1 class="display-5 fw-bold text-dark">Artikel dan Informasi Terbaru</h1>
        <p class="text-muted mx-auto" style="max-width: 600px;">Temukan wawasan terbaru seputar dunia pendidikan, pengembangan diri, dan kegiatan GenZE.</p>
    </div>

    <div class="row">
        @foreach($blogs as $blog)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card blog-card border-0 shadow-sm h-100 rounded-3 overflow-hidden">
                <a href="{{ route('landing.page.detail-blog', $blog->id_blog) }}" style="text-decoration: none; color: inherit;">
                    <div class="blog-img-wrapper position-relative">
                        <img class="img-fluid w-100 h-100 object-fit-cover" src="{{ asset('storage/' . $blog->gambar) }}" alt="{{ $blog->judul }}">
                        <span class="badge-type position-absolute top-0 start-0 m-3 px-3 py-2 text-white rounded-pill">
                            {{ $blog->kategoriBlog->kategori_blog ?? 'Umum' }}
                        </span>
                    </div>
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold text-dark mb-2">{{ \Illuminate\Support\Str::limit($blog->judul, 60) }}</h5>
                        <div class="text-muted small mb-2">
                            <i class="fa fa-calendar-alt me-1 text-success"></i>
                            {{ \Carbon\Carbon::parse($blog->tanggal_posting)->translatedFormat('d F Y') }}
                        </div>
                        <p class="text-muted small">{{ \Illuminate\Support\Str::limit(strip_tags($blog->isi), 100) }}</p>
                    </div>
                </a>
            </div>
        </div>
        @endforeach
    </div>

    <div class="col-12 text-center mt-4">
        {{ $blogs->links('pagination::bootstrap-5') }}
    </div>
</div>
<!-- Blog List End -->

<style>
.blog-card {
    transition: all 0.3s ease;
    background-color: #ffffff;
}

.blog-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1);
}

.blog-img-wrapper {
    height: 220px;
    overflow: hidden;
    position: relative;
}

.blog-img-wrapper img {
    transition: transform 0.4s ease;
    object-fit: cover;
}

.blog-img-wrapper:hover img {
    transform: scale(1.07);
}

.badge-type {
    background: #28a745;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}
</style>
@endsection
