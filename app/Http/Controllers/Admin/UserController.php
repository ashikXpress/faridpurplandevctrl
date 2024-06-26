<?php

namespace App\Http\Controllers\Admin;

use App\Enumeration\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.user.index');
   }
    public function dataTable()
    {
        $query = User::where('role',Role::$ADMIN);
        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function(User $user) {
                $btn = '';

                $btn .= '<a href="' . route('user.edit', ['user' => $user->id]) . '" class="btn btn-purple bg-gradient-purple btn-sm btn-edit"><i class="fa fa-edit"></i></a>';

                $btn .= ' <a role="button" data-id="' . $user->id . '" class="btn btn-danger btn-sm btn-delete"><i class="fa fa-trash"></i></a>';

                return $btn;
            })
            ->addColumn('status', function(User $user) {
              if ($user->status == 1)
               return '<span class="badge badge-success">Active</span>';
              else
                  return '<span class="badge badge-danger">Inactive</span>';

            })
            ->rawColumns(['action','status'])
            ->toJson();
    }
    public function create()
    {

        return view('admin.user.create');
   }

    public function store(Request $request)
    {

        // Validate the request data
        $validatedData = $request->validate([
            'name' =>[
                'required','max:255',
            ],
            'username' =>[
                'required','max:255',
                Rule::unique('users')
            ],
            'email' =>[
                'nullable','max:255',
                Rule::unique('users')
            ],
            'mobile_no' =>[
                'nullable','max:255',
                Rule::unique('users')
            ],
            'password' => ['required', 'confirmed',Password::defaults()],
            'status' => 'required|boolean', // Ensure 'status' is boolean
        ]);
        // Start a database transaction
        DB::beginTransaction();

        try {
            // Replace 'channel' with 'channel_id' in the validated data
            $validatedData['password'] = bcrypt($request->password);
            $validatedData['role'] = Role::$ADMIN;

            // Create a new User record in the database
            $user = User::create($validatedData);
            // Commit the transaction
            DB::commit();
            // Redirect to the index page with a success message
            return redirect()->route('user.index')->with('success', 'User created successfully');
        } catch (\Exception $e) {
            // Roll back the transaction in case of an error
            DB::rollback();
            // Handle the error and redirect with an error message
            return redirect()->route('user.create')->with('error', 'An error occurred while creating the user : '.$e->getMessage());
        }
   }

    public function edit(User $user)
    {
        if ($user->role != Role::$ADMIN){
            abort('404');
        }

        return view('admin.user.edit',compact('user'));
   }

    public function update(User $user,Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' =>[
                'required','max:255',
            ],
            'username' =>[
                'required','max:255',
                Rule::unique('users')
                ->ignore($user)
            ],
            'email' =>[
                'nullable','max:255',
                Rule::unique('users')
                    ->ignore($user)
            ],
            'mobile_no' =>[
                'nullable','max:255',
                Rule::unique('users')
                    ->ignore($user)
            ],
            'password' => ['nullable', 'confirmed',Password::defaults()],
            'status' => 'required|boolean', // Ensure 'status' is boolean
        ]);
        // Start a database transaction
        DB::beginTransaction();

        try {
            if ($request->password != ''){
                $validatedData['password'] = bcrypt($request->password);
            }else{
                unset($validatedData['password']);

            }
            $validatedData['role'] = Role::$ADMIN;

            // Create a new User record in the database
            $user->update($validatedData);
            // Commit the transaction
            DB::commit();

            // Redirect to the index page with a success message
            return redirect()->route('user.index')->with('success', 'User updated successfully');
        } catch (\Exception $e) {
            // Roll back the transaction in case of an error
            DB::rollback();

            // Handle the error and redirect with an error message
            return redirect()->route('user.edit',['user'=>$user->id])->with('error', 'An error occurred while updating the user : '.$e->getMessage());
        }
   }

    public function destroy(User $user)
    {
        try {
            // Delete the User record
            $user->delete();
            // Return a JSON success response
            return response()->json(['success'=>true,'message' => 'User deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            // Handle any errors, such as record not found
            return response()->json(['success'=>false,'message' => 'User not found: '.$e->getMessage()], Response::HTTP_OK);
        }
   }
}
