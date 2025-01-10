@if(!empty($roles))
@foreach($roles as $role)
    <tr class="h-16 border-t">
    <td class="px-2 py-3 flex items-center justify-center">
                    <div class="flex items-center justify-center w-8 h-8 rounded-full text-white font-semibold text-sm"
                        style="background-color: {{ '#' . substr(md5($role->name), 0, 6) }};">
                        {{ strtoupper(substr($role->name, 0, 1)) }}
                    </div>
                </td>

        <td class="font-normal text-c-black text-left pl-3">
            {{ $role->name }}
        </td>
        <td class="font-normal text-c-black text-left pl-3">
            {{ $role->client->name ?? 'N/A' }}
        </td>
        <td class="font-normal text-c-black text-left pl-3 pr-3 md:pr-0">
            {{ $role->description ?? 'No Description' }}
        </td>
       <!-- <td class="font-normal text-c-black text-left pl-3 pr-3 md:pr-0">
            <ul class="list-disc">
                @php
                   // print_r($role->permissions);die;
                    // Decode permissions JSON field from the role
                    $rolePermissions = json_decode($role->permissions,true);
                    // Fetch all permission groups and permissions
                    $permissionGroups = \App\Models\PermissionList::whereIn('id', $rolePermissions)
                        ->orderBy('permission_group_flag')
                        ->get()
                        ->groupBy('permission_group_flag');
                @endphp
                @foreach($permissionGroups as $groupFlag => $permissions)
                    <li class="mb-2">
                        <strong>{{ $groupFlag }}</strong> 
                        <ul class="ml-4 list-disc">
                            @foreach($permissions as $permission)
                                <li>{{ $permission->name }}</li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        </td> -->
        <td class="text-c-black text-left pl-3 whitespace-nowrap pr-3 md:pr-0 flex gap-4">
            <!-- Edit Icon -->
            <button class="editRoleModal" data-role="{{ base64_encode($role->id) }}">
                <i class="ri-edit-line ri-xl cursor-pointer"></i>
            </button>
            
            <!-- Delete Icon -->
            <button class="deleteRole" data-id="{{ $role->id }}">
                <i class="ri-delete-bin-line ri-xl cursor-pointer text-red-500"></i>
            </button>
        </td>
    </tr>
@endforeach

@if($roles->isEmpty())
    <tr>
        <td colspan="7" class="text-center py-4 font-semibold text-gray-500 bg-gray-100">
            {{ 'No Records' }}
        </td>
    </tr>
@endif
<!-- Pagination Links -->
<div class="mt-4">
    {{ $roles->links() }}
</div>
@endif

