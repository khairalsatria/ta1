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
                <a href="{{ url('/') }}" class="nav-item nav-link active">Home</a>
                <a href="{{ url('/about') }}" class="nav-item nav-link">About</a>
                <a href="{{ url('/courses') }}" class="nav-item nav-link">Courses</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Pages</a>
                    <div class="dropdown-menu m-0">
                        <a href="{{ url('/detail') }}" class="dropdown-item">Course Detail</a>
                        <a href="{{ url('/feature') }}" class="dropdown-item">Our Features</a>
                        <a href="{{ url('/team') }}" class="dropdown-item">Instructors</a>
                        <a href="{{ url('/testimonial') }}" class="dropdown-item">Testimonial</a>
                    </div>
                </div>
                <a href="{{ url('/contact') }}" class="nav-item nav-link">Contact</a>
            </div>
            <a href="{{ route('login') }}" class="btn btn-primary py-2 px-4 d-none d-lg-block">Login</a>


        </div>
    </nav>
</div>
<!-- Navbar End -->

{{-- <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content login-modal-content">
            <div class="row no-gutters">

                <!-- Left Side -->
                <div class="col-md-6 login-left">
                    <div class="illustration">
                        <img src="{{ asset('images/illustration.png') }}" alt="Illustration" class="img-fluid">
                    </div>
                </div>

                <!-- Right Side -->
                <div class="col-md-6 login-right p-5">
                    <div class="modal-header border-0">
                        <h5 class="modal-title w-100 text-center" id="loginModalLabel">Hello Again!</h5>
                    </div>
                    <div class="modal-body p-0">
                        <p class="text-center mb-4">Welcome back, you've been missed!</p>

                        <form method="POST" action="{{ route('home') }}">
                            @csrf
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" placeholder="Enter email" required>
                            </div>
                            <div class="form-group position-relative">
                                <input type="password" class="form-control" name="password" placeholder="Password" id="passwordField" required>
                                <span toggle="#passwordField" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>
                            <div class="form-group text-right">
                                <a href="#" class="small">Recovery Password</a>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-danger btn-block">Sign In</button>
                            </div>
                        </form>

                        <div class="text-center mt-4">
                            <p>Or continue with</p>
                            <div class="social-login-buttons d-flex justify-content-center">
                                <a href="{{ route('google.login') }}" class="btn btn-light mr-2">
                                    <img src="{{ asset('images/google-icon.png') }}" width="20" alt="Google">
                                </a>
                                {{-- Tambahkan tombol Facebook/Apple nanti kalau mau
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <p class="small">Not a member? <a href="#" id="registerLink">Register now</a></p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content register-modal-content">
            <div class="row no-gutters">

                <!-- Left Side -->
                <div class="col-md-6 login-left">
                    <div class="illustration">
                        <img src="{{ asset('images/illustration.png') }}" alt="Illustration" class="img-fluid">
                    </div>
                </div>

                <!-- Right Side -->
                <div class="col-md-6 login-right p-5">
                    <div class="modal-header border-0">
                        <h5 class="modal-title w-100 text-center" id="registerModalLabel">Create an Account</h5>
                    </div>
                    <div class="modal-body p-0">
                        <p class="text-center mb-4">Join us and enjoy our services!</p>

                        {{-- <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" placeholder="Enter your name" required>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" placeholder="Enter email" required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="nohp" placeholder="Enter phone number" required>
                            </div>
                            <div class="form-group position-relative">
                                <input type="password" class="form-control" name="password" placeholder="Password" id="passwordFieldRegister" required>
                                <span toggle="#passwordFieldRegister" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>
                            <div class="form-group position-relative">
                                <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-danger btn-block">Sign Up</button>
                            </div>
                        </form>

                        <div class="text-center mt-4">
                            <p>Or continue with</p>
                            <div class="social-login-buttons d-flex justify-content-center">
                                <a href="{{ route('google.login') }}" class="btn btn-light mr-2">
                                    <img src="{{ asset('images/google-icon.png') }}" width="20" alt="Google">
                                </a>
                                {{-- Tambahkan tombol Facebook/Apple nanti kalau mau
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <p class="small">Already have an account? <a href="#" id="loginLink">Login here</a></p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>



<!-- Custom CSS -->
<style>
    .login-modal-content {
        border-radius: 20px;
        overflow: hidden;
    }
    .login-left {
        background: #f7d4f7; /* Soft pink-purple background */
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .login-right {
        background: #ffffff;
    }
    .form-control {
        border-radius: 10px;
        height: 45px;
    }
    .btn-danger {
        background-color: #FF6B6B;
        border: none;
        border-radius: 10px;
        height: 45px;
        font-weight: bold;
    }
    .btn-danger:hover {
        background-color: #ff4c4c;
    }
    .social-login-buttons .btn {
        border: 1px solid #ccc;
        border-radius: 10px;
        padding: 0.5rem 1rem;
    }
    .toggle-password {
        position: absolute;
        top: 50%;
        right: 15px;
        transform: translateY(-50%);
        cursor: pointer;
        color: #aaa;
    }
    input::placeholder {
        color: #aaa;
    }
</style>

<!-- Optional: Toggle password visibility -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const togglePassword = document.querySelector('.toggle-password');
        const passwordField = document.querySelector('#passwordField');

        togglePassword.addEventListener('click', function () {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });
    });
</script>

<script>
    document.getElementById('registerLink').addEventListener('click', function() {
        $('#loginModal').modal('hide');
        $('#registerModal').modal('show');
    });

    document.getElementById('loginLink').addEventListener('click', function() {
        $('#registerModal').modal('hide');
        $('#loginModal').modal('show');
    });
</script> --}}






