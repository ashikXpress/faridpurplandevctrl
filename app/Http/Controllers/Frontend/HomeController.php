<?php

namespace App\Http\Controllers\Frontend;

use App\Enumeration\Role;
use App\Http\Controllers\Controller;
use App\Models\PlanServiceCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function dashboardRedirect()
    {
        if (auth()->check()){
            if (auth()->user()->role == Role::$ADMIN){
                return redirect()->route('dashboard');
            }elseif (auth()->user()->role == Role::$USER){
                return redirect()->route('user_dashboard');
            }else{
                dd('dashboardRedirect Methods');
            }
        }else{
            return redirect()->route('home');
        }
    }
    public function home()
    {
        $planServiceCategories = PlanServiceCategory::where('main_service',0)->orderBy('sort')->where('status',1)->get();
        $mainPlanService = \App\Models\PlanServiceCategory::where('main_service',1)
            ->where('status',1)
            ->first();
        return view('frontend.home',compact('planServiceCategories','mainPlanService'));
    }
}
