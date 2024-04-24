@extends('layouts.frontend')
@section('title','রেজিস্ট্রেশন')
@section('content')
    <section class="other-services bg-custom-gray">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2 class="other-services-section-title">রেজিস্ট্রেশন করুন</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card-box-design card-box-design-pdd border-custom-radius">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group">
                                <label for="name" class="form-label">আপনার নাম <span class="text-danger">*</span></label>
                                <input type="text" value="{{ old('name') }}" autocomplete="new-username" class="form-control" id="name" name="name">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="mobile_no" class="form-label">আপনার মোবাইল নাম্বার <span class="text-danger">*</span></label>
                                <input type="text" value="{{ old('mobile_no') }}" class="form-control" id="mobile_no" name="mobile_no">
                                @error('mobile_no')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password" class="form-label">পাসওয়ার্ড <span class="text-danger">*</span></label>
                                <input autocomplete="new-password" type="password" class="form-control" id="password" name="password">
                                @error('password')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation" class="form-label">পুনরায় পাসওয়ার্ড <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                @error('password_confirmation')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                    <a href="{{ route('login',['user'=>true]) }}">
                                        ইতিমধ্যে রেজিস্ট্রেশন করেছেন?
                                    </a>
                                <button class="btn btn-primary bg-gradient-primary"> রেজিস্টার</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

