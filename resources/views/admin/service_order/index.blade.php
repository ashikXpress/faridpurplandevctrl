@extends('layouts.app')
@section('title',$planServiceCategory->name)
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card {{ $cardBg }}">
                <div class="card-header">
                    <div class="card-title">{{ $planServiceCategory->name }} এর {{ $statusName }} তালিকা</div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table" class="table table-bordered">
                            <thead>
                            <tr>
                                <th class="text-center">created_at</th>
                                <th class="text-center">তারিখ/সময়</th>
                                <th class="text-center">আবেদনকারীর নাম</th>
                                <th class="text-center">পিতার নাম</th>
                                <th class="text-center">মাতার নাম</th>
                                <th class="text-center">মোবাইল নাম্বার</th>
                                <th class="text-center">বিকল্প মোবাইল নাম্বার</th>
                                <th class="text-center">ওয়ার্ড নং</th>
                                <th class="text-center">মহল্লা</th>
                                <th class="text-center">ঠিকানা</th>
                                <th class="text-center">সার্ভিস অর্ডার নাম্বার</th>
                                <th class="text-center">প্ল্যান নাম্বার</th>
                                <th class="text-center">ফিস</th>
                                <th class="text-center">স্টেটাস</th>
                                <th class="text-center">ডকুমেন্ট</th>
                                <th class="text-center">অ্যাকশন</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-status-change" data-backdrop="static">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header"  id="modal-bg">
                    <h4 class="modal-title" id="modal-status-title">Approve Information</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="plan-service-order-status-form" method="POST"
                          action="{{ route('plan_service_application_status_change') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="hidden" id="plan_service_order_id" name="plan_service_order_id">
                                    <input type="hidden" id="current_status" name="current_status">
                                    <input type="hidden" id="next_status" name="next_status">
                                    <label for="remarks">মন্তব্য</label>
                                    <textarea class="form-control" name="remarks" id="remarks"></textarea>
                                    <span class="text-danger error-message" id="remarks-error"></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger bg-gradient-danger" data-dismiss="modal"><i class="fa fa-times"></i></button>
                    <button type="button" id="btn-status-save" class="btn btn-purple bg-gradient-purple">
                        Approved
                    </button>
                </div>
            </div>

        </div>

    </div>

@endsection

@section('script')
    <script>
        $(function () {
            //Declined
            $('body').on('click', '.btn-status-change', function(){
                $('.error-message').text(' ');
                preloaderToggle(true);
                $('#plan_service_order_id').val($(this).data('id'));
                $('#current_status').val($(this).data('current_status'));
                let nextStatus = $(this).data('next_status');
                 $('#next_status').val(nextStatus);
                 console.log(nextStatus);
                let modal_title = '';
                let modal_save_title = '';
                let modal_bg = '';
                if (nextStatus == '{{ \App\Enumeration\ServiceOrderStatus::APPROVED }}'){
                    modal_title = 'অনুমোদনের জন্য তথ্য';
                    modal_save_title = 'অনুমোদন করুণ';
                     modal_bg = 'bg-gradient-success';
                    $("#modal-bg").removeClass('bg-gradient-danger');
                }else if(nextStatus == '{{ \App\Enumeration\ServiceOrderStatus::REJECTED }}'){
                    modal_title = 'বাতিলের জন্য তথ্য';
                    modal_save_title = 'বাতিল করুণ';
                    modal_bg = 'bg-gradient-danger';
                    $("#modal-bg").removeClass('bg-gradient-success');
                }


                $("#modal-bg").addClass(modal_bg);
                $("#modal-status-title").text(modal_title);
                $("#btn-status-save").text(modal_save_title);
                $("#modal-status-change").modal('show');
                preloaderToggle(false);

            })
            $('#btn-status-save').click(function () {
                preloaderToggle(true);
                $('.error-message').text(' ');
                $.ajax({
                    type: 'POST',
                    url: $('#plan-service-order-status-form').attr('action'),
                    data: $('#plan-service-order-status-form').serialize(),
                    success: function (response) {
                        preloaderToggle(false);
                        if (response.status) {
                            $("#modal-status-change").modal('hide');
                            Swal.fire({
                                position: "top",
                                icon: response.service_order_status == '{{ \App\Enumeration\ServiceOrderStatus::REJECTED }}' ? 'danger' : "success",
                                title: response.message,
                                showConfirmButton: false,
                                timer: 1500,
                                customClass: {
                                    popup: 'swal2-popup-centered' // Adding a custom class for positioning
                                }
                            });
                            setTimeout(function () {
                                location.reload()
                            }, 2000); // 2000 milliseconds = 2 seconds

                        } else {
                            ajaxErrorMessage(response.message);
                        }
                    },
                    error: function (xhr) {
                        preloaderToggle(false);
                        // If the form submission encounters an error
                        // Display validation errors
                        if (xhr.status === 422) {
                            ajaxWarningMessage('Please fill up validate required fields.');
                            let errors = xhr.responseJSON.errors;
                            // Clear previous error messages
                            $('.error-message').text(' ');
                            // Update error messages for each field
                            $.each(errors, function (field, errorMessage) {
                                $('#' + field + '-error').text(errorMessage[0]);
                            });
                        }
                    }
                });
            });


            $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('plan_service_order.datatable') }}",
                    data: function (d) {
                        d.plan_service_category_id = {{ $planServiceCategory->id }}
                        d.status = {{ $status }}
                    }
                },
                "pagingType": "full_numbers",
                columns: [
                    {data: 'created_at', name: 'created_at',visible:false},
                    {data: 'created_at_edit', name: 'created_at_edit'},
                    {data: 'name', name: 'name'},
                    {data: 'father_name', name: 'father_name'},
                    {data: 'mother_name', name: 'mother_name'},
                    {data: 'mobile_no',name: 'mobile_no',render: function(data) {
                            return en2bn(data);
                        }
                    },
                    {data: 'alternative_mobile_no',name: 'alternative_mobile_no',render: function(data) {
                            return en2bn(data);
                        }
                    },
                    {
                        data: 'ward_no',
                        name: 'ward.ward_no',
                        render: function(data) {
                            return en2bn(data);
                        },className: 'text-center'
                    },

                    {data: 'area_name', name: 'area.area_name'},
                    {data: 'address', name: 'address'},
                    {data: 'pso_no',name: 'pso_no',render: function(data) {
                            return en2bn(data);
                        }
                    },
                    {data: 'plan_no',name: 'plan_no',render: function(data) {
                            return en2bn(data);
                        }
                    },
                    {data: 'fees', name: 'fees',
                        render: function(data) {
                            return en2bn(jsNumberFormat(parseFloat(data).toFixed(2)));
                        }
                        ,className:'text-right'
                    },
                    {data: 'status', name: 'status',className:'text-center'},
                    {data: 'supporting_documents', name: 'supporting_documents',className:'text-left'},
                    {data: 'action', name: 'action', orderable: false,className:'text-center'},
                ],
                "dom": 'lBfrtip',
                "buttons": datatableExportButton(),
                "responsive": false, "autoWidth": false,"colReorder": true,
            });

        })
    </script>
@endsection
