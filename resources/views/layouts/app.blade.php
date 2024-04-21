<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | {{ config('app.name', 'Laravel') }}</title>
    @include('layouts.partial.__favicon')
    @include('layouts.partial.__styles')
    @yield('style')
</head>
<body class="sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed  {{ auth()->user()->theme_mode == 1 ? ' ' : 'dark-mode' }}">
<div class="wrapper">
    <!-- Navbar -->
@include('layouts.partial.__navbar')
<!-- /.navbar -->
    <!-- Main Sidebar Container -->
@include('layouts.partial.__main_sidebar')
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="position: relative;">
        <div id="preloader">
            <div id="loader"></div>
        </div>
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <h1>@yield('title')</h1>
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                @yield('content')
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <!-- Main Footer -->
    @include('layouts.partial.__footer')
</div>
<!-- ./wrapper -->
@include('layouts.partial.__media_files')
<!-- REQUIRED SCRIPTS -->
@include('layouts.partial.__scripts')
@yield('script')
<!-- AdminLTE App -->
<script src="{{ asset('themes/backend/dist/js/adminlte.min.js') }}"></script>
</body>
</html>
