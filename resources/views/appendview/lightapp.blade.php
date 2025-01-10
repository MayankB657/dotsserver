
 @foreach ($lightApps as $lightApp)
 <div class="small-container w-48 h-56 rounded-lg flex flex-col items-center justify-center gap-5">
    <div class="img-container w-16 h-16 rounded-lg bg-white shadow-black flex items-center justify-center">
        <img class="w-10 h-10" src="{{ asset($constants['APPFILEPATH'].$lightApp->icon) }}" alt="{{ $lightApp->name }} Image">
    </div>
    <h1 class="font-medium">{{ $lightApp->name }}</h1>
    <div class="relative">
        <button data-appid="{{ $lightApp->id }}" class="add-btn bg-black px-10 py-1 rounded-sm relative overflow-hidden flex items-start">
         Add
        </button>
        <a class="editoption" data-appid="{{ $lightApp->id }}"><i class="ri-arrow-down-s-line bg-white px-2 py-1 absolute top-0 right-0"></i></a>
    </div>
    <div id="buttoncontainer{{ $lightApp->id }}" class="hidden editbutton absolute top-20 bg-white p-4 rounded shadow-lg">
        <ul>
            <li class="mb-2"><button class="w-full py-2 text-left rounded hover:bg-gray-300"><i class="ri-edit-box-line"></i> Edit</button></li>
            <li class="mb-2"><button class="w-full py-2 text-left  rounded hover:bg-gray-300"><i class="ri-delete-bin-line"></i> Delete</button></li>
        </ul>
        
    </div>
 </div>
@endforeach