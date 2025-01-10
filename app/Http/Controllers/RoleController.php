<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Client;
use App\Models\Company;
use App\Models\PermissionList;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    private function getViewPath($baseView)
    {
        if (request()->is('client/roles*')) {
            return 'client.' . $baseView;
        } elseif (request()->is('company/roles*')) {
            return 'company.' . $baseView;
        } elseif (request()->is('client/company/roles*')) {
            return 'client.company.' . $baseView;
        }
        return $baseView;
    }

    public function index()
    {
        $client_id = auth()->user()->client_id;

        $roles = Role::with('client', 'company')->get();
        $clients = Client::all();
        $companies = Company::where('client_id',$client_id)->get();
        $view = $this->getViewPath('roles.main');
        return view($view, compact('roles', 'clients', 'companies'));
    }

    public function rolelist(Request $request)
{
    $client_id = $request->has('client_id') ? $request->input('client_id') : auth()->user()->client_id;
    $company_id = $request->has('company_id') ? $request->input('company_id') : auth()->user()->company_id;
    $searchTerm = $request->input('searchTerm');

    $roles = Role::with(['client', 'company'])
        ->when(request()->is('roles*'), function ($query) use ($client_id, $company_id) {
            if (is_null($client_id) && is_null($company_id)) {
                $query->whereNull('client_id')->whereNull('company_id');
            } elseif(is_null($company_id) && !is_null($client_id)) {
                $query->where('client_id', $client_id)->whereNull('company_id');
            }else{
                $query->where('client_id', $client_id)
                ->where('company_id', $company_id);

            }
        })
        ->when(request()->is('client/roles*'), function ($query) use ($client_id) {
            $query->whereNull('company_id')
                  ->whereNotNull('client_id'); // Ensures client_id is not null
                  
            if (!empty($client_id)) {
                $query->where('client_id', $client_id);
            }
        })
        ->when( request()->is('client/company/roles*'), function ($query) use ($client_id, $company_id) {
            $query->whereNotNull('company_id')->whereNotNull('client_id');
                
                if (!empty($client_id)) {
                    $query->where('client_id', $client_id);
                }
    
                if (!empty($company_id)) {
                    $query->where('company_id', $company_id);
                }
        })
        ->when(request()->is('company/roles*'), function ($query) use ($client_id, $company_id) {
            $query->whereNotNull('company_id')->whereNotNull('client_id');
            $query->where('client_id', $client_id);
            if (!empty($company_id)) {
                $query->where('company_id', $company_id);
            }
        })
        ->when($searchTerm, function ($query) use ($searchTerm, $client_id,$company_id) {
            if (!empty($client_id)) {
                $query->where('client_id', $client_id);
            }
            if (!empty($company_id)) {
                $query->where('company_id', $company_id);
            }

            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%");

                if (request()->is('client/roles*') || request()->is('client/company/roles*')) {
                    $q->orWhereHas('client', function ($q) use ($searchTerm) {
                        $q->where('name', 'LIKE', "%{$searchTerm}%");
                    });
                }

                if (request()->is('client/company/roles*')) {
                    $q->orWhereHas('company', function ($q) use ($searchTerm) {
                        $q->where('name', 'LIKE', "%{$searchTerm}%");
                    });
                }
            });
        })
        ->paginate(200);

    $view = $this->getViewPath('roles.list');
    $html = view($view)->with('roles', $roles)->render();
    return response()->json(['html' => $html]);
}


    public function addRole()
    {
        $client_id = auth()->user()->client_id;

        $clients = Client::all();
        $companies = Company::where('client_id',$client_id)->get();

        $permissionGroups = PermissionList::where('status', 1)
            ->where('for_user_type', 'user')
            ->orderBy('permission_group_flag')
            ->get()
            ->groupBy('permission_group_flag');

        $view = $this->getViewPath('roles.add');
        $html = view($view)->with('permissionGroups', $permissionGroups)->with('clients', $clients)->with('companies', $companies)->render();
        return response()->json(['html' => $html]);
    }

   public function store(Request $request)
    {
        $clientRequired = request()->is('client/roles*') || request()->is('client/company/roles*');
        $companyRequired = request()->is('company/roles*') || request()->is('client/company/roles*');
        $client_id = $request->has('client') ? base64_decode($request->client) : auth()->user()->client_id;
        $company_id = $request->has('company') ? base64_decode($request->company) : auth()->user()->company_id;
    
        // Validation with custom rule for unique name
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:20',
                function ($attribute, $value, $fail) use ($client_id, $company_id) {
                    $existingRoleQuery = Role::query()->where('name', $value);
    
                    if (request()->is('client/roles*')) {
                        $existingRoleQuery->where('client_id', $client_id);
                    } elseif (request()->is('client/company/roles*') || request()->is('company/roles*')) {
                        $existingRoleQuery->where('client_id', $client_id)->where('company_id', $company_id);
                    } elseif (request()->is('roles*')) {
                        if (is_null($client_id) && is_null($company_id)) {
                            $existingRoleQuery->whereNull('client_id');
                        } elseif (!is_null($client_id) && is_null($company_id)) {
                            $existingRoleQuery->where('client_id', $client_id)->whereNull('company_id');
                        } elseif (!is_null($client_id) && !is_null($company_id)) {
                            $existingRoleQuery->where('client_id', $client_id)->where('company_id', $company_id);
                        }
                    }
    
                    if ($existingRoleQuery->exists()) {
                        $fail('A role with this name already exists.');
                    }
                }
            ],
            'description' => 'nullable|string|max:250',
            'permissions' => 'required|array',
            'client' => $clientRequired ? 'required' : 'nullable',
            'company' => $companyRequired ? 'required' : 'nullable',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        // Create the role
        $role = Role::create([
            'name' => $request->name,
            'description' => $request->description,
            'permissions' => json_encode($request->permissions),
            'client_id' => $client_id,
            'company_id' => $company_id,
        ]);
    
        return response()->json(['success' => 'Role added successfully.', 'role' => $role]);
    }


    public function editRole(Request $request)
    {
        $roleId = base64_decode($request->roleid);
        $role = Role::findOrFail($roleId);
        $clients = Client::all();
        $companies = Company::where('client_id',$role->client_id)->get();

        $permissionGroups = PermissionList::where('status', 1)
            ->where('for_user_type', 'user')
            ->orderBy('permission_group_flag')
            ->get()
            ->groupBy('permission_group_flag');

        $rolePermissions = json_decode($role->permissions, true) ?? [];

        $view = $this->getViewPath('roles.edit');
        $html = view($view)
            ->with('role', $role)
            ->with('clients', $clients)
            ->with('companies', $companies)
            ->with('permissionGroups', $permissionGroups)
            ->with('rolePermissions', $rolePermissions)
            ->render();

        return response()->json(['html' => $html]);
    }

   public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $clientRequired = request()->is('client/roles*') || request()->is('client/company/roles*');
        $companyRequired = request()->is('company/roles*') || request()->is('client/company/roles*');
        $client_id = $request->has('client') ? base64_decode($request->client) : $role->client_id;
        $company_id = $request->has('company') ? base64_decode($request->company) : $role->company_id;
    
        // Validation with custom rule for unique name
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:20',
                function ($attribute, $value, $fail) use ($id, $client_id, $company_id) {
                    $existingRoleQuery = Role::query()->where('name', $value)->where('id', '!=', $id);
    
                    if (request()->is('client/roles*')) {
                        $existingRoleQuery->where('client_id', $client_id);
                    } elseif (request()->is('client/company/roles*') || request()->is('company/roles*')) {
                        $existingRoleQuery->where('client_id', $client_id)->where('company_id', $company_id);
                    } elseif (request()->is('roles*')) {
                        if (is_null($client_id) && is_null($company_id)) {
                            $existingRoleQuery->whereNull('client_id');
                        } elseif (!is_null($client_id) && is_null($company_id)) {
                            $existingRoleQuery->where('client_id', $client_id)->whereNull('company_id');
                        } elseif (!is_null($client_id) && !is_null($company_id)) {
                            $existingRoleQuery->where('client_id', $client_id)->where('company_id', $company_id);
                        }
                    }
    
                    if ($existingRoleQuery->exists()) {
                        $fail('A role with this name already exists.');
                    }
                }
            ],
            'description' => 'nullable|string|max:250',
            'permissions' => 'required|array',
            'client' => $clientRequired ? 'required' : 'nullable',
            'company' => $companyRequired ? 'required' : 'nullable',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        // Update the role
        $role->update([
            'client_id' => $client_id,
            'company_id' => $company_id,
            'name' => $request->name,
            'description' => $request->description,
            'permissions' => json_encode($request->permissions),
        ]);
    
        return response()->json(['success' => 'Role updated successfully.', 'role' => $role]);
    }


    public function deleteRole(Request $request)
    {
        $role = Role::findOrFail($request->id);
        $role->delete();

        return response()->json(['message' => 'Role deleted successfully.']);
    }
}
