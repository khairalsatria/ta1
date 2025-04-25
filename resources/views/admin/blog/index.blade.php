@extends('admin.layout.main')

@section('title', 'Daftar Blog')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Blog</h3>
                <p class="text-subtitle text-muted">Daftar blog yang tersedia</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Blog</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Data Blog</h5>
                <a href="{{ route('admin.blog.create') }}" class="btn btn-primary btn-sm">+ Tambah Blog</a>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Tanggal</th>
                            <th>Penulis</th>
                            <th>Kategori</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($blogs as $blog)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $blog->judul }}</td>
                            <td>{{ \Carbon\Carbon::parse($blog->tanggal_posting)->translatedFormat('d M Y') }}</td>
                            <td>{{ $blog->penulis }}</td>
                            <td>{{ $blog->kategoriBlog->kategori_blog ?? '-' }}</td>
                            <td>
                                @if($blog->gambar)
                                    <img src="{{ asset('storage/' . $blog->gambar) }}" alt="Gambar" width="100">
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.blog.edit', $blog->id_blog) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.blog.destroy', $blog->id_blog) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
@endsection
