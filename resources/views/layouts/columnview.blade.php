<div id="tableContainer" class="hidden">
              <!--table container in mobile-->
              <div class="md:hidden" id="mobileList">
                <ul>
                  <li
                    class="flex items-center pl-2 pr-3.5 pt-3 pb-3 border-b border-c-medium-gray justify-between"
                  >
                    <div class="ml-4 flex-row">
                      <div class="flex items-center space-x-2">
                        <div class="flex-shrink-0">
                          <img
                            src="images/excel.svg"
                            alt="Document Image"
                            class="w-3/4"
                          />
                        </div>
                        <div class="flex flex-col justify-between">
                          <div class="font-weight-500">Testdocument.xls</div>
                          <div class=" ">08-14 01:10</div>
                        </div>
                      </div>
                    </div>
                    <div>
                      <i class="ri-more-fill"></i>
                    </div>
                  </li>
                  <li
                    class="flex items-center pl-2 pr-3.5 pt-3 pb-3 border-b border-c-medium-gray justify-between"
                  >
                    <div class="ml-4 flex-row">
                      <div class="flex items-center space-x-2">
                        <div class="flex-shrink-0">
                          <img
                            src="images/powerpoint.svg"
                            alt="Document Image"
                            class="w-3/4"
                          />
                        </div>
                        <div class="flex flex-col justify-between">
                          <div class="font-weight-500">Testdocument.pdf</div>
                          <div class=" ">08-14 01:10</div>
                        </div>
                      </div>
                    </div>
                    <div>
                      <i class="ri-more-fill"></i>
                    </div>
                  </li>
                </ul>
              </div>
              <!--table container in desktop-->
              <div
                class="m-6 overflow-x-auto rounded-lg hidden md:flex"
                id="deskList"
              >
                <table class="min-w-full bg-c-white rounded-lg shadow-lg">
                  <thead class="bg-c-dark-gray rounded-t-lg">
                    <tr class="text-left font-medium border-none text-c-white">
                      <th class="px-4 py-2">Name</th>
                      <th class="px-4 py-2">Type</th>
                      <th class="px-4 py-2">Size</th>
                      <th class="px-4 py-2">Modification</th>
                      <th class="px-4 py-2">Editor</th>
                      <th class="px-4 py-2">Creation</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="cursor-pointer text-left">
                      <td class="px-4 py-2">
                        <div class="flex items-center">
                          <img
                            src="images/excel.svg"
                            alt="Your Image"
                            class="w-8 h-6 pr-2"
                          />
                          Testdocument.xls
                        </div>
                      </td>
                      <td class="px-4 py-2">excel File</td>
                      <td class="px-4 py-2">236KB</td>
                      <td class="px-4 py-2">04-25 17:23</td>
                      <td class="px-4 py-2">
                        <div class="flex items-center">
                          <img
                            src="images/me.png"
                            alt="Your Image"
                            class="w-6 h-6 pr-1"
                          />Me
                        </div>
                      </td>
                      <td class="px-4 py-2">03-25 18:09</td>
                    </tr>
                    <tr class="cursor-pointer text-left">
                      <td class="px-4 py-2">
                        <div class="flex items-center">
                          <img
                            src="images/powerpoint.svg"
                            alt="Your Image"
                            class="w-8 h-6 pr-2"
                          />
                          Testdocument.pdf
                        </div>
                      </td>
                      <td class="px-4 py-2">pdf File</td>
                      <td class="px-4 py-2">236KB</td>
                      <td class="px-4 py-2">04-25 17:23</td>
                      <td class="px-4 py-2">
                        <div class="flex items-center">
                          <img
                            src="images/me.png"
                            alt="Your Image"
                            class="w-6 h-6 pr-1"
                          />Me
                        </div>
                      </td>
                      <td class="px-4 py-2">03-25 18:09</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>