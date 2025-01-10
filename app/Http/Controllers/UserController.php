<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Client;
use App\Models\Company;
use App\Models\Group;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Models\SettingMenu;
use Spatie\SimpleExcel\SimpleExcelReader;
use Illuminate\Support\Facades\Storage;
use App\Models\File as FileModel;


class UserController extends Controller
{
    private function getViewPath($baseView)
    {
        if (request()->is('client/users*')) {
            return 'client.' . $baseView;
        } elseif (request()->is('company/users*')) {
            return 'company.' . $baseView;
        } elseif (request()->is('client/company/users*')) {
            return 'client.company.' . $baseView;
        }
        return $baseView;
    }

    public function index()
    {
        $clients = Client::all();
        $client_id = auth()->user()->client_id;

        $companies = Company::where('client_id',$client_id)->get();

        $users = User::with('client', 'company', 'group', 'role')->get();
        $groups = Group::where('client_id', auth()->user()->client_id)
                        ->where('company_id', auth()->user()->company_id)->get();
        $roles = Role::where('client_id', auth()->user()->client_id)
                     ->where('company_id', auth()->user()->company_id)->get();
        $menus = SettingMenu::where('status', 1)->get();

        $view = $this->getViewPath('users.main');
        return view($view, compact('groups', 'roles','clients', 'users', 'menus','companies'));
    }

    public function userlist(Request $request)
    {
        $usertype = auth()->user()->usertype;
        $client_id = $request->has('client_id') ? $request->input('client_id') : auth()->user()->client_id;
        $company_id = $request->has('company_id') ? $request->input('company_id') : auth()->user()->company_id;
        $searchTerm = $request->input('searchTerm');

        $users = User::with(['client', 'company', 'group', 'role'])
            ->when(request()->is('users*'), function ($query) use ($client_id, $company_id,$usertype) {

                if (is_null($client_id) && is_null($company_id)) {
                    $query->whereNull('client_id')->whereNull('company_id');
                } elseif(is_null($company_id) && !is_null($client_id)) {
                    $query->where('client_id', $client_id)->whereNull('company_id');
                }else{
                    $query->where('client_id', $client_id)
                    ->where('company_id', $company_id);
                }
                if($usertype == 'group' || $usertype =='user'){
                    $query->where('group_id', auth()->user()->group_id);
                }
            })
            ->when(request()->is('client/users*'), function ($query) use ($client_id) {
                $query->whereNull('company_id')
                      ->whereNotNull('client_id'); // Ensures client_id is not null
                      
                if (!empty($client_id)) {
                    $query->where('client_id', $client_id);
                }
            })
            ->when( request()->is('client/company/users*'), function ($query) use ($client_id, $company_id) {
                $query->whereNotNull('company_id')->whereNotNull('client_id');
                    
                    if (!empty($client_id)) {
                        $query->where('client_id', $client_id);
                    }
        
                if (!empty($company_id)) {
                    $query->where('company_id', $company_id);
                }
            })
            ->when(request()->is('company/users*'), function ($query) use ($client_id, $company_id) {
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
                    $q->where('name', 'LIKE', "%{$searchTerm}%")
                    ->orWhereHas('role', function ($q) use ($searchTerm) {
                        $q->where('name', 'LIKE', "%{$searchTerm}%");
                    })
                    ->orWhereHas('group', function ($q) use ($searchTerm) {
                        $q->where('name', 'LIKE', "%{$searchTerm}%");
                    });
                    if (request()->is('client/users*') || request()->is('client/company/users*')) {
                        $q->orWhereHas('client', function ($q) use ($searchTerm) {
                            $q->where('name', 'LIKE', "%{$searchTerm}%");
                        });
                    }
    
                    if (request()->is('client/company/users*')) {
                        $q->orWhereHas('company', function ($q) use ($searchTerm) {
                            $q->where('name', 'LIKE', "%{$searchTerm}%");
                        });
                    }
                });
            })
            ->where('id', '!=', auth()->user()->id)
            ->where('usertype','user')  // Exclude the logged-in user
            ->paginate(200);

        $view = $this->getViewPath('users.list');
        $html = view($view)->with('users', $users)->render();
        return response()->json(['html' => $html]);
    }


    public function toggleStatus(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->status = $request->status;
        $user->save();

        return response()->json([
            'message' => 'User ' . ($request->status == 1 ? 'activated' : 'deactivated') . ' successfully.',
            'new_status' => $user->status
        ]);
    }

    public function addUser()
    {
        $client_id = auth()->user()->client_id;
        $company_id = auth()->user()->company_id;
        $group_id = auth()->user()->group_id;
        $usertype = auth()->user()->usertype;
        $clients = Client::all();
        $companies = Company::where('client_id',$client_id)->get();

        $groups = Group::when((request()->is('company/users*') || request()->is('client/company/users*')), function ($query) use ($client_id, $company_id) {
            $query->where('client_id', $client_id)
                  ->where('company_id', $company_id);
        })
        ->when(request()->is('client/users*'), function ($query) use ($client_id, $company_id) {
            $query->where('client_id', $client_id)
                    ->whereNull('company_id');
        })
        ->when(request()->is('users*'), function ($query) use ($client_id, $company_id,$group_id,$usertype) {

             if (is_null($client_id) && is_null($company_id)) {
                $query->whereNull('client_id')->whereNull('company_id');
            } else {
                $query->where('client_id', $client_id)
                ->where('company_id', $company_id);
            }
            if($usertype == 'group' || $usertype == 'user'){
                 $query->where('id', $group_id);
                
            }
        })
        ->get();

    $roles = Role::when((request()->is('company/users*') || request()->is('client/company/users*') || request()->is('users*')), function ($query) use ($client_id, $company_id) {
            $query->where('client_id', $client_id)
                  ->where('company_id', $company_id);
        })
        ->when(request()->is('client/users*'), function ($query) use ($client_id, $company_id) {
            $query->where('client_id', $client_id)
                    ->whereNull('company_id');
        }) 
        ->when(request()->is('users*'), function ($query) use ($client_id, $company_id) {

            if (is_null($client_id) && is_null($company_id)) {
               $query->whereNull('client_id')->whereNull('company_id');
           } else {
                $query->where('client_id', $client_id)
                ->where('company_id', $company_id);
           }
       })
        ->get();

        $view = $this->getViewPath('users.add');
        $html = view($view)->with('roles', $roles)->with('groups', $groups)->with('clients', $clients)->with('companies', $companies)->render();
        return response()->json(['html' => $html]);
    }

    public function editUser(Request $request)
    {
        $clients = Client::all();

        $userid = base64_decode($request->userid);
        $userdetail = User::findOrFail($userid);
        if(request()->is('users*')){
            $client_id = auth()->user()->client_id;
            $company_id = auth()->user()->company_id;
            $group_id = auth()->user()->group_id;
            $usertype = auth()->user()->usertype;
            $companies = Company::where('client_id',$userdetail->client_id)->get();

        }else{
            if($userdetail){
                $client_id = $userdetail->client_id;
                $company_id = $userdetail->company_id;
                $group_id = $userdetail->group_id;
                $usertype = $userdetail->usertype;
                $companies = Company::where('client_id',$userdetail->client_id)->get();

            }
        }
        

        $groups = Group::when((request()->is('company/users*') || request()->is('client/company/users*')), function ($query) use ($client_id, $company_id) {
                $query->where('client_id', $client_id)
                      ->where('company_id', $company_id);
            })
            ->when(request()->is('client/users*'), function ($query) use ($client_id, $company_id) {
                $query->where('client_id', $client_id)
                        ->whereNull('company_id');
            })
            ->when(request()->is('users*'), function ($query) use ($client_id, $company_id,$group_id,$usertype) {

                 if (is_null($client_id) && is_null($company_id)) {
                    $query->whereNull('client_id')->whereNull('company_id');
                } else {
                    $query->where('client_id', $client_id)
                    ->where('company_id', $company_id);
                }
                if($usertype == 'group' || $usertype == 'user'){
                 $query->where('id', $group_id);
                
                }
            })
            ->get();

        $roles = Role::when((request()->is('company/users*') || request()->is('client/company/users*') || request()->is('users*')), function ($query) use ($client_id, $company_id) {
                $query->where('client_id', $client_id)
                      ->where('company_id', $company_id);
            })
            ->when(request()->is('client/users*'), function ($query) use ($client_id, $company_id) {
                $query->where('client_id', $client_id)
                        ->whereNull('company_id');
            }) 
            ->when(request()->is('users*'), function ($query) use ($client_id, $company_id) {

                if (is_null($client_id) && is_null($company_id)) {
                   $query->whereNull('client_id')->whereNull('company_id');
               } else {
                    $query->where('client_id', $client_id)
                    ->where('company_id', $company_id);
               }
           })
            ->get();

        $view = $this->getViewPath('users.edit');
        $html = view($view)->with('roles', $roles)->with('groups', $groups)->with('clients', $clients)->with('userdetail', $userdetail)->with('companies',$companies)->render();
        return response()->json(['html' => $html]);
    }

    public function show($id)
    {
        $user = User::with('client', 'company', 'group', 'role')->findOrFail($id);
        $view = $this->getViewPath('users.show');
        return view($view, compact('user'));
    }

    public function store(Request $request)
    {
        
        $clientRequired = request()->is('client/users*') || request()->is('client/company/users*');
        $companyRequired = request()->is('company/users*') || request()->is('client/company/users*');
        $client_id = $request->has('client') ? base64_decode($request->client) : auth()->user()->client_id;
        $company_id = $request->has('company') ? base64_decode($request->company) : auth()->user()->company_id;
        
        $validator = Validator::make($request->all(), [
            'group_id' => 'required|exists:groups,id',
            'role_id' => 'required|exists:roles,id',
            'name' => 'required|string|max:20',
            'username' => [
                'required',
                'string',
                'max:20',
                'unique:users,username',
                'regex:/^[a-zA-Z][a-zA-Z0-9]*$/', // Must start with a letter and contain only letters/numbers
            ],
            'email' => [
                'required',
                'email',
                'max:30',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:20',
                'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/', // At least 1 uppercase, 1 number, 1 special char
            ],
            'sizeMax' => 'required|numeric|max:5',
            'client' => $clientRequired ? 'required' : 'nullable',
            'company' => $companyRequired ? 'required' : 'nullable',
        ],
        [
            'password.regex' => 'The password must include at least one uppercase letter, one digit, and one special character (e.g., Test@12345).',
        ]
        );
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        
        $input = $request->all();
        $input['password'] = Hash::make($request->password);
        $input['client_id'] = $client_id;
        $input['company_id'] = $company_id;
        $input['created_by'] = auth()->user()->id;

        $user = User::create($input);
        return response()->json(['success' => 'User added successfully.', 'user' => $user,'status'=>true]);
    }

    public function update(Request $request, User $user)
    {

        $clientRequired = request()->is('client/users*') || request()->is('client/company/users*');
        $companyRequired = request()->is('company/users*') || request()->is('client/company/users*');
        $client_id = $request->has('client') ? base64_decode($request->client) : $user->client_id;
        $company_id = $request->has('company') ? base64_decode($request->company) : $user->company_id;
        $validator = Validator::make($request->all(), [
            'group_id' => 'required|exists:groups,id',
            'role_id' => 'required|exists:roles,id',
            'name' => 'required|string|max:20',
            'username' => ['required', 'string', 'max:20', 'unique:users,username,' . $user->id, 'regex:/^[a-zA-Z][a-zA-Z0-9]*$/'],
            'email' => 'required|email|max:30|unique:users,email,' . $user->id,
            'password' => ['nullable', 'string', 'min:8','max:20', 'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/'],
            'sizeMax' => 'nullable|numeric|max:5',
            'client' => $clientRequired ? 'required' : 'nullable',
            'company' => $companyRequired ? 'required' : 'nullable',
        ],[
            'password.regex' => 'The password must include at least one uppercase letter, one digit, and one special character (e.g., Test@12345).',
        ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }



        $user->update([
            'group_id' => $request->group_id,
            'role_id' => $request->role_id,
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'sizeMax' => (int)$request->sizeMax,
            'client_id' => $client_id,
            'company_id' => $company_id
        ]);

        return response()->json(['success' => 'User updated successfully.', 'user' => $user]);
    }

    public function deleteUser(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->delete();
        return response()->json(['message' => 'User deleted successfully.']);
    }

    public function getCompaniesByClient(Request $request)
    {
        $client_id = $request->input('client_id');
        $companies = Company::where('client_id', $client_id)->get(['id', 'name']);
        return response()->json($companies);
    }

    public function fetchRolesAndGroupsByClient(Request $request)
    {
        $client_id = $request->has('client_id') ? base64_decode($request->input('client_id')) : auth()->user()->client_id;
        $company_id = $request->has('company_id') ? base64_decode($request->input('company_id')) : null;

        $roles = Role::where('client_id', $client_id)
                    ->when($company_id, function ($query) use ($company_id) {
                        $query->where('company_id', $company_id);
                    }, function ($query) {
                        $query->whereNull('company_id');
                    })
                    ->get(['id', 'name']);

        $groups = Group::where('client_id', $client_id)
                    ->when($company_id, function ($query) use ($company_id) {
                        $query->where('company_id', $company_id);
                    }, function ($query) {
                        $query->whereNull('company_id');
                    })
                    ->get(['id', 'name']);

        return response()->json([
            'roles' => $roles,
            'groups' => $groups
        ]);
    }
    
    public function importUsers(Request $request)
{
    // Validate the uploaded file
    $request->validate([
        'file' => 'required|mimes:xlsx,csv|max:2048', // Ensure it's an Excel or CSV file
    ]);

    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $filePath = $file->storeAs('temp', $file->getClientOriginalName());
        $fullFilePath = storage_path('app/' . $filePath);

        $errors = [];
        $client_id = auth()->user()->client_id;
        $company_id = auth()->user()->company_id;
        $rows = [];

        // Process the file using SimpleExcelReader
        $reader = SimpleExcelReader::create($fullFilePath);
        $reader->getRows()->each(function (array $row, $index) use (&$errors, &$rows, $client_id, $company_id) {
            // Trim spaces in both the keys and values of the row
            $row = array_combine(
                array_map('trim', array_keys($row)), // Trim the keys
                array_map('trim', $row) // Trim the values
            );

            if (!isset($row['group_name']) || !isset($row['role_name'])) {
                $rows[] = [
                    'success' => false,
                    'error' => 'Missing group_name or role_name'
                ];
                return;
            }

            $group = Group::where('name', $row['group_name'])
                          ->where('client_id', $client_id)
                          ->where('company_id', $company_id)
                          ->first();

            $role = Role::where('name', $row['role_name'])
                        ->where('client_id', $client_id)
                        ->where('company_id', $company_id)
                        ->first();

            if (!$group) {
                $rows[] = [
                    'success' => false,
                    'error' => 'Group "' . $row['group_name'] . '" not found'
                ];
                return;
            }

            if (!$role) {
                $rows[] = [
                    'success' => false,
                    'error' => 'Role "' . $row['role_name'] . '" not found'
                ];
                return;
            }

            $validator = Validator::make($row, [
                'name' => 'required|string|max:20',
                'username' => 'required|string|max:20|unique:users,username',
                'email' => 'required|email|max:30|unique:users,email',
                'password' => 'required|string|min:8|max:20',
                'sizeMax' => 'required|numeric|max:5'
            ]);

            if ($validator->fails()) {
                $rows[] = [
                    'success' => false,
                    'error' => implode(', ', $validator->errors()->all())
                ];
                return;
            }

            // Create user if no errors
            User::create([
                'group_id' => $group->id,
                'role_id' => $role->id,
                'client_id' => $client_id,
                'company_id' => $company_id,
                'name' => $row['name'],
                'username' => $row['username'],
                'email' => $row['email'],
                'password' => Hash::make($row['password']),
                'sizeMax' => $row['sizeMax'],
                'created_by' => auth()->user()->id
            ]);

            $rows[] = [
                'success' => true
            ];
        });

        Storage::delete($filePath); // Clean up

        return response()->json(['rows' => $rows], 200);
    }

    return response()->json(['error' => 'No file uploaded'], 400);
}

public function restoreList(){
    return view('restore.main');
}

public function ProfilePic(Request $request)
{
        if (Auth::user()) {
            $user = Auth::user();
            $old = $user->avatar;
            $type = $request->profile->getClientMimeType();
            if (in_array($type, ['image/jpeg', 'image/jpeg', 'image/png'])) {
                $FileName = time() . '.' . $request->profile->getClientOriginalExtension();;
                $request->profile->move(public_path('storage/userprofile'), $FileName);
                $user->avatar = 'public/storage/userprofile/' . $FileName;
                $user->save();
                if (File::exists(base_path($old))) {
                    File::delete(base_path($old));
                }
                return redirect()->back()->with('success', 'Profile updated successfully.');
            } else {
                return redirect()->back()->with('error', 'Invalid image type! Select jpeg,png,jpg.');
            }
        } else {
            return redirect()->route('login');
        }
}

public function dumpedFileList(Request $request)
{
    $user = auth()->user();
    $usertype = $user->usertype;
    $client_id = $user->client_id;
    $company_id = $user->company_id;
    $group_id = $user->group_id;
    $user_id = $user->id;

    $searchTerm = $request->input('searchTerm');

    $files = FileModel::with(['client', 'company', 'group', 'role', 'user'])
        ->where('status', 2) // Only include files with status 2
        ->when($usertype === 'master', function ($query) use ($user_id) {
            // Show all records except those created by the master admin itself
            $query->where('created_by', '!=', $user_id);
        })
        ->when($usertype === 'client', function ($query) use ($user_id) {
            // Show files for users with client_id matching logged-in user's user ID
            $query->whereHas('user', function ($q) use ($user_id) {
                $q->where('client_id', $user_id);
            });
        })
        ->when($usertype === 'company', function ($query) use ($client_id, $company_id) {
            // Show files for users with client_id and company_id matching the logged-in user's IDs
            $query->whereHas('user', function ($q) use ($client_id, $company_id) {
                $q->where('client_id', $client_id)
                  ->where('company_id', $company_id);
            });
        })
        ->when($usertype === 'group', function ($query) use ($client_id, $company_id, $group_id) {
            // Show files for users with matching client_id, company_id, and group_id
            $query->whereHas('user', function ($q) use ($client_id, $company_id, $group_id) {
                $q->where('client_id', $client_id)
                  ->where('company_id', $company_id)
                  ->where('group_id', $group_id);
            });
        })
        ->when($usertype === 'user', function ($query) use ($client_id, $company_id, $group_id) {
            // Show files for users with matching client_id, company_id, and group_id
            $query->whereHas('user', function ($q) use ($client_id, $company_id, $group_id) {
                $q->where('client_id', $client_id)
                  ->where('company_id', $company_id)
                  ->where('group_id', $group_id);
            });
        })
        ->when($searchTerm, function ($query) use ($searchTerm) {
            // Apply search term filtering
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                  ->orWhereHas('role', function ($q) use ($searchTerm) {
                      $q->where('name', 'LIKE', "%{$searchTerm}%");
                  })
                  ->orWhereHas('group', function ($q) use ($searchTerm) {
                      $q->where('name', 'LIKE', "%{$searchTerm}%");
                  })
                  ->orWhereHas('client', function ($q) use ($searchTerm) {
                      $q->where('name', 'LIKE', "%{$searchTerm}%");
                  })
                  ->orWhereHas('company', function ($q) use ($searchTerm) {
                      $q->where('name', 'LIKE', "%{$searchTerm}%");
                  });
            });
        })
        ->paginate(200);

    $view = 'restore.list';
    $html = view($view)->with('files', $files)->render();

    return response()->json(['html' => $html]);
}



}
