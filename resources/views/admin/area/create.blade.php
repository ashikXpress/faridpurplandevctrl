@extends('layouts.app')
@section('title','মহল্লা তৈরি করুন')
@section('content')
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">মহল্লার তথ্য</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form enctype="multipart/form-data" action="{{ route('area.store') }}" class="form-horizontal" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row {{ $errors->has('area_no') ? 'has-error' :'' }}">
                            <label for="area_no" class="col-sm-2 col-form-label">মহল্লা নং <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ old('area_no') }}" name="area_no" class="form-control" id="area_no" placeholder="মহল্লা নং লিখুন">
                                @error('area_no')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('area_name') ? 'has-error' :'' }}">
                            <label for="area_name" class="col-sm-2 col-form-label">মহল্লা নাম <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ old('area_name') }}" name="area_name" class="form-control" id="area_name" placeholder="মহল্লা নাম লিখুন">
                                @error('area_name')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('ward') ? 'has-error' :'' }}">
                            <label for="ward" class="col-sm-2 col-form-label">ওয়ার্ড নং <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select name="ward" id="ward" class="form-control select2">
                                    <option value="">ওয়ার্ড নং নির্ধারণ</option>
                                    @foreach($wards as $ward)
                                    <option {{ old('ward') == $ward->id ? 'selected' : '' }} value="{{ $ward->id }}">{{ $ward->ward_no }}</option>
                                    @endforeach
                                </select>
                            @error('ward')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-purple bg-gradient-purple">সংরক্ষণ করা করুন</button>
                        <a href="{{ route('area.index') }}" class="btn btn-danger bg-gradient-danger float-right">বাতিল</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
            <!-- /.card -->
        </div>
        <!--/.col (left) -->
    </div>
@endsection

