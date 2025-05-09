<!-- resources/views/landing/page/detail-program-guide.blade.php -->
@extends('landing.layout.main')

@section('content')
    {{-- <h1>Pendaftaran Program Guide: {{ $program->nama }}</h1> --}}

    <form action="{{ route('pendaftaran-guide.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="tipe_program">Pilih Program:</label>
            <select name="tipe_program" id="tipe_program" required>
                @foreach ($programs as $program)
                    <option value="{{ $program->id }}">{{ $program->nama_program }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="paket_guide">Pilih Paket Guide:</label>
            <select name="paket_guide" id="paket_guide" required>
                <option value="1">Paket 1 (Upload File)</option>
                <option value="2">Paket 2 (Pilih Jadwal)</option>
                <option value="3">Paket 3 (Upload File)</option>
            </select>
        </div>

        <div id="file-upload" style="display:none;">
            <label for="file_upload">Upload File (PDF, DOC, JPG):</label>
            <input type="file" name="file_upload" id="file_upload" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
        </div>

        <div id="jadwal-pilihan" style="display:none;">
            <label for="jadwalguide2_pilihan">Pilih Jadwal:</label>
            <select name="jadwalguide2_pilihan[]" id="jadwalguide2_pilihan" multiple>
                @foreach ($jadwalGuide2 as $jadwal)
                    <option value="{{ $jadwal->id }}">{{ $jadwal->nama_jadwal }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit">Daftar</button>
    </form>

    <script>
        // Menampilkan form upload file atau jadwal berdasarkan pilihan paket
        document.getElementById('paket_guide').addEventListener('change', function() {
            var fileUpload = document.getElementById('file-upload');
            var jadwalPilihan = document.getElementById('jadwal-pilihan');

            if (this.value == '1' || this.value == '3') {
                fileUpload.style.display = 'block';
                jadwalPilihan.style.display = 'none';
            } else if (this.value == '2') {
                fileUpload.style.display = 'none';
                jadwalPilihan.style.display = 'block';
            }
        });
    </script>


@endsection
