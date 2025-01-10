            <div
                id="previewContent"
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
                      onclick="togglePanel('preview');"
                    >
                      <i class="ri-close-fill font-size-18"></i>
                    </button>
                  </div>
                </div>
                <!--chat list-->
                <div class="flex-1 overflow-auto scroll">
                  <iframe
                    src="http://web.simmons.edu/~grovesd/comm244/notes/week2/links"
                    class="w-full"
                    style="height: 55vh"
                    frameborder="0"
                  ></iframe>
                </div>
              </div>