@extends('admin.layout.main')

@section('title', 'Detail & Konfirmasi Pendaftaran GenZE Class')

@section('content')
<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border rounded-4">
                <div class="card-header bg-primary text-white rounded-top-4 mb-4">
                    <h4 class="card-title m-0">
                        <i class="bi bi-person-lines-fill me-2"></i> Detail Pendaftaran GenZE Class
                    </h4>
                </div>

                <div class="card-body">
                    <!-- DATA PESERTA -->
                    <div class="mb-4">
                        <h5 class="text-primary"><i class="bi bi-person-circle me-2"></i>Data Peserta</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <tr>
                                    <th width="30%">Nama</th>
                                    <td>{{ $pendaftaranClass->pendaftaran->user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $pendaftaranClass->pendaftaran->user->email }}</td>
                                </tr>
                                <tr>
                                    <th>No HP</th>
                                    <td>{{ $pendaftaranClass->pendaftaran->user->nohp ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- DATA PENDAFTARAN -->
                    <div class="mb-4">
                        <h5 class="text-success"><i class="bi bi-book-half me-2"></i>Data Pendaftaran</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <tr>
                                    <th width="30%">Jenis Kelas</th>
                                    <td>{{ $pendaftaranClass->jenisKelas->jeniskelas ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Jenjang Pendidikan</th>
                                    <td>{{ $pendaftaranClass->jenjangPendidikan->jenjang_pendidikan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Kelas</th>
                                    <td>{{ $pendaftaranClass->kelas ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Mata Pelajaran</th>
                                    <td>{{ $pendaftaranClass->mataPelajaran->mata_pelajaran ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Jadwal Pilihan</th>
                                    <td>
                                        <ul class="mb-0">
                                            @foreach($jadwalPilihan as $jadwal)
                                                <li>{{ $jadwal->jadwalkelas }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Jadwal Dikonfirmasi</th>
                                    <td>
                                        @if($pendaftaranClass->jadwalKonfirmasi)
                                            <span class="badge bg-success">{{ $pendaftaranClass->jadwalKonfirmasi->jadwalkelas }}</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Belum dikonfirmasi</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Grup Mapel</th>
                                    <td>
                                        @if($pendaftaranClass->kelasGenze)
                                            <span class="badge bg-primary">{{ $pendaftaranClass->kelasGenze->nama_kelas }}</span>
                                        @else
                                            <span class="badge bg-secondary">Belum ditetapkan</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="text-end">
                        <a href="{{ route('admin.pendaftaran.classes.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                        </a>
                    </div>

                </div> <!-- /.card-body -->
            </div> <!-- /.card -->
        </div>
    </div>
</section>
@endsection
