@extends('admin.layout.main')

@section('title', 'Tambah Kategori Blog')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-md-6">
                <h3>Tambah Kategori Blog</h3>
            </div>
            <div class="col-md-6">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        {{-- <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li> --}}
                        <li class="breadcrumb-item"><a href="{{ route('admin.kategori_blog.index') }}">Kategori Blog</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Form Tambah Kategori Blog</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.kategori_blog.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="kategori_blog">Kategori Blog</label>
                        <input type="text" class="form-control @error('kategori_blog') is-invalid @enderror" id="kategori_blog" name="kategori_blog" value="{{ old('kategori_blog') }}">
                        @error('kategori_blog')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
