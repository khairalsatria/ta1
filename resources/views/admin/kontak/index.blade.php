@extends('admin.layout.main')

@section('title', 'Daftar Kontak')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Kontak</h3>
                <p class="text-subtitle text-muted">Daftar data kontak yang tersedia</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Kontak</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Data Kontak</h5>
                <a href="{{ route('admin.kontak.create') }}" class="btn btn-primary btn-sm">+ Tambah Kontak</a>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kontak</th>
                            <th>Isi</th>
                            <th>Link</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kontaks as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->kontak }}</td>
                            <td>{{ $item->isi }}</td>
                            <td>
                                @if($item->link)
                                    <a href="{{ $item->link }}" target="_blank" rel="noopener noreferrer">{{ $item->link }}</a>
                                @else
                                    -
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('admin.kontak.edit', $item->id_kontak) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.kontak.destroy', $item->id_kontak) }}" method="POST" style="display:inline;">
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
