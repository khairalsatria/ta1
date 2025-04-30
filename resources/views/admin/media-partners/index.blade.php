@extends('admin.layout.main')

@section('title', 'Daftar Media Partner')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Media Partner</h3>
                <p class="text-subtitle text-muted">Daftar media partner yang tersedia</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Media Partner</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Data Media Partner</h5>
                <a href="{{ route('admin.media-partners.create') }}" class="btn btn-primary btn-sm">+ Tambah Media Partner</a>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Logo</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($partners as $partner)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $partner->nama }}</td>
                            <td>
                                <img src="{{ asset('storage/' . $partner->logo) }}" alt="Logo" height="40">
                            </td>
                            <td>
                                <a href="{{ route('admin.media-partners.edit', $partner->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.media-partners.destroy', $partner->id) }}" method="POST" style="display:inline;">
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
