<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>GenZE</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets2/img/favicon.ico') }}">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets2/lib/owlcarousel/assets/owl.carousel.min.css') }}">

    <!-- Customized Bootstrap Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets2/css/style.css') }}">
    <style>
        /* public/assets2/css/custom.css */
#mainNavbar {
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 1050;
    background-color: white;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

body {
    padding-top: 90px;
}

    </style>
</head>

<body>
    @include('landing.layout.navbar')


    @yield('content')

    @include('landing.layout.footer')

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary rounded-0 btn-lg-square back-to-top">
        <i class="fa fa-angle-double-up"></i>
    </a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets2/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('assets2/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('assets2/lib/counterup/counterup.min.js') }}"></script>
    <script src="{{ asset('assets2/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Template Javascript -->
    <script src="{{ asset('assets2/js/main.js') }}"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
    function togglePassword(inputId = 'passwordLogin', iconId = 'togglePasswordIcon') {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        if (!input || !icon) return; // safety check

        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            input.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }

</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if(session('toast_success'))
            Swal.fire({
                toast: true,
                icon: 'success',
                title: '{{ session('toast_success') }}',
                position: 'top-end',
                showConfirmButton: false,
                timer: 2500,
                padding: '1rem',
                customClass: {
                    popup: 'shadow-lg rounded-3'
                }
            });
        @endif

        @if(session('toast_error'))
            Swal.fire({
                toast: true,
                icon: 'error',
                title: '{{ session('toast_error') }}',
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                padding: '1rem',
                customClass: {
                    popup: 'shadow-lg rounded-3'
                }
            });
        @endif
    });
</script>

<script>
    $(document).ready(function(){

        $('.mentor-carousel').owlCarousel({
            loop: true,
            margin: 20,
            autoplay: true,
            autoplayTimeout: 2500,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 1
                },
                576: {
                    items: 2
                },
                768: {
                    items: 3
                },
                992: {
                    items: 4
                }
            }
        });


        $(".blog-carousel").owlCarousel({
            loop: true,
            margin: 20,
            nav: false,
            dots: true,
            autoplay: true,
            autoplayTimeout: 5000,
            responsive: {
                0: { items: 1 },
                768: { items: 2 },
                992: { items: 3 }
            }
        });
         $(document).ready(function(){
        $('.partner-carousel').owlCarousel({
            loop: true,
            margin: 10,
            autoplay: true,
            autoplayTimeout: 2000,
            responsive: {
                0: { items: 3 },
                600: { items: 4 },
                1000: { items: 6 }
            }
        });
    });
    });
</script>


</body>

</html>
