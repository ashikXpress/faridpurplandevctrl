@extends('layouts.frontend')
@section('title','Home')
<style>
    section.banner-area {
        background: #f8f9fa;
        overflow: hidden;
    }
    section.banner-area img {
        width: 100%;
        height: 280px;
        object-fit: cover;
    }
    .banner-card {
        position: relative;
        height: 100%;
        width: 100%;
    }

    .service-card-box{
        padding: 1.4rem;
        display: block;
        text-decoration: none;
        color: #000;
        background: #0049ff2e !important;
        border-radius: 5px;
    }
    .banner-card-body {
        padding: 2.4rem;
        margin-top: 69px;
    }
    .banner-title{
        font-family: "Tiro Bangla", serif;
        font-weight: bold;
        font-style: normal;
        color: #004bff;
    }

    .service-card-box img {
        margin-bottom: 10px;
    }
    .service-card-box-title,.service-card-box-fees{
        font-family: "Tiro Bangla", serif;
    }
    .progress-bar {
        height: 20px;
        margin-bottom: 10px;
        width: 100%;
        background-image: linear-gradient(to right, #ffc107 0%, #ffc107 23.5%, #000 23.5%, #000 25.5%, #007bff 25.5%, #007bff 49%,#000 49%, #000 51%, #dc3545 50%, #dc3545 74.5%,#000 74.5%, #000 76.5%, #28a745 76.5%, #28a745 100%);
    }
</style>
@section('style')
@endsection
@section('content')
    <section class="banner-area">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="banner-card" id="plan-banar">
                        <div class="banner-card-body card-box-design border-custom-radius">
                            <h3 class="banner-title">আপনার বাড়ির প্ল্যান করতে চান?</h3>
                            @php
                                $redirectUrl = '';
                                if (!auth()->check()){
                                     $redirectUrl = route('login',['user'=>true]);
                                }
                            @endphp
                            @if($mainPlanService)
                                <a href="{{ $redirectUrl != '' ? $redirectUrl : route('plan_service_application_form',['planServiceCategory'=>$mainPlanService->slug]) }}">এখানে আবেদন করুন</a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-4 offset-1">
                    <img src="{{ asset('img/banner.png') }}" alt="">
                </div>
            </div>
        </div>
    </section>
    <section class="other-services">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2 class="other-services-section-title">অন্যান্য সেবা সমূহ</h2>
                </div>
            </div>
            <div class="row">
                @foreach($planServiceCategories as $planServiceCategory)
                <div class="col-md-3 text-center">
                    <a href="{{ $redirectUrl != '' ? $redirectUrl : route('plan_service_application_form',['planServiceCategory'=>$planServiceCategory->slug]) }}" class="service-card-box card-box-design border-custom-radius">
                        <img style="height: 50px" src="{{ asset('plan_service_icon/'.$planServiceCategory->slug.'.png') }}" alt="">
                        <h5 class="service-card-box-title">{{ $planServiceCategory->name }}</h5>
                        <p class="mb-0" class="service-card-box-fees">ফিসঃ {{ en2bn(number_format($planServiceCategory->fees)) }}</p>
                        <p class="mb-0"><small><u>আবেদন করুন</u></small></p>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="other-services bg-custom-gray">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2 class="other-services-section-title">আবেদন করার প্রক্রিয়া</h2>
                </div>
            </div>
            <div class="row">
                 <div class="col-md-3 text-center">
                        <a href="{{ route('register') }}" class="service-card-box card-box-design border-custom-radius" style="background: #fff !important;">
                            <img style="height: 50px" src="{{ asset('application_apply_process/register.png') }}" alt="">
                            <h5 class="service-card-box-title">অনলাইনে নিবন্ধন</h5>
                            <p  class="service-card-box-fees">প্রথমে এই পোর্টালের মাধ্যমে সঠিক মোবাইল নম্বর যাচাইপূর্বক অনলাইনে নিবন্ধন সম্পন্ন করবেন।</p>
                        </a>
                    </div>
                <div class="col-md-3 text-center">
                    <a href="#plan-banar" class="service-card-box card-box-design border-custom-radius" style="background: #fff !important;">
                        <img style="height: 50px" src="{{ asset('application_apply_process/application_form.png') }}" alt="">
                        <h5 class="service-card-box-title">আবেদন করুণ</h5>
                        <p  class="service-card-box-fees">প্রদত্ত বিষয়ে আপানার আবেদন ফর্মের প্রয়োজনীয় তথ্য গুলো পুরুন করুণ ও ফর্ম সাবমিট করুন।</p>
                    </a>
                </div>
                 <div class="col-md-3 text-center">
                        <div class="service-card-box card-box-design border-custom-radius" style="background: #fff !important;">
                            <img style="height: 50px" src="{{ asset('application_apply_process/notification.png') }}" alt="">
                            <h5 class="service-card-box-title">এসএমএস নোটিফিকেশন</h5>
                            <p  class="service-card-box-fees">আবেদন সাবমিট সম্পন্ন হলে, আপনার আবেদনের অবস্থা সম্পরকে মুঠোফোনে খুদেবার্তা পাবেন।</p>
                        </div>
                    </div>
                 <div class="col-md-3 text-center">
                        <a href="{{ route('dashboard') }}" class="service-card-box card-box-design border-custom-radius" style="background: #fff !important;">
                            <img style="height: 50px" src="{{ asset('application_apply_process/file.png') }}" alt="">
                            <h5 class="service-card-box-title">সনদ পত্র গ্রহণ</h5>
                            <p  class="service-card-box-fees">আপনার আবেদন গৃহীত হলে আপনার ড্যাশবোর্ড থেকে সনদ ডাউনলোড করতে পারবেন।</p>
                        </a>
                    </div>
                <div class="col-md-12">
                    <div class="progress-bar"></div>
                </div>
            </div>
        </div>
    </section>
@endsection
