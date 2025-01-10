@extends('layouts.backendsettings')
@section('title', 'Roles')
@section('content')

    <div class="flex-grow h-100 main">
        <div class="flex w-full h-full flex-col content">
            <div class="px-9 py-3.5 lg:py-6 lg:px-5">
                <div class="flex items-center gap-4">
                    <i class="ri-settings-3-fill ri-xl"></i>
                    <span class="text-lg text-c-black font-normal">Role Management</span>
                </div>
            </div>
            <!-- topTaskbar in desktop -->
            <div class="pl-4 md:pl-6 py-4 pr-4 md:pr-6 w-full flex flex-row justify-between items-center taskbar">
                <div class="w-full md:w-6/12 xl:w-8/12">
                    <div class="flex items-center gap-1 sm:gap-2">
                        <span class="text-c-light-black whitespace-nowrap font-normal">
                            Role Management
                        </span>
                        <i class="ri-arrow-right-line ri-lg text-c-light-black"></i>
                        <span class="font-semibold text-c-black">
                            Roles
                        </span>
                        @if(!empty($company->name))
                            <i class="ri-arrow-right-line ri-lg text-c-light-black"></i>
                            <span class="font-semibold text-c-black">
                                {{ $company->name }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="relative taskicon hidden md:flex md:w-5/12 flex flex-row items-center justify-end gap-6">
                    <div id="searchbutton"
                        class="flex items-center rounded overflow-hidden flex-shrink-0 flex-grow bg-c-white h-7 w-1/12 md:w-2/12 hidden md:flex">
                        <input type="text"
                            class="search pl-4 pt-2.5 pb-2.5 flex-shrink flex-grow border-none outline-none font-size-14 w-3/12"
                            placeholder="Search roles" id="searchterm" />
                        <div class="searchicon pt-3 pb-3 pr-4 flex items-center justify-center">
                            <i class="ri-search-line" id="search"></i>
                        </div>
                    </div>
                    <button class="has-tooltip addrolemodel">
                        <i class="ri-add-circle-fill ri-xl"></i>
                    </button>
                    <div class="absolute py-1 px-2 text-start text-xs tooltip -bottom-8 right-5 z-10 bg-white border rounded-md border-c-yellow z-0 font-normal">
                        Add Role
                    </div>
                    
                    
                </div>
            </div>

            <!-- Client Dropdown -->
            <div class="px-4 py-3 md:px-6 md:py-4 flex justify-between items-center bg-c-light-white-smoke">
                <label for="clientDropdown" class="font-semibold text-c-black">Select Client:</label>
                <select id="clientDropdown" class="w-full md:w-1/3 p-2 bg-white border border-c-gray rounded-md outline-none text-c-black">
                    <option value="">All Clients</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                    @endforeach
                </select>
            </div>

            <!--Main content -->
            <div class="p-4 relative h-full flex flex-col main-content overflow-y-scroll scroll">
                
                <div class="bg-white cs-table-container border border-c-gray rounded-md mt-5">
                    <table class="table-auto w-full">
                        <thead class="h-14">
                            <tr class="bg-c-dark-gray">
                                <th class="text-c-white font-medium text-left pl-3 rounded-tl-md"></th>
                                <th class="text-c-white font-medium text-left pl-3 whitespace-nowrap w-1/4 pr-3 md:pr-0">
                                    Name
                                </th>
                                <th class="text-c-white font-medium text-left pl-3 whitespace-nowrap w-1/4 pr-3 md:pr-0">
                                    Client
                                </th>
                                <th class="text-c-white font-medium text-left pl-3 pr-3 md:pr-0 w-2/4">
                                    <button class="font-medium">
                                        Description
                                    </button>
                                </th>
                                <!-- <th class="text-c-white font-medium text-left pl-3 pr-3 md:pr-0">
                                    Permissions
                                </th> -->
                                <th class="text-c-white font-medium text-left pl-3 pr-3 md:pr-0">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody id="searchableTableBody">
                        </tbody>
                    </table>
                </div>

                <div class="mt-auto flex justify-end pt-3 font-normal">
                </div>
            </div>
        </div>

    </div>

        <div id="allRoleModel">
            <!-- Add role model-->
            <div id="addRoleModelDiv" role="dialog"
            class="fixed hidden inset-0 flex items-center justify-center bg-black bg-opacity-50 z-10">
            </div>  
            <!-- End model-->
            <!-- Edit role model-->
            <div id="editRoleModalDiv" role="dialog"
                    class="fixed hidden inset-0 flex items-center justify-center bg-black bg-opacity-50 z-10">
            </div>
        </div>
            <!-- End model-->


    <!-- Delete Confirmation Modal -->
<div id="delete-modal" tabindex="-1"
     class="fixed hidden inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <div class="delete-modal relative bg-white rounded-lg">
        <div class="p-4 md:p-5 text-center">
            <div class="delete-header flex items-center gap-4 mb-1 py-1">
                <i class="ri-delete-bin-6-line ri-xl text-c-yellow"></i>
                <h1 class="text-lg font-medium">Delete Role</h1>
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

<!-- end import popup-->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Initial population of the table
            populateTable();

             // Populate the table with company data
             function populateTable(searchTerm = '', page = 1, clientId = '') {
                const listroute = @json(route('client.role.list'));
                $.ajax({
                    url: listroute,
                    method: 'GET',
                    data: {
                        page: page,
                        searchTerm: searchTerm,
                        client_id: clientId
                    },
                    success: function(response) {
                        $('#searchableTableBody').html(response.html);
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            }
            // search 
                $('#searchterm').on('input', function() {
                    const searchTerm = $(this).val();
                    populateTable(searchTerm);
                });
                 // Client dropdown handling
                $('#clientDropdown').on('change', function() {
                    const clientId = $(this).val();
                    const searchTerm = $('#searchterm').val();
                    populateTable(searchTerm, 1, clientId);
                });

            // Pagination handling
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                const page = $(this).attr('href').split('page=')[1];
                populateTable($('#searchterm').val(), page);
            });

            // Add Role Modal
            $('.addrolemodel').on('click', function() {
                const addRoleRoute = @json(route('client.role.add')); 
                $.ajax({
                    url: addRoleRoute,
                    method: 'GET',
                    success: function(response) {
                        $('#addRoleModelDiv').html(response.html).css('display','flex');
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            });

            $(document).on('submit', '#addRoleModelDiv #newRole', function(e) {
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
                        $('#addRoleModelDiv').hide();

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
                                $(`small[name="${field}"]`).text(messages[0]);
                            });
                        } else {
                            console.error(xhr.responseText);
                        }
                    }
                });
            });
            // Edit Role Modal
            $(document).on('click', '#searchableTableBody .editRoleModal', function() {
                const editRoleRoute = @json(route('client.role.edit'));
                const roleId = $(this).data('role');
                $.ajax({
                    url: editRoleRoute,
                    method: 'GET',
                    data: { roleid: roleId },
                    success: function(response) {
                        $('#editRoleModalDiv').html(response.html).css('display','flex');
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            });

            // save user
            $(document).on('submit', '#editRoleModalDiv #editRoleForm', function(e) {
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
                        $('#editRoleModalDiv').hide();

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
                                $(`small[name="${field}"]`).text(messages[0]);
                            });
                        } else {
                            console.error(xhr.responseText);
                        }
                    }
                });

            });

            $(document).on('click', '#addRoleModelDiv .closeModalButton', function(event) {
                $('#addRoleModelDiv').hide();
            });
            $(document).on('click', '#editRoleModalDiv .closeModalButton', function(event) {
                $('#editRoleModalDiv').hide();
            });


            // Delete Role Confirmation
            $(document).on('click', '.deleteRole', function() {
                const roleId = $(this).data('id');
                $('#delete-id').val(roleId);
                $('#delete-modal').removeClass('hidden');
            });

            $('#okdelete').on('click', function() {
                const roleId = $('#delete-id').val();
                const deleteRoute = @json(route('client.role.delete'));
                $.ajax({
                    url: deleteRoute,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: roleId
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

            
        });
    </script>
@endsection
