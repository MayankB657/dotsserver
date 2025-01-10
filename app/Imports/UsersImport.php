<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Group;
use App\Models\Roles;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
// use Maatwebsite\Excel\Concerns\ToModel;
// use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Spatie\SimpleExcel\SimpleExcelReader;

class UsersImport
{
    public function import($filePath)
    {
        $rows = SimpleExcelReader::create($filePath)->getRows();
        $cid = auth()->user()->cID; //current companyid

        foreach ($rows as $row) {

            // Get roleID and groupID based on the name
            $role = Roles::where('name', $row['role'])->where('cID',$cid)->first();
            $group = Group::where('name', $row['group'])->where('cID',$cid)->first();
            $duplicate = User::where('email', $row['email'])->where('cID',$cid)->exists();
            if ($duplicate == 1) {
                $exist[] = $row['email'];
                continue;
            }

            //check password pattern
            $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,}$/';

                if (!preg_match($pattern, $row['password'])) {
                    $exist['invalid'] = 'Invalid password!! Password must be at least 6 characters, contain 1 uppercase letter, 1 number, and 1 special character';
                    continue;
                } 

            //  return $group;exit;
            // Check if a user with the same name or email already exists
            $existingUser = User::where('name', $row['username'])->orWhere('email', $row['email'])->first();
            if ($role && $group) {

                if ($existingUser) {

                    $existingUser->update([
                        //'name' => $row['username'],
                        //'email' => $row['email'],
                        // 'password' => Hash::make($row['password']),
                        'roleID' => $role->id,
                        'nickName' => $row['name'],
                        'sizeMax' => $row['space'],
                        'groupID' => $group->id,
                    ]);
                }


                $user =  User::create([
                    'name' => $row['username'],
                    'email' => $row['email'],
                    'password' => Hash::make($row['password']),
                    'nickName' => $row['name'],
                    'roleID' => $role->id,
                    'groupID' => $group->id,
                    'cID' => $cid,
                    'sizeMax' => $row['space']
                ]);
                if ($user) {
                    $username = $user->name;
                    $email = $user->email;
                    $url = url('/') . '/login?username=' . $username;
                    $password = $row['password'];
                    Mail::send('mail-templates.register', compact('url', 'user', 'password'), function ($message) use ($email) {
                        $message->to($email);
                        $message->subject('Welcome to Dots');
                    });

                }
            }else{
                return false;
            }
        }
        if(empty($exist))
        return true;
        else 
        return $exist;
    }
}
