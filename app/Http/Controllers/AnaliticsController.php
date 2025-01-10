<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Activity;
use App\Models\Analitics;
use App\Models\GraphData;
use App\Models\GraphCustom;
use Carbon\Carbon;


class AnaliticsController extends Controller
{    
    //constants for date types -------------------------------------------------------------
    const TODAY = 'Today';
    const LAST_7_DAYS = 'Last 7 Days';
    const LAST_30_DAYS = 'Last 30 Days';
    const CUSTOM_DATE = 'Custom Date';

    //get date range wise data -------------------------------------------------------------
    private function getDateRange($dateRange, $startDate = null, $endDate = null)
    {
        switch ($dateRange) {
            case self::TODAY:
                return [now()->startOfDay(), now()->endOfDay()];
            case self::LAST_7_DAYS:
                return [now()->subDays(6)->startOfDay(), now()->endOfDay()];
            case self::LAST_30_DAYS:
                return [now()->subDays(29)->startOfDay(), now()->endOfDay()];
            case self::CUSTOM_DATE:
                if ($startDate && $endDate) {
                    $startDate = Carbon::parse($startDate)->startOfDay();
                    $endDate = Carbon::parse($endDate)->endOfDay();
                    return [$startDate, $endDate];
                }
                return [null, null];
            default:
                return [null, null];
        }
    }

    //analytics graph code start-------------------------------------------------------------

    //default graph code with activity groups
    public function index(Request $request)
    {
        if (empty(Auth::check())) {
            return redirect('/'); 
        }else{
            $activityGroups = Analitics::where('status', 1)->get();
            return view('analitics.main', compact('activityGroups'));
        }        
    }

    //get activity type by activity groups id
    public function getActivityById(Request $request)
    {
        $activityGroupId = $request->input('activityGroupId');
        $activityTypes = Analitics::where('parent', $activityGroupId)->where('status', 1)->get(['id', 'name']);
        return response()->json($activityTypes);
    }

    //get graph type by activity type id
    public function getGraphTypeById(Request $request)
    {
        $activityTypeId = $request->input('id');
        $graphData  = Analitics::where('id', $activityTypeId)->where('status', 1)->first(['id', 'graph_type', 'flag']);

        if ($graphData) {
            $graphTypes = json_decode($graphData->graph_type, true);
            $object = new \stdClass();

            foreach ($graphTypes['types'] as $key => $item) {
                $newItem = new \stdClass();
                $newItem->id = $item;
                $newItem->name = ucfirst($item);
                $object->{$key} = $newItem;
            }

            return response()->json($object);
        }
    }

    //get graph data after graph type selection
    public function getGraph(Request $request)
    {
        $userId = Auth::user()->id;
        $userType = Auth::user()->usertype;
        $allactivityGroups = Analitics::where('parent', 0)->where('status', 1)->get();
        $allGraphFilters = GraphData::where('user_id', $userId)->get();
        $graphResults = [];
        $addGraphDesign = '';

        foreach ($allGraphFilters as $filter) {
            $allactivityTypes = '';
            if (!empty($filter->activitygroup_id)) {
                $allactivityTypes = Analitics::where('parent', $filter->activitygroup_id)->where('status', 1)->get();
            }
            $allgraphtype = '';
            $activityName = '';
            $activityFlag = '';
            if (!empty($filter->activitytype_id)) {
                $allgraphtypejson = Analitics::where('id', $filter->activitytype_id)->first();
                $allgraphtype = json_decode($allgraphtypejson->graph_type, true);
                $activityName = $allgraphtypejson->name;
                $activityFlag = $allgraphtypejson->flag;
            }

            if ($activityFlag === 'inactive') {
                $query = DB::table('users')
                    ->leftJoin('activities', 'users.id', '=', 'activities.user_id')
                    ->selectRaw('users.usertype as name, COUNT(users.id) as count')
                    ->whereNull('activities.id')
                    ->where('users.status', 1)
                    ->groupBy('users.usertype');

                list($startDate, $endDate) = $this->getDateRangeFromFilter($filter);

                if ($startDate && $endDate) {
                    $query->whereBetween('users.created_at', [$startDate, $endDate]);
                }
            } elseif ($activityFlag === 'user_count_group') {
                $query = DB::table('users')
                    ->join('clients', 'users.client_id', '=', 'clients.id')
                    ->join('groups', 'users.group_id', '=', 'groups.id')
                    ->join('companies', 'users.company_id', '=', 'companies.id')
                    ->selectRaw('users.name as name, COUNT(users.group_id) as count')
                    ->where('users.status', 1)
                    ->groupBy('users.group_id', 'users.name');

                list($startDate, $endDate) = $this->getDateRangeFromFilter($filter);

                if ($startDate && $endDate) {
                    $query->whereBetween('users.created_at', [$startDate, $endDate]);
                }
            } elseif ($activityFlag === 'used_size_group') {
                $query = DB::table('users')
                    ->join('clients', 'users.client_id', '=', 'clients.id')
                    ->join('groups', 'users.group_id', '=', 'groups.id')
                    ->join('companies', 'users.company_id', '=', 'companies.id')
                    ->selectRaw('users.name as name, SUM(users.sizeUse) as count')
                    ->where('users.status', 1)
                    ->groupBy('users.group_id', 'users.name');

                list($startDate, $endDate) = $this->getDateRangeFromFilter($filter);

                if ($startDate && $endDate) {
                    $query->whereBetween('users.created_at', [$startDate, $endDate]);
                }
            } elseif ($activityFlag === 'max_size_group') {
                $query = DB::table('users')
                    ->join('clients', 'users.client_id', '=', 'clients.id')
                    ->join('groups', 'users.group_id', '=', 'groups.id')
                    ->join('companies', 'users.company_id', '=', 'companies.id')
                    ->selectRaw('users.name as name, SUM(users.sizeMax) as count')
                    ->where('users.status', 1)
                    ->groupBy('users.group_id', 'users.name');

                list($startDate, $endDate) = $this->getDateRangeFromFilter($filter);

                if ($startDate && $endDate) {
                    $query->whereBetween('users.created_at', [$startDate, $endDate]);
                }
            } elseif ($activityFlag === 'file_extension_count') {
                $query = DB::table('users')
                    ->join('files', 'users.id', '=', 'files.created_by')
                    ->selectRaw('files.extension as name, COUNT(files.created_by) as count')
                    ->where('users.status', 1)
                    ->groupBy('files.extension');

                list($startDate, $endDate) = $this->getDateRangeFromFilter($filter);

                if ($startDate && $endDate) {
                    $query->whereBetween('users.created_at', [$startDate, $endDate]);
                }
            } elseif ($activityFlag === 'most_active_group') {
                $query = DB::table('users')
                    ->join('groups', 'users.group_id', '=', 'groups.id')
                    ->selectRaw('groups.name as name, COUNT(users.id) as count')
                    ->where('users.status', 1)
                    ->whereNotNull('users.group_id')
                    ->groupBy('groups.name');

                list($startDate, $endDate) = $this->getDateRangeFromFilter($filter);

                if ($startDate && $endDate) {
                    $query->whereBetween('users.created_at', [$startDate, $endDate]);
                }
            } elseif ($activityFlag === 'user_count_role') {
                $query = DB::table('users')
                    ->join('clients', 'users.client_id', '=', 'clients.id')
                    ->join('roles', 'users.role_id', '=', 'roles.id')
                    ->join('companies', 'users.company_id', '=', 'companies.id')
                    ->selectRaw('roles.name as name, COUNT(users.role_id) as count')
                    ->where('users.status', 1)
                    ->groupBy('users.role_id', 'roles.name');

                list($startDate, $endDate) = $this->getDateRangeFromFilter($filter);

                if ($startDate && $endDate) {
                    $query->whereBetween('users.created_at', [$startDate, $endDate]);
                }
            } elseif ($activityFlag === 'most_active_role') {
                $query = DB::table('users')
                    ->join('roles', 'users.role_id', '=', 'roles.id')
                    ->selectRaw('roles.name as name, COUNT(users.id) as count')
                    ->where('users.status', 1)
                    ->whereNotNull('users.role_id')
                    ->groupBy('roles.name');

                list($startDate, $endDate) = $this->getDateRangeFromFilter($filter);

                if ($startDate && $endDate) {
                    $query->whereBetween('users.created_at', [$startDate, $endDate]);
                }
            } else {
                $query = Activity::selectRaw('users.name as name, COUNT(activities.id) as count')
                    ->join('users', 'activities.user_id', '=', 'users.id')
                    ->where('activities.flag', $activityFlag)
                    ->where('users.status', 1)
                    ->groupBy('users.name');

                if (in_array($userType, ['client', 'group', 'user', 'company'])) {
                    $query->where('activities.user_id', $userId);
                }

                list($startDate, $endDate) = $this->getDateRangeFromFilter($filter);

                if ($startDate && $endDate) {
                    $query->whereBetween('activities.created_at', [$startDate, $endDate]);
                }
            }

            $getCount = $query->get();
            $getLabels = $getCount->pluck('name')->toArray();
            $getData = $getCount->pluck('count')->toArray();
            $fill = ($filter->graphtype === 'area') ? true : false; // Area chart fill
            $graphResults[] = [
                'id' => $filter->id,
                'getLabels' => $getLabels,
                'getData' => $getData,
                'getAnaliticalData' => $filter,
                'name' => $activityName,
                'type' => $filter->graphtype,
                'activityGroups' => $filter->activitygroup_id,
                'activityType' => $filter->activitytype_id,
                'dateType' => $filter->datetype,
                'startDate' => $filter->startdate,
                'endDate' => $filter->enddate,
                'allactivityTypes' => $allactivityTypes,
                'allgraphtype' => $allgraphtype,
                'flag' => $activityFlag,
                'default' => $filter->default,
                'userId' => $userId,
                'fill' => $fill
            ];
        }

        $addGraphDesign = !collect($graphResults)->contains(fn($result) => $result['default'] == 0);

        return response()->json([
            'html' => view('analitics.graph')
                ->with('graphResults', $graphResults)
                ->with('allactivityGroups', $allactivityGroups)
                ->render(),
            'graphResults' => $graphResults,
            'addGraphDesign' => $addGraphDesign
        ]);
    }

    //common code for date filter
    private function getDateRangeFromFilter($filter)
    {
        $startDate = $filter->startdate;
        $endDate = $filter->enddate;

        if ($filter->datetype === self::CUSTOM_DATE) {
            $startDate = Carbon::parse($filter->startdate)->startOfMinute();
            $endDate = Carbon::parse($filter->enddate)->endOfMinute();
        } else {
            list($startDate, $endDate) = $this->getDateRange($filter->datetype);
        }

        return [$startDate, $endDate];
    }

    //remove all graph except default=1
    public function removeGraph(Request $request)
    {
        $userId = Auth::user()->id;
        $graphData = GraphData::where('user_id', $userId)->where('default', '!=', 1)->delete();
        if ($graphData) {
            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }

    //delete graph except default=1
    public function deleteGraph($id)
    {
        try {
            $userId = Auth::user()->id;
            $graphData = GraphData::where('user_id', $userId)->where('default', '!=', 1)->find($id);

            if (!$graphData) {
                return response()->json([
                    'success' => false,
                    'message' => 'Graph data not found.',
                ], 404);
            }

            $graphData->delete();

            return response()->json([
                'success' => true,
                'message' => 'Graph data deleted successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the graph data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    //add graph with check user id exist or not
    public function addGraph(Request $request)
    {
        $userId = Auth::user()->id;
        $data = [
            'user_id' => $userId,
            'activitygroup_id' => $request->input('activityGroupId'),
            'activitytype_id' => $request->input('activityTypeId'),
            'graphtype' => $request->input('graphType'),
            'datetype' => $request->input('dateType'),
            'startdate' => $request->input('startDate'),
            'enddate' => $request->input('endDate'),
            'flag' => $request->input('flag'),
        ];

        $check = GraphData::where('user_id', $userId)->exists();

        if (!$check) {
            $data['default'] = 1;
        }

        $graphData = GraphData::create($data);

        return response()->json(['status' => (bool)$graphData]);
    }

    //update graph filter dropdown data
    public function updateGraph(Request $request)
    {
        $activityGroupId = $request->input('activityGroupId');
        $activityTypeId = $request->input('activityTypeId');
        $graphType = $request->input('graphType');
        $flag = $request->input('flag');
        $dateRange = $request->input('dateType');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $graphId = $request->input('graphId');

        $graphData = GraphData::where('id', $graphId)
            ->update([
                'activitygroup_id' => $activityGroupId,
                'activitytype_id' => $activityTypeId,
                'graphtype' => $graphType,
                'datetype' => $dateRange,
                'startdate' => $startDate,
                'enddate' => $endDate,
                'flag' => $flag,
            ]);

        if ($graphData) {
            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }


    //metrics graph-----------------------------------------------------------------------
    public function customGraph(Request $request)
    {
        if (empty(Auth::check())) {
            return redirect('/'); //Check auth
        }else{
            $activityGroups = Analitics::where('matrics_status', 1)->get();
            return view('analitics.custom_main', compact('activityGroups'));
        }        
    }

    public function getCustomActivityById(Request $request)
    {
        $activityGroupId = $request->input('activityGroupId');
        $activityGroupIdOne = $request->input('activityGroupIdOne');
        $activityTypes = Analitics::where('parent', $activityGroupId)
            ->where('is_metrics', 1)
            ->where('matrics_status', 1)
            ->get(['id', 'name', 'flag']);

        $activityTypesOne = Analitics::where('parent', $activityGroupIdOne)
            ->where('is_metrics', 1)
            ->where('matrics_status', 1)
            ->get(['id', 'name', 'flag']);

        $response = [
            'activityTypes' => $activityTypes,
            'activityTypesOne' => $activityTypesOne
        ];

        return response()->json($response);
    }

    public function getCustomGraphTypeById(Request $request)
    {
        $graphData = '{"types": ["bar", "line", "area"]}';
        if ($graphData) {
            $graphTypes = json_decode($graphData, true);
            $object = new \stdClass();

            foreach ($graphTypes['types'] as $key => $item) {
                $newItem = new \stdClass();
                $newItem->id = $item;
                $newItem->name = ucfirst($item);
                $object->{$key} = $newItem;
            }

            return response()->json($object);
        }
    }

    public function getCustomGraph(Request $request)
    {
        $userId = Auth::user()->id;
        $userType = Auth::user()->usertype;
        $allactivityGroups = Analitics::where('parent', 0)->where('matrics_status', 1)->get();
        $allactivityGroupsOne = Analitics::where('parent', 0)->where('matrics_status', 1)->get();
        $allGraphFilters = GraphCustom::where('user_id', $userId)->get();
        $graphResults = [];
        foreach ($allGraphFilters as $filter) {
            $allactivityTypes = '';
            $allactivityTypesOne = '';
            if (!empty($filter->activitygroup_id)) {
                $allactivityTypes = Analitics::where('parent', $filter->activitygroup_id)->where('matrics_status', 1)->get();
            }

            if (!empty($filter->activitygroup_id_one)) {
                $allactivityTypesOne = Analitics::where('parent', $filter->activitygroup_id_one)->where('matrics_status', 1)->get();
            }

            $allgraphtype = '';
            $labelName = '';
            $activityFlag = '';
            if (!empty($filter->activitytype_id)) {
                $allgraphtypejson = Analitics::where('id', $filter->activitytype_id)->first();
                $allgraphtype = json_decode($allgraphtypejson->custom_graph_type, true);
                $labelName = $allgraphtypejson->name;
                $activityFlag = $allgraphtypejson->flag;
            }


            $allgraphtypeOne = '';
            $labelNameOne = '';
            $activityFlagOne = '';
            if (!empty($filter->activitytype_id_one)) {
                $allgraphtypejson = Analitics::where('id', $filter->activitytype_id_one)->first();
                $allgraphtypeOne = json_decode($allgraphtypejson->custom_graph_type, true);
                $labelNameOne = $allgraphtypejson->name;
                $activityFlagOne = $allgraphtypejson->flag;
            }

            if ($activityFlag === 'inactive' || $activityFlagOne === 'inactive') {
                $query = DB::table('users')
                    ->leftJoin('activities', 'users.id', '=', 'activities.user_id')
                    ->selectRaw('users.usertype as name, COUNT(users.id) as count')
                    ->whereNull('activities.id')
                    ->where('users.status', 1)
                    ->groupBy('users.usertype');

                $queryOne = DB::table('users')
                    ->leftJoin('activities', 'users.id', '=', 'activities.user_id')
                    ->selectRaw('users.usertype as name, COUNT(users.id) as count')
                    ->whereNull('activities.id')
                    ->where('users.status', 1)
                    ->groupBy('users.usertype');
            } elseif ($activityFlag === 'file_extension_count' || $activityFlagOne === 'file_extension_count') {
                $query = DB::table('users')
                    ->join('files', 'users.id', '=', 'files.created_by')
                    ->selectRaw('files.extension as name, COUNT(files.created_by) as count')
                    ->where('users.status', 1)
                    ->groupBy('files.extension');

                $queryOne = DB::table('users')
                    ->join('files', 'users.id', '=', 'files.created_by')
                    ->selectRaw('files.extension as name, COUNT(files.created_by) as count')
                    ->where('users.status', 1)
                    ->groupBy('files.extension');
            } else {
                $query = Activity::selectRaw('users.name as name, COUNT(activities.id) as count')
                    ->join('users', 'activities.user_id', '=', 'users.id')
                    ->where('activities.flag', $activityFlag)
                    ->groupBy('users.name');
                if (in_array($userType, ['client', 'group', 'user', 'company'])) {
                    $query->where('activities.user_id', $userId);
                }

                $queryOne = Activity::selectRaw('users.name as name, COUNT(activities.id) as count')
                    ->join('users', 'activities.user_id', '=', 'users.id')
                    ->where('activities.flag', $activityFlagOne)
                    ->groupBy('users.name');
                if (in_array($userType, ['client', 'group', 'user', 'company'])) {
                    $queryOne->where('activities.user_id', $userId);
                }
            }

            $startDate = $filter->startdate;
            $endDate = $filter->enddate;

            if ($filter->datetype === self::CUSTOM_DATE) {
                $startDate = Carbon::parse($filter->startdate)->startOfMinute();
                $endDate = Carbon::parse($filter->enddate)->endOfMinute();
            } else {
                list($startDate, $endDate) = $this->getDateRange($filter->datetype);
            }

            if ($activityFlag === 'inactive' || $activityFlagOne === 'inactive') {
                if ($startDate && $endDate) {
                    $query->whereBetween('users.created_at', [$startDate, $endDate]);
                }
                if ($startDate && $endDate) {
                    $queryOne->whereBetween('users.created_at', [$startDate, $endDate]);
                }
            } elseif ($activityFlag === 'file_extension_count' || $activityFlagOne === 'file_extension_count') {
                if ($startDate && $endDate) {
                    $query->whereBetween('users.created_at', [$startDate, $endDate]);
                }
                if ($startDate && $endDate) {
                    $queryOne->whereBetween('users.created_at', [$startDate, $endDate]);
                }
            }else {
                if ($startDate && $endDate) {
                    $query->whereBetween('activities.created_at', [$startDate, $endDate]);
                }
                if ($startDate && $endDate) {
                    $queryOne->whereBetween('activities.created_at', [$startDate, $endDate]);
                }
            }

            $getCount = $query->get();
            $getLabels = $getCount->pluck('name')->toArray();
            $getData = $getCount->pluck('count')->toArray();

            $getCountOne = $queryOne->get();
            $getLabelsOne = $getCountOne->pluck('name')->toArray();
            $getDataOne = $getCountOne->pluck('count')->toArray();

            $fill = ($filter->graphtype === 'area') ? true : false; // Area chart fill
            $fillOne = ($filter->graphtype_one === 'area') ? true : false; // Area chart fill

            $graphResults[] = [
                'id' => $filter->id,
                'label' => $labelName,
                'labelOne' => $labelNameOne,
                'getLabels' => $getLabels,
                'getLabelsOne' => $getLabelsOne,
                'getData' => $getData,
                'getDataOne' => $getDataOne,
                'type' => $filter->graphtype,
                'typeOne' => $filter->graphtype_one,
                'allgraphtype' => $allgraphtype,
                'allgraphtypeOne' => $allgraphtypeOne,
                'activityGroups' => $filter->activitygroup_id,
                'activityGroupsOne' => $filter->activitygroup_id_one,
                'activityType' => $filter->activitytype_id,
                'activityTypeOne' => $filter->activitytype_id_one,
                'dateType' => $filter->datetype,
                'startDate' => $filter->startdate,
                'endDate' => $filter->enddate,
                'allactivityTypes' => $allactivityTypes,
                'allactivityTypesOne' => $allactivityTypesOne,
                'default' => $filter->default,
                'userId' => $userId,
                'fill' => $fill,
                'fillOne' => $fillOne,
            ];
        }

        return response()->json([
            'html' => view('analitics.custom_graph')
                ->with('graphResults', $graphResults)
                ->with('allactivityGroups', $allactivityGroups)
                ->with('allactivityGroupsOne', $allactivityGroupsOne)
                ->render(),
            'graphResults' => $graphResults,
        ]);
    }

    public function removeCustomGraph(Request $request)
    {
        $userId = Auth::user()->id;
        $graphData = GraphCustom::where('user_id', $userId)->where('default', '!=', 1)->delete();
        if ($graphData) {
            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }

    public function deleteCustomGraph($id)
    {
        try {
            $userId = Auth::user()->id;
            $graphData = GraphCustom::where('user_id', $userId)->find($id);

            if (!$graphData) {
                return response()->json([
                    'success' => false,
                    'message' => 'Graph data not found.',
                ], 404);
            }

            $graphData->delete();

            return response()->json([
                'success' => true,
                'message' => 'Graph data deleted successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the graph data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function addCustomGraph(Request $request)
    {
        $userId = Auth::user()->id;
        $data = [
            'user_id' => $userId,
            'activitygroup_id' => $request->input('activityGroupId'),
            'activitytype_id' => $request->input('activityTypeId'),
            'graphtype' => $request->input('graphType'),
            'activitygroup_id_one' => $request->input('activityGroupIdOne'),
            'activitytype_id_one' => $request->input('activityTypeIdOne'),
            'graphtype_one' => $request->input('graphTypeOne'),
            'datetype' => $request->input('dateType'),
            'startdate' => $request->input('startDate'),
            'enddate' => $request->input('endDate'),
            'flag' => $request->input('flag'),
        ];

        $check = GraphCustom::where('user_id', $userId)->exists();

        if (!$check) {
            $data['default'] = 1;
        }

        $graphData = GraphCustom::create($data);

        return response()->json(['status' => (bool)$graphData]);
    }

    public function updateCustomGraph(Request $request)
    {
        $activityGroupId = $request->input('activityGroupId');
        $activityTypeId = $request->input('activityTypeId');
        $graphType = $request->input('graphType');

        $activityGroupIdOne = $request->input('activityGroupIdOne');
        $activityTypeIdOne = $request->input('activityTypeIdOne');
        $graphTypeOne = $request->input('graphTypeOne');

        $flag = $request->input('flag');
        $dateRange = $request->input('dateType');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $graphId = $request->input('graphId');

        $graphData = GraphCustom::where('id', $graphId)
            ->update([
                'activitygroup_id' => $activityGroupId,
                'activitytype_id' => $activityTypeId,
                'graphtype' => $graphType,
                'activitygroup_id_one' => $activityGroupIdOne,
                'activitytype_id_one' => $activityTypeIdOne,
                'graphtype_one' => $graphTypeOne,
                'datetype' => $dateRange,
                'startdate' => $startDate,
                'enddate' => $endDate,
                'flag' => $flag,
            ]);

        if ($graphData) {
            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }
}
