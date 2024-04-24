@extends('layouts.app')
@section('title','প্ল্যান সার্ভিস ক্যাটাগরি সাপোর্টিং ডকুমেন্টেশন অ্যাড করুন')
@section('content')
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">প্ল্যান সার্ভিস ক্যাটাগরি সাপোর্টিং ডকুমেন্টেশন অ্যাডের তথ্য</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form enctype="multipart/form-data" action="{{ route('add-plan-service-category-supporting-document-items',['planServiceCategory'=>$planServiceCategory->id]) }}" class="form-horizontal" method="post">
                    @csrf
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th class="text-center">ক্রমিক</th>
                                <th width="5%" class="text-center">স্টেটাস</th>
                                <th width="8%" class="text-center">ক্রম</th>
                                <th class="text-center">সাপোর্টিং ডকুমেন্ট টাইটেল</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($supportingDocumentCategories as $supportingDocumentCategory)
                                @php
                                    $supportingDocumentItem = \App\Models\PlanServiceCategorySupportingDocumentItem::
                                            where('supporting_document_category_id',$supportingDocumentCategory->id)
                                                ->where('plan_service_category_id',$planServiceCategory->id)
                                                ->first();
                                    //dd($supportingDocumentItem,$supportingDocumentCategory->id,$planServiceCategory->id);
                                @endphp
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">
                                        <div class="icheck-success">
                                            <input type="checkbox" {{ !$supportingDocumentItem ? '' : 'checked' }}  name="status[]" onchange="toggleSortInput(this)" id="for_label_{{ $supportingDocumentCategory->id }}" value="{{ $supportingDocumentCategory->id }}">
                                            <label for="for_label_{{ $supportingDocumentCategory->id }}"></label>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <input type="number" {{ !$supportingDocumentItem ? 'readonly' : '' }} value="{{ $loop->iteration }}" name="sort[]" class="form-control text-center">
                                    </td>

                                    <td>{{ $supportingDocumentCategory->title }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-purple bg-gradient-purple">সংরক্ষণ করা করুন</button>
                        <a href="{{ route('plan-service-category.index') }}" class="btn btn-danger bg-gradient-danger float-right">বাতিল</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
            <!-- /.card -->
        </div>
        <!--/.col (left) -->
    </div>
@endsection

@section('script')
    <script>
        function toggleSortInput(checkbox) {
            // Get the parent row of the checkbox
            var row = checkbox.closest('tr');

            // Find the sort input field within the row
            var sortInput = row.querySelector('input[name="sort[]"]');

            // Toggle the readonly attribute based on checkbox status
            sortInput.readOnly = !checkbox.checked;
        }
    </script>
@endsection
