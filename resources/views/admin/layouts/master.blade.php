<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="light-style layout-navbar-fixed layout-menu-fixed"
      dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" data-theme="theme-default" data-assets-path="../../assets/"
      data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <meta name="description" content="" />
    @include('admin.layouts.header')
</head>

<body>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @include('admin.layouts.sidebar')

        <!-- Layout container -->
        <div class="layout-page">

            @include('admin.layouts.navbar')


            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->

                <div class="container-xxl flex-grow-1 container-p-y">
                    @yield('content')
                </div>
                <!-- / Content -->

                @include('admin.layouts.footer')


            </div>
            <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>
</div>
<!-- / Layout wrapper -->

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->

@include('admin.layouts.footer_scripts')
</body>

</html>
