@extends('admin.layout.main')
@section('content')
<h2 class="text-xl font-bold mb-4">Daftar Kelas Genze</h2>
<a href="{{ route('admin.kelas.create') }}" class="btn btn-primary mb-4">+ Tambah Kelas</a>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama Kelas</th>
            <th>Mentor</th>
            <th>Kuota</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($kelas as $k)
        <tr>
            <td>{{ $k->nama_kelas }}</td>
            <td>{{ $k->mentor->name ?? '-' }}</td>
            <td>{{ $k->kuota }}</td>
            <td>
                <a href="{{ route('admin.kelas.edit', $k->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('admin.kelas.destroy', $k->id) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"
                        onclick="return confirm('Yakin ingin menghapus kelas ini?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
