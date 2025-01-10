<!--detailContent-->
              <div
                id="detailContent"
                class="absolute bottom-0 top-1 flex h-11/12 w-full flex-col hidden border-r bg-c-lighten-gray hidden font-size-14"
              >
                <div
                  class="sticky top-0 z-10 flex items-start justify-between border-b px-4 pb-2"
                >
                  <div class="flex items-end space-x-4">
                    <div class="flex-shrink-0">
                      <img
                        src="images/excel.svg"
                        alt="Document Image"
                        class="w-16 h-16"
                      />
                    </div>
                    <div class="flex flex-col justify-between">
                      <p>Document</p>
                      <p>561KB</p>
                      <p>Today 12:06</p>
                    </div>
                    <div class="space-x-4">
                      <button>
                        <i class="ri-star-line font-size-20"></i>
                      </button>
                      <button>
                        <i class="ri-pushpin-2-line font-size-20"></i>
                      </button>
                    </div>
                  </div>
                  <div>
                    <button
                      class="p-1 hover:text-dark-yellow"
                      onclick="togglePanel('detail');"
                    >
                      <i class="ri-close-fill font-size-18"></i>
                    </button>
                  </div>
                </div>
                <!--info content-->
                <div
                  class="flex-1 overflow-auto scroll tab-content donut-space active"
                  id="info"
                >
                  <!-- Content items -->
                  <div class="flex justify-start space-x-14 mt-2">
                    <p class="pl-5">Path</p>
                    <p>
                      Personal / Documents
                      <button><i class="ri-file-copy-2-line"></i></button>
                      <button><i class="ri-link"></i></button>
                    </p>
                  </div>
                  <div class="flex justify-start space-x-7 mt-2">
                    <p class="pl-5">Currently</p>
                    <p>
                      120 files&#40;121File, 1Folder&#41;
                      <button><i class="ri-information-2-line"></i></button>
                    </p>
                  </div>
                  <div class="flex justify-start space-x-14 mt-2">
                    <p class="pl-5">Size</p>
                    <p>797KB&#40;815,628 Byte&#41;</p>
                  </div>
                  <div class="flex justify-start space-x-7 mt-2">
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
                  </div>
                  <!-- Add more content here to ensure scrolling works -->
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
                  </div>
                </div>
                <!--chat content-->
                <!-- tabs -->
                <div class="flex items-center sticky bottom-0 z-10 border-t bg-c-lighten-gray relative">
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
                  <!--chat button tab-->
                </div>
              </div>