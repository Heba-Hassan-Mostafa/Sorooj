<!-- Favicon -->
<link rel="icon" href="{{ asset('assets/admin/img/favicon.png') }}">


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

<link rel="stylesheet" href="{{ asset('assets/admin/css/demo.css') }}" />

<!-- Vendors CSS -->
<link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/node-waves/node-waves.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/typeahead-js/typeahead.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/swiper/swiper.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/flatpickr/flatpickr.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/animate-css/animate.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/sweetalert2/sweetalert2.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/bs-stepper/bs-stepper.css') }}" />
{{--<link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/select2/select2.css') }}" />--}}

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">

@yield('css')

<link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />

<!-- Page CSS -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/admin/vendor/css/pages/cards-advance.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/admin/css/custom.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/css/main.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/css/mainStyle.css') }}">



@if (app()->getLocale() == 'ar')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/rtl.css') }}" />
@endif

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
<script src="{{ asset('assets/admin/vendor/js/helpers.js') }}"></script>

<script src="{{ asset('assets/admin/vendor/js/template-customizer.js') }}"></script>
<script src="{{ asset('assets/admin/js/config.js') }}"></script>

<!-- Jquery --->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
        integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="{{ asset('assets/admin/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
<link rel="stylesheet" href="{{ asset('assets/admin/vendor/css/rtl/theme-default.css') }}"
      class="template-customizer-theme-css" />

@livewireStyles
