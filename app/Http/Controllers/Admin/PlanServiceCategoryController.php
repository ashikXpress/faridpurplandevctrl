<?php

namespace App\Http\Controllers\Admin;

use App\Models\PlanServiceCategory;
use App\Models\PlanServiceCategorySupportingDocumentItem;
use App\Models\PlanServiceOrder;
use App\Models\SupportingDocumentCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class PlanServiceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return view('admin.plan_category.index');
    }
    public function dataTable()
    {
        $query = PlanServiceCategory::query();
        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function(PlanServiceCategory $planCategory) {
                $isSupportingDocuments = count($planCategory->supportingDocumentItems);
                $btn = '';
                $btn .= ' <a href="' . route('add-plan-service-category-supporting-document-items', ['planServiceCategory' => $planCategory->id]) . '" class="btn btn-purple bg-gradient-purple btn-sm"><i class="'.($isSupportingDocuments > 0 ? 'fa fa-edit' :'fa fa-plus').'"></i> '.($isSupportingDocuments > 0 ? 'সাপোর্টিং ডকুমেন্ট ক্যাটাগরি সম্পাদনা করুন' : 'সাপোর্টিং ডকুমেন্ট ক্যাটাগরি যোগ করুন').'</a>';
                $btn .= ' <a href="' . route('plan-service-category.edit', ['plan_service_category' => $planCategory->id]) . '" class="btn btn-purple bg-gradient-purple btn-sm btn-edit"><i class="fa fa-edit"></i></a>';
                $btn .= ' <a role="button" data-id="' . $planCategory->id . '" class="btn btn-danger btn-sm btn-delete"><i class="fa fa-trash"></i></a>';

                return $btn;
            })
            ->addColumn('status', function(PlanServiceCategory $planCategory) {
                if ($planCategory->status == 1)
                    return '<span class="badge badge-success">সক্রিয়</span>';
                else
                    return '<span class="badge badge-danger">নিষ্ক্রিয়</span>';

            })
            ->rawColumns(['action','status'])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $maxSort = en2bn(PlanServiceCategory::max('sort') + 1);

        return view('admin.plan_category.create',compact('maxSort'));
    }

    public function store(Request $request)
    {
        $request['fees'] = bn2en($request->fees);
        $request['sort'] = bn2en($request->sort);
        // Validate the request data
        $validatedData = $request->validate([
            'name' =>[
                'required','max:255',
                Rule::unique('plan_service_categories')
                ],
            'fees' => 'required|numeric', // Ensure 'status' is boolean
            'sort' => 'required|integer', // Ensure 'status' is boolean
            'status' => 'required|boolean', // Ensure 'status' is boolean
        ]);
        // Start a database transaction
        DB::beginTransaction();

        try {

            // Create a new User record in the database
            $validatedData['user_id'] = auth()->id();
            $validatedData['slug'] = Str::slug($request->name);
            $user = PlanServiceCategory::create($validatedData);
            // Commit the transaction
            DB::commit();
            // Redirect to the index page with a success message
            return redirect()->route('plan-service-category.index')->with('success', 'Plan service category created successfully');
        } catch (\Exception $e) {
            // Roll back the transaction in case of an error
            DB::rollback();
            // Handle the error and redirect with an error message
            return redirect()->route('plan-service-category.create')->withInput()
                ->with('error', 'An error occurred while creating the plan category : '.$e->getMessage());
        }
    }

    public function edit(PlanServiceCategory $plan_service_category)
    {

        return view('admin.plan_category.edit',compact('plan_service_category'));
    }

    public function update(PlanServiceCategory $plan_service_category,Request $request)
    {
        // Validate the request data
        $request['fees'] = bn2en($request->fees);
        $request['sort'] = bn2en($request->sort);
        $validatedData = $request->validate([
            'name' =>[
                'required','max:255',
                Rule::unique('plan_service_categories')
                ->ignore($plan_service_category)
            ],
            'sort' => 'required|integer', // Ensure 'status' is boolean
            'fees' => 'required|numeric', // Ensure 'status' is boolean
            'status' => 'required|boolean', // Ensure 'status' is boolean
        ]);
        // Start a database transaction
        DB::beginTransaction();

        try {

            // Create a new User record in the database
            $validatedData['slug'] = Str::slug($request->name);
            $validatedData['alter_user_id'] = auth()->id();
            $plan_service_category->update($validatedData);
            // Commit the transaction
            DB::commit();

            // Redirect to the index page with a success message
            return redirect()->route('plan-service-category.index')->with('success', 'Plan service category updated successfully');
        } catch (\Exception $e) {
            // Roll back the transaction in case of an error
            DB::rollback();

            // Handle the error and redirect with an error message
            return redirect()->route('plan_category.edit',['plan_category'=>$plan_service_category->id])->with('error', 'An error occurred while updating the plan service category : '.$e->getMessage());
        }
    }
    public function destroy(PlanServiceCategory $plan_service_category)
    {
        try {
            $planServiceOrder = PlanServiceOrder::
            where('plan_service_category_id',$plan_service_category->id)
                ->first();

            if ($planServiceOrder){
                return response()->json(['success'=>false,'message' => "Can't delete, plan service category has service order"], Response::HTTP_OK);

            }
            // Delete the User record
            $plan_service_category->delete();
            // Return a JSON success response
            return response()->json(['success'=>true,'message' => 'Plan service category deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            // Handle any errors, such as record not found
            return response()->json(['success'=>false,'message' => 'Plan service category not found: '.$e->getMessage()], Response::HTTP_OK);

        }
    }

    public function addSupportingDocumentItems(PlanServiceCategory $planServiceCategory)
    {
        $supportingDocumentCategories = SupportingDocumentCategory::orderBy('sort')->where('status',1)->get();
        return view('admin.plan_category.add_document_categories',compact('planServiceCategory',
        'supportingDocumentCategories'));
    }
    public function addSupportingDocumentItemsPost(PlanServiceCategory $planServiceCategory,Request $request)
    {
        // Start a database transaction
        DB::beginTransaction();

        try {
            if ($request->status){
                PlanServiceCategorySupportingDocumentItem::where('plan_service_category_id',$planServiceCategory->id)
                            ->delete();

                $counter = 0;
                foreach ($request->status as $reqStatus){
                    $supportingDocumentItem = new PlanServiceCategorySupportingDocumentItem();
                    $supportingDocumentItem->plan_service_category_id = $planServiceCategory->id;
                    $supportingDocumentItem->supporting_document_category_id = $request->status[$counter];
                    $supportingDocumentItem->sort = $request->sort[$counter] ?? 1;
                    $supportingDocumentItem->save();

                    $counter++;
                }
            }

            DB::commit();

            // Redirect to the index page with a success message
            return redirect()->route('plan-service-category.index')->with('success',"Plan service category's document items added successfully");
        } catch (\Exception $e) {
            // Roll back the transaction in case of an error
            DB::rollback();

            // Handle the error and redirect with an error message
            return redirect()->route('add-plan-service-category-supporting-document-items',['planServiceCategory'=>$planServiceCategory->id])->with('error', 'An error occurred while updating the plan service category document item : '.$e->getMessage());
        }
    }
}
