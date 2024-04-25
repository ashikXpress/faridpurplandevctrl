<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | {{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('layouts.partial.__favicon')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tiro+Bangla:ital@0;1&display=swap" rel="stylesheet">
    <link href="{{ asset('themes/frontend/toastr/toastr.min.css') }}" rel="stylesheet">
    <style>
        .navbar{
            box-shadow: 0 2px 4px rgba(0, 0, 0, .08), 0 4px 12px rgba(0, 0, 0, .08);
        }
        .navbar-brand {
            display: inline-block;
            padding-top: .3125rem;
            padding-bottom: .3125rem;
            margin-right: 1rem;
            font-size: 1.25rem;
            line-height: inherit;
            white-space: nowrap;
            text-align: center;
        }

        a.navbar-brand img {
            height: 85px;
        }

        .ml-auto, .mx-auto {
            margin-left: auto !important;
        }
        .nav-item a {
            font-family: "Tiro Bangla", serif;
            font-size: 19px;
            font-weight: 500;
            color: #000;
        }

        .su-main-footer-area {
            background: #5f86e4;
            min-height: 80px;
            padding: 1rem;
        }
        .list-footer {
            margin: 0;
            padding: 0;
            list-style-type: none;
        }
        .su-footer-logo img  {
            height: 98px;
        }
        .mt-5, .my-5 {
            margin-top: 3rem!important;
        }
        .list-footer {
            margin: 0;
            padding: 0;
            list-style-type: none;
        }
        .list-footer li {
            margin-bottom: 10px;
        }
        .list-footer a, .list-footer a:focus, .list-footer a:hover, .su-footer-l-col p, .su-footer-r-col p {
            color: #fff;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            font-family: "Tiro Bangla", serif;
        }
        li.nav-item a.login-btn {
            color: #0249fe;
            border-radius: 4px;
            border: 2px solid #0249fe;
            transition: all 1s ease-out;
        }
        li.nav-item a.login-btn:hover{
            background: #0249fe;
            color: #fff;
        }
        nav.navbar.navbar-expand-lg.navbar-light.bg-light.p-0 {
            background: #fff !important;
        }
        ul.list-footer li {
            display: inline-block;
            padding: 0 14px;
        }
        .su-footer-logo {
            position: relative;
        }

        .su-footer-logo img {
            height: 69px;
            bottom: -59px;
        }

        .contact-number-area {
            background: #141414;
            padding: 11px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,.08),0 4px 12px rgba(0,0,0,.08);
            text-align: center;
        }

        .contact-number {
            font-size: 17px;
            color: #fff;
            font-weight: bold;
            font-family: "Tiro Bangla", serif;
        }
        .contact-number a {
            color: #fff;
        }

        section.other-services {
            padding: 30px 0;
        }
        .other-services-section-title {
            margin-bottom: 25px;
            font-family: "Tiro Bangla", serif;
            font-weight: 400;
            font-style: normal;
        }
        .card-box-design-pdd{
            padding: 2.4rem;
        }
        .card-box-design{
            background: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,.08),0 4px 12px rgba(0,0,0,.08);
            margin-bottom: 1rem;
        }
        .border-custom-radius{
            border-radius: 5px;
        }
        .bg-custom-gray{
            background: #f8f9fa;
        }
        .form-group {
            margin-bottom: 5px;
        }
        *{
            font-family: "Tiro Bangla", serif;
        }
        .login-btn.active {
            background: #004bff;
            color: #fff !important;
            border-radius: 50% !important;
        }
        #preloader {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgb(114 114 114 / 80%);
            z-index: 9999 !important;
        }

        #loader {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border: 6px solid #f3f3f3;
            border-top: 6px solid #0d6efd;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            100% { transform: translate(-50%, -50%) rotate(360deg); }
        }
        .develop-by {
            background: #ffffff !important;
            display: inline-block;
            padding: 3px 11px;
            border-radius: 3px;
            box-shadow: 1px 5px 6px 0 rgba(0, 0, 0, .08), 0 4px 12px rgba(0, 0, 0, .08);
            font-size: 13px;
            margin-top: 18px;
        }
        /* Responsive styles */
        @media only screen and (max-width: 600px) {
            li.nav-item a.login-btn {
                color: #000;
                border-radius: 0;
                border: 0px solid #fff;
            }
            li.nav-item a.login-btn:hover{
                background: none;
                color: #000;
            }
            .login-btn.active {
                background: none;
                color: #000 !important;
                border-radius: 0 !important;
            }
        }
    </style>
    @yield('style')
</head>
<body>
<div id="preloader">
    <div id="loader"></div>
</div>
<nav class="navbar navbar-expand-lg navbar-light bg-light p-0">
    <div class="container">
        <a class="navbar-brand main-logo active" href="{{ route('home') }}">
            <img class="img-fluid" src="{{ asset('img/logo.png') }}" alt="{{ config('app.name') }}">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('home') }}">হোম</a>
                </li>
                @php
                    $redirectUrl = '';
                    if (!auth()->check()){
                         $redirectUrl = route('login',['user'=>true]);
                    }

                    $planServiceCategories = \App\Models\PlanServiceCategory::where('main_service',0)
                            ->where('status',1)
                            ->orderBy('sort')->get();
                $mainPlanServices = \App\Models\PlanServiceCategory::where('main_service',1)
                            ->where('status',1)
                            ->orderBy('sort')
                            ->get()
                @endphp
                @foreach($mainPlanServices as $mainPlanService)
                <li class="nav-item">
                    <a class="nav-link" href="{{ $redirectUrl != '' ? $redirectUrl : route('plan_service_application_form',['planServiceCategory'=>$mainPlanService->slug]) }}">পরিকল্পনা অনুমোদনের আবেদন</a>
                </li>
                @endforeach
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                       aria-expanded="false">
                        অন্যান্য সেবা সমূহ
                    </a>
                    <ul class="dropdown-menu">
                        @foreach($planServiceCategories as $planServiceCategory)
                            <li><a class="dropdown-item" href="{{ $redirectUrl != '' ? $redirectUrl : route('plan_service_application_form',['planServiceCategory'=>$planServiceCategory->slug]) }}">{{ $planServiceCategory->name }}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle  login-btn {{ auth()->check() ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown"
                       aria-expanded="false">
                        @if(auth()->check())
                            {{ customShortName(auth()->user()->name) }}
                        @else
                        লগইন/ অ্যাকাউন্ট তৈরি করুন
                        @endif
                    </a>
                    <ul class="dropdown-menu">
                        @if(auth()->check())
                        <li><a class="dropdown-item" href="{{ route('dashboard') }}">ড্যাশবোর্ড</a></li>
                        <li><a class="dropdown-item" href="#">প্রোফাইল</a></li>

                         <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                        this.closest('form').submit();">লগ আউট</a>
                            </form>

                        </li>


                        @else
                            <li><a class="dropdown-item" href="{{ route('login',['user'=>true]) }}">লগইন করুন</a></li>
                            <li><a class="dropdown-item" href="{{ route('register') }}">অ্যাকাউন্ট তৈরি করুন</a></li>
                        @endif
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
@yield('content')

<footer class="su-main-footer-area no-print">
    <div class="container">
        <div class="row text-left">
            <div class="col-12 col-md-2 text-center">
                <div class="su-footer-logo">
                    <img src="{{ asset('img/logo.png') }}" alt="{{ config('app.name') }}">
                </div>
            </div>
            <div class="col-12 col-md-7 text-center">
                <ul class="list-footer text-small">
                    <li><a class="footer-link" href="#faq">জিজ্ঞাসা</a></li>
                    <li><a class="footer-link" href="#help">যোগাযোগ</a></li>
                    <li><a class="footer-link" href="#privacy-policy">প্রাইভেসি পলিসি</a></li>
                    <li><a class="footer-link" href="#terms-of-service">টার্মস অফ সার্ভিসেস</a></li>
                </ul>

            </div>
            <div class="col-12 col-md-3">
                <div class="contact-number-area">
                    <div class="contact-number">যোগাযোগের নম্বর <a href="tel:01700000000">{{ en2bn('01700000000') }}</a></div>
                </div>
            </div>
            <div class="col-md-12 text-center">
                <p class="develop-by">Design & Developed by <a target="_blank" href="https://2aitlimited.com">2ait Limited</a></p>
            </div>
        </div>
    </div>
</footer>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
<script src="{{ asset('themes/frontend/toastr/toastr.min.js') }}"></script>
<script>
    $(function (){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    })
    function preloaderToggle(condition){
        if(condition){
            $("#preloader").fadeIn();
            $('body').css('overflow','hidden');
        }else{
            $("#preloader").fadeOut();
            $('body').css('overflow','initial');
        }
    }
    function ajaxSuccessMessage(message){
        toastr.success(message)
    }
    function ajaxErrorMessage(message){
        toastr.error(message)
    }
    function ajaxWarningMessage(message){
        toastr.warning(message)
    }
</script>
@yield('script')
</body>
</html>
