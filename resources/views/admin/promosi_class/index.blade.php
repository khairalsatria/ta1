@extends('admin.layout.main')

@section('title', 'Daftar Promosi Class')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-md-6">
                <h3>Daftar Promosi Class</h3>
            </div>
            <div class="col-md-6">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Promosi Class</li>
                    </ol>
                </nav>
            </div>
        </div>
    </ <div class="page-heading">
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Data Promosi Class</h5>
                <div>
                    <a href="{{ route('admin.promosi_class.create') }}" class="btn btn-primary btn-sm">+ Tambah Promosi Class</a>
                    {{-- <a href="{{ route('admin.pendaftaran_class.index') }}" class="btn btn-success btn-sm">Pendaftaran</a> --}}
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Program</th>
                            <th>Deskripsi</th>
                            <th>Benefit</th>
                            <th>Harga</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($promosi_classes as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama_program }}</td>
                            <td>{{ $item->deskripsi }}</td>
                            <td>{{ $item->benefit }}</td>
                            <td>{{ number_format($item->harga, 2) }}</td>
                            <td>
                                @if($item->gambar)
                                    <img src="{{ asset('images/promosi/' . $item->gambar) }}" alt="{{ $item->nama_program }}" width="100">
                                @else
                                    Tidak ada gambar
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.promosi_class.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.promosi_class.destroy', $item->id) }}" method="POST" style="display:inline;">
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
