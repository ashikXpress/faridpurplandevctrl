@extends('layouts.frontend')
@section('title','লগইন')
@section('content')
    <section class="other-services bg-custom-gray">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2 class="other-services-section-title">লগইন করুন</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card-box-design card-box-design-pdd border-custom-radius">
                        @if($errors->any())
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li class="text-danger">{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <form method="POST" action="{{ route('login',['user'=>request('user')]) }}">
                            @csrf
                            <input type="hidden" name="login_type" value="{{ request('user') }}">

                            <div class="form-group">
                                <label for="email" class="form-label">মোবাইল নাম্বার <span class="text-danger">*</span></label>
                                <input type="text" autocomplete="new-username" class="form-control" id="email" name="email">
                            </div>
                            <div class="form-group">
                                <label for="password" class="form-label">পাসওয়ার্ড <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <div class="form-group">
                                <label for="remember_me">
                                    <input type="checkbox" id="remember_me" name="remember_me">
                                    আমাকে মনে রাখুন
                                </label>

                            </div>
                                <div class="flex items-center justify-end mt-4">
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}">
                                            আপনি কি পাসওয়ার্ড ভুলে গেছেন?
                                        </a>
                                    @endif
                                    <button class="btn btn-primary bg-gradient-primary"> লগইন</button>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
