<div id="sharePopup" class="cm fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 fmclose">
    <div
        class="bg-white rounded-2xl overflow-hidden shadow-lg max-w-xl w-full modal-content">
        <div class="sticky top-0 bg-white z-10 flex p-4 px-5 justify-between items-center border-b border-gray-3 text-c-black">
            <div class="flex flex-col md:flex-row md:gap-6">
                <h2 class="text-base font-semibold m-0">
                    Link Sharing
                </h2>
                <p class="text-xs md:text-sm">
                    <span class="font-weight-500">Location:</span>
                    /Personal/{{ $file->path }}{{ $filetype == 'folder' ? '/' : '' }}
                    <br>
                    <span class="font-weight-500">Share time:</span> {{ $today }}
                    <br>
                    <span
                        class="font-weight-500">Downloads:</span> {{ $downloadCount }},
                    <span class="font-weight-500">Views:</span> {{ $viewCount }}
                </p>
            </div>
            <button id="ClosePopup">
            <i class="ri-close-circle-fill text-black ri-lg"></i>
            </button>
           
        </div>
        <div
            class="overflow-y-auto scroll"
            style="max-height: calc(100vh - 14rem)"
          >
        <form class="space-y-4 m-5 text-sm" method="POST" id="shareForm"
            action="{{ route('fileshare.store') }}">
            @csrf
            <input type="hidden" name="filetype" value="{{ $filetype }}">
            <input type="hidden" name="id" value="{{ $hashed }}">
            <input type="hidden" name="oldId" value="{{ $oldId }}">
            <div class="flex flex-wrap items-center">
                <label class="block w-full md:w-1/4 font-weight-500">URL:<span class="text-c-dark-red">*</span></label>
                <div class="flex w-full md:w-3/4">
                    <input type="text" name="url"
                        class="flex-grow border border-gray-3 rounded-l-xl p-2 focus:outline-none focus:ring-0"
                        value="{{ url('/') }}/sharing/{{ $hashed }}" readonly />
                    <a href="{{ url('/') }}/sharing/{{ $hashed }}" target="_blank"
                        class="border border-gray-3 text-c-black hover:text-black bg-c-light-black1 hover-bg-c-yellow p-2 px-4">
                        <i class="ri-share-box-line"></i>
                    </a>
                    <button type="button"
                        class="border border-gray-3 rounded-r-xl bg-c-light-black1 hover-bg-c-yellow p-2 px-4 ClicktoCopy">
                        <i class="ri-file-copy-2-line"></i>
                    </button>
                    <!-- <button type="button"
                        class="border border-gray-3 rounded-r-xl bg-c-light-black1 hover-bg-c-yellow p-2 px-4 showqrcode">
                        <i class="ri-qr-code-line"></i>
                    </button> -->
                </div>
            </div>

            <div class="flex flex-wrap items-center">
                <label class="block w-full md:w-1/4 font-weight-500">Password:</label>
                <div class="flex w-full md:w-3/4 ml-auto">
                <div class="relative w-full">

                    <input type="text" id="Password"
                        class="flex-grow border border-gray-3 rounded-xl p-2 focus:outline-none focus:ring-0 w-full"
                        placeholder="Enter password" name="password" value="{{ $password ?? '' }}" />
                    <button type="button" id="RandomPassword"
                        class="absolute inset-y-0 right-0 flex items-center bg-c-gray-4 border border-gray-3 rounded-r-xl p-3 text-xs">
                        Random
                    </button>
                </div></div> <p class="w-full md:w-3/4 md:ml-auto text-left font-light text-xs">
                <!-- Only extract password to view, no privacy and security -->
            </p>
            </div>
           
            <div class="flex flex-wrap gap-y-2 items-center">
                <div class="w-1/4 font-medium text-c-black text-base">
                    Share to view:<span class="text-red-500">*</span>
                </div>
                <div class="flex gap-2 ml-auto w-3/4 flex-wrap sm:flex-nowrap">
                    <label for="Users" class="cursor-pointer radio-button other-labels">
                        <input type="checkbox" name="share_to[]" id="Users"  value="users"
                        {{ count($selectedUsers) > 0 ? 'checked' : '' }}  />
                        <span
                            class="flex items-center justify-center gap-1 px-2 py-1.5 w-24 rounded text-c-black bg-c-light-black1"><i
                                class="ri-user-add-line text-c-black"></i>Users</span>
                    </label>
                    <label for="Groups" class="cursor-pointer radio-button other-labels">
                        <input type="checkbox" name="share_to[]" id="Groups" value="groups"
                        {{ count($selectedGroups) > 0 ? 'checked' : '' }} />
                        <span
                            class="flex items-center justify-center gap-1 px-2 py-1.5 w-24 rounded text-c-black bg-c-light-black1"><i
                                class="ri-group-line text-c-black"></i>Groups</span>
                    </label>
                    <label for="Roles" class="cursor-pointer radio-button other-labels">
                        <input type="checkbox" name="share_to[]" id="Roles" value="role"
                        {{ count($selectedRoles) > 0 ? 'checked' : '' }} />
                        <span
                            class="flex items-center justify-center gap-1 px-2 py-1.5 w-24 rounded text-c-black bg-c-light-black1"><i
                                class="ri-suitcase-line text-c-black"></i>Role</span>
                    </label>
                </div>
                <div id="DivUsers" class="w-3/4 ml-auto"
                    style="{{ count($selectedUsers) > 0 ? '' : 'display: none' }}">
                    <div class="flex flex-wrap gap-2 items-center flex-grow">
                        <select data-placeholder="Select content" multiple
                            class="label ui selection fluid dropdown w-full rounded-xl" name="users[]">
                            <option value="">Please choose the user</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ in_array($user->id, $selectedUsers) ? 'selected' : '' }}>{{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div id="DivGroups" class="w-3/4 ml-auto"
                    style="{{ count($selectedGroups) > 0 ? '' : 'display: none' }}">
                    <div class="flex flex-wrap gap-2 items-center flex-grow">
                        <select data-placeholder="Select content" multiple
                            class="label ui selection fluid dropdown w-full rounded-xl" name="groups[]">
                            <option value="">Please choose the group</option>
                            @foreach ($groups as $group)
                                <option value="{{ $group->id }}"
                                    {{ in_array($group->id, $selectedGroups) ? 'selected' : '' }}>{{ $group->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div id="DivRoles" class="w-3/4 ml-auto"
                    style="{{ count($selectedRoles) > 0 ? '' : 'display: none' }}">
                    <div class="flex flex-wrap gap-2 items-center flex-grow">
                        <select data-placeholder="Select content" multiple
                            class="label ui selection fluid dropdown w-full rounded-xl" name="roles[]">
                            <option value="">Please choose the role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}"
                                    {{ in_array($role->id, $selectedRoles) ? 'selected' : '' }}>{{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap gap-y-2 items-center">
                <div class="w-1/4 font-medium text-c-black text-base">
                    Share to Edit:
                    <!-- <span class="text-red-500">*</span> -->
                </div>
                <div class="flex gap-2 ml-auto w-3/4 flex-wrap sm:flex-nowrap">
                    <label for="EditUsers" class="cursor-pointer radio-button other-labels">
                        <input type="checkbox" name="edit_share_to[]" id="EditUsers" value="users"
                        {{ count($selectedUsersEdit) > 0 ? 'checked' : '' }}  />
                        <span
                            class="flex items-center justify-center gap-1 px-2 py-1.5 w-24 rounded text-c-black bg-c-light-black1"><i
                                class="ri-user-add-line text-c-black"></i>Users</span>
                    </label>
                    <label for="EditGroups" class="cursor-pointer radio-button other-labels">
                        <input type="checkbox" name="edit_share_to[]" id="EditGroups" value="groups"
                        {{ count($selectedGroupsEdit) > 0 ? 'checked' : '' }} />
                        <span
                            class="flex items-center justify-center gap-1 px-2 py-1.5 w-24 rounded text-c-black bg-c-light-black1"><i
                                class="ri-group-line text-c-black"></i>Groups</span>
                    </label>
                    <label for="EditRoles" class="cursor-pointer radio-button other-labels">
                        <input type="checkbox" name="edit_share_to[]" id="EditRoles" value="role"
                        {{ count($selectedRolesEdit) > 0 ? 'checked' : '' }} />
                        <span
                            class="flex items-center justify-center gap-1 px-2 py-1.5 w-24 rounded text-c-black bg-c-light-black1"><i
                                class="ri-suitcase-line text-c-black"></i>Role</span>
                    </label>
                </div>
                <div id="DivEditUsers" class="w-3/4 ml-auto"
                    style="{{ count($selectedUsersEdit) > 0 ? '' : 'display: none' }}">
                    <div class="flex flex-wrap gap-2 items-center flex-grow">
                        <select data-placeholder="Select content" multiple
                            class="label ui selection fluid dropdown w-full rounded-xl" name="edit_users[]">
                            <option value="">Please choose the user</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ in_array($user->id, $selectedUsersEdit) ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div id="DivEditGroups" class="w-3/4 ml-auto"
                    style="{{ count($selectedGroupsEdit) > 0 ? '' : 'display: none' }}">
                    <div class="flex flex-wrap gap-2 items-center flex-grow">
                        <select data-placeholder="Select content" multiple
                            class="label ui selection fluid dropdown w-full rounded-xl" name="edit_groups[]">
                            <option value="">Please choose the group</option>
                            @foreach ($groups as $group)
                                <option value="{{ $group->id }}"
                                    {{ in_array($group->id, $selectedGroupsEdit) ? 'selected' : '' }}>
                                    {{ $group->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div id="DivEditRoles" class="w-3/4 ml-auto"
                    style="{{ count($selectedRolesEdit) > 0 ? '' : 'display: none' }}">
                    <div class="flex flex-wrap gap-2 items-center flex-grow">
                        <select data-placeholder="Select content" multiple
                            class="label ui selection fluid dropdown w-full rounded-xl" name="edit_roles[]">
                            <option value="">Please choose the role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}"
                                    {{ in_array($role->id, $selectedRolesEdit) ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap items-center">
                <label class="block w-full md:w-1/4 font-weight-500">Expiry date:</label>
                <input type="datetime-local" name="expirydate" class="text-sm border border-gray px-1 py-1 rounded" value="{{ $expiry }}">
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-c-light-gray text-c-white px-6 py-2 rounded-full">
                    Save
                </button>
            </div>
        </form>
</div>
    </div>
</div>

<div id="QrCodeModal" class="fixed inset-0 flex items-center justify-center hidden bg-gray-800 bg-opacity-50">
    <div class="bg-c-white rounded-xl p-10 shadow-lg max-w-7xl max-h-screen overflow-y-auto">
        <div id="qrcode" style="width: 100px; height: 100px; margin-bottom: 15px"></div>
        <div class="flex items-center justify-center">
            <button class="bg-c-light-gray text-c-white px-6 py-2 rounded-full hideqrmodal">Close</button>
        </div>
    </div>
</div>


<script defer>
        $('.label.ui.dropdown')
            .dropdown();

        $('.no.label.ui.dropdown')
            .dropdown({
                useLabels: false
            });

        $('.ui.button').on('click', function () {
            $('.ui.dropdown')
                .dropdown('restore defaults')
        })

    </script>

<script>   
    document.getElementById('shareForm').addEventListener('submit', function (e) {
        const shareToCheckboxes = document.querySelectorAll('input[name="share_to[]"]');
        let isChecked = false;
        shareToCheckboxes.forEach(function (checkbox) {
            if (checkbox.checked) {
                isChecked = true;
            }
        });
        if (!isChecked) {
            e.preventDefault(); 
            alert('Please select at least one user from "Share to view" option.');
        }
    });
</script>

