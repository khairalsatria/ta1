@extends('mentor.layout.main')

@section('title', 'Daftar Materi Pertemuan')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Materi Pertemuan</h3>
                <p class="text-subtitle text-muted">Daftar materi pertemuan untuk setiap kelas</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Materi Pertemuan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Data Materi Pertemuan</h5>
                <a href="{{ route('mentor.materi.create') }}" class="btn btn-primary btn-sm">+ Tambah Materi</a>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kelas</th>
                            <th>Pertemuan Ke</th>
                            <th>Judul</th>
                            <th>Tanggal</th>
                            <th>PDF</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($materi as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->kelas->nama_kelas }}</td>
                            <td>{{ $item->pertemuan_ke }}</td>
                            <td>{{ $item->judul }}</td>
                            <td>{{ $item->tanggal_pertemuan }}</td>
                            <td>
                                @if($item->file_pdf)
                                    <a href="{{ asset('storage/' . $item->file_pdf) }}" target="_blank" class="btn btn-info btn-sm">Lihat</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('mentor.materi.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('mentor.materi.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus materi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
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
