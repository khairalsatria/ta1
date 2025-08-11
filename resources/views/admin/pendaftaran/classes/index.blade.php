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
                                <th>Detail & Aksi</th>

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
                                    <a href="{{ route('admin.pendaftaran.classes.show', $class->id) }}" class="btn btn-sm btn-info">
        <i class="bi bi-eye"></i> Detail
    </a>
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
        <div class="modal-content border-0 shadow-sm">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalLabel{{ $class->id }}">
                    <i class="bi bi-calendar-check me-2"></i>
                    Konfirmasi Jadwal & Kelas - {{ $class->pendaftaran->user->name }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row g-4">

                    <!-- Konfirmasi Jadwal -->
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h6 class="card-title fw-bold mb-3">
                                    <i class="bi bi-clock me-2"></i>Konfirmasi Jadwal
                                </h6>

                                @if($class->jadwalkelas_konfirmasi && $class->kelas_id)
                                    <div class="">
                                        <strong>Jadwal & Kelas telah ditentukan:</strong><br>
                                        <span class="badge bg-success">{{ $class->jadwalKonfirmasi->jadwalkelas ?? 'Tidak ditemukan' }}</span><br>

                                    </div>
                                @else
                                    <form method="POST" action="{{ route('admin.pendaftaran.classes.konfirmasi', $class->id) }}">
                                        @csrf
                                        @method('PUT')

                                        <div class="mb-3">
                                            <label for="jadwal_konfirmasi" class="form-label">Pilih Jadwal</label>
                                            <select name="jadwal_konfirmasi" class="form-select" required>
                                                <option value="" disabled selected>-- Pilih Jadwal --</option>
                                                @foreach($class->getJadwalPilihanObjectsAttribute() as $jadwal)
                                                    <option value="{{ $jadwal->id_jadwalkelas }}"
                                                        @selected($class->jadwalkelas_konfirmasi == $jadwal->id_jadwalkelas)>
                                                        {{ $jadwal->jadwalkelas }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <button class="btn btn-primary w-100">
                                            <i class="bi bi-check-circle me-1"></i> Konfirmasi Jadwal
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Tetapkan Kelas -->
                    <!-- Tetapkan Kelas -->
<div class="col-md-6">
    <div class="card border-0 shadow-sm h-100">
        <div class="card-body">
            <h6 class="card-title fw-bold mb-3">
                <i class="bi bi-building me-2"></i>Tetapkan Kelas
            </h6>

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @php
                $userId = optional($class->pendaftaran)->user_id;
                $kelasTersedia = $daftar_kelas->filter(function ($kelas) use ($userId) {
                    return !\App\Models\PendaftaranClasses::where('kelas_id', $kelas->id)
                        ->whereHas('pendaftaran', function ($query) use ($userId) {
                            $query->where('user_id', $userId);
                        })->exists();
                });
            @endphp

            @if($class->pendaftaran->status !== 'diterima')
                <div class="text-warning">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                   Pembayaran siswa belum diterima. Tetapkan kelas hanya setelah pembayaran diterima.
                </div>
            @elseif($class->jadwalkelas_konfirmasi && $class->kelas_id)
                <div class="">
                    <strong>Kelas sudah ditetapkan:</strong><br>
                    <span class="badge bg-success">{{ $class->kelasGenze->nama_kelas ?? 'Tidak ditemukan' }}</span>
                </div>
            @elseif($class->jadwalkelas_konfirmasi)
                @if($kelasTersedia->isNotEmpty())
                    <form method="POST" action="{{ route('admin.pendaftaran.assignKelas', $class->id) }}">
                        @csrf

                        <div class="mb-3">
                            <label for="kelas_id" class="form-label">Pilih Kelas</label>
                            <select name="kelas_id" class="form-select" required>
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($kelasTersedia as $kelas)
                                    @php
                                        $terisi = $kelas->siswa->count();
                                        $sisa = $kelas->sisaKuota();
                                        $jadwal = optional($kelas->jadwalKelas)->jadwalkelas ?? 'Tidak ada jadwal';
                                    @endphp
                                    <option value="{{ $kelas->id }}">
                                        {{ $kelas->nama_kelas }} - Jadwal: {{ $jadwal }} - Kuota: {{ $kelas->kuota }} - Terisi: {{ $terisi }} - Sisa: {{ $sisa }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button class="btn btn-success w-100">
                            <i class="bi bi-check2-square me-1"></i> Tetapkan Kelas
                        </button>
                    </form>
                @else
                    <div class="text-muted">Siswa telah tergabung di semua kelas yang tersedia.</div>
                @endif
            @else
                <div class="text-muted">Jadwal belum dikonfirmasi.</div>
            @endif
        </div>
    </div>
</div>


                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->





    <form action="{{ route('admin.pendaftaran.classes.destroy', $class->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus pendaftaran ini?');">
        @csrf
        @method('DELETE')
        @if(in_array($class->pendaftaran->status, ['ditolak', 'menunggu']))
            <button type="submit" class="btn btn-sm btn-danger">
                <i class="bi bi-trash"></i> Hapus
            </button>
        @else
            <button type="button" class="btn btn-sm btn-secondary" disabled>
                <i class="bi bi-trash"></i> Hapus
            </button>
        @endif
    </form>
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
