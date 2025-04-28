@extends('admin.layout.main')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Detail Pendaftaran Siswa</h2>

    <div class="card shadow">
        <div class="card-body">
            <h5 class="card-title">{{ $pendaftaran->nama }}</h5>
            <p><strong>Email:</strong> {{ $pendaftaran->email }}</p>
            <p><strong>No HP:</strong> {{ $pendaftaran->nohp }}</p>
            <p><strong>Jenis Kelas:</strong> {{ $pendaftaran->jenisKelas->jeniskelas ?? '-' }}</p>
            <p><strong>Kelas:</strong> {{ $pendaftaran->kelas }}</p>
            <p><strong>Jenjang Pendidikan:</strong> {{ $pendaftaran->jenjangPendidikan->jenjang_pendidikan ?? '-' }}</p>
            <p><strong>Mata Pelajaran:</strong> {{ $pendaftaran->mataPelajaran->mata_pelajaran ?? '-' }}</p>
            <p><strong>Harga:</strong> Rp{{ number_format($pendaftaran->harga, 0, ',', '.') }}</p>
            <p><strong>Status:</strong>
                @php
                    $statusLabel = [
                        'menunggu_jadwal' => 'secondary',
                        'menunggu_pembayaran' => 'warning',
                        'pembayaran_berhasil' => 'success',
                        'pembayaran_ditolak' => 'danger',
                    ];
                @endphp
                <span class="badge bg-{{ $statusLabel[$pendaftaran->status_pembayaran ?? 'menunggu_jadwal'] ?? 'secondary' }}">
                    {{ ucfirst(str_replace('_', ' ', $pendaftaran->status_pembayaran ?? 'menunggu_jadwal')) }}
                </span>
            </p>

            <p><strong>Jadwal Pilihan:</strong></p>
            <ul>
                @foreach((array) $pendaftaran->jadwal_pilihan as $jadwalId)
                    @php
                        $jadwal = $jadwalKelas->firstWhere('id_jadwalkelas', $jadwalId);
                    @endphp
                    <li>{{ $jadwal->jadwalkelas ?? 'Jadwal tidak ditemukan' }}</li>
                @endforeach
            </ul>

            <hr>

            <form action="{{ route('admin.pendaftaran.konfirmasiJadwal', $pendaftaran->id) }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="jadwal_konfirmasi">Pilih Jadwal untuk Dikonfirmasi:</label>
                    <select name="jadwal_konfirmasi" id="jadwal_konfirmasi" class="form-select" required>
                        <option value="" selected hidden>-- Pilih Jadwal --</option> <!-- Placeholder di atas -->
                        @foreach($jadwalKelas as $jadwal)
                            <option value="{{ $jadwal->id_jadwalkelas }}">
                                {{ $jadwal->jadwalkelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Konfirmasi Jadwal</button>
            </form>


        </div>
    </div>
</div>
@endsection
