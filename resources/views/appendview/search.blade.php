@if (count($results['files']) > 0)
    @foreach ($results['files'] as $filekey => $file)
        <div class="image-file border-t border-c-dark-gray mt-1 p-3">
            <h1 class="text-xl font-medium mb-2">{{ $filekey }}</h1>
            <ul>
                @foreach ($file as $filedet)
                    <a href="#" class="files openiframe selectapp" data-path ="{{ base64UrlEncode($filedet['path']) }}" data-appkey="{{ base64UrlEncode($filedet['openwith']) }}" data-filekey="{{ base64UrlEncode($filedet['id']) }}" data-filetype="file" data-apptype=" {{ (checkFileGroup($filedet['extension']) !='editor') ? 'app' : 'lightapp' }}">
                        <li class="flex items-center gap-4">
                            <img class="w-8 h-8 icondisplay"
                                src="{{ checkIconExist($filedet['extension'],'file')}}"
                                alt="{{ $filedet['name'] }}">
                            <p>{{ $filedet['name'] }}</p>
                        </li>
                    </a>
                @endforeach
            </ul>
        </div>
    @endforeach
@endif
@if (count($results['folders']) > 0)
    <div class="image-file border-t border-c-dark-gray mt-1 p-3">
        <h1 class="text-xl font-medium mb-2">Folder</h1>
        <ul>
            @foreach ($results['folders'] as $folder)
            <a href="#" data-path =" {{ base64UrlEncode($folder->path) }}" class="folders openiframe selectapp" data-appkey="{{ base64UrlEncode($folder->openwith) }}" data-filekey="{{ base64UrlEncode($folder->id) }}" data-filetype="folder" data-apptype="app"> 
                    <li class="flex items-center gap-4">
                        <img class="w-8 h-8 icondisplay" src="{{ checkIconExist('folder','folder') }}"
                            alt="{{ $folder->name }}">
                        <p>{{ $folder->name }}</p>
                    </li>
                </a>
            @endforeach
        </ul>
    </div>
@endif
@if (count($results['folders']) <= 0 && count($results['files']) <= 0)
    <div class="image-file mt-1 p-3">
        <h3 class="text-base font-medium mb-2">No result</h3>
    </div>
@endif
