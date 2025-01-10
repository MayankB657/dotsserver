@extends('layouts.common')
@section('title', 'Light App')
@section('styles')
    <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'].'lightapp.css') }}">
@endsection
@section('content')
    <div class="lightapp w-full h-screen">
      <div class="lightapp-container w-full flex">
        <div class="lightapp-sidebar h-full w-1/4 md:1/4 lg:w-1/6 bg-no-repeat bg-cover bg-center">
            <div class="lightapp-logo px-9 py-7">
                <a href="{{ route('dashboard') }}"><img class="w-16 h-16" src="{{ asset($constants['IMAGEFILEPATH'].'logo.png')}}" alt="logo"></a>
            </div>
             <nav>
              <ul class="grid gap-2">
                <li>
                  <a 
                    class="flex items-center gap-3 rounded-r-md py-3 bg-black text-sm hover:bg-black"
                    href="#"
                  >
                    <span id="All" class="text-base font-normal px-10">All</span>
                  </a>
                </li>
                @foreach ($categories as $category)

                <li>
                  <a  data-catid="{{ $category->id }}"
                    class="selectcategory flex items-center gap-3 rounded-r-md py-3 text-sm hover:bg-black"
                    href="#"
                  >
                    <span
                      class="text-base font-normal px-10"
                    >
                      {{ $category->name }}
                    </span>
                  </a>
                </li>
                @endforeach
            
              </ul>
            </nav>
        </div>
        <div class="right-container h-full w-3/4 md:3/4 lg:w-5/6 bg-no-repeat bg-cover">
            <div class="lightapp-header w-full h-28">
                <div class="flex items-center gap-2 py-3 px-6">
                    <img class="w-10 h-10" src="{{ asset($constants['IMAGEFILEPATH'].'lightimg.png')}}" alt="Light Image">
                    <h1 class="text-base font-normal mb-2">Light App</h1>
                </div>
                <div class="lightapp-yellowbar w-full h-12 bg-no-repeat bg-cover bg-center flex items-center justify-between px-7">
                    <span class="text-base font-medium">All</span>
                    <span>
                        <button class="lightapp-btn py-2 px-6 bg-black text-sm rounded-sm">Create a light application</button>
                    </span>
                </div>
            </div>
            <div id="lightappcontent" class="lightapp-content flex gap-10 flex-wrap p-5">
               
            </div>
        </div>
      </div>
    </div>
<script>
      const showLightApp = @json(route('showlightapp'));

</script>
@endsection

@section('scripts')
    <script src="{{ asset($constants['JSFILEPATH'].'lightapp.js') }}"></script>
@endsection
