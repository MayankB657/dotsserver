@if(!empty($iframeArray))
@foreach($iframeArray as $iframekey=>$iframeval)
    @foreach($iframeval as $iframedetail)
        @if(!empty($iframedetail))
            <!-- Iframe Popup -->
            <div id="iframepopup{{ $iframedetail['filetype'].$iframedetail['filekey'] }}" class="draggableelement draggable-clock box popupiframe fixed inset-0 bg-black-900 bg-opacity-50 flex items-center justify-center rounded-lg hidden">
                <div class="bg-opacity-70 shadow-lg w-full h-full relative">
                    <div class="flex justify-between items-center p-1 pr-2 border-b bg-c-gray-gradient">
                        <span class="text-lg font-semibold flex">
                            <img class="w-5 h-5 mt-1" src="{{ checkIconExist($iframedetail['appicon'], 'app') }}"/>
                            <h2 class="text-white ml-2 font-medium">{{ $iframedetail['appname'] }}</h2>
                        </span>
                        <div class="flex space-x-1">
                            <a href="#" class="minimizeiframe-btn" data-iframe-id="{{ $iframedetail['filetype'].$iframedetail['filekey'] }}">
                                <img src="{{ asset($constants['IMAGEFILEPATH'].'minimize'.$constants['ICONEXTENSION'])}}"/>
                            </a>
                            <a href="#" class="maximizeiframe-btn" data-iframe-id="{{ $iframedetail['filetype'].$iframedetail['filekey'] }}">
                                <img src="{{ asset($constants['IMAGEFILEPATH'].'maximize'.$constants['ICONEXTENSION'])}}"/>
                            </a>
                            <a href="#" class="closeiframe-btn" data-filekey="{{ $iframedetail['filekey'] }}" data-iframe-id="{{ $iframedetail['filetype'].$iframedetail['filekey'] }}" data-appkey="{{ $iframedetail['appkey'] }}" data-filetype="{{ $iframedetail['filetype'] }}" data-apptype="{{ $iframedetail['apptype'] }}">
                                <img src="{{ asset($constants['IMAGEFILEPATH'].'close'.$constants['ICONEXTENSION'])}}"/>
                            </a>
                            <input type="hidden" name="filekey" id="filekey" value="{{ $iframedetail['filekey'] }}" />
                        </div>
                    </div>

                    @if ($iframedetail['extension'] == 'editor')
                        <!-- Comment Section -->
                        <div class="commentssection absolute bottom-0 top-9 flex h-11/12 flex-col border-r bg-c-lighten-gray hidden md:w-1/3 font-size-14">
                            <div class="resizer absolute top-0 right-0 w-1 h-full bg-gray-300 cursor-ew-resize"></div>
                            <div class="sticky top-0 z-10 flex items-center justify-between border-b px-4 py-2">
                                <h3 class="font-medium text-lg">Comments</h3>
                                <div>
                                    <button class="pr-2 comment-button" onclick="togglePane('.addcomment')" data-type="comment">
                                        <i class="ri-chat-new-line ri-lg"></i>
                                    </button>
                                    <button onclick="togglePane('.commentssection')">
                                        <i class="ri-close-fill ri-lg"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="flex-1 overflow-auto comment-list" id="message_view"></div>
                            <!-- Add Comment -->
                            <div class="addcomment sticky bottom-0 z-10 border-t px-4 py-2 hidden bg-c-lighten-gray relative">
                                <textarea placeholder="Write a new comment..." class="commentTextarea w-full rounded-md border p-2 text-sm focus:outline-none bg-transparent" rows="4"></textarea>
                                <button class="postButton border px-3 py-1 rounded text-sm bg-c-yellow">Post</button>
                            </div>
                        </div>
                    @endif

                    <!-- Iframe -->
                     @if($iframedetail['is_popup'])
                        @include($iframedetail['popup_page'])
                     @else
                     <iframe id="iframe{{ $iframedetail['filetype'].$iframedetail['filekey'] }}" src="{{ $iframedetail['iframeurl'] }}" class="w-full h-full frame"></iframe>
                     @endif
                    @if ($iframedetail['extension'] == 'editor')
                        <div class="absolute bottom-5 left-5 bg-gray-300 rounded-full px-2 py-1 commentbutton">
                            <button class="comment" data-filekey="{{ $iframedetail['filetype'].$iframedetail['filekey'] }}" onclick="togglePane('.commentssection')">
                                <i class="ri-chat-4-line ri-lg"></i>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
            <!-- End Iframe Popup -->
        @endif
    @endforeach
@endforeach
@endif

