@extends('layouts.app')
@section('title','ড্যাশবোর্ড')
@section('style')
    <style>
        #chartContainer {
            width: 100%; /* Ensure the container fills the full width of its parent */
        }
    </style>
@endsection
@section('content')
    <div class="row justify-content-md-center">
        <div class="col-md">
            <a href="{{ route('area.index') }}" class="info-box mb-3">
                <span class="info-box-icon bg-gradient-info elevation-1"><i class="fas fa-list-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">মহল্লা</span>
                    <span class="info-box-number">{{ en2bn(number_format($areasCount)) }}</span>
                </div>

            </a>
        </div>
        <div class="col-md">
            <a href="{{ route('supporting-document-category.index') }}" class="info-box mb-3">
                <span class="info-box-icon bg-gradient-primary elevation-1"><i class="fas fa-list-ul"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">সাপোর্টিং ডকুমেন্ট ক্যাটাগরি</span>
                    <span class="info-box-number">{{ en2bn(number_format($supportingDocumentCategoryCount)) }}</span>
                </div>

            </a>
        </div>
        <div class="col-md">
            <a href="{{ route('plan-service-category.index') }}" class="info-box mb-3">
                <span class="info-box-icon bg-gradient-purple elevation-1"><i class="fas fa-th-list"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">প্ল্যান সার্ভিস ক্যাটাগরি</span>
                    <span class="info-box-number">{{ en2bn(number_format($planServiceCategoryCount)) }}</span>
                </div>

            </a>
        </div>
        <div class="col-md">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-gradient-success elevation-1"><i class="fas fa-user-friends"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">আবেদনকারী</span>
                    <span class="info-box-number">{{ en2bn(number_format($usersCount)) }}</span>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header  bg-gradient-yellow text-center">
                    <div class="card-title text-white">নতুন আবেদনের তালিকা</div>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tbody>
                        @foreach($planServiceCategories as $planServiceCategory)
                            <tr>
                                <td class="text-left"><a href="{{ route('plan_service_order',['planServiceCategory'=>$planServiceCategory->id,'status'=>\App\Enumeration\ServiceOrderStatus::PENDING]) }}">{{ $planServiceCategory->name }}</a></td>
                                <td width="20%" class="text-center"><span class="right badge badge-warning text-white">{{ en2bn(number_format($planServiceCategory->planServiceOrders->where('status',\App\Enumeration\ServiceOrderStatus::PENDING)->count())) }}</span></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <ul>

            </ul>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header  bg-gradient-success">
                    <div class="card-title  text-center">অনুমোদিত আবেদনের তালিকা</div>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                            <tbody>
                            @foreach($planServiceCategories as $planServiceCategory)
                                <tr>
                                    <td class="text-left"><a href="{{ route('plan_service_order',['planServiceCategory'=>$planServiceCategory->id,'status'=>\App\Enumeration\ServiceOrderStatus::APPROVED]) }}">{{ $planServiceCategory->name }}</a></td>
                                    <td width="20%" class="text-center"><span class="right badge badge-success text-white">{{ en2bn(number_format($planServiceCategory->planServiceOrders->where('status',\App\Enumeration\ServiceOrderStatus::APPROVED)->count())) }}</span></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
            <ul>

            </ul>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-gradient-danger">
                    <div class="card-title text-center">বাতিল আবেদনের তালিকা</div>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tbody>
                        @foreach($planServiceCategories as $planServiceCategory)
                            <tr>
                                <td class="text-left"><a href="{{ route('plan_service_order',['planServiceCategory'=>$planServiceCategory->id,'status'=>\App\Enumeration\ServiceOrderStatus::REJECTED]) }}">{{ $planServiceCategory->name }}</a></td>
                                <td width="20%" class="text-center"><span class="right badge badge-danger text-white">{{ en2bn(number_format($planServiceCategory->planServiceOrders->where('status',\App\Enumeration\ServiceOrderStatus::REJECTED)->count())) }}</span></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <ul>

            </ul>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-9 order-xs-1">
                            <div class="card-title">
                                আবেদনের পরিসংখ্যান
                            </div>
                        </div>
                        <div class="col-md-3 order-xs-2">
                            <form action="{{ route('dashboard') }}" id="dashboard_year_form" method="get">
                                <div class="form-group mb-0">
                                    <select name="dashboard_year" class="form-control select2" id="dashboard_year">
                                        @for($i = 2024;$i <= date('Y');$i++)
                                            <option {{ request('dashboard_year',date('Y')) == $i ? 'selected' : '' }} value="{{ $i }}">{{ en2bn($i) }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <div id="chartContainer">
                        <canvas id="transactionChart"></canvas>
                    </div>
                </div>
                <div class="card-header">
                    <div class="card-title">
                        আদায়কৃত টাকার পরিসংখ্যান
                    </div>
                </div>
                <div class="card-body">
                    <div id="chartContainer2">
                        <canvas id="transactionChart2"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function() {
            // Listen for changes in the dropdown
            $('#dashboard_year').on('change', function() {
                $('#dashboard_year_form').submit();
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            // Dynamically adjust canvas width based on its container size
            const canvas = document.getElementById('transactionChart');
            const context = canvas.getContext('2d');
            const container = document.getElementById('chartContainer');

            // Set canvas dimensions based on its container's width
            canvas.width = container.clientWidth;
            canvas.height = 400; // Set a fixed height or adjust dynamically if needed

            // Transaction data by month
            const transactionData = @json($transactionData);

            // Extract month names and counts
            const months = transactionData.map(data => data.month);

            // Create datasets for each status
            const pendingData = transactionData.map(data => data.pending);
            const approvedData = transactionData.map(data => data.approved);
            const rejectedData = transactionData.map(data => data.rejected);

            // Create chart
            const transactionChart = new Chart(context, {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [
                        {
                            label: 'অনুমোদন অপেক্ষারত',
                            data: pendingData,
                            borderColor: '#ffc107', // Set color for pending line
                            tension: 0.4, // Adjust the curve tension
                            fill: true,
                        },
                        {
                            label: 'অনুমোদিত',
                            data: approvedData,
                            borderColor: '#28a745', // Set color for approved line
                            tension: 0.4, // Adjust the curve tension
                            fill: true,
                        },
                        {
                            label: 'অননুমোদিত',
                            data: rejectedData,
                            borderColor: '#dc3545', // Set color for rejected line
                            tension: 0.4, // Adjust the curve tension
                            fill: true,
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
            // Dynamically adjust canvas width based on its container size
            const canvas = document.getElementById('transactionChart2');
            const context = canvas.getContext('2d');
            const container = document.getElementById('chartContainer2');

            // Set canvas dimensions based on its container's width
            canvas.width = container.clientWidth;
            canvas.height = 400; // Set a fixed height or adjust dynamically if needed

            // Transaction data by month
            const transactionData = @json($transactionFeesData);

            // Extract month names and counts
            const months = transactionData.map(data => data.month);

            // Create datasets for each status
            const collect_fees = transactionData.map(data => data.collect_fees);

            // Create chart
            const transactionChart = new Chart(context, {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [
                        {
                            label: 'আদায়কৃত টাকা',
                            data: collect_fees,
                            borderColor: '#28a745', // Set color for approved line
                            tension: 0.4, // Adjust the curve tension
                            fill: true,
                        },
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endsection
