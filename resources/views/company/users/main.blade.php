@extends('layouts.backendsettings')
@section('title', 'Users')
@section('content')

    <div class="flex-grow h-100 main">
        <div class="flex w-full h-full flex-col content">
            <div class="px-9 py-3.5 lg:py-6 lg:px-5">
                <div class="flex items-center gap-4">
                    <i class="ri-settings-3-fill ri-xl"></i>
                    <span class="text-lg text-c-black font-normal">User Management</span>
                </div>
            </div>

            <!-- Top Taskbar in Desktop -->
            <div class="pl-4 md:pl-6 py-4 pr-4 md:pr-6 w-full flex flex-row justify-between items-center taskbar">
                <div class="w-full md:w-6/12 xl:w-8/12">
                    <div class="flex items-center gap-1 sm:gap-2">
                        <span class="text-c-light-black whitespace-nowrap font-normal">User Management</span>
                        <i class="ri-arrow-right-line ri-lg text-c-light-black"></i>
                        <span class="font-semibold text-c-black">Users</span>
                        @if(!empty($company->name))
                            <i class="ri-arrow-right-line ri-lg text-c-light-black"></i>
                            <span class="font-semibold text-c-black">{{ $company->name }}</span>
                        @endif
                    </div>
                </div>
                
                <div class="relative taskicon hidden md:flex md:w-5/12 flex flex-row items-center justify-end gap-6">
                    <div id="searchbutton" class="flex items-center rounded overflow-hidden flex-shrink-0 flex-grow bg-c-white h-7 w-1/12 md:w-2/12 hidden md:flex">
                        <input type="text" class="search pl-4 pt-2.5 pb-2.5 flex-shrink flex-grow border-none outline-none font-size-14 w-3/12"
                               placeholder="Search users, roles & groups" id="searchterm" />
                        <div class="searchicon pt-3 pb-3 pr-4 flex items-center justify-center">
                            <i class="ri-search-line" id="search"></i>
                        </div>
                    </div>
                    <button class="has-tooltip addusermodel">
                        <i class="ri-add-circle-fill ri-xl"></i>
                    </button>
                    <div class="absolute py-1 px-2 text-start text-xs tooltip -bottom-8 right-5 z-10 bg-white border rounded-md border-c-yellow z-0 font-normal">
                        Add user
                    </div>
                    <!-- <button class="has-tooltip1">
                        <i class="ri-file-excel-2-fill ri-xl" id="showimport-upload-popup"></i>
                    </button>
                    <div class="absolute py-1 px-2 text-start text-xs tooltip1 -bottom-8 -right-5 z-10 bg-white border rounded-md border-c-yellow z-0">
                        Import Users
                    </div> -->
                </div>
            </div>

            <!-- Company Dropdowns -->
            <div class="px-4 py-3 md:px-6 md:py-4 flex gap-4 items-center bg-c-light-white-smoke">
                <label for="companyDropdown" class="font-semibold text-c-black">Select Company:</label>
                <select id="companyDropdown" class="w-full md:w-1/4 p-2 bg-white border border-c-gray rounded-md outline-none text-c-black">
                    <option value="">All Company</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Main Content -->
            <div class="p-4 relative h-full flex flex-col main-content overflow-y-scroll scroll">
                <div class="bg-white cs-table-container border border-c-gray rounded-md mt-5">
                    <table class="table-auto w-full">
                        <thead class="h-14">
                            <tr class="bg-c-dark-gray">
                                <th class="text-c-white font-medium text-left pl-3 rounded-tl-md"></th>
                                <th class="text-c-white font-medium text-left pl-3 whitespace-nowrap w-1/4 pr-3 md:pr-0">Name</th>
                                <th class="text-c-white font-medium text-left pl-3 pr-3 md:pr-0">Company</th>
                                <th class="text-c-white font-medium text-left pl-3 pr-3 md:pr-0">Role</th>
                                <th class="text-c-white font-medium text-left pl-3 pr-3 md:pr-0">Space Usage</th>
                                <th class="text-c-white font-medium text-left pl-3 pr-3 md:pr-0">Group</th>
                                <th class="text-c-white font-medium text-left pl-3 pr-3 md:pr-0">Status</th>
                                <th class="rounded-tr-md text-c-white font-medium text-left pl-3 pr-3 md:pr-0">Action</th>
                            </tr>
                        </thead>
                        <tbody id="searchableTableBody">
                        </tbody>
                    </table>
                </div>
                <div class="mt-auto flex justify-end pt-3 font-normal"></div>
            </div>
        </div>
    </div>

<div id="allUserModel">
    <!-- Add user modal -->
    <div id="addUserModelDiv" role="dialog"
        class="fixed hidden inset-0 flex items-center justify-center bg-black bg-opacity-50 z-10">
    </div>  
    <!-- End modal -->
    
    <!-- Edit user modal -->
    <div id="editUserModalDiv" role="dialog"
        class="fixed hidden inset-0 flex items-center justify-center bg-black bg-opacity-50 z-10">
    </div>
    <!-- End modal -->
</div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" tabindex="-1"
     class="fixed hidden inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <div class="delete-modal relative bg-white rounded-lg">
        <div class="p-4 md:p-5 text-center">
            <div class="delete-header flex items-center gap-4 mb-1 py-1">
                <i class="ri-delete-bin-6-line ri-xl text-c-yellow"></i>
                <h1 class="text-lg font-medium">Delete User</h1>
            </div>
            <hr>
            <div class="mt-6 flex items-center justify-center">
                <h1 class="text-md font-medium text-c-black">
                    Are you sure? This action cannot be undone!
                </h1>
            </div>
            <div class="flex items-center justify-center gap-3 mt-9">
                <button id="okdelete" class="bg-c-black text-white rounded-full px-12 sm:px-14 py-2" type="button">
                    OK
                </button>
                <button id="canceldelete" class="bg-white text-c-yellow px-9 sm:px-12 py-2 rounded-full border border-c-yellow">
                    Cancel
                </button>
                <input type="hidden" id="delete-id" value="">
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $(document).on('click', '#allUserModel .togglePassword', function(e) {
            var passwordField = $('#allUserModel .password');
            var toggleIcon = $(this).find('.toggleIcon');
            var type = passwordField.attr('type') === 'password' ? 'text' : 'password';
            passwordField.attr('type', type);
            toggleIcon.toggleClass('ri-eye-line ri-eye-off-line');
        });
        const companyDropdown = $('#companyDropdown');
        const companyLabel = $('#companyLabel');
        populateTable();
        function populateTable(searchTerm = '', page = 1, companyId = '') {
            const listRoute = @json(route('company.user.list'));
            $.ajax({
                url: listRoute,
                method: 'GET',
                data: {
                    page: page,
                    searchTerm: searchTerm,
                    company_id: companyId
                },
                success: function(response) {
                    $('#searchableTableBody').html(response.html);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        }


        // Update table on company dropdown change
        companyDropdown.on('change', function() {
            const companyId = $(this).val();
            const searchTerm = $('#searchterm').val();
            populateTable(searchTerm, 1, companyId);
        });

        $('#searchterm').on('input', function() {
            const searchTerm = $(this).val();
            populateTable(searchTerm, 1, companyDropdown.val());
        });

        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            const page = $(this).attr('href').split('page=')[1];
            populateTable($('#searchterm').val(), page, companyDropdown.val());
        });

        // Add User Modal
        $('.addusermodel').on('click', function() {
            const addUserRoute = @json(route('company.user.add')); 
            $.ajax({
                url: addUserRoute,
                method: 'GET',
                success: function(response) {
                    $('#addUserModelDiv').html(response.html).css('display','flex');
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        });

        $(document).on('submit', '#addUserModelDiv #newUser', function(e) {
            e.preventDefault();

            const form = $(this);
            const formData = form.serialize();
            const storeUserRoute = form.attr('action');

            $.ajax({
                url: storeUserRoute,
                method: 'POST',
                data: formData,
                success: function(response) {
                    // On success, show success message using Toastr and close the modal
                    toastr.success(response.success);
                    $('#addUserModelDiv').hide();

                    // Optionally, reload the users list after a new user is added
                    populateTable();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        // Clear existing errors
                        form.find('small.text-red-500').text('');

                        // Show validation errors
                        $.each(errors, function(field, messages) {
                            form.find(`[name="${field}"]`).siblings('small').text(messages[0]);
                        });
                    } else {
                        console.error(xhr.responseText);
                    }
                }
            });
        });

        // Edit User Modal
        $(document).on('click', '#searchableTableBody .editUserModal', function() {
            const editUserRoute = @json(route('company.user.edit'));
            const userId = $(this).data('user');
            $.ajax({
                url: editUserRoute,
                method: 'GET',
                data: { userid: userId },
                success: function(response) {
                    $('#editUserModalDiv').html(response.html).css('display','flex');
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        });

        // Save User
        $(document).on('submit', '#editUserModalDiv #editUserForm', function(e) {
            e.preventDefault();

            const form = $(this);
            const formData = form.serialize();
            const storeUserRoute = form.attr('action');

            $.ajax({
                url: storeUserRoute,
                method: 'PUT',
                data: formData,
                success: function(response) {
                    // On success, show success message using Toastr and close the modal
                    toastr.success(response.success);
                    $('#editUserModalDiv').hide();

                    // Optionally, reload the users list after a new user is added
                    populateTable();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        // Clear existing errors
                        form.find('small.text-red-500').text('');

                        // Show validation errors
                        $.each(errors, function(field, messages) {
                            form.find(`[name="${field}"]`).siblings('small').text(messages[0]);
                        });
                    } else {
                        console.error(xhr.responseText);
                    }
                }
            });

        });

        $(document).on('click', '#addUserModelDiv .closeModalButton', function(event) {
            $('#addUserModelDiv').hide();
        });
        $(document).on('click', '#editUserModalDiv .closeModalButton', function(event) {
            $('#editUserModalDiv').hide();
        });

        // Delete User Confirmation
        $(document).on('click', '.deleteUser', function() {
            const userId = $(this).data('id');
            $('#delete-id').val(userId);
            $('#delete-modal').removeClass('hidden');
        });

        $('#okdelete').on('click', function() {
            const userId = $('#delete-id').val();
            const deleteRoute = @json(route('company.user.delete'));
            $.ajax({
                url: deleteRoute,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: userId
                },
                success: function(response) {
                    toastr.success(response.message);
                    populateTable();
                    $('#delete-modal').addClass('hidden');
                },
                error: function(xhr) {
                    toastr.error('An error occurred.');
                    console.error(xhr.responseText);
                }
            });
        });

        $('#canceldelete').on('click', function() {
            $('#delete-modal').addClass('hidden');
        });

        
         // client change 
         function fetchRolesAndGroups(companyId = null) {
                    const fetchRolesAndGroupsRoute = @json(route('fetch.roles.groups.by.client'));

                    $.ajax({
                        url: fetchRolesAndGroupsRoute,
                        method: 'GET',
                        data: {
                            company_id : companyId
                        },
                        success: function (response) {
                            const rolesDropdown = $('#allUserModel .roleslist');
                            rolesDropdown.empty().append('<option value="">Select Role</option>');
                            response.roles.forEach(role => {
                                rolesDropdown.append(`<option value="${role.id}">${role.name}</option>`);
                            });

                            const groupsDropdown = $('#allUserModel .groupslist');
                            groupsDropdown.empty().append('<option value="">Select Group</option>');
                            response.groups.forEach(group => {
                                groupsDropdown.append(`<option value="${group.id}">${group.name}</option>`);
                            });
                        },
                        error: function (xhr) {
                            console.error(xhr.responseText);
                        }
                    });
            }

            $(document).on('change', '#allUserModel .companychangelist', function (e) {
                const companyId = $(this).val();
                fetchRolesAndGroups(companyId);
            });
            
             // Toggle status (Activate/Deactivate)
            $(document).on('click', '#searchableTableBody .toggleStatus', function() {
                let userId = $(this).data('id');
                let newStatus = $(this).data('status');
                let toggleRoute = @json(route('user.togglestatus'));

                $.ajax({
                    url: toggleRoute,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: userId,
                        status: newStatus
                    },
                    success: function(response) {
                        toastr.success(response.message);
                        populateTable(); // Reload the table to reflect the status change
                    },
                    error: function(xhr, status, error) {
                        toastr.error('An error occurred. Please try again.');
                        console.error(xhr.responseText);
                    }
                });
            });


    });
</script>
@endsection
