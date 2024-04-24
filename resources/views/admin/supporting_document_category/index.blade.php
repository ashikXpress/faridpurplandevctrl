@extends('layouts.app')
@section('title','সাপোর্টিং ডকুমেন্ট ক্যাটাগরি')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-default">
                <div class="card-header">
                    <a href="{{ route('supporting-document-category.create') }}" class="btn btn-purple bg-gradient-purple">সাপোর্টিং ডকুমেন্ট ক্যাটাগরি তৈরি করুন</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table id="table" class="table table-bordered">
                            <thead>
                            <tr>
                                <th class="text-center">ক্রমিক</th>
                                <th class="text-center">টাইটেল</th>
                                <th class="text-center">ফাইল টাইপ</th>
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
                ajax: '{{ route('supporting-document-category.datatable') }}',
                "pagingType": "full_numbers",
                columns: [
                    {data: 'sort', name: 'sort',className:'text-center'},
                    {data: 'title', name: 'title'},
                    {data: 'file_types', name: 'file_types'},
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
                            url: "{{ route('supporting-document-category.destroy', ['supporting_document_category' => 'REPLACE_WITH_ID_HERE']) }}".replace('REPLACE_WITH_ID_HERE', id),
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
