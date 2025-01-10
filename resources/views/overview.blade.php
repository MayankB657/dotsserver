@extends('layouts.backendsettings')
@section('title', 'Overview')
@section('content')

<head>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Overview</title>
    <style>
        @media print {
                @page {
                    size: A1;
                    margin: 0; /* Optional: Adjust the margin as needed */
                }
                #Sidebar {
                    display: none !important;
                }
           #printButton {
                    display: none !important;
                }
            #my_export {
                    display: none !important;
                }
    </style>
</head>



   

    <!-- main content -->
    <div class="flex-grow border h-100 main">
        <div class="flex w-full h-full flex-col content">
            <div class="p-4">
                <div class="flex items-center gap-4">
                    <i class="ri-settings-3-fill text-2xl"></i> <span class="text-lg">System Settings</span>
                </div>
            </div>

            <!-- top taskbar -->
            <div class="taskbar flex items-center justify-between px-4 py-4">
                <div class="flex items-center gap-4 w-full md:w-1/2">
                    <div class="flex gap-2 font-semibold items-center">
                        Overview
                    </div>
                </div>
                <div class="flex-grow md:w-1/2">
                    <div class="flex items-center justify-end gap-2 md:gap-6">

                        <!-- <i class="ri-download-line border px-3 hover-bg-c-black hover-text-c-yellow text-sm text-black py-1 rounded border-gray-600">&nbsp;<a href="{{ url('export-overview') }}" class="btn btn-success" target="_blank">Export</a></i> -->
                        <!-- Example button for printing -->
                       <button id="printButton" 
              type="button"
              class="border px-3 hover-bg-c-black hover-text-c-yellow text-sm text-black py-1 rounded border-c-light-gray export"
            >
              <i class="ri-printer-line"></i>&nbsp;Print</button>
                        <script>
                            document.getElementById('printButton').addEventListener('click', function() {
                                window.print();
                            });
                        </script>

                      

                        <button id="printButton1" class="ri-download-2-line border px-3 hover-bg-c-black hover-text-c-yellow text-sm text-black py-1 rounded border-c-light-gray " >  <a href="{{ url('export-overview') }}" class="btn btn-success" id="my_export" target="_blank" style="
  font-family: Roboto, sans-serif;">Export</a></button>
                    </div>

                </div>

            </div>

            <!-- overview content -->
            <div class="p-4 space-y-2">
                <!-- info cards -->
                <div class="flex gap-2 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-2">
                    <div class="bg-white border p-4 flex flex-col h-full rounded-md">
                        <div class="border-b pb-1 flex">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13.3333 8.33333C13.3333 9.21739 12.9821 10.0652 12.357 10.6904C11.7319 11.3155 10.884 11.6667 9.99996 11.6667C9.1159 11.6667 8.26806 11.3155 7.64294 10.6904C7.01782 10.0652 6.66663 9.21739 6.66663 8.33333C6.66663 7.44928 7.01782 6.60143 7.64294 5.97631C8.26806 5.35119 9.1159 5 9.99996 5C10.884 5 11.7319 5.35119 12.357 5.97631C12.9821 6.60143 13.3333 7.44928 13.3333 8.33333Z"
                                fill="#060709" />
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.65996 18.3265C5.21538 18.1482 1.66663 14.4882 1.66663 9.99984C1.66663 5.39734 5.39746 1.6665 9.99996 1.6665C14.6025 1.6665 18.3333 5.39734 18.3333 9.99984C18.3333 14.6023 14.6025 18.3332 9.99996 18.3332H9.88579C9.81024 18.3332 9.73496 18.3309 9.65996 18.3265ZM4.65246 15.2582C4.59015 15.0792 4.56894 14.8886 4.59041 14.7003C4.61187 14.5121 4.67546 14.3311 4.77645 14.1708C4.87744 14.0105 5.01324 13.875 5.17376 13.7743C5.33429 13.6737 5.51542 13.6105 5.70371 13.5894C8.95204 13.2298 11.0679 13.2623 14.3004 13.5969C14.4889 13.6166 14.6705 13.679 14.8313 13.7794C14.9921 13.8798 15.1278 14.0156 15.2282 14.1764C15.3286 14.3372 15.3909 14.5188 15.4105 14.7073C15.4301 14.8959 15.4064 15.0864 15.3412 15.2644C16.7267 13.8628 17.5025 11.9707 17.5 9.99984C17.5 5.85775 14.142 2.49984 9.99996 2.49984C5.85788 2.49984 2.49996 5.85775 2.49996 9.99984C2.49996 12.0482 3.32121 13.9048 4.65246 15.2582Z"
                                fill="#060709" />
                            </svg>
                            &nbsp;<span class="font-semibold">User</span>
                        </div>
                        <div class="text-center pt-2 space-y-4">
                            <span class="block text-sm mt-3">Total no. of users</span>
                            <span class="block text-3xl font-bold text-c-yellow">{{ $totalUsers }}</span>
                        </div>
                        <div class="mt-auto space-y-1 pt-1">
                            <div class="flex items-center gap-2 text-xs">
                                <span class="block w-2 h-2 rounded-full bg-c-green"></span>
                                <span>Online: {{ $countOnline }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs">
                                <span class="block w-2 h-2 rounded-full bg-red-400"></span>
                                <span>Offline: {{ $countOffline }}</span>
                            </div>
                        </div>
                    </div>

                 <!--  123  <div class="bg-white border p-4 flex flex-col h-full rounded-md">
                        <div class="border-b pb-1">
                            <i class="ri-folder-4-line"></i>&nbsp;<span class="font-semibold">File</span>
                        </div>
                        <div class="text-center pt-2 space-y-4">
                            <span class="block text-sm mt-3">Space Used</span>
                            <span class="block text-3xl font-bold text-c-yellow">{{ $file->size ?? '0'}} GB</span>
                        </div>
                        <div class="text-xs py-1 mt-auto mb-1">
                            <div>
                                <span>Actual: 3.8GB</span>
                            </div>
                            <div>
                                <span>Saved: 0B</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 border-t pt-1">
                            <div class="flex items-center gap-2 text-xs">
                                <span>Count: 192</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs">
                                <span>Today: 0B</span>
                            </div>
                        </div>
                    </div> -->

                    <div class="bg-white border p-4 flex flex-col h-full rounded-md">
                        <div class="border-b flex pb-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.9999 11.9998V12.0098M14.8279 9.17177C15.5778 9.92188 15.9991 10.9391 15.9991 11.9998C15.9991 13.0604 15.5778 14.0777 14.8279 14.8278M17.6569 6.34277C18.3999 7.08565 18.9892 7.96758 19.3912 8.93821C19.7933 9.90884 20.0002 10.9492 20.0002 11.9998C20.0002 13.0504 19.7933 14.0907 19.3912 15.0613C18.9892 16.032 18.3999 16.9139 17.6569 17.6568M9.16794 14.8278C8.41806 14.0777 7.9968 13.0604 7.9968 11.9998C7.9968 10.9391 8.41806 9.92188 9.16794 9.17177M6.33694 17.6568C5.59403 16.9139 5.00472 16.032 4.60266 15.0613C4.20059 14.0907 3.99365 13.0504 3.99365 11.9998C3.99365 10.9492 4.20059 9.90884 4.60266 8.93821C5.00472 7.96758 5.59403 7.08565 6.33694 6.34277"
                                stroke="#111111" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            &nbsp;<span class="font-semibold">Access Today</span>
                        </div>
                        <div class="text-xs pt-2 space-y-4">
                            <div class="flex gap-2 items-center">
                                <span class="w-1/3">Upload</span>
                                <div class="w-full bg-gray-200 rounded-full h-1.5 dark:bg-gray-700">
                                    <div class="bg-c-yellow h-1.5 rounded-full" style="width: {{ $activityUpload }}%"></div>
                                </div>
                            </div>
                            <div class="flex gap-2 items-center">
                                <span class="w-1/3">Create</span>
                                <div class="w-full bg-gray-200 rounded-full h-1.5 dark:bg-gray-700">
                                    <div class="bg-c-yellow h-1.5 rounded-full" style="width: {{ $activityCreate }}%"></div>
                                </div>
                            </div>
                            <div class="flex gap-2 items-center">
                                <span class="w-1/3">Edit</span>
                                <div class="w-full bg-gray-200 rounded-full h-1.5 dark:bg-gray-700">
                                    <div class="bg-c-yellow h-1.5 rounded-full" style="width: {{$activityEdit}}%"></div>
                                </div>
                            </div>
                            <div class="flex gap-2 items-center">
                                <span class="w-1/3">Delete</span>
                                <div class="w-full bg-gray-200 rounded-full h-1.5 dark:bg-gray-700">
                                    <div class="bg-c-yellow h-1.5 rounded-full" style="width: {{$activityDelete}}%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-auto text-xs space-y-1 border-t pt-1">
                            <div class="flex justify-between items-end">
                                <div>
                                    <div>
                                        <span>Request: 00</span>
                                    </div>
                                    <div>
                                        <span>Users: {{ $totalUsers }}</span>
                                    </div>
                                </div>
                             <!--    <div class="relative placeholder-gray-400 flex items-end">
                                    <button type="button" class="has-tooltip">
                                        <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M13.125 4.6875H1.875C1.62636 4.6875 1.3879 4.78627 1.21209 4.96209C1.03627 5.1379 0.9375 5.37636 0.9375 5.625V9.375C0.9375 9.62364 1.03627 9.8621 1.21209 10.0379C1.3879 10.2137 1.62636 10.3125 1.875 10.3125H13.125C13.3736 10.3125 13.6121 10.2137 13.7879 10.0379C13.9637 9.8621 14.0625 9.62364 14.0625 9.375V5.625C14.0625 5.37636 13.9637 5.1379 13.7879 4.96209C13.6121 4.78627 13.3736 4.6875 13.125 4.6875ZM3.51562 8.20312C3.37656 8.20312 3.24062 8.16189 3.12499 8.08463C3.00936 8.00737 2.91924 7.89755 2.86602 7.76907C2.8128 7.64059 2.79888 7.49922 2.82601 7.36283C2.85314 7.22643 2.92011 7.10115 3.01844 7.00282C3.11677 6.90448 3.24206 6.83752 3.37845 6.81039C3.51485 6.78326 3.65622 6.79718 3.7847 6.8504C3.91318 6.90361 4.02299 6.99374 4.10025 7.10936C4.17751 7.22499 4.21875 7.36093 4.21875 7.5C4.21875 7.68648 4.14467 7.86532 4.01281 7.99718C3.88095 8.12905 3.70211 8.20312 3.51562 8.20312ZM7.5 8.20312C7.36094 8.20312 7.22499 8.16189 7.10936 8.08463C6.99374 8.00737 6.90361 7.89755 6.8504 7.76907C6.79718 7.64059 6.78326 7.49922 6.81039 7.36283C6.83752 7.22643 6.90448 7.10115 7.00282 7.00282C7.10115 6.90448 7.22643 6.83752 7.36283 6.81039C7.49922 6.78326 7.64059 6.79718 7.76907 6.8504C7.89755 6.90361 8.00737 6.99374 8.08463 7.10936C8.16189 7.22499 8.20312 7.36093 8.20312 7.5C8.20312 7.68648 8.12905 7.86532 7.99718 7.99718C7.86532 8.12905 7.68648 8.20312 7.5 8.20312ZM11.4844 8.20312C11.3453 8.20312 11.2094 8.16189 11.0937 8.08463C10.9781 8.00737 10.888 7.89755 10.8348 7.76907C10.7816 7.64059 10.7676 7.49922 10.7948 7.36283C10.8219 7.22643 10.8889 7.10115 10.9872 7.00282C11.0855 6.90448 11.2108 6.83752 11.3472 6.81039C11.4836 6.78326 11.625 6.79718 11.7534 6.8504C11.8819 6.90361 11.9917 6.99374 12.069 7.10936C12.1463 7.22499 12.1875 7.36093 12.1875 7.5C12.1875 7.68648 12.1134 7.86532 11.9816 7.99718C11.8497 8.12905 11.6709 8.20312 11.4844 8.20312Z"
                                            fill="#282828" />
                                        </svg>
                                    </button>
                                    <div class="absolute text-xs tooltip -bottom-8 -left-8 px-2 py-1 text-center z-10 min-w-full bg-white border rounded-md">
                                        Details
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>



                   <!--123  <div class="bg-white border p-4 flex flex-col h-full rounded-md">
                        <div class="border-b pb-1">
                            <i class="ri-macbook-line"></i>&nbsp;<span class="font-semibold">System</span>
                        </div>
                        <div class="pt-2 space-y-1">
                            <span class="block text-sm">System Score</span>
                            <div class="w-full bg-gray-200 rounded-full h-1.5 dark:bg-gray-700 relative">
                                <span class="absolute right-0 -top-4 text-xs text-c-green">90%</span>
                                <div class="bg-c-green h-1.5 rounded-full" style="width: 90%"></div>
                            </div>
                        </div> -->
                        <!-- <div class="text-xs py-2 space-y-1">
                            <div class="flex gap-2 items-center">
                                <span class="w-1/3">Disk</span>
                                <div class="w-full bg-gray-200 rounded-full h-1.5 dark:bg-gray-700">
                                    <div class="bg-c-yellow h-1.5 rounded-full" style="width: 45%"></div>
                                </div>
                            </div>
                            <div class="flex gap-2 items-center">
                                <span class="w-1/3">Storage</span>
                                <div class="w-full bg-gray-200 rounded-full h-1.5 dark:bg-gray-700">
                                    <div class="bg-c-yellow h-1.5 rounded-full" style="width: 25%"></div>
                                </div>
                            </div>
                            <div class="flex gap-2 items-center">
                                <span class="w-1/3">Lite Speed</span>
                                <span class="w-2/3 text-c-green">Normal</span>
                            </div>
                            <div class="flex gap-2 items-center">
                                <span class="w-1/3">PHP</span>
                                <span class="w-2/3 text-c-green">Normal</span>
                            </div>
                            <div class="flex gap-2 items-center">
                                <span class="w-1/3">MySQL</span>
                                <span class="w-2/3 text-c-green">Normal</span>
                            </div>
                        </div>
                        <div class="mt-auto flex gap-2 text-xs pt-1 border-t">
                            <span class="text-gray-400">Name: </span>
                            <span><a href="desktop.dots.in">desktop.dots.in</a></span>
                            <div class="relative aspect-square ml-auto w-4 h-4">
                                <button type="button" class="has-tooltip rounded-md openTaskManagerModalButton">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.54333 0C3.33836 0 2.18275 0.485951 1.33071 1.35095C0.478671 2.21595 0 3.38914 0 4.61243V16.9122C0 18.1355 0.478671 19.3087 1.33071 20.1737C2.18275 21.0387 3.33836 21.5247 4.54333 21.5247H9.99683C9.19687 19.9332 8.91397 18.1255 9.18873 16.3607C9.46349 14.596 10.2818 12.9649 11.5262 11.7015C12.7707 10.4382 14.3773 9.60742 16.1156 9.32848C17.8539 9.04954 19.6346 9.33674 21.2022 10.1489V4.61243C21.2022 3.38914 20.7235 2.21595 19.8715 1.35095C19.0194 0.485951 17.8638 0 16.6589 0H4.54333ZM9.62277 5.22127C9.69329 5.29268 9.74923 5.37751 9.78741 5.4709C9.82558 5.5643 9.84523 5.66442 9.84523 5.76553C9.84523 5.86665 9.82558 5.96677 9.78741 6.06017C9.74923 6.15356 9.69329 6.23839 9.62277 6.3098L6.97249 9.00038C6.83454 9.14027 6.64875 9.22074 6.45381 9.22504C6.25887 9.22933 6.06982 9.15712 5.92601 9.02345L4.79018 7.97028C4.713 7.9033 4.64987 7.82125 4.60456 7.72901C4.55924 7.63677 4.53266 7.53622 4.52639 7.43333C4.52013 7.33045 4.53431 7.22734 4.5681 7.13014C4.60188 7.03293 4.65457 6.94361 4.72304 6.8675C4.79151 6.79139 4.87436 6.73003 4.96666 6.68708C5.05896 6.64413 5.15883 6.62047 5.26032 6.61749C5.36182 6.61452 5.46286 6.6323 5.55745 6.66977C5.65204 6.70724 5.73823 6.76364 5.81092 6.83562L6.41215 7.39218L8.55054 5.22127C8.62088 5.14968 8.70444 5.09288 8.79644 5.05412C8.88843 5.01537 8.98705 4.99542 9.08666 4.99542C9.18626 4.99542 9.28488 5.01537 9.37687 5.05412C9.46887 5.09288 9.55243 5.14968 9.62277 5.22127ZM8.55054 12.9086C8.69273 12.7643 8.88557 12.6832 9.08666 12.6832C9.28774 12.6832 9.48058 12.7643 9.62277 12.9086C9.76495 13.053 9.84483 13.2488 9.84483 13.4529C9.84483 13.6571 9.76495 13.8528 9.62277 13.9972L6.97249 16.6878C6.83454 16.8277 6.64875 16.9081 6.45381 16.9124C6.25887 16.9167 6.06982 16.8445 5.92601 16.7108L4.79018 15.6577C4.64951 15.5183 4.56769 15.329 4.56202 15.1295C4.55635 14.9301 4.62727 14.7363 4.75979 14.589C4.89232 14.4416 5.07607 14.3524 5.27221 14.3401C5.46836 14.3278 5.66153 14.3934 5.81092 14.523L6.41215 15.0811L8.55054 12.9086ZM12.1155 7.68738C11.9147 7.68738 11.7221 7.60639 11.5801 7.46222C11.4381 7.31806 11.3583 7.12252 11.3583 6.91864C11.3583 6.71476 11.4381 6.51923 11.5801 6.37506C11.7221 6.2309 11.9147 6.1499 12.1155 6.1499H15.9016C16.1025 6.1499 16.2951 6.2309 16.4371 6.37506C16.5791 6.51923 16.6589 6.71476 16.6589 6.91864C16.6589 7.12252 16.5791 7.31806 16.4371 7.46222C16.2951 7.60639 16.1025 7.68738 15.9016 7.68738H12.1155ZM11.5613 16.7892C11.9523 16.6877 12.3195 16.5078 12.6411 16.2601C12.9627 16.0125 13.2323 15.7021 13.4341 15.3471C13.6358 14.9922 13.7657 14.5999 13.816 14.1933C13.8663 13.7867 13.836 13.3739 13.7269 12.9794L13.4907 12.123C13.8773 11.8196 14.2923 11.5634 14.7355 11.3543L15.2459 11.9047C15.529 12.2095 15.8706 12.4523 16.2495 12.6183C16.6284 12.7843 17.0367 12.8699 17.4494 12.8699C17.8621 12.8699 18.2704 12.7843 18.6493 12.6183C19.0283 12.4523 19.3698 12.2095 19.6529 11.9047L20.1406 11.3773C20.5929 11.5926 21.0144 11.858 21.4051 12.1737L21.2143 12.8225C21.0962 13.2239 21.06 13.6455 21.1081 14.0615C21.1562 14.4775 21.2876 14.8792 21.494 15.2418C21.7005 15.6045 21.9778 15.9205 22.3089 16.1704C22.6399 16.4204 23.0178 16.5991 23.4193 16.6955L23.9494 16.8215C24.0114 17.3406 24.0164 17.865 23.9645 18.3851L23.2679 18.5666C22.8765 18.6678 22.5091 18.8474 22.1871 19.0949C21.8652 19.3424 21.5952 19.6528 21.3932 20.0078C21.1911 20.3628 21.061 20.7552 21.0105 21.162C20.96 21.5687 20.9902 21.9817 21.0992 22.3764L21.3355 23.2313C20.9488 23.5347 20.5338 23.7909 20.0906 24L19.5802 23.4496C19.2971 23.145 18.9557 22.9024 18.5769 22.7366C18.1981 22.5707 17.79 22.4852 17.3775 22.4852C16.965 22.4852 16.5568 22.5707 16.178 22.7366C15.7993 22.9024 15.4578 23.145 15.1747 23.4496L14.6901 23.9846C14.2401 23.768 13.8154 23.5009 13.424 23.1882L13.6148 22.5379C13.7332 22.1364 13.7695 21.7147 13.7216 21.2985C13.6736 20.8823 13.5423 20.4804 13.3358 20.1176C13.1293 19.7548 12.852 19.4386 12.5208 19.1886C12.1896 18.9385 11.8115 18.7598 11.4098 18.6634L10.8813 18.5373C10.8194 18.0188 10.8143 17.4949 10.8661 16.9753L11.5613 16.7892ZM18.929 17.681C18.929 17.2732 18.7695 16.8821 18.4854 16.5938C18.2014 16.3055 17.8162 16.1435 17.4146 16.1435C17.0129 16.1435 16.6277 16.3055 16.3437 16.5938C16.0597 16.8821 15.9001 17.2732 15.9001 17.681C15.9001 18.0887 16.0597 18.4798 16.3437 18.7681C16.6277 19.0565 17.0129 19.2184 17.4146 19.2184C17.8162 19.2184 18.2014 19.0565 18.4854 18.7681C18.7695 18.4798 18.929 18.0887 18.929 17.681Z"
                                        fill="#282828" />
                                    </svg>
                                </button>
                                <div class="absolute w-24 p-1 text-center text-xs tooltip -bottom-8 right-0 z-10 min-w-full bg-white border rounded-md">
                                    Task Manager
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-2">
                    <div class="col-span-1 md:col-span-1 border bg-white rounded-md">
                        <div class="p-1">
                            <div class="text-sm p-1 text-c-black"> Space Usage <!-- <span class="text-gray-400">(10.1MB/Unlimited)</span> -->
                            </div>
                            <canvas id="space-ratio-donut"></canvas>
                        </div>
                    </div>
                    <div class="col-span-1 md:col-span-3 p-2 border bg-white rounded-md relative">
                        <div class="text-sm p-1 text-c-black"> Document log <span class="text-gray-400"><!-- (14 Records) --></span>
                        </div>
                        <div class="h-72 overflow-y-auto">
                            @foreach($activity as $logs) @if(($logs['action'] != 'Log In') && ($logs['action'] != 'Log Out'))
                            <div class="flex items-center space-x-3 mt-3 text-c-black">
                                <div class="relative flex items-center">
                                    <div class="absolute top-1/2 left-6 transform -translate-y-1/2 h-0.5 bg-c-light-white w-1/2"></div>
                                    <div class="absolute left-3 top-6 transform -translate-x-1/2 w-0.5 bg-c-light-white h-20 sm:h-14"></div>
                                    <!-- add if else conditions to show icon start -->
                                    @if($logs['action'] == 'Share')
                                    <div class="has-tooltip relative z-10 w-6 h-6 bg-c-yellow rounded-full flex items-center justify-center">
                                        <i class="ri-share-forward-fill text-c-black"></i>
                                    </div>
                                    <div class="absolute w-24 p-1 text-center text-xs tooltip -bottom-8 left-0 z-10 min-w-full bg-white border rounded-md"> Edit sharing1 </div>
                                    @elseif($logs['action'] == 'New Folder')
                                    <div class="has-tooltip relative z-10 w-6 h-6 bg-c-yellow rounded-full flex items-center justify-center">
                                        <i class="ri-add-fill text-c-black"></i>
                                    </div>
                                    <div class="absolute w-24 p-1 text-center text-xs tooltip -bottom-8 left-0 z-10 min-w-full bg-white border rounded-md"> Edit sharing2 </div>
                                    @elseif($logs['action'] == 'Edit')
                                    <div class="has-tooltip relative z-10 w-6 h-6 bg-c-yellow rounded-full flex items-center justify-center">
                                        <i class="ri-add-fill text-c-black"></i>
                                    </div>
                                    <div class="absolute w-24 p-1 text-center text-xs tooltip -bottom-8 left-0 z-10 min-w-full bg-white border rounded-md"> Edit sharing2.1 </div>
                                    @elseif($logs['action'] == 'Upload')
                                    <div class="has-tooltip relative z-10 w-6 h-6 bg-c-yellow rounded-full flex items-center justify-center">
                                        <i class="ri-upload-2-fill text-c-black"></i>
                                    </div>
                                    <div class="absolute w-24 p-1 text-center text-xs tooltip -bottom-8 left-0 z-10 min-w-full bg-white border rounded-md"> Edit sharing3 </div>
                                    @elseif($logs['action'] == 'Download')
                                    <div class="has-tooltip relative z-10 w-6 h-6 bg-c-yellow rounded-full flex items-center justify-center">
                                        <i class="ri-download-2-fill text-c-black"></i>
                                    </div>
                                    <div class="absolute w-24 p-1 text-center text-xs tooltip -bottom-8 left-0 z-10 min-w-full bg-white border rounded-md"> Edit sharing4 </div>
                                    @endif
                                    <!-- add if else conditions to show icon ends -->
                                </div>
                                <div class="border bg-blue-50 p-2 shadow rounded pb-5 w-full">
                                    <div class="flex flex-col md:flex-row justify-between bg-gray-200 rounded px-2 py-1 text-sm relative">

                                        <div> {{ $logs['action'] }}
                                            <a href="#" class="text-link-blue has-tooltip">New folder(3)</a>
                                            <div class="absolute py-1 px-2 text-start text-xs tooltip -bottom-8 left-14 z-10 bg-white border rounded-md">
                                                {{ $logs['path'] }}
                                            </div>

                                            <a href="#" class="text-link-blue has-tooltip1">New file.docx</a>
                                            <!-- <div class="absolute py-1 px-2 text-start text-xs tooltip1 -bottom-8 left-44 z-10 bg-white border rounded-md">
                                                /Personal/New Folder(0)/File.docx
                                            </div> -->


                                        </div>
                                        <div class="flex relative text-sm gap-2 ml-auto">
                                            <span><i class="ri-calendar-2-line"></i>&nbsp; {{ \Carbon\Carbon::parse($logs['created_at'])->format('d-m-y') }}</span>
                                            <span><i class="ri-time-line"></i>&nbsp;{{ \Carbon\Carbon::parse($logs['created_at'])->format('H:i') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- for loop ends  -->

                            @endif @endforeach
                        </div>
                    </div>
                </div>
                <!-- table and donut chart -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-2">
                    <div class="col-span-1 md:col-span-3 p-2 border bg-white rounded-md relative">
                        <div class="flex gap-4">
                            <button type="button" onclick="showTab(this)" class="tab-control styled text-sm px-1 pb-1 active" data-tab="donut-space" data-control="user-space-tab">User Space</button>
                            <button type="button" onclick="showTab(this)" class="tab-control styled text-sm px-1 pb-1" data-tab="donut-space" data-control="group-space-tab">Group Space</button>
                        </div>
                        <div class="pt-4">
                            <div class="tab-content donut-space active" id="user-space-tab">
                                <div class="bg-white nx-table-container">
                                    <table class="table-auto w-full">
                                        <thead>
                                            <tr class="bg-c-dark-gray">
                                                <th class="py-2 rounded-tl-md text-white text-left pl-3">ID</th>
                                                <th class="py-2 text-white text-left pl-3">Name</th>
                                                <th class="py-2 text-white text-left pl-3">Used</th>
                                                <th class="py-2 text-white text-left pl-3">Limited Size</th>
                                                <th class="py-2 rounded-tr-md text-white text-left pr-3">Creation</th>
                                            </tr>
                                        </thead>
                                        <tbody class="border" id="chart-entries">
                                            @foreach($Users as $user)
                                            <tr class="text-sm border-t">
                                                <td class="py-2 pl-3">
                                                    <input type="checkbox" class="c-checkbox" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}">
                                                </td>
                                                <td class="py-2 pl-3">{{ $user->name }}</td>
                                                <td class="py-2 pl-3">{{ $user->sizeUse }} MB</td>
                                                <td class="py-2 pl-3">{{ $user->sizeMax }} GB</td>
                                                <td class="py-2 pr-3">
                                                    <div class="flex relative text-sm gap-2 ml-auto">
                                                        <span><i class="ri-calendar-2-line"></i>&nbsp; {{ \Carbon\Carbon::parse($user->created_at)->format('d-m-y') }}</span>
                                                        <span><i class="ri-time-line"></i>&nbsp;{{ \Carbon\Carbon::parse($user->created_at)->format('H:i') }}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                    
 <div class="p-5">
                                 
 <!-- Pagination Links -->
                                    {{ $Users->links() }}
                            </div>
                                </div>
                            </div>
                            <div class="tab-content donut-space" id="group-space-tab">
                                <div class="bg-white nx-table-container">
                                    <table class="table-auto w-full">
                                        <thead>
                                            <tr class="bg-c-dark-gray">
                                                <th class="py-2 rounded-tl-md text-white text-left pl-3">ID</th>
                                                <th class="py-2 text-white text-left pl-3">Name</th>
                                                <th class="py-2 text-white text-left pl-3">Used</th>
                                                <th class="py-2 text-white text-left pl-3">Limited Size</th>
                                                <th class="py-2 rounded-tr-md text-white text-left pr-3">Creation</th>
                                            </tr>
                                        </thead>
                                        <tbody class="border">
                                            @foreach($UsersGroup as $UserGroup)
                                            <tr class="text-sm border-t">
                                                <td class="py-2 pl-3">
                                                    <input type="checkbox" class="c-checkbox g-usage" data-user-id="{{ $UserGroup->id }}" data-user-group-name="{{ $UserGroup->name }}">
                                                </td>
                                                <td class="py-2 pl-3">{{ $UserGroup->name }}</td>
                                                <td class="py-2 pl-3">{{ $UserGroup->sizeUse }}</td>
                                                <td class="py-2 pl-3">{{ $UserGroup->sizeMax }}</td>
                                                <td class="py-2 pr-3">
                                                    <div class="flex relative text-sm gap-2 ml-auto">
                                                        <span><i class="ri-calendar-2-line"></i>&nbsp;{{ \Carbon\Carbon::parse($UserGroup->created_at)->format('d-m-y') }}</span>
                                                        <span><i class="ri-time-line"></i>&nbsp;{{ \Carbon\Carbon::parse($UserGroup->created_at)->format('H:i') }}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-span-1 md:col-span-1 border bg-white rounded-md">
                        <div class="p-1">
                            <div class="text-sm p-1">File Usage Ratio <span class="text-gray-400">[<span id="chart_title">All</span>]</span>
                            </div>
                            <canvas id="usage-ratio-donut"></canvas>
                            <div class="border-t p-1 mt-1 flex text-xs">
                                <div class="text-center w-full">
                                    <!-- Total: 1.4 MB -->
                                </div>
                                <div class="text-center w-full">
                                    <!-- Files: 442 -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- data and space usage -->
                <div class="bg-white rounded border p-2 rounded-md">
                    <div class="flex flex-wrap gap-2 justify-between">
                        <div class="flex gap-4">
                            <button type="button" onclick="showTab(this)" class="tab-control styled text-sm px-1 active" data-tab="user-data-space" data-control="user-data-tab">User Data</button>
                            <button type="button" onclick="showTab(this)" class="tab-control styled text-sm px-1" data-tab="user-data-space" data-control="space-usage-tab">Space Usage</button>
                        </div>
                        <div class="">
                            <form id="graph-timeframe-form" class="flex gap-2">
                                <label for="day" class="cursor-pointer radio-button">
                                    <input type="radio" name="graph-timeframe" id="day" value="day">
                                    <span class="block py-1 px-2 text-sm rounded-md text-center bg-gray-200">Day</span>
                                </label>
                                <label for="week" class="cursor-pointer radio-button">
                                    <input type="radio" name="graph-timeframe" id="week" value="week">
                                    <span class="block py-1 px-2 text-sm rounded-md text-center bg-gray-200">Week</span>
                                </label>
                                <label for="month" class="cursor-pointer radio-button">
                                    <input type="radio" name="graph-timeframe" id="month" value="month" checked>
                                    <span class="block py-1 px-2 text-sm rounded-md text-center bg-gray-200">Month</span>
                                </label>
                                <label for="year" class="cursor-pointer radio-button">
                                    <input type="radio" name="graph-timeframe" id="year" value="year">
                                    <span class="block py-1 px-2 text-sm rounded-md text-center bg-gray-200">Year</span>
                                </label>
                            </form>

                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="tab-content user-data-space active" id="user-data-tab">
                            <canvas id="user-data-chart" height="400"></canvas>
                        </div>
                        <div class="tab-content user-data-space" id="space-usage-tab">
                            <canvas id="space-usage-chart" height="400"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>



<!-- run task scheduled message -->
<div id="run-success" class="fixed z-10 w-full transition-all" style="top: -120px;">
    <div class="max-w-sm mx-auto">
        <div class="flex items-center border rounded-md bg-white">
            <div class="bg-c-yellow py-2 px-3">
                <i class="fa-solid fa-check fa-lg text-black"></i>
            </div>
            <p id="run-success-message" class="px-3 text-center w-full text-gray-700 text-sm">The scheduled task has restarted
            </p>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script>
    // checkbox
const checkboxes = document.querySelectorAll('.c-checkbox');

checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        // Uncheck all checkboxes except the one that was just checked
        checkboxes.forEach(cb => {
            if (cb !== checkbox) {
                cb.checked = false;
            }
        });
    });
});

const checkboxes2 = document.querySelectorAll('.c-checkboxa');

checkboxes2.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        // Uncheck all checkboxes2 except the one that was just checked
        checkboxes2.forEach(cb => {
            if (cb !== checkbox) {
                cb.checked = false;
            }
        });
    });
});
//end checkbox

        $(document).ready(function() {
            $('.c-checkbox').change(function() {
                if (this.checked) {
                    var userId = $(this).data('user-id');
                    var userName = $(this).data('user-name');
                    console.log("User ID: " + userName);

                    // Perform your AJAX request here
                    $.ajax({
                        url: '{{ route("chartLogs.userId") }}', // Replace with your endpoint
                        type: 'GET',
                        data: { userId: userId },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // If using Laravel, include CSRF token
                        },
                        success: function(data) {
                               
                             var newData = data;
                            // console.log(newData);

                    // Update chart data
                      myChart.data.datasets[0].label = "Data Usage"; // Update dataset label if needed
                    myChart.data.labels = [
                   'Other Docs',
                    'Image'
                    
                ]; // Example labels
                    myChart.data.datasets[0].data = newData.chartData;

                    // Update the chart
                    myChart.update();

                        $('#chart_title').text(userName);                           
                        }
                    });
                } else {
                    $('#chart_title').text('All'); 
                }
            });
        });
//group usage
          $(document).ready(function() {
            $('.g-usage').change(function() {
                if (this.checked) {
                    var userId = $(this).data('user-id');
                    var userName = $(this).data('user-group-name');
                    // console.log("User ID: " + userId);

                    // Perform your AJAX request here
                    $.ajax({
                        url: '{{ route("groupUusage.userId") }}', // Replace with your endpoint
                        type: 'GET',
                        data: { userId: userId },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // If using Laravel, include CSRF token
                        },
                        success: function(data) {
                               
                             var newData = data;
                            // console.log(newData);

                    // Update chart data
                      myChart.data.datasets[0].label = "Data Usage"; // Update dataset label if needed
                    myChart.data.labels = [
                   'Other Docs',
                    'Image'
                    
                ]; // Example labels
                    myChart.data.datasets[0].data = newData.chartData;

                    // Update the chart
                    myChart.update();
                        $('#chart_title').text(userName); 
                        }
                    });
                } else {
                    $('#chart_title').text('All'); 
                }
            });
        });
</script>



<script defer>
    function showSuccessMessage(message) {
            runSuccessMessage.innerText = message;
            runSuccessModal.style.top = '20px';
            setTimeout(() => {
                runSuccessModal.style.top = '-120px';
            }, 3000);
        }
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script defer>
    const ctx = document.getElementById('usage-ratio-donut');


 var  myChart =   new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [
                    'Users',
                    'Group',
                    'Others'
                ],
                datasets: [{
                    label: 'Users',
                    data: [{{ $sizeMaxData }}, {{ $GroupSizePi }}, 20],
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)'
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                plugins: {
                    title: "File Usage Ratio",
                    // tooltip: {
                    //     callbacks: {
                    //         label: function(tooltipItem) {
                    //             let label = tooltipItem.label || '';
                    //             if (label) {
                    //                 label += ': ';
                    //             }
                    //             label += tooltipItem.dataset.data;
                    //             return label;
                    //         }

                    //     }
                    // }
                }
            }
        });

      //line c
      const graphDataUrl = '{{ route('Graph.Data') }}';
let chart; // Declare the chart variable
let spaceUsageChart; // Declare the spaceUsageChart variable

$(document).ready(function() {
    const timeframe = 'month';

    fetchData(timeframe);

    document.getElementById('graph-timeframe-form').addEventListener('change', (e) => {
        const timeframe = document.querySelector('input[name="graph-timeframe"]:checked').value;
        fetchData(timeframe);
    });
});

function fetchData(timeframe) {
    fetch(`${graphDataUrl}?timeframe=${timeframe}`)
        .then(response => response.json())
        .then(data => {
            initUserDataChart(data);
            initSpaceUsageChart(data);
        })
        .catch(error => {
            console.error('Error fetching the graph data:', error);
        });
}

function initUserDataChart(data) {
    const ctx2 = document.getElementById('user-data-chart').getContext('2d');
    if (chart) {
        chart.destroy();
    }
    chart = new Chart(ctx2, {
        type: 'line',
        data: {
            labels: data.labels,
            datasets: [
                {
                    label: 'Logins',
                    data: data.loginCounts,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'New Users',
                    data: data.newUsersData,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Total Users',
                    data: data.usersDataGraph,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true,
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    beginAtZero: true
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

function initSpaceUsageChart(data) {
    const ctx3 = document.getElementById('space-usage-chart').getContext('2d');
    if (spaceUsageChart) {
        spaceUsageChart.destroy();
    }
    spaceUsageChart = new Chart(ctx3, {
        type: 'line',
        data: {
            labels: data.labels,
            datasets: [
                {
                    label: 'Total',
                    data: data.maxSizes,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Actual',
                    data: data.actualdata,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'User',
                    data: data.totalSizeUsers,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Group',
                    data: data.totalSizeGroups,
                    borderColor: 'rgba(75, 145, 142, 1)',
                    backgroundColor: 'rgba(75, 145, 142, 0.2)',
                    fill: true,
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    beginAtZero: true
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

    //logs
      const space = document.getElementById("space-ratio-donut");

      new Chart(space, {
        type: "doughnut",
        data: {
          labels: ["Documents", "Image", "Music", "Video", "Archive", "Other"],
          datasets: [
            {
              label: "Usage",
              data: [12, {{$sizeMaxData}}, 0, 0, 0, 0],
              backgroundColor: [
                "rgb(255, 99, 132)", // Color for Documents
                "rgb(54, 162, 235)", // Color for Image
                "rgb(255, 205, 86)", // Color for Music
                "rgb(75, 192, 192)", // Color for Video
                "rgb(153, 102, 255)", // Color for Archive
                "rgb(255, 159, 64)", // Color for Other
              ],
              hoverOffset: 4,
            },
          ],
        },
        options: {
          plugins: {
            title: "Data usage ratio",
          },
        },
      });
</script>
<script>
    function showTab(eventTarget) {
    const tabClass = eventTarget.getAttribute('data-tab');
    const tabToShow = eventTarget.getAttribute('data-control');

    // select all the buttons with same data-tab attribute
    const tabButtons = document.querySelectorAll(`button.tab-control[data-tab="${tabClass}"]`);

    // select all div with `tabClass` class
    const tabDivs = document.querySelectorAll(`div.${tabClass}.tab-content`);

    // hide all divs
    tabDivs.forEach(div => {
        div.classList.remove('active');
    });

    // show selected div
    document.getElementById(tabToShow).classList.add('active');

    // remove active class from all buttons
    tabButtons.forEach(button => {
        button.classList.remove('active');
    });

    // add active class to selected button
    eventTarget.classList.add('active');

}

function toggleTab(eventTarget) {
    const tabTarget = eventTarget.getAttribute('data-target');

    if(eventTarget.checked){
        document.getElementById(tabTarget).classList.add('active');
    } else {
        document.getElementById(tabTarget).classList.remove('active');
    }
}

function singleSelectPut(eventTarget) {
    console.log("asdas");
    const target = eventTarget.getAttribute('data-put');

    document.getElementById(target).innerHTML = eventTarget.value;
}
function convertCanvasToImage(canvas) {
            var img = new Image();
            img.src = canvas.toDataURL("image/png");
            return img;
        }

        window.onbeforeprint = function() {

            var canvas = document.getElementById('usage-ratio-donut');
            var sidebar = document.getElementById('Sidebar');
            sidebar.addClass('hidden');
            var img = convertCanvasToImage(canvas);
            canvas.parentNode.insertBefore(img, canvas);
            canvas.style.display = 'none';
        };

        window.onafterprint = function() {
            var canvas = document.getElementById('usage-ratio-donut');
            var sidebar = document.getElementById('Sidebar');
            sidebar.removeClass('hidden');
            var img = canvas.previousSibling;
            if (img.tagName === 'IMG') {
                img.parentNode.removeChild(img);
                canvas.style.display = 'block';
            }
        };
</script>

@endsection




<!-- <script>
    // Define the route URL from Laravel
    const graphDataUrl = `{{ route('Graph.Data') }}`;

    document.getElementById('graph-timeframe-form').addEventListener('change', (e) => {
        const timeframe = e.target.value;

        fetch(`${graphDataUrl}?timeframe=${timeframe}`)
            .then(response => response.json())
            .then(data => {
                initChart(data);
            })
            .catch(error => {
                console.error('Error fetching the graph data:', error);
            });
    });

    const ctx2 = document.getElementById('user-data-chart').getContext('2d');
    let chart;

    const initChart = (data) => {
        if (chart) chart.destroy();
        chart = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: data.labels,
                datasets: [
                    {
                        label: 'Total Users',
                        data: data.usersDataGraph,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        fill: false,
                        tension: 0.3
                    },
                    {
                        label: 'New Users',
                        data: data.newUsersData,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        fill: false,
                        tension: 0.3
                    },
                    {
                        label: 'Logins',
                        data: data.loginCounts,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: false,
                        tension: 0.3
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: { beginAtZero: true },
                    y: { beginAtZero: true }
                }
            }
        });
    };
</script> -->