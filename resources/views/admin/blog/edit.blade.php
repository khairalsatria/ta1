@extends('admin.layout.main')

@section('title', 'Edit Blog')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-md-6">
                <h3>Edit Blog</h3>
            </div>
            <div class="col-md-6">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.blog.index') }}">Blog</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Form Edit Blog</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.blog.update', $blog->id_blog) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <label for="judul">Judul</label>
                        <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul', $blog->judul) }}">
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="tanggal_posting">Tanggal Posting</label>
                        <input type="date" class="form-control @error('tanggal_posting') is-invalid @enderror" id="tanggal_posting" name="tanggal_posting" value="{{ old('tanggal_posting', $blog->tanggal_posting) }}">
                        @error('tanggal_posting')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="isi">Isi</label>
                        <textarea class="form-control @error('isi') is-invalid @enderror" id="isi" name="isi" rows="5">{{ old('isi', $blog->isi) }}</textarea>
                        @error('isi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="penulis">Penulis</label>
                        <input type="text" class="form-control @error('penulis') is-invalid @enderror" id="penulis" name="penulis" value="{{ old('penulis', $blog->penulis) }}">
                        @error('penulis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="kategori">Kategori</label>
                        <select class="form-control @error('kategori') is-invalid @enderror" id="kategori" name="kategori">
                            @foreach($kategoriBlogs as $kategori)
                                <option value="{{ $kategori->id_kategori_blog }}"
                                    {{ $kategori->id_kategori_blog == old('kategori', $blog->kategori) ? 'selected' : '' }}>
                                    {{ $kategori->kategori_blog }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="gambar">Gambar</label><br>
                        @if ($blog->gambar)
                            <img src="{{ asset('storage/' . $blog->gambar) }}" alt="Gambar Blog" width="200" class="mb-2"><br>
                        @endif
                        <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar" name="gambar">
                        <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar</small>
                        @error('gambar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Update</button>
                    <a href="{{ route('admin.blog.index') }}" class="btn btn-secondary mt-3">Kembali</a>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
