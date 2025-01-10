<div class="flex flex-wrap gap-4 p-6 ">
    @foreach ($defaultfolders as $dfolder)
        <div class="app maindesktopapp w-21 h-28 cursor-pointer relative">
            <a href="{{ url('/sharingp/' . urlencode($dfolder->path)) }}" class="systemapp selectapp showappoptions"
                data-appkey="{{ base64UrlEncode($dfolder->id) }}" data-filekey="{{ base64UrlEncode($dfolder->id) }}"
                data-filetype="systemapp" data-apptype="App" data-isfile="1">

                <div class="fixed w-full app-tools absolute flex item-center gap-8 px-2 invisible showappoptions">
                    <input type="checkbox" class="appcheckbox"
                        id="checkboxsystemapp{{ base64UrlEncode($dfolder->id) }}">
                    <div class="ml-auto -mt-1">
                        <i class="ri-arrow-drop-down-fill ri-xl text-black"></i>
                    </div>
                </div>
                <div class="flex flex-col items-center">
                    <img class="w-16 icondisplay" src="{{ asset($constants['APPFILEPATH'] . $dfolder->icon) }}"
                        alt="{{ $dfolder->name }}" />

                    <div class="input-wrapper" id="inputWrappersystemapp{{ base64UrlEncode($dfolder->id) }}">
                        <input type="text" class="text-center text-black appinputtext" disabled
                            id="inputFieldsystemapp{{ base64UrlEncode($dfolder->id) }}" value="{{ $dfolder->name }}">
                    </div>
                </div>
            </a>
        </div>
    @endforeach
    {{-- @foreach ($folders as $folder)
        <div class="app maindesktopapp w-21 h-28 cursor-pointer relative">
            <a href="{{ url('/sharingp/' . urlencode($folder->path)) }}" class="folders selectapp"
                data-path =" {{ urldecode($folder->path) }}" data-appkey="{{ base64UrlEncode($folder->openwith) }}"
                data-filekey="{{ base64UrlEncode($folder->id) }}" data-filetype="folder" data-apptype="App"
                data-isfile="1">

                <div class="fixed w-full app-tools absolute flex item-center gap-8 px-2 invisible showappoptions">
                    <input type="checkbox" class="appcheckbox" id="checkboxfolder{{ base64UrlEncode($folder->id) }}">
                    <div class="ml-auto -mt-1">
                        <i class="ri-arrow-drop-down-fill ri-xl text-black"></i>
                    </div>
                </div>
                <div class="flex flex-col items-center">
                    <img class="w-16 icondisplay" src="{{ asset($constants['FILEICONPATH'] . 'folder.png') }}"
                        alt="{{ $folder->name }}" />

                    <div class="input-wrapper" id="inputWrapperfolder{{ base64UrlEncode($folder->id) }}">
                        <input type="text" class="text-center text-black appinputtext" disabled
                            id="inputFieldfolder{{ base64UrlEncode($folder->id) }}" value="{{ $folder->name }}">
                    </div>
                </div>
            </a>
        </div>
    @endforeach --}}
    @foreach ($files as $file)
        <div class="app maindesktopapp w-21 h-28 cursor-pointer relative">
            <a href="#" class="files openiframe selectapp" data-path =" {{ urldecode($file->path) }}"
                data-appkey="{{ base64UrlEncode($file->openwith) }}" data-filekey="{{ base64UrlEncode($file->id) }}"
                data-filetype="document" data-apptype="LightApp" data-isfile="1">

                <div class="fixed w-full app-tools absolute flex item-center gap-8 px-2 invisible showappoptions">
                    <input type="checkbox" class="appcheckbox" id="checkboxdocument{{ base64UrlEncode($file->id) }}">
                    <div class="ml-auto -mt-1">
                        <i class="ri-arrow-drop-down-fill ri-xl text-black"></i>
                    </div>
                </div>
                <div class="flex flex-col items-center">
                    @if ($file->filetype == 'image')                    
                        <a href="{{ url(Storage::url($constants['ROOTPATH'].$file->path)) }}" class="files openiframe selectapp" data-ext = "{{ $file->extension }}"
                            data-image="{{ $file->path }}" data-title="{{ $file->name }}"
                            data-url="{{ $file->path }}">
                            <img class="w-16 icondisplay" src="{{ url(Storage::url($constants['ROOTPATH'].$file->path)) }}" alt="{{ $file->name }}" />
                        </a>
                        @elseif($file->filetype == 'application')
                        @php
                        $extension = strtolower($file->extension); 
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

                    <a href="{{ url(Storage::url($constants['ROOTPATH'].$file->path)) }}" target="_blank" class="files openiframe selectapp"
                        data-ext="{{ $file->extension }}" data-title="{{ $file->name }}" data-url="{{ $file->path }}">
                        <img class="w-16 icondisplay" src="{{ $iconPath }}" alt="{{ $file->name }}" />
                    </a>
                    @elseif($file->filetype == 'video')
                        <a href="#" class="files openiframe selectapp" data-ext = "{{ $file->extension }}"
                            data-image="{{ $file->path }}" data-title="{{ $file->name }}"
                            data-url="{{ url(Storage::url($constants['ROOTPATH'].$file->path)) }}">
                            <video class="w-16 icondisplay" alt="{{ $file->name }}" />
                            <source src="{{ url(Storage::url($constants['ROOTPATH'].$file->path)) }}" type="video/mp4"></video>
                        </a>
                    @else
                        <img class="w-16 icondisplay "
                            src="{{ asset($constants['FILEICONPATH'] . $file->extension . '.png') }}"
                            alt="{{ $file->name }}" />
                    @endif
                    <div class="input-wrapper" id="inputWrapperdocument{{ base64UrlEncode($file->id) }}">
                        <input type="text" class="text-center text-black appinputtext" disabled
                            id="inputFielddocument{{ base64UrlEncode($file->id) }}" value="{{ $file->name }}">
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>
