@extends('admin.layout.main')

@section('title', 'Tambah Genze Guide')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-md-6">
                <h3>Tambah Genze Guide</h3>
            </div>
            <div class="col-md-6">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.genze_guides.index') }}">Genze Guide</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Form Tambah Genze Guide</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.genze_guides.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group mb-3">
                        <label for="paket_guide">Paket Guide</label>
                        <select name="paket_guide" class="form-control @error('paket_guide') is-invalid @enderror" required>
                            @foreach($pakets as $paket)
                                <option value="{{ $paket->id_paket_guide }}">{{ $paket->paket_guide }}</option>
                            @endforeach
                        </select>
                        @error('paket_guide')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3" id="jadwal_guide_wrapper">
                        <label for="jadwal_guide2">Jadwal Guide</label>
                        <select name="jadwal_guide2" class="form-control @error('jadwal_guide2') is-invalid @enderror">
                            <option value="">-- Pilih Jadwal --</option>
                            @foreach($jadwals as $jadwal)
                                <option value="{{ $jadwal->id_jadwalguide2 }}">{{ $jadwal->jadwalguide2 }}</option>
                            @endforeach
                        </select>
                        @error('jadwal_guide2')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="file">File</label>
                        <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" required>
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="harga">Harga</label>
                        <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror" value="{{ old('harga') }}" required>
                        @error('harga')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="keterangan">Keterangan</label>
                        <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="link_zoom">Link Zoom</label>
                        <input type="text" name="link_zoom" class="form-control @error('link_zoom') is-invalid @enderror" value="{{ old('link_zoom') }}">
                        @error('link_zoom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                    <a href="{{ route('admin.genze_guides.index') }}" class="btn btn-secondary mt-3">Kembali</a>
                </form>
            </div>
        </div>
    </section>
</div>

@
<script>
    function toggleFormFields() {
        const paketSelect = document.querySelector('select[name="paket_guide"]');
        const selectedValue = parseInt(paketSelect.value);

        const jadwalWrapper = document.getElementById('jadwal_guide_wrapper');
        const jadwalSelect = document.querySelector('select[name="jadwal_guide2"]');
        const fileInput = document.querySelector('input[name="file"]');
        const linkZoomInput = document.querySelector('input[name="link_zoom"]');

        if (selectedValue === 2) {
            // Paket guide 2:
            // - Jadwal aktif & tampil
            // - File TIDAK bisa diisi
            // - Link Zoom BISA diisi
            jadwalWrapper.style.display = 'block';
            jadwalSelect.disabled = false;

            fileInput.disabled = true;
            fileInput.value = null;

            linkZoomInput.disabled = false;
        } else {
            // Paket guide 1 & 3:
            // - Jadwal disembunyikan
            // - File BISA diisi
            // - Link Zoom TIDAK bisa diisi
            jadwalWrapper.style.display = 'none';
            jadwalSelect.value = '';
            jadwalSelect.disabled = true;

            fileInput.disabled = false;

            linkZoomInput.disabled = true;
            linkZoomInput.value = '';
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        toggleFormFields();
        document.querySelector('select[name="paket_guide"]').addEventListener('change', toggleFormFields);
    });
</script>
@endsection

