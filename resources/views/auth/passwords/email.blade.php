@extends('landing.layout.main')

@section('title', 'Lupa Password')

@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-lg border-0 rounded-4 p-4" style="max-width: 450px; width: 100%;">

        <div class="text-center mb-4">
            <div class="mb-3">
                <i class="bi bi-lock-fill text-primary" style="font-size: 3rem;"></i>
            </div>
            <h3 class="fw-bold text-primary">Lupa Password</h3>
            <p class="text-muted">Masukkan email yang terdaftar, kami akan mengirimkan link reset password.</p>
        </div>

        @if (session('status'))
            <div class="alert alert-success text-center small mb-4">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email Anda</label>
                <input id="email" type="email"
                       class="form-control rounded-pill @error('email') is-invalid @enderror"
                       name="email"
                       placeholder="contoh@email.com"
                       value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="invalid-feedback small">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary rounded-pill fw-semibold">
                    <i class="bi bi-send-fill me-1"></i> Kirim Link Reset
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
