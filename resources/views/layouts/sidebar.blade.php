
<!-- sidebar -->
<aside class="h-full relative">
        <input type="checkbox" class="hidden" id="sidebar-toggle" />
        <label
          for="sidebar-toggle"
          class="absolute lg:hidden top-6 -right-8 px-1"
        >
          <i class="ri-bar-chart-horizontal-line"></i>
        </label>
        <div class="h-full sidebar">
          <div class="sidebar-container">
            <div class="p-4">
              <img class="w-20" src="{{ asset($constants['IMAGEFILEPATH'].'logo.png') }}" alt="Dots Logo"
              />
            </div>
            <div class="sidebar-content">
              <ul class="space-y-1">
                <li class="position">
                  <div
                    role="button"
                    onclick="toggleDropMenu(this)"
                    class="drop-menu cursor-pointer rounded-r-lg"
                  >
                    <a
                      class="w-full px-6 py-1 flex justify-between items-center bg-c-black text-c-yellow  rounded-r-xl"
                      href="#"
                    >
                      <span>Position (WIP)</span>
                      <i
                        class="ri-arrow-right-s-line text-c-yellow big-right-arrow text-2xl"
                      ></i>
                    </a>
                    <ul class="drop-list text-sm space-y-1">
                      <li class="starred">
                        <a
                          id="starred-link"
                          class="block py-1 px-8 rounded-r-md w-full flex justify-between items-center subdrop"
                          onclick="event.stopPropagation();toggleSubDropMenu();"
                        >
                          <span>Starred</span>
                          <i
                            class="ri-arrow-right-s-line text-c-yellow text-2xl subdrop-right-arrow"
                          ></i>
                        </a>
                        <ul
                          class="drop-list text-sm space-y-1 hidden"
                          id="subdrop-menu"
                        >
                          <li>
                            <a
                              href="#"
                              class="block py-1 pl-12 pr-10 rounded-r-md w-full flex justify-between items-center"
                              onclick="event.stopPropagation();"
                            >
                              <span>submenu1</span>
                              <i
                                class="ri-arrow-right-s-line text-c-yellow text-2xl"
                              ></i>
                            </a>
                          </li>
                          <li>
                            <a
                              href="#"
                              class="block py-1 pl-12 pr-10 rounded-r-md w-full flex justify-between items-center"
                              onclick="event.stopPropagation();"
                            >
                              <span>submenu2</span>
                              <i
                                class="ri-arrow-right-s-line text-c-yellow text-2xl"
                              ></i>
                            </a>
                          </li>
                        </ul>
                      </li>
                      <li>
                        <a
                          href="#"
                          class="block py-1 px-8 rounded-r-md w-full flex justify-between items-center"
                          onclick="event.stopPropagation();"
                        >
                          <span>Personal</span>
                          <i
                            class="ri-arrow-right-s-line text-c-yellow text-2xl"
                          ></i>
                        </a>
                      </li>
                      <li>
                        <a
                          href="#"
                          class="block py-1 px-8 rounded-r-md w-full flex justify-between items-center"
                          onclick="event.stopPropagation();"
                        >
                          <span>Group</span>
                          <i
                            class="ri-arrow-right-s-line text-c-yellow text-2xl"
                          ></i>
                        </a>
                      </li>
                      <li>
                        <a
                          href="#"
                          class="block py-1 px-8 rounded-r-md w-full flex justify-between items-center"
                          onclick="event.stopPropagation();"
                        >
                          <span>Collaborate with me</span>
                          <i
                            class="ri-arrow-right-s-line text-c-yellow text-2xl"
                          ></i>
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>
                <li>
                  <div
                    role="button"
                    onclick="toggleDropMenu(this)"
                    class="drop-menu cursor-pointer rounded-r-lg"
                  >
                    <div
                      class="w-full px-6 py-1 flex justify-between items-center"
                      href="#"
                    >
                      <span>Tools </span>
                      <i
                        class="ri-arrow-right-s-line text-c-yellow big-right-arrow text-2xl"
                      ></i>
                    </div>
                    <ul class="drop-list text-sm space-y-1">
                      <li>
                        <a
                          href="{{ route('linkshare') }}"
                          class="block py-1 px-8 rounded-r-md w-full flex justify-between items-center"
                        >
                          <span>Link Sharing</span>
                          <i
                            class="ri-arrow-right-s-line text-c-yellow text-2xl"
                          ></i>
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>
                <li>
                  <div
                    role="button"
                    onclick="toggleDropMenu(this)"
                    class="drop-menu cursor-pointer rounded-r-lg"
                  >
                    <div
                      class="w-full px-6 py-1 flex justify-between items-center"
                      href="#"
                    >
                      <span>File type</span>
                      <i
                        class="ri-arrow-right-s-line text-c-yellow big-right-arrow text-2xl"
                      ></i>
                    </div>
                  </div>
                </li>

                <li>
                  <div
                    role="button"
                    onclick="toggleDropMenu(this)"
                    class="drop-menu cursor-pointer rounded-r-lg"
                  >
                    <div
                      class="w-full px-6 py-1 flex justify-between items-center"
                      href="#"
                    >
                      <span>Tags</span>
                      <i
                        class="ri-arrow-right-s-line text-c-yellow big-right-arrow text-2xl"
                      ></i>
                    </div>
                  </div>
                </li>
                <li>
                  <div
                    role="button"
                    onclick="toggleDropMenu(this)"
                    class="drop-menu cursor-pointer rounded-r-lg"
                  >
                    <div
                      class="w-full px-6 py-1 flex justify-between items-center"
                      href="#"
                    >
                      <span>Network Driver</span>
                      <i
                        class="ri-arrow-right-s-line text-c-yellow big-right-arrow text-2xl"
                      ></i>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </aside>