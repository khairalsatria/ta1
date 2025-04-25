@extends('admin.layout.main')

@section('title', 'Edit Jenis Kelas')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-md-6">
                <h3>Edit Jenis Kelas</h3>
            </div>
            <div class="col-md-6">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        {{-- <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li> --}}
                        <li class="breadcrumb-item"><a href="{{ route('admin.jenis_kelas.index') }}">Jenis Kelas</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Form Edit Jenis Kelas</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.jenis_kelas.update', $jenis_kelas->id_jeniskelas) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="jeniskelas">Jenis Kelas</label>
                        <input type="text" class="form-control @error('jeniskelas') is-invalid @enderror" id="jeniskelas" name="jeniskelas" value="{{ old('jeniskelas', $jenis_kelas->jeniskelas) }}">
                        @error('jeniskelas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Update</button>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
