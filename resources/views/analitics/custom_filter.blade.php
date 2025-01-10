@php
$graph = $graph ? json_decode($graph) : null;
$allactivityGroups = $allactivityGroups ? json_decode($allactivityGroups) : null;
$allactivityGroupsOne = $allactivityGroupsOne ? json_decode($allactivityGroupsOne) : null;
@endphp

@if($graph)

<div class="default-filter flex items-center gap-2 flex-wrap filterList" data-row="{{ $graph->id }}">
    <div class="flex items-start justify-center gap-5">

        <div class="border border-c-light-black rounded-md px-1.5 py-2 flex flex-col items-center justify-center gap-3 sm:block">
            <h1 class="text-center pb-2 font-bold text-c-black">Matrix One</h1>
            <div class="chart-type border inline-block relative">
                <select
                    class="dynamic-select actGroupDropdown chart-type-btn rounded px-2 py-1 custom-outline custom-safety-btn"
                    data-row="{{ $graph->id }}"
                    data-fetch-url="{{ route('fetch.custom.actType.by.actGroup') }}"
                    data-next="actTypeDropdown">
                    <option value="">Activity Group</option>
                    @if(!empty($allactivityGroups))
                    @foreach($allactivityGroups as $valActivityGroup)
                    <option value="{{ $valActivityGroup->id }}" {{ ($graph->activityGroups == $valActivityGroup->id) ? 'selected' : '' }}>{{ $valActivityGroup->name }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            <div class="chart-type border inline-block relative">
                <select
                    class="dynamic-select actTypeDropdown chart-type-btn rounded px-2 py-1 custom-outline custom-safety-btn"
                    data-row="{{ $graph->id }}"
                    data-fetch-url="{{ route('fetch.custom.graphType.by.actType') }}"
                    data-next="graphTypeDropdown">
                    <option value="">Activity Type</option>
                    @if($graph->activityGroups && !empty($graph->allactivityTypes))
                    @foreach($graph->allactivityTypes as $valActivityType)
                    <option value="{{ $valActivityType->id }}" {{ ($graph->activityType == $valActivityType->id) ? 'selected' : '' }}>{{ $valActivityType->name }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            <div class="chart-type border inline-block relative" data-row="{{ $graph->id }}">
                <select
                    class="dynamic-select custom-safety-btn chart-type-btn graphTypeDropdown w-full md:w-1/3 px-2 py-1 bg-white border border-c-gray rounded-md outline-none text-c-black"
                    data-row="{{ $graph->id }}">
                    <option value="">Select Graph Type</option>
                    @if(!empty($graph->allgraphtype->types))
                    @foreach($graph->allgraphtype->types as $valGraphType)
                    <option value="{{ $valGraphType }}" {{ ($graph->type == $valGraphType) ? 'selected' : '' }}>
                        {{ ucfirst($valGraphType) }}
                    </option>
                    @endforeach
                    @endif
                </select> 
            </div>
        </div>

        <div class="border border-c-light-black rounded-md px-1.5 py-2 flex flex-col items-center justify-center gap-3 sm:block">
            <h1 class="text-center pb-2 font-bold text-c-black">Matrix Two</h1>
            <div class="chart-type border inline-block relative">
                <select
                    class="dynamic-select actGroupDropdownOne chart-type-btn rounded px-2 py-1 custom-outline custom-safety-btn"
                    data-row="{{ $graph->id }}"
                    data-fetch-url="{{ route('fetch.custom.actType.by.actGroup') }}"
                    data-next="actTypeDropdownOne">
                    <option value="">Activity Group</option>
                    @if(!empty($allactivityGroupsOne))
                    @foreach($allactivityGroupsOne as $valGroupOne)
                    <option value="{{ $valGroupOne->id }}" {{ ($graph->activityGroupsOne == $valGroupOne->id) ? 'selected' : '' }}>{{ $valGroupOne->name }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            <div class="chart-type border inline-block relative">
                <select
                    class="dynamic-select actTypeDropdownOne chart-type-btn rounded px-2 py-1 custom-outline custom-safety-btn"
                    data-row="{{ $graph->id }}"
                    data-fetch-url="{{ route('fetch.custom.graphType.by.actType') }}"
                    data-next="graphTypeDropdownOne">
                    <option value="">Activity Type</option>
                    @if(!empty($graph->allactivityTypesOne))
                    @foreach($graph->allactivityTypesOne as $valActivityTypOne)
                    <option value="{{ $valActivityTypOne->id }}" {{ ($graph->activityTypeOne == $valActivityTypOne->id) ? 'selected' : '' }}>{{ $valActivityTypOne->name }}</option>
                    @endforeach
                    @endif
                </select>
            </div>

            <div class="chart-type border inline-block relative">
                <select
                    class="dynamic-select custom-safety-btn chart-type-btn graphTypeDropdownOne w-full md:w-1/3 px-2 py-1 bg-white border border-c-gray rounded-md outline-none text-c-black"
                    data-row="{{ $graph->id }}">
                    <option value="">Select Graph Type</option>
                    @if(!empty($graph->allgraphtypeOne->types))
                    @foreach($graph->allgraphtypeOne->types as $valGraphTypeOne)
                    <option value="{{ $valGraphTypeOne }}" {{ ($graph->typeOne == $valGraphTypeOne) ? 'selected' : '' }}>
                        {{ ucfirst($valGraphTypeOne) }}
                    </option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>

        <!-- date commented  -->
        <div class="chart-type inline-block">
            <select class="dateTypeDropdown custom-graph-dates-btn chart-type-btn rounded px-2 py-1 custom-outline custom-safety-btn" data-row="{{ $graph->id }}">
                <option value="">Select Date Type</option>
                <option value="Custom Date" {{ ($graph->dateType == 'Custom Date') ? 'selected' : '' }}>Custom Date</option>
                <option value="Today" {{ ($graph->dateType == 'Today') ? 'selected' : '' }}>Today</option>
                <option value="Last 7 Days" {{ ($graph->dateType == 'Last 7 Days') ? 'selected' : '' }}>Last 7 Days</option>
                <option value="Last 30 Days" {{ ($graph->dateType == 'Last 30 Days') ? 'selected' : '' }}>Last 30 Days</option>
            </select>

            <div class="customDateInputs custom-graph-dates-btn date-select custom-safety-btn rounded px-6  mr-1 hover:border-yellow-300 {{ ($graph->dateType == 'Custom Date') ? '' : 'hidden' }}" data-row="{{ $graph->id }}">
                <input type="datetime-local" id="start_date" name="start-date" class="startdate outline-none bg-gray-100 w-44 py-1 pl-2" data-row="{{ $graph->id }}" value="{{ $graph->startDate }}">
            </div>
            <div class="customDateInputs custom-graph-dates-btn date-select custom-safety-btn rounded px-6 mr-1 hover:border-yellow-300 {{ ($graph->dateType == 'Custom Date') ? '' : 'hidden' }}" data-row="{{ $graph->id }}">
                <input type="datetime-local" id="end_date" name="end-date" class="enddate outline-none bg-gray-100 w-44 py-1 pl-2" data-row="{{ $graph->id }}" value="{{ $graph->endDate }}">
            </div>
        </div>
    </div>
    <div>
    </div>
</div>


@endif