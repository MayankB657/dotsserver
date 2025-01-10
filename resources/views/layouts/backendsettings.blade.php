<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title')</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset($constants['IMAGEFILEPATH'] . 'logo.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'] . 'semantic.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'] . 'root.css') }}">
    <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'] . 'cs.css') }}">
    <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'] . 'as.css') }}">
    <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'] . 'nx.css') }}">
    <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'] . 'custom.css') }}">
    <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'] . 'custom-reusable-style.css') }}">
    
    @yield('styles')
</head>

<body class="h-screen w-full">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <main class="flex w-full h-full cs plugin fm role">
        <!-- Sidebar -->
        <aside class="h-full relative">
        <input type="checkbox" class="hidden" id="sidebar-toggle" />
        <label
          for="sidebar-toggle"
          class="absolute lg:hidden top-6 -right-8 px-1"
        >
          <i class="ri-bar-chart-horizontal-line"></i>
        </label>
            <div class="h-full sidebar">
                <div class="sidebar-container">
                    <div class="p-6">
                        
                            <img class="w-20" src="{{ asset($constants['IMAGEFILEPATH'] . 'logo.png') }}" alt="Dots Logo" />
                        
                    </div>

                    <div class="sidebar-content">
                        <ul class="space-y-1">
                            @foreach($menus->where('parent', 0) as $menu)
                            @if(canShowMenu($menu))
                                <li>
                                    @if ($menu->hassubmenu == 1)
                                        <div role="button" onclick="toggleDropMenu(this)" class="drop-menu cursor-pointer rounded-r-lg">
                                            <div class="w-full px-6 py-3 flex justify-between items-center">
                                                <span class="font-normal">{{ $menu->name }}</span>
                                                <i class="ri-arrow-right-s-line text-c-yellow transition-all text-2xl big-right-arrow"></i>
                                            </div>
                                            <ul class="drop-list text-sm space-y-1">
                                                @foreach ($menus->where('parent', $menu->id) as $submenu)
                                                @if(canShowMenu($submenu))
                                                    <li>
                                                        @if ($submenu->hassubmenu == 1)
                                                            <div role="button" onclick="event.stopPropagation();toggleSubDropMenu('subdrop-menu{{$submenu->id}}')" class="subdrop cursor-pointer rounded-r-md">
                                                                <div class="w-full px-8 py-2 flex justify-between items-center">
                                                                    <span class="font-normal">{{ $submenu->name }}</span>
                                                                    <i class="ri-arrow-right-s-line text-c-yellow transition-all text-xl subdrop-right-arrow"></i>
                                                                </div>
                                                                <ul class="drop-list text-sm space-y-1 subdropmenulist hidden" id="subdrop-menu{{$submenu->id}}" style="background-color:#bcbcbc !important;">
                                                                    @foreach ($menus->where('parent', $submenu->id) as $subsubmenu)
                                                                    @if(canShowMenu($subsubmenu))

                                                                        <li>
                                                                            <a href="{{ route($subsubmenu->route) }}" path="{{ parse_url(route($subsubmenu->route), PHP_URL_PATH)}}" class="block py-2 px-10 rounded-r-md w-full flex justify-between items-center">
                                                                                <span class="font-normal">{{ $subsubmenu->name }}</span>
                                                                            </a>
                                                                        </li>
                                                                        @endif
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        @else
                                                            <a href="{{ route($submenu->route) }}" path="{{ parse_url(route($submenu->route), PHP_URL_PATH)}}" class="block py-2 px-8 rounded-r-md w-full flex justify-between items-center">
                                                                <span class="font-normal">{{ $submenu->name }}</span>
                                                                <i class="ri-arrow-right-s-line text-c-yellow right-arrow text-2xl"></i>
                                                            </a>
                                                        @endif
                                                    </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    @else
                                        <a href="{{ route($menu->route) }}" path="{{ parse_url(route($menu->route), PHP_URL_PATH)}}" class="w-full px-6 py-3 rounded-r-lg block flex justify-between items-center">
                                            <span class="font-normal">{{ $menu->name }}</span>
                                            <i class="ri-arrow-right-s-line text-c-yellow right-arrow text-2xl big-right-arrow"></i>
                                        </a>
                                    @endif
                                </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        @yield('content')
        <!-- Main Content end -->
    </main>
@include('layouts.script')
    <script src="{{ asset($constants['JSFILEPATH'] . 'sidebar.js') }}"></script>
    <script src="{{ asset($constants['JSFILEPATH'] . 'select-dropdown.js') }}"></script>
    <script src="{{ asset($constants['JSFILEPATH'] . 'custom-dropdown.js') }}"></script>
    <script src="{{ asset($constants['JSFILEPATH'] . 'tabs.js') }}"></script>
    <script src="{{ asset($constants['JSFILEPATH'] . 'taskbar.js') }}"></script>
    <script src="{{ asset($constants['JSFILEPATH'] . 'formValidation.js') }}"></script>
    <script>
    window.addEventListener('storage', function (event) {
                if (event.key === 'user_theme') {
                   applySavedTheme();
                }
        });
    </script>
    @yield('scripts')
</body>
</html>
