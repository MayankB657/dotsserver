@foreach($files as $file)
    <tr class="h-16 border-t">
            <td class="px-2 py-3 flex items-center justify-center">
                    <div class="flex items-center justify-center w-8 h-8 rounded-full text-white font-semibold text-sm"
                        style="background-color: {{ '#' . substr(md5($file->name), 0, 6) }};">
                        {{ strtoupper(substr($file->name, 0, 1)) }}
                    </div>
                </td>

        <td class="font-normal text-c-black text-left pl-3">
            {{$file->name}}
        </td>
        <td class="font-normal text-c-black text-left pl-3 pr-3 md:pr-0">
            {{ (!empty($file->user->name)) ? $file->user->name : 'NA' }}
        </td>
      
            @if(filterView('route', 'restoretoadmin') || filterView('route', 'restoretouser') || filterView('route', 'dumpfile'))
            <td class="text-c-black text-left pl-3 whitespace-nowrap pr-3 md:pr-0 flex gap-4">
            @if(filterView('route', 'restoretouser'))
                <!-- Edit Icon -->
                <button class="restoreFile" data-user="{{ base64_encode($file->id) }}">
                    <i class="ri-edit-line ri-xl cursor-pointer"></i>
                </button>
            @endif
            
            <!-- Delete Icon -->
            @if(filterView('route', 'dumpfile'))
            <button class="deleteFile" data-id="{{ $file->id }}">
                <i class="ri-delete-bin-line ri-xl cursor-pointer text-red-500"></i>
            </button>
            @endif
            
        </td>
        @endif
    </tr>
@endforeach

@if($files->isEmpty())
    <tr>
        <td colspan="7" class="text-center py-4 font-semibold text-gray-500 bg-gray-100">
            {{ 'NO Records' }}
        </td>
    </tr>
@endif

<!-- Pagination Links -->
<div class="mt-4">
    {{ $files->links() }}
</div>
