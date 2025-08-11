@extends('admin.layout.main')

@section('title', 'Daftar GenZE Learn')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>GenZE Learn</h3>
                <p class="text-subtitle text-muted">Daftar pendaftar program GenZE Learn</p>
            </div>

            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">GenZE Learn</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="card-title mb-0">Data Pendaftaran GenZE Learn</h5>
    <a href="{{ route('admin.learn_events.index') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-file-earmark-medical"></i> Kelola Sertifikat
    </a>
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
                            <th>Instansi</th>
                            <th>Status</th>
                            <th>Detail & Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendaftarans as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->pendaftaran->user->name ?? '-' }}</td>
                            <td>{{ $p->asal_instansi ?? '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $p->pendaftaran->status === 'diterima' ? 'success' : ($p->pendaftaran->status === 'menunggu' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($p->pendaftaran->status) }}
                                </span>
                            </td>
                            <td>
    <a href="{{ route('admin.pendaftaran.learns.show', $p->id) }}" class="btn btn-sm btn-info">
        <i class="bi bi-eye"></i> Detail
    </a>

    <form action="{{ route('admin.pendaftaran.learns.destroy', $p->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus pendaftaran ini?');">
        @csrf
        @method('DELETE')
        @if(in_array($p->pendaftaran->status, ['ditolak', 'menunggu']))
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
