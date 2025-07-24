@extends('admin.layout.main')

@section('title', 'Daftar Pendaftaran Program')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Pendaftaran Program</h3>
                <p class="text-subtitle text-muted">Daftar semua pendaftaran program</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Pendaftaran</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Data Pendaftaran Program</h5>
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
                            <th>Status</th>
                            {{-- <th>Bukti Pembayaran</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendaftarans as $pendaftaran)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pendaftaran->user->name }}</td>
                            <td>{{ $pendaftaran->program->tipe_program ?? '-' }} {{ $pendaftaran->program->nama_program ??  '-' }}</td>
                            <td>{{ ucfirst($pendaftaran->status) }}</td>
                            {{-- <td>
                                @if($pendaftaran->bukti_pembayaran)
                                    <a href="{{ Storage::url($pendaftaran->bukti_pembayaran) }}" target="_blank" class="btn btn-sm btn-info">Lihat</a>
                                @else
                                    <span class="text-muted">Belum upload</span>
                                @endif
                            </td> --}}
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
