<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\PlanServiceOrder;
use App\Models\Ward;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.area.index');
    }

    public function dataTable()
    {
        $query = Area::with('ward');
        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function(Area $area) {
                $btn = '';
                $btn .= ' <a href="' . route('area.edit', ['area' => $area->id]) . '" class="btn btn-purple bg-gradient-purple btn-sm btn-edit"><i class="fa fa-edit"></i></a>';
                $btn .= ' <a role="button" data-id="' . $area->id . '" class="btn btn-danger btn-sm btn-delete"><i class="fa fa-trash"></i></a>';

                return $btn;
            })
            ->addColumn('ward_no', function(Area $area) {
                return $area->ward->ward_no ?? '';
            })

            ->rawColumns(['action'])
            ->toJson();
    }
    public function create()
    {
        $wards = Ward::all();
        return view('admin.area.create',compact('wards'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request['area_no'] = bn2en($request->area_no);
        $validatedData = $request->validate([
            'area_name' =>[
                'required','max:255',
                Rule::unique('areas')
            ],
            'area_no' => 'required|max:255',
            'ward' => 'required',
        ]);
        // Start a database transaction
        DB::beginTransaction();

        try {

            // Create a new User record in the database
            $validatedData['ward_id'] = $request->ward;
            unset($validatedData['ward']);
            Area::create($validatedData);
            // Commit the transaction
            DB::commit();
            // Redirect to the index page with a success message
            return redirect()->route('area.index')->with('success', 'Area created successfully');
        } catch (\Exception $e) {
            // Roll back the transaction in case of an error
            DB::rollback();
            // Handle the error and redirect with an error message
            return redirect()->route('area.create')->withInput()
                ->with('error', 'An error occurred while creating the area : '.$e->getMessage());
        }
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Area $area)
    {
        $wards = Ward::all();
        return view('admin.area.edit',compact('area','wards'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Area $area)
    {
        // Validate the request data
        $request['area_no'] = bn2en($request->area_no);
        $validatedData = $request->validate([
            'area_name' =>[
                'required','max:255',
                Rule::unique('areas')
                    ->ignore($area)
            ],
            'area_no' => 'required|max:255',
            'ward' => 'required',
        ]);
        // Start a database transaction
        DB::beginTransaction();

        try {

            // Create a new User record in the database
            $validatedData['ward_id'] = $request->ward;
            unset($validatedData['ward']);
            $area->update($validatedData);
            // Commit the transaction
            DB::commit();
            // Redirect to the index page with a success message
            return redirect()->route('area.index')->with('success', 'Area updated successfully');
        } catch (\Exception $e) {
            // Roll back the transaction in case of an error
            DB::rollback();

            // Handle the error and redirect with an error message
            return redirect()->route('area.edit',['plan_category'=>$area->id])->with('error', 'An error occurred while updating the area : '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Area $area)
    {
        try {
            $planServiceOrder = PlanServiceOrder::where('area_id',$area->id)->first();
            if ($planServiceOrder){
                return response()->json(['success'=>false,'message' => "Can't delete, area has service order"], Response::HTTP_OK);

            }
            // Delete the User record
            $area->delete();
            // Return a JSON success response
            return response()->json(['success'=>true,'message' => 'Area deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            // Handle any errors, such as record not found
            return response()->json(['success'=>false,'message' => 'Area not found: '.$e->getMessage()], Response::HTTP_OK);

        }
    }
}
