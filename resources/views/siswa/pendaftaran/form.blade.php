@extends('siswa.layout.main')

@section('title', 'Form Pendaftaran')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-md-6">
                <h3>Form Pendaftaran GenZE Class</h3>
            </div>
            <div class="col-md-6">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('siswa.pendaftaran.form') }}">Pendaftaran</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Form Pendaftaran</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Form Pendaftaran</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('siswa.pendaftaran.store') }}" method="POST">
                    @csrf

                    <div class="form-group mb-3">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" placeholder="Nama" class="form-control @error('nama') is-invalid @enderror" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="email" name="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="nohp">No HP</label>
                        <input type="text" name="nohp" placeholder="No HP" class="form-control @error('nohp') is-invalid @enderror" required>
                        @error('nohp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="id_jeniskelas">Jenis Kelas</label>
                        <select name="id_jeniskelas" class="form-select @error('id_jeniskelas') is-invalid @enderror" required>
                            <option value="">-- Pilih Jenis Kelas --</option>
                            @foreach($jenisKelas as $jenis)
                                <option value="{{ $jenis->id_jeniskelas }}">{{ $jenis->jeniskelas }}</option>
                            @endforeach
                        </select>
                        @error('id_jeniskelas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="kelas">Kelas</label>
                        <input type="number" name="kelas" placeholder="Kelas (contoh: 10)" class="form-control @error('kelas') is-invalid @enderror" required>
                        @error('kelas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="jenjang">Jenjang Pendidikan</label>
                        <select name="jenjang_pendidikan" id="jenjang" class="form-select @error('jenjang_pendidikan') is-invalid @enderror" required>
                            <option value="">-- Pilih Jenjang Pendidikan --</option>
                            <option value="1">SD</option>
                            <option value="2">SMP</option>
                            <option value="3">SMA</option>
                        </select>
                        @error('jenjang_pendidikan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="mataPelajaran">Mata Pelajaran</label>
                        <select name="mata_pelajaran" id="mataPelajaran" class="form-select @error('mata_pelajaran') is-invalid @enderror" required>
                            <option value="">-- Pilih Mata Pelajaran --</option>
                        </select>
                        @error('mata_pelajaran')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Pilih Maksimal 3 Jadwal:</label><br>
                        @foreach($jadwalKelas as $jadwal)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="jadwal_pilihan[]" value="{{ $jadwal->id_jadwalkelas }}" id="jadwal-{{ $jadwal->id_jadwalkelas }}">
                                <label class="form-check-label" for="jadwal-{{ $jadwal->id_jadwalkelas }}">{{ $jadwal->jadwalkelas }}</label>
                            </div>
                        @endforeach
                    </div>

                    <input type="hidden" name="harga" value="{{ $hargaPromosi }}">

                    <button type="submit" class="btn btn-primary mt-3">Daftar</button>
                    <a href="{{ route('siswa.pendaftaran.form') }}" class="btn btn-secondary mt-3">Kembali</a>
                </form>
            </div>
        </div>
    </section>
</div>

<script>
    document.getElementById('jenjang').addEventListener('change', function () {
        let jenjangId = this.value;
        fetch(`/mata-pelajaran/by-jenjang/${jenjangId}`)
            .then(res => res.json())
            .then(data => {
                let mataPelajaranSelect = document.getElementById('mataPelajaran');
                mataPelajaranSelect.innerHTML = '<option value="">-- Pilih Mata Pelajaran --</option>';
                data.forEach(mp => {
                    mataPelajaranSelect.innerHTML += `<option value="${mp.id_mata_pelajaran}">${mp.mata_pelajaran}</option>`;
                });
            })
            .catch(error => console.error('Error fetching mata pelajaran:', error));
    });
</script>
@endsection
