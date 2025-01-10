@extends('layouts.backendsettings')
@section('title', 'Notice')
@section('content')
    @include('layouts.alert')
    <div class="flex-grow border h-100 main">
        <div class="flex flex-col w-full h-full content">
            <div class=" px-9 py-3 lg:py-6 lg:px-5">
                <div class="flex items-center gap-4">
                    <i class="ri-settings-3-fill ri-xl"></i>
                    <span class="text-lg text-c-black">System settings</span>
                </div>
            </div>

            <!-- top taskbar -->
            <div class="taskbar flex items-center justify-between px-3 sm:px-6 py-4">
                <div class="w-full md:w-1/2">
                    <div class="flex items-center gap-1 sm:gap-2">
                        <span class="text-c-light-black"> System settings </span>
                        <i class="ri-arrow-right-line ri-lg" style="color: #4D4D4D;"></i>
                        <span class="font-semibold text-c-black"> Notice </span>
                    </div>
                </div>

                <div class="flex-grow md:w-1/2">
                    <div class="flex items-center justify-end">
                        <div>
                            <button
                                class="flex items-center justify-center gap-2 bg-c-black text-c-yellow px-3 sm:px-4 py-1 sm:py-1.5 rounded-md"
                                onclick="showModal('AddModal')">
                                <i class="ri-add-circle-fill"></i><span class=" text-xs sm:text-sm">Add</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- info table -->
            <div class="p-4 relative h-full flex flex-col">
                <div class="bg-white cs-table-container border border-c-gray rounded-md">
                    <table class="table-auto w-full">
                        <thead class="h-14">
                            <tr class="bg-c-dark-gray">
                                <th class="text-c-white font-medium text-left pl-3 rounded-tl-md">Name</th>
                                <th class="text-c-white font-medium text-left pl-3">Status</th>
                                <th class="text-c-white font-medium text-left pl-3">Push date</th>
                                <th class="text-c-white font-medium text-left pl-3">Push time</th>
                                <th class="text-c-white font-medium text-left pl-3">Creation date</th>
                                <th class="text-c-white font-medium text-left pl-3">Creation time</th>
                                <th class="text-c-white font-medium text-left pl-3">Enable</th>
                                <th class="text-c-white font-medium text-left pl-3 rounded-tr-md">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $row)
                                <tr class="h-16">
                                    <td class="font-normal text-c-black text-left pl-3 px-2">{{ $row->title }}
                                    </td>
                                    <td class="font-normal text-c-black text-left pl-3">
                                        <span
                                            class="bg-system py-1.5 text-center px-5 font-normal rounded-sm text-dark-black">{{ $row->is_send == 1 ? 'Pushed' : 'Schedule' }}</span>
                                    </td>
                                    <td class="font-normal text-c-black text-left pl-3">
                                        {{ $row->is_send ? Carbon\Carbon::parse($row->send_at)->format('Y-m-d') : '' }}
                                    </td>
                                    <td class="font-normal text-c-black text-left pl-3">
                                        {{ $row->is_send ? Carbon\Carbon::parse($row->send_at)->format('H:i:s') : '' }}
                                    </td>
                                    <td class="font-normal text-c-black text-left pl-3">
                                        {{ Carbon\Carbon::parse($row->created_at)->format('Y-m-d') }}</td>
                                    <td class="font-normal text-c-black text-left pl-3">
                                        {{ Carbon\Carbon::parse($row->created_at)->format('H:i:s') }}</td>
                                    <td class="text-left pl-3">
                                        <label for="ToggleEnable{{ $key }}"
                                            class="toggle-switch flex items-center cursor-pointer">
                                            <div class="relative">
                                                <input type="checkbox" id="ToggleEnable{{ $key }}" class="sr-only"
                                                    {{ $row->is_enable ? 'checked' : '' }}
                                                    onchange="ChangeStatus(this,{{ $row->id }})">
                                                <div class="block toggle-bg w-14 h-7 rounded-full border"></div>
                                                <div
                                                    class="dot absolute left-0.5 top-0.5 bg-white w-6 h-6 rounded-full transition shadow-lg">
                                                </div>
                                            </div>
                                        </label>
                                    </td>
                                    <td class="font-normal text-c-black text-left pl-3">
                                        <div class="flex relative text-sm gap-2">
                                            <div class="relative">
                                                <button type="button" class="dropdown-btn">Action&nbsp;<i
                                                        class="ri-arrow-down-s-line"></i></button>
                                                <div
                                                    class="absolute text-xs dropdown-option w-20 z-10 min-w-full space-y-1 border rounded-md overflow-hidden">
                                                    <button class="block hover-bg-c-yellow w-full px-2 py-1"
                                                        onclick="runnow({{ $row->id }})">Run</button>
                                                    <form action="{{ route('notice.destroy', $row->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="block hover-bg-c-yellow w-full px-2 py-1"
                                                            type="submit">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                            <a href="{{ route('notice.edit', $row->id) }}"
                                                class="text-c-sky editbtn">Edit</a>
                                            <button class="text-c-sky"
                                                onclick="showPreviewModal({{ $key }})">Preview</button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-auto flex justify-end">
                    Total {{ $data->lastPage() }} page &nbsp; <span class="text-c-yellow">({{ $data->total() }}
                        records)</span>
                </div>
            </div>
        </div>
    </div>
    @foreach ($data as $key => $notice)
        <!-- Preview Modal -->
        <div id="preview-modal{{ $key }}" role="dialog"
            class="fixed hidden inset-0 flex items-center justify-center bg-black bg-opacity-50 previewmodal">
            <div class="w-full max-w-md h-96 rounded-2xl bg-white overflow-hidden px-5 modal-content">
                <div class="flex pt-8 pb-1 border-b-2 justify-center items-center">
                    <h2 class="text-lg text-c-black font-medium">{{ $notice->title }}</h2>
                </div>
                <div class="py-2">
                    {!! $notice->content !!}
                    <p>{{ Carbon\Carbon::parse($notice->created_at)->format('Y-m-d') }}</p>
                    <p>{{ Carbon\Carbon::parse($notice->created_at)->format('H:i:s') }}</p>
                </div>
            </div>
        </div>
    @endforeach
    <!-- edit modal -->
    <div id="EditDiv"></div>

    <!-- add modal -->
    <div id="AddModal" role="dialog"
        class="fixed hidden inset-0 flex items-center justify-center bg-black bg-opacity-50 hidemodal">
        <div class="bg-white rounded-2xl overflow-auto shadow-lg max-w-xl w-full bg-c-lighten-gray modal-content">
            <div class="flex py-4 px-5 justify-start items-center">
                <button type="button" id="closeModalButton" class="py-1.5 px-3 bg-c-lightest-gray rounded-md text-c-black"
                    onclick="hideModal('AddModal')">
                    <i class="ri-arrow-left-line text-black mr-3"></i>Back
                </button>
            </div>
            <div class="p-5">
                <form class="space-y-4 text-sm ajax-submit" action="{{ route('notice.store') }}" method="POST">
                    @csrf
                    <div class="flex flex-wrap w-full gap-y-4 items-start">
                        <label for="title" class="w-1/4 font-bold text-c-black">Message title: <span
                                class="text-red-500">*</span></label>
                        <input type="text" required name="title" id="title"
                            class="w-3/4 bg-c-lighten-gray border border-gray text-gray-900 text-sm rounded-xl block p-2 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            placeholder="" />
                    </div>
                    <div class="flex flex-wrap gap-y-4 items-start">
                        <label class="w-1/4 font-bold text-c-black" for="message-content">Message content: </label>
                        <textarea name="content" id="message-content" rows="4"
                            class="bg-c-lighten-gray border border-gray rounded-xl p-2 w-3/4 CkeditorClass"></textarea>
                    </div>
                    <hr text-sm />
                    <div class="flex flex-wrap gap-y-2 items-center">
                        <div class="w-1/4 font-bold text-c-black">Push object:<span class="text-red-500">*</span>
                        </div>
                        <div class="flex gap-2 ml-auto w-3/4 flex-wrap sm:flex-nowrap">
                            <label for="everyone" class="cursor-pointer radio-button">
                                <input type="radio" name="send_to" id="everyone" value="Everyone"
                                    class="checkEveryone" checked>
                                <span
                                    class="flex items-center justify-center gap-1 px-2 py-1.5 w-24 rounded text-c-black bg-c-gray-3"><i
                                        class="ri-check-double-line text-c-black"></i>Everyone</span>
                            </label>
                            <label for="users" class="cursor-pointer radio-button other-labels">
                                <input type="checkbox" name="send_to" id="users" value="Users" class="checkUser">
                                <span
                                    class="flex items-center justify-center gap-1 px-2 py-1.5 w-24 rounded text-c-black bg-c-gray-3"><i
                                        class="ri-user-add-line text-c-black"></i>Users</span>
                            </label>
                            <label for="groups" class="cursor-pointer radio-button other-labels">
                                <input type="checkbox" name="send_to" id="groups" value="Groups" class="checkGroup">
                                <span
                                    class="flex items-center justify-center gap-1 px-2 py-1.5 w-24 rounded text-c-black bg-c-gray-3 "><i
                                        class="ri-group-line text-c-black"></i>Groups</span>
                            </label>
                            <label for="role" class="cursor-pointer radio-button other-labels">
                                <input type="checkbox" name="send_to" id="role" value="Role" class="checkRole">
                                <span
                                    class="flex items-center justify-center gap-1 px-2 py-1.5 w-24 rounded text-c-black bg-c-gray-3"><i
                                        class="ri-suitcase-line text-c-black"></i>Role</span>
                            </label>
                        </div>
                        <div id="users-div" class="w-3/4 ml-auto" style="display: none">
                            <div class="flex flex-wrap gap-2 items-center flex-grow">
                                <select data-placeholder="Select content" multiple
                                    class="label ui selection fluid dropdown w-full rounded-xl" name="users[]">
                                    <option value="">Please choose the user</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div id="groups-div" class="w-3/4 ml-auto" style="display: none">
                            <div class="flex flex-wrap gap-2 items-center flex-grow">
                                <select data-placeholder="Select content" multiple
                                    class="label ui selection fluid dropdown w-full rounded-xl" name="groups[]">
                                    <option value="">Please choose the group</option>
                                    @foreach ($groups as $group)
                                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div id="role-div" class="w-3/4 ml-auto" style="display: none">
                            <div class="flex flex-wrap gap-2 items-center flex-grow">
                                <select data-placeholder="Select content" multiple
                                    class="label ui selection fluid dropdown w-full rounded-xl" name="roles[]">
                                    <option value="">Please choose the role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
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
                                <input type="radio" name="is_schedule" id="push-immediately" value="0" checked>
                                <span
                                    class="flex items-center justify-center gap-1 px-2 py-1.5 w-36 rounded text-c-black bg-c-gray-3">Push
                                    immediately</span>
                            </label>
                            <label for="scheduled-push" class="cursor-pointer radio-button">
                                <input type="radio" name="is_schedule" id="scheduled-push" value="1">
                                <span
                                    class="flex items-center justify-center gap-1 px-2 py-1.5 w-36 rounded text-c-black bg-c-gray-3">Scheduled
                                    push</span>
                            </label>
                        </div>
                    </div>
                    <div id="push-time" class="flex flex-wrap gap-y-4 items-center" style="display: none;">
                        <div class="w-1/4 font-bold text-c-black">Push time:<span class="text-red-500">*</span> </div>
                        <div class="flex gap-2 ml-auto w-3/4">
                            <div class="bg-c-lighten-gray flex items-center rounded border border-gray overflow-hidden">
                                <input type="datetime-local" name="schedule_time" id="ScheduleTime"
                                    class="text-sm px-1 py-1">
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-y-2 items-center">
                        <div class="w-1/4 font-bold text-c-black">Prompt level:<span class="text-red-500">*</span>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-1 sm:gap-5 ml-auto w-3/4">
                            <div>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="type" value="Weak hint" checked />
                                    <span class="custom-radio"></span>
                                    <span class="text-c-black text-sm sm:text-base">Weak hint</span>
                                </label>
                            </div>
                            <div>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="type" value="Strong prompt" />
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
                                        class="sr-only">
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
    @php
        $url = 'https://node.sizaf.com';
    @endphp
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.2.13/dist/semantic.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.0.1/dist/js/multi-select-tag.js"></script>
    <script src="https://cdn.socket.io/4.7.5/socket.io.min.js"></script>
    <script src="{{ url('/') }}/public/ckeditor/ckeditor.js"></script>
    <script defer>
        // for handling add or edit modal
        function showModal(id) {
            var Modal = document.getElementById(id);
            Modal.classList.remove('hidden');
        }

        function hideModal(id) {
            var Modal = document.getElementById(id);
            Modal.classList.add('hidden');
        }

        // for handling type users, groups and role input in edit/add modal
        const usersDiv = document.getElementById('users-div');
        const groupsDiv = document.getElementById('groups-div');
        const roleDiv = document.getElementById('role-div');
        const usersRadio = document.querySelector('input.checkUser');
        const groupsRadio = document.querySelector('input.checkGroup');
        const roleRadio = document.querySelector('input.checkRole');
        const everyoneRadio = document.querySelector('input.checkEveryone');
        const otherLabels = document.querySelectorAll('.other-labels')

        usersRadio.addEventListener('change', () => {
            if (usersRadio.checked) {
                usersDiv.style.display = 'block';
                everyoneRadio.checked = false;
            } else {
                usersDiv.style.display = 'none';
                checkRadios();
            }
        });
        groupsRadio.addEventListener('change', () => {
            if (groupsRadio.checked) {
                groupsDiv.style.display = 'block';
                everyoneRadio.checked = false;
            } else {
                groupsDiv.style.display = 'none';
                checkRadios();
            }
        });
        roleRadio.addEventListener('change', () => {
            if (roleRadio.checked) {
                roleDiv.style.display = 'block';
                everyoneRadio.checked = false;
            } else {
                roleDiv.style.display = 'none';
                checkRadios();
            }
        })

        function checkRadios() {
            if (!usersRadio.checked && !groupsRadio.checked && !roleRadio.checked) {
                everyoneRadio.checked = true;
            }
        }

        everyoneRadio.addEventListener("click", () => {
            usersDiv.style.display = "none";
            groupsDiv.style.display = "none";
            roleDiv.style.display = "none";

            otherLabels.forEach((label) => {
                label.querySelector('input').checked = false;
            })
        })

        // for handling pushtime input in add/edit modal
        const pushTimeDiv = document.getElementById("push-time");
        const scheduledRadio = document.querySelector('input#scheduled-push')
        const pushRadio = document.querySelector('input#push-immediately')

        scheduledRadio.addEventListener("click", () => {
            pushTimeDiv.style.display = "flex"
        })

        pushRadio.addEventListener("click", () => {
            pushTimeDiv.style.display = "none"
        })

        // for handling Preview modal
        const previewModal = document.getElementById('preview-modal');

        function showPreviewModal(key) {
            var previewModal = document.getElementById('preview-modal' + key);
            previewModal.classList.remove('hidden');
        }

        window.addEventListener('click', (event) => {
            var modals = document.querySelectorAll('.previewmodal');
            modals.forEach(modal => {
                if (event.target == modal) {
                    modal.classList.add('hidden');
                }
            });
        });
    </script>
    <script defer>
        function initdropdown() {
            $(".label.ui.dropdown").dropdown();
        }
        $(".no.label.ui.dropdown").dropdown({
            useLabels: false,
        });
        $(".ui.button").on("click", function() {
            $(".ui.dropdown").dropdown("restore defaults");
        });
        $(document).ready(function() {
            initdropdown();
            $('.CkeditorClass').each(function() {
                CKEDITOR.replace($(this).attr('id'));
            });
        });
    </script>
    <script>
        function ChangeStatus(el, id) {
            $.ajax({
                type: "GET",
                url: "{{ url('/') }}/notice/" + id,
                success: function(response) {
                    if (response.status == 1) {
                        el.checked = true;
                    } else {
                        el.checked = false;
                    }
                }
            });
        }
        $(document).ready(function() {
            $('.editbtn').on('click', function(event) {
                event.preventDefault();
                var url = $(this).attr('href');
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        $('#EditDiv').html(response.html);
                        $('#EditModel').removeClass('hidden');
                        $('.CkeditorClass').each(function() {
                            CKEDITOR.replace($(this).attr('id'));
                        });
                        initdropdown();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
        var url = "{{ $url }}";
        var socket = io(url);
        $(document).on('submit', '.ajax-submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var route = $(this).attr('action');
            $.ajax({
                type: "POST",
                url: route,
                data: formData,
                dataType: "JSON",
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.schedule == false) {
                        if (response.users != null) {
                            response.users.forEach(userId => {
                                var obj = {
                                    user: userId,
                                    data: response.data
                                }
                                socket.emit('received', obj)
                            });
                        }
                        location.reload();
                    } else {
                        location.reload();
                    }
                }
            });
        });

        function runnow(id) {
            $.ajax({
                type: "GET",
                url: "{{ url('/') }}/runnow/" + id,
                success: function(response) {
                    toastr["success"]("Notice send successfully");
                }
            });
        }
    </script>
@endsection
