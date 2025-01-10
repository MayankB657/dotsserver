<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AuditLog;

use App\Models\User;
use App\Models\Roles;
use Carbon\Carbon;
use App\Exports\OperationExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Activity;
use App\Helpers\PermissionHelper;


class OperationLogController extends Controller
{
     public function __construct()
    {
        //commented for development
        $this->middleware('auth');
    }
     public function index()
    {    	
        $filteredPermissions = PermissionHelper::getFilteredPermissions(auth()->id());
        $log = Activity::with('user')->orderBy('created_at', 'desc')->paginate(13);
        $roles = Roles::get();
        return view('operationLog',compact('log', 'roles', 'filteredPermissions'));
    }

    public function filter(Request $request)
    {
        
        $filter = $request->input('filter'); 
        $query = Activity::with('user');
        $roleId= @$request->roles?$request->roles:0;


        switch ($filter) {
            case 'today':
                $query->whereDate('created_at', Carbon::today());
                break;
            case '7-days':
                $query->where('created_at', '>=', Carbon::today()->subDays(7));
                break;
            case '30-days':
                $query->where('created_at', '>=', Carbon::today()->subDays(30));
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

        $tag = $request->input('tag');

        if($tag && $tag != 'All'){
            $query->where('action', $tag);
        }
    	
        $log = $query->take(7)->get();

        $view = view('partials.operationLogEntries', compact('log'))->render();

        return response()->json(['html' => $view]);
    }

     public function export(Request $request)
    {
       
          // Add some logging to check if this method is being called
        // \Log::info('LoginController export method called');

        return Excel::download(new OperationExport($request), 'operation.xlsx');
    }
}
