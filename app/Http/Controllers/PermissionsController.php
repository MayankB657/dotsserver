<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permissions;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\JsonResponse;
use App\Helpers\PermissionHelper;

class PermissionsController extends Controller
{

     public function __construct()
    {
        $this->middleware('auth');
    }
 /**
     * Display a listing of the roles.
     */
    public function index($id ='')
    {
       if($id){
        $permission = Permissions::find($id);
        return view('permissions.index',compact('permission'));

       }else{
           $permissions = Permissions::get();
           return view('permissions.index',compact('permissions'));
        }
    }

    public function permissions()
    {
        $filteredPermissions = PermissionHelper::getFilteredPermissions(auth()->id());
        $permissions = Permissions::paginate(10);
        return view('permissions.permissions')->with('permissions',$permissions)->with('filteredPermissions', $filteredPermissions);
    }

     public function permissionsList(Request $request)
    {
        $filteredPermissions = PermissionHelper::getFilteredPermissions(auth()->id());
        $input = $request->all();

        if($input['searchTerm']){
           $search = $input['searchTerm'];
            $permissions = Permissions::where('name','LIKE','%'.$search.'%')->get();
        }else{
              if(auth()->user()->cID == 0){
               $permissions = Permissions::paginate(10);
                }else{
                $cid = auth()->user()->cID;
                $permissions = Permissions::where('cID',$cid)->paginate(10);  
                }
        }
        $permission = view('appendview.permissionlist')->with('permissions',$permissions)->with('filteredPermissions', $filteredPermissions)->render();
        return response()->json($permission);
    }

    public function add()
    {
       return view('permissions.add');
    }

    public function create(Request $request)
    {
        //  $validator = Validator::make($request->all(), [
        //     'name' => 'required|string',
        //     'permissions' => 'required',
        // ]);

        // if($validator->fails()){
        //     return $this->sendError('Validation Error.', $validator->errors());       
        // }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'permissions' => 'required|array|min:1',
        ], [
            'name.required' => 'The name field is required.',
            'permissions.required' => 'The permissions field is required and cannot be empty.',
            // 'permissions.min' => 'You must select at least one permission.',
        ]);
        
        if ($validator->fails()) {        
            return redirect()->route('permissionsadmin')->with('error', 'Choose atleast one permission!'); 
        }

        $cid = auth()->user()->cID;
        $input = $request->all();
        $input['name'] = preg_replace('/[^A-Za-z0-9 ]/', '', $input['name']);
        $input['permissions'] = implode(',', $input['permissions']);
        $input['cID'] = $cid;
        $role = Permissions::create($input);
        return redirect()->route('permissionsadmin')->with('success', 'Permission created successfully!'); 
    }

     public function edit(Request $request)
    {
        $id = $request->id;
        $permission = Permissions::find($id);
        $permission->permissions = explode(',',$permission->permissions);
        $permissions = view('appendview.editpermission')->with('permission',$permission)->render();
        return response()->json($permissions);
    }

     public function update(Request $request, string $id)
    {

       // Access and prepare data from the request
        $data = request()->except(['_token']);
        $data['name'] = preg_replace('/[^A-Za-z0-9 ]/', '', $data['name']);
        if(!empty($data['permissions']))
        $data['permissions'] = implode(',', $data['permissions']);
        else
        $data['permissions'] = '';
        $updated = Permissions::where('id', $id)->update($data);
        $role = Permissions::find($id);

        if ($updated) {
            return redirect()->route('permissionsadmin')->with('success-update', 'Permission updated successfully!');
        } else {
            // Handle update failure (e.g., log the error or return a specific error message)
            return redirect()->route('permissionsadmin')->with('error', 'Permission update failed!');
        }
    }

     public function destroy(string $id)
    {
        
        Permissions::where('id', $id)->delete();
        return redirect()->route('permissionsadmin')->with('delete', 'Permission deleted successfully!');
    
    }
}
