@extends('admin.layout.main')

@section('title', 'Edit Mata Pelajaran')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-md-6">
                <h3>Edit Mata Pelajaran</h3>
            </div>
            <div class="col-md-6">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.mata_pelajaran.index') }}">Mata Pelajaran</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Form Edit Mata Pelajaran</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.mata_pelajaran.update', $mata_pelajaran->id_mata_pelajaran) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="mata_pelajaran">Mata Pelajaran</label>
                        <input type="text" class="form-control @error('mata_pelajaran') is-invalid @enderror" id="mata_pelajaran" name="mata_pelajaran" value="{{ old('mata_pelajaran', $mata_pelajaran->mata_pelajaran) }}" required>
                        @error('mata_pelajaran')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="jenjang_pendidikan">Pendidikan</label>
                        <select class="form-control @error('jenjang_pendidikan') is-invalid @enderror" id="jenjang_pendidikan" name="jenjang_pendidikan" required>
                            <option value="">Pilih Pendidikan</option>
                            @foreach ($jenjangPendidikans as $jenjang)
                                <option value="{{ $jenjang->id_jenjang_pendidikan }}" {{ old('jenjang_pendidikan', $mata_pelajaran->jenjang_pendidikan) == $jenjang->id_jenjang_pendidikan ? 'selected' : '' }}>{{ $jenjang->jenjang_pendidikan }}</option>
                            @endforeach
                        </select>
                        @error('jenjang_pendidikan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Update</button>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
