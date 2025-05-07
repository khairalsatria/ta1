@extends('landing.layout.main')
@section('title', 'Pendaftaran Genze Guide')
@section('content')
<div class="container">
    <h2>Pendaftaran Genze Guide</h2>
    {{-- <form action="{{ route('pendaftaran.guide.store', $pendaftaranId) }}" method="POST"> --}}
        @csrf
        <div class="form-group">
            <label>Jenjang Pendidikan</label>
            <input type="text" name="jenjang_pendidikan" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Materi yang Diinginkan</label>
            <textarea name="materi" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label>Pilih Jadwal (maksimal 3)</label>
            @foreach($jadwalPilihan as $jadwal)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="jadwalguide_pilihan[]" value="{{ $jadwal }}">
                <label class="form-check-label">{{ $jadwal }}</label>
            </div>
            @endforeach
        </div>
        <button type="submit" class="btn btn-primary">Daftar</button>
    </form>
</div>
@endsection
