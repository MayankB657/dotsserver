  <!-- listview  -->
  <div class="m-6 rounded-lg hidden md:flex listview" id="deskList" >
    <table class="min-w-full bg-c-white rounded-lg shadow-lg">
      <thead class="bg-c-dark-gray rounded-t-lg">
        <tr class="text-left font-medium border-none text-c-white">
          <th class="px-4 py-2 w-80">Name</th>
          <th class="px-4 py-2">Type</th>
          <th class="px-4 py-2">Size</th>
          <th class="px-4 py-2">Modification</th>
          <th class="px-4 py-2">Editor</th>
          <th class="px-4 py-2">Creation</th>
        </tr>
      </thead>
    

      @foreach ($files as $file)
      @if($file->folder==1)
      <tbody>
        <tr class="cursor-pointer text-left">
          <td class="px-4 py-2">
            <div class="app listview maindesktopapp cursor-pointer relative" data-option="recyclebin">

            <a href="#" class="systemapp selectapp showappoptions" data-appkey="{{ base64UrlEncode($file->openwith) }}" data-filekey="{{ base64UrlEncode($file->id) }}" data-filetype="folder" data-apptype="app">           
          
              
                <div class="fixed w-full app-tools absolute flex item-center gap-8 px-2 invisible showappoptions">
                  <input type="checkbox" class="appcheckbox" id="checkboxsystemapp{{ base64UrlEncode($file->id) }}">
                  <div class="ml-auto -mt-1">
                      <i class="ri-arrow-drop-down-fill ri-xl text-black"></i>
                  </div>
                </div>
                <div class="flex flex-row items-center pr-5 pl-8 imagewraper">
                      <img class="w-8 icondisplay" src="{{ asset($constants['FILEICONPATH'].'folder.png')}}" alt="{{ $file->name }}"/>                  

                    <div class="input-wrapper" id="inputWrappersystemapp{{ base64UrlEncode($file->id) }}">
                      <input type="text" class="text-center text-black appinputtext" disabled id="inputFieldsystemapp{{ base64UrlEncode($file->id) }}" value="{{ $file->name }}">
                  </div>

                </div>
              </a>
            </div>
          </td>
          <td class="px-4 py-2">{{ $file->extension }}</td>
          <td class="px-4 py-2">{{ folderSize(session('userstoragepath').$file->path) }}</td>                
          <td class="px-4 py-2">{{ $file->updated_at->format('Y-m-d H:i:s') }}</td>
          <td class="px-4 py-2">
            <div class="flex items-center">
            @if (Auth::user()->avatar != null)
                  <img class="w-6 h-6 pr-1"
                      src="{{ url('/') }}/{{ Auth::user()->avatar }}" alt="user image" />
              @else
                  <img class="w-6 h-6 pr-1" src="{{ asset($constants['IMAGEFILEPATH'] . 'profile.png') }}"
                      alt="user image" />
              @endif 
              {{ Auth::user()->name }}
            </div>
          </td>
          <td class="px-4 py-2">{{ $file->created_at->format('Y-m-d H:i:s') }}</td>
        </tr>                    
      </tbody>
      @else
      <tbody>
        <tr class="cursor-pointer text-left">
          <td class="px-4 py-2">
            <div class="app maindesktopapp cursor-pointer relative" data-option="recyclebin">

            <a href="#" class="systemapp selectapp  showappoptions" data-path =" {{ base64UrlEncode($file->path) }}" data-appkey="{{ base64UrlEncode($file->openwith) }}" data-filekey="{{ base64UrlEncode($file->id) }}" data-filetype="file" data-apptype="{{ (checkFileGroup($file->extension) !='editor') ? 'app' : 'lightapp' }}">

              
                <div class="fixed w-full app-tools absolute flex item-center gap-8 px-2 invisible showappoptions">
                  <input type="checkbox" class="appcheckbox" id="checkboxsystemapp{{ base64UrlEncode($file->id) }}">
                  <div class="ml-auto -mt-1">
                      <i class="ri-arrow-drop-down-fill ri-xl text-black"></i>
                  </div>
                </div>
                <div class="flex flex-row items-center pr-5 pl-8 imagewraper">
                      
                      @if(checkFileGroup($file->extension)=='image')
                      <img class="w-8 icondisplay" src="{{ url(Storage::url($constants['ROOTPATH'].session('userstoragepath').'Recycle Bin/'.base64UrlEncode($file->id . $file->name . $file->created_by).$file->name)) }}" alt="{{ $file->name }}"/> 
                      @else
                          <img class="w-8 icondisplay " src="{{ checkIconExist($file->extension,'file')}}" alt="{{ $file->name }}"/>
                      @endif                   

                    <div class="input-wrapper" id="inputWrappersystemapp{{ base64UrlEncode($file->id) }}">
                      <input type="text" class="text-center text-black appinputtext" disabled id="inputFieldsystemapp{{ base64UrlEncode($file->id) }}" value="{{ $file->name }}">
                  </div>

                </div>
              </a>
            </div>
          </td>
          <td class="px-4 py-2">{{ $file->extension }}</td>
          <td class="px-4 py-2">{{ formatBytes($file->size) }}</td>                
          <td class="px-4 py-2">{{ $file->updated_at->format('Y-m-d H:i:s') }}</td>
          <td class="px-4 py-2">
            <div class="flex items-center">
              @if (Auth::user()->avatar != null)
                  <img class="w-6 h-6 pr-1"
                      src="{{ url('/') }}/{{ Auth::user()->avatar }}" alt="user image" />
              @else
                  <img class="w-6 h-6 pr-1" src="{{ asset($constants['IMAGEFILEPATH'] . 'profile.png') }}"
                      alt="user image" />
              @endif             
              {{ Auth::user()->name }}
            </div>
          </td>
          <td class="px-4 py-2">{{ $file->created_at->format('Y-m-d H:i:s') }}</td>
        </tr>                    
      </tbody>
      @endif 
      @endforeach
    </table>
  </div>

  