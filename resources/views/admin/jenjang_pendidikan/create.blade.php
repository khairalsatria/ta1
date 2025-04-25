@extends('admin.layout.main')

@section('title', 'Tambah Jenjang Pendidikan')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-md-6">
                <h3>Tambah Jenjang Pendidikan</h3>
            </div>
            <div class="col-md-6">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        {{-- <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li> --}}
                        <li class="breadcrumb-item"><a href="{{ route('admin.jenjang_pendidikan.index') }}">Jenjang Pendidikan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Form Tambah Jenjang Pendidikan</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.jenjang_pendidikan.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="jenjang_pendidikan">Jenjang Pendidikan</label>
                        <input type="text" class="form-control @error('jenjang_pendidikan') is-invalid @enderror" id="jenjang_pendidikan" name="jenjang_pendidikan" value="{{ old('jenjang_pendidikan') }}">
                        @error('jenjang_pendidikan')
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
