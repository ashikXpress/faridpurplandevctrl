@extends('layouts.frontend')
@section('title',$planServiceCategory->name.' এর জন্যে আবেদন')
@section('style')
    <style>
        .reset {
            all: revert;
        }
        .form-group {
            margin-bottom: 15px;
        }
        legend.reset {
            font-size: 25px;
        }
        .form-control:focus {
            border-color: #004bff;
            box-shadow: none;
        }

    </style>
@endsection
@section('content')
    <section class="other-services bg-custom-gray">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2 class="other-services-section-title">{{ $planServiceCategory->name }} এর জন্যে আবেদন করুন</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card-box-design card-box-design-pdd border-custom-radius">
                        <form id="application-form" method="POST" enctype="multipart/form-data" action="{{ route('plan_service_application_form',['planServiceCategory'=>$planServiceCategory->slug]) }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-7">
                                    <fieldset class="reset">
                                        <legend class="reset">প্রয়োজনীয় তথ্যাদি</legend>
                                        <div class="row">
                                            @if($planServiceCategory->fees > 0)
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="fees" class="form-label">ফিসের পরিমান</label>
                                                        <input readonly style="background: #ddd" type="text" value="{{ old('fees',en2bn(number_format($planServiceCategory->fees))) }}" class="form-control" id="fees" name="fees">
                                                        <span id="fees-error" class="text-danger error-message"></span>
                                                    </div>
                                                </div>
                                            @endif
                                            @if($planServiceCategory->is_need_plan_no == 1)
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="existing_plan_no" class="form-label">বিদ্যমান প্লানের নম্বর লিখুন <span class="text-danger ">*</span></label>
                                                        <input type="text" value="{{ old('existing_plan_no') }}" class="form-control" id="existing_plan_no" name="existing_plan_no">
                                                        <span id="existing_plan_no-error" class="text-danger error-message"></span>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name" class="form-label">আপনার নাম <span class="text-danger ">*</span></label>
                                                    <input type="text" value="{{ old('name') }}" class="form-control" id="name" name="name">
                                                    <span id="name-error" class="text-danger error-message"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="father_name" class="form-label">পিতার নাম <span class="text-danger ">*</span></label>
                                                    <input type="text" value="{{ old('father_name') }}" class="form-control" id="father_name" name="father_name">
                                                    <span id="father_name-error" class="text-danger error-message"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="mother_name" class="form-label">মাতার নাম <span class="text-danger ">*</span></label>
                                                    <input type="text" value="{{ old('mother_name') }}" class="form-control" id="mother_name" name="mother_name">
                                                    <span id="mother_name-error" class="text-danger error-message"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="mobile_no" class="form-label">মোবাইল নাম্বার <span class="text-danger ">*</span></label>
                                                    <input type="text" value="{{ old('mobile_no',en2bn(auth()->user()->mobile_no ?? '')) }}" class="form-control" id="mobile_no" name="mobile_no">
                                                    <span id="mobile_no-error" class="text-danger error-message"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="alternative_mobile_no" class="form-label">বিকল্প মোবাইল নাম্বার (*যদি থাকে)</label>
                                                    <input type="text" value="{{ old('alternative_mobile_no') }}" class="form-control" id="alternative_mobile_no" name="alternative_mobile_no">
                                                    <span id="alternative_mobile_no-error" class="text-danger error-message"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="nid_no" class="form-label">জাতীয় পরিচয়পত্রের নাম্বার <span class="text-danger ">*</span></label>
                                                    <input type="text" value="{{ old('nid_no') }}" class="form-control" id="nid_no" name="nid_no">
                                                    <span id="nid_no-error" class="text-danger error-message"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="ward" class="form-label">ওয়ার্ড নং <span class="text-danger ">*</span></label>
                                                    <select name="ward" class="form-control select2" id="ward">
                                                        <option value="">ওয়ার্ড নং নির্ধারণ</option>
                                                        @foreach($wards as $ward)
                                                        <option value="{{ $ward->id }}">{{ en2bn($ward->ward_no) }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="ward-error" class="text-danger error-message"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="area" class="form-label">মহল্লা <span class="text-danger ">*</span></label>
                                                    <select name="area" class="form-control select2" id="area">
                                                        <option value="">মহল্লা নির্ধারণ</option>
                                                    </select>
                                                    <span id="area-error" class="text-danger error-message"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="address" class="form-label">সম্পূর্ণ ঠিকানা লিখুন <span class="text-danger ">*</span></label>
                                                    <textarea class="form-control" id="address" name="address">{{ old('address') }}</textarea>
                                                    <span id="address-error" class="text-danger error-message"></span>
                                                </div>
                                            </div>
                                        </div>

                                    </fieldset>
                                </div>
                                <div class="col-md-5">
                                    <fieldset class="reset">
                                        <legend class="reset">প্রয়োজনীয় ডকুমেন্ট</legend>
                                        <div class="row">
                                            @foreach($planServiceCategory->supportingDocumentItems as $supportingDocumentItem)
                                                @php
                                                    $fileTypesArray = json_decode($supportingDocumentItem->supportingDocumentCategory->file_types);
                                                   // Replace "image" with ".jpg,.png,.jpeg"
                                                    if (($key = array_search('image', $fileTypesArray)) !== false) {
                                                        unset($fileTypesArray[$key]);
                                                        $fileTypesArray = array_merge($fileTypesArray, ['jpg', 'png', 'jpeg']);
                                                    }
                                                    if (($key = array_search('word', $fileTypesArray)) !== false) {
                                                        unset($fileTypesArray[$key]);
                                                        $fileTypesArray = array_merge($fileTypesArray, ['docx', 'doc']);
                                                    }
                                                     if (($key = array_search('excel', $fileTypesArray)) !== false) {
                                                        unset($fileTypesArray[$key]);
                                                        $fileTypesArray = array_merge($fileTypesArray, ['xlsx', 'xls']);
                                                    }

                                                    // Convert array to string
                                                    $fileTypes = implode(',', array_map(function($type) {
                                                        return '.' . $type;
                                                    }, $fileTypesArray));

                                                @endphp
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="supporting_document_{{ $supportingDocumentItem->id }}" class="form-label">{{ $supportingDocumentItem->supportingDocumentCategory->title ?? '' }} ({{ $fileTypes }}) <span class="text-danger ">*</span></label>
                                                        <input type="file" accept="{{ $fileTypes }}" class="form-control" id="supporting_document_{{ $supportingDocumentItem->id }}" name="supporting_document_{{ $supportingDocumentItem->id }}">
                                                        <span class="text-danger error-message" id="supporting_document_{{ $supportingDocumentItem->id }}-error"></span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="flex items-center justify-end mt-4">
                                <button type="button" id="application-form-btn" class="btn btn-primary bg-gradient-primary">সাবমিট করুন</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
        //$("#preloader").fadeIn();
        $(function (){
            $("#ward").change(function () {
                let wardId = $(this).val();
                $('#area').html('<option value="">মহল্লা নির্ধারণ</option>');
                if (wardId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_areas') }}",
                        data: {wardId: wardId}
                    }).done(function (data) {
                        $.each(data, function (index, item) {
                            $('#area').append('<option value="' + item.id + '">' + item.area_name + '</option>');
                        });
                    });
                }
            })


            $('#application-form-btn').click(function() {
                preloaderToggle(true);
                // Create a FormData object
                var formData = new FormData(document.getElementById('application-form'));
                $.ajax({
                    type: 'POST',
                    url: $('#application-form').attr('action'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        preloaderToggle(false);
                        if (response.status){
                            ajaxSuccessMessage(response.message)
                            window.location.href = response.redirect_url;
                        }else{

                            ajaxErrorMessage(response.message)
                        }
                    },
                    error: function(xhr) {
                        preloaderToggle(false);
                        // If the form submission encounters an error
                        // Display validation errors
                        if (xhr.status === 422) {
                            ajaxWarningMessage('Please fill up validate required fields.')
                            let errors = xhr.responseJSON.errors;
                            // Clear previous error messages
                            $('.error-message').text('');
                            $('.form-group').removeClass('has-error');
                            // Update error messages for each field
                            $.each(errors, function(field, errorMessage) {
                                $('#'+field+'-error').text(errorMessage[0]);
                                $('#'+field+'-error').closest('.form-group').addClass('has-error')
                            });
                        }
                    }
                });
            });
        })
    </script>
@endsection
