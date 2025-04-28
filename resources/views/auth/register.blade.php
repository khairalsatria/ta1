@extends('auth.main')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-10">
            <div class="register-container d-flex shadow rounded-4 overflow-hidden">

                <!-- Left Side -->
                <div class="col-md-6 p-0 register-left d-flex align-items-center justify-content-center">
                    <img src="{{ asset('images/illustration.png') }}" alt="Illustration" class="img-fluid">
                </div>

                <!-- Right Side -->
                <div class="col-md-6 p-5 register-right position-relative">

                    <div class="text-end">
                        <small>Already have an account? <a href="{{ route('login') }}" class="text-primary fw-bold">Login here</a></small>
                    </div>

                    <h2 class="fw-bold text-center mt-4">Create an Account</h2>
                    <p class="text-center mb-4 text-muted">Join us and enjoy our services!</p>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name -->
                        <div class="form-group mb-3">
                            <input
                                type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                name="name"
                                id="name"
                                placeholder="Enter your name"
                                value="{{ old('name') }}"
                                required
                                autofocus>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group mb-3">
                            <input
                                type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                name="email"
                                id="email"
                                placeholder="Enter email"
                                value="{{ old('email') }}"
                                required
                                autocomplete="email">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Phone Number -->
                        <div class="form-group mb-3">
                            <input
                                type="text"
                                class="form-control @error('nohp') is-invalid @enderror"
                                name="nohp"
                                id="nohp"
                                placeholder="Enter phone number"
                                value="{{ old('nohp') }}"
                                required>
                            @error('nohp')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-group mb-3 position-relative">
                            <input
                                type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                name="password"
                                id="passwordRegister"
                                placeholder="Password"
                                required
                                autocomplete="new-password">
                            <span toggle="#passwordRegister" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group mb-4 position-relative">
                            <input
                                type="password"
                                class="form-control"
                                name="password_confirmation"
                                id="passwordConfirmationRegister"
                                placeholder="Confirm Password"
                                required
                                autocomplete="new-password">
                            <span toggle="#passwordConfirmationRegister" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block rounded-3 fw-bold mb-3">Sign Up</button>
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
    .register-container {
        background: #f7faff;
        border-radius: 20px;
    }
    .register-left {
        background: #d8b4f8;
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
