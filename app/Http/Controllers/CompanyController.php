<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\User;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    // Helper function to determine the view path based on the route prefix
    private function getViewPath($baseView)
    {
        return request()->is('client/companies*') ? 'client.' . $baseView : $baseView;
    }

    // Display a list of companies via AJAX
    public function index()
    {
        $companies = Company::with('client')->get();
        $clients = Client::all();
        $view = $this->getViewPath('company.main');
        return view($view, compact('companies', 'clients'));
    }

    public function companylist(Request $request)
    {
        $client_id = $request->has('client_id') ? $request->input('client_id') : auth()->user()->client_id;
        $searchTerm = $request->input('searchTerm');

        $companies = Company::with(['client', 'companyHead' => function ($query) {
            $query->select('id', 'name', 'username', 'email');
        }])
            ->when(request()->is('client/companies*'), function ($query) use ($client_id) {
                if ($client_id) {
                    $query->where('client_id', $client_id);
                }
            }, function ($query) use ($client_id) {
                $query->where('client_id', $client_id);
            })
            ->when($searchTerm, function ($query) use ($searchTerm, $client_id) {
                if (!empty($client_id)) {
                    $query->where('client_id', $client_id);
                }
                $query->where(function ($query) use ($searchTerm) {
                    $query->where('name', 'LIKE', "%{$searchTerm}%")
                        ->orWhereHas('client', function ($query) use ($searchTerm) {
                            $query->where('name', 'LIKE', "%{$searchTerm}%");
                        })
                        ->orWhereHas('companyHead', function ($query) use ($searchTerm) {
                            $query->where('name', 'LIKE', "%{$searchTerm}%")
                                  ->orWhere('username', 'LIKE', "%{$searchTerm}%");
                        });
                });
            })
            ->paginate(200);

        $view = $this->getViewPath('company.list');
        $html = view($view)->with('companies', $companies)->render();

        return response()->json(['html' => $html]);
    }

    public function addcompany(Request $request)
    {
        $clients = Client::where('status', 1)->get();
        $view = $this->getViewPath('company.add');
        $html = view($view)->with('clients', $clients)->render();
        return response()->json(['html' => $html]);
    }

    public function editcompany(Request $request)
    {
        $clients = Client::where('status', 1)->get();
        $companyId = base64_decode($request->companyid);
        $company = Company::findOrFail($companyId);
        $user = User::where('status', 1)->where('id', $company->company_head)->first();
        $view = $this->getViewPath('company.edit');

        $html = view($view)
            ->with('companydetail', $company)
            ->with('userdetail', $user)
            ->with('clients', $clients)
            ->render();

        return response()->json(['html' => $html]);
    }

    public function store(Request $request)
    {
        $clientRequired = (request()->is('client/companies*')) ? 'required' : 'nullable' ;
        $isClientRoute = request()->is('client/companies*');
        $client_id = $request->has('client') ? base64_decode($request->client) : auth()->user()->client_id;

        $validator = Validator::make($request->all(), [
            'company_name' => 'required|string|max:20',
            'name' => 'required|string|max:20',
            'username' => ['required', 'string', 'max:20', 'unique:users,username', 'regex:/^[a-zA-Z][a-zA-Z0-9]*$/'],
            'email' => 'required|email|max:30|unique:users,email',
            'password' => [
                'required', 
                'string', 
                'min:8',
                'max:20', 
                'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/'
            ],
            'client' => [
                $clientRequired, 
                function ($attribute, $value, $fail) use ($client_id, $isClientRoute) {
                    if ($isClientRoute && !Client::where('id', $client_id)->where('status', 1)->exists()) {
                        $fail('The selected client is invalid.');
                    }
                }
            ],
        ],[
            'password.regex' => 'The password must include at least one uppercase letter, one digit, and one special character (e.g., Test@12345).',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
            $company = Company::create([
                'client_id' => $client_id,
                'name' => $request->company_name,
            ]);

            $user = User::create([
                'client_id' => $client_id,
                'company_id' => $company->id,
                'usertype' => 'company',
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $company->company_head = $user->id;
            $company->save();

            DB::commit();

            $userid = base64_encode($user->id . env('ENCRYPTION_TOKEN'));
            $basePath = storage_path('app/root/' . $userid);
            $folders = ['Desktop', 'Document', 'Download', 'Gallery', 'Recyclebin'];

            foreach ($folders as $folder) {
                File::makeDirectory($basePath . '/' . $folder, 0755, true);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($company) && $company->exists) {
                $company->delete();
            }

            return response()->json(['error' => 'Failed to create user or update company. Company creation reverted.']);
        }

        return response()->json(['success' => 'Company added successfully.', 'company' => $company]);
    }

    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);
        $user = User::findOrFail($company->company_head);

        $isClientRoute = request()->is('client/companies*');
        $client_id = $request->has('client') ? base64_decode($request->client) : $company->client_id;

        $validator = Validator::make($request->all(), [
            'company_name' => 'required|string|max:20',
            'name' => 'required|string|max:20',
            'username' => [
                'required', 
                'string', 
                'max:20', 
                'unique:users,username,' . $user->id, 
                'regex:/^[a-zA-Z][a-zA-Z0-9]*$/'
            ],
            'email' => 'required|email|max:30|unique:users,email,' . $user->id,
            'password' => [
                'nullable', 
                'string', 
                'min:8',
                'max:20', 
                'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/'
            ],
            'client' => [
                'nullable', 
                function ($attribute, $value, $fail) use ($client_id, $isClientRoute) {
                    if ($isClientRoute && !Client::where('id', $client_id)->where('status', 1)->exists()) {
                        $fail('The selected client is invalid.');
                    }
                }
            ],
        ],[
            'password.regex' => 'The password must include at least one uppercase letter, one digit, and one special character (e.g., Test@12345).',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $company->update([
            'client_id' => $client_id,
            'name' => $request->company_name,
        ]);

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'client_id' => $client_id,
        ]);

        return response()->json(['success' => 'Company updated successfully.', 'company' => $company]);
    }

    public function deletecompany(Request $request)
    {
        $company = Company::findOrFail($request->id);
        $company->delete();

        return response()->json(['message' => 'Company deleted successfully.']);
    }
}
