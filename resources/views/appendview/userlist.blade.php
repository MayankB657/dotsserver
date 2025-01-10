@foreach($users as $user)
 @if( ($user->cID == 0) && empty($user->type))
        @php continue;  @endphp
 @endif
 @if((Auth::user()->cID != 0) && ($user->type == "superadmin"))
        @php continue;  @endphp
 @endif
<tr class="h-16 border-t">
                      <td class="pl-3 px-2 flex items-center justify-center mt-6">
                        <input
                          type="checkbox"
                          class="c-checkbox"
                          name="options"
                          value="weak"
                        />
                      </td>
                      <td class="font-normal text-c-black text-left pl-3">
                        {{$user->name}}
                      </td>
                      <td
                        class="font-normal text-c-black text-left pl-3 pr-3 md:pr-0"
                      >
                        {{(!empty($user->roles->name))?$user->roles->name:'NA'}}
                      </td>
                      <td
                        class="font-normal text-c-black text-left pl-3 pr-3 md:pr-0"
                      >
                        <div
                          class="bg-c-light-black1 h-2 mb-2 rounded-lg overflow-hidden w-5/12"
                        >
                          <div
                            class="bg-c-yellow h-full rounded-r-full w-2/3"
                          ></div>
                        </div>
                        <span class="whitespace-nowrap"> {{$user->sizeMax}} GB </span>
                      </td>
                      <td
                        class="font-normal text-c-black text-left pl-3 whitespace-nowrap pr-3 md:pr-0"
                      >
                        {{(!empty($user->group->name))?$user->group->name:'NA'}}
                      </td>
                      <td>
                        <div class="cs flex relative text-sm gap-3 pl-3">
                            <div class="relative">
                                <button type="button" class="dropdown-btn">
                                  Action
                                <i class="ri-arrow-down-s-line"></i>
                                </button>
                                <div class="absolute text-xs dropdown-option z-10 min-w-full bg-gray-100 border rounded-md">
                                @if(!empty($filteredPermissions['userManagement']) && in_array('user-delete', $filteredPermissions['userManagement']) || Auth::user()->cID == 0)
                
                                    <button  class="suspend-user block rounded-t hover:bg-yellow-300 @php echo ($user->status == 0)?'bg-yellow-300':'' @endphp w-full px-2 py-1" data-id="{{ $user->id }}">
                                            Deactivated
                                    </button>
                                    
                                    <a href="{{ route('user-suspend',['id' => $user->id]) }}">
                                        <button  class="block hover:bg-yellow-300 @php echo ($user->status == 1)?'bg-yellow-300':'' @endphp w-full px-2 py-1">
                                        Active
                                        </button>
                                      </a>
                                      @endif
                                      @if(!empty($filteredPermissions['userManagement']) && in_array('user-edit', $filteredPermissions['userManagement']) || Auth::user()->cID == 0)
                                        <button  class="editUsers rounded-b block bg-white-300 w-full px-2 py-1 hover:bg-yellow-300" data-id="{{$user->id}}">
                                        Edit
                                        </button>
                                      @endif
                                </div>
                            </div>
                         </div>
                      </td>
                    </tr>
@endforeach
@if(empty($users))
 <tr><td>{{ 'NOT Found'}}</td></tr>
@endif
<script>
     //edit popup
                    
        $('table tr button.editUsers').on('click', function (e) {
          e.preventDefault();
          
      id = $(this).attr("data-id");
      $.ajax({
              url: 'user-edit',
              method: 'GET',
              data: {id:id},
              success: function (response) {
                  // Update the app list container with the updated list
                  $('#user-edit-div').html(response);
                  $('.user-edit-modal').removeClass('hidden');
              },
              error: function (xhr, status, error) {
                  console.error(xhr.responseText);
              }
          });
        
      });
      
      $('table td button.suspend-user').on('click', function (e) {
          e.preventDefault();
        $("#delete-modal").removeClass('hidden');
        var id = $(this).attr("data-id");
        var deleteroute = "user-suspend/"+ id;
        $("#deleteRole").attr("href",deleteroute);

        
      });
   
</script>