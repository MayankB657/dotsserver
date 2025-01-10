<!-- New Role Modal -->
<div class="bg-white rounded-2xl overflow-hidden shadow-lg max-w-xl w-full bg-c-lighten-gray modal-content">
    <!-- Sticky header -->
    <div
        class="sticky top-0 flex py-2 px-5 justify-between items-center border-b border-gray-3 bg-white z-10 text-c-black">
        <div class="text-lg font-normal">Add New Role</div>
        <button type="button" class="closeModalButton py-1.5 rounded-md">
            <i class="ri-close-circle-fill text-black ri-lg"></i>
        </button>
    </div>
    <!-- Scrollable content -->
    <div class="p-5 overflow-y-auto scroll" style="max-height: calc(100vh - 10rem)">
        <form class="flex flex-col gap-4 text-sm" id="newRole" action="{{ route('client.role.store') }}" method="POST">
            @csrf
             <!-- Client Dropdown -->
             <div class="grid grid-cols-1 md:grid-cols-10 gap-4 items-start">
                <div class="md:col-span-2 flex items-center">
                    <label for="client_id" class="block font-bold text-c-black">
                        Client:<span class="text-red-500">*</span>
                    </label>
                </div>
                <div class="md:col-span-8">
                    <select id="client_id" name="client" 
                            class="w-full p-2 bg-c-lighten-gray border border-gray-3 rounded-xl outline-none pl-5">
                        <option value="" disabled selected>Select Client</option>
                        @foreach($clients as $client)
                            <option value="{{ base64_encode($client->id) }}">{{ $client->name }}</option>
                        @endforeach
                    </select>
                    <small class="text-red-500 mt-1 block" name="client"></small>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-10 gap-4 items-start">
                <div class="md:col-span-2 flex items-center">
                    <label for="name" class="block font-bold text-c-black">
                        Role Name:<span class="text-red-500">*</span>
                    </label>
                </div>
                <div class="md:col-span-8">
                    <input id="name"
                        class="w-full p-2 bg-c-lighten-gray border border-gray-3 rounded-xl outline-none pl-5"
                        type="text" placeholder="Enter role name" name="name" required />
                    <small class="text-red-500 mt-1 block" name="name"></small>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-10 gap-4 items-start">
                <div class="md:col-span-2 flex items-center">
                    <label for="description" class="block font-bold text-c-black">
                        Description:
                    </label>
                </div>
                <div class="md:col-span-8">
                    <textarea id="description" class="w-full p-2 bg-c-lighten-gray border border-gray-3 rounded-xl outline-none pl-5"
                        placeholder="Enter role description" name="description"></textarea>
                    <small class="text-red-500 mt-1 block" name="description"></small>
                </div>
            </div>

            <!-- Permissions Section -->
            <div class="grid grid-cols-1 md:grid-cols-10 gap-4 items-start">
                <div class="md:col-span-2 flex items-center">
                    <label for="permissions" class="block font-bold text-c-black">
                        Permissions:<span class="text-red-500">*</span>
                    </label>
                </div>
                <div class="md:col-span-8">
                    <!-- Select All Checkbox -->
                    <div class="flex items-center mb-3">
                        <input type="checkbox" id="select-all-permissions" class="c-checkbox">
                        <label for="select-all-permissions" class="ml-2">Select All Permissions</label>
                    </div>

                    <!-- Grouped Permissions by permission_group_flag -->
                    @foreach ($permissionGroups as $groupFlag => $permissions)
                        <div class="mb-3 border p-2 rounded-xl">
                            <!-- Group Head Checkbox -->
                            <div class="flex items-center">
                                <input type="checkbox" class="group-checkbox c-checkbox" data-group="{{ $groupFlag }}">
                                <label class="ml-2 font-bold">{{ $groupFlag }}</label>
                            </div>

                            <!-- Permissions within Group -->
                            <ul class="pl-6 mt-2 list-disc">
                                @foreach ($permissions as $permission)
                                    <li class="flex items-center">
                                        <input type="checkbox" class="permission-checkbox c-checkbox"
                                               name="permissions[]" value="{{ $permission->id }}"
                                               data-group="{{ $groupFlag }}">
                                        <label class="ml-2">{{ $permission->name }}</label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                    <small class="text-red-500 mt-1 block" name="permissions"></small>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-c-black hover:bg-c-black text-white rounded-full w-32 py-2 text-sm">
                    Create
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Script for Handling Permission Selection -->
<script>
    $(document).ready(function() {
        // Select all permissions
        $('#select-all-permissions').on('change', function() {
            const isChecked = $(this).is(':checked');
            $('.permission-checkbox').prop('checked', isChecked);
            $('.group-checkbox').prop('checked', isChecked);
        });

        // Select all permissions within a group
        $('.group-checkbox').on('change', function() {
            const group = $(this).data('group');
            const isChecked = $(this).is(':checked');
            $(`.permission-checkbox[data-group="${group}"]`).prop('checked', isChecked);
        });

        // If all permissions in a group are checked, check the group checkbox
        $('.permission-checkbox').on('change', function() {
            const group = $(this).data('group');
            const allChecked = $(`.permission-checkbox[data-group="${group}"]:checked`).length ===
                $(`.permission-checkbox[data-group="${group}"]`).length;
            $(`.group-checkbox[data-group="${group}"]`).prop('checked', allChecked);

            // If all permissions are checked, check the select-all checkbox
            const allPermissionsChecked = $('.permission-checkbox:checked').length === $('.permission-checkbox').length;
            $('#select-all-permissions').prop('checked', allPermissionsChecked);
        });
    });
</script>
