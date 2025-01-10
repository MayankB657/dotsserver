<!DOCTYPE html>
@extends('layouts.common')
@section('title', 'Dashboard')
@section('styles')
    <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'] . 'dashbord.css') }}">
    <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'] . 'filemanager.css') }}">
    <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'] . 'semantic.min.css') }}">

@endsection
@section('content')


    <div id="filemanagersection" class="file-manager mainrightscreen w-full h-screen">
        <div class="file-container w-full bg-no-repeat bg-center bg-cover">
            <nav class="logo-container h-20 px-10 py-3">
                <a href="{{ route('dashboard') }}"><img class="w-12 h-12"
                        src="{{ asset($constants['IMAGEFILEPATH'] . 'logo.png') }}" alt="logo" /></a>
            </nav>
            <div class="content-container w-full flex">
                <div class="sidebar w-1/4 md:1/4 lg:w-1/6 h-full bg-no-repeat bg-cover bg-center flex flex-col">
                    <div class="px-10 py-7 mt-10">
                        <h1 class="text-base">Favourites</h1>
                    </div>
                    <nav class="mt-2">
                        <ul class="grid gap-2">
                            <li>
                                <a id="link-desktop"
                                    class="flex fimanagerlinks items-center gap-3 rounded-r-md py-2 text-sm  data-[active=true]:bg-black data-[active=true]:font-semibold"
                                    href="{{ url('/filemanager', ['path' => urlencode('Desktop')]) }}">
                                    <span class="text-base font-normal px-10"><i class="ri-mac-line"></i><span
                                            class="ml-4">Desktop</span></span>
                                </a>
                            </li>
                            <li>
                                <a id="link-recent"
                                    class="flex fimanagerlinks items-center gap-3 rounded-r-md py-2 text-sm  data-[active=true]:font-semibold"
                                    href="{{ url('/filemanager', ['path' => urlencode('Gallery')]) }}">
                                    <span class="text-base font-normal px-10"><i class="ri-gallery-fill"></i>
                                        <span class="ml-4">Gallery</span>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a id="link-downloads"
                                    class="flex fimanagerlinks items-center gap-3 rounded-r-md py-2 text-sm hover:text-orange-500 data-[active=true]:text-orange-500 transition-colors hover:bg-black data-[active=true]:bg-black data-[active=true]:font-semibold"
                                    href="{{ url('/filemanager', ['path' => urlencode('Download')]) }}">
                                    <span class="text-base font-normal px-10"><i class="ri-chat-download-line"></i>
                                        <span class="ml-4"> Downloads</span>
                                    </span>
                                </a>
                            </li>
                            <!--<li>-->
                            <!--  <a  id="link-filemanager"-->
                            <!--    class="flex items-center gap-3 rounded-r-md py-2 text-sm hover:text-orange-500 data-[active=true]:text-orange-500transition-colors hover:bg-black data-[active=true]:bg-black data-[active=true]:font-semibold"-->
                            <!--    href="filemanager.html"-->
                            <!--  >-->
                            <!--    <span-->
                            <!--      class="text-base font-normal px-10"-->
                            <!--    >-->
                            <!--      App-->
                            <!--    </span>-->
                            <!--  </a>-->
                            <!--</li>-->
                            <li>
                                <a id="link-documents"
                                    class="flex fimanagerlinks items-center gap-3 rounded-r-md py-2 text-sm  transition-colors  data-[active=true]:font-semibold"
                                    href="{{ url('/filemanager', ['path' => urlencode('Document')]) }}">
                                    <span class="text-base font-normal px-10"><i class="ri-file-line"></i>
                                        <span class="ml-4">Documents</span>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a id="link-documents"
                                    class="flex fimanagerlinks items-center gap-3 rounded-r-md py-2 text-sm  transition-colors  data-[active=true]:font-semibold"
                                    href="{{ url('/filemanager', ['path' => urlencode('RecycleBin')]) }}">
                                    <span class="text-base font-normal px-10"><i class="ri-delete-bin-line"></i>
                                        <span class="ml-4">Recycle Bin</span>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a id="link-documents"
                                    class="flex fimanagerlinks items-center gap-3 rounded-r-md py-2 text-sm  transition-colors  data-[active=true]:font-semibold"
                                    href="{{ url('/linkshare') }}">
                                    <span class="text-base font-normal px-10"><i class="ri-file-line"></i>
                                        <span class="ml-4">Link Sharing</span>
                                    </span>
                                </a>
                            </li>
                            <!--<li>-->
                            <!--  <a id="link-applications"-->
                            <!--    class="flex items-center gap-3 rounded-r-md  py-2 text-sm  transition-colors data-[active=true]:font-semibold"-->
                            <!--    href="applications.html"-->
                            <!--  >-->
                            <!--    <span-->
                            <!--      class="text-base font-normal px-10"-->
                            <!--    >-->
                            <!--      Applications-->
                            <!--    </span>-->
                            <!--  </a>-->
                            <!--</li>-->
                        </ul>
                    </nav>
                </div>
                <div class="content-showing w-3/4 md:3/4 lg:w-5/6 h-full">


                    <!--optionbar -->
                    <div
                        class="transparent pl-5 border-b border-color-gray4 w-full h-16 bg-no-repeat bg-cover border-t border-gray-300">
                        <div class="flex items-center p-4 gap-8 relative">
                            <div class="relative">

                                <button class="flex items-center gap-2 newfiledropdown">
                                    </i>
                                    <h1>Link Sharing</h1>
                                    <i class="ri-arrow-down-s-line text-xs -ml-1 -mt-2"></i>
                                </button>
                                <!--<div class="absolute mt-2 hidden bg-white shadow-lg rounded-md newfiledropdownoption">-->
                                <!--  <ul class="py-1">-->
                                <!--    <li class="px-4 py-2 hover:bg-gray-200 cursor-pointer">-->
                                <!--      <i class="ri-file-text-line"></i>-->
                                <!--      <span class="ml-2">TXT</span>-->
                                <!--    </li>-->
                                <!--    <li class="px-4 py-2 hover:bg-gray-200 cursor-pointer">-->
                                <!--      <i class="ri-file-word-line"></i>-->
                                <!--      <span class="ml-2">Word</span>-->
                                <!--    </li>-->
                                <!--  </ul>-->
                                <!--</div>-->
                            </div>

                            <div class="relative flex items-center hidden" id="cancelshare">
                                <button class="flex gap-x-1">
                                    <i class="ri-close-fill ri-lg mt-1"></i><span>Cancel Link sharing</span>
                                </button>

                            </div>
                        </div>
                    </div>

                    <!--optiobarend -->

                    <div class="relative h-full overflow-y-auto scroll">
                        <div class="w-full mx-auto rounded">
                            <!--personal space-->
                            <div class="transition">
                                <!-- header -->
                                <div
                                    class="accordion-header cursor-pointer mt-3 transition flex justify-between px-6 items-center h-8 hover-bg-c-yellow border-b">
                                    <h6 class="font-weight-500 text-base">Personal Space (You Have Shared Data To Others)</h6>
                                    <i class="ri-arrow-drop-right-line ri-xl"></i>
                                </div>
                                <!-- Content -->
                                <div class="accordion-content pt-0 overflow-hidden max-h-0">
                                    <!--grid container -->
                                    <div id="gridContainer" class="overflow-y-auto personal">
                                    </div>
                                </div>
                            </div>

                            <div class="transition">
                                <!-- header -->
                                <div
                                    class="accordion-header cursor-pointer transition flex justify-between px-6 items-center h-8 hover-bg-c-yellow border-b">
                                    <h6 class="font-weight-500 text-base">Departmental Space (Others Shared With You)</h6>
                                    <i class="ri-arrow-drop-right-line ri-xl"></i>
                                </div>
                                <!-- Content -->
                                <div class="accordion-content pt-0 overflow-hidden max-h-0">
                                    <!--grid container -->
                                    <div id="gridContainer" class="overflow-y-auto document">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!--end here -->
    <!-- Right click Menu -->
    <div id="context-menu" class="context-menu hidden">
        <ul>
            <li class="flex items-center justify-between pr-4"><a href="#" id="refreshButton">Refresh</a>
                <p class="menu-sidename">F5</p>
            </li>
            <li class="border-b-2"><a href="#" class="show-upload-popup">Upload file</a></li>
            <li><a href="#" id="createFolderdesktop">New folder</a></li>
            <li class="flex items-center justify-between">
                <a href="#">New file</a>
                <i class="ri-arrow-right-s-line"></i>
                <ul class="submenu newfile-submenu absolute shadow-md rounded-md hidden">

                    <li class="flex items-center px-5">
                        <img class="w-5 h-5" src="{{ asset($constants['FILEICONPATH'] . 'docx.png') }}" alt="word-file">
                        <a href="#" id="createwordfile">Word file</a>
                    </li>
                    <li class="flex items-center px-5">
                        <img class="w-5 h-5" src="{{ asset($constants['FILEICONPATH'] . 'xlsx.png') }}"
                            alt="excel-file">
                        <a href="#" id="createexcelfile">Excel file</a>
                    </li>
                    <li class="flex items-center px-5 border-b-2">
                        <img class="w-5 h-5" src="{{ asset($constants['FILEICONPATH'] . 'pptx.png') }}"
                            alt="powerpoint-file">
                        <a href="#" id="createpptfile">PowerPoint File</a>
                    </li>

                </ul>
            </li>

            <li
                class="flex items-center justify-between pr-4 {{ session()->has('copyfilepath') ? '' : 'hidden' }} pastefileButton">
                <a href="#">Paste</a>
                <p class="menu-sidename">Ctrl+V</p>
            </li>

            <li class="flex items-center justify-between">
                <a href="#">Icon size</a>
                <i class="ri-arrow-right-s-line"></i>
                <ul class="submenu iconsize-submenu absolute shadow-md rounded-md hidden">
                    <li class="flex items-center px-5">
                        <i class="ri-function-add-line ri-xs"></i>
                        <a href="#" class="displaytinyicon">Tiny</a>
                    </li>
                    <li class="flex items-center px-5">
                        <i class="ri-function-add-line ri-sm"></i>
                        <a href="#" class="displaysmallicon">Small icon</a>
                    </li>
                    <li class="flex items-center px-5">
                        <i class="ri-function-add-line ri-1x"></i>
                        <a href="#" class="displaymediumicon">Medium icon</a>
                    </li>
                    <li class="flex items-center px-5">
                        <i class="ri-function-add-line ri-lg"></i>
                        <a href="#" class="displaybigicon">Big icon</a>
                    </li>
                    <li class="flex items-center px-5">
                        <i class="ri-function-add-line ri-xl"></i>
                        <a href="#" class="displayoversizeicon">Oversized icon</a>
                    </li>
                </ul>
            </li>

        </ul>
    </div>

    <!-- Apps context-menu -->
    <div id="app-contextmenu" class="context-menu hidden">
        <ul>
            <li class="flex items-center justify-between pr-4 allappoptions appoptions openrightclick"><a
                    href="#">Open</a>
                <p class="menu-sidename"></p>
            </li>

            <li class="flex items-center justify-between pr-4 allappoptions hidden downloadButton"><a
                    href="#">Download</a>
                <p class="menu-sidename">Shift+Enter</p>
            </li>
            <!--<li class="flex items-center justify-between pr-4 allappoptions hidden"><a href="#">Link sharing</a></li>-->
            <li class="flex items-center justify-between pr-4 allappoptions hidden copyfileButton"><a
                    href="#">Copy</a>
                <p class="menu-sidename">Ctrl+C</p>
            </li>
            <li class="flex items-center justify-between pr-4 allappoptions hidden cutfileButton"><a
                    href="#">Cut</a>
                <p class="menu-sidename">Ctrl+X</p>
            </li>
            <li class="flex items-center justify-between pr-4 allappoptions hidden renameButton"><a
                    href="#">Rename</a>
                <p class="menu-sidename">F2</p>
            </li>
            <li class="flex items-center justify-between pr-4 allappoptions hidden deletefileButton"><a
                    href="#">Delete</a>
                <p class="menu-sidename">Del</p>
            </li>

        </ul>
    </div>

    <div id="popupuploadfiles" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center">
        <div class="popup-content bg-white rounded-lg shadow-lg p-6 w-full max-w-2xl">
            <!-- Header -->
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Local Upload</h2>
                <button id="close-popup" class="text-2xl">
                    <i class="ri-close-line"></i>
                </button>
            </div>

            <!-- Button Area -->
            <div class="flex justify-between items-center mb-4">
                <div>
                    <input type="file" id="file-input" multiple class="hidden">
                    <label for="file-input" class="bg-black text-white px-4 py-2 mr-2 cursor-pointer">Upload File</label>
                    <!--<input type="file" id="folder-input" webkitdirectory multiple class="hidden">-->
                    <!--<label for="folder-input" class="bg-black text-white px-4 py-2 cursor-pointer">Upload Folder</label>-->
                </div>
                <div>
                    <!--<button id="pause-all" class="bg-gray-300 text-black px-4 py-2 mr-2 hover:bg-yellow-300">Pause</button>-->
                    <button id="clear-all" class="bg-gray-300 text-black px-4 py-2 mr-2 hover:bg-yellow-300">Clear
                        All</button>
                    <!--<button id="clear-out" class="bg-gray-300 text-black px-4 py-2 hover:bg-yellow-300">Clear Out</button>-->
                </div>
            </div>

            <!-- Table Area -->
            <div class="dropzone mt-10 mb-4 border border-gray-300 rounded-md overflow-y-auto max-h-68">
                <div id="file-list" class="space-y-2">
                    <!-- Files will be listed here -->
                </div>
            </div>

        </div>
    </div>
@endsection
@section('scripts')

    <!--poup-->
    <script src="{{ asset($constants['JSFILEPATH'] . 'filemanager.js') }}"></script>
    <script src="{{ asset($constants['JSFILEPATH'] . 'qrcode.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.2.13/dist/semantic.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.0.1/dist/js/multi-select-tag.js"></script>

    <script>
        $(document).ready(function() {
            $('#cancelshare, .cancel-share-btn').click(function() {
                var folderIds = [];
                var fileIds = [];

                // Collect selected folder and file IDs
                $('.appcheckbox:checked').each(function() {
                    var folderId = $(this).data('folder-id');
                    var fileId = $(this).data('file-id');

                    if (folderId) {
                        folderIds.push(folderId);
                    }
                    if (fileId) {
                        fileIds.push(fileId);
                    }
                });

                console.log('Selected folder IDs:', folderIds);
                console.log('Selected file IDs:', fileIds);

                var id = $(this).data('id');
                var row = $(this).closest('tr');
                console.log('>>>>>> ', id);
                
                var confirmMessage = 'Are you sure you want to cancel the share?';
                var useRoute = $(this).hasClass('cancel-share');

                if (!useRoute || confirm(confirmMessage)) {
                    var url = '{{ route('cancel.share2') }}';

                    var type = 'POST';

                    $.ajax({
                        url: url,
                        type: type,
                        data: {
                            _token: '{{ csrf_token() }}',
                            folderIds: folderIds,
                            fileIds: fileIds
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


        const cancel = document.getElementById("cancelshare");

        function togglebutton() {
            cancel.classList.toggle("hidden");
        }
    </script>
    <script>
        const desktopapp = @json(route('desktopapp'));
        const createFolderRoute = @json(route('createfolder'));
        const createFileRoute = @json(route('createfile'));
        const showFileDetail = @json(route('showsharedetail'));
    </script>
    <script>
        //checkbox enable
        $(document).ready(function() {

            $(document).on('click', '.appcheckbox', function() {
                if ($('.appcheckbox:checked').length > 0) {
                    $('#cancelshare').removeClass('hidden');
                } else {
                    $('#cancelshare').addClass('hidden');
                }
            });

        });
        document.addEventListener("DOMContentLoaded", () => {
            document.querySelector('.newfiledropdown').addEventListener('click', function() {
                document.querySelector('.newfiledropdownoption').classList.toggle('hidden');
            });
            const links = {
                'desktop.html': 'link-desktop',
                'Recent.html': 'link-recent',
                'downloads.html': 'link-downloads',
                'filemanager.html': 'link-filemanager',
                'documents.html': 'link-documents',
                'applications.html': 'link-applications'
            };
            const currentPage = window.location.pathname.split('/').pop();
            const activeLinkId = links[currentPage];
            if (activeLinkId) {
                const activeLink = document.getElementById(activeLinkId);
                if (activeLink) {
                    activeLink.classList.add('bg-black', 'text-orange-500', 'font-semibold');
                }
            }
            showapathdetail();

            function showapathdetail() {
                $.ajax({
                    url: showFileDetail,
                    method: 'GET',

                    success: function(response) {
                        // Update the app list container with the updated list
                        $('.personal').html(response.html);

                        $('.document').html(response.html2);

                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    </script>
    <script>
        const accordionHeader = document.querySelectorAll(".accordion-header");
        // on page load the content of accordion is display
        window.addEventListener("load", () => {
            accordionHeader.forEach((header) => {
                const accordionContent =
                    header.parentElement.querySelector(".accordion-content");
                let accordionMaxHeight = accordionContent.style.maxHeight;
                accordionContent.style.maxHeight = `${
        accordionContent.scrollHeight + 32
      }px`;
                header
                    .querySelector("i")
                    .classList.remove("ri-arrow-drop-right-line");
                header.querySelector("i").classList.add("ri-arrow-drop-down-line");
            });
        });
        // on click of accordion header show content
        accordionHeader.forEach((header) => {
            header.addEventListener("click", function() {
                const accordionContent =
                    header.parentElement.querySelector(".accordion-content");
                let accordionMaxHeight = accordionContent.style.maxHeight;

                // Condition handling
                if (accordionMaxHeight == "0px" || accordionMaxHeight.length == 0) {
                    accordionContent.style.maxHeight = `${
          accordionContent.scrollHeight + 32
        }px`;
                    header
                        .querySelector("i")
                        .classList.remove("ri-arrow-drop-right-line");
                    header.querySelector("i").classList.add("ri-arrow-drop-down-line");
                } else {
                    accordionContent.style.maxHeight = `0px`;
                    header.querySelector("i").classList.add("ri-arrow-drop-right-line");
                    header
                        .querySelector("i")
                        .classList.remove("ri-arrow-drop-down-line");
                }
            });
        });
    </script>

@endsection
