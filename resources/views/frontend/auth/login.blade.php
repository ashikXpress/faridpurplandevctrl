@extends('layouts.frontend')
@section('content')
    <section class="other-services">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2 class="other-services-section-title">লগইন করুন</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 offset-3">
                    <div class="card-box-design card-box-design-pdd">
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
                                <label for="email">Mobile No. <span class="text-danger">*</span></label>
                                <input type="text" autocomplete="new-username" class="form-control" id="email" name="email" placeholder="Enter Mobile No.">
                            </div>
                            <div class="form-group">
                                <label for="password">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
                            </div>
                            <div class="form-group">
                                <label for="remember_me">
                                    <input type="checkbox" id="remember_me" name="remember_me">
                                    {{ __('Remember me') }}
                                </label>

                            </div>
                                <div class="flex items-center justify-end mt-4">
                                    @if (Route::has('password.request'))
                                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                                            {{ __('Forgot your password?') }}
                                        </a>
                                    @endif
                                    <button class="btn btn-primary bg-gradient-primary">
                                        {{ __('Log in') }}
                                    </button>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
