<?php

namespace App\Exports;

use App\Models\LoginLog;
use App\Models\Roles;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LoginsExport implements FromCollection, WithHeadings
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
            $query = LoginLog::with('user');
            $roleId= @$this->request->roles?$this->request->roles:0;
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
                case 'roles':
                if ($roleId) {

                    
                 $query->whereHas('user', function ($query) use ($roleId) {
                    $query->where('roleID', $roleId);
                    });
                 }

                    break;
             case 'dateTime':
           
            $query->whereBetween('created_at', [
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

        if($start && $end){
            $query->whereBetween('login_logs.created_at', [
                date('Y-m-d H:i:s', strtotime($this->request->start_date_time)),
                date('Y-m-d H:i:s', strtotime($this->request->end_date_time))
            ]);
        }



         $query->join('users', 'login_logs.user_id', '=', 'users.id')
            ->select('users.name as user_name', 'login_logs.login_time', 'login_logs.system', 'login_logs.system_version', 'login_logs.browser', 'login_logs.login_address');

         // dd($query->get()->toArray());
         return LoginLog::with('user')
            ->fromSub($query, 'login_logs')  // Use fromSub to join with the $query
            ->get();

        /*new implementation ends*/
    }

    public function headings(): array
    {
        return [
            'USER',
            'LOG IN DATE',
            'SYSTEM',
            'SYSTEM VERSION',
            'BROWSER',
            'LOGIN ADDRESS',
        ];
    }
}
