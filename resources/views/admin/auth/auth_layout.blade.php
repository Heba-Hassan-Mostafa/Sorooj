<!DOCTYPE html>

<html
    lang="ar"
    class="light-style customizer-hide"
    dir="rtl"
    data-theme="theme-default"
    data-assets-path="{{ asset('assets/') }}"
    data-template="vertical-menu-template">
<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ config('app.name') }} - @yield('title')</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/admin/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/fonts/tabler-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/fonts/flag-icons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/css/rtl/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/admin/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/typeahead-js/typeahead.css') }}" />
    <!-- Vendor -->
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/css/pages/page-auth.css')}}" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
    <style>
        /* Customize Toastr error message */
        .toast-error {
            background-color: #f8d7da !important; /* Light red background for errors */
            color: #721c24 !important; /* Dark red text color */
        }

        /* Customize Toastr success message */
        .toast-success {
            background-color: #d4edda !important; /* Light green background for success */
            color: #155724 !important; /* Dark green text color */
        }

        /* Customize Toastr info message */
        .toast-info {
            background-color: #d1ecf1 !important; /* Light blue background for info */
            color: #0c5460 !important; /* Dark blue text color */
        }

        /* Customize Toastr warning message */
        .toast-warning {
            background-color: #fff3cd !important; /* Light yellow background for warnings */
            color: #856404 !important; /* Dark yellow text color */
        }

        /* Optional: Set a custom font size */
        .toast-message {
            font-size: 16px;
        }
    </style>

    <!-- Helpers -->
    <script src="{{ asset('assets/admin/vendor/js/helpers.js')}}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ asset('assets/admin/vendor/js/template-customizer.js')}}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets/admin/js/config.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/vendor/css/rtl/core.css')}}" class="template-customizer-core-css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/vendor/css/rtl/theme-default.css')}}" class="template-customizer-theme-css">
</head>

<body>
<!-- Content -->

    @yield('content')
<!-- / Content -->
<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->

<script src="{{ asset('assets/admin/vendor/libs/jquery/jquery.js')}}"></script>
<script src="{{ asset('assets/admin/vendor/libs/popper/popper.js')}}"></script>
<script src="{{ asset('assets/admin/vendor/js/bootstrap.js')}}"></script>
<script src="{{ asset('assets/admin/vendor/libs/node-waves/node-waves.js')}}"></script>
<script src="{{ asset('assets/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
<script src="{{ asset('assets/admin/vendor/libs/hammer/hammer.js')}}"></script>
<script src="{{ asset('assets/admin/vendor/libs/i18n/i18n.js')}}"></script>
<script src="{{ asset('assets/admin/vendor/libs/typeahead-js/typeahead.js')}}"></script>
<script src="{{ asset('assets/admin/vendor/js/menu.js')}}"></script>

<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{ asset('assets/admin/vendor/libs/@form-validation/umd/bundle/popular.min.js')}}"></script>
<script src="{{ asset('assets/admin/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js')}}"></script>
<script src="{{ asset('assets/admin/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js')}}"></script>

<!-- Main JS -->
<script src="{{ asset('assets/admin/js/main.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!-- Page JS -->
<script src="{{ asset('assets/admin/js/pages-auth.js')}}"></script>

<script>
    @if ($errors->any())
    @foreach ($errors->all() as $error)
    toastr.error("{{ $error }}", "Error", {
        closeButton: true,
        progressBar: true,
        timeOut: "5000",
    });
    @endforeach
    @endif

    @if (session('success'))
    toastr.success("{{ session('success') }}", "Success", {
        closeButton: true,
        progressBar: true,
        timeOut: "5000",
    });
    @endif

    @if (session('info'))
    toastr.info("{{ session('info') }}", "Info", {
        closeButton: true,
        progressBar: true,
        timeOut: "5000",
    });
    @endif

    @if (session('warning'))
    toastr.warning("{{ session('warning') }}", "Warning", {
        closeButton: true,
        progressBar: true,
        timeOut: "5000",
    });
    @endif
</script>

</body>
</html>
