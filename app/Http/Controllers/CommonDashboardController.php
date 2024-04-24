<?php

namespace App\Http\Controllers;

use App\Enumeration\Role;
use App\Enumeration\ServiceOrderStatus;
use App\Models\Area;
use App\Models\PlanServiceCategory;
use App\Models\PlanServiceOrder;
use App\Models\SupportingDocumentCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CommonDashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        if (auth()->user()->role == Role::$USER){
            $serviceOrders = PlanServiceOrder::with('planServiceCategory','planServiceOrder')
                ->where('user_id',auth()->id())
                ->orderBy('created_at','desc')
                ->simplePaginate(10);

            return view('frontend.user.dashboard',compact('serviceOrders'));
        }else{
            $planServiceCategories = PlanServiceCategory::with('planServiceOrders')->where('status',1)->orderBy('sort')->get();
            $areasCount = Area::count();
            $supportingDocumentCategoryCount = SupportingDocumentCategory::count();
            $planServiceCategoryCount = PlanServiceCategory::count();
            $usersCount = User::where('role',Role::$USER)->count();

            $transactionData = [];
            $transactionFeesData = [];
            for ($i = 1; $i <= 12; $i++) {
                // Get the month name
                $monthName = Carbon::create(null, $i, 1)->format('F');

                // Get the year
                $year =  $request->dashboard_year ?? Carbon::now()->year;

                // Fetch pending, approved, and rejected counts for the current month
                $pendingCount = PlanServiceOrder::where('status', ServiceOrderStatus::PENDING)
                    ->whereMonth('created_at', $i)  // Filter by the current month
                    ->whereYear('created_at', $year) // Filter by the current year
                    ->count();

                $approvedCount = PlanServiceOrder::where('status', ServiceOrderStatus::APPROVED)
                    ->whereMonth('approved_at', $i) // Filter by the current month
                    ->whereYear('approved_at', $year) // Filter by the current year
                    ->count();

                $rejectedCount = PlanServiceOrder::where('status', ServiceOrderStatus::REJECTED)
                    ->whereMonth('rejected_at', $i) // Filter by the current month
                    ->whereYear('rejected_at', $year) // Filter by the current year
                    ->count();


                $collectFees = PlanServiceOrder::where('payment_status',0)
                    ->whereMonth('created_at', $i) // Filter by the current month
                    ->whereYear('created_at', $year) // Filter by the current year
                    ->sum('fees');

                // Add the data for the current month to the transactionData array

                $transactionFeesData[] = [
                    'month' => en2bnMonth($monthName),
                    'collect_fees' => $collectFees,
                ];
                $transactionData[] = [
                    'month' => en2bnMonth($monthName),
                    'pending' => $pendingCount,
                    'approved' => $approvedCount,
                    'rejected' => $rejectedCount,
                ];

            }


            return view('dashboard',compact('planServiceCategories',
            'supportingDocumentCategoryCount','planServiceCategoryCount','usersCount','areasCount',
            'transactionData','transactionFeesData'));
        }
    }
}
