@extends('admin.layout.main')

@section('title', 'Daftar Jenjang Pendidikan')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Jenjang Pendidikan</h3>
                <p class="text-subtitle text-muted">Daftar jenjang pendidikan yang tersedia</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Jenjang Pendidikan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Data Jenjang Pendidikan</h5>
                <a href="{{ route('admin.jenjang_pendidikan.create') }}" class="btn btn-primary btn-sm">+ Tambah Jenjang Pendidikan</a>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenjang Pendidikan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jenjang_pendidikan as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->jenjang_pendidikan }}</td>
                            <td>
                                <a href="{{ route('admin.jenjang_pendidikan.edit', $item->id_jenjang_pendidikan) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.jenjang_pendidikan.destroy', $item->id_jenjang_pendidikan) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
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
