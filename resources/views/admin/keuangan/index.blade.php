@extends('admin.layout.main')

@section('title', 'Manajemen Keuangan')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Manajemen Keuangan</h3>
                <p class="text-subtitle text-muted">Laporan pemasukan dan pengeluaran</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Keuangan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        {{-- Ringkasan Keuangan --}}
        <div class="row mb-3">
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <strong>Pemasukan Manual:</strong>
                        <h4>Rp {{ number_format($totalPemasukanManual, 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <strong>Pemasukan Pendaftaran:</strong>
                        <h4>Rp {{ number_format($totalPemasukanPendaftaran, 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <strong>Pengeluaran:</strong>
                        <h4>Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-dark text-white">
                    <div class="card-body">
                        <strong>Total Saldo:</strong>
                        <h4>Rp {{ number_format($totalSaldo, 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel Data --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h5 class="card-title m-0">Data Keuangan</h5>
 <a href="{{ route('admin.keuangan.create') }}" class="btn btn-primary btn-sm">
                + Tambah Transaksi
            </a>
        <div class="d-flex flex-wrap align-items-center gap-2">


            {{-- <a href="{{ route('admin.keuangan.cetak') }}" target="_blank" class="btn btn-secondary btn-sm">
                <i class="bi bi-printer"></i> Semua
            </a> --}}

            <form action="{{ route('admin.keuangan.cetak') }}" method="GET" class="d-flex align-items-end gap-2 flex-wrap" target="_blank">
    <div class="d-flex flex-column">
        <label for="tanggal_awal" class="form-label mb-0 small">Tanggal Awal</label>
        <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control form-control-sm" required>
    </div>

    <div class="d-flex flex-column">
        <label for="tanggal_akhir" class="form-label mb-0 small">Tanggal Akhir</label>
        <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control form-control-sm" required>
    </div>

    <button type="submit" class="btn btn-secondary btn-sm mt-auto">
        <i class="bi bi-printer"></i> Cetak PDF
    </button>
</form>



        </div>
    </div>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($keuangans->count())
            <div class="table-responsive">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jenis</th>
                            <th>Keterangan</th>
                            <th>Jumlah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($keuangans as $k)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($k->tanggal)->format('d M Y') }}</td>
                                <td>
                                    <span class="badge bg-{{ $k->jenis_transaksi == 'pemasukan' ? 'success' : 'danger' }}">
                                        {{ ucfirst($k->jenis_transaksi) }}
                                    </span>
                                </td>
                                <td>{{ $k->keterangan }}</td>
                                <td>Rp {{ number_format($k->jumlah, 0, ',', '.') }}</td>
                                <td>
                                    @if($k->sumber == 'manual')
                                        <a href="{{ route('admin.keuangan.edit', $k->id) }}" class="btn btn-sm btn-warning">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.keuangan.destroy', $k->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                                Hapus
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted">Pendaftaran</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-muted">Belum ada data transaksi keuangan.</p>
        @endif
    </div>
</div>

    </section>
</div>
@endsection
