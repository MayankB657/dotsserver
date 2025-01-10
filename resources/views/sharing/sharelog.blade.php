<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users and Groups</title>
    <!-- Include Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'] . 'root.css') }}">
    <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'] . 'setting-admin-users.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Add jQuery for simplicity -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>

<main class="bg-gray-100 pt-5">
    <div class="flex items-center mb-4 ml-4 p-3">
        <!-- Setting icon -->
        <span class="text-gray-500 mr-3 text-2xl ">
            <i class="fas fa-cog"></i>
        </span>
        <!-- Title -->
        <span class="text-2xl">Share Logs</span>
    </div>

    <div class="flex items-center justify-between bg-yellow-400 p-2 pl-8  mb-4">
        <div>
            <h2 class="text">Stroge File/<span class="font-semibold">Share</span></h2>
        </div>
    </div>

    <div class="users-admin-btn-grp pl-8 flex items-center relative justify-between">

        <div class="flex items-center gap-3">


            <button data-filter="today"
                class="flex items-center focus:border-yellow-500 dropdown-toggle border border-gray-300 rounded px-6 py-1 mr-2 hover:border-yellow-300 filter-button">Today</button>


            <button data-filter="7-days"
                class="flex items-center focus:border-yellow-500 dropdown-toggle border border-gray-300 rounded px-6 py-1 mr-2 hover:border-yellow-300 filter-button">Last
                7 days</button>
            <button data-filter="30-days"
                class="flex items-center focus:border-yellow-500 dropdown-toggle border border-gray-300 rounded px-6 py-1 mr-2 hover:border-yellow-300 filter-button">Last
                30 days</button>
            <button id="customize"
                class="flex items-center focus:border-yellow-500 dropdown-toggle border border-gray-300 rounded px-6 py-1 mr-2 hover:border-yellow-300">
                Customize
            </button>
            <button id="filter"
                class="flex items-center focus:border-yellow-500 dropdown-toggle border border-gray-300 rounded px-6 py-1 mr-2 hover:border-yellow-300 hidden">
                Filter
            </button>
            <div
                class="date-select flex items-center gap-2 focus:border-yellow-500 dropdown-toggle border border-gray-300 rounded mr-2 hover:border-yellow-300 hidden">
                <input id="start-date" class="outline-none bg-gray-100 w-24 py-1 pl-2" datepicker datepicker-autohide
                    type="text" placeholder="Select date start" readonly>
                <input id="start-time" type="time" class="outline-none bg-gray-100" min="09:00" max="18:00"
                    value="00:00" required />
            </div>

            <div
                class="date-select flex items-center gap-2 focus:border-yellow-500 dropdown-toggle border border-gray-300 rounded mr-2 hover:border-yellow-300 hidden">
                <input id="end-date" class="outline-none bg-gray-100 w-24 py-1 pl-2" datepicker datepicker-autohide
                    type="text" placeholder="Select date end" readonly>
                <input id="end-time" type="time" class="outline-none bg-gray-100" min="09:00" max="18:00"
                    value="00:00" required />
            </div>


            <a href="{{ url('export-share') }}" class="btn btn-success" id="my_export" target="_blank">Export to
                Excel</a>

            <!-- <a class="btn btn-success" id="export-button">Export to Excel</a> -->
            <!-- Dropdown menu -->
            <select
                class="flex items-center focus:border-yellow-500 dropdown-toggle border border-gray-300 rounded px-6 py-2 mr-2 hover:border-yellow-300  form-control roles_filter"
                id="sel1" name="roleID" id="roleID">
                <option value="">Please Select</option>
                @foreach ($roles as $role)
                    <option data-role-ID = "{{ $role->id }}" value="{{ $role->id }}">{{ $role->name }}
                    </option>
                @endforeach

            </select>
            <!-- User List -->
            <div id="userList" class="mt-5">
                <!-- Users will be displayed here -->
            </div>

        </div>

    </div>

    <div class="users-admin-content-wrapper pl-8  pr-3">
        <div class="container mx-auto mt-10">
            <!-- Searchable Table -->
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" id="my-table">
                    <thead class="text-xs text-white uppercase bg-gray-500 dark:text-white">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Sharer
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Sharer Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Sharing Type
                            </th>


                            <th scope="col" class="px-6 py-3">
                                Details
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Views
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Downloads
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Expiration
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Share Time
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody id="log-entries" id="userList">
                        @foreach ($log as $logs)
                            <tr class=" bg-white border-b dark:bg-gray-800 dark:border-gray-700">

                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">

                                    <span class="bg-gray-400 rounded-full px-2"></span> {{ $logs->sharedByUser->name }}
                                </th>
                                <td class="px-6 py-4">
                                    @if ($logs->files_id == null)
                                        {{ $logs->folder->name }}
                                    @else
                                    {{ $logs->file->name }}
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-blue-600">
                                    Link Share
                                </td>

                                <td class="px-6 py-4 flex items-center text-blue-600">
<a href="{{ url('/') }}{{ $logs->url }}" target="_blank">External Link</a>

                                </td>
                                <td class="px-6 py-4">
                                    {{ $logs->views }}

                                </td>
                                <td class="px-6 py-4">
                                    {{ $logs->downloads }}

                                </td>
                                <td class="px-6 py-4">

                                    {{ \Carbon\Carbon::parse($logs->expiry)->format('d-m-y') }}


                                </td>
                                <td class="px-6 py-4">
                                    <span><i class="ri-calendar-2-line"></i>&nbsp; {{ \Carbon\Carbon::parse($logs->created_at)->format('d-m-y') }}</span>
                                    <span><i class="ri-time-line"></i>&nbsp;{{ \Carbon\Carbon::parse($logs->created_at)->format('H:i') }}</span>

                                </td>


                                <td>
                                    <button class="cancel-share text-blue-600" data-id="{{ $logs->id }}" >Cancel Share</button>
                                </td>
                            </tr>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                <!-- Pagination Links -->
                {{ $log->links() }}
                <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
                <!-- Export Functionality -->

                <!-- Cancel share Functionality -->





<script>
$(document).ready(function() {
    $('.cancel-share, .cancel-share-btn').click(function() {
        var id = $(this).data('id');
        var row = $(this).closest('tr');

        var confirmMessage = 'Are you sure you want to cancel the share?';
        var useRoute = $(this).hasClass('cancel-share');

        if (!useRoute || confirm(confirmMessage)) {
            var url = useRoute
                ? '{{ route("cancel.share", ":id") }}'.replace(':id', id)
                : '{{ url("cancel-share") }}/' + id;
            var type = useRoute ? 'GET' : 'DELETE';

            $.ajax({
                url: url,
                type: type,
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (useRoute) {
                        location.reload();
                    } else if (response.success) {
                        row.remove();
                    } else {
                        alert('An error occurred while cancelling the share.');
                    }
                },
                error: function(xhr) {
                    alert('An error occurred. Please try again later.');
                }
            });
        }
    });
});
</script>



<script>

//delete share end
                    document.addEventListener('DOMContentLoaded', (event) => {


                        // Get the current time
                        const now = new Date();
                        let hours = now.getHours();
                        let minutes = now.getMinutes();

                        // Pad the hours and minutes with leading zeros if needed
                        hours = hours < 10 ? '0' + hours : hours;
                        minutes = minutes < 10 ? '0' + minutes : minutes;

                        // Set the current time in the time input field
                        const currentTime = hours + ':' + minutes;
                        document.getElementById('end-time').value = currentTime;
                    });

                    $(document).ready(function() {
                        $('.filter-button').on('click', function() {
                            var filter = $(this).data('filter');

                            $.ajax({
                                url: '{{ route('shareLogs.filter') }}', // Route to handle the AJAX request
                                type: 'GET',
                                data: {
                                    filter: filter
                                },
                                success: function(response) {
                                    $('#log-entries').html(response
                                    .html); // Update the table body with the new data
                                }
                            });

                            var baseUrl = "{{ url('export-logins') }}";
                            var newUrl = baseUrl + '?filter=' + filter;
                            $('#my_export').attr('href', newUrl);

                        });


                        $('.roles_filter').on('change', function() {

                            var roles = $(this).val();

                            $.ajax({
                                url: '{{ route('shareLogs.filter') }}', // Route to handle the AJAX request
                                type: 'GET',
                                data: {
                                    roles: roles,
                                    filter: 'role'
                                },
                                success: function(response) {
                                    $('#log-entries').html(response
                                    .html); // Update the table body with the new data
                                }
                            });
                            var baseUrl = "{{ url('export-logins') }}";
                            var newUrl = baseUrl + '?roles=' + roles;
                            $('#my_export').attr('href', newUrl);
                        });
                    });
                </script>
                <script>
                    $(document).ready(function() {
                        $('#filter').click(function() {
                            // Get the input values
                            var startDate = $('#start-date').val();
                            var startTime = $('#start-time').val();
                            var endDate = $('#end-date').val();
                            var endTime = $('#end-time').val();

                            // Combine and format date and time
                            var startDateTime = startDate + ' ' + startTime;
                            var endDateTime = endDate + ' ' + endTime;

                            // Format date-time to Y-m-d H:i
                            var startDateTimeFormatted = formatDateTime(startDateTime);
                            var endDateTimeFormatted = formatDateTime(endDateTime);

                            // Make AJAX request
                            $.ajax({
                                url: '{{ route('shareLogs.filter') }}', // URL to send the request to
                                type: 'GET',
                                data: {
                                    start_date_time: startDateTimeFormatted,
                                    end_date_time: endDateTimeFormatted,
                                    filter: 'dateTime'
                                },
                                success: function(response) {
                                    // Handle success

                                    $('#log-entries').html(response.html);

                                },
                                error: function(xhr, status, error) {
                                    // Handle error
                                    console.error(error);
                                }
                            });
                            var baseUrl = "{{ url('export-logins') }}";
                            var newUrl = baseUrl + '?start_date_time=' + startDateTimeFormatted + '&end_date_time=' +
                                endDateTimeFormatted;
                            $('#my_export').attr('href', newUrl);
                        });

                        function formatDateTime(dateTime) {
                            var date = new Date(dateTime);
                            var year = date.getFullYear();
                            var month = ('0' + (date.getMonth() + 1)).slice(-2);
                            var day = ('0' + date.getDate()).slice(-2);
                            var hours = ('0' + date.getHours()).slice(-2);
                            var minutes = ('0' + date.getMinutes()).slice(-2);
                            return `${year}-${month}-${day} ${hours}:${minutes}`;
                        }
                    });
                </script>
                <script type="text/javascript">
                    var filter = document.getElementById('filter');
                    document.getElementById("customize").addEventListener("click", function() {
                        filter.classList.toggle("hidden")
                        document.querySelectorAll(".date-select").forEach(function(element) {
                            element.classList.toggle('hidden');
                        });
                    })
                </script>
            </div>

        </div>
    </div>


</main>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
