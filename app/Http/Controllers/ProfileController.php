<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $authuser = Auth::user();
            $user = User::find($authuser->id);
            if ($request->type === "username") {
                $validator = Validator::make($request->all(), [
                    'username' => 'required|string|max:20|unique:users,username|regex:/^[a-zA-Z][a-zA-Z0-9]*$/', // Must start with a letter and contain only letters/numbers
                ]);
                if ($validator->fails()) {
                    return response()->json(['status' => false, 'errors' => $validator->errors()]);
                }
                $user->username = $request->username;
                $user->save();
                DB::commit();
                return response()->json(['message' => 'Username updated successfully.', 'status' => true, 'username' => $user->username]);
            } elseif ($request->type === "password") {
                $validator = Validator::make($request->all(), [
                    'verification_code' => 'required|string',
                    'password' => 'required|string|min:8',
                ]);
                if ($validator->fails()) {
                    return response()->json(['status' => false, 'errors' => $validator->errors()]);
                }
                if (!Hash::check($request->verification_code, session('verification_code'))) {
                    return response()->json(['message' => 'Verification code is incorrect.', 'status' => false]);
                }
                $user->password = Hash::make($request->password);
                $user->save();
                session()->forget('verification_code');
                DB::commit();
                return response()->json(['message' => 'Password updated successfully.', 'status' => true]);
            } elseif ($request->type === "email") {
                $validator = Validator::make($request->all(), [
                    'email' => 'required|string|email|max:40|unique:users,email',
                    'verification_code' => 'required|string',
                ]);
                if ($validator->fails()) {
                    return response()->json(['status' => false, 'errors' => $validator->errors()]);
                }
                if (!Hash::check($request->verification_code, session('verification_code'))) {
                    return response()->json(['message' => 'Verification code is incorrect.', 'status' => false]);
                }
                $user->email = session('new_email');
                $user->save();
                session()->forget('verification_code');
                session()->forget('new_email');
                DB::commit();
                return response()->json(['message' => 'Email updated successfully.', 'status' => true, 'email' => $user->email]);
            } elseif ($request->type === "photo") {
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
                } else {
                    return response()->json(['message' => 'Invalid file type.', 'status' => false]);
                }
                DB::commit();
                return response()->json(['message' => 'Profile photo updated successfully.', 'status' => true, 'path' => url('/') . '/' . $user->avatar]);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['message' => $th->getMessage(), 'status' => false]);
        }
    }

    public function SendVerificationCode(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'email' => [
                'required',
                'string',
                'email',
                'max:40',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }
        $verification_code = rand(100000, 999999);
        $user = Auth::user();
        session(['verification_code' => Hash::make($verification_code)]);
        session(['new_email' => $request->email]);
        $email = $request->email;
        Mail::send('mail-templates.mailverification', compact('verification_code', 'user'), function ($message) use ($email) {
            $message->to($email);
            $message->subject('Verification code');
        });
        return response()->json(['message' => 'Verification code sent successfully.', 'status' => true]);
    }
}
