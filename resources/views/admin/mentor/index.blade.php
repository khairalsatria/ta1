@extends('admin.layout.main')

@section('title', 'Daftar Mentor')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Mentor</h3>
                <p class="text-subtitle text-muted">Daftar mentor yang tersedia</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Mentor</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Data Mentor</h5>
                <a href="{{ route('admin.mentor.create') }}" class="btn btn-primary btn-sm">+ Tambah Mentor</a>
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
                            <th>Email</th>
                            <th>No. HP</th>
                            <th>Role</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mentors as $mentor)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $mentor->name }}</td>
                            <td>{{ $mentor->email }}</td>
                            <td>{{ $mentor->nohp }}</td>
                            <td>{{ $mentor->role }}</td>
                            <td>
                                @if($mentor->photo)
                                    <img src="{{ asset('storage/' . $mentor->photo) }}" alt="Foto" width="100">
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.mentor.edit', $mentor->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.mentor.destroy', $mentor->id) }}" method="POST" style="display:inline;">
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
