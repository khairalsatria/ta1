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
                            <th>Program</th>
                            <th>Jadwal Konfirmasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendaftaranClasses as $class)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $class->pendaftaran->user->name }}</td>
                            <td>GenZE Class</td>
                            <td>{{ $class->jadwalKonfirmasi->jadwalkelas ?? 'Belum dikonfirmasi' }}</td>
                            <td>
                                <a href="{{ route('admin.pendaftaran.class.show', $class->id) }}" class="btn btn-sm btn-primary">Lihat & Konfirmasi</a>
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
    $(document).ready(function() {
        $('#table1').DataTable();
    });
</script>
@endsection
