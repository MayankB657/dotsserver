<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    // Display a list of clients via AJAX
    public function index()
    {
        $clients = Client::all();
        return view('client.main', compact('clients'));
    }

    public function clientlist(Request $request)
    {
        $searchTerm = $request->input('searchTerm');
    
        $clients = Client::with(['clientHead' => function($query) {
                $query->select('id', 'name', 'username');
            }])
            ->when($searchTerm, function ($query, $searchTerm) {
                return $query->where(function($q) use ($searchTerm) {
                    $q->where('name', 'LIKE', "%{$searchTerm}%")
                      ->orWhereHas('clientHead', function ($q) use ($searchTerm) {
                          $q->where('name', 'LIKE', "%{$searchTerm}%")
                            ->orWhere('username', 'LIKE', "%{$searchTerm}%");
                      });
                });
            })
            ->paginate(200);
    
        $html = view('client.list')->with('clients', $clients)->render();
        return response()->json(['html' => $html]);
    }
    

    public function addclient()
    {
        $html = view('client.add')->render();
        return response()->json(['html' => $html]);
    }

    public function editclient(Request $request)
    {
        $clientId = base64_decode($request->clientid);
        $client = Client::findOrFail($clientId);
        $user = User::where('status', 1)->where('id', $client->client_head)->first();

        $html = view('client.edit')
            ->with('clientdetail', $client)
            ->with('userdetail', $user)
            ->render();

        return response()->json(['html' => $html]);
    }

    // Store a newly created client via AJAX
    public function store(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'client_name' => 'required|string|max:20',
            'name' => 'required|string|max:20',
            'username' => ['required', 'string', 'max:20', 'unique:users,username', 'regex:/^[a-zA-Z][a-zA-Z0-9]*$/'],
            'email' => 'required|email|max:30|unique:users,email',
            'password' => ['required', 'string', 'min:8','max:20', 'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/'],
        ],[
            'password.regex' => 'The password must include at least one uppercase letter, one digit, and one special character (e.g., Test@12345).',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
            $client = Client::create([
                'name' => $request->client_name,
            ]);

            $user = User::create([
                'client_id' => $client->id,
                'usertype' => 'client',
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $client->client_head = $user->id;
            $clientSaveResult = $client->save();

            if (!$clientSaveResult) {
                throw new \Exception("Failed to save client_head.");
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            if ($client->exists) {
                $client->delete();
            }

            return response()->json(['error' => 'Failed to create user or update client. Client creation reverted.']);
        }

        // Additional logic for sending welcome email and creating folders
        if ($user) {
            $username = $request->username;
            $email = $user->email;
            $url = url('/') . '/login?username=' . $username;
            $password = $request->password;

            // Mail::send('mail-templates.register', compact('url', 'user', 'password'), function ($message) use ($email) {
            //     $message->to($email);
            //     $message->subject('Welcome to Dots');
            // });

            $userid = base64_encode($user->id . env('ENCRYPTION_TOKEN'));
            if (!File::exists(storage_path('app/root/' . $userid))) {
                File::makeDirectory(storage_path('app/root/' . $userid), 0755, true);
            }
            $basePath = storage_path('app/root/' . $userid);
            $folders = ['Desktop', 'Document', 'Download', 'Gallery', 'Recyclebin'];

            foreach ($folders as $folder) {
                $folderPath = $basePath . '/' . $folder;
                if (!File::exists($folderPath)) {
                    File::makeDirectory($folderPath, 0755, true);
                }
            }
        }

        return response()->json(['success' => 'Client added successfully.', 'client' => $client]);
    }

    // Update the specified client via AJAX
    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);
        $user = User::findOrFail($client->client_head);

        $validator = Validator::make($request->all(), [
            'client_name' => 'required|string|max:50',
            'name' => 'required|string|max:100',
            'username' => ['required', 'string', 'max:100', 'unique:users,username,' . $user->id, 'regex:/^[a-zA-Z][a-zA-Z0-9]*$/'],
            'email' => 'required|email|max:100|unique:users,email,' . $user->id,
            'password' => ['nullable', 'string', 'min:8','max:20', 'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/'],
        ],[
            'password.regex' => 'The password must include at least one uppercase letter, one digit, and one special character (e.g., Test@12345).',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $client->update([
            'name' => $request->client_name,
        ]);

        if ($user) {
            $user->update([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => $request->password ? Hash::make($request->password) : $user->password,
            ]);
        } else {
            return response()->json(['error' => 'Client Head not found.']);
        }

        return response()->json(['success' => 'Client updated successfully.', 'client' => $client]);
    }

    // Delete the specified client via AJAX
    public function deleteclient(Request $request)
    {
        $client = Client::findOrFail($request->id);
        $client->delete();

        return response()->json(['message' => 'Client deleted successfully.']);
    }
}
