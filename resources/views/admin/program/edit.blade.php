@extends('admin.layout.main')

@section('title', 'Edit Program')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-md-6">
                <h3>Edit Program</h3>
            </div>
            <div class="col-md-6">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.program.index') }}">Program</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Form Edit Program</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.program.update', $program->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')


                    <div class="form-group mb-3">
                        <label for="tipe_program">Tipe Program</label>
                        <select class="form-control @error('tipe_program') is-invalid @enderror" id="tipe_program" name="tipe_program">
                            <option value="GenZE Class" {{ old('tipe_program', $program->tipe_program) == 'GenZE Class' ? 'selected' : '' }}>GenZE Class</option>
                            <option value="GenZE Guide" {{ old('tipe_program', $program->tipe_program) == 'GenZE Guide' ? 'selected' : '' }}>GenZE Guide</option>
                            <option value="GenZE Learn" {{ old('tipe_program', $program->tipe_program) == 'GenZE Learn' ? 'selected' : '' }}>GenZE Learn</option>
                        </select>
                        @error('tipe_program')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="nama_program">Nama Program</label>
                        <input type="text" class="form-control @error('nama_program') is-invalid @enderror" id="nama_program" name="nama_program" value="{{ old('nama_program', $program->nama_program) }}">
                        @error('nama_program')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi', $program->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="fitur">Fitur</label>
                        <textarea class="form-control @error('fitur') is-invalid @enderror" id="fitur" name="fitur" rows="3">{{ old('fitur', $program->fitur) }}</textarea>
                        @error('fitur')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="rating">Rating</label>
                        <input type="number" step="0.1" class="form-control @error('rating') is-invalid @enderror" id="rating" name="rating" value="{{ old('rating', $program->rating) }}">
                        @error('rating')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="instruktur">Instruktur</label>
                        <input type="text" class="form-control @error('instruktur') is-invalid @enderror" id="instruktur" name="instruktur" value="{{ old('instruktur', $program->instruktur) }}">
                        @error('instruktur')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="durasi">Durasi</label>
                        <input type="text" class="form-control @error('durasi') is-invalid @enderror" id="durasi" name="durasi" value="{{ old('durasi', $program->durasi) }}">
                        @error('durasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="level">Level</label>
                        <input type="text" class="form-control @error('level') is-invalid @enderror" id="level" name="level" value="{{ old('level', $program->level) }}">
                        @error('level')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="harga">Harga</label>
                        <input type="number" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" value="{{ old('harga', $program->harga) }}">
                        @error('harga')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="form-group mb-3">
                        <label for="gambar">Gambar</label><br>
                        @if ($program->gambar)
                            <img src="{{ asset('storage/' . $program->gambar) }}" alt="Gambar Program" width="200" class="mb-2"><br>
                        @endif
                        <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar" name="gambar">
                        <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar</small>
                        @error('gambar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Update</button>
                    <a href="{{ route('admin.program.index') }}" class="btn btn-secondary mt-3">Kembali</a>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
