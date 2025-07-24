@extends('mentor.layout.main')

@section('title', 'Tambah Materi')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-md-6">
                <h3>Tambah Materi</h3>
            </div>
            <div class="col-md-6">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('mentor.materi.index') }}">Materi</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Form Tambah Materi</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('mentor.materi.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
<div class="form-group mb-3">
    <label for="kelas_id">Kelas</label>
    <select name="kelas_id" id="kelas_id" class="form-control @error('kelas_id') is-invalid @enderror" required>
        @foreach($semua_kelas as $k)
            <option value="{{ $k->id }}"
                {{ (old('kelas_id', $kelas_id ?? '') == $k->id) ? 'selected' : '' }}>
                {{ $k->nama_kelas }}
            </option>
        @endforeach
    </select>
    @error('kelas_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>


                    <div class="form-group mb-3">
                        <label for="tanggal_pertemuan">Tanggal Pertemuan</label>
                        <input type="date" id="tanggal_pertemuan" name="tanggal_pertemuan" class="form-control @error('tanggal_pertemuan') is-invalid @enderror" value="{{ old('tanggal_pertemuan') }}">
                        @error('tanggal_pertemuan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="pertemuan_ke">Pertemuan Ke</label>
                        <input type="number" id="pertemuan_ke" name="pertemuan_ke" class="form-control @error('pertemuan_ke') is-invalid @enderror" value="{{ old('pertemuan_ke') }}">
                        @error('pertemuan_ke')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="judul">Judul Materi</label>
                        <input type="text" id="judul" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul') }}">
                        @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="file_pdf">File PDF (opsional)</label>
                        <input type="file" id="file_pdf" name="file_pdf" class="form-control @error('file_pdf') is-invalid @enderror">
                        @error('file_pdf')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="link_zoom">Link Zoom (opsional)</label>
                        <input type="url" id="link_zoom" name="link_zoom" class="form-control @error('link_zoom') is-invalid @enderror" value="{{ old('link_zoom') }}">
                        @error('link_zoom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="link_rekaman">Link Rekaman (opsional)</label>
                        <input type="url" id="link_rekaman" name="link_rekaman" class="form-control @error('link_rekaman') is-invalid @enderror" value="{{ old('link_rekaman') }}">
                        @error('link_rekaman')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
