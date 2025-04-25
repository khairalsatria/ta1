@extends('admin.layout.main')

@section('title', 'Daftar Mata Pelajaran')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Mata Pelajaran</h3>
                <p class="text-subtitle text-muted">Daftar mata pelajaran yang tersedia</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Mata Pelajaran</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Data Mata Pelajaran</h5>
                <a href="{{ route('admin.mata_pelajaran.create') }}" class="btn btn-primary btn-sm">+ Tambah Mata Pelajaran</a>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Mata Pelajaran</th>
                            <th>Pendidikan</th> <!-- Menambahkan kolom Pendidikan -->
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mata_pelajaran as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->mata_pelajaran }}</td>
                            <td>{{ $item->jenjangPendidikan->jenjang_pendidikan }}</td> <!-- Menampilkan nilai Pendidikan -->
                            <td>
                                <a href="{{ route('admin.mata_pelajaran.edit', $item->id_mata_pelajaran) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.mata_pelajaran.destroy', $item->id_mata_pelajaran) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
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
