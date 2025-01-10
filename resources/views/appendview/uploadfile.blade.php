<!--upload popup-->
          <div
            id="uploadPopup"
            class="fixed inset-0 flex z-20 items-center justify-center bg-gray-800 bg-opacity-50 hidden"
          >
            <div
              class="uploadPopup bg-c-white rounded-2xl shadow-lg md:w-9/12 lg:w-7/12 xl:w-6/12 2xl:w-2/5 max-w-7xl max-h-screen overflow-y-auto"
            >
              <div
                class="flex justify-between items-center border-b border-gray-3 px-6 p-4"
              >
                <h2 class="font-weight-500">Local Upload</h2>
                <button onclick="togglePopup('uploadPopup')">
                  <i class="ri-close-circle-fill ri-xl"></i>
                </button>
              </div>
              <form class="px-6 p-4" onsubmit="return false">
                <div
                  class="mb-4 flex flex-col md:flex-row items-center justify-between border-b border-gray-3 pb-4"
                >
                  <div class="w-full md:w-auto mb-4 md:mb-0 flex relative">
                    <input
                      type="button"
                      class="border border-r-0 rounded-l-lg p-2 px-4 bg-c-light-gray text-c-yellow border-c-light-gray"
                      value="Select the File"
                      onclick="event.stopPropagation();"
                    />
                    <button
                      class="border border-l-0 rounded-r-lg px-2 dropdown-btn border-c-light-gray"
                    >
                      <i class="ri-arrow-drop-down-line ri-xl"></i>
                    </button>
                    <div
                      class="dropdown-option absolute top-full left-32 md:left-3/4 mt-1 z-10 bg-c-white border border-c-medium-gray rounded-lg shadow-md hidden w-44"
                    >
                      <div class="hover-bg-c-yellow rounded-lg">
                        <a href="#" class="block p-2 pl-4 dropdown-item"
                          ><div class="flex">
                            <i class="ri-upload-2-line ri-lg pr-4 mt-1"></i>
                            <span>Upload Folder</span>
                          </div></a
                        >
                      </div>
                    </div>
                  </div>
                  <div
                    class="flex flex-wrap justify-start md:justify-end w-full md:w-auto"
                  >
                    <button
                      class="bg-c-light-black1 text-c-light-black hover-bg-c-yellow font-weight-500 px-6 py-2.5 rounded-md m-1 md:m-0 md:ml-2"
                      onclick="event.stopPropagation();"
                    >
                      Pause
                    </button>
                    <button
                      class="bg-c-light-black1 text-c-light-black hover-bg-c-yellow font-weight-500 px-6 py-2.5 rounded-md m-1 md:m-0 md:ml-2"
                      onclick="event.stopPropagation();"
                    >
                      Clear All
                    </button>
                    <button
                      class="bg-c-light-black1 text-c-light-black hover-bg-c-yellow font-weight-500 px-4 py-2.5 md:px-6 rounded-md m-1 md:m-0 md:ml-2"
                      onclick="event.stopPropagation();"
                    >
                      Cleared Out
                    </button>
                  </div>
                </div>
                <div
                  class="mb-4 overflow-y-auto h-56 w-full border border-gray-3 rounded-lg"
                >
                  <div
                    class="grid grid-cols-1 md:grid-cols-2 gap-1 p-2 px-4 border-b border-gray-3"
                  >
                    <div class="flex items-center">
                      <img src="images/powerpoint.svg" class="w-8 h-8 mr-2" />
                      <span>PowerPoint 560301.pptx </span>
                    </div>
                    <div class="flex items-center justify-start md:justify-end">
                      <span class="pr-3">158kbs</span>
                      <span>Uploaded Successfully</span>
                      <input
                        type="checkbox"
                        class="relative c-checkbox ml-2 h-4 w-4"
                      />
                    </div>
                  </div>
                  <div
                    class="grid grid-cols-1 md:grid-cols-2 gap-1 p-2 px-4 border-b border-gray-3"
                  >
                    <div class="flex items-center">
                      <img src="images/powerpoint.svg" class="w-8 h-8 mr-2" />
                      <span>PowerPoint 560301.pptx </span>
                    </div>
                    <div class="flex items-center justify-start md:justify-end">
                      <span class="pr-3">158kbs</span>
                      <span>Uploaded Successfully</span>
                      <input
                        type="checkbox"
                        class="relative c-checkbox ml-2 h-4 w-4"
                      />
                    </div>
                  </div>
                  <div class="flex items-center justify-center h-20 mt-5">
                    Drop File Here
                  </div>
                </div>
              </form>
            </div>
          </div>