    @extends('landing.layout.main')

    @section('title', 'Form Pendaftaran GenZE Class')

    @section('content')
    <div class="page-heading">
        <h3>Pendaftaran GenZE Class</h3>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">Form Pendaftaran</div>
            <div class="card-body">
                <form action="{{ route('siswa.pendaftaran.genze-class.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="pendaftaran_id" value="{{ request()->get('pendaftaran_id') ?? $pendaftaran_id ?? '' }}">
                    <input type="hidden" name="tipe_program" value="{{ $program->id }}">


                    <div class="form-group mb-3">
                        <label for="id_jeniskelas">Jenis Kelas</label>
                        <select name="id_jeniskelas" class="form-select" required>
                            <option value="">-- Pilih Jenis Kelas --</option>
                            @foreach($jenisKelas as $jenis)
                                <option value="{{ $jenis->id_jeniskelas }}">{{ $jenis->jeniskelas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="kelas">Kelas</label>
                        <input type="number" name="kelas" class="form-control" placeholder="Contoh: 10" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="id_jenjang_pendidikan">Jenjang Pendidikan</label>
                        <select name="id_jenjang_pendidikan" id="jenjang" class="form-select" required>
                            <option value="">-- Pilih Jenjang --</option>
                            @foreach($jenjangPendidikans as $jenjang)
                                <option value="{{ $jenjang->id_jenjang_pendidikan }}">{{ $jenjang->jenjang_pendidikan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="id_mata_pelajaran">Mata Pelajaran</label>
                        <select name="id_mata_pelajaran" id="mataPelajaran" class="form-select" required>
                            <option value="">-- Pilih Mata Pelajaran --</option>
                        </select>
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

                    {{-- <input type="hidden" name="harga" value="{{ $hargaPromosi }}"> --}}

                    <button type="submit" class="btn btn-primary">Daftar Sekarang</button>
                </form>
            </div>
        </div>
    </section>

    <script>
        document.getElementById('jenjang').addEventListener('change', function () {
            let jenjangId = this.value;
            fetch('/mata-pelajaran/by-jenjang/' + jenjangId)
                .then(response => response.json())
                .then(data => {
                    let mataPelajaran = document.getElementById('mataPelajaran');
                    mataPelajaran.innerHTML = '<option value="">-- Pilih Mata Pelajaran --</option>';
                    data.forEach(function (item) {
                        mataPelajaran.innerHTML += `<option value="${item.id_mata_pelajaran}">${item.mata_pelajaran}</option>`;
                    });
                });
        });
    </script>
    @endsection
