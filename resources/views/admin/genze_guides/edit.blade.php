@extends('admin.layout.main')

@section('title', 'Edit Genze Guide')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-md-6">
                <h3>Edit Genze Guide</h3>
            </div>
            <div class="col-md-6">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.genze_guides.index') }}">Genze Guide</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Form Edit Genze Guide</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.genze_guides.update', $guide->id_guide) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <label for="paket_guide">Paket Guide</label>
                        <select name="paket_guide" class="form-control" id="paket_guide" required>
                            @foreach($pakets as $paket)
                                <option value="{{ $paket->id_paket_guide }}" {{ $paket->id_paket_guide == $guide->paket_guide ? 'selected' : '' }}>{{ $paket->paket_guide }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3" id="jadwal_guide_wrapper">
                        <label for="jadwal_guide2">Jadwal Guide</label>
                        <select name="jadwal_guide2" id="jadwal_guide2" class="form-control">
                            <option value="">-- Pilih Jadwal --</option>
                            @foreach($jadwals as $jadwal)
                                <option value="{{ $jadwal->id_jadwalguide2 }}" {{ $jadwal->id_jadwalguide2 == $guide->jadwal_guide2 ? 'selected' : '' }}>{{ $jadwal->jadwalguide2 }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="file">File (biarkan kosong jika tidak ingin mengubah)</label>
                        <input type="file" name="file" id="file" class="form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label for="harga">Harga</label>
                        <input type="number" name="harga" id="harga" class="form-control" value="{{ old('harga', $guide->harga) }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="keterangan">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" class="form-control">{{ old('keterangan', $guide->keterangan) }}</textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="link_zoom">Link Zoom</label>
                        <input type="text" name="link_zoom" id="link_zoom" class="form-control" value="{{ old('link_zoom', $guide->link_zoom) }}">
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Update</button>
                    <a href="{{ route('admin.genze_guides.index') }}" class="btn btn-secondary mt-3">Kembali</a>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script>
    function toggleJadwalGuide() {
        const paketSelect = document.getElementById('paket_guide');
        const jadwalWrapper = document.getElementById('jadwal_guide_wrapper');
        const jadwalSelect = document.getElementById('jadwal_guide2');

        if (paketSelect.value == 2) {
            jadwalWrapper.style.display = 'block';
        } else {
            jadwalWrapper.style.display = 'none';
            jadwalSelect.value = '';
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        toggleJadwalGuide(); // initial call
        document.getElementById('paket_guide').addEventListener('change', toggleJadwalGuide);
    });
</script>
@endsection
