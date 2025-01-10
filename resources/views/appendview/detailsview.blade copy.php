<!-- new code for details start  -->
 <!--------- get data on checkbox checked on file or folder start  ---------------------------------------->
 @if($getFFId != "") 
 <!--panes1-->
    <div id="panel" class="resizable-sidebar  md:w-3/12 xl:w-1/5">
        <div class="resizer"></div>
        <!--detailContent-->
        <div id="detailContent" class="absolute bottom-0 top-1 flex h-11/12 w-full flex-col  border-r bg-c-lighten-gray  font-size-14">
            <div class="sticky top-0 z-10 flex items-start justify-between border-b px-4 pb-2" >
                
                <div class="flex items-end space-x-4">
                    <div class="flex-shrink-0">
                        @if(checkFileGroup($file->extension)=='image')
                            <img class="w-16 h-16" src="{{ url(Storage::url($constants['ROOTPATH'].$file->path)) }}" alt="{{ $file->name }}"/>
                        
                        @elseif(($file->extension)=='Absolute')
                        <img class="w-16 h-16" src="{{ asset($constants['FILEICONPATH'].'folder.png')}}" alt="{{ $file->name }}"/>
                        
                        @else
                            <img class="w-16 h-16" src="{{ checkIconExist($file->extension,'file')}}" alt="{{ $file->name }}"/>
                        @endif  
                        
                    </div> 
                                    
                </div>
            <div>                
            <button class="p-1 hover:text-dark-yellow"  onclick="togglePanel('detail');" >
                <i class="ri-close-fill font-size-18"></i>
            </button>
        </div>
    </div> 
    
    <!--info content-->
    <div  class="flex-1 overflow-auto scroll tab-content donut-space active" id="info" >
        <!-- Content items -->
        
        <div class="flex justify-start space-x-14 mt-2">
            <p class="pl-5">Path</p>
            <p>Home / {{$filepath}}</p>
        </div>       

        <div class="flex justify-start space-x-14 mt-2">
            <p class="pl-5">Size</p>
            <p>{{$size}}</p>
        </div>

        <div class="flex justify-start space-x-7 mt-2">
            <p class="pl-5">Creation</p>
            <p>{{ $file->created_at->format('Y-m-d H:i:s') }}</p>
        </div>

        <div class="flex justify-start space-x-1 mt-2 border-b pb-2">
            <p class="pl-5">Modification</p>
            <p>{{ $file->updated_at->format('Y-m-d H:i:s') }}</p>
        </div>

        <div class="flex justify-start space-x-8 mt-2">
            <p class="pl-5">Creator</p>
            <p class="flex items-start justify-center">                
                @if (Auth::user()->avatar != null)
                  <img class="w-5 h-5 rounded-full mr-2"
                      src="{{ url('/') }}/{{ Auth::user()->avatar }}" alt="user image" />
                @else
                    <img class="w-5 h-5 rounded-full mr-2" src="{{ asset($constants['IMAGEFILEPATH'] . 'profile.png') }}"
                        alt="user image" />
                @endif             
                {{ $userName }}
            </p>
        </div>     
         

        </div>
       
        
        <!--chat content-->
        <div class="flex-1 overflow-auto scroll tab-content donut-space relative" id="chat"  >
            <div class="commentssection absolute bottom-0 flex h-full flex-col border-r bg-c-lighten-gray w-full"  >               

                <!--chat list-->
                <div class="flex-1 overflow-auto scroll comment-list">
                    <div class="space-y-4 p-4">
                        <div class="grid gap-2 border-b">
                            @if ($commentsWithReceivers)  <!-- Check if $commentsWithReceivers has data -->
                                @foreach ($commentsWithReceivers as $commentWithReceiver)
                                    <div class="flex items-start gap-3">
                                        <div class="h-8 w-8 rounded-full">
                                            @if (Auth::user()->avatar != null)
                                                <img class="h-8 w-8 rounded-full"
                                                    src="{{ url('/') }}/{{ Auth::user()->avatar }}" alt="user image" />
                                            @else
                                                <img class="h-8 w-8 rounded-full" src="{{ asset($constants['IMAGEFILEPATH'] . 'profile.png') }}"
                                                    alt="user image" />
                                            @endif
                                        </div>
                                        <div class="flex-1 space-y-1">
                                            <div class="flex items-center justify-between">
                                                <div class="font-medium">{{ $userName }}</div>
                                                <div class="text-xs"></div>
                                            </div>
                                            <p>{{ $commentWithReceiver['comment']->message }}</p>  <!-- Display the comment message -->
                                        </div>
                                    </div>

                                    <!-- comment receiver area  -->
                                    @if ($commentWithReceiver['receivers']->isNotEmpty())
                                        <div class="ml-11 grid gap-2">
                                            @foreach ($commentWithReceiver['receivers'] as $receiver)
                                                <div class="flex items-start gap-3">
                                                    <div class="h-8 w-8 rounded-full">
                                                        <img
                                                            src="{{ asset($constants['IMAGEFILEPATH'] . 'profile.png') }}"  
                                                            alt="Avatar"
                                                            class="h-8 w-8 rounded-full"
                                                        />
                                                    </div>
                                                    <div class="flex-1 space-y-1">
                                                        <div class="flex items-center justify-between">
                                                            <div class="font-medium">{{ $receiver->name ?? 'Unknown' }}</div>  <!-- Display receiver's name, or fallback to 'Unknown' -->
                                                            <div class="text-xs">{{ $receiver->created_at->diffForHumans() }}</div>  <!-- Display receiver's comment time -->
                                                        </div>
                                                        <p>{{ $receiver->message }}</p>  <!-- Display the receiver's message -->
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                            
                        </div>
                       
                    </div>
                </div>             

            </div>
        </div>

        <!-- tabs -->
        <div class="flex items-center sticky bottom-0 z-10 border-t bg-c-lighten-gray relative" >
            <button
            type="button"
            onclick="showTab(this)"
            class="flex flex-col justify-center items-center space-y-1 tab-control styled text-sm p-2 px-5 active"
            data-tab="donut-space"
            data-control="info"
            >
            <i class="ri-information-line ri-lg"></i>
            <span>Info</span>
            </button>
            @if(($file->extension) != 'Absolute')
            <button
            type="button"
            onclick="showTab(this)"
            class="flex flex-col justify-center items-center space-y-1 tab-control styled text-sm p-2 px-5"
            data-tab="donut-space"
            data-control="chat"
            >
            <i class="ri-message-2-line ri-lg"></i>
            <span>Chat</span>
            </button>
            @endif

        </div>
    </div>

    <!--preview pane-->
    <div id="previewContent"  class="absolute bottom-0 top-1 flex h-11/12 w-full flex-col hidden border-r bg-c-lighten-gray hidden font-size-14">
        <div class="sticky top-0 z-10 flex items-start justify-between border-b px-4 pb-2"  >
           
            <div class="flex items-end space-x-4">
                <div class="flex-shrink-0">                   
                    @if(checkFileGroup($file->extension)=='image')
                        <img class="w-16 h-16" src="{{ url(Storage::url($constants['ROOTPATH'].$file->path)) }}" alt="{{ $file->name }}"/>
                    
                    @elseif(($file->extension)=='Absolute')
                    <img class="w-16 h-16" src="{{ asset($constants['FILEICONPATH'].'folder.png')}}" alt="{{ $file->name }}"/>
                    
                    @else
                        <img class="w-16 h-16" src="{{ checkIconExist($file->extension,'file')}}" alt="{{ $file->name }}"/>
                    @endif 
                </div>
                <div class="flex flex-col justify-between">
                    <p>Home / {{$filepath}}</p>
                    <p>{{$size}}</p>
                </div>               
            </div>           

            <!-- close btn  -->
            <div>
                <button
                    class="p-1 hover:text-dark-yellow"
                    onclick="togglePanel('preview');"
                >
                    <i class="ri-close-fill font-size-18"></i>
                </button>
            </div>

        </div>
        <!--chat list-->
        <div class="flex-1 overflow-auto scroll">
            <!-- <iframe
            src="http://web.simmons.edu/~grovesd/comm244/notes/week2/links"
            class="w-full"
            style="height: 55vh"
            frameborder="0"
            ></iframe> -->
        </div>
    </div>
 <!--------- get data on checkbox checked on file or folder end  ---------------------------------------->





 <!--------- get data on details and preview clicks start  --------------------------------------------->

 @else
    <!--panes-->
    <div id="panel" class="resizable-sidebar hidden md:w-3/12 xl:w-1/5">
        <div class="resizer"></div>
        <!--detailContent-->
        <div id="detailContent" class="absolute bottom-0 top-1 flex h-11/12 w-full flex-col border-r bg-c-lighten-gray hidden font-size-14">
            <div class="sticky top-0 z-10 flex items-start justify-between border-b px-4 pb-2" >
                @if($path == "/")
                <div class="flex items-end space-x-4">
                    <div class="flex-shrink-0">
                        <img
                        src="{{ asset($constants['IMAGEFILEPATH'] . 'Home.png') }}"
                        alt="Document Image"
                        class="w-16 h-16"
                        />
                    </div>
                    <div class="flex flex-col justify-between">
                        <!-- <p>Home </p> --> 
                        <p> </p>
                        <p> </p>
                        <!-- <p></p>
                        <p>Select a single folder to get more information and share your content</p> -->
                    </div>
                    <!-- <div class="space-x-4">
                        <button>
                        <i class="ri-star-line font-size-20"></i>
                        </button>
                        <button>
                        <i class="ri-pushpin-2-line font-size-20"></i>
                        </button>
                    </div> -->
                </div>
                @endif

                @if($filepath == "Document")
                <div class="flex items-end space-x-4">
                    <div class="flex-shrink-0">
                        <img
                        src="{{ asset($constants['IMAGEFILEPATH'] . 'apps/document.png') }}"
                        alt="Document Image"
                        class="w-16 h-16"
                        />
                    </div>   
                    <div class="flex flex-col justify-between">
                        <!-- <p>Document </p> -->
                        <p> </p>
                        <p> </p>
                    </div>                 
                </div>
                @endif

                @if($filepath == "Desktop")
                <div class="flex items-end space-x-4">
                    <div class="flex-shrink-0">
                        <img
                        src="{{ asset($constants['IMAGEFILEPATH'] . 'apps/desktop.png') }}"
                        alt="Document Image"
                        class="w-16 h-16"
                        />
                    </div>
                    <div class="flex flex-col justify-between">
                        <!-- <p>Desktop </p> -->
                        <p> </p>
                        <p> </p>
                    </div>
                </div>
                @endif

                @if($filepath == "Download")
                <div class="flex items-end space-x-4">
                    <div class="flex-shrink-0">
                        <img
                        src="{{ asset($constants['IMAGEFILEPATH'] . 'apps/download.png') }}"
                        alt="Document Image"
                        class="w-16 h-16"
                        />
                    </div>
                    <div class="flex flex-col justify-between">
                        <!-- <p>Download </p> -->
                        <p> </p>
                        <p> </p>
                    </div>
                </div>
                @endif

                @if($filepath == "RecycleBin")
                <div class="flex items-end space-x-4">
                    <div class="flex-shrink-0">
                        <img
                        src="{{ asset($constants['IMAGEFILEPATH'] . 'apps/bin.png') }}"
                        alt="Document Image"
                        class="w-16 h-16"
                        />
                    </div>
                    <div class="flex flex-col justify-between">
                        <p>RecycleBin </p>
                        <p> </p>
                        <p> </p>
                    </div>
                </div>
                @endif

            <div>
                
            <button class="p-1 hover:text-dark-yellow"  onclick="togglePanel('detail');" >
                <i class="ri-close-fill font-size-18"></i>
            </button>
        </div>
    </div>

    <!--info content-->
    <div  class="flex-1 overflow-auto scroll tab-content donut-space active" id="info" >
        <!-- Content items -->
        @if($path == "/")
        <div class="flex justify-start space-x-14 mt-2">
            <p class="pl-5">Path</p>
            <p>
                Home
                <!-- <button><i class="ri-file-copy-2-line"></i></button>
                <button><i class="ri-link"></i></button> -->
            </p>
        </div>

        <div class="flex justify-start space-x-7 mt-2">
            <p class="pl-5">Currently</p>
            <p>
            {{ $allFileFolderCount }} items
                <!-- 120 files&#40;121File, 1Folder&#41; -->
                <!-- <button><i class="ri-information-2-line"></i></button> -->
            </p>
        </div>

        <div class="flex justify-start space-x-7 mt-2">
            <p class="pl-5">Total Size</p>
            <p>{{ $totalSpecifiedSizeFormatted  }}</p>
        </div>

        <div class="flex justify-start space-x-7 mt-2"><br><hr> </div>

        <div class="flex justify-start space-x-7 mt-2">
            <p class="pl-5">Desktop</p>
            <p>{{$sizeDesktopFormatted}}</p>
        </div>
        
        <div class="flex justify-start space-x-7 mt-2">
            <p class="pl-5">Document</p>
            <p>{{$sizeDocumentsFormatted}}</p>
        </div>

        <div class="flex justify-start space-x-7 mt-2">
            <p class="pl-5">Download</p>
            <p>{{$sizeDownloadsFormatted}}</p>
        </div>

        <div class="flex justify-start space-x-7 mt-2">
            <p class="pl-5">Recyclebin</p>
            <p>{{$sizeRecycleBinFormatted}}</p>
        </div>
        <!-- <div class="flex justify-start space-x-7 mt-2">
            <p class="pl-5">Creation</p>
            <p>2024-09-21 13:47</p>
        </div>

        <div class="flex justify-start space-x-1 mt-2 border-b pb-2">
            <p class="pl-5">Modification</p>
            <p>Today 01:10</p>
        </div>

        <div class="flex justify-start space-x-8 mt-2">
            <p class="pl-5">Creator</p>
            <p class="flex items-start justify-center">
                <img
                src="images/me.png"
                alt="Creator Image"
                class="w-5 h-5 rounded-full mr-2"
                />Me
            </p>
        </div>

        <div class="flex justify-start space-x-11 mt-2">
            <p class="pl-5">Editor</p>
            <p class="flex items-start justify-center">
                <img
                src="images/me.png"
                alt="Editor Image"
                class="w-5 h-5 rounded-full mr-2"
                />Me
            </p>
        </div>

        <div class="flex justify-start space-x-3 mt-2 border-b pb-2">
            <p class="pl-5">Description</p>
            <p>
                Add document description
                <button><i class="ri-edit-2-fill"></i></button>
            </p>
        </div>

        <div class="flex justify-between mt-2">
            <p class="pl-5 font-semibold">File tag</p>
            <p>
                <i class="ri-bookmark-3-line pr-3"></i>
            </p>
        </div>

        <div class="flex justify-start space-x-11 mt-2">
            <p class="pl-5">No tags, click settings</p>
        </div> -->
        
        <!-- file tag-->
        <!-- <div class="mt-10">
            <div class="flex justify-between mt-2">
                <p class="pl-5 font-semibold">File tag</p>
                <p>
                <i class="ri-bookmark-3-line pr-3"></i>
                </p>
            </div>
            <div class="flex justify-start space-x-11 mt-2">
                <p class="pl-5">No tags, click settings</p>
            </div>
        </div>
        <div class="mt-10">
            <div class="flex justify-between mt-2">
                <p class="pl-5 font-semibold">File tag</p>
                <p>
                <i class="ri-bookmark-3-line pr-3"></i>
                </p>
            </div>
            <div class="flex justify-start space-x-11 mt-2">
                <p class="pl-5">No tags, click settings</p>
            </div>
        </div> -->

        </div>
        @endif


        @if($filepath == "Desktop")
            <div class="flex justify-start space-x-14 mt-2">
                <p class="pl-5">Path</p>
                <p>Home / {{$filepath}}</p>
            </div>

            <div class="flex justify-start space-x-7 mt-2">
                <p class="pl-5">Currently</p>
                <p>{{ $totalItemCount }} items </p>
            </div>

            <div class="flex justify-start space-x-14 mt-2">
                <p class="pl-5">Size</p>
                <p>{{ $sizeDesktopFormatted  }}</p>
            </div>
            </div>
        @endif

        @if($filepath == "Document")
            <div class="flex justify-start space-x-14 mt-2">
                <p class="pl-5">Path</p>
                <p>Home / {{$filepath}}</p>
            </div>

            <div class="flex justify-start space-x-7 mt-2">
                <p class="pl-5">Currently</p>
                <p>{{ $totalItemCount }} items </p>
            </div>

            <div class="flex justify-start space-x-14 mt-2">
                <p class="pl-5">Size</p>
                <p>{{ $sizeDocumentsFormatted  }}</p>
            </div>
            </div>
        @endif

        @if($filepath == "Download")
            <div class="flex justify-start space-x-14 mt-2">
                <p class="pl-5">Path</p>
                <p>Home / {{$filepath}}</p>
            </div>

            <div class="flex justify-start space-x-7 mt-2">
                <p class="pl-5">Currently</p>
                <p>{{ $totalItemCount }} items </p>
            </div>

            <div class="flex justify-start space-x-14 mt-2">
                <p class="pl-5">Size</p>
                <p>{{ $sizeDownloadsFormatted  }}</p>
            </div>
            </div>
        @endif

        @if($filepath == "RecycleBin")
            <div class="flex justify-start space-x-14 mt-2">
                <p class="pl-5">Path</p>
                <p>Home / {{$filepath}}</p>
            </div>

            <div class="flex justify-start space-x-7 mt-2">
                <p class="pl-5">Currently</p>
                <p>{{ $totalFileCount }} items </p>
            </div>

            <div class="flex justify-start space-x-14 mt-2">
                <p class="pl-5">Size</p>
                <p>{{ $sizeRecycleBinFormatted  }}</p>
            </div>
            </div>
        @endif
    

        <!--chat content-->
        <div class="flex-1 overflow-auto scroll tab-content donut-space relative" id="chat"  >
            <div class="commentssection absolute bottom-0 flex h-full flex-col border-r bg-c-lighten-gray w-full"  >               

                <!--chat list-->
                <!-- <div class="flex-1 overflow-auto scroll comment-list">
                    <div class="space-y-4 p-4">
                        <div class="grid gap-2 border-b">
                            <div class="flex items-start gap-3">
                                <div class="h-8 w-8 rounded-full">
                                    <img
                                    src="images/profile.png"
                                    alt="Avatar"
                                    class="h-8 w-8 rounded-full"
                                    />
                                </div>
                                <div class="flex-1 space-y-1">
                                    <div class="flex items-center justify-between">
                                        <div class="font-medium">John</div>
                                        <div class="text-xs">10-07-2024 10:45</div>
                                    </div>
                                    <p>
                                    This is a great document! I have a few
                                    suggestions...
                                    </p>                                    
                                </div>
                            </div>

                            <div class="ml-11 grid gap-2">
                                <div class="flex items-start gap-3">
                                    <div class="h-8 w-8 rounded-full">
                                        <img
                                            src="images/profile.png"
                                            alt="Avatar"
                                            class="h-8 w-8 rounded-full"
                                        />
                                    </div>
                                    <div class="flex-1 space-y-1">
                                        <div class="flex items-center justify-between">
                                            <div class="font-medium">Sarah Anderson</div>
                                            <div class="text-xs">1 hour ago</div>
                                        </div>
                                        <p>
                                            I agree, those are great suggestions. Let me
                                            add a few more...
                                        </p>                                        
                                    </div>
                                </div>
                            </div>

                            <div class="ml-11 grid gap-2">
                                <div class="flex items-start gap-3">
                                    <div class="h-8 w-8 rounded-full">
                                        <img
                                            src="images/profile.png"
                                            alt="Avatar"
                                            class="h-8 w-8 rounded-full"
                                        />
                                    </div>
                                    <div class="flex-1 space-y-1">
                                        <div class="flex items-center justify-between">
                                            <div class="font-medium">Sarah Anderson</div>
                                            <div class="text-xs">1 hour ago</div>
                                        </div>
                                        <p>
                                            I agree, those are great suggestions. Let me
                                            add a few more...
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid gap-2">
                            <div class="flex items-start gap-3">
                            <div class="h-8 w-8 rounded-full">
                                <img
                                src="images/profile.png"
                                alt="Avatar"
                                class="h-8 w-8 rounded-full"
                                />
                            </div>
                            <div class="flex-1 space-y-1">
                                <div class="flex items-center justify-between">
                                <div class="font-medium">John Doe</div>
                                <div class="text-xs">10-07-2024 10:45</div>
                                </div>
                                <p>
                                This is a great document! I have a few
                                suggestions...
                                </p>
                            </div>
                            </div>
                            <div class="ml-11 grid gap-2">
                            <div class="flex items-start gap-3">
                                <div class="h-8 w-8 rounded-full">
                                <img
                                    src="images/profile.png"
                                    alt="Avatar"
                                    class="h-8 w-8 rounded-full"
                                />
                                </div>
                                <div class="flex-1 space-y-1">
                                <div class="flex items-center justify-between">
                                    <div class="font-medium">Sarah Anderson</div>
                                    <div class="text-xs">1 hour ago</div>
                                </div>
                                <p>
                                    I agree, those are great suggestions. Let me
                                    add a few more...
                                </p>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div> -->

                <!--Add comment-->
                <!-- <div id="addcomment1"  class="addcomment flex items-center gap-x-2 sticky bottom-0 z-10 border-t px-4 py-2 hidden bg-c-lighten-gray relative">
                    <div class="w-3/4">
                        <div  class="mention-container relative bg-c-white border border-gray-3 p-2 rounded-lg"  >
                            <div
                            contenteditable="true"
                            class="mention-textbox w-full h-20 overflow-auto focus:outline-none"
                            placeholder="Type your message here1..."
                            ></div>
                            <div
                            class="mention-list absolute bottom-full h-28 overflow-y-auto mb-2 left-0 w-full bg-c-white border border-gray-3 rounded-lg shadow-lg mt-1 hidden"
                            >
                            <ul class="list list-none"> </ul>
                            </div>
                        </div>
                    </div>
                    <button class="border px-3 hover-bg-c-black hover-text-c-yellow text-sm py-1 rounded border-gray-600 bg-c-yellow">
                        Post
                    </button>
                </div> -->

            </div>
        </div>

        <!-- tabs -->
        <div class="flex items-center sticky bottom-0 z-10 border-t bg-c-lighten-gray relative" >
            <button
            type="button"
            onclick="showTab(this)"
            class="flex flex-col justify-center items-center space-y-1 tab-control styled text-sm p-2 px-5 active"
            data-tab="donut-space"
            data-control="info"
            >
            <i class="ri-information-line ri-lg"></i>
            <span>Info</span>
            </button>
            
            <!-- <button
            type="button"
            onclick="showTab(this)"
            class="flex flex-col justify-center items-center space-y-1 tab-control styled text-sm p-2 px-5"
            data-tab="donut-space"
            data-control="chat"
            >
            <i class="ri-message-2-line ri-lg"></i>
            <span>Chat</span>
            </button> -->

        </div>
    </div>

    <!--preview pane-->
    <div id="previewContent"  class="absolute bottom-0 top-1 flex h-11/12 w-full flex-col hidden border-r bg-c-lighten-gray hidden font-size-14">
        <div class="sticky top-0 z-10 flex items-start justify-between border-b px-4 pb-2"  >
            @if($path == "/")
            <div class="flex items-end space-x-4">
                <div class="flex-shrink-0">
                    <img
                    src="{{ asset($constants['IMAGEFILEPATH'] . 'Home.png') }}"
                    alt="Document Image"
                    class="w-16 h-16"
                    />
                </div>
                <div class="flex flex-col justify-between">
                    <p>Home ({{ $allFileFolderCount }} items)</p>
                    <p>{{ $totalSpecifiedSizeFormatted  }}</p>
                    <!-- <p>Select a single folder to get more information and share your content</p> -->
                </div>
                <!-- <div class="space-x-4">
                    <button>
                    <i class="ri-star-line font-size-20"></i>
                    </button>
                    <button>
                    <i class="ri-pushpin-2-line font-size-20"></i>
                    </button>
                </div> -->
            </div>
            @endif


            @if($filepath == "Desktop")
            <div class="flex items-end space-x-4">
                <div class="flex-shrink-0">
                    <img
                    src="{{ asset($constants['IMAGEFILEPATH'] . 'apps/desktop.png') }}"
                    alt="Document Image"
                    class="w-16 h-16"
                    />
                </div>
                <div class="flex flex-col justify-between">
                    <p>Desktop ({{ $totalItemCount }} items)</p>
                    <p>{{ $sizeDesktopFormatted  }}</p>
                </div>                
            </div>
            @endif

            @if($filepath == "Document")
            <div class="flex items-end space-x-4">
                <div class="flex-shrink-0">
                    <img
                    src="{{ asset($constants['IMAGEFILEPATH'] . 'apps/document.png') }}"
                    alt="Document Image"
                    class="w-16 h-16"
                    />
                </div>
                <div class="flex flex-col justify-between">
                    <p>Document ({{ $totalItemCount }} items)</p>
                    <p>{{ $sizeDocumentsFormatted  }}</p>
                </div>                
            </div>
            @endif

            @if($filepath == "Download")
            <div class="flex items-end space-x-4">
                <div class="flex-shrink-0">
                    <img
                    src="{{ asset($constants['IMAGEFILEPATH'] . 'apps/download.png') }}"
                    alt="Document Image"
                    class="w-16 h-16"
                    />
                </div>
                <div class="flex flex-col justify-between">
                    <p>Download ({{ $totalItemCount }} items)</p>
                    <p>{{ $sizeDownloadsFormatted  }}</p>
                </div>                
            </div>
            @endif

            @if($filepath == "RecycleBin")
            <div class="flex items-end space-x-4">
                <div class="flex-shrink-0">
                    <img
                    src="{{ asset($constants['IMAGEFILEPATH'] . 'apps/bin.png') }}"
                    alt="Document Image"
                    class="w-16 h-16"
                    />
                </div>
                <div class="flex flex-col justify-between">
                    <p>RecycleBin ({{ $totalFileCount }} items)</p>
                    <p>{{ $sizeRecycleBinFormatted  }}</p>
                </div>                
            </div>
            @endif

            <!-- close btn  -->
            <div>
                <button
                    class="p-1 hover:text-dark-yellow"
                    onclick="togglePanel('preview');"
                >
                    <i class="ri-close-fill font-size-18"></i>
                </button>
            </div>

        </div>
        <!--chat list-->
        <div class="flex-1 overflow-auto scroll">
            <!-- <iframe
            src="http://web.simmons.edu/~grovesd/comm244/notes/week2/links"
            class="w-full"
            style="height: 55vh"
            frameborder="0"
            ></iframe> -->
        </div>
    </div>
</div>

<!-- new code for details end  -->


<script>
  const togglePanel = (view) => {
    if (view === "detail") {
        if ($("#panel").hasClass("hidden") || $("#detailContent").hasClass("hidden")) {
            $("#panel").removeClass("hidden");
            $("#detailContent").removeClass("hidden");
            $("#previewContent").addClass("hidden");
        } else {
            $("#panel").addClass("hidden");
        }
    } else if (view === "preview") {
        if ($("#panel").hasClass("hidden") || $("#previewContent").hasClass("hidden")) {
            $("#panel").removeClass("hidden");
            $("#previewContent").removeClass("hidden");
            $("#detailContent").addClass("hidden");
        } else {
            $("#panel").addClass("hidden");
        }
    } 
};
</script>
@endif
 <!--------- get data on details and preview clicks end  --------------------------------------------->
