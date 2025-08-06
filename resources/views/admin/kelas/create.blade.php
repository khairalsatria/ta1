@extends('admin.layout.main')

@section('title', 'Tambah Kelas Genze')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-md-6">
                <h3>Tambah Kelas Genze</h3>
            </div>
            <div class="col-md-6">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.kelas.index') }}">Kelas Genze</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Form Tambah Kelas Genze</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.kelas.store') }}" method="POST">
                    @csrf

                    <div class="form-group mb-3">
                        <label for="nama_kelas">Nama Kelas</label>
                        <input type="text" id="nama_kelas" name="nama_kelas" class="form-control @error('nama_kelas') is-invalid @enderror" value="{{ old('nama_kelas') }}" required>
                        @error('nama_kelas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="program_id">Program</label>
                        <select name="program_id" id="program_id" class="form-control @error('program_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Program --</option>
                            @foreach($programs as $p)
                                <option value="{{ $p->id }}" {{ old('program_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_program }}</option>
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
                                <option value="{{ $m->id }}" {{ old('mentor_id') == $m->id ? 'selected' : '' }}>{{ $m->name }}</option>
                            @endforeach
                        </select>
                        @error('mentor_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
    <label for="jadwal_kelas_id">Jadwal Kelas</label>
    <select name="jadwal_kelas_id" id="jadwal_kelas_id" class="form-control @error('jadwal_kelas_id') is-invalid @enderror" required>
        <option value="">-- Pilih Jadwal --</option>
        @foreach($jadwal_kelas as $j)
            <option value="{{ $j->id_jadwalkelas }}" {{ old('jadwal_kelas_id') == $j->id_jadwalkelas ? 'selected' : '' }}>
                {{ $j->jadwalkelas }}
            </option>
        @endforeach
    </select>
    @error('jadwal_kelas_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


                    <div class="form-group mb-3">
                        <label for="kuota">Kuota</label>
                        <input type="number" id="kuota" name="kuota" class="form-control @error('kuota') is-invalid @enderror" value="{{ old('kuota') }}" required>
                        @error('kuota')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea id="deskripsi" name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="link_zoom_default">Link Zoom Default</label>
                        <input type="url" id="link_zoom_default" name="link_zoom_default" class="form-control @error('link_zoom_default') is-invalid @enderror" value="{{ old('link_zoom_default') }}">
                        @error('link_zoom_default')
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
