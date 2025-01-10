
@foreach($roles as $role)
<!-- <tr>
        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300">{{$role->name}}</td>
        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300">{{$role->upload_limit}}</td>
        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300">{{$role->description}}</td>
        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300">
        <a href="#" data-id="{{$role->id}}" class="editRoles">Edit</a> &nbsp;
        <a href="{{ route('role-delete',['id' => $role->id]) }}">Delete</a>
        </td>
</tr> -->

<tr class="text-sm border-t h-14">
                      <td class="py-2 pl-3"> <input type="checkbox" class="c-checkbox"></td>
                      <td class="text-c-black pl-3">{{$role->name}}</td>
                      <td class="text-c-black pl-3">
                       <span class="taskbar py-1.5 text-center px-5 font-normal text-dark-black rounded-sm">System</span>
                      </td>
                      <td class="text-c-black pl-3">{{$role->description}}</td>
                      <td class="text-c-black pl-3">{{$role->updated_at}}</td>
                      <td class="text-c-black text-right pl-3">
                        <div
                          class="flex relative text-sm gap-3"
                        >
                          <div class="relative">
                            <button type="button" class="dropdown-btn">
                              Action
                              <i class="ri-arrow-down-s-line"></i>
                            </button>
                            <div
                              class="absolute text-xs dropdown-option z-10 min-w-full bg-gray-100 border rounded-md"
                            >
                              @if(!empty($filteredPermissions['roleManagement']) && in_array('role-delete', $filteredPermissions['roleManagement']) || Auth::user()->cID == 0) 
                              <button class="delete-role block hover:bg-yellow-300 w-full px-2 py-1" data-id="{{ $role->id }}">
                                Delete
                              </button>
                              @endif
                            </div>
                          </div>
                          @if(!empty($filteredPermissions['roleManagement']) && in_array('role-edit', $filteredPermissions['roleManagement']) || Auth::user()->cID == 0)               
                          <button class="editRoles text-c-sky openEditModalButton" data-id="{{$role->id}}">
                            Edit
                          </button>
                          @endif
                        </div>
                      </td>
                    </tr>
@endforeach
<script>
     //edit popup

      $('table td button.editRoles').on('click', function (e) {
        e.preventDefault();
        
    var id = $(this).attr("data-id");
    $.ajax({
            url: 'role-edit',
            method: 'GET',
            data: {id:id},
            success: function (response) {
                // Update the app list container with the updated list
                $('#role-edit-div').html(response);
                $('.role-edit-modal').removeClass('hidden');
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
      
    });

    $('table td button.delete-role').on('click', function (e) {
        e.preventDefault();
      $("#delete-modal").removeClass('hidden');
      var id = $(this).attr("data-id");
      var deleteroute = "role-delete/"+ id;
      $("#deleteRole").attr("href",deleteroute);

      
    });
</script>


