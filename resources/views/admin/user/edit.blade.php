@extends('admin.layout.main')

@section('title', 'Edit User')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-md-6">
                <h3>Edit User</h3>
            </div>
            <div class="col-md-6">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.user.index') }}">User</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Form Edit User</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="nohp">No. HP</label>
                        <input type="text" class="form-control @error('nohp') is-invalid @enderror" id="nohp" name="nohp" value="{{ old('nohp', $user->nohp) }}">
                        @error('nohp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="photo">Foto</label><br>
                        @if ($user->photo)
                            <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto User" width="150" class="mb-2"><br>
                        @endif
                        <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo">
                        <small class="text-muted">Kosongkan jika tidak ingin mengganti foto</small>
                        @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="password">Password Baru</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                        <small class="text-muted">Kosongkan jika tidak ingin mengganti password</small>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation">
                        @error('password_confirmation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Update</button>
                    <a href="{{ route('admin.user.index') }}" class="btn btn-secondary mt-3">Kembali</a>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
