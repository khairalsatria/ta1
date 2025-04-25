@extends('admin.layout.main')

@section('title', 'Tambah Jadwal Guide')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-md-6">
                <h3>Tambah Jadwal Guide</h3>
            </div>
            <div class="col-md-6">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.jadwal_guide2.index') }}">Jadwal Guide</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Form Tambah Jadwal Guide</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.jadwal_guide2.store') }}" method="POST">
                    @csrf

                    @php
                        $hariList = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
                    @endphp

                    <div class="mb-3">
                        <label for="hari" class="form-label">Pilih Hari</label>
                        <select name="hari" id="hari" class="form-select @error('hari') is-invalid @enderror">
                            <option value="">-- Pilih Hari --</option>
                            @foreach($hariList as $hari)
                                <option value="{{ $hari }}" {{ old('hari') == $hari ? 'selected' : '' }}>{{ $hari }}</option>
                            @endforeach
                        </select>
                        @error('hari')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jam" class="form-label">Jam</label>
                        <input type="time" name="jam" id="jam" class="form-control @error('jam') is-invalid @enderror" value="{{ old('jam') }}">
                        @error('jam')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary mt-2">Simpan</button>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
