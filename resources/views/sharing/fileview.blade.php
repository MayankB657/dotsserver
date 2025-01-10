<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
    <link href="https://unpkg.com/tailwindcss@^2.2.19/dist/tailwind.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'] . 'root.css') }}" />
    <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'] . 'common.css') }}" /> 
</head>

<body class="w-full h-screen">
    <main class="w-full h-full bg-c-gray-5">
        <nav class="bg-c-white h-10 flex items-center justify-end">
            <div class="flex items-center justify-center cursor-pointer">
                <!-- <span class="border-l border-c-lightgray py-2 px-4 hover:bg-gray-200 backButton"><i
                        class="ri-arrow-left-line text-c-time"></i></span> -->
                <!-- <span class="border-l border-c-lightgray py-2 px-4 hover:bg-gray-200"><i
                        class="ri-download-2-line text-c-time"></i></span> -->
                <!-- <span class="border-l border-c-lightgray py-2 px-4 hover:bg-gray-200 ShowQrCode"><i
                        class="ri-qr-code-line text-c-time"></i></span> -->
                <a href="{{ route('dashboard') }}"><span
                        class="border-l border-c-lightgray py-2 px-4 hover:bg-gray-200"><i
                            class="ri-home-2-line text-c-time"></i></span></a>
            </div>
        </nav>
        <div class="w-full lg:px-20 lg:py-3" style="height: calc(100% - 72px);">
            <div class="w-full h-full bg-c-gray-6 rounded overflow-hidden">
                <div class="h-full float-left px-2 hidden lg:block">
                    <div class="loaddetails">
                        <div class="app maindesktopapp w-21 h-28 cursor-pointer relative">
                            <a href="#" class="files openiframe selectapp"
                                data-path =" {{ urldecode($files->path) }}"
                                data-appkey="{{ base64UrlEncode($files->openwith) }}"
                                data-filekey="{{ base64UrlEncode($files->id) }}" data-filetype="document"
                                data-apptype="LightApp" data-isfile="1">
                                <div
                                    class="w-full app-tools absolute flex item-center gap-8 px-2 invisible showappoptions">
                                    <input type="checkbox" class="appcheckbox"
                                        id="checkboxdocument{{ base64UrlEncode($files->id) }}">
                                    <div class="ml-auto -mt-1">
                                        <i class="ri-arrow-drop-down-fill ri-xl text-black"></i>
                                    </div>
                                </div>
                                <div class="flex flex-col items-center">
                                    @if ($files->filetype == 'image')
                                        <a 
                                        href = "{{ url(Storage::url($constants['ROOTPATH'].$files->path)) }}" 
                                        class = "files openiframe selectapp" 
                                        data-file-id = "{{ $files->id }}"
                                        data-ext = "{{ $files->extension }}" 
                                        data-image = "{{ $files->path }}"
                                        data-title = "{{ $files->name }}" 
                                        data-url = "{{ $files->path }}"
                                        >
                                        
                                        <img class="w-16 icondisplay" 
                                        src="{{ url(Storage::url($constants['ROOTPATH'].$files->path)) }}"
                                        alt="{{ $files->name }}" />
                                        </a>
                                    @elseif($files->filetype == 'application')
                                    @php
                                    $extension = strtolower($files->extension); 
                                    $iconPath = ''; 
                                    switch ($extension) {
                                        case 'pdf':
                                            $iconPath = asset('public/images/Docs.png');
                                            break;
                                        case 'doc':
                                        case 'docx':
                                            $iconPath = asset('public/images/docx.png');
                                            break;
                                        case 'xls':
                                        case 'xlsx':
                                            $iconPath = asset('public/images/xlsx.png');
                                            break;
                                        case 'ppt':
                                        case 'pptx':
                                            $iconPath = asset('public/images/pptx.png');
                                            break;
                                        default:
                                            $iconPath = asset('public/images/Docs.png'); 
                                            break;
                                    }
                                @endphp

                                <a href="{{ url(Storage::url($constants['ROOTPATH'].$files->path)) }}" target="_blank" class="files openiframe selectapp" data-file-id="{{ $files->id }}"
                                    data-ext="{{ $files->extension }}" data-title="{{ $files->name }}" data-url="{{ $files->path }}">
                                    <img class="w-16 icondisplay" src="{{ $iconPath }}" alt="{{ $files->name }}" />
                                </a>

                               
                                    @elseif($files->filetype == 'video')
                                        <a href="{{ url(Storage::url($constants['ROOTPATH'].$files->path)) }}" class="files openiframe selectapp" data-file-id="{{ $files->id }}"
                                            data-ext = "{{ $files->extension }}" data-image="{{ $files->path }}"
                                            data-title="{{ $files->name }}" data-url="{{ url(Storage::url($constants['ROOTPATH'].$files->path)) }}">
                                            <video class="w-16 icondisplay" alt="{{ $files->name }}" />
                                            <source src="{{ url(Storage::url($constants['ROOTPATH'].$files->path)) }}" type="video/mp4"></video>
                                        </a>
                                    @else
                                    
                                        <img class="w-16 icondisplay "
                                            src="{{ url(Storage::url($constants['ROOTPATH'].$files->extension . '.png')) }}"
                                            alt="{{ $files->name }}" />
                                    @endif
                                    <div class="input-wrapper"
                                        id="inputWrapperdocument{{ base64UrlEncode($files->id) }}">
                                        <input type="text" class="text-center text-black appinputtext" disabled
                                            id="inputFielddocument{{ base64UrlEncode($files->id) }}"
                                            value="{{ $files->name }}">
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <!-- <div id="alliframelist">

                    </div>
                    <header id="iframeheaders"
                        class="transparent p-2 text-white flex justify-center items-center fixed top-0 left-0 right-0 mainiframeiconheader mainscreen">

                    </header> -->
                </div>
                <div class="bg-c-white w-60 h-full float-right px-2 hidden lg:block">
                    <div class="flex flex-col items-center justify-center gap-2 border-b border-c-lightgray py-8">
                        <img class="rounded-full w-20 shadow-current" style="object-fit: none"
                            src="{{ asset($constants['IMAGEFILEPATH'] . 'folder.png') }}" alt="user-img">
                        <h3 class="text-c-black text-base font-normal">File <span class="text-sm text-c-medium-gray">
                                Sharing</span></h3>
                    </div>
                    <div class="mt-3">
                        <div class="flex items-start flex-wrap p-1">
                            <h5 class="text-xs text-c-time w-1/3">Title:</h5>
                            <span class="text-xs text-c-black font-bold break-words w-2/3">{{ $path }}</span>
                        </div>  
                        <!-- <div class="flex items-center p-1">
                            <h5 class="text-xs text-c-time w-1/3">Time:</h5>
                            <span class="text-xs text-c-black font-normal break-words w-2/3"></span>
                        </div>
                        <div class="flex items-center p-1">
                            <h5 class="text-xs text-c-time w-1/3">Size:</h5>
                            <span class="text-xs text-c-black font-normal break-words w-2/3"></span>
                        </div>
                        <div class="flex items-center p-1">
                            <h5 class="text-xs text-c-time w-1/3">Browse:</h5>
                            <span class="text-xs text-c-black font-normal break-words w-2/3"></span>
                        </div>
                        <div class="flex items-center p-1">
                            <h5 class="text-xs text-c-time w-1/3">Download:</h5>
                            <span class="text-xs text-c-black font-normal break-words w-2/3"></span>
                        </div> -->
                    </div>
                </div>
            </div>
            <div id="QrCodeModal"
                class="fixed inset-0 flex items-center justify-center hidden bg-gray-800 bg-opacity-50">
                <div class="bg-c-white rounded-xl p-10 shadow-lg max-w-7xl max-h-screen overflow-y-auto">
                    <div id="qrcode" style="width: 100px; height: 100px; margin-bottom: 15px"></div>
                    <div class="flex items-center justify-center">
                        <button class="bg-c-light-gray text-c-white px-6 py-2 rounded-full hideqrmodal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <footer class="w-full h-8 bg-c-white flex items-center justify-center">
            <span class="text-c-time font-light text-xs">- Powered by DOTS</span>
        </footer>
    </main>
    <input type="hidden" value="{{ base64UrlEncode($files->openwith) }}" id="app-key">
    <input type="hidden" value="{{ base64UrlEncode($files->id) }}" id="file-key">
    <input type="hidden" value="document" id="file-type">
    <input type="hidden" value="LightApp" id="app-type">
    <input type="hidden" value="1" id="is-file">
    <input type="hidden" value="{{ url('/') }}/sharing/{{ $id }}" name="url">
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js"></script>
<script src="{{ asset($constants['JSFILEPATH'] . 'qrcode.js') }}"></script>
<script>
    const showFileDetail = @json(route('sharepathdetail'));
    const updateFileDownloadCount = @json(route('updateFileDownloadCount'));
    $(document).ready(function() {
        const appkey = $('#app-key').val();
        const filekey = $('#file-key').val();
        const filetype = "document";
        const apptype = "LightApp";
        const isfile = 1;
        const iframedata = {
            appkey: appkey,
            filekey: filekey,
            filetype: filetype,
            apptype: apptype,
            isfile: isfile
        };
        console.log(iframedata);
        //openiframe(iframedata);
    });

    function openiframe(data) {
        $.ajax({
            url: '{{ route('openiframe') }}',
            method: 'GET',
            data: data,
            success: function(response) {
                // Update the app list container with the updated list
                $('#alliframelist').html(response.html);
                $('#iframeheaders').html(response.html2);
                if (response.filekey) {
                    document.getElementById(response.filekey).classList.remove('hidden');
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
    document.addEventListener("DOMContentLoaded", () => {
        $(document).on('click', '#alliframelist .closeiframe-btn', function() {
            const appkey = this.getAttribute('data-appkey');
            const filekey = this.getAttribute('data-filekey');
            const filetype = this.getAttribute('data-filetype');
            const isfile = this.getAttribute('data-isfile');
            const fileid = this.getAttribute('data-iframefile-id');
            closeiframe(appkey, filekey, fileid, filetype, isfile);
        });

        // Maximize button functionality
        $(document).on('click', '#alliframelist .maximizeiframe-btn', function() {
            var iframeId = $(this).data('iframe-id');
            var iframePopup = $('#alliframelist #iframepopup' + iframeId);
            iframePopup.toggleClass('maximized');
        });

        // Minimize button functionality
        $(document).on('click', '#alliframelist .minimizeiframe-btn', function() {
            var iframeId = $(this).data('iframe-id');
            var iframePopup = $('#alliframelist #iframepopup' + iframeId);
            $('#alliframelist #iframepopup' + iframeId).addClass('hidden');
        });

        function closeiframe(appkey, filekey, fileid, filetype, isfile) {
            $('#alliframelist #iframepopup' + fileid).removeClass('hidden');
            $.ajax({
                url: '{{ route('closeiframe') }}',
                method: 'GET',
                data: {
                    appkey: appkey,
                    filekey: filekey,
                    filetype: filetype,
                    isfile: isfile
                },
                success: function(response) {
                    // Update the app list container with the updated list
                    $('#alliframelist').html(response.html);
                    $('#iframeheaders').html(response.html2);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        $(document).on('click', '.backButton', function(e) {
            e.preventDefault();
            window.history.back();
        });        
    });

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '.files', function(e) {
            var fileId = $(this).data('file-id');
            var fileUrl = $(this).attr('href');  

            $.ajax({
                url: updateFileDownloadCount,  
                method: 'POST',
                data: {                    
                    fileId: fileId
                },
                success: function(response) {
                    window.location.href = fileUrl; 
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });

            e.preventDefault();  
        });
    });


    // $(document).ready(function() {
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //     });
    //     $(document).on('click', '.files', function(e) {
    //         e.preventDefault(); 
    //         var fileId = $(this).data('file-id');
    //         $.ajax({
    //             url: updateFileDownloadCount,
    //             method: 'POST',
    //             data: {                    
    //                 fileId: fileId
    //             },
    //             success: function(response) {
    //                 // location.reload();
    //                 // $('#loaddetails').html(response.html);
    //             },
    //             error: function(xhr, status, error) {
    //                 console.error(xhr.responseText);
    //             }
    //         });
    //     });
    // });
</script>

</html>
