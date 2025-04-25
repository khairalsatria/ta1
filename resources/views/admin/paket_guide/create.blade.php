@extends('admin.layout.main')

@section('title', 'Tambah Paket Guide')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-md-6">
                <h3>Tambah Paket Guide</h3>
            </div>
            <div class="col-md-6">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        {{-- <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li> --}}
                        <li class="breadcrumb-item"><a href="{{ route('admin.paket_guide.index') }}">Paket Guide</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Form Tambah Paket Guide</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.paket_guide.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="paket_guide">Paket Guide</label>
                        <input type="text" class="form-control @error('paket_guide') is-invalid @enderror" id="paket_guide" name="paket_guide" value="{{ old('paket_guide') }}">
                        @error('paket_guide')
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
