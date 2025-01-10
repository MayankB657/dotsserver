
@foreach($permissions as $permission)

<tr class="h-14 border-t">
                    <td class="py-2 pl-3 pt-5 flex items-start"> <input type="checkbox" class="c-checkbox"></td>
                    <td
                      class="font-normal text-c-black text-left pl-3 align-top pt-4"
                    >
                      {{$permission->name}}
                    </td>
                    <td
                      class="font-normal text-c-black text-left pl-3 pr-5 align-top pt-4"
                    >
                      <span
                        class="taskbar py-1.5 text-center px-5 font-normal rounded-sm text-dark-black"
                        >System</span
                      >
                    </td>
                    <td
                      class="font-normal text-c-black text-left pl-3 pr-5 align-top pt-4"
                    >
                     {{$permission->permissions}}
                    </td>

                    <td
                      class="font-normal text-c-black text-left pl-3 align-top pt-4"
                    >
                      <div class="flex relative text-sm gap-2">
                        <div class="relative">
                          <button type="button" class="dropdown-btn">
                            Action&nbsp;<i class="ri-arrow-down-s-line"></i>
                          </button>
                          <div
                            class="absolute text-xs dropdown-option w-20 z-10 min-w-full space-y-1 border rounded-md overflow-hidden"
                          >
                            <button class="delete-role block hover:bg-yellow-300 w-full px-2 py-1" data-id="{{ $permission->id }}">
                                Delete
                              </button>

                            <!-- <button
                              class="block hover-bg-c-yellow w-full px-2 py-1"
                            >
                              Log
                            </button> -->
                          </div>
                        </div>
                        <button class="editUserpermission text-c-sky pr-5" data-id="{{$permission->id}}">
                          Edit
                        </button>
                      </div>
                    </td>
                  </tr>
@endforeach
<script>
     //edit popup

                     $('table td button.editUserpermission').on('click', function (e) {
                       e.preventDefault();
                       
                    id = $(this).attr("data-id");
                    $.ajax({
                            url: 'permission-edit',
                            method: 'GET',
                            data: {id:id},
                            success: function (response) {
                                // Update the app list container with the updated list
                                $('#permission-edit-div').html(response);
                                $('.permission-edit-modal').removeClass('hidden');
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
                      var deleteroute = "permission-delete/"+ id;
                      $("#deletePermission").attr("href",deleteroute);

                     
                    });
</script>