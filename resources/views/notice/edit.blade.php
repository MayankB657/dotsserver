<div id="EditModel" role="dialog"
    class="fixed hidden inset-0 flex items-center justify-center bg-black bg-opacity-50 hidemodal">
    <div class="bg-white rounded-2xl overflow-auto shadow-lg max-w-xl w-full bg-c-lighten-gray modal-content">
        <div class="flex py-4 px-5 justify-start items-center">
            <button type="button" id="closeModalButton" class="py-1.5 px-3 bg-c-lightest-gray rounded-md text-c-black"
                onclick="hideModal('EditModel')">
                <i class="ri-arrow-left-line text-black mr-3"></i>Back
            </button>
        </div>
        <div class="p-5">
            <form class="space-y-4 text-sm ajax-submit" action="{{ route('notice.update', $data->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="flex flex-wrap w-full gap-y-4 items-start">
                    <label for="title" class="w-1/4 font-bold text-c-black">Message title: <span
                            class="text-red-500">*</span></label>
                    <input type="text" required name="title" id="title"
                        class="w-3/4 bg-c-lighten-gray border border-gray text-gray-900 text-sm rounded-xl block p-2 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                        placeholder="" value="{{ $data->title }}" />
                </div>
                <div class="flex flex-wrap gap-y-4 items-start">
                    <label class="w-1/4 font-bold text-c-black" for="message-content">Message content: </label>
                    <textarea name="content" id="message-content" rows="4"
                        class="bg-c-lighten-gray border border-gray rounded-xl p-2 w-3/4 CkeditorClass">{{ $data->content }}</textarea>
                </div>
                <hr text-sm />
                <div class="flex flex-wrap gap-y-2 items-center">
                    <div class="w-1/4 font-bold text-c-black">Push object:<span class="text-red-500">*</span>
                    </div>
                    <div class="flex gap-2 ml-auto w-3/4 flex-wrap sm:flex-nowrap">
                        <label for="everyone" class="cursor-pointer radio-button">
                            <input type="radio" name="send_to" id="everyone" value="Everyone" class="checkEveryone"
                                {{ $data->send_to == 'Everyone' ? 'checked' : '' }}>
                            <span
                                class="flex items-center justify-center gap-1 px-2 py-1.5 w-24 rounded text-c-black bg-c-gray-3"><i
                                    class="ri-check-double-line text-c-black"></i>Everyone</span>
                        </label>
                        <label for="users" class="cursor-pointer radio-button other-labels">
                            <input type="checkbox" name="send_to" id="users" value="Users" class="checkUser"
                                {{ $data->users->count() > 0 ? 'checked' : '' }}>
                            <span
                                class="flex items-center justify-center gap-1 px-2 py-1.5 w-24 rounded text-c-black bg-c-gray-3"><i
                                    class="ri-user-add-line text-c-black"></i>Users</span>
                        </label>
                        <label for="groups" class="cursor-pointer radio-button other-labels">
                            <input type="checkbox" name="send_to" id="groups" value="Groups" class="checkGroup"
                                {{ $data->groups->count() > 0 ? 'checked' : '' }}>
                            <span
                                class="flex items-center justify-center gap-1 px-2 py-1.5 w-24 rounded text-c-black bg-c-gray-3 "><i
                                    class="ri-group-line text-c-black"></i>Groups</span>
                        </label>
                        <label for="role" class="cursor-pointer radio-button other-labels">
                            <input type="checkbox" name="send_to" id="role" value="Role" class="checkRole"
                                {{ $data->roles->count() > 0 ? 'checked' : '' }}>
                            <span
                                class="flex items-center justify-center gap-1 px-2 py-1.5 w-24 rounded text-c-black bg-c-gray-3"><i
                                    class="ri-suitcase-line text-c-black"></i>Role</span>
                        </label>
                    </div>
                    <div id="users-div" class="w-3/4 ml-auto"
                        style="display: {{ $data->users->count() > 0 ? 'block' : 'none' }}">
                        <div class="flex flex-wrap gap-2 items-center flex-grow">
                            <select data-placeholder="Select content" multiple
                                class="label ui selection fluid dropdown w-full rounded-xl" name="users[]">
                                <option value="">Please choose the user</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ in_array($user->id, $data->users->pluck('users_id')->toArray()) ? 'selected' : '' }}>
                                        {{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="groups-div" class="w-3/4 ml-auto"
                        style="display: {{ $data->groups->count() > 0 ? 'block' : 'none' }}">
                        <div class="flex flex-wrap gap-2 items-center flex-grow">
                            <select data-placeholder="Select content" multiple
                                class="label ui selection fluid dropdown w-full rounded-xl" name="groups[]">
                                <option value="">Please choose the group</option>
                                @foreach ($groups as $group)
                                    <option value="{{ $group->id }}"
                                        {{ in_array($group->id, $data->groups->pluck('groups_id')->toArray()) ? 'selected' : '' }}>
                                        {{ $group->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="role-div" class="w-3/4 ml-auto"
                        style="display: {{ $data->roles->count() > 0 ? 'block' : 'none' }}">
                        <div class="flex flex-wrap gap-2 items-center flex-grow">
                            <select data-placeholder="Select content" multiple
                                class="label ui selection fluid dropdown w-full rounded-xl" name="roles[]">
                                <option value="">Please choose the role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}"
                                        {{ in_array($role->id, $data->roles->pluck('roles_id')->toArray()) ? 'selected' : '' }}>
                                        {{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="w-3/4 ml-auto">
                        <p class="text-xs font-light text-c-black">Choose to push to everyone, or push to specified
                            users, user group, and permission groups.</p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-y-4 items-center">
                    <div class="w-1/4 font-bold text-c-black">Push method:<span class="text-red-500">*</span>
                    </div>
                    <div class="flex gap-2 ml-auto w-3/4 flex-col sm:flex-row">
                        <label for="push-immediately" class="cursor-pointer radio-button">
                            <input type="radio" name="is_schedule" id="push-immediately" value="0"
                                {{ $data->is_schedule == 0 ? 'checked' : '' }}>
                            <span
                                class="flex items-center justify-center gap-1 px-2 py-1.5 w-36 rounded text-c-black bg-c-gray-3">Push
                                immediately</span>
                        </label>
                        <label for="scheduled-push" class="cursor-pointer radio-button">
                            <input type="radio" name="is_schedule" id="scheduled-push" value="1"
                                {{ $data->is_schedule == 1 ? 'checked' : '' }}>
                            <span
                                class="flex items-center justify-center gap-1 px-2 py-1.5 w-36 rounded text-c-black bg-c-gray-3">Scheduled
                                push</span>
                        </label>
                    </div>
                </div>
                <div id="push-time" class="flex flex-wrap gap-y-4 items-center"
                    style="display: {{ $data->is_schedule == 1 ? 'block' : 'none' }};">
                    <div class="w-1/4 font-bold text-c-black">Push time:<span class="text-red-500">*</span> </div>
                    <div class="flex gap-2 ml-auto w-3/4">
                        <div class="bg-c-lighten-gray flex items-center rounded border border-gray overflow-hidden">
                            <input type="datetime-local" name="schedule_time" id="ScheduleTime"
                                class="text-sm px-1 py-1" value="{{ $data->schedule_time }}">
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap gap-y-2 items-center">
                    <div class="w-1/4 font-bold text-c-black">Prompt level:<span class="text-red-500">*</span>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-1 sm:gap-5 ml-auto w-3/4">
                        <div>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="type" value="Weak hint"
                                    {{ $data->type == 'Weak hint' ? 'checked' : '' }} />
                                <span class="custom-radio"></span>
                                <span class="text-c-black text-sm sm:text-base">Weak hint</span>
                            </label>
                        </div>
                        <div>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="type" value="Strong prompt"
                                    {{ $data->type == 'Strong prompt' ? 'checked' : '' }} />
                                <span class="custom-radio"></span>
                                <span class="text-c-black text-sm sm:text-base">Strong prompt</span>
                            </label>
                        </div>
                    </div>
                    <div class="w-3/4 ml-auto">
                        <p class="text-xs font-light text-c-black">Weak reminder: a red dot is displayed in the
                            notification bar at the lower left corner; strong reminder: a notification will pop up
                            directly after the user logs in.</p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-y-4 items-center">
                    <div class="w-1/4 font-bold text-c-black">Enable: </div>
                    <div class="w-3/4 ml-auto">
                        <label for="toggle-debug" class="toggle-switch flex items-center cursor-pointer">
                            <div class="relative">
                                <input type="checkbox" id="toggle-debug" name="is_enable" value="1"
                                    class="sr-only" {{ $data->is_enable == 1 ? 'checked' : '' }}>
                                <div class="block toggle-bg w-14 h-7 rounded-full border"></div>
                                <div
                                    class="dot absolute left-0.5 top-0.5 bg-white w-6 h-6 rounded-full transition shadow-lg">
                                </div>
                            </div>
                        </label>
                    </div>

                </div>
                <div class="flex justify-end mt-3">
                    <button type="submit"
                        class="bg-c-black hover-bg-c-black text-white rounded-full w-32 py-2 text-sm">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
