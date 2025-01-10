@foreach($users as $user)
    <tr class="h-16 border-t">
            <td class="px-2 py-3 flex items-center justify-center">
                    <div class="flex items-center justify-center w-8 h-8 rounded-full text-white font-semibold text-sm"
                        style="background-color: {{ '#' . substr(md5($user->name), 0, 6) }};">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                </td>

        <td class="font-normal text-c-black text-left pl-3">
            {{$user->name}}
        </td>
        <td class="font-normal text-c-black text-left pl-3 pr-3 md:pr-0">
            {{ (!empty($user->client->name)) ? $user->client->name : 'NA' }}
        </td>
        <td class="font-normal text-c-black text-left pl-3 pr-3 md:pr-0">
            {{ (!empty($user->role->name)) ? $user->role->name : 'NA' }}
        </td>
        <td class="font-normal text-c-black text-left pl-3 pr-3 md:pr-0">
            <div class="bg-c-light-black1 h-2 mb-2 rounded-lg overflow-hidden w-5/12">
                <div class="bg-c-yellow h-full rounded-r-full w-2/3"></div>
            </div>
            <span class="whitespace-nowrap">{{$user->sizeMax}} GB</span>
        </td>
        <td class="font-normal text-c-black text-left pl-3 whitespace-nowrap pr-3 md:pr-0">
            {{ (!empty($user->group->name)) ? $user->group->name : 'NA' }}
        </td>
        <td class="font-normal text-c-black text-left pl-3 whitespace-nowrap pr-3 md:pr-0">
            @if ($user->status == 1)
                <span class="px-2 py-1 bg-green-200 text-green-700 rounded-full text-xs">Active</span>
            @else
                <span class="px-2 py-1 bg-red-200 text-red-700 rounded-full text-xs">Deactivated</span>
            @endif
        </td>
        <td class="text-c-black text-left pl-3 whitespace-nowrap pr-3 md:pr-0 flex gap-4">
            <!-- Edit Icon -->
            <button class="editUserModal" data-user="{{ base64_encode($user->id) }}">
                <i class="ri-edit-line ri-xl cursor-pointer"></i>
            </button>
            
            <!-- Delete Icon -->
            <button class="deleteUser" data-id="{{ $user->id }}">
                <i class="ri-delete-bin-line ri-xl cursor-pointer text-red-500"></i>
            </button>
            
            <!-- Active/Deactive Icon -->
            <button class="toggleStatus" data-id="{{ $user->id }}" data-status="{{ $user->status == 1 ? 0 : 1 }}">
                @if($user->status == 1)
                    <i class="ri-toggle-fill ri-2x text-green-500 cursor-pointer"></i>
                @else
                    <i class="ri-toggle-line ri-2x text-red-500 cursor-pointer"></i>
                @endif
            </button>
        </td>
    </tr>
@endforeach

@if($users->isEmpty())
    <tr>
        <td colspan="7" class="text-center py-4 font-semibold text-gray-500 bg-gray-100">
            {{ 'NO Records' }}
        </td>
    </tr>
@endif

<!-- Pagination Links -->
<div class="mt-4">
    {{ $users->links() }}
</div>
