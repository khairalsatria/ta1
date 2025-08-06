    @extends('admin.layout.main')

    @section('title', 'Daftar Genze Class')

    @section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Genze Class</h3>
                    <p class="text-subtitle text-muted">Daftar pendaftar program Genze Class</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">Genze Class</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Data Pendaftaran Genze Class</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Mapel</th>
                                {{-- <th>Grup Kelas</th> --}}
                                <th>Jadwal Konfirmasi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendaftaranClasses as $class)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $class->pendaftaran->user->name }}</td>
                                <td>{{ $class->kelas }}</td>
                                <td>{{ $class->mataPelajaran->mata_pelajaran ?? '-' }}</td>
                                {{-- <td>{{ $class->kelasGenze->nama_kelas ?? '-' }}</td> --}}
                                <td>{{ $class->jadwalKonfirmasi->jadwalkelas ?? 'Belum dikonfirmasi' }}</td>
                                <td>
        <span class="badge bg-{{ $class->pendaftaran->status === 'diterima' ? 'success' : ($class->pendaftaran->status === 'menunggu' ? 'warning' : 'secondary') }}">
            {{ ucfirst($class->pendaftaran->status) }}
        </span>
    </td>
                                <td>
                                    <button type="button"
                                        class="btn btn-sm btn-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalKonfirmasi{{ $class->id }}">
                                        Konfirmasi
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="modalKonfirmasi{{ $class->id }}" tabindex="-1"
                                        aria-labelledby="modalLabel{{ $class->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalLabel{{ $class->id }}">
                                                        Konfirmasi Jadwal & Kelas - {{ $class->pendaftaran->user->name }}
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <!-- Konfirmasi Jadwal -->
                                                        <div class="col-md-6 mb-4">
                                                            <h6>Konfirmasi Jadwal</h6>
                                                            <form method="POST"
                                                                action="{{ route('admin.pendaftaran.classes.konfirmasi', $class->id) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <select name="jadwal_konfirmasi" class="form-select mb-3">
                                                                    @foreach($class->getJadwalPilihanObjectsAttribute() as $jadwal)
                                                                    <option value="{{ $jadwal->id_jadwalkelas }}"
                                                                        @selected($class->jadwalkelas_konfirmasi == $jadwal->id_jadwalkelas)>
                                                                        {{ $jadwal->jadwalkelas }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                                <button class="btn btn-primary">Konfirmasi Jadwal</button>
                                                            </form>

                                                        </div>

                                                        <!-- Tetapkan Kelas -->
                                                       <div class="col-md-6 mb-4">
    <h6>Tetapkan Kelas</h6>

    @if($class->jadwalkelas_konfirmasi)
        <form method="POST" action="{{ route('admin.pendaftaran.assignKelas', $class->id) }}">
            @csrf
            <select name="kelas_id" class="form-select mb-3">
                @foreach($daftar_kelas as $kelas)
                    @php
                        $terisi = $kelas->siswa->count();
                        $sisa = $kelas->sisaKuota();
                        $jadwal = $kelas->jadwalKelas->jadwalkelas ?? 'Tidak ada jadwal';
                    @endphp
                    <option value="{{ $kelas->id }}" @selected($class->kelas_id == $kelas->id)>
                        {{ $kelas->nama_kelas }} - Jadwal: {{ $jadwal }} - Kuota: {{ $kelas->kuota }} - Terisi: {{ $terisi }} - Sisa: {{ $sisa }}
                    </option>
                @endforeach
            </select>
            <button class="btn btn-success">Tetapkan Kelas</button>
        </form>
    @else
        <div class="text-muted">Jadwal belum dikonfirmasi.</div>
    @endif
</div>

                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Modal -->
                                </td>
                                <td>
                                    <a href="{{ route('admin.pendaftaran.classes.show', $class->id) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
    @endsection

    @section('scripts')
    <script>
        $(document).ready(function () {
            $('#table1').DataTable();
        });
    </script>
    @endsection
