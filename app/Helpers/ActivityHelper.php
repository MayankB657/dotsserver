<?php

namespace App\Helpers;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;

class ActivityHelper
{
    public static function log($action, $flag ,$old_data=null, $new_data=null , $filetype=null)
    {
        $user = Auth::user();
        // echo "<pre>"; print_r($user); 
        $agent = new Agent();
        $system = $agent->platform();
        $browser = $agent->browser();
        $browserVersion = $agent->version($browser);
        $systemVersion = $agent->version($system);
        $address = 'India';

        Activity::create([
            'user_id' => $user->id,
            'client_id' => $user->client_id,
            'company_id' => $user->company_id,
            'group_id' => $user->group_id,
            'role_id' => $user->role_id,
            'usertype' => $user->usertype,
            'old_data' => $old_data,
            'new_data' => $new_data,
            'filetype' => $filetype,
            'date' => now(),
            'action' => $action,
            'flag' => $flag,
            'details' => "$system $systemVersion $browser $browserVersion",
            'address' => $address,
        ]);
    }
}
