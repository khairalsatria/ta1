@extends('siswa.layout.main')

@section('content')
<div class="container">
    <h2>Masukkan Email Anda</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('siswa.pendaftaran.dashboard', $pendaftaran_id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Lihat Detail Pendaftaran</button>
    </form>
</div>
@endsection
