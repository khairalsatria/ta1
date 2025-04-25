@extends('admin.layout.main')

@section('title', 'Edit Genze Learn')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-md-6">
                <h3>Edit Program Genze Learn</h3>
            </div>
            <div class="col-md-6">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.genze_learn.index') }}">Genze Learn</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Form Edit Program Genze Learn</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.genze_learn.update', $genzeLearn->id_learn) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <label for="nama_learn">Nama Learn</label>
                        <input type="text" class="form-control @error('nama_learn') is-invalid @enderror" id="nama_learn" name="nama_learn" value="{{ old('nama_learn', $genzeLearn->nama_learn) }}">
                        @error('nama_learn')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="pembicara">Pembicara</label>
                        <input type="text" class="form-control @error('pembicara') is-invalid @enderror" id="pembicara" name="pembicara" value="{{ old('pembicara', $genzeLearn->pembicara) }}">
                        @error('pembicara')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="jadwal">Jadwal</label>
                        <input type="datetime-local" class="form-control @error('jadwal') is-invalid @enderror" id="jadwal" name="jadwal" value="{{ old('jadwal', \Carbon\Carbon::parse($genzeLearn->jadwal)->format('Y-m-d\TH:i')) }}">
                        @error('jadwal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="harga">Harga</label>
                        <input type="number" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" value="{{ old('harga', $genzeLearn->harga) }}">
                        @error('harga')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="4">{{ old('keterangan', $genzeLearn->keterangan) }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="link_zoom">Link Zoom</label>
                        <input type="text" class="form-control @error('link_zoom') is-invalid @enderror" id="link_zoom" name="link_zoom" value="{{ old('link_zoom', $genzeLearn->link_zoom) }}">
                        @error('link_zoom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="sertifikat">Sertifikat</label>
                        <input type="text" class="form-control @error('sertifikat') is-invalid @enderror" id="sertifikat" name="sertifikat" value="{{ old('sertifikat', $genzeLearn->sertifikat) }}">
                        @error('sertifikat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Update</button>
                    <a href="{{ route('admin.genze_learn.index') }}" class="btn btn-secondary mt-3">Kembali</a>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
