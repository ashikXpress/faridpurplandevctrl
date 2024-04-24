@extends('layouts.app')
@section('title','সাপোর্টিং ডকুমেন্ট ক্যাটাগরি তৈরি করুন')
@section('content')
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">সাপোর্টিং ডকুমেন্ট ক্যাটাগরির তথ্য</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form enctype="multipart/form-data" action="{{ route('supporting-document-category.store') }}" class="form-horizontal" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row {{ $errors->has('title') ? 'has-error' :'' }}">
                            <label for="title" class="col-sm-2 col-form-label">ডকুমেন্ট'স টাইটেল <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ old('title') }}" name="title" class="form-control" id="title" placeholder="ডকুমেন্ট'স টাইটেল লিখন">
                                @error('title')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('file_types') ? 'has-error' :'' }}">
                            <label for="file_types" class="col-sm-2 col-form-label">ডকুমেন্ট'স টাইপ <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select data-placeholder="ডকুমেন্ট'স টাইপ নির্ধারন করুণ..." name="file_types[]" multiple class="form-control select2" id="file_types">
                                    <option value="pdf" {{ in_array('pdf', old('file_types', [])) ? 'selected' : '' }}>PDF</option>
                                    <option value="word" {{ in_array('word', old('file_types', [])) ? 'selected' : '' }}>Word</option>
                                    <option value="excel" {{ in_array('excel', old('file_types', [])) ? 'selected' : '' }}>Excel</option>
                                    <option value="image" {{ in_array('image', old('file_types', [])) ? 'selected' : '' }}>Image</option>
                                </select>
                                @error('file_types')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('sort') ? 'has-error' :'' }}">
                            <label for="sort" class="col-sm-2 col-form-label">ক্রম <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                            <input type="text" value="{{ old('sort',$maxSort) }}" name="sort" class="form-control" id="sort" placeholder="ক্রম">
                                @error('sort')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('status') ? 'has-error' :'' }}">
                            <label class="col-sm-2 col-form-label">স্টেটাস <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <div class="icheck-success d-inline">
                                    <input checked type="radio" id="active" name="status" value="1" {{ old('status') == '1' ? 'checked' : '' }}>
                                    <label for="active">
                                        সক্রিয়
                                    </label>
                                </div>

                                <div class="icheck-danger d-inline">
                                    <input type="radio" id="inactive" name="status" value="0" {{ old('status') == '0' ? 'checked' : '' }}>
                                    <label for="inactive">
                                        নিষ্ক্রিয়
                                    </label>
                                </div>

                                @error('status')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-purple bg-gradient-purple">সংরক্ষণ করা করুন</button>
                        <a href="{{ route('supporting-document-category.index') }}" class="btn btn-danger bg-gradient-danger float-right">বাতিল</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
            <!-- /.card -->
        </div>
        <!--/.col (left) -->
    </div>
@endsection

