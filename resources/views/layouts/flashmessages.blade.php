@session('success')
<div class="alert alert-danger alert-dismissible fade show absolute bg-green-500 right-3 top-20 h-12 rounded px-4 py-2 flex items-center gap-2 z-50" role="alert">
    <strong class="text-white"> {{ $value }}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="ri-close-fill ri-xl"></i></button>
</div> 
@endsession
      
@session('error')
<div class="alert alert-danger alert-dismissible fade show absolute bg-red-500 right-3 top-20 h-12 rounded px-4 py-2 flex items-center gap-2 z-50" role="alert">
    <strong class="text-white">{{ $value }}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="ri-close-fill ri-xl"></i></button>
</div>
@endsession
       
@session('warning')

@endsession
       
@session('info')

@endsession
      
@if ($errors->any())

@endif