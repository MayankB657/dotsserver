
@if($wallpaperlist)
@foreach($wallpaperlist as $wallpaper)
<div class="relative flex wallpaper-div border border-gray overflow-hidden">
    <img class="object-cover w-full h-full" src="{{  asset($constants['THEMEPATH']).'/'. $wallpaper->flag .'/background.png'}}" data-id="{{ $wallpaper->id }}" alt="Theme" />

    <div class="absolute top-2 right-2">
        <input class="c-checkbox" type="checkbox" data-id="{{ $wallpaper->id }}" data-type="theme" {{ $userWallpaper && $wallpaper->id == $userWallpaper->theme_id ? 'checked' : '' }}>
    </div>
</div>
@endforeach
@endif