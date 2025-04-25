@extends('admin.layout.main')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Konfirmasi Jadwal untuk {{ $pendaftaran->nama }}</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.pendaftaran.konfirmasi.jadwal.simpan', $pendaftaran->id_pendaftaranclass) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="jadwal_konfirmasi">Pilih Jadwal</label>
                    <select name="jadwal_konfirmasi" class="form-control" required>
                        <option value="">- Pilih Jadwal -</option>
                        @foreach($jadwalDipilih as $jadwal)
                            <option value="{{ $jadwal->id_jadwalkelas }}">
                                {{ $jadwal->hari }} - {{ $jadwal->jam }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Konfirmasi Jadwal</button>
            </form>
        </div>
    </div>
@endsection
