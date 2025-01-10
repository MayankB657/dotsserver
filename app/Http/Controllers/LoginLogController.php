<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoginLog;
use App\Models\User;
use App\Models\Roles;
use Carbon\Carbon;
use App\Exports\LoginsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Record; // Assuming you have a Record model
use Illuminate\Support\Facades\Log; // Import the Log facade
use App\Helpers\PermissionHelper; 


class LoginLogController extends Controller
{
     public function __construct()
    {
        //commented for development
        $this->middleware('auth');
    }
   public function index()
   {
    $filteredPermissions = PermissionHelper::getFilteredPermissions(auth()->id());
    $log = LoginLog::with('user')->orderBy('created_at', 'desc')->paginate(10);
    $roles = Roles::get();
    return view('loginLog',compact('log', 'roles', 'filteredPermissions'));
}

public function filter(Request $request)
{
    // dd($request->all());
    $filter = $request->input('filter');
    $query = LoginLog::with('user');
    $roleId= @$request->roles?$request->roles:0;

    switch ($filter) {
        case 'today':
        $query->whereDate('login_time', Carbon::today());
        break;
        case '7-days':
        $query->where('login_time', '>=', Carbon::today()->subDays(7));
        break;
        case '30-days':
        $query->where('login_time', '>=', Carbon::today()->subDays(30));
        break;
        case 'role':
        if ($roleId) {
         $query->whereHas('user', function ($query) use ($roleId) {
            $query->where('roleID', $roleId);
            });
         }

            break;
     case 'dateTime':
   
    $query->whereBetween('created_at', [
    date('Y-m-d H:i:s', strtotime($request->start_date_time)),
    date('Y-m-d H:i:s', strtotime($request->end_date_time))
]);

    

     break;

     default:
     break;
 }

 $log = $query->take(7)->get();
 //return $query->take(7)->get();
//dd($log->toArray());

 $view = view('partials.loginLogEntries', compact('log'))->render();

 return response()->json(['html' => $view]);
}

public function export(Request $request)
{
          // Add some logging to check if this method is being called
    \Log::info('LoginController export method called');

    return Excel::download(new LoginsExport($request), 'logins.xlsx');
}

public function filterRecords(Request $request)
{

        // Log the input values for debugging
    Log::info('Start DateTime: ' . $request->query('start_date_time'));
    Log::info('End DateTime: ' . $request->query('end_date_time'));

        // Validate date-time format
    $request->validate([
        'start_date_time' => 'required|date_format:Y-m-d H:i',
        'end_date_time' => 'required|date_format:Y-m-d H:i',
    ], [
        'start_date_time.required' => 'The start date time field is required.',
        'start_date_time.date_format' => 'The start date time must match the format Y-m-d H:i.',
        'end_date_time.required' => 'The end date time field is required.',
        'end_date_time.date_format' => 'The end date time must match the format Y-m-d H:i.',
    ]);

        // Query to filter records based on date and time
    $records = LoginLog::whereBetween('created_at', [$request->query('start_date_time'), $request->query('end_date_time')])->get();

        // Return response (JSON format)
    return response()->json($records);
}
}
