@extends('landing.layout.main')
@section('title', 'Form Pendaftaran GenZE Guide')
@section('content')
<div class="container">
    <h2>Form Pendaftaran GenZE Guide</h2>
    <form action="{{ route('siswa.pendaftaranguide.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="paketguides">Pilih Paket Guide</label>
            <select name="paketguides" class="form-control" id="paketguides" onchange="toggleInput(this.value)">
                @foreach($paket_guides as $paket)
                    <option value="{{ $paket->id_paket_guide }}">{{ $paket->paket_guide }}</option>
                @endforeach
            </select>
        </div>

        <div id="file-upload-group" class="form-group d-none">
            <label for="file_upload">Upload File</label>
            <input type="file" class="form-control" name="file_upload">
        </div>

        <div id="jadwal-pilihan-group" class="form-group d-none">
            <label>Pilih Maksimal 3 Jadwal</label><br>
            @foreach($jadwal_guide2 as $jadwal)
                <label><input type="checkbox" name="jadwalguide2_pilihan[]" value="{{ $jadwal->id_jadwalguide2 }}"> {{ $jadwal->jadwalguide2 }}</label><br>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">Kirim</button>
    </form>
</div>
<script>
    function toggleInput(value) {
        document.getElementById('file-upload-group').classList.add('d-none');
        document.getElementById('jadwal-pilihan-group').classList.add('d-none');

        if (value == 1 || value == 3) {
            document.getElementById('file-upload-group').classList.remove('d-none');
        } else if (value == 2) {
            document.getElementById('jadwal-pilihan-group').classList.remove('d-none');
        }
    }
</script>
@endsection
