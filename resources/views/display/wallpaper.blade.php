<div id="add-div" class="open-popup rounded-2xl border border-c-yellow bg-c-lighten-gray flex flex-col gap-3 items-center justify-center">
    <div class="w-10 h-10 bg-c-yellow rounded-full flex items-center justify-center">
        <i class="ri-add-large-fill ri-lg"></i>
    </div>
    <span class="text-c-black font-medium text-sm sm:text-base">Add new wallpaper</span>
</div>
</div>
@if($wallpaperlist)
@foreach($wallpaperlist as $wallpaper)
<div class="relative flex wallpaper-div border border-gray overflow-hidden">
    <img class="object-cover w-full h-full" src="{{  asset($constants['WALLPAPERPATH']).'/'. $type .'/' .$wallpaper->image}}" data-id="{{ $wallpaper->id }}" alt="Wallpaper" />

    <div class="absolute top-2 right-2">
        <input class="c-checkbox" type="checkbox" data-id="{{ $wallpaper->id }}"   data-type="{{ $type }}"
        {{ $userWallpaper && ($wallpaper->id == $userWallpaper->dashboard_display || $wallpaper->id == $userWallpaper->login_display) ? 'checked' : '' }}>
    </div>

    <div class="absolute bottom-1 right-2">
        @if($wallpaper->default == 0)
        <form action="javascript:void(0);" class="delete-form" data-id="{{ $wallpaper->id }}" onsubmit="deleteWallpaper('{{ $wallpaper->id }}')">
            @csrf
            @method('DELETE')
            <button type="submit" class="delete-btn">
                <i class="text-c-yellow ri-delete-bin-6-line"></i>
            </button>
        </form>
        @endif
    </div>
</div>
@endforeach
@endif