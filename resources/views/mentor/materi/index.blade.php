@extends('mentor.layout.main')
@section('title', 'Daftar Materi')

@section('content')
<div class="container">
    <h4 class="mb-4">Daftar Materi Pertemuan</h4>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('mentor.materi.create') }}" class="btn btn-primary mb-3">Tambah Materi</a>

    <table class="table table-bordered">
        <thead>
            <tr>
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
                    <td>{{ $item->kelas->nama_kelas }}</td>
                    <td>{{ $item->pertemuan_ke }}</td>
                    <td>{{ $item->judul }}</td>
                    <td>{{ $item->tanggal_pertemuan }}</td>
                    <td>
                        @if($item->file_pdf)
                            <a href="{{ asset('storage/' . $item->file_pdf) }}" target="_blank">Lihat</a>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('mentor.materi.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('mentor.materi.destroy', $item->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
