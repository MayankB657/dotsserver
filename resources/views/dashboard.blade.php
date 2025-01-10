@extends('layouts.common')
@section('title', 'Dashboard')
@section('styles')
    <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'] . 'dashbord.css') }}">

@endsection
@section('content')

    <div class="w-full h-full dashboard cs pt-20 relative">

        <div class="desktopapps-div w-full overflow-x-auto">
            <div id="desktopapps"
                class="desktop-apps allfilesandfolders content-start allapplist gap-4 p-2 pt-3 h-full flex flex-col  flex-wrap">

            </div>
        </div>



        <!-- Notification -->
        <div id="notification" class="Notification h-80 absolute right-5 sm:right-20 top-16 hidden overflow-hidden">
            <div class="h-16 border-b-2 border-c-gray py-4 px-4 flex items-center justify-between">
                <h1 class="text-sm sm:text-lg text-c-black font-normal">Notification Center</h1>
                <h1 class="text-sm sm:text-lg text-c-yellow font-medium cursor-pointer">Mark all as read</h1>
            </div>
            <div class="scrollbar-div overflow-y-auto" style="height: calc(100% - 64px);">

            </div>
        </div>

        <!-- Search Input -->
        <div id="search" class="Search hidden fixed top-60 sm:top-72 md:top-80 lg:top-64">
            <div class="row">
                <i class="ri-search-line search-icon absolute"></i>
                <input type="search" id="searchInput" placeholder="Search">
                <i class="ri-close-line cross-icon absolute" onclick=""></i>
            </div>
            <div id="searchsuggestions" class="searchdata allapplist hidden px-3 py-3 max-h-96">
            </div>
        </div>

        <!-- Right Sidebar -->
        <div class="dashboardefaultdapp allapplist dashboard-sidebar w-16 px-2 hidden sm:block" data-option="app">
            @if($apps)
            @foreach ($apps as $app)
            @if(checkSpecificTo($app))
            <a href="#" data-path ="{{ base64UrlEncode($app->path) }}" class="openiframe selectapp {{ !empty($app->app_function) ? 'customfunction' : '' }} "  data-popup="{{ $app->app_function}}" data-appkey="{{ base64UrlEncode($app->id) }}" data-filekey="{{ base64UrlEncode($app->id) }}" data-filetype="app" data-apptype="app">
                <img loading="lazy" class="mb-2 icondisplay"src="{{ checkIconExist($app->icon,'app') }}" alt="{{ $app->name }}" style="transition: transform 0.2s ease-in-out;"
            onmouseover="this.style.transform='scale(1.2)';"
            onmouseout="this.style.transform='scale(1)';" />
                </a>
            @endif
            @endforeach
            @endif
        </div>

        <!-- Administrator -->
        <div id="administrator" class="Administrator h-max absolute right-5 sm:right-28 bottom-16 hidden">
            <div class="flex items-center gap-5 pl-10 pt-5">
                <form action="{{ route('ProfilePic') }}" id="FormProfilePic" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="logo mb-2">
                        <input type="file" name="profile" accept="image/*" id="ProfilePic" class="hidden">
                        <label for="ProfilePic">
                            @if (Auth::user()->avatar != null)
                                <img loading="lazy" class="w-16 h-16 rounded-full object-cover" loading="lazy"
                                    src="{{ url('/') }}/{{ Auth::user()->avatar }}" alt="user image" />
                            @else
                                <img loading="lazy" class="w-16" src="{{ asset($constants['IMAGEFILEPATH'] . 'profile.png') }}"
                                    alt="user image" />
                            @endif
                        </label>
                    </div>
                </form>
                <div class="user-info">
                    <h1 class="text-lg font-normal underline underline-offset-8 decoration-1">
                         {{Auth::user()->username}}
                    </h1>
                    <h4 class="text-sm">{{ ucfirst(Auth::user()->name) }}</h4>
                </div>
            </div>
            <div class="bottom border-t-2 border-gray-500">
                <div class="features-list py-5 px-16">
                    <ul>
                        @if($menuapps)
                            @foreach ($menuapps as $menuapp)
                            @if(checkSpecificTo($menuapp))
                                <li class="flex items-center gap-8 mb-4 allapplist" data-option="app">
                                   <img loading="lazy" class="mb-2 w-8 icondisplay"src="{{ checkIconExist($menuapp->icon,'app') }}" alt="{{ $menuapp->name }}" />
                                    <a href="#" class="openiframe selectapp" data-path ="{{ base64UrlEncode($menuapp->path) }}" data-appkey="{{ base64UrlEncode($menuapp->id) }}" data-filekey="{{ base64UrlEncode($menuapp->id) }}" data-filetype="app" data-apptype="app">{{ $menuapp->name }}</a>
                                </li>
                            @endif
                            @endforeach
                        @endif


                        <li class="flex items-center gap-8 mb-4">
                            <i class="ri-logout-box-r-line ri-1x Ad-iconcolor"></i>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Administrator end -->


        <!-- Footer -->

        <!-- Footer -->
        <div class="absolute bottom-4 right-4 px-5 has-tooltip flex justify-center items-center gap-4">
             <!-- Clock -->
            <div class="clock flex flex-col items-center" id="clock"></div>
            <img id="footer-logo" loading="lazy" class="w-10 h-10" src="{{ asset($constants['IMAGEFILEPATH'] . 'logo.png') }}"
                alt="Logo" />
        </div>
        <div class="absolute py-1 px-2 text-start text-xs tooltip bottom-2 right-20 z-10 bg-white border rounded-md border-c-yellow font-normal">
                Administrator
        </div>


    </div>
@endsection
@section('scripts')
    @php
        $path = base64UrlEncode('Desktop');
    @endphp
    <script>
        // After 4 seconds, hide the curtains
        setTimeout(() => {
        $('#curtain').addClass('hidden');
        }, 4000);
    </script>
    <script>
        let path = @json($path);
        let navbar = true;
    </script>
    <script src="{{ asset($constants['JSFILEPATH'] . 'dashboard.js') }}"></script>
    <script>
        $(document).ready(function() {
            if ($('.navbarhead').hasClass('taskbar-slide')) {
                $('.navbarhead').removeClass('taskbar-slide');

            }

            $('#searchInput').on('input', function() {
                $('#searchsuggestions').html('');
                let searchQuery = $(this).val().trim(); // Get the search query from the input field
                if (searchQuery.length > 0) {
                    // Send AJAX request to the route
                    $.ajax({
                        url: '{{ route('search') }}', // Replace '/search' with your actual route URL
                        method: 'GET',
                        data: {
                            query: searchQuery
                        }, // Pass the search query as data
                        success: function(response) {
                            // Update the search results div with the response data
                            $('#searchsuggestions').html(response.html);
                            $('#searchsuggestions').removeClass('hidden');
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                } else {
                    // Clear the search results if the input is empty
                    $('#searchsuggestions').html('');
                    $('#searchsuggestions').addClass('hidden');
                }
            });

            $(document).on('change','#ProfilePic',function(){
                $('#FormProfilePic').submit();
            });
        });
    </script>

@endsection
