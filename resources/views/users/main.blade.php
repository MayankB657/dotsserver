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
            <!-- topTaskbar in desktop -->
            <div class="pl-4 md:pl-6 py-4 pr-4 md:pr-6 w-full flex flex-row justify-between items-center taskbar">
                <div class="w-full md:w-6/12 xl:w-8/12">
                    <div class="flex items-center gap-1 sm:gap-2">
                        <span class="text-c-light-black whitespace-nowrap font-normal">
                            User Management
                        </span>
                        <i class="ri-arrow-right-line ri-lg text-c-light-black"></i>
                        <span class="font-semibold text-c-black">
                            Users
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
                            placeholder="Search users,roles & groups" id="searchterm" />
                        <div class="searchicon pt-3 pb-3 pr-4 flex items-center justify-center">
                            <i class="ri-search-line" id="search"></i>
                        </div>
                    </div>
                    @if(filterView('route', 'adduser'))
                    <button class="has-tooltip addusermodel">
                        <i class="ri-add-circle-fill ri-xl"></i>
                    </button>
                    
                    <div class="absolute py-1 px-2 text-start text-xs tooltip -bottom-8 right-5 z-10 bg-white border rounded-md border-c-yellow z-0 font-normal">
                        Add user
                    </div>
                    @endif
                    @if(filterView('route', 'import-users'))
                    <button class="has-tooltip1">
                        <i class="ri-file-excel-2-fill ri-xl" id="showimport-upload-popup"></i>
                    </button>
                    <div class="absolute py-1 px-2 text-start text-xs tooltip1 -bottom-8 -right-5 z-10 bg-white border rounded-md border-c-yellow z-0">
                        Import Users
                    </div>
                    @endif
                </div>
               
            </div>
            <!-- searchbar in mobile-->
            <div class="pl-4 pt-3 mt-3 pb-3 pr-4 w-full flex flex-row justify-between items-center bg-c-light-white-smoke md:hidden"
                id="mobiletaskbar">
                <div class="relative w-full flex flex-row items-center justify-end gap-2">
                    <div class="flex items-center rounded overflow-hidden flex-shrink-0 flex-grow bg-c-white h-8 w-1/12">
                        <input type="text" id="searchterm"
                            class="pl-4 pt-2.5 pb-2.5 flex-shrink flex-grow border-none outline-none w-3/12"
                            placeholder="Search users..." />
                        <div class="pt-3 pb-3 pr-4 flex items-center justify-center">
                            <i class="ri-search-line" id="search"></i>
                        </div>
                    </div>
                    @if(filterView('route', 'adduser'))
                    <button class="px-2 has-tooltip addusermodel" >
                        <i class="ri-add-circle-fill ri-xl"></i>
                    </button>
                    <div
                        class="absolute py-1 px-2 text-start text-xs tooltip -bottom-8 right-5 z-10 bg-white border rounded-md border-c-yellow z-0">
                        Add user
                    </div>
                    @endif
                </div>
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
                                <th class="text-c-white font-medium text-left pl-3 pr-3 md:pr-0">
                                    <button class="font-medium">
                                        Role 
                                    </button>
                                </th>
                                <th class="text-c-white font-medium text-left pl-3 pr-3 md:pr-0">
                                    <button class="font-medium">
                                        Space Usage
                                    </button>
                                </th>
                                <th class="text-c-white font-medium text-left pl-3 pr-3 md:pr-0">
                                    Group
                                </th>
                                <th class="text-c-white font-medium text-left pl-3 pr-3 md:pr-0">
                                    Status
                                </th>
                                @if(filterView('route', 'edituser') || filterView('route', 'deleteuser') || filterView('route', 'user.togglestatus'))
                                <th class="rounded-tr-md text-c-white font-medium text-left pl-3 pr-3 md:pr-0">Action</th>
                                @endif
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

        <div id="allUserModel">
            <!-- Add user model-->
            <div id="addUserModelDiv" role="dialog"
            class="fixed hidden inset-0 flex items-center justify-center bg-black bg-opacity-50 z-10">
            <!-- <div id=""> -->
            </div>  
            <!-- End model-->
            <!-- Edit user model-->
            <div id="editUserModalDiv" role="dialog"
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
                <button id="canceldelete"class="bg-white text-c-yellow px-9 sm:px-12 py-2 rounded-full border border-c-yellow">
                    Cancel
                </button>
                <input type="hidden" id="delete-id" value="">
            </div>
        </div>
    </div>
</div>

<!-- Import user popup -->
<div id="import-users-modal" tabindex="-1"
     class="fixed hidden inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-lg shadow-lg">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-c-black">Import Users</h2>
            <i class="ri-close-line ri-xl cursor-pointer" id="close-import-modal"></i>
        </div>
        <hr class="border-t-2 border-gray-200 mb-4">
        <div class="overflow-y-auto scroll" style="max-height: calc(100vh - 10rem)">

            <!-- Download Sample File -->
            <div class="mb-4">
                <a href="{{ route('download-user-sample') }}" 
                   class="bg-c-yellow text-white rounded-full px-4 py-2 inline-flex items-center">
                    <i class="ri-download-2-line mr-2"></i>
                    Download Sample Excel File
                </a>
            </div>
    
            <!-- Drag and Drop Area -->
            <div id="drop-area"
                 class="border-2 border-dashed border-gray-300 bg-gray-100 p-4 flex flex-col items-center justify-center cursor-pointer hover:bg-gray-200 transition">
                <i class="ri-upload-cloud-line ri-3x text-c-black mb-2"></i>
                <p class="text-c-black font-semibold">Upload Your CSV/EXCEL file here</p>
                <!-- <p class="text-gray-500 text-sm">or</p> -->
                <input type="file" id="file-upload" class="hidden" accept=".xlsx,.csv">
                <button id="upload-btn" class="bg-c-yellow text-white rounded-full px-4 py-2 mt-2">Upload File</button>
            </div>

            <!-- Progress Bar -->
            <div id="progress-container" class="hidden mt-4">
                <p class="text-gray-600 mb-2">Importing users... <span id="progress-status">0%</span></p>
                <div class="w-full bg-gray-300 rounded-full mb-4">
                    <div id="progress-bar" class="bg-c-yellow h-2 rounded-full" style="width: 0%;"></div>
                </div>
                <div>
                <table class="w-full text-left mb-4">
                    <thead>
                        <tr>
                            <th class="p-2 border">Row</th>
                            <th class="p-2 border">Status</th>
                            <th class="p-2 border">Message</th>
    
                        </tr>
                    </thead>
                    <tbody id="status-table-body">
                        <!-- Status rows will be dynamically added here -->
                    </tbody>
                </table>
              </div>
            </div>

            <!-- Error Message Display -->
            <div id="error-message" class="hidden mt-4 p-3 bg-red-100 text-red-600 rounded-lg max-h-32 overflow-auto">
                <p><strong>Error(s) Found:</strong></p>
                <ul id="error-list" class="list-disc ml-5 text-sm"></ul>
            </div>
        </div>
    </div>
</div>

<!-- end import popup-->

    

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
            // Initial population of the table
            populateTable();

            function populateTable(searchTerm = '', page = 1) {
                const listroute = @json(route('userlist'));
                $.ajax({
                    url: listroute,
                    method: 'GET',
                    data: {
                        page: page,
                        searchTerm: searchTerm
                    },
                    success: function(response) {
                        // Update the app list container with the updated list
                        $('#searchableTableBody').html(response.html);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });

            }
            // search 
                $('#searchterm').on('input', function() {
                    const searchTerm = $(this).val();
                    populateTable(searchTerm);
                });

                // Pagination handling
                $(document).on('click', '.pagination a', function(e) {
                    e.preventDefault();
                    var page = $(this).attr('href').split('page=')[1];
                    populateTable($('#searchterm').val(), page); // Pass the search term and page
                });
            // end search 

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

             // Function to toggle the modal
        // function toggleModal(modalId) {
        //     const modal = document.getElementById(modalId);
        //     if (modal) {
        //         modal.classList.toggle('hidden');
        //     }
        // }

       // Click event for add user button
            $('.addusermodel').on('click', function() {
                const addUserRoute = @json(route('adduser')); 
                
                $.ajax({
                    url: addUserRoute,
                    method: 'GET',
                    success: function(response) {
                        $('#addUserModelDiv').html(response.html);
                        
                        $('#addUserModelDiv').css('display','flex');
                        // toggleModal('addUserModelDiv');
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });

            $(document).on('click', '#addUserModelDiv .closeModalButton', function(event) {
                $('#addUserModelDiv').hide();
            });

            // save user
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
                // add user end 

                /// Edit user 
            $(document).on('click', '#searchableTableBody .editUserModal', function(e) {
                const editUserRoute = @json(route('edituser')); 
                let userid = $(this).data('user');
                $.ajax({
                    url: editUserRoute,
                    method: 'GET',
                    data : {userid:userid},
                    success: function(response) {
                        $('#editUserModalDiv').html(response.html);
                        
                        $('#editUserModalDiv').css('display','flex');
                        // toggleModal('addUserModelDiv');
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });

            $(document).on('click', '#editUserModalDiv .closeModalButton', function(event) {
                $('#editUserModalDiv').hide();
            });

            // save user
            $(document).on('submit', '#editUserModalDiv #editUser', function(e) {
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


            /// delete user 
                let deleteUserId;
                // Show delete confirmation modal
                $(document).on('click', '.deleteUser', function() {
                    deleteUserId = $(this).data('id'); // Get the user ID from the button
                    $('#delete-id').val(deleteUserId); // Set the ID in the hidden input field
                    $('#delete-modal').removeClass('hidden'); // Show the modal
                });

                // Handle OK button click for delete confirmation
                $('#okdelete').on('click', function() {
                    let userId = $('#delete-id').val(); // Get the user ID from the hidden input field
                    let deleteRoute = @json(route('deleteuser')); // Route to delete the user

                    $.ajax({
                        url: deleteRoute,
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: userId
                        },
                        success: function(response) {
                            // Hide the modal
                            $('#delete-modal').addClass('hidden');

                            // Show toastr success message
                            toastr.success(response.message);

                            // Reload the table to reflect the deletion
                            populateTable();
                        },
                        error: function(xhr) {
                            toastr.error('An error occurred. Please try again.');
                            console.error(xhr.responseText);
                        }
                    });
                });

                // Hide delete confirmation modal
                
                $('#canceldelete').on('click', function() {
                    $('#delete-modal').addClass('hidden');
                });
                
                // Open import users modal
                $('#showimport-upload-popup').on('click', function() {
                    $('#import-users-modal').removeClass('hidden');
                });

                // Close import modal
                $('#close-import-modal').on('click', function() {
                    $('#import-users-modal').addClass('hidden');
                    // Reset progress bar and error messages
                    $('#progress-bar').css('width', '0%');
                    $('#progress-status').text('0%');
                    $('#progress-container').addClass('hidden');
                    $('#error-message').addClass('hidden');
                    $('#status-table-body').html(''); // Clear previous status
                    $('#error-list').html(''); // Clear previous errors
                    
                });

                // Drag-and-drop functionality
                // $('#drop-area').on('click', function() {
                //     $('#file-upload').click();
                // });

                $('#upload-btn').on('click', function() {
                    $('#file-upload').click();
                });

                $('#file-upload').on('change', function() {
                    let file = this.files[0];
                    handleFileUpload(file);
                });

                function handleFileUpload(file) {
                    let formData = new FormData();
                    formData.append('file', file);
                    formData.append('_token', '{{ csrf_token() }}');

                    // Reset progress bar and error messages
                    $('#progress-bar').css('width', '0%');
                    $('#progress-status').text('0%');
                    $('#progress-container').removeClass('hidden');
                    $('#error-message').addClass('hidden');
                    $('#status-table-body').html(''); // Clear previous status
                    $('#error-list').html(''); // Clear previous errors

                    // AJAX request to handle the file upload
                    $.ajax({
                        url: '{{ route("import-users") }}',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        xhr: function() {
                            let xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function(evt) {
                                if (evt.lengthComputable) {
                                    let percentComplete = Math.round((evt.loaded / evt.total) * 100);
                                    $('#progress-bar').css('width', percentComplete + '%');
                                    $('#progress-status').text(percentComplete + '%');
                                }
                            }, false);
                            return xhr;
                        },
                        success: function(response) {
                            // Show status for each row
                            let rowHtml='';
                            if (response.rows.length > 0) {
                                response.rows.forEach(function(row, index) {
                                     rowHtml += `<tr>
                                        <td class="p-2 border">${index + 1}</td>
                                        <td class="p-2 border">
                                            ${row.success ? 
                                                '<i class="ri-check-line text-green-500"></i> Success' :
                                                '<i class="ri-close-line text-red-500"></i> Failed'}
                                        </td>
                                        <td class="p-2 border">${row.success ? '<span class="text-green-500">Successfully Added</span>' : '<span class="text-red-500">'+row.error+'</span>' }</td>
                                    </tr>`;
                                
                                    // If failed, add to the error list
                                    // if (!row.success) {
                                    //     $('#error-list').append(`<li>Row ${index + 1}: ${row.error}</li>`);
                                    // }
                                });
                            }

                            $('#status-table-body').append(rowHtml);

                                populateTable();

                            // If there are errors, show the error message section
                            if (response.errors && response.errors.length > 0) {
                                $('#error-message').removeClass('hidden');
                            }
                        },
                        error: function(xhr) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(index, error) {
                                $('#error-list').append('<li>' + error + '</li>');
                            });
                            $('#error-message').removeClass('hidden');
                        }
                    });
                }

        });


    </script>

@endsection
