<!-- edit modal -->
        <div
          id="editModal"
          role="dialog"
          class="group-edit-modal fixed hidden inset-0 flex items-center justify-center bg-black bg-opacity-50 z-10"
        >
          <div
            class="bg-white rounded-2xl overflow-hidden shadow-lg max-w-xl w-full bg-c-lighten-gray modal-content"
          >
            <div
              class="sticky top-0 flex py-2 px-5 justify-between items-center border-b border-gray-3 bg-white z-10 text-c-black"
            >
              <div class="text-lg font-normal">@if(!empty($company->name)){{ $company->name}} -- @endif Edit Group</div>
              <button
                type="button"
                id="closeModalButton"
                class="group-edit-close py-1.5 rounded-md">
                <i class="ri-close-circle-fill text-black ri-lg"></i>
              </button>
            </div>
            <div div class="p-5 overflow-y-auto scroll" style="max-height: calc(100vh - 14rem)">
              <form class="flex flex-col gap-4 text-sm" action="{{ route('group-update',['id' => $group->id]) }}" method="POST">
                 @csrf
                <div class="flex flex-wrap w-full gap-y-4 items-center">
                  <label for="title" class="title font-bold text-c-black"
                    >Name: <span class="text-red-500">*</span></label
                  >
                  <div class="w-full sm:w-3/4 ml-auto">
                    <div class="relative w-full">
                      <input
                        class="w-full p-2 bg-c-lighten-gray border border-gray-3 rounded-xl outline-none pl-4"
                        type="text"
                        placeholder="Group 1"
                        name="name" value="{{ $group->name }}" maxlength="50"
                      />
                      <div
                        class="absolute inset-y-0 right-0 flex items-center border border-gray-3 w-12 rounded-r-xl pl-3"
                      >
                        <i class="ri-folder-5-fill ri-xl text-c-sky"></i>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="flex flex-wrap gap-y-4 items-start">
                  <div class="title font-bold text-c-black pt-3">
                    Space size:<span class="text-red-500">*</span>
                  </div>
                  <div class="w-full sm:w-3/4 ml-auto">
                    <div class="relative w-full">
                      <input
                        class="w-full p-2 bg-c-lighten-gray border border-gray-3 rounded-xl outline-none pl-4"
                        type="number"
                        placeholder="3"
                        name="sizeUse" value="{{ $group->sizeUse }}"
                      />
                      <div
                        class="absolute inset-y-0 right-0 flex items-center bg-c-gray-4 border border-gray-3 w-12 rounded-r-xl pl-3"
                      >
                        <p class="font-normal">GB</p>
                      </div>
                    </div>
                    <p class="text-xs text-c-black font-light mt-2">
                      0 is unlimited
                    </p>
                  </div>
                </div>
                <div class="flex justify-end mt-3">
                  <button type="submit" 
                    class="bg-c-black hover-bg-c-black text-white rounded-full w-32 py-2 text-sm"
                  >
                    Update
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>

<script>
  
  $('.group-edit-close').on('click', function (e) {
          $('.group-edit-modal').hide();
    });
</script>