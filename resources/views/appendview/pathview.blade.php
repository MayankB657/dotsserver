<style>
    .selected {
        border: 2px blue;
        background-color: rgba(173, 216, 230, 0.5);
    }
</style>

<!-- pathview -->
<div class="flex flex-wrap gap-4 p-6 gridview">
    <!-- Check if both $defaultfolders and $files are empty and display a message -->
    @if($defaultfolders->isEmpty() && $files->isEmpty())
    <div class="text-center w-full">
        <p class="text-gray-500">No folders or files found.</p>
    </div>
    @else
    <!-- shows default folders; desktop, document, download, recyclebin -->
    @foreach ($defaultfolders as $dfolder)
    <div class="app maindesktopapp w-32 h-28 cursor-pointer relative" data-option="all" draggable="true"
        data-filekey="{{ base64UrlEncode($dfolder->id) }}" data-path="{{ base64UrlEncode($dfolder->path) }}" data-folder="1"
        ondragstart="drag(event)" ondragover="allowDrop(event)" ondrop="drop(event)">
        <a href="{{ url('filemanager/'.base64UrlEncode($dfolder->path))}}" class="systemapp selectapp showappoptions" data-appkey="{{ base64UrlEncode($dfolder->id) }}" data-filekey="{{ base64UrlEncode($dfolder->id) }}" data-filetype="app" data-apptype="app">
            <div class="fixed w-full app-tools absolute flex item-center gap-8 px-2 invisible showappoptions top-1 left-2">
                <input type="checkbox" class="appcheckbox" id="checkboxsystemapp{{ base64UrlEncode($dfolder->id) }}">
                <div class="ml-auto -mt-1">
                    <i class="ri-arrow-drop-down-fill ri-xl text-black"></i>
                </div>
            </div>
            <div class="flex flex-col items-center imagewraper">
                <img class="w-16 icondisplay" loading="lazy" src="{{ checkIconExist($dfolder->icon,'app') }}" alt="{{ $dfolder->name }}" />
                <div class="input-wrapper" id="inputWrappersystemapp{{ base64UrlEncode($dfolder->id) }}">
                    <input type="text" class="text-center text-black appinputtext" disabled id="inputFieldsystemapp{{ base64UrlEncode($dfolder->id) }}" value="{{ $dfolder->name }}">
                </div>
            </div>
        </a>
    </div>
    @endforeach

    <!-- shows folders and files -->
    @foreach ($files as $file)
    @if($file->folder == 1)
    <div class="app maindesktopapp w-32 h-28 cursor-pointer relative" data-option="file" draggable="true"
        data-filekey="{{ base64UrlEncode($file->id) }}" data-folder="{{ $file->folder }}"
        ondragstart="drag(event)" ondragover="allowDrop(event)" ondrop="drop(event)" data-path="{{ base64UrlEncode($file->path) }}">
        <a href="{{ url('filemanager/'.base64UrlEncode($file->path)) }}" class="folders selectapp" data-path="{{ base64UrlEncode($file->path) }}" data-appkey="{{ base64UrlEncode($file->openwith) }}" data-filekey="{{ base64UrlEncode($file->id) }}" data-filetype="folder" data-apptype="app">
            <div class="fixed w-full app-tools absolute flex item-center gap-8 px-2 invisible showappoptions top-1 left-2">
                <input type="checkbox" class="appcheckbox" id="checkboxfolder{{ base64UrlEncode($file->id) }}">
                <div class="ml-auto -mt-1">
                    <i class="ri-arrow-drop-down-fill ri-xl text-black"></i>
                </div>
            </div>
            <div class="flex flex-col items-center imagewraper">
                <img class="w-16 icondisplay" loading="lazy" src="{{ asset($constants['FILEICONPATH'].'folder.png') }}" alt="{{ $file->name }}" />
                <div class="input-wrapper" id="inputWrapperfolder{{ base64UrlEncode($file->id) }}">
                    <input type="text" class="text-center text-black appinputtext" disabled id="inputFieldfolder{{ base64UrlEncode($file->id) }}" value="{{ $file->name }}">
                </div>
            </div>
        </a>
    </div>
    @else
    <div class="app maindesktopapp w-32 h-28 cursor-pointer relative" data-option="file" draggable="true"
        data-filekey="{{ base64UrlEncode($file->id) }}" ondragstart="drag(event)">
        <a href="#" class="files openiframe selectapp" data-path="{{ base64UrlEncode($file->path) }}" data-appkey="{{ base64UrlEncode($file->openwith) }}" data-filekey="{{ base64UrlEncode($file->id) }}" data-filetype="file" data-apptype="{{ (checkFileGroup($file->extension) !='editor') ? 'app' : 'lightapp' }}">
            <div class="fixed w-full app-tools absolute flex item-center gap-8 px-2 invisible showappoptions top-1 left-2">
                <input type="checkbox" class="appcheckbox" id="checkboxdocument{{ base64UrlEncode($file->id) }}">
                <div class="ml-auto -mt-1">
                    <i class="ri-arrow-drop-down-fill ri-xl text-black"></i>
                </div>
            </div>
            <div class="flex flex-col items-center imagewraper">
                @if(checkFileGroup($file->extension) == 'image')
                <img class="w-16 icondisplay" loading="lazy" src="{{ url(Storage::url($constants['ROOTPATH'].session('userstoragepath').$file->path)) }}" alt="{{ $file->name }}" />
                @else
                <img class="w-16 icondisplay" loading="lazy" src="{{ checkIconExist($file->extension, 'file') }}" alt="{{ $file->name }}" />
                @endif
                <div class="input-wrapper" id="inputWrapperfile{{ base64UrlEncode($file->id) }}">
                    <input type="text" class="text-center text-black appinputtext" disabled id="inputFieldfile{{ base64UrlEncode($file->id) }}" value="{{ $file->name }}">
                </div>
            </div>
        </a>
    </div>
    @endif
    @endforeach
    @endif
</div>
<script>
    var moveUrl = "{{ route('file.move') }}";
</script>
