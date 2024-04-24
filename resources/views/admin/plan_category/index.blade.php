@extends('layouts.app')
@section('title','প্ল্যান সার্ভিস ক্যাটাগরি')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-default">
                <div class="card-header">
                    <a href="{{ route('plan-service-category.create') }}" class="btn btn-purple bg-gradient-purple">প্ল্যান সার্ভিস ক্যাটাগরি তৈরি করুন</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table id="table" class="table table-bordered">
                            <thead>
                            <tr>
                                <th class="text-center">ক্রমিক</th>
                                <th class="text-center">নাম</th>
                                <th class="text-center">ফিস</th>
                                <th class="text-center">স্টেটাস</th>
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
@endsection

@section('script')
    <script>
        $(function () {
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('plan-service-category.datatable') }}',
                "pagingType": "full_numbers",
                columns: [
                    {data: 'sort', name: 'sort',className:'text-center'},
                    {data: 'name', name: 'name'},
                    {data: 'fees', name: 'fees',
                        render: function(data) {
                            return jsNumberFormat(parseFloat(data).toFixed(2));
                        }
                        ,className:'text-right'
                    },
                    {data: 'status', name: 'status',className:'text-center'},
                    {data: 'action', name: 'action', orderable: false,className:'text-center'},
                ],
                "dom": 'lBfrtip',
                "buttons": datatableExportButton(),
                "responsive": true, "autoWidth": false,"colReorder": true,
            });
            $('body').on('click', '.btn-delete', function () {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        preloaderToggle(true);
                        $.ajax({
                            method: "DELETE",
                            url: "{{ route('plan-service-category.destroy', ['plan_service_category' => 'REPLACE_WITH_ID_HERE']) }}".replace('REPLACE_WITH_ID_HERE', id),
                            data: { id: id }
                        }).done(function( response ) {
                            preloaderToggle(false);
                            if (response.success) {
                                Swal.fire(
                                    'Deleted!',
                                    response.message,
                                    'success'
                                ).then((result) => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: response.message,
                                });
                            }
                        });

                    }
                })

            });
        })
    </script>
@endsection
