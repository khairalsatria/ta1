@extends('landing.layout.main')
@section('title', 'Pendaftaran Genze Learn')
@section('content')
<div class="container">
    <h2>Pendaftaran Genze Learn</h2>
    <form action="{{ route('pendaftaran.learn.store', $pendaftaranId) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Upload Sertifikat Terakhir (PDF/JPG/PNG)</label>
            <input type="file" name="sertifikat" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
        </div>
        <button type="submit" class="btn btn-primary">Daftar & Upload</button>
    </form>
</div>
@endsection
