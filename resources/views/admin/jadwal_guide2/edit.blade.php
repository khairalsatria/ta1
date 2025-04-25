@extends('admin.layout.main')

@section('title', 'Edit Jadwal Guide')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-md-6">
                <h3>Edit Jenis Kelas</h3>
            </div>
            <div class="col-md-6">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        {{-- <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li> --}}
                        <li class="breadcrumb-item"><a href="{{ route('admin.jadwal_guide2.index') }}">Jadwal Guide</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

<section class="section">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.jadwal_guide2.update', $jadwal->id_jadwalguide2) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group mb-3">
                    <label for="hari">Pilih Hari</label>
                    <select name="hari" id="hari" class="form-control @error('hari') is-invalid @enderror">
                        <option value="">-- Pilih Hari --</option>
                        @foreach ($hariList as $item)
                            <option value="{{ $item }}" {{ $hari == $item ? 'selected' : '' }}>{{ $item }}</option>
                        @endforeach
                    </select>
                    @error('hari')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="jam">Jam</label>
                    <input type="time" name="jam" id="jam" class="form-control @error('jam') is-invalid @enderror" value="{{ $jam }}">
                    @error('jam')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</section>
@endsection
