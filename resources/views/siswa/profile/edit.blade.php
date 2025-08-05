@extends('landing.layout.main')

@section('title', 'Edit Profil')

@section('content')

<!-- Header Start -->
<div class="jumbotron jumbotron-fluid page-header position-relative overlay-bottom mb-5">
    <div class="container text-center py-5">
        <h1 class="text-white display-4 fw-bold" style="text-shadow: 2px 2px 10px rgba(0,0,0,0.7);">Edit Profil</h1>
        <div class="d-inline-flex text-white mt-3 fw-semibold">
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
                <div class="alert alert-success text-center fw-semibold shadow-sm rounded-3">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif

            <div class="card border-0 shadow rounded-4">
                <div class="card-body p-4">
                    <h4 class="text-center mb-4 fw-bold text-success">
                        <i class="fas fa-user-edit me-2"></i>Perbarui Profil
                    </h4>

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Name --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-user"></i></span>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-envelope"></i></span>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                            </div>
                        </div>

                        {{-- Phone --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">No. HP</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-phone"></i></span>
                                <input type="text" name="nohp" class="form-control" value="{{ old('nohp', $user->nohp) }}">
                            </div>
                        </div>

                        {{-- Gender --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Jenis Kelamin</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-venus-mars"></i></span>
                                <select name="gender" class="form-control">
                                    <option value="L" {{ old('gender', $user->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('gender', $user->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Password Baru</label>
                            <input type="password" name="password" class="form-control mb-2" placeholder="Password baru">
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi password">
                        </div>

                        {{-- Profile Picture --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Foto Profil</label>
                            <div class="mb-2">
                                @if ($user->photo)
                                    <img src="{{ asset('storage/' . $user->photo) }}" class="rounded-circle" width="80" alt="Foto Profil">
                                @endif
                            </div>
                            <input type="file" name="photo" class="form-control">
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="btn btn-success w-100 rounded-pill fw-bold">
                            <i class="fas fa-save me-2"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Form End -->

<style>
    .form-control:focus {
        border-color: #28a745;
        box-shadow: 0 0 8px rgba(40, 167, 69, 0.25);
    }

    .input-group-text {
        width: 45px;
        justify-content: center;
        border-radius: 0.375rem 0 0 0.375rem;
    }

    .alert-success {
        background-color: #e9f7ec;
        color: #218838;
        border: none;
        padding: 0.75rem 1.25rem;
    }
</style>

@endsection
