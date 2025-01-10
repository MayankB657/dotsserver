<style>
    .custom-bg-iframe{
    background: rgb(235 224 224 / 86%) !important;
  }
</style>

@if(!empty($iframeArray))

@foreach($iframeArray as $iframekey=>$iframeval)
@if(!empty($iframeval))
    <div class="relative parentiframe draggable-element">
                <div id="iframeicon{{ $iframeval[0]['filetype'].$iframeval[0]['appkey'] }}" data-popup-count="{{ count($iframeval) }}" data-iframefile-id = "{{ $iframeval[0]['filetype'].$iframeval[0]['filekey'] }}" data-iframe-id = "{{ $iframeval[0]['apptype'].$iframeval[0]['appkey'] }}" data-popup = "{{ $iframeval[0]['popup_page'] }}" data-path ="{{ $iframeval[0]['filepath'] }}" class="iframemainheadericon flex items-center justify-center text-white cursor-pointer"  style="transition: transform 0.2s ease-in-out;"  onmouseover="this.style.transform='scale(1.2)';" onmouseout="this.style.transform='scale(1)';">
                    <img class="app-icon" id ="iframeiconimage{{ $iframeval[0]['filetype'].$iframeval[0]['appkey'] }}" data-app-id ="iframeiconimage{{ $iframeval[0]['filetype'].$iframeval[0]['appkey'] }}" src="{{ checkIconExist($iframeval[0]['appicon'],'app') }}" >
                </div>
            @if(count($iframeval)>1)
                <div class="hidden iframetabselement fixed top-12 left-1/2 transform -translate-x-1/2" id="iframetab{{ $iframeval[0]['apptype'].$iframeval[0]['appkey'] }}">
                    <div class="flex flex-row-reverse space-x-2 space-x-reverse">
                    
                    
                    @foreach($iframeval as $iframefile)
        
                            <div class="custom-bg-iframe popup rounded shadow-md iframemainheaderpopup" id="iframefilepopupdet{{ $iframefile['filetype'].$iframefile['filekey'] }}"  data-popup-count="{{ count($iframeval) }}" data-iframefile-id = "{{ $iframefile['filetype'].$iframefile['filekey'] }}" data-iframe-id = "{{ $iframefile['apptype'].$iframeval[0]['appkey'] }}" data-popup = "{{ $iframefile['popup_page'] }}" data-path ="{{ $iframefile['filepath'] }}">
                                <div class="flex justify-between items-center">
                                    <div class="overflow-hidden scrollbar-hidden scroll-container max-w-full">
                                        <div class="whitespace-no-wrap flex text-black scroll-content items-center ">
                                            <img class="w-6" src="{{ checkIconExist($iframefile['appicon'],'app') }}"><span>{{ $iframefile['filename'] }}</span>
                                        </div>
                                    </div>
                                    <button class="iframefilepopupclosebtn -mt-6 text-gray-900 hover:text-gray-700" data-apptype="{{ $iframefile['apptype'] }}" data-filekey="{{ $iframefile['filekey'] }}" data-iframefile-id = "{{ $iframefile['filetype'].$iframefile['filekey'] }}" data-appkey="{{ $iframeval[0]['appkey'] }}" data-filetype="{{ $iframefile['filetype'] }}">
                                        <i class="ri-close-line"></i>
                                    </button>
                                </div>
                            </div>
                     @endforeach
       
                    </div>
                </div>
    @endif
            </div>
    @endif
     @endforeach
     @endif
