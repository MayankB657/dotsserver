<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\File;
use App\Models\Group;
use App\Models\Activity;
use App\Models\Roles;
use Illuminate\Support\Facades\Auth;
use App\Models\Permissions;
use App\Exports\OverviewExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Mpdf\Mpdf;
use Barryvdh\Snappy\Facades\SnappyPdf;
use App\Helpers\PermissionHelper;

class OverviewController extends Controller
{
    
 public function __construct()
    {
        //commented for development
        $this->middleware('auth');
    }

 public function index()
 {
    $filteredPermissions = PermissionHelper::getFilteredPermissions(auth()->id());
      //Logins------------------

  // $loginsData = Activity::where('action', 'Log In')->get();
  $loginsData = Activity::select(DB::raw('MONTHNAME(date) as month'), DB::raw('COUNT(*) as count'))
  ->where('action', 'Log In')
  ->groupBy(DB::raw('MONTH(date)'), DB::raw('MONTHNAME(date)'))
  ->orderBy(DB::raw('MONTH(date)'))
  ->get();

    //
  $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August'];
  // $loginCounts = [];

  $loginCounts = array_fill(0, 12, 0); // Initialize yearly array with 12 zeros

  foreach ($loginsData as $data) {
    $month = $data['month'];
    $count = $data['count'];

          // Find the index of the month in the $months array
    $index = array_search($month, $months);

    if ($index !== false) {
              // Update the yearly array at the corresponding index
      $loginCounts[$index] = $count;
    }
  }

   // Count logins per month
  foreach ($loginsData as $login) {
        $month = date('F', strtotime($login->created_at)); // Adjust this according to your date format
        if (array_key_exists($month, $loginCounts)) {
          $loginCounts[$month]++;
        }
      }
//Logins--ends----------------
     //new user-----------------------------

      // Fetch new users count month by month
     $newUsers = User::selectRaw('DATE_FORMAT(created_at, "%M") as month, MONTH(created_at) as month_number, COUNT(*) as count')
    ->groupBy('month', 'month_number')
    ->orderBy('month_number')
    ->get();


      $newUsersData = array_fill(0, 12, 0); // Initialize yearly array with 12 zeros
      foreach ($newUsers as $data) {
        $month = $data['month'];
        $count = $data['count'];

          // Find the index of the month in the $months array
        $index = array_search($month, $months);

        if ($index !== false) {
              // Update the yearly array at the corresponding index
          $newUsersData[$index] = $count;
        }
      }
//new user----------ends-------------------

        //totals user-------------------------
      $usersDataGraph_temp = User::selectRaw('DATE_FORMAT(created_at, "%M") as month, COUNT(*) as total_users')
      ->whereYear('created_at', Carbon::now()->year)
      ->groupBy('month')
      ->orderBy('month')
      ->get();

      $usersDataGraph = array_fill(0, 12, 0); // Initialize yearly array with 12 zeros

      foreach ($usersDataGraph_temp as $data) {

          // dump($data->toArray());

        $month = $data['month'];
        $count = $data['total_users'];

          // Find the index of the month in the $months array
        $index = array_search($month, $months);

        if ($index !== false) {
              // Update the yearly array at the corresponding index
          $usersDataGraph[$index] = $count;
        }
      }
//totals user--------ends-----------------------------------
  
  // 11111  Total Retrieve maximum size data grouped by month---------
 // Retrieve maximum size data grouped by month
    $sizesData = User::select(
        DB::raw('MONTHNAME(created_at) as month'),
        DB::raw('MAX(sizemax) as max_size')
    )
    ->groupBy(DB::raw('MONTH(created_at)'), DB::raw('MONTHNAME(created_at)'))
    ->orderBy(DB::raw('MONTH(created_at)'))
    ->get();

    $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    $maxSizes = array_fill(0, 12, 0);

    // Fill max sizes array
    foreach ($sizesData as $data) {
        $month = $data['month'];
        $maxSize = $data['max_size'];
        $index = array_search($month, $months);
        if ($index !== false) {
            $maxSizes[$index] = $maxSize;
        }
    }

    // Actual size usage data
    $sizeUseData = User::select(
        DB::raw('MONTHNAME(created_at) as month'),
        DB::raw('SUM(sizeUse) as total_sizeUse')
    )
    ->groupBy(DB::raw('MONTH(created_at)'), DB::raw('MONTHNAME(created_at)'))
    ->orderBy(DB::raw('MONTH(created_at)'))
    ->get();

    $actualdata = array_fill(0, 12, 0);

    foreach ($sizeUseData as $data) {
        $month = $data['month'];
        $sizeUse = $data['total_sizeUse'];
        $index = array_search($month, $months);
        if ($index !== false) {
            $actualdata[$index] = $sizeUse;
        }
    }

    // User size usage data
    $sizeUseUser = User::select(
        DB::raw('MONTHNAME(created_at) as month'),
        DB::raw('SUM(sizeUse) as total_sizeUse')
    )
    ->groupBy(DB::raw('MONTH(created_at)'), DB::raw('MONTHNAME(created_at)'))
    ->orderBy(DB::raw('MONTH(created_at)'))
    ->get();

    $totalSizeUsesr = array_fill(0, 12, 0);

    foreach ($sizeUseUser as $data) {
        $month = $data['month'];
        $sizeUse = $data['total_sizeUse'];
        $index = array_search($month, $months);
        if ($index !== false) {
            $totalSizeUsesr[$index] = $sizeUse;
        }
    }

    // Group size usage data
    $sizeUseDataGroup = Group::select(
        DB::raw('MONTHNAME(created_at) as month'),
        DB::raw('SUM(sizeUse) as total_sizeUse')
    )
    ->groupBy(DB::raw('MONTH(created_at)'), DB::raw('MONTHNAME(created_at)'))
    ->orderBy(DB::raw('MONTH(created_at)'))
    ->get();

    $totalSizeUsesGroup = array_fill(0, 12, 0);

    foreach ($sizeUseDataGroup as $data) {
        $month = $data['month'];
        $sizeUse = $data['total_sizeUse'];
        $index = array_search($month, $months);
        if ($index !== false) {
            $totalSizeUsesGroup[$index] = $sizeUse;
        }
    }
//------------------------ends------------

      $Users = User::orderBy('created_at', 'desc')->paginate(8);
      $activity = Activity::orderBy('created_at', 'asc')->get();

      $UsersGroup = Group::orderBy('created_at', 'desc')->paginate(8);
      $file = File::first();
      $sizeMaxData = User::sum('sizeUse');
      $GroupSizePi = Group::sum('sizeUse');
      
      $totalUsers = User::where('cID', '!=', 0)->count();
      $countOnline = User::where('last_seen', 1)->count();
      $countOffline = User::where('last_seen', 0)->count();
      $activityUpload = Activity::where('action', 'Upload')->count();
      $activityCreate = Activity::where('action', 'Create')->count();
      $activityEdit = Activity::where('action', 'Edit')->count();
      $activityDelete = Activity::where('action', 'Delete')->count();


      return view('overview',compact('totalUsers','countOnline','countOffline','activityUpload','activityCreate','activityEdit','activityDelete','Users','file','sizeMaxData','usersDataGraph','newUsersData','loginCounts','UsersGroup','activity','GroupSizePi','sizesData','maxSizes', 'actualdata', 'totalSizeUsesr', 'totalSizeUsesGroup', 'filteredPermissions'));
    
    }



    public function chartsData(Request $request)
    {
      $userId = $request->input('userId');
      $chartData = User::where('id' , $userId)->sum('sizeUse');


      return response()->json(['chartData' => $chartData]);
    }
    public function GroupusageData(Request $request)
    {
      $userId = $request->input('userId');
      $chartData = Group::where('id' , $userId)->sum('sizeUse');
    


      return response()->json(['chartData' => $chartData]);
    }
    public function exportOverview()
    {
      // Add some logging to check if this method is being called
      \Log::info('LoginController export method called');

      return Excel::download(new OverviewExport, 'overview.xlsx');

    }

  

public function getGraphData(Request $request)
{
    $timeframe = $request->query('timeframe', 'month');

    switch ($timeframe) {
        case 'day':
            $format = '%Y-%m-%d';
            $interval = 'day';
            break;
        case 'week':
            $format = '%Y-%u';
            $interval = 'week';
            break;
        case 'month':
            $format = '%Y-%m';
            $interval = 'month';
            break;
        case 'year':
            $format = '%Y';
            $interval = 'year';
            break;
        default:
            $format = '%Y-%m';
            $interval = 'month';
    }

    // Logins Data
    $loginsData = Activity::select(DB::raw("DATE_FORMAT(date, '$format') as period"), DB::raw('COUNT(*) as count'))
        ->where('action', 'Log In')
        ->groupBy('period')
        ->orderBy('period')
        ->get();

    $loginCounts = $this->initializeDataArray($interval);

    foreach ($loginsData as $data) {
        $loginCounts[$data->period] = $data->count;
    }

    // New Users Data
    $newUsers = User::selectRaw("DATE_FORMAT(created_at, '$format') as period, COUNT(*) as count")
        ->groupBy('period')
        ->orderBy('period')
        ->get();

    $newUsersData = $this->initializeDataArray($interval);

    foreach ($newUsers as $data) {
        $newUsersData[$data->period] = $data->count;
    }

    // Total Users Data
    $totalUsers = User::selectRaw("DATE_FORMAT(created_at, '$format') as period, COUNT(*) as total_users")
        ->whereYear('created_at', Carbon::now()->year)
        ->groupBy('period')
        ->orderBy('period')
        ->get();

    $usersDataGraph = $this->initializeDataArray($interval);

    foreach ($totalUsers as $data) {
        $usersDataGraph[$data->period] = $data->total_users;
    }

    // Space Usage Data
    // Fetching max sizes
    $maxSizesData = User::select(
        DB::raw('MONTHNAME(created_at) as month'),
        DB::raw('MAX(sizemax) as max_size')
    )
    ->groupBy(DB::raw('MONTH(created_at)'), DB::raw('MONTHNAME(created_at)'))
    ->orderBy(DB::raw('MONTH(created_at)'))
    ->get();

    $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    $maxSizes = array_fill(0, 12, 0);

    foreach ($maxSizesData as $data) {
        $index = array_search($data->month, $months);
        if ($index !== false) {
            $maxSizes[$index] = $data->max_size;
        }
    }

    // Fetching actual data
    $actualData = User::select(
        DB::raw('MONTHNAME(created_at) as month'),
        DB::raw('SUM(sizeUse) as total_sizeUse')
    )
    ->groupBy(DB::raw('MONTH(created_at)'), DB::raw('MONTHNAME(created_at)'))
    ->orderBy(DB::raw('MONTH(created_at)'))
    ->get();

    $actualdata = array_fill(0, 12, 0);

    foreach ($actualData as $data) {
        $index = array_search($data->month, $months);
        if ($index !== false) {
            $actualdata[$index] = $data->total_sizeUse;
        }
    }

    // Fetching total size users
    $totalSizeUsersData = User::select(
        DB::raw('MONTHNAME(created_at) as month'),
        DB::raw('SUM(sizeUse) as total_sizeUse')
    )
    ->groupBy(DB::raw('MONTH(created_at)'), DB::raw('MONTHNAME(created_at)'))
    ->orderBy(DB::raw('MONTH(created_at)'))
    ->get();

    $totalSizeUsers = array_fill(0, 12, 0);

    foreach ($totalSizeUsersData as $data) {
        $index = array_search($data->month, $months);
        if ($index !== false) {
            $totalSizeUsers[$index] = $data->total_sizeUse;
        }
    }

    // Fetching total size groups
    $totalSizeGroupsData = Group::select(
        DB::raw('MONTHNAME(created_at) as month'),
        DB::raw('SUM(sizeUse) as total_sizeUse')
    )
    ->groupBy(DB::raw('MONTH(created_at)'), DB::raw('MONTHNAME(created_at)'))
    ->orderBy(DB::raw('MONTH(created_at)'))
    ->get();

    $totalSizeGroups = array_fill(0, 12, 0);

    foreach ($totalSizeGroupsData as $data) {
        $index = array_search($data->month, $months);
        if ($index !== false) {
            $totalSizeGroups[$index] = $data->total_sizeUse;
        }
    }

    return response()->json([
        'labels' => array_keys($loginCounts),
        'loginCounts' => array_values($loginCounts),
        'newUsersData' => array_values($newUsersData),
        'usersDataGraph' => array_values($usersDataGraph),
        'maxSizes' => $maxSizes,
        'actualdata' => $actualdata,
        'totalSizeUsers' => $totalSizeUsers,
        'totalSizeGroups' => $totalSizeGroups,
    ]);
}

private function initializeDataArray($interval)
{
    $dataArray = [];
    $currentDate = Carbon::now();

    switch ($interval) {
        case 'day':
            for ($i = 0; $i < 30; $i++) {
                $dataArray[$currentDate->copy()->subDays($i)->format('Y-m-d')] = 0;
            }
            break;
        case 'week':
            for ($i = 0; $i < 52; $i++) {
                $dataArray[$currentDate->copy()->subWeeks($i)->format('Y-W')] = 0;
            }
            break;
        case 'month':
            for ($i = 0; $i < 12; $i++) {
                $dataArray[$currentDate->copy()->subMonths($i)->format('Y-m')] = 0;
            }
            break;
        case 'year':
            for ($i = 0; $i < 5; $i++) {
                $dataArray[$currentDate->copy()->subYears($i)->format('Y')] = 0;
            }
            break;
    }

    return $dataArray;
}



    }
