<!DOCTYPE html>
@extends('layouts.common')
@section('title', 'Dashboard')
@section('styles')
    <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'].'dashbord.css') }}">
    <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'].'filemanager.css') }}">

@endsection
@section('content')
<div class="mainrightscreen desktop w-full h-screen mainscreen">
    @include('dashboardtest')
</div>
<div class="filemanager w-full h-screen mainscreen hidden">
    @include('filemanagertest')
</div>
 <!--///// iframe -->
    <div id="alliframelist">
        
    </div>
    <!--//// iframe end-->
<!--iframe icon-->
     <!-- Header -->
    <header id="iframeheaders" class="transparent p-2 text-white flex justify-center items-center fixed top-0 left-0 right-0 desktop mainscreen">
        
    </header>


@endsection
@section('scripts')
    <script>
      const desktopapp = @json(route('desktopapp'));
      const createFolderRoute = @json(route('createfolder'));
      const createFileRoute = @json(route('createfile'));
      const showFileDetail = @json(route('showpathdetail'));

      let path = 'Desktop';
              //return  // Remove the # symbol
    document.addEventListener('DOMContentLoaded', (event) => {
        let screen = window.location.hash.substring(1);
        if(screen){
            $('.mainscreen').addClass('hidden');
            $('.'+screen).removeClass('hidden');
        }else{
            $('.mainscreen').addClass('hidden');
            $('.desktop').removeClass('hidden');
        }

    });
    document.addEventListener("DOMContentLoaded", () => {
           document.querySelector('.newfiledropdown').addEventListener('click', function() {
        document.querySelector('.newfiledropdownoption').classList.toggle('hidden');
      });
           
        const links = {
          'desktop.html': 'link-desktop',
          'Recent.html': 'link-recent',
          'downloads.html': 'link-downloads',
          'filemanager.html': 'link-filemanager',
          'documents.html': 'link-documents',
          'applications.html': 'link-applications'
        };

        const currentPage = window.location.pathname.split('/').pop();

        const activeLinkId = links[currentPage];
        if (activeLinkId) {
          const activeLink = document.getElementById(activeLinkId);
          if (activeLink) {
            activeLink.classList.add('bg-black', 'text-orange-500', 'font-semibold');
          }
        }
      

     showapathdetail(path);
        
        function showapathdetail(path){
            $.ajax({
                url: showFileDetail,
                method: 'GET',
                data: {path:path},
                success: function (response) {
                    // Update the app list container with the updated list
                    $('.loaddetails').html(response.html);
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
            
            
        }
        
    
            
       });


    </script>
    <script src="{{ asset($constants['JSFILEPATH'].'dashboard.js') }}"></script>
    <script src="{{ asset($constants['JSFILEPATH'].'filemanager.js') }}"></script>

@endsection
