@php
$graph = json_decode($graph);
$allactivityGroups = json_decode($allactivityGroups);
@endphp

@if($graph)
<div class="default-filter flex items-center gap-2 flex-wrap filterList" data-row="{{ $graph->id }}">
    <div class="px-4 py-3 md:px-3 md:py-2 flex justify-start items-start gap-3 flex-wrap"> 

        <select
            class="dynamic-select custom-safety-btn actGroupDropdown w-full md:w-1/3 p-2 bg-white border border-c-gray rounded-md outline-none text-c-black"
            data-row="{{ $graph->id }}"
            data-fetch-url="{{ route('fetch.actType.by.actGroup') }}"
            data-next="actTypeDropdown">
            <option class="activity-custom-dropdown-menu" value="">All Activity Group</option>
            @if(!empty($allactivityGroups))
            @foreach($allactivityGroups as $activityGroup)
            <option value="{{ $activityGroup->id }}" {{ ($graph->activityGroups == $activityGroup->id) ? 'selected' : '' }}>{{ $activityGroup->name }}</option>
            @endforeach
            @endif
        </select>

        <select
            class="dynamic-select custom-safety-btn actTypeDropdown w-full md:w-1/3 p-2 bg-white border border-c-gray rounded-md outline-none text-c-black "
            data-row="{{ $graph->id }}"
            data-fetch-url="{{ route('fetch.graphType.by.actType') }}"
            data-next="graphTypeDropdown">
            <option value="">Select Activity Type</option>
            @if($graph->activityGroups && !empty($graph->allactivityTypes))
            @foreach($graph->allactivityTypes as $activityType)
            <option value="{{ $activityType->id }}" {{ ($graph->activityType == $activityType->id) ? 'selected' : '' }}>{{ $activityType->name }}</option>
            @endforeach
            @endif
        </select>


        <select
            class="dynamic-select custom-safety-btn graphTypeDropdown w-full md:w-1/3 p-2 bg-white border border-c-gray rounded-md outline-none text-c-black"
            data-row="{{ $graph->id }}">
            <option value="">Select Graph Type</option>
            @if(!empty($graph->allgraphtype->types))                       
            @foreach($graph->allgraphtype->types as $graphType)                       
            <option value="{{ $graphType }}" {{ ($graph->type == $graphType) ? 'selected' : '' }}>
                {{ ucfirst($graphType) }}
            </option>
            @endforeach
            @endif
        </select>

        <select
            class="dateTypeDropdown custom-safety-btn w-full md:w-1/3 p-2 bg-white border border-c-gray rounded-md outline-none text-c-black "
            data-row="{{ $graph->id }}">
            <option value="">Select Date Type</option>
            <option value="Custom Date" {{ ($graph->dateType == 'Custom Date') ? 'selected' : '' }}>Custom Date</option>
            <option value="Today" {{ ($graph->dateType == 'Today') ? 'selected' : '' }}>Today</option>
            <option value="Last 7 Days" {{ ($graph->dateType == 'Last 7 Days') ? 'selected' : '' }}>Last 7 Days</option>
            <option value="Last 30 Days" {{ ($graph->dateType == 'Last 30 Days') ? 'selected' : '' }}>Last 30 Days</option>
        </select>

        <div class="customDateInputs date-select custom-dates-btn rounded px-1 mr-1 hover:border-yellow-300 {{ ($graph->dateType == 'Custom Date') ? '' : 'hidden' }}" data-row="{{ $graph->id }}">
            <input type="datetime-local" name="start-date" class="startdate outline-none bg-gray-100 w-44 py-1 pl-2" data-row="{{ $graph->id }}" value="{{ $graph->startDate }}">
        </div>

        <div class="customDateInputs date-select custom-dates-btn rounded px-1 mr-1 hover:border-yellow-300 {{ ($graph->dateType == 'Custom Date') ? '' : 'hidden' }}" data-row="{{ $graph->id }}">
            <input type="datetime-local" name="end-date" class="enddate outline-none bg-gray-100 w-44 py-1 pl-2" data-row="{{ $graph->id }}" value="{{ $graph->endDate }}">
        </div>
    </div>
</div>
@endif