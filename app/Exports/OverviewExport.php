<?php

namespace App\Exports;

use App\Models\Activity;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OverviewExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
         // Add some logging to check if this method is being called
        \Log::info('OperationExport collection method called');
        
        return Activity::join('users', 'activities.user_id', '=', 'users.id')
            ->select('users.name as username', 'activities.date', 'activities.action','activities.path', 'activities.details')
            ->get();

    }
    public function headings(): array
    {
        return [
            'USER',
            'LOG IN DATE',
            'Action',
            'Path',
            'Details',
        ];
    }
}
