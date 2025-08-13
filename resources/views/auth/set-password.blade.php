@extends('landing.layout.main')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <h3 class="mb-3 fw-bold">Set Password</h3>
            <p class="text-muted">
                Silakan buat password agar Anda bisa login manual di lain waktu.
            </p>

            {{-- Alert pesan sukses / error --}}
            @if(session('toast_info'))
                <div class="alert alert-info">{{ session('toast_info') }}</div>
            @endif
            @if(session('toast_error'))
                <div class="alert alert-danger">{{ session('toast_error') }}</div>
            @endif
            @if(session('toast_success'))
                <div class="alert alert-success">{{ session('toast_success') }}</div>
            @endif

            <form method="POST" action="{{ route('user.set.password') }}">
                @csrf

                {{-- Password baru --}}
                <div class="mb-3">
                    <label for="password" class="form-label">Password Baru</label>
                    <input type="password"
                           name="password"
                           id="password"
                           class="form-control @error('password') is-invalid @enderror"
                           minlength="8"
                           required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Konfirmasi password --}}
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password"
                           name="password_confirmation"
                           id="password_confirmation"
                           class="form-control @error('password_confirmation') is-invalid @enderror"
                           minlength="8"
                           required>
                    @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tombol simpan --}}
                <button class="btn btn-primary w-100" type="submit">
                    Simpan Password
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
