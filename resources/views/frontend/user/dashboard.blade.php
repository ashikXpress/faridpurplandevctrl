@extends('layouts.frontend')
@section('title','ড্যাশবোর্ড')
@section('content')
    <section class="other-services" style="min-height: 70vh">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-left">
                    <h2 class="other-services-section-title">ড্যাশবোর্ড</h2>
                </div>
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th class="text-center">ক্রমিক</th>
                                <th class="text-center">তারিখ</th>
                                <th class="text-center">সার্ভিস ওডার নাম্বার</th>
                                <th class="text-center">প্ল্যান নাম্বার</th>
                                <th class="text-center">সার্ভিসের নাম</th>
                                <th class="text-center">ফিস</th>
                                <th class="text-center">স্টেটাস</th>
                                <th class="text-center">অ্যাকশন</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($serviceOrders as $serviceOrder)
                                <tr>
                                    <td class="text-center">{{ en2bn($loop->iteration) }}</td>
                                    <td class="text-center">{{ en2bnTime($serviceOrder->created_at->format('d-m-Y, H:i:s A')) }}</td>
                                    <td class="text-center">{{ en2bn($serviceOrder->pso_no) }}</td>
                                    <td class="text-center">
                                        {{ en2bn($serviceOrder->plan_no) }}
                                        {{ en2bn($serviceOrder->planServiceOrder->plan_no ?? '') }}
                                    </td>
                                    <td class="text-center">{{ en2bn($serviceOrder->planServiceCategory->name ?? '') }}</td>
                                    <td class="text-center">{{ en2bn(number_format($serviceOrder->fees)) }}</td>
                                    <td class="text-center">
                                        @if($serviceOrder->payment_status == 0)
                                            <span class="badge rounded-pill bg-danger">পেমেন্ট অসম্পূর্ণ</span>
                                        @else
                                            @if($serviceOrder->status == \App\Enumeration\ServiceOrderStatus::PENDING)
                                                <span class="badge bg-gradient-warning">অপেক্ষমান</span>
                                             @elseif($serviceOrder->status == \App\Enumeration\ServiceOrderStatus::APPROVED)
                                                    <span class="badge bg-gradient-success">অনুমোদিত</span>
                                            @elseif($serviceOrder->status == \App\Enumeration\ServiceOrderStatus::REJECTED)
                                                <span class="badge bg-gradient-danger">বাতিল</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($serviceOrder->payment_status == 0)
                                            <a href="" class="btn btn-warning bg-gradient-warning btn-sm">পেমেন্ট করুন</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-center" colspan="8">{{ $serviceOrders->links() }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
