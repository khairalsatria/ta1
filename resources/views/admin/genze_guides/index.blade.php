@extends('admin.layout.main')

@section('title', 'Daftar Genze Guide')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Genze Guide</h3>
                <p class="text-subtitle text-muted">Daftar Genze Guide yang tersedia</p>
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
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Data Genze Guide</h5>
                <a href="{{ route('admin.genze_guides.create') }}" class="btn btn-primary btn-sm">+ Tambah Guide</a>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Paket Guide</th>
                            <th>Jadwal Guide</th>
                            <th>Harga</th>
                            <th>Link Zoom</th>
                            <th>File</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($guides as $guide)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $guide->paket->paket_guide ?? '-' }}</td>
                            <td>{{ $guide->jadwal->jadwalguide2 ?? '-' }}</td>
                            <td>Rp{{ number_format($guide->harga, 0, ',', '.') }}</td>
                            <td>{{ $guide->link_zoom ?? '-' }}</td>
                            <td>
                                @if($guide->file)
                                    <a href="{{ asset('storage/' . $guide->file) }}" target="_blank" class="btn btn-sm btn-success">Lihat File</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.genze_guides.edit', $guide) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.genze_guides.destroy', $guide) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
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
    $(document).ready(function() {
        $('#table1').DataTable();
    });
</script>
@endsection
