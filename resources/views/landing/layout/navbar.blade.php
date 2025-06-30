<!-- Navbar Start -->
<div class="container-fluid p-0">
    <nav class="navbar navbar-expand-lg bg-white navbar-light py-3 py-lg-0 px-lg-5">
        <a href="{{ url('/') }}" class="navbar-brand ml-lg-3">
            <h1 class="m-0 text-primary"><i class="fa fa-book-reader mr-3"></i>GenZE</h1>
        </a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between px-lg-3" id="navbarCollapse">
    <div class="navbar-nav mx-auto py-0">
        <a href="{{ url('/home') }}" class="nav-item nav-link {{ request()->is('home') ? 'active' : '' }}">Home</a>
        <a href="{{ url('/program') }}" class="nav-item nav-link {{ request()->is('program') ? 'active' : '' }}">Course</a>
        <a href="{{ url('/team') }}" class="nav-item nav-link {{ request()->is('team') ? 'active' : '' }}">Team</a>
        <a href="{{ url('/testimoni') }}" class="nav-item nav-link {{ request()->is('team') ? 'active' : '' }}">Testimonial</a>
        <a href="{{ url('/kontak') }}" class="nav-item nav-link {{ request()->is('team') ? 'active' : '' }}">Contact</a>
        @auth
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle {{ request()->is('akun*') || request()->is('status*') || request()->is('programku*') ? 'active' : '' }}"
                data-bs-toggle="dropdown">Student Center</a>
            <div class="dropdown-menu m-0">
                <a href="{{ url('/profile') }}" class="dropdown-item {{ request()->is('akun') ? 'active' : '' }}">My Profile</a>
                <a href="{{ url('/status') }}" class="dropdown-item {{ request()->is('status') ? 'active' : '' }}">Registration</a>
                <a href="{{ url('/programku') }}" class="dropdown-item {{ request()->is('programku') ? 'active' : '' }}">My Course</a>
            </div>
        </div>
        @endauth
            </div>

            {{-- Login / Authenticated Button --}}
@auth
    <div class="d-flex align-items-center gap-2">
        <!-- Link ke profile -->
        <a href="{{ url('/profile') }}" class="btn btn-primary py-2 px-4 d-none d-lg-block">
            {{ auth()->user()->name }}
        </a>

        <!-- Logout button dengan ikon -->
        <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
            @csrf
            <button type="submit" class="btn btn-primary d-none d-lg-block" title="Logout">
                <i class="fas fa-sign-out-alt"></i>
            </button>
        </form>
    </div>
@else
    <a href="#" class="btn btn-primary py-2 px-4 d-none d-lg-block" data-toggle="modal" data-target="#loginModal">Login</a>
@endauth

        </div>

    </nav>
</div>
<!-- Navbar End -->

<!--Modal Login-->

<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content border-0 shadow-lg rounded-5 overflow-hidden" style="background-color: #fff7ee;">
            <div class="modal-body d-flex flex-column flex-md-row p-0">

                <!-- Kiri - Ilustrasi dan Slogan -->
                <div class="col-md-6 bg-light-green d-flex flex-column align-items-center justify-content-center text-center p-4">
                    <img src="{{ asset('assets2/img/login.png') }}" alt="GenZE Illustration" class="img-fluid mb-3 login-illustration">
                    <h2 class="fw-bold text-dark">GenZE<br><span class="fw-normal"></span></h2>
                </div>

                <!-- Kanan - Form Login -->
                <div class="col-md-6 bg-white p-5">
                    <h3 class="fw-bold text-center mb-4">Welcome Back!</h3>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email/Phone Input -->
                        <div class="form-group mb-4">
                            <label for="login" class="form-label fw-semibold text-dark">Email or Phone</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="bi bi-person-fill text-muted"></i>
                                </span>
                                <input type="text" id="login" class="form-control @error('login') is-invalid @enderror" name="login" value="{{ old('login') }}" placeholder="Enter your email or phone" required autofocus>
                            </div>
                            @error('login')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div class="form-group mb-4">
                            <label for="passwordLogin" class="form-label fw-semibold text-dark">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="bi bi-lock-fill text-muted"></i>
                                </span>
                                <input type="password" id="passwordLogin" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Enter your password" required>
                                <span class="input-group-text bg-white toggle-password" style="cursor: pointer;" onclick="togglePassword()">
                                    <i class="fa fa-eye text-muted" id="togglePasswordIcon"></i>
                                </span>
                            </div>
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn w-100 rounded-3 fw-bold py-2" style="background-color: #3ddc97; color: white;">
                            <i class=></i>Login
                        </button>
                    </form>

                    <!-- Google Login -->
                    <div class="text-center mt-4">
                        <p class="text-muted"></p>
                        <a href="{{ route('google.login') }}" class="btn btn-outline-primary rounded-pill px-4 py-2 d-inline-flex align-items-center">
                            <i class="fab fa-google me-2">  Google</i>
                        </a>
                    </div>
                    <div class="text-center mt-2">
                        <small>Don't have an account? <a class="text-primary fw-bold" data-dismiss="modal" data-toggle="modal" data-target="#registerModal" href="="">Register here</a></small>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<!-- Toggle password visibility script -->
<script>
function togglePassword() {
    const passwordInput = document.getElementById('passwordLogin');
    const icon = document.getElementById('togglePasswordIcon');
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    icon.classList.toggle('fa-eye');
    icon.classList.toggle('fa-eye-slash');
}
</script>

<!-- CSS -->
<style>
    .bg-light-green {
        background-color: #C6F6E2;
    }

    .modal-content {
        border-radius: 25px;
    }

    input.form-control {
        height: 45px;
        font-size: 14px;
    }

    .login-illustration {
        max-height: 280px;
        width: auto;
        object-fit: contain;
    }

    @media (max-width: 768px) {
        .login-illustration {
            max-height: 180px;
        }
    }

    .input-group-text {
        background-color: #fff;
        border-right: none;
    }

    .input-group .form-control {
        border-left: none;
    }

    .input-group .form-control:focus {
        box-shadow: none;
    }
</style>




<!-- Modal Register -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-5 overflow-hidden" style="background-color: #fff7ee;">
            <div class="modal-body d-flex flex-column flex-md-row p-0">
                <!-- Kiri - Ilustrasi -->
                <div class="col-md-6 bg-light-green d-flex flex-column align-items-center justify-content-center text-center p-4">
                    <img src="{{ asset('assets2/img/login.png') }}" alt="GenZE Illustration" class="img-fluid mb-3 login-illustration">
                    <h2 class="fw-bold text-dark">GenZE<br>
                </div>

                <!-- Kanan - Form -->
                <div class="col-md-6 bg-white p-5">

                    <h3 class="fw-bold text-center mb-3">Create an Account</h3>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name -->
                        <div class="form-group mb-3">
                            <label for="name" class="form-label fw-semibold text-dark">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" placeholder="Enter your name"
                                   value="{{ old('name') }}" required autofocus>
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group mb-3">
                            <label for="email" class="form-label fw-semibold text-dark">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" placeholder="Enter your email"
                                   value="{{ old('email') }}" required>
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Phone -->
                        <div class="form-group mb-3">
                            <label for="nohp" class="form-label fw-semibold text-dark">Phone Number</label>
                            <input type="text" class="form-control @error('nohp') is-invalid @enderror"
                                   id="nohp" name="nohp" placeholder="Enter your phone number"
                                   value="{{ old('nohp') }}" required>
                            @error('nohp') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-group mb-3">
                            <label for="passwordRegister" class="form-label fw-semibold text-dark">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-lock-fill text-muted"></i></span>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                       id="passwordRegister" name="password" placeholder="Password" required>
                                <span class="input-group-text bg-white" onclick="togglePassword('passwordRegister', 'toggleIcon1')" style="cursor:pointer;">
                                    <i class="fa fa-eye text-muted" id="toggleIcon1"></i>
                                </span>
                            </div>
                            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group mb-4">
                            <label for="passwordConfirmationRegister" class="form-label fw-semibold text-dark">Confirm Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-lock-fill text-muted"></i></span>
                                <input type="password" class="form-control"
                                       id="passwordConfirmationRegister" name="password_confirmation"
                                       placeholder="Confirm Password" required>
                                <span class="input-group-text bg-white" onclick="togglePassword('passwordConfirmationRegister', 'toggleIcon2')" style="cursor:pointer;">
                                    <i class="fa fa-eye text-muted" id="toggleIcon2"></i>
                                </span>
                            </div>
                        </div>

                        <button type="submit" class="btn w-100 rounded-3 fw-bold py-2" style="background-color: #3ddc97; color: white;">
                            <i href="#" data-dismiss="modal" data-toggle="modal" data-target="#loginModal" class="bi bi-person-plus me-2"></i>Sign Up
                        </button>
                    </form>

                    <!-- Google Login -->
                    <div class="text-center mt-4">
                        {{-- <p class="text-muted">Atau lanjutkan dengan</p> --}}
                        <a href="{{ route('google.login') }}" class="btn btn-outline-primary rounded-pill px-4 py-2 d-inline-flex align-items-center">
                            <i class="fab fa-google me-2"> Google</i>
                        </a>
                    </div>
                    <div class="text-center mt-2   ">
                        <small>Already have an account?
                            <a class="text-primary fw-bold" href="#" data-dismiss="modal" data-toggle="modal" data-target="#loginModal">Login here</a>
                        </small>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<!-- Toggle Password Script -->
<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        const isPasswordVisible = input.getAttribute('type') === 'text';

        input.setAttribute('type', isPasswordVisible ? 'password' : 'text');

        if (isPasswordVisible) {
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        } else {
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        }
    }
    </script>


<!-- CSS (gunakan juga di layout utama jika belum ada) -->
<style>
    .bg-light-green {
        background-color: #C6F6E2;
    }

    .modal-content {
        border-radius: 25px;
    }

    input.form-control {
        height: 45px;
        font-size: 14px;
    }

    .login-illustration {
        max-height: 280px;
        width: auto;
        object-fit: contain;
    }

    @media (max-width: 768px) {
        .login-illustration {
            max-height: 180px;
        }
    }

    .input-group-text {
        background-color: #fff;
        border-right: none;
    }

    .input-group .form-control {
        border-left: none;
    }

    .input-group .form-control:focus {
        box-shadow: none;
    }
</style>

@if(request('login') === 'modal')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let modal = new bootstrap.Modal(document.getElementById('loginModal'));
            modal.show();
        });
    </script>
@endif






