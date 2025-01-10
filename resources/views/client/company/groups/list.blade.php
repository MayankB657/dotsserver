@foreach($groups as $group)
    <tr class="h-16 border-t">
        <td class="px-2 py-3 flex items-center justify-center">
                    <div class="flex items-center justify-center w-8 h-8 rounded-full text-white font-semibold text-sm"
                        style="background-color: {{ '#' . substr(md5($group->name), 0, 6) }};">
                        {{ strtoupper(substr($group->name, 0, 1)) }}
                    </div>
                </td>

        <td class="font-normal text-c-black text-left pl-3">
            {{$group->name}}
        </td>
        <td class="font-normal text-c-black text-left pl-3">
            {{ $group->client->name ?? 'N/A' }}
        </td>
        <td class="font-normal text-c-black text-left pl-3">
            {{ $group->company->name ?? 'N/A' }}
        </td>
        <td class="font-normal text-c-black text-left pl-3">
            {{ $group->groupHead->name ?? 'N/A' }}
        </td>
        <td class="font-normal text-c-black text-left pl-3">
            {{ $group->groupHead->username ?? 'N/A' }}
        </td>
        
        <td class="text-c-black text-left pl-3 whitespace-nowrap pr-3 md:pr-0 flex gap-4">
            <!-- Edit Icon -->
            <button class="editGroupModal" data-group="{{ base64_encode($group->id) }}">
                <i class="ri-edit-line ri-xl cursor-pointer"></i>
            </button>
            
            <!-- Delete Icon -->
            <button class="deleteGroup" data-id="{{ $group->id }}">
                <i class="ri-delete-bin-line ri-xl cursor-pointer text-red-500"></i>
            </button>
            
        </td>
    </tr>
@endforeach

@if($groups->isEmpty())
    <tr>
        <td colspan="7" class="text-center py-4 font-semibold text-gray-500 bg-gray-100">
            {{ 'NO Records' }}
        </td>
    </tr>
@endif

<!-- Pagination Links -->
<div class="mt-4">
    {{ $groups->links() }}
</div>
