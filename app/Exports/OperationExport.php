<?php

namespace App\Exports;


use App\Models\Roles;
use App\Models\Activity;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OperationExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function collection()
    {


       /*new implementation starts*/
      $filter = $this->request->input('filter');
    $query = Activity::with('user');
    $tag = $this->request->input('tag');
    $roleId = $this->request->roles ? $this->request->roles : 0;

       

       switch ($filter) {
        case 'today':
        $query->whereDate('activities.created_at', Carbon::today());
        break;
        case '7-days':
        $query->where('activities.created_at', '>=', Carbon::today()->subDays(7));
        break;
        case '30-days':
        $query->where('activities.created_at', '>=', Carbon::today()->subDays(30));
        break;
        case 'roles':
        if ($roleId) {
            $query->whereHas('user', function ($query) use ($roleId) {
                $query->where('roleID', $roleId);
            });
        }
        break;
        case 'dateTime':
        $query->whereBetween('activities.created_at', [
            date('Y-m-d H:i:s', strtotime($this->request->start_date_time)),
            date('Y-m-d H:i:s', strtotime($this->request->end_date_time))
        ]);
        break;
        default:
        break;
    }

    $roles = $this->request->input('roles');
    if ($roles && $roleId) {
        $query->whereHas('user', function ($query) use ($roleId) {
            $query->where('roleID', $roleId);
        });
    }

    $start = $this->request->input('start_date_time');
    $end = $this->request->input('end_date_time');

    if ($start && $end) {
        $query->whereBetween('activities.created_at', [
            date('Y-m-d H:i:s', strtotime($this->request->start_date_time)),
            date('Y-m-d H:i:s', strtotime($this->request->end_date_time))
        ]);
    }


    if($tag && $tag != 'All'){
        $query->where('action', $tag);
    }

    $query->join('users', 'activities.user_id', '=', 'users.id')
    ->select('users.name as user_name', 'activities.created_at as date', 'activities.action', 'activities.details');

// dd($query->get()->toArray());
    return Activity::with('user')
    ->fromSub($query, 'activities')  // Use fromSub to join with the $query
    ->get();

    /*new implementation ends*/

}

public function headings(): array
{
    return [
        'USER',
        'LOG IN DATE',
        'Action',
        'Details',
    ];
}
}
