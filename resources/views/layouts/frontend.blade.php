<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | {{ config('app.name') }}</title>
    @include('layouts.partial.__favicon')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tiro+Bangla:ital@0;1&display=swap" rel="stylesheet">
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
            position: absolute;
            height: 69px;
            bottom: -59px;
        }

        .contact-number-area {
            background: #fff;
            padding: 11px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,.08),0 4px 12px rgba(0,0,0,.08);
        }

        .contact-number {
            font-size: 17px;
            color: #000;
            font-weight: bold;
            font-family: "Tiro Bangla", serif;
        }

        section.other-services {
            padding: 50px 0;
        }
        .other-services-section-title {
            margin-bottom: 40px;
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
    </style>
</head>
<body>
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
                <li class="nav-item">
                    <a class="nav-link" href="#">প্লানের জন্য আবেদন</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                       aria-expanded="false">
                        অন্যান্য সেবা সমূহ
                    </a>
                    <ul class="dropdown-menu">
                        @foreach(\App\Models\PlanServiceCategory::where('status',1)->orderBy('sort')->get() as $planServiceCategory)
                            <li><a class="dropdown-item" href="#{{ $planServiceCategory->slug }}">{{ $planServiceCategory->name }}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle  login-btn" href="#" role="button" data-bs-toggle="dropdown"
                       aria-expanded="false">
                        @if(auth()->check())
                            {{ auth()->user()->name }}
                        @else
                        লগইন/ অ্যাকাউন্ট তৈরি করুন
                        @endif
                    </a>
                    <ul class="dropdown-menu">
                        @if(auth()->check())
                            @if(auth()->user()->role == \App\Enumeration\Role::$USER)
                        <li><a class="dropdown-item" href="{{ route('user_dashboard') }}">ড্যাশবোর্ড</a></li>
                        <li><a class="dropdown-item" href="#">প্রোফাইল</a></li>
                        @elseif(auth()->user()->role == \App\Enumeration\Role::$ADMIN)
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}">ড্যাশবোর্ড</a></li>
                        @endif
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
                    <div class="contact-number">Contact No. <a href="tel:017xxxxxxxx">017xxxxxxxx</a></div>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>
