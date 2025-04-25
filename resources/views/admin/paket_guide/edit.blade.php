@extends('admin.layout.main')

@section('title', 'Edit Paket Guide')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-md-6">
                <h3>Edit Paket Guide</h3>
            </div>
            <div class="col-md-6">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        {{-- <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li> --}}
                        <li class="breadcrumb-item"><a href="{{ route('admin.paket_guide.index') }}">Paket Guide</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Form Edit Paket Guide</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.paket_guide.update', $paket_guide->id_paket_guide) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="paket_guide">Paket Guide</label>
                        <input type="text" class="form-control @error('paket_guide') is-invalid @enderror" id="paket_guide" name="paket_guide" value="{{ old('paket_guide', $paket_guide->paket_guide) }}">
                        @error('paket_guide')
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
