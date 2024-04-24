<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportingDocumentCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class SupportingDocumentCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.supporting_document_category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function dataTable()
    {
        $query = SupportingDocumentCategory::query();
        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function(SupportingDocumentCategory $documentCategory) {
                $btn = '';
                $btn .= '<a href="' . route('supporting-document-category.edit', ['supporting_document_category' => $documentCategory->id]) . '" class="btn btn-purple bg-gradient-purple btn-sm btn-edit"><i class="fa fa-edit"></i></a>';
                $btn .= ' <a role="button" data-id="' . $documentCategory->id . '" class="btn btn-danger btn-sm btn-delete"><i class="fa fa-trash"></i></a>';

                return $btn;
            })
            ->addColumn('status', function(SupportingDocumentCategory $documentCategory) {
                if ($documentCategory->status == 1)
                    return '<span class="badge badge-success">সক্রিয়</span>';
                else
                    return '<span class="badge badge-danger">নিষ্ক্রিয়</span>';

            })
            ->rawColumns(['action','status'])
            ->toJson();
    }
    public function create()
    {
        $maxSort = en2bn(SupportingDocumentCategory::max('sort') + 1);
        return view('admin.supporting_document_category.create',compact('maxSort'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request['sort'] = bn2en($request->sort);
        // Validate the request data
        $validatedData = $request->validate([
            'title' =>[
                'required','max:255',
                Rule::unique('supporting_document_categories')
            ],
            'file_types' => 'required',
            'sort' => 'required|integer',
            'status' => 'required|boolean',
        ]);
        // Start a database transaction
        DB::beginTransaction();

        try {
          $validatedData['file_types'] = json_encode($request->file_types);
           SupportingDocumentCategory::create($validatedData);
            // Commit the transaction
            DB::commit();
            // Redirect to the index page with a success message
            return redirect()->route('supporting-document-category.index')->with('success', 'Supporting document category created successfully');
        } catch (\Exception $e) {
            // Roll back the transaction in case of an error
            DB::rollback();
            // Handle the error and redirect with an error message
            return redirect()->route('supporting-document-category.create')
                ->withInput()
                ->with('error', 'An error occurred while creating the supporting document category : '.$e->getMessage());
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SupportingDocumentCategory $supporting_document_category)
    {
        return view('admin.supporting_document_category.edit',compact('supporting_document_category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SupportingDocumentCategory $supporting_document_category)
    {
        // Validate the request data
        $request['sort'] = bn2en($request->sort);
        $validatedData = $request->validate([
            'title' =>[
                'required','max:255',
                Rule::unique('supporting_document_categories')
                    ->ignore($supporting_document_category)
            ],
            'sort' => 'required|integer',
            'file_types' => 'required',
            'status' => 'required|boolean',
        ]);
        // Start a database transaction
        DB::beginTransaction();

        try {

            // Create a new User record in the database
            $validatedData['file_types'] = json_encode($request->file_types);
            $supporting_document_category->update($validatedData);
            // Commit the transaction
            DB::commit();

            // Redirect to the index page with a success message
            return redirect()->route('supporting-document-category.index')
                ->with('success', 'Supporting document category updated successfully');
        } catch (\Exception $e) {
            // Roll back the transaction in case of an error
            DB::rollback();

            // Handle the error and redirect with an error message
            return redirect()->route('supporting-document-category.edit',['supporting_document_category'=>$supporting_document_category->id])
                ->with('error', 'An error occurred while updating the supporting document category : '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SupportingDocumentCategory $supportingDocumentCategory)
    {
        try {
            // Delete the User record
            $supportingDocumentCategory->delete();
            // Return a JSON success response
            return response()->json(['success'=>true,'message' => 'Supporting document category deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            // Handle any errors, such as record not found
            return response()->json(['success'=>false,'message' => 'Supporting document category not found: '.$e->getMessage()], Response::HTTP_OK);
        }
    }
}
