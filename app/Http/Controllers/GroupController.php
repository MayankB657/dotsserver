<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\User;
use App\Models\Client;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    private function getViewPath($baseView)
    {
        if (request()->is('client/groups*')) {
            return 'client.' . $baseView;
        } elseif (request()->is('company/groups*')) {
            return 'company.' . $baseView;
        } elseif (request()->is('client/company/groups*')) {
            return 'client.company.' . $baseView;
        }
        return $baseView;
    }

    public function index()
    {
        $client_id = auth()->user()->client_id;

        $groups = Group::with('client', 'company')->get();
        $clients = Client::all();
        $companies = Company::where('client_id',$client_id)->get();
        $view = $this->getViewPath('groups.main');
        return view($view, compact('groups', 'clients', 'companies'));
    }

    public function grouplist(Request $request)
    {
        $client_id = $request->has('client_id') ? $request->input('client_id') : auth()->user()->client_id;
        $company_id = $request->has('company_id') ? $request->input('company_id') : auth()->user()->company_id;
        $searchTerm = $request->input('searchTerm');
    
        $groups = Group::with(['client', 'company', 'groupHead' => function ($query) {
            $query->select('id', 'name', 'username');
        }])
        ->when(request()->is('groups*'), function ($query) use ($client_id, $company_id) {
            if (is_null($client_id) && is_null($company_id)) {
                $query->whereNull('client_id')->whereNull('company_id');
            } elseif(is_null($company_id) && !is_null($client_id)) {
                $query->where('client_id', $client_id)->whereNull('company_id');
            }else{
                $query->where('client_id', $client_id)
                ->where('company_id', $company_id);

            }
        })
        ->when(request()->is('client/groups*'), function ($query) use ($client_id) {
            $query->whereNull('company_id')
                  ->whereNotNull('client_id'); // Ensures client_id is not null
                  
            if (!empty($client_id)) {
                $query->where('client_id', $client_id);
            }
        })
        ->when( request()->is('client/company/groups*'), function ($query) use ($client_id, $company_id) {
            $query->whereNotNull('company_id')->whereNotNull('client_id');
                
                if (!empty($client_id)) {
                    $query->where('client_id', $client_id);
                }
    
            if (!empty($company_id)) {
                $query->where('company_id', $company_id);
            }
        })
        ->when(request()->is('company/groups*'), function ($query) use ($client_id, $company_id) {
            $query->whereNotNull('company_id')->whereNotNull('client_id');
            $query->where('client_id', $client_id);
            if (!empty($company_id)) {
                $query->where('company_id', $company_id);
            }
        })
        ->when($searchTerm, function ($query) use ($searchTerm, $client_id, $company_id) {
            if (!empty($client_id)) {
                $query->where('client_id', $client_id);
            }
            if (!empty($company_id)) {
                $query->where('company_id', $company_id);
            }
    
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                  ->orWhereHas('groupHead', function ($q) use ($searchTerm) {
                      $q->where('name', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('username', 'LIKE', "%{$searchTerm}%");
                  });
                
                if (request()->is('client/groups*') || request()->is('client/company/groups*')) {
                    $q->orWhereHas('client', function ($q) use ($searchTerm) {
                        $q->where('name', 'LIKE', "%{$searchTerm}%");
                    });
                }
    
                if (request()->is('client/company/groups*')) {
                    $q->orWhereHas('company', function ($q) use ($searchTerm) {
                        $q->where('name', 'LIKE', "%{$searchTerm}%");
                    });
                }
            });
        })
        ->paginate(200);
    
        $view = $this->getViewPath('groups.list');
        $html = view($view)->with('groups', $groups)->render();
        return response()->json(['html' => $html]);
    }
    

    public function addgroup()
    {
        $client_id = auth()->user()->client_id;
        $companies = Company::where('client_id',$client_id)->get();
        $clients = Client::where('status', 1)->get();
        $view = $this->getViewPath('groups.add');
        $html = view($view)->with('clients', $clients)->with('companies', $companies)->render();

        return response()->json(['html' => $html]);
    }

    public function editgroup(Request $request)
    {
        $groupId = base64_decode($request->groupid);
        $group = Group::findOrFail($groupId);
        $clients = Client::where('status', 1)->get();
        $companies = Company::where('client_id',$group->client_id)->get();
        $user = User::where('status', 1)->where('id', $group->group_head)->first();

        $view = $this->getViewPath('groups.edit');
        $html = view($view)
            ->with('groupdetail', $group)
            ->with('userdetail', $user)
            ->with('clients', $clients)
            ->with('companies', $companies)
            ->render();

        return response()->json(['html' => $html]);
    }

    public function store(Request $request)
    {
        $clientRequired = request()->is('client/groups*') || request()->is('client/company/groups*');
        $companyRequired = request()->is('company/groups*') || request()->is('client/company/groups*');
        $client_id = $request->has('client') ? base64_decode($request->client) : auth()->user()->client_id;
        $company_id = $request->has('company') ? base64_decode($request->company) : auth()->user()->company_id;

        $validator = Validator::make($request->all(), [
            'group_name' => 'required|string|max:20',
            'name' => 'required|string|max:20',
            'username' => ['required', 'string', 'max:20', 'unique:users,username', 'regex:/^[a-zA-Z][a-zA-Z0-9]*$/'],
            'email' => 'required|email|max:30|unique:users,email',
            'password' => ['required', 'string', 'min:8','max:20', 'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/'],
            'client' => $clientRequired ? 'required' : 'nullable',
            'company' => $companyRequired ? 'required' : 'nullable',
        ],[
            'password.regex' => 'The password must include at least one uppercase letter, one digit, and one special character (e.g., Test@12345).',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        DB::beginTransaction();
        try {
            $group = Group::create([
                'client_id' => $client_id,
                'company_id' => $company_id,
                'name' => $request->group_name,
            ]);

            $user = User::create([
                'client_id' => $client_id,
                'company_id' => $company_id,
                'group_id' => $group->id,
                'usertype' => 'group',
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $group->group_head = $user->id;
            $group->save();

            DB::commit();

            $userid = base64_encode($user->id . env('ENCRYPTION_TOKEN'));
            $basePath = storage_path('app/root/' . $userid);
            $folders = ['Desktop', 'Document', 'Download', 'Gallery', 'Recyclebin'];

            foreach ($folders as $folder) {
                File::makeDirectory($basePath . '/' . $folder, 0755, true);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($group) && $group->exists) {
                $group->delete();
            }

            return response()->json(['error' => 'Failed to create user or update group. Group creation reverted.']);
        }

        return response()->json(['success' => 'Group added successfully.', 'group' => $group]);
    }

    public function update(Request $request, $id)
    {
        $group = Group::findOrFail($id);
        $user = User::findOrFail($group->group_head);

        $clientRequired = request()->is('client/groups*') || request()->is('client/company/groups*');
        $companyRequired = request()->is('company/groups*') || request()->is('client/company/groups*');
        $client_id = $request->has('client') ? base64_decode($request->client) : $group->client_id;
        $company_id = $request->has('company') ? base64_decode($request->company) : $group->company_id;

        $validator = Validator::make($request->all(), [
            'group_name' => 'required|string|max:20',
            'name' => 'required|string|max:20',
            'username' => ['required', 'string', 'max:20', 'unique:users,username,' . $user->id, 'regex:/^[a-zA-Z][a-zA-Z0-9]*$/'],
            'email' => 'required|email|max:100|unique:users,email,' . $user->id,
            'password' => ['nullable', 'string', 'min:8','max:20', 'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/'],
            'client' => $clientRequired ? 'required' : 'nullable',
            'company' => $companyRequired ? 'required' : 'nullable',
        ],[
            'password.regex' => 'The password must include at least one uppercase letter, one digit, and one special character (e.g., Test@12345).',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

       

        $group->update([
            'client_id' => $client_id,
            'company_id' => $company_id,
            'name' => $request->group_name,
        ]);

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'client_id' => $client_id,
            'company_id' => $company_id,
        ]);

        return response()->json(['success' => 'Group updated successfully.', 'group' => $group]);
    }

    public function deletegroup(Request $request)
    {
        $group = Group::findOrFail($request->id);
        $group->delete();

        return response()->json(['message' => 'Group deleted successfully.']);
    }
}
