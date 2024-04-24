<?php

namespace App\Http\Controllers\Admin;

use App\Enumeration\ServiceOrderStatus;
use App\Http\Controllers\Controller;
use App\Models\PlanServiceCategory;
use App\Models\PlanServiceOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PlanServiceOrderController extends Controller
{
    public function index($planServiceCategory,$status)
    {
        $planServiceCategory = PlanServiceCategory::where('id',$planServiceCategory)->first();

        if ($status == ServiceOrderStatus::PENDING){
            $statusName = 'অপেক্ষমান';
            $cardBg = 'card-warning';
        }elseif($status == ServiceOrderStatus::APPROVED){
            $statusName = 'অনুমোদিত';
            $cardBg = 'card-success';
        }elseif($status == ServiceOrderStatus::REJECTED){
            $statusName = 'বাতিল';
            $cardBg = 'card-danger';
        }else{
            $statusName = 'অজানা';
            $cardBg = 'card-default';
        }

        return view('admin.service_order.index',compact('planServiceCategory',
            'status','statusName','cardBg'));
   }
    public function dataTable()
    {
        $query = PlanServiceOrder::with('user','area','ward','planServiceOrderSupportingDocuments',
            'planServiceOrderSupportingDocuments.supportingDocumentCategory');

        if (request('plan_service_category_id') != ''){
            $query->where('plan_service_category_id',request('plan_service_category_id'));
        }
        if (request('status') != ''){
            $query->where('status',request('status'));
        }

        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function(PlanServiceOrder $planServiceOrder) {
                $btn = '';
                if ($planServiceOrder->status == ServiceOrderStatus::PENDING){
                    $btn .= ' <a role="button" data-id="' . $planServiceOrder->id . '" data-current_status="'.$planServiceOrder->status.'" data-next_status="'.ServiceOrderStatus::APPROVED.'" class="btn btn-success bg-gradient-success btn-sm btn-status-change">অনুমোদন</a>';
                    $btn .= ' <a role="button" data-id="' . $planServiceOrder->id . '" data-current_status="'.$planServiceOrder->status.'" data-next_status="'.ServiceOrderStatus::REJECTED.'" class="btn btn-danger bg-gradient-danger btn-sm btn-status-change">বাতিল</a>';
                }
                $btn .= ' <a href="#" class="btn btn-purple bg-gradient-purple btn-sm"><i class="fa fa-info-circle"></i></a>';
                return $btn;
            })
            ->addColumn('created_at_edit', function(PlanServiceOrder $planServiceOrder) {
                return en2bnTime($planServiceOrder->created_at->format('d-m-Y, H:i A'));
            })
            ->addColumn('user_name', function(PlanServiceOrder $planServiceOrder) {
                return $planServiceOrder->user->name ?? '';
            })
            ->addColumn('ward_no', function(PlanServiceOrder $planServiceOrder) {
                return $planServiceOrder->ward->ward_no ?? '';
            })
            ->addColumn('area_name', function(PlanServiceOrder $planServiceOrder) {
                return $planServiceOrder->area->area_name ?? '';
            })
             ->addColumn('supporting_documents', function(PlanServiceOrder $planServiceOrder) {
                 $elements = '<ol style="padding-left: 15px">';
                    foreach ($planServiceOrder->planServiceOrderSupportingDocuments as $supportingDocument){
                        $elements .= '<li><a download href="'.asset($supportingDocument->file_path).'">'.($supportingDocument->supportingDocumentCategory->title ?? '').'</a></li>';
                    }
                 $elements .= '</ol>';
                return $elements;
            })
            ->addColumn('status', function(PlanServiceOrder $planServiceOrder) {
                if ($planServiceOrder->status == ServiceOrderStatus::PENDING)
                    return '<span class="badge bg-gradient-warning">অপেক্ষমান</span>';
                elseif($planServiceOrder->status == ServiceOrderStatus::APPROVED)
                    return '<span class="badge bg-gradient-success">অনুমোদিত</span>';
                elseif($planServiceOrder->status == ServiceOrderStatus::REJECTED)
                    return '<span class="badge bg-gradient-danger">বাতিল</span>';

            })
            ->rawColumns(['action','status','supporting_documents'])
            ->toJson();
    }

    public function planServiceApplicationStatusChange(Request $request)
    {
        $rules = [
            'remarks' => 'nullable|max:255',
            'plan_service_order_id' => 'required',
            'current_status' => 'required',
            'next_status' => 'required',
        ];

        $request->validate($rules);

        // Start a database transaction
        DB::beginTransaction();

        try {

            $planServiceOrder = PlanServiceOrder::where('id',$request->plan_service_order_id)
                ->where('status',$request->current_status)
                ->first();
            $successMsg = '';
            $planServiceOrder->status = $request->next_status;
            if ($request->next_status == ServiceOrderStatus::APPROVED){
                $planServiceOrder->approved_remarks = $request->remarks;
                $planServiceOrder->approved_user_id = auth()->id();
                $planServiceOrder->approved_at = Carbon::now();
                $successMsg = 'আবেদনটি অনুমোদন করা হয়েছে।';
            }elseif($request->next_status == ServiceOrderStatus::REJECTED){
                $planServiceOrder->rejected_remarks = $request->remarks;
                $planServiceOrder->rejected_user_id = auth()->id();
                $planServiceOrder->rejected_at = Carbon::now();
                $successMsg = 'আবেদনটি বাতিল করা হয়েছে।';
            }
            $planServiceOrder->save();

            // Commit the transaction
            DB::commit();

            // Redirect to the index page with a success message
            return response()->json([
                'status'=>true,
                'service_order_status'=> $planServiceOrder->status,
                'message'=>($planServiceOrder->planServiceCategory->name ?? '').' '.$successMsg,
            ]);
        } catch (\Exception $e) {
            // Roll back the transaction in case of an error
            DB::rollback();

            // Handle the error and redirect with an error message
            return response()->json([
                'status'=>false,
                'message'=>'আবেদন হালনাগাদ করার সময় একটি ত্রুটি ঘটেছে : '.$e->getMessage(),
            ]);
        }
    }
}
