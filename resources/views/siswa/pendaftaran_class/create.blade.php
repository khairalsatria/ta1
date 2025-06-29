@extends('landing.layout.main')
@section('title', 'Form Pendaftaran GenZE Class')
@section('content')
<div class="container">
    <h2>Form Pendaftaran GenZE Class</h2>
    <form action="{{ route('siswa.pendaftaranclass.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="jeniskelas">Jenis Kelas</label>
            <select name="jeniskelas" id="jeniskelas" class="form-control">
                @foreach($jenis_kelas as $jenis)
                    <option value="{{ $jenis->id_jeniskelas }}">{{ $jenis->jeniskelas }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
    <label for="kelas">Nama Kelas</label>
    <input type="text" name="kelas" id="kelas" class="form-control" required value="{{ old('kelas') }}">
</div>


        <div class="form-group">
            <label for="jenjang_pendidikan">Jenjang Pendidikan</label>
            <select name="jenjang_pendidikan" class="form-control" id="jenjang_pendidikan">
                @foreach($jenjang_pendidikans as $jenjang)
                    <option value="{{ $jenjang->id_jenjang_pendidikan }}">{{ $jenjang->jenjang_pendidikan }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="mata_pelajaran">Mata Pelajaran</label>
            <select name="mata_pelajaran" class="form-control" id="mata_pelajaran">
                @foreach($mata_pelajarans as $mapel)
                    <option value="{{ $mapel->id_mata_pelajaran }}">{{ $mapel->mata_pelajaran }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Pilih Maksimal 3 Jadwal</label><br>
            @foreach($jadwal_kelas as $jadwal)
                <label><input type="checkbox" name="jadwalkelas_pilihan[]" value="{{ $jadwal->id_jadwalkelas }}"> {{ $jadwal->jadwalkelas }}</label><br>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">Kirim</button>
    </form>
</div>
@endsection
