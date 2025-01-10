<div class="py-4 w-full hidden md:flex flex-row items-center gap-2 taskbar">
    <div class="flex bg-c-white rounded-md w-16 h-8 justify-evenly ml-6 items-center">
        <a href="#" class="leftArrowClick" data-path ="{{ base64UrlDecode($path) }}"
            data-leftpath="{{ url('filemanager', ['path' => base64UrlEncode($updatedPath)]) }}">
            <button>
                <i
                    class="ri-arrow-left-line ri-lg {{ empty(base64UrlDecode($path)) || base64UrlDecode($path) == '/' ? 'disabledicon' : '' }}"></i>
            </button>
        </a>

        <a href="#" class=" rightArrowClick"
            data-path ="{{ session()->has('rightarrowpath') ? url('filemanager', ['path' => base64UrlEncode(session('rightarrowpath'))]) : '' }}">
            <button>
                <i class="ri-arrow-right-line ri-lg {{ session()->has('rightarrowpath') ?: 'disabledicon' }}"></i>
            </button>
        </a>
    </div>

    <div
        class="flex context-menulist items-center rounded-md overflow-hidden bg-c-white h-8 md:ml-6 md:w-61 lg:w-8/12 cursor-pointer">
        <a href="#" class="leftArrowClick" data-path ="{{ base64UrlDecode($path) }}"
            data-leftpath="{{ url('filemanager', ['path' => base64UrlEncode($updatedPath)]) }}">

            <button
                class="pt-3 pb-3 pl-4 hidden md:flex items-center justify-center border-r border-c-gray-opaque pr-3">
                <i
                    class="ri-arrow-up-line ri-lg {{ empty(base64UrlDecode($path)) || base64UrlDecode($path) == '/' ? 'disabledicon' : '' }}"></i>
            </button>
        </a>

        <div class="flex items-center flex-grow flex-shrink overflow-x-auto scroll-x">
            <button class="flex items-center pl-2">
                <i class="ri-home-4-line pr-2"></i>Home
                {!! count($pathComponents) >= 1 ? '<span>/</span>' : '' !!}
            </button>
            @if (!empty($pathComponents))
                @foreach ($pathComponents as $pckey => $pcomponent)
                    @if ($pcomponent != '/' && !empty($pcomponent))
                        <button class="flex items-center whitespace-nowrap pl-1">
                            <span class="flex-shrink-0"> {{ $pcomponent }}</span>
                            {!! $pckey != count($pathComponents) - 1 ? '<span>/</span>' : '' !!}
                        </button>
                    @endif
                @endforeach
            @endif
        </div>

        <button class="pr-5 pt-3 pb-3 px-4 flex items-center justify-center">
            <i class="ri-star-line"></i>
        </button>
        <a href="#" class="refreshButton">
            <button class="pr-4 pt-3 pb-3 flex items-center justify-center">
                <i class="ri-loop-left-line"></i>
            </button>
        </a>
    </div>

    <div
        class="flex items-center rounded-md overflow-hidden flex-shrink-0 flex-grow bg-c-white h-8 ml-7 mr-6 w-11/12 md:w-2/12">
        <input type="text" class="pl-4 pt-2.5 pb-2.5 flex-shrink flex-grow border-none outline-none w-2/12"
            placeholder="Search" id="searchFiles" />
        <div class="pt-3 pb-3 pr-4 flex items-center justify-center">
            <i class="ri-search-line"></i>
        </div>
    </div>
</div>

<!-- topTaskbar in mobile -->
<div class="md:hidden w-full relative" id="taskbar">
    <div
        class="flex items-center justify-between overflow-hidden flex-shrink-0 bg-transparent h-8 w-11/12 ml-5 sm:ml-7 mb-3 mr-6 cursor-pointer flex-grow">
        <div class="flex items-center space-x-6 w-3/4 sm:w-5/6 overflow-x-auto scroll-x">
            <button class="flex items-center">
                <i class="ri-home-4-line pr-2"></i>Home
                {!! count($pathComponents) >= 1 ? '<span>/</span>' : '' !!}
            </button>
            @if (!empty($pathComponents))
                @foreach ($pathComponents as $pckey => $pcomponent)
                    @if ($pcomponent != '/' && !empty($pcomponent))
                        <button class="flex items-center">
                            <span class="truncate">{{ $pcomponent }}</span>
                            {!! $pckey != count($pathComponents) - 1 ? '<span>/</span>' : '' !!}
                        </button>
                    @endif
                @endforeach
            @endif
        </div>

        <div class="flex items-center space-x-2">
            <button class="pr-2 pt-3 pb-3 flex items-center justify-center" onclick="toggleView();">
                <i class="ri-gallery-view-2" id="view-button"></i>
            </button>
            <button class="pt-3 pb-3 flex items-center justify-center dropdown-btn">
                <i class="ri-more-fill" id="more-button"></i>
            </button>
            <div class="dropdown-option absolute z-10 right-4 top-8 bg-c-white border border-c-medium-gray rounded-lg shadow-md hidden w-10"
                id="more-dropdown">
                <div class="hover-bg-c-yellow rounded-t-lg">
                    <a href="#" class="block p-1 flex justify-center items-center dropdown-item"
                        onclick="togglePanel('detail');">
                        <i class="ri-profile-line"></i>
                    </a>
                </div>
                <div class="hover-bg-c-yellow rounded-b-lg">
                    <a href="#" class="block p-1 flex justify-center items-center dropdown-item"
                        onclick="togglePanel('preview');"><i class="ri-eye-line"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="py-4 w-full flex flex-col items-center gap-2 taskbar" id="search">
        <div
            class="flex items-center rounded-md overflow-hidden flex-shrink-0 flex-grow bg-c-white h-8 ml-7 mr-6 w-11/12 md:w-2/12">
            <input type="text"
                class="pl-4 pt-2.5 pb-2.5 flex-shrink flex-grow border-none outline-none font-size-16 w-2/12"
                placeholder="Search" />
            <div class="pt-3 pb-3 pr-4 flex items-center justify-center">
                <i class="ri-search-line"></i>
            </div>
        </div>
    </div>
</div>

<!-- actionbar -->

<div class="border-b border-c-light-gray1 flex justify-between items-center hidden md:flex text-c-black actionbar">

    <!--------------- end icon bar  --------------------------------------------------------------------------------->

    <div class="flex ml-6 gap-x-5 lg:gap-x-4 xl:gap-x-6 my-2 context-menulist">
        @if ($path == '/')
        @else
            @if (in_array('Recycle Bin', $pathComponents))
                <a href="#" class="clickmenu restoreFunction disabledicon fimanagertoolpanel"><button
                        class="restore">
                        <i class="">Restore</i>
                    </button></a>

                <a href="#" class="clickmenu deleteFunction disabledicon fimanagertoolpanel"><button
                        class="delete">
                        <i class="ri-delete-bin-line ri-lg"></i>
                    </button></a>
            @else
                @if (filterView('function', 'createFileFunction'))
                    <div class="relative flex items-center clickmenu new">

                        <button class="flex dropdown-btn">
                            <i class="ri-add-circle-fill ri-xl mt-1"></i><span class="ml-1">New</span>
                            <i class="ri-arrow-drop-down-line ri-lg mt-1"></i>
                        </button>

                        <div id="new-dropdown"
                            class="dropdown-option absolute mt-2 z-10 bg-c-white border border-c-medium-gray rounded-lg shadow-md hidden w-52 top-full">
                            @if (!empty($contextTypes))
                                @foreach ($contextTypes as $contextType)
                                    @if (!empty($contextType->contextOptions))
                                        @foreach ($contextType->contextOptions as $option)
                                            <div class="hover-bg-c-yellow rounded-t-lg">
                                                <a href="#"
                                                    class="flex block p-2 pl-4 dropdown-item {{ $contextType->function }} "
                                                    data-type="{{ $option->function }}">
                                                    <img src="{{ asset($constants['FILEICONPATH'] . ($option->image ?? 'default') . $constants['ICONEXTENSION']) }}"
                                                        alt="{{ $option->name }}"
                                                        class="pr-4 w-11" /><span>{{ $option->name }}</span>
                                                </a>
                                            </div>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endif
                @if (filterView('function', 'uploadFiles'))
                    <div class="relative flex items-center upload">
                        <a href="#" class="clickmenu uploadFiles">
                            <button class="flex gap-x-2">
                                <i class="ri-upload-2-line ri-lg mt-1"></i>
                                <span>Upload</span>
                            </button>
                        </a>
                    </div>
                @endif
                @if (filterView('function', 'cutFunction'))
                    <a href="#" class="clickmenu cutFunction disabledicon fimanagertoolpanel"><button
                            class="scissor">
                            <i class="ri-scissors-2-fill ri-lg"></i>
                        </button></a>
                @endif
                @if (filterView('function', 'copyFunction'))
                    <a href="#" class="clickmenu copyFunction disabledicon fimanagertoolpanel"><button
                            class="copy">
                            <i class="ri-file-copy-line ri-lg"></i>
                        </button></a>
                @endif
                @if (filterView('function', 'cutFunction') || filterView('function', 'copyFunction'))
                    <a href="#"
                        class="clickmenu pasteFunction enableonlypaste disabledicon fimanagertoolpanel"><button
                            class="paste">
                            <i class="ri-clipboard-line ri-lg"></i>
                        </button></a>
                @endif
                @if (filterView('function', 'renameFunction'))
                    <a href="#" class="clickmenu renameFunction disabledicon fimanagertoolpanel"><button
                            class="edit">
                            <i class="ri-edit-line ri-lg"></i>
                        </button></a>
                @endif
                <!-- <button class="share" onclick="togglePopup('sharePopup');">
                  <i class="ri-share-fill ri-lg"></i>
                </button> -->
                @if (filterView('function', 'deleteFunction'))
                    <a href="#" class="clickmenu deleteFunction disabledicon fimanagertoolpanel"><button
                            class="delete">
                            <i class="ri-delete-bin-line ri-lg"></i>
                        </button></a>
                @endif
                <div class="relative flex items-center clickmenu sort">
                    <button class="flex dropdown-btn">
                        <i class="ri-arrow-up-down-line ri-lg mt-1"></i>
                        <span class="ml-1">Sort</span>
                        <i class="ri-arrow-drop-down-line ri-lg mt-1"></i>

                    </button>

                    <div id="sort-dropdown"
                        class="dropdown-option absolute top-full mt-2 z-10 bg-c-white border border-c-medium-gray rounded-lg shadow-md hidden md:w-40 lg:w-44 xl:w-68">
                        @if (!empty($sortcontextTypes))
                            @foreach ($sortcontextTypes as $scontextType)
                                @if (!empty($scontextType->contextOptions))
                                    @foreach ($scontextType->contextOptions as $soption)
                                        <div class="hover-bg-c-yellow rounded-t-lg">
                                            <a href="#"
                                                class="flex block p-2 pl-4 dropdown-item  {{ $scontextType->function }} "
                                                data-type="{{ $soption->function }}">
                                                @if ($soption->divider == 1)
                                                    <hr>
                                                @endif
                                                <span>{{ $soption->name }}</span>
                                                @if ($soption->suboption == 1)
                                                    <i class="ri-check-line pr-3 ri-lg mt-1 sortingcheck sorting{{ $soption->function }} {{ session()->has('sortorder') && session('sortorder') == $soption->function ?: 'hidden' }}"
                                                        data-key="sortorder"></i>
                                                @else
                                                    <i class="ri-check-line pr-3 ri-lg mt-1 sortingcheck sorting{{ $soption->function }} {{ session()->has('sortby') && session('sortby') == $soption->function ?: 'hidden' }} "
                                                        data-key="sortby"></i>
                                                @endif
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="relative flex items-center resize">
                    <button class="flex dropdown-btn">
                        <i class="ri-arrow-up-down-line ri-lg mt-1"></i>
                        <span class="ml-1">Resize</span>
                        <i class="ri-arrow-drop-down-line ri-lg mt-1"></i>
                    </button>
                    <div id="resize-dropdown"
                        class="dropdown-option absolute top-full mt-2 z-10 bg-c-white border border-c-medium-gray rounded-lg shadow-md hidden clickmenu md:w-40 lg:w-44 xl:w-68">
                        @if (!empty($resizecontextTypes))
                            @foreach ($resizecontextTypes as $rcontextType)
                                @if (!empty($rcontextType->contextOptions))
                                    @foreach ($rcontextType->contextOptions as $roption)
                                        <div class="hover-bg-c-yellow rounded-t-lg">
                                            <a href="#"
                                                class="flex items-center block p-2 pl-4 dropdown-item  {{ $rcontextType->function }} "
                                                data-type="{{ $roption->function }}">
                                                <i class="ri-gallery-view-2 text-sm mt-1 w-1/4"></i>
                                                <span>{{ $roption->name }}</span>
                                                <i
                                                    class="ri-check-line pr-3 ri-lg mt-1 resizecheck resize{{ $roption->function }} {{ session()->has('iconsize') && session('iconsize') == $roption->function ?: 'hidden' }}"></i>
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            @endif
        @endif


        <div class="relative flex items-center view">
            <button class="flex dropdown-btn" onclick="toggleView()">
                <i class="ri-gallery-view-2 ri-lg mt-1"></i>
                <span class="ml-1">View</span>
                <i class="ri-arrow-drop-down-line ri-lg mt-1"></i>
            </button>

            <div id="view-dropdown"
                class="dropdown-option absolute top-full mt-2 z-10 bg-c-white border border-c-medium-gray rounded-lg shadow-md hidden md:w-44 xl:w-68">
                <div class="hover-bg-c-yellow rounded-t-lg">
                    <a href="#" class="flex items-center block p-2 pl-4 dropdown-item clickmenu listFunction"
                        data-type="">
                        <i class="ri-list-check ri-lg w-1/4"></i>
                        <span>List View</span>
                    </a>
                </div>

                <div class="hover-bg-c-yellow rounded-t-lg">
                    <a href="#" class="flex items-center block p-2 pl-4 dropdown-item clickmenu tileFunction"
                        data-type="">
                        <i class="ri-grid-fill w-1/4"></i>
                        <span>Grid View</span>
                    </a>
                </div>

                <!-- <div class="hover-bg-c-yellow rounded-t-lg">-->
                <!--  <a-->
                <!--    href="#"-->
                <!--    class="flex items-center block p-2 pl-4 dropdown-item disabledicon fimanagertoolpanel clickmenu detailsFunction" -->
                <!--    data-type=""-->
                <!--  >-->
                <!--  <i class="ri-profile-line ri-lg w-1/4"></i>-->
                <!--  <span>Detail pane</span>-->
                <!--  </a>-->
                <!--</div>-->

                <!--<div class="hover-bg-c-yellow rounded-t-lg">-->
                <!--  <a-->
                <!--    href="#"-->
                <!--    class="flex items-center block p-2 pl-4 disabledicon fimanagertoolpanel dropdown-item clickmenu previewFunction" -->
                <!--    data-type=""-->
                <!--  >-->
                <!--  <i class="ri-eye-line ri-lg w-1/4"></i>-->
                <!--  <span>Preview pane</span>-->
                <!--  </a>-->
                <!--</div> -->

            </div>
        </div>
    </div>

    <!------ end icon bar  ------------------------------------------------------>
    @if (!empty($pathComponents))
        <div class="py-2 md:flex items-center justify-end ">
            <button class="pr-8" onclick="OrientDropModel()">
                <i class="ri-settings-3-fill text-2xl"></i>
            </button>
        </div>
    @endif
</div>

<div id="OrientDropModel"
    class="fixed inset-0 z-20 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg w-11/12 md:w-2/3">
        <!-- Modal Header -->
        <div class="flex justify-between items-center p-4 border-b">
            <h2 class="text-lg font-bold">
                <i class="ri-settings-3-fill"></i> Orient drop
            </h2>
            <button id="closeModal" class="text-gray-500 hover:text-gray-800">
                <i class="ri-close-fill text-2xl"></i>
            </button>
        </div>
        <!-- Modal Content -->
        <div class="p-4">
            <div class="w-full ml-auto mb-4">
                <select data-placeholder="Select content" multiple
                    class="label ui selection fluid dropdown w-full rounded-xl" name="groups[]">
                    <option value="">Please choose the group</option>
                    <option value="1">Sales dept</option>
                    <option value="2">Marketing dept</option>
                    <option value="3"> HR dept</option>
                </select>
            </div>
            <!-- Table -->
            <div id="tableContainer" class="overflow-x-auto transition-all">
                <table class="w-full text-left border-collapse border border-gray-200">
                    <thead class="bg-c-gray-4 role">
                        <tr>
                            <th class="border border-gray-300 px-4 py-2 text-center">
                                <label class="flex items-center justify-center gap-2">
                                    <input type="checkbox" class="d-checkbox" /> Select
                                    all
                                </label>
                            </th>
                            <th class="border border-gray-300 px-4 py-2 text-center">
                                <label class="flex items-center justify-center gap-2">
                                    <input type="checkbox" class="d-checkbox" /> View
                                </label>
                            </th>
                            <th class="border border-gray-300 px-4 py-2 text-center">
                                <label class="flex items-center justify-center gap-2">
                                    <input type="checkbox" checked class="d-checkbox" />
                                    Edit
                                </label>
                            </th>
                            <th class="border border-gray-300 px-4 py-2 text-center">
                                <label class="flex items-center justify-center gap-2">
                                    <input type="checkbox" class="d-checkbox" />
                                    Download
                                </label>
                            </th>
                            <th class="border border-gray-300 px-4 py-2 text-center">
                                <label class="flex items-center justify-center gap-2">
                                    <input type="checkbox" checked class="d-checkbox" />
                                    Delete
                                </label>
                            </th>
                        </tr>
                    </thead>

                    <tbody class="role">
                        <tr class="bg-c-table-yellow">
                            <th class="border border-gray-300 px-4 py-2">
                                <label class="flex items-center justify-start gap-2">
                                    <input type="checkbox" checked class="d-checkbox" />
                                    <span class="font-normal">Admin</span>
                                </label>
                            </th>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <div class="flex justify-center items-center">
                                    <input type="checkbox" class="d-checkbox" />
                                </div>
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <div class="flex justify-center items-center">
                                    <input type="checkbox" class="d-checkbox" />
                                </div>
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <div class="flex justify-center items-center">
                                    <input type="checkbox" checked class="d-checkbox" />
                                </div>
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <div class="flex justify-center items-center">
                                    <input type="checkbox" checked class="d-checkbox" />
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th class="border border-gray-300 px-4 py-2">
                                <label class="flex items-center justify-start gap-2">
                                    <input type="checkbox" checked class="d-checkbox" />
                                    <span class="font-normal">User 1</span>
                                </label>
                            </th>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <div class="flex justify-center items-center">
                                    <input type="checkbox" class="d-checkbox" />
                                </div>
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <div class="flex justify-center items-center">
                                    <input type="checkbox" checked class="d-checkbox" />
                                </div>
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <div class="flex justify-center items-center">
                                    <input type="checkbox" class="d-checkbox" />
                                </div>
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <div class="flex justify-center items-center">
                                    <input type="checkbox" class="d-checkbox" />
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th class="border border-gray-300 px-4 py-2">
                                <label class="flex items-center justify-start gap-2">
                                    <input type="checkbox" checked class="d-checkbox" />
                                    <span class="font-normal">User 2</span>
                                </label>
                            </th>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <div class="flex justify-center items-center">
                                    <input type="checkbox" class="d-checkbox" />
                                </div>
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <div class="flex justify-center items-center">
                                    <input type="checkbox" checked class="d-checkbox" />
                                </div>
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <div class="flex justify-center items-center">
                                    <input type="checkbox" class="d-checkbox" />
                                </div>
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <div class="flex justify-center items-center">
                                    <input type="checkbox" class="d-checkbox" />
                                </div>
                            </td>
                        </tr>
                        <tr class="bg-c-table-yellow">
                            <th class="border border-gray-300 px-4 py-2">
                                <label class="flex items-center justify-start gap-2">
                                    <input type="checkbox" class="d-checkbox" />
                                    <span class="font-normal">HR</span>
                                </label>
                            </th>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <div class="flex justify-center items-center">
                                    <input type="checkbox" class="d-checkbox" />
                                </div>
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <div class="flex justify-center items-center">
                                    <input type="checkbox" class="d-checkbox" />
                                </div>
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <div class="flex justify-center items-center">
                                    <input type="checkbox" class="d-checkbox" />
                                </div>
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <div class="flex justify-center items-center">
                                    <input type="checkbox" class="d-checkbox" />
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th class="border border-gray-300 px-4 py-2">
                                <label class="flex items-center justify-start gap-2">
                                    <input type="checkbox" class="d-checkbox" />
                                    <span class="font-normal">User 1</span>
                                </label>
                            </th>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <div class="flex justify-center items-center">
                                    <input type="checkbox" class="d-checkbox" />
                                </div>
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <div class="flex justify-center items-center">
                                    <input type="checkbox" class="d-checkbox" />
                                </div>
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <div class="flex justify-center items-center">
                                    <input type="checkbox" class="d-checkbox" />
                                </div>
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <div class="flex justify-center items-center">
                                    <input type="checkbox" class="d-checkbox" />
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th class="border border-gray-300 px-4 py-2">
                                <label class="flex items-center justify-start gap-2">
                                    <input type="checkbox" class="d-checkbox" />
                                    <span class="font-normal">User 2</span>
                                </label>
                            </th>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <div class="flex justify-center items-center">
                                    <input type="checkbox" class="d-checkbox" />
                                </div>
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <div class="flex justify-center items-center">
                                    <input type="checkbox" class="d-checkbox" />
                                </div>
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <div class="flex justify-center items-center">
                                    <input type="checkbox" class="d-checkbox" />
                                </div>
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <div class="flex justify-center items-center">
                                    <input type="checkbox" class="d-checkbox" />
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="flex justify-end mt-3">
                    <button class="bg-c-black hover-bg-c-black text-white rounded-full w-32 py-2 text-sm">
                        Save
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset($constants['JSFILEPATH'] . 'orientdrop.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.2.13/dist/semantic.min.js"></script>
<script defer>
    $('.label.ui.dropdown')
        .dropdown();

    $('.no.label.ui.dropdown')
        .dropdown({
            useLabels: false
        });

    $('.ui.button').on('click', function() {
        $('.ui.dropdown')
            .dropdown('restore defaults')
    })
</script>
