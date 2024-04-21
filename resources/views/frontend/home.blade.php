@extends('layouts.frontend')
@section('title','Home')
<style>
    section.banner-area {
        background: #f8f9fa;
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
        background: #0049ff2e;
        border-radius: 5px;
    }
    .banner-card-body {
        padding: 2.4rem;
        position: absolute;
        left: 0;
        top: 25%;
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
</style>
@section('style')
@endsection
@section('content')
    <section class="banner-area">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="banner-card">
                        <div class="banner-card-body card-box-design">
                            <h3 class="banner-title">আপনার বাড়ির প্ল্যান করতে চান?</h3>
                            <a href="#">এখানে এপ্লাই করুন</a>
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
                    <a href="#" class="service-card-box card-box-design">
                        <img style="height: 50px" src="{{ asset('plan_service_icon/'.$planServiceCategory->slug.'.png') }}" alt="">
                        <h5 class="service-card-box-title">{{ $planServiceCategory->name }}</h5>
                        <p class="mb-0" class="service-card-box-fees">ফিসঃ {{ en2bn(number_format($planServiceCategory->fees)) }}</p>
                        <p class="mb-0"><small><u>এপ্লাই করুন</u></small></p>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
