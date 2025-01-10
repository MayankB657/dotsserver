<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{ asset($constants['IMAGEFILEPATH'] . 'logo.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'] . 'custom.css') }}">
    <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'] . 'root.css') }}">
    <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'] . 'cs.css') }}">
    <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'] . 'as.css') }}">
    <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'] . 'nx.css') }}">
    <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'] . 'custom.css') }}">
    <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'] . 'custom-reusable-style.css') }}">
    <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'] . 'common.css') }}">
    <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'] . 'tour.min.css') }}">
    @yield('styles')
</head>

<body class="h-screen w-full">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Taskbar -->
    <div class="taskbar-slide h-16 flex items-center w-full absolute">

        <div class="flex justify-center ml-10 w-full relative h-full" id="toolbar">
            <div class="bg absolute w-full  bottom-0">
                <img id="shelf" class="w-full" src="{{ asset($constants['IMAGEFILEPATH'] . 'shelf.png') }}"
                    alt="">
            </div>
        </div>
        <div class="flex items-center gap-8 w-48 justify-end pr-5">
            <i id="search-icon" class="ri-search-line "></i>
            <i id="notification-icon" class="ri-notification-3-line "></i>
        </div>

    </div>
    <main class="w-full h-full flex cm account">

        <!-- Sidebar -->
        <aside class="h-full relative">
            <input type="checkbox" class="hidden" id="sidebar-toggle" />
            <label
                for="sidebar-toggle"
                class="absolute lg:hidden top-7 -right-8 px-1">
                <i class="ri-bar-chart-horizontal-line"></i>
            </label>
            <div class="h-full sidebar">
                <div class="sidebar-container">
                    <div class="p-4">
                        
                            <img class="w-20" src="{{ asset($constants['IMAGEFILEPATH'] . 'logo.png') }}"
                                alt="Dots Logo" />
                       
                    </div>
                    <div class="md:pt-6">
                        <ul class="space-y-1">
                            <li>
                                <a
                                    class="w-full px-6 py-3 rounded-r-lg block flex justify-between items-center"
                                    href="admin-account-page.html">
                                    <span> Account </span>
                                    <i
                                        class="ri-arrow-right-s-line text-c-yellow transition-all text-2xl"></i>
                                </a>
                            </li>
                            <li>
                                <a
                                    id="wallpaper"
                                    class="w-full px-6 py-3 rounded-r-lg block flex justify-between items-center"
                                    href="admin-wallpaper-page.html">
                                    <span> Wallpaper </span>
                                    <i
                                        class="ri-arrow-right-s-line text-c-yellow transition-all text-2xl"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        @yield('content')
        <!-- Main Content end -->

    </main>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset($constants['JSFILEPATH'] . 'sidebar.js') }}"></script>
    <script src="{{ asset($constants['JSFILEPATH'] . 'select-dropdown.js') }}"></script>
    <script src="{{ asset($constants['JSFILEPATH'] . 'custom-dropdown.js') }}"></script>
    <script src="{{ asset($constants['JSFILEPATH'] . 'tabs.js') }}"></script>
    <script src="{{ asset($constants['JSFILEPATH'] . 'taskbar.js') }}"></script>
    <script src="{{ asset($constants['JSFILEPATH'] . 'formValidation.js') }}"></script>
    <script src="{{ asset($constants['JSFILEPATH'].'tourguidejs/tour.js') }}"></script>
    <script src="{{ asset($constants['JSFILEPATH'].'admin-wallpaper-tour.js') }}"></script>
    @yield('scripts')
</body>

</html>