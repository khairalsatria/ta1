@extends('admin.layout.main')

@section('title', 'Edit Kelas Genze')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-md-6">
                <h3>Edit Kelas Genze</h3>
            </div>
            <div class="col-md-6">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.kelas.index') }}">Kelas Genze</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Form Edit Kelas Genze</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.kelas.update', $kelas->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <label for="nama_kelas">Nama Kelas</label>
                        <input type="text" class="form-control @error('nama_kelas') is-invalid @enderror" id="nama_kelas" name="nama_kelas" value="{{ old('nama_kelas', $kelas->nama_kelas) }}" required>
                        @error('nama_kelas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="program_id">Program</label>
                        <select name="program_id" id="program_id" class="form-control @error('program_id') is-invalid @enderror" required>
                            @foreach($programs as $p)
                                <option value="{{ $p->id }}" {{ old('program_id', $kelas->program_id) == $p->id ? 'selected' : '' }}>{{ $p->nama_program }}</option>
                            @endforeach
                        </select>
                        @error('program_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="mentor_id">Mentor</label>
                        <select name="mentor_id" id="mentor_id" class="form-control @error('mentor_id') is-invalid @enderror">
                            <option value="">-- Pilih Mentor --</option>
                            @foreach($mentors as $m)
                                <option value="{{ $m->id }}" {{ old('mentor_id', $kelas->mentor_id) == $m->id ? 'selected' : '' }}>{{ $m->name }}</option>
                            @endforeach
                        </select>
                        @error('mentor_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="kuota">Kuota</label>
                        <input type="number" class="form-control @error('kuota') is-invalid @enderror" id="kuota" name="kuota" value="{{ old('kuota', $kelas->kuota) }}" required>
                        @error('kuota')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi">{{ old('deskripsi', $kelas->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="link_zoom_default">Link Zoom Default</label>
                        <input type="url" class="form-control @error('link_zoom_default') is-invalid @enderror" id="link_zoom_default" name="link_zoom_default" value="{{ old('link_zoom_default', $kelas->link_zoom_default) }}">
                        @error('link_zoom_default')
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
