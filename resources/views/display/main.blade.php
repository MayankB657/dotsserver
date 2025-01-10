@extends('layouts.backendsettings')
@section('title', 'Display')
@section('content')
<main class="w-full h-full flex cm account">

  <!-- Main content -->
  <div class="flex-grow border h-100 main">
    <div class="flex flex-col w-full h-full content">
      <div class="px-9 py-3.5 lg:py-6 lg:px-5">
        <div class="flex items-center gap-4">
          <i class="ri-settings-3-fill ri-xl"></i>
          <span class="text-lg text-c-black font-normal">Display</span>
        </div>
      </div>
      <!-- topTaskbar in desktop -->
      <div class="pl-4 md:pl-6 py-4 pr-4 md:pr-6 w-full flex flex-row justify-between items-center taskbar">
        <div class="w-full md:w-6/12 xl:w-8/12">
          <div class="flex items-center gap-1 sm:gap-2">
            <span class="text-c-light-black whitespace-nowrap font-normal">
              Display
            </span>
            <i class="ri-arrow-right-line ri-lg text-c-light-black"></i>
            <span class="font-semibold text-c-black">
              {{ ucfirst($type .' '. $title) }}
            </span>
            @if(!empty($company->name))
            <i class="ri-arrow-right-line ri-lg text-c-light-black"></i>
            <span class="font-semibold text-c-black">
              {{ $company->name }}
            </span>
            @endif
          </div>
        </div>

      </div>

      <!-- Content -->
      <div class="px-6">
        <div class="wallpapers p-6 border-t-2" id="wallpaper-content">
        </div>
      </div>
    </div>
</main>
<!-- Popup Container -->
<div id="imageUploadPopup" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
  <div class="bg-white rounded-lg shadow-lg w-96 p-6 relative">
    <!-- Close Button -->
    <button
      class="absolute top-2 right-2 text-black hover:text-gray-700 close-popup">
      <i class="ri-close-circle-line text-2xl"></i>
    </button>

    <!-- Popup Header -->
    <div class="flex items-center mb-4">
      <i class="ri-image-line text-2xl mr-2"></i>
      <h2 class="text-lg font-semibold text-black">Upload Image</h2>
    </div>

    <!-- Image Preview -->
    <form id="uploadForm" enctype="multipart/form-data">
      @csrf
      <div class="border border-gray-300 rounded-lg p-4 text-center">
        <h1 class="select-image font-bold capitalize">Select an wallpaper</h1>
        <img id="imagePreview" src="" loading="lazy" alt="Image Preview" class="hidden w-full h-48 object-cover mb-4 rounded-md">

      </div>
      <input type="hidden" id="wallpaper-type" name="type" value="{{ $type }}">
      <!-- Save Button -->
      <div class="flex items-center gap-3 justify-center mt-2">
        <label
          for="fileInput"
          class="block text-sm text-gray-600 cursor-pointer theme-yellow px-4 py-2 rounded-md font-medium shadow-md hover:opacity-90">
          Choose Image
        </label>
        <input name="image"
          type="file"
          id="fileInput"
          accept="image/*"
          class="hidden"
          onchange="previewImage(event)" />
        <button type="submit"
          class="px-4 py-2 theme-yellow rounded-md text-sm font-medium shadow-md hover:opacity-90">
          Save
        </button>
      </div>

    </form>
  </div>
</div>

@endsection

@section('scripts')
<script>
  const wallpaperlist = @json(route('wallpaperlist'));
  const getWallpaperUploadRoute = @json(route('wallpaper.store'));
  const updateUserWallpaperData = @json(route('wallpaper.update'));
  const type = @json($type);
</script>
<script src="{{ asset($constants['JSFILEPATH'] . 'wallpaper.js') }}"></script>
@endsection