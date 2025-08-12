@extends('landing.layout.main')

@section('title', 'Reset Password')

@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-lg border-0 rounded-4 p-4" style="max-width: 450px; width: 100%;">

        <div class="text-center mb-4">
            <div class="mb-3">
                <i class="bi bi-shield-lock-fill text-success" style="font-size: 3rem;"></i>
            </div>
            <h3 class="fw-bold text-success">Reset Password</h3>
            <p class="text-muted">Masukkan password baru Anda untuk mengganti password lama.</p>
        </div>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email</label>
                <input id="email" type="email"
                       class="form-control rounded-pill @error('email') is-invalid @enderror"
                       name="email"
                       value="{{ $email ?? old('email') }}"
                       placeholder="contoh@email.com"
                       required>
                @error('email')
                    <div class="invalid-feedback small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-semibold">Password Baru</label>
                <input id="password" type="password"
                       class="form-control rounded-pill @error('password') is-invalid @enderror"
                       name="password"
                       placeholder="Minimal 8 karakter"
                       required>
                @error('password')
                    <div class="invalid-feedback small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password Baru</label>
                <input id="password_confirmation" type="password"
                       class="form-control rounded-pill"
                       name="password_confirmation"
                       placeholder="Ulangi password baru"
                       required>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-success rounded-pill fw-semibold">
                    <i class="bi bi-check-circle-fill me-1"></i> Ubah Password
                </button>
            </div>
        </form>

        <div class="text-center mt-3">
            <a href="{{ route('login') }}" class="text-decoration-none">
                <i class="bi bi-arrow-left"></i> Kembali ke Login
            </a>
        </div>
    </div>
</div>
@endsection
