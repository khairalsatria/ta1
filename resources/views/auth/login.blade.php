@extends('auth.main')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-8">
            <div class="login-container d-flex shadow rounded-4 overflow-hidden">

                <!-- Left Side -->
                <div class="col-md-6 p-0 login-left d-flex align-items-center justify-content-center">
                    <img src="{{ asset('images/illustration-login.png') }}" alt="Login Illustration" class="img-fluid">
                </div>

                <!-- Right Side -->
                <div class="col-md-6 p-5 login-right position-relative">

                    <div class="text-end">
                        <small>Don't have an account? <a href="{{ route('register') }}" class="text-primary fw-bold">Register here</a></small>
                    </div>

                    <h2 class="fw-bold text-center mt-4">Welcome Back!</h2>
                    <p class="text-center mb-4 text-muted">Login to your account</p>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <input type="text" class="form-control @error('login') is-invalid @enderror" name="login" value="{{ old('login') }}" placeholder="Email or Phone Number" required autofocus>
                            @error('login')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-4 position-relative">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="passwordLogin" placeholder="Password" required>
                            <span toggle="#passwordLogin" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary btn-block rounded-3 fw-bold mb-3">Login</button>
                    </form>

                    <div class="text-center mt-3">
                        <p class="text-muted">Or continue with</p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('google.login') }}" class="btn btn-light border rounded-circle p-2">
                                <img src="{{ asset('images/google-icon.png') }}" width="24" alt="Google">
                            </a>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .login-container {
        background: #f7faff;
        border-radius: 20px;
    }
    .login-left {
        background: #c7d2fe;
    }
    .form-control {
        border-radius: 12px;
        height: 50px;
        background: #f5f5f5;
        border: none;
    }
    .toggle-password {
        position: absolute;
        top: 50%;
        right: 15px;
        transform: translateY(-50%);
        cursor: pointer;
        color: #aaa;
    }
    .field-icon {
        font-size: 18px;
    }
    input::placeholder {
        color: #bbb;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const togglePasswords = document.querySelectorAll('.toggle-password');

        togglePasswords.forEach(function(toggle) {
            toggle.addEventListener('click', function () {
                const input = document.querySelector(this.getAttribute('toggle'));
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                this.classList.toggle('fa-eye-slash');
            });
        });
    });
</script>
@endpush
