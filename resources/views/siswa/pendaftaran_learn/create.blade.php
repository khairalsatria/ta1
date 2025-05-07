@extends('landing.layout.main')
@section('title', 'Form Pendaftaran GenZE Learn')
@section('content')
<div class="container">
    <h2>Form Pendaftaran GenZE Learn</h2>
    <form action="{{ route('siswa.pendaftaranlearn.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="asal_instansi">Asal Instansi</label>
            <input type="text" name="asal_instansi" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="bukti_pembayaran">Upload Bukti Pembayaran</label>
            <input type="file" name="bukti_pembayaran" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Kirim</button>
    </form>
</div>
@endsection
