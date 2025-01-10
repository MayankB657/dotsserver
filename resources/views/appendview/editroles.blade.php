<!--Add Modal -->
      <div
        id="add-modal"
        role="dialog"
        class="role-edit-modal fixed hidden inset-0 flex items-center justify-center bg-black bg-opacity-50 add"
      >
        <div class="bg-white rounded-xl max-w-xl shadow-lg w-full mx-auto">
          <div class="flex justify-between items-center py-2 px-5 border-b">
            <h1 class="text-lg font-medium text-c-black" id="staticBackdropLabel">Edit Role</h1>
            <i
              class="roles-edit-close ri-close-circle-fill ri-lg cursor-pointer"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></i>
          </div>
          <form autocomplete="on" id="editroles-form" action="{{ route('role-update',['id' => $role->id]) }}" method="POST">
            @csrf
          <div
            class="p-4 overflow-y-auto scroll"
            style="max-height: calc(100vh - 8rem)"
          >
              <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <div class="md:col-span-2">
                  <label for="name" class="block font-bold text-c-black"
                    >Name:<span class="text-red-500">*</span></label
                  >
                </div>
                <div class="md:col-span-10 md:pr-28">
                  <input
                    id="name"
                    name = "name"
                    class="w-full p-2 bg-c-lighten-gray border border-gray rounded-xl outline-none pl-5 "
                    type="text"
                    placeholder="Please enter an username"
                    autocomplete="name" value="{{ $role->name }}" required
                  />
                </div>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mt-4">
                <div class="md:col-span-2">
                  <h3 class="block font-bold text-c-black">Display:</h3>
                </div>
                <div class="md:col-span-10 flex items-center gap-4">
                  <label for="toggle" class="toggle-switch flex items-center cursor-pointer">
                      <div class="relative">
                                                <input type="checkbox" id="toggle" class="sr-only">
                                                <div class="block toggle-bg w-14 h-7 rounded-full border"></div>
                                                <div
                                                    class="dot absolute left-0.5 top-0.5 bg-white w-6 h-6 rounded-full transition shadow-lg">
                                                </div>
                                            </div>
                                        </label>
                  <p class="text-sm text-c-black font-light">
                    Whether to display when setting user role
                  </p>
                </div>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mt-4">
                <div class="md:col-span-2 flex items-center">
                  <label for="filesize" class="block font-bold text-c-black"
                    >File size:<span class="text-red-500">*</span></label
                  >
                </div>
                <div class="md:col-span-10 flex items-center gap-2 md:pr-2">
                  <div class="relative w-full">
                    <input
                      id="filesize"
                      name="upload_limit"
                      class="w-full p-2 bg-c-lighten-gray border border-gray rounded-xl outline-none pl-4"
                      type="number"
                      placeholder="Please upload file size" value="{{ $role->upload_limit }}" required
                      min="0" max="400"
                    />
                    <div
                      class="absolute inset-y-0 right-0 flex items-center bg-c-gray-4 border border-gray w-10 rounded-r-xl pl-2"
                    >
                      <p class="font-normal">GB</p>
                    </div>
                  </div>
                  <p class="text-sm text-c-black font-light">(GB) 0 is unlimited</p>
                </div>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mt-4">
                <div class="md:col-span-2 flex items-start">
                  <label for="roleDescription" class="block font-bold text-c-black"
                    >Role description:<span class="text-red-500">*</span></label
                  >
                </div>
                <div class="md:col-span-10 md:pr-28">
                  <textarea
                    id="roleDescription"
                     name="description"
                    class="w-full p-2 bg-c-lighten-gray border border-gray rounded-xl"
                    rows="4" 
                  >{{ $role->description }}</textarea>
                </div>
              </div>
              <hr class="my-4" />
              <div>
                <div class="flex justify-center">
                  <button
                    type="button"
                    class="title-btn px-8 py-2 bg-c-yellow text-c-black rounded"
                  >
                    Permissions
                  </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mt-4">
                  <div class="md:col-span-2 flex items-start">
                    <h3 class="block font-bold text-c-black">Assign Permission:</h3>
                  </div>
                  <div class="md:col-span-10 md:pr-28">
                  <div class="custom-dropdown w-full">
                      <select id="roleID" name="permissionID" >
                      <option value="">Select Permission</option>
                         @foreach($permissions as $permission)
                         <option value="{{ $permission->id }}" @php echo ($permission->id == $role->permissionID)?'selected':'' @endphp>{{ $permission->name }}</option>
                         @endforeach
                      </select>
                  </div>  
                </div>
              </div>
              <div class="flex justify-end p-4">
            <button class="bg-c-black text-white px-12 py-2 rounded-full">
              Update
            </button>
          </div>
          </div>       
          </form>
        </div>
      </div>
<script src="{{ asset($constants['JSFILEPATH'] . 'custom-dropdown.js') }}"></script>
<script>
  
  $('.roles-edit-close').on('click', function (e) {
          $('.role-edit-modal').hide();
    });
 
 //roles edit form validation
    document.getElementById('editroles-form').addEventListener('submit', function (e) {
      e.preventDefault();
      const form = e.target;
      if (FormValidation.validateForm(form)) {
        console.log('Form submitted successfully');
        document.getElementById("editroles-form").submit();
      } else {
        console.log('Form validation failed');
      }
    });
</script>