@extends('landing.layout.main')

@section('title', 'Edit Profil')

@section('content')

<!-- Header Start -->
<div class="jumbotron jumbotron-fluid page-header position-relative overlay-bottom mb-5">
    <div class="container text-center py-5">
        <h1 class="text-white display-4 font-weight-bold" style="text-shadow: 2px 2px 10px rgba(0,0,0,0.7);">Edit Profil</h1>
        <div class="d-inline-flex text-white mt-3 font-weight-semibold">
            <p class="m-0 text-uppercase"><a class="text-white" href="{{ url('/') }}">Home</a></p>
            <i class="fa fa-angle-double-right pt-1 px-3"></i>
            <p class="m-0 text-uppercase text-white">Edit Profil</p>
        </div>
    </div>
</div>
<!-- Header End -->

<!-- Form Start -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-10">
            @if(session('success'))
                <div class="alert alert-success text-center font-weight-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <h4 class="text-center mb-4 font-weight-bold text-success">Update Profile</h4>

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="name" class="font-weight-semibold text-dark">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control rounded-pill px-4" value="{{ old('name', $user->name) }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="email" class="font-weight-semibold text-dark">Email</label>
                            <input type="email" name="email" class="form-control rounded-pill px-4" value="{{ old('email', $user->email) }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="nohp" class="font-weight-semibold text-dark">No. HP</label>
                            <input type="text" name="nohp" class="form-control rounded-pill px-4" value="{{ old('nohp', $user->nohp) }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="password" class="font-weight-semibold text-dark">Password Baru</label>
                            <input type="password" name="password" class="form-control rounded-pill px-4">
                            <input type="password" name="password_confirmation" class="form-control rounded-pill mt-2 px-4" placeholder="Konfirmasi Password">
                        </div>

                        <div class="form-group mb-3">
                            <label for="photo" class="font-weight-semibold text-dark">Foto Profil</label><br>
                            @if ($user->photo)
                                <img src="{{ asset('storage/' . $user->photo) }}" class="rounded mb-2" width="100" alt="Foto Profil">
                            @endif
                            <input type="file" name="photo" class="form-control rounded-pill px-4">
                        </div>

                        <button type="submit" class="btn btn-success w-100 rounded-pill py-2 font-weight-bold">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Form End -->

<style>
    .card input.form-control:focus {
        box-shadow: 0 0 8px rgba(40, 167, 69, 0.4);
        border-color: #28a745;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: none;
        border-radius: 10px;
        padding: 1rem;
        font-weight: 600;
    }
</style>

@endsection
