{{-- @extends('auth.main')

@section('content')
<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content login-container shadow rounded-4 overflow-hidden">
            <div class="modal-body p-0 d-flex">

                <!-- Left Side -->
                <div class="col-md-6 p-0 login-left d-none d-md-flex align-items-center justify-content-center">
                    <img src="{{ asset('images/illustration-login.png') }}" alt="Login Illustration" class="img-fluid">
                </div>

                <!-- Right Side -->
                <div class="col-md-6 p-4 login-right position-relative">

                    <div class="text-end mb-2">
                        <small>Don't have an account? <a href="{{ route('register') }}" class="text-primary fw-bold">Register here</a></small>
                    </div>

                    <h2 class="fw-bold text-center">Welcome Back!</h2>
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

                        <button type="submit" class="btn btn-primary w-100 rounded-3 fw-bold mb-3">Login</button>
                    </form>

                    <div class="text-center mt-3">
                        <p class="text-muted">Or continue with</p>
                        <a href="{{ route('google.login') }}" class="btn btn-light border rounded-circle p-2">
                            <img src="{{ asset('images/google-icon.png') }}" width="24" alt="Google">
                        </a>
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


<script>
    @if ($errors->has('login') || $errors->has('password'))
        $(document).ready(function() {
            $('#loginModal').modal('show');
        });
    @endif
</script>
 --}}
