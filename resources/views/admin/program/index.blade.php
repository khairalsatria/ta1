@extends('admin.layout.main')

@section('title', 'Daftar Program')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Program</h3>
                <p class="text-subtitle text-muted">Daftar program yang tersedia</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Program</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Data Program</h5>
                <a href="{{ route('admin.program.create') }}" class="btn btn-primary btn-sm">+ Tambah Program</a>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tipe Program</th>
                            <th>Nama Program</th>
                            <th>Instruktur</th>
                            <th>Level</th>
                            <th>Durasi</th>
                            <th>Harga</th>
                            <th>Rating</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($programs as $program)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $program->tipe_program }}</td>
                            <td>{{ $program->nama_program }}</td>
                            <td>{{ $program->instruktur }}</td>
                            <td>{{ $program->level }}</td>
                            <td>{{ $program->durasi }}</td>
                            <td>Rp{{ number_format($program->harga, 0, ',', '.') }}</td>
                            <td>{{ $program->rating }}</td>
                            <td>
                                @if($program->gambar)
                                    <img src="{{ asset('storage/' . $program->gambar) }}" alt="Gambar" width="100">
                                @else
                                    -
                                @endif
                            </td>
                            <td>
    <a href="{{ route('admin.program.edit', $program->id) }}" class="btn btn-sm btn-warning">Edit</a>
    <form action="{{ route('admin.program.destroy', $program->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus program ini?')">Hapus</button>
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
