<?php

namespace App\Http\Controllers\Frontend;

use App\Enumeration\ServiceOrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\PlanServiceCategory;
use App\Models\PlanServiceCategorySupportingDocumentItem;
use App\Models\PlanServiceOrder;
use App\Models\PlanServiceOrderSupportingDocument;
use App\Models\Ward;
use App\Utility\OnepayUtility;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Ramsey\Uuid\Uuid;

class ApplicationController extends Controller
{
    public function planServiceApplicationForm($planServiceCategory)
    {
        $planServiceCategory = PlanServiceCategory::where('slug',$planServiceCategory)->first();

        if (!$planServiceCategory)
            abort('404');
        $planServiceCategory->load('supportingDocumentItems');

        $wards = Ward::orderBy('ward_no')->get();

        return view('frontend.user.application.service_application_form',compact(
            'planServiceCategory','wards'));
    }
    public function planServiceApplicationFormSubmit($planServiceCategory,Request $request)
    {
        $planServiceCategory = PlanServiceCategory::where('slug',$planServiceCategory)->first();

        if (!$planServiceCategory)
            abort('404');

        $request['nid_no'] = bn2en($request->nid_no);
        $request['mobile_no'] = bn2en($request->mobile_no);
        $request['alternative_mobile_no'] = bn2en($request->alternative_mobile_no);
        $request['existing_plan_no'] = bn2en($request->existing_plan_no);


        $rules = [
            'name' =>['required','max:255'],
            'father_name' =>['required','max:255'],
            'mother_name' =>['required','max:255'],
            'nid_no' =>['required','digits:13'],
            'mobile_no' =>['required','digits:11'],
            'alternative_mobile_no' =>['nullable','digits:11'],
            'address' => 'required|max:500',
            'ward' => 'required',
            'area' => 'required',
        ];
        if($planServiceCategory->is_need_plan_no == 1){
            Validator::extend('existing_plan_no', function ($attribute, $value, $parameters, $validator) {
                // Check if the plan number exists in the plan_service_orders table
                return \App\Models\PlanServiceOrder::where('plan_no', $value)->exists();
            });
            $rules['existing_plan_no'] = 'required|max:255|existing_plan_no';
        }
        foreach($planServiceCategory->supportingDocumentItems as $supportingDocumentItem){
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
                return $type;
            }, $fileTypesArray));

            $rules['supporting_document_'.$supportingDocumentItem->id] = 'required|mimes:'.$fileTypes;
        }
        // Custom error messages
        $customMessages = [
            'name.required' => 'আপনার নাম অবশ্যই পূরণ হবে।',
            'name.max' => 'আপনার নাম অবশ্যই ২৫০ অক্ষরের বেশি হবে না।',
            'father_name.required' => 'পিতার নাম অবশ্যই পূরণ হবে।',
            'father_name.max' => 'পিতার নাম অবশ্যই ২৫০ অক্ষরের বেশি হবে না।',
            'mother_name.required' => 'মাতার নাম অবশ্যই পূরণ হবে।',
            'mother_name.max' => 'মাতার নাম অবশ্যই ২৫০ অক্ষরের বেশি হবে না।',
            'nid_no.required' => 'জাতীয় পরিচয়পত্রের নাম্বার অবশ্যই পূরণ হবে।',
            'nid_no.digits' => 'জাতীয় পরিচয়পত্রের নম্বরটি অবশ্যই ১৩ সংখ্যার হতে হবে।',
            'mobile_no.required' => 'মোবাইল নাম্বার অবশ্যই পূরণ হবে।',
            'mobile_no.digits' => 'মোবাইল নাম্বার অবশ্যই ১১ সংখ্যার হতে হবে।',
            'alternative_mobile_no.digits' => 'বিকল্প মোবাইল নাম্বার অবশ্যই ১১ সংখ্যার হতে হবে।',
            'address.required' => 'সম্পূর্ণ ঠিকানা অবশ্যই পূরণ হবে।',
            'address.max' => 'সম্পূর্ণ ঠিকানা অবশ্যই ২৫০ অক্ষরের বেশি হবে না।',
            'ward.required' => 'ওয়ার্ড নং অবশ্যই নির্ধারণ করতে হবে।',
            'area.required' => 'মহল্লা অবশ্যই নির্ধারণ করতে হবে।',
            ];
        if($planServiceCategory->is_need_plan_no == 1) {
            $customMessages['existing_plan_no.required'] = 'প্লানের নম্বর অবশ্যই পূরণ হবে।';
            $customMessages['existing_plan_no.existing_plan_no'] = 'প্রদত্ত বিদ্যমান প্ল্যান নম্বর আমাদের রেকর্ডে বিদ্যমান নেই।';
            $customMessages['existing_plan_no.max'] = 'প্লানের নম্বর ২৫০ অক্ষরের বেশি হবে না।';
        }
        foreach($planServiceCategory->supportingDocumentItems as $supportingDocumentItem){
            $customMessages['supporting_document_'.$supportingDocumentItem->id.'.required'] = ($supportingDocumentItem->supportingDocumentCategory->title ?? '').' অবশ্যই সংযুক্ত করতে হবে।';
        }
        $request->validate($rules,$customMessages);

        // Start a database transaction
        DB::beginTransaction();

        try {



            $planServiceOrder = new PlanServiceOrder();
            $planServiceOrder->plan_service_category_id = $planServiceCategory->id;
            $planServiceOrder->name = $request->name;
            $planServiceOrder->father_name = $request->father_name;
            $planServiceOrder->mother_name = $request->mother_name;
            $planServiceOrder->nid_no = $request->nid_no;
            $planServiceOrder->mobile_no = $request->mobile_no;
            $planServiceOrder->alternative_mobile_no = $request->alternative_mobile_no;
            $planServiceOrder->address = $request->address;
            $planServiceOrder->area_id = $request->area;
            $planServiceOrder->ward_id = $request->ward;
            $planServiceOrder->user_id = auth()->id();
            $planServiceOrder->status = ServiceOrderStatus::PENDING;
            $planServiceOrder->fees = $planServiceCategory->fees;


            if ($request->existing_plan_no){
                $checkPlanServiceOrder = PlanServiceOrder::where('plan_no',$request->existing_plan_no)
                    ->first();
                $planServiceOrder->existing_plan_service_order_id = $checkPlanServiceOrder->id;
            }

            $planServiceOrder->save();
            $planServiceOrder->pso_no = 'PSO-'.date('Ymd').$planServiceOrder->id;
            if ($planServiceCategory->main_service == 1){
                $planServiceOrder->plan_no = date('Ymd').$planServiceOrder->id;
            }
            $planServiceOrder->save();

            foreach($planServiceCategory->supportingDocumentItems as $supportingDocumentItem){
                    $attachmentFile = $request->file('supporting_document_'.$supportingDocumentItem->id);
                    $filename = date('Ymdhis').'_'.Uuid::uuid1()->toString().'.'. $attachmentFile->extension();
                    $destinationPath = public_path('uploads/application_supporting_documents/'.date('Y'));
                    $attachmentFile->move($destinationPath, $filename);
                    $path ='uploads/application_supporting_documents/'.date('Y').'/'. $filename;

                    $supportingDocument = new PlanServiceOrderSupportingDocument();
                    $supportingDocument->plan_service_order_id = $planServiceOrder->id;
                    $supportingDocument->supporting_document_category_id = $supportingDocumentItem->supporting_document_category_id;
                    $supportingDocument->file_path = $path;
                    $supportingDocument->save();

            }

            // Commit the transaction
            DB::commit();

            // Redirect to the index page with a success message
            return response()->json([
                'status'=>true,
                'redirect_url'=>route('dashboard'),
                'message'=>$planServiceCategory->name.' আবেদন সফলভাবে গৃহীত করা হয়েছে।',
            ]);
        } catch (\Exception $e) {
            // Roll back the transaction in case of an error
            DB::rollback();

            // Handle the error and redirect with an error message
            return response()->json([
                'status'=>false,
                'message'=>'আবেদন গৃহীত করার সময় একটি ত্রুটি ঘটেছে : '.$e->getMessage(),
            ]);
        }



    }

    public function getAreas(Request $request)
    {
        $areas = Area::where('ward_id',$request->wardId)->get();
        return response()->json($areas);

    }
}
