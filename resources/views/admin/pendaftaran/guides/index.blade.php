@extends('admin.layout.main')

@section('title', 'Daftar Genze Guide')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Genze Guide</h3>
                <p class="text-subtitle text-muted">Daftar pendaftar program Genze Guide</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Genze Guide</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Data Pendaftaran Genze Guide</h5>
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
                            <th>Paket</th>
                            <th>Status</th>
                            <th>Aksi & Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendaftarans as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->pendaftaran->user->name ?? '-' }}</td>
                            <td>{{ $p->paketGuide->paket_guide ?? '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $p->pendaftaran->status === 'diterima' ? 'success' : ($p->pendaftaran->status === 'menunggu' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($p->pendaftaran->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.pendaftaran.guides.show', $p->id) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i> Konfirmasi
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
