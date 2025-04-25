@extends('admin.layout.main')

@section('title', 'Edit Promosi Class')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-md-6">
                <h3>Edit Promosi Class</h3>
            </div>
            <div class="col-md-6">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.promosi_class.index') }}">Promosi Class</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Form Edit Promosi Class</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.promosi_class.update', $promosi_class->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="nama_program">Nama Program</label>
                        <input type="text" class="form-control" id="nama_program" name="nama_program" value="{{ $promosi_class->nama_program }}" required>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" required>{{ $promosi_class->deskripsi }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="benefit">Benefit</label>
                        <input type="text" class="form-control" id="benefit" name="benefit" value="{{ $promosi_class->benefit }}" required>
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="number" class="form-control" id="harga" name="harga" value="{{ $promosi_class->harga }}" required>
                    </div>
                    <div class="form-group">
                        <label for="gambar">Gambar</label>
                        <input type="file" class="form-control" id="gambar" name="gambar">
                        @if($promosi_class->gambar)
                            <img src="{{ asset('images/promosi/' . $promosi_class->gambar) }}" alt="{{ $promosi_class->nama_program }}" width="100" class="mt-2">
                        @endif
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('admin.promosi_class.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
