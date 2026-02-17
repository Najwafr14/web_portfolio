<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin CMS - Portfolio')</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Quicksand:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

</head>

<body class="font-sans antialiased bg-light">
    <!-- Navbar -->
    @include('partials.admin.navbar')

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Main Content -->
        <div class="content py-4">
            <div class="container-fluid">
                <!-- Success Message -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Error Message -->
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Info Message -->
                @if(session('info'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="bi bi-info-circle me-2"></i>
                        {{ session('info') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Content from child views -->
                @yield('content')
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-white border-top text-center py-3 mt-5">
            <div class="container-fluid">
                <p class="text-muted small mb-0">
                    &copy; {{ date('Y') }} Portfolio CMS. All rights reserved.
                </p>
            </div>
        </footer>
    </div>


    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('assets/vendor/typed.js/typed.umd.js') }}"></script>
    <script src="{{ asset('assets/vendor/waypoints/noframework.waypoints.js') }}"></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Admin Layout Styles -->
    <style>
        :root {
            --primary-color: #3498db;
            --dark-bg: #2c3e50;
            --light-bg: #ecf0f1;
            --border-color: #bdc3c7;
            --sidebar-width: 260px;
            --navbar-height: 56px;
        }

        body {
            font-family: 'Roboto', 'Open Sans', sans-serif;
            background-color: #f5f7fa;
            padding-top: var(--navbar-height);
        }

        /* Content Wrapper */
        .content-wrapper {
            transition: margin-left 0.3s ease;
            min-height: calc(100vh - var(--navbar-height));
            display: flex;
            flex-direction: column;
        }

        .content-header {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        }

        .content-header h1 {
            color: #2c3e50;
        }

        .content {
            flex-grow: 1;
            padding: 2rem 1rem;
        }

        /* Alert Styles */
        .alert {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        /* Breadcrumb */
        .breadcrumb {
            background-color: transparent;
            padding: 0;
        }

        .breadcrumb-item.active {
            color: #6c757d;
        }

        .breadcrumb-item a {
            color: #3498db;
            text-decoration: none;
        }

        .breadcrumb-item a:hover {
            color: #2980b9;
            text-decoration: underline;
        }

        /* Footer */
        footer {
            margin-top: auto;
            background-color: #f8f9fa;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .content {
                padding: 1rem 0.5rem;
            }

            .content-header {
                padding: 1rem 0 !important;
            }

            .content-header h1 {
                font-size: 1.5rem;
            }
        }

        /* Smooth transitions */
        * {
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        a {
            transition: color 0.2s ease, text-decoration 0.2s ease;
        }

        button {
            transition: background-color 0.2s ease, border-color 0.2s ease;
        }
    </style>
</body>

</html>