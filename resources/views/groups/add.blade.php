<!-- New group Modal -->
<div class="bg-white rounded-2xl overflow-hidden shadow-lg max-w-xl w-full bg-c-lighten-gray modal-content">
    <!-- Sticky header -->
    <div
        class="sticky top-0 flex py-2 px-5 justify-between items-center border-b border-gray-3 bg-white z-10 text-c-black">
        <div class="text-lg font-normal">Add New Group</div>
        <button type="button" class="closeModalButton py-1.5 rounded-md">
            <i class="ri-close-circle-fill text-black ri-lg"></i>
        </button>
    </div>
    <!-- Scrollable content -->
    <div class="p-5 overflow-y-auto scroll" style="max-height: calc(100vh - 10rem)">
        <form class="flex flex-col gap-4 text-sm" id="newgroup" action="{{ route('groups.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-10 gap-4 items-start">
                <div class="md:col-span-2 flex items-center">
                    <label for="group_name" class="block font-bold text-c-black">
                        Group Name:<span class="text-red-500">*</span>
                    </label>
                </div>
                <div class="md:col-span-8">
                    
                    <input id="group_name"
                        class="w-full p-2 bg-c-lighten-gray border border-gray-3 rounded-xl outline-none pl-5"
                        type="text" placeholder="Enter Group name" name="group_name" required />
                    <small class="text-red-500 mt-1 block"></small>
                </div>
            </div>
            <h3>HOD<h3>
                    <div class="grid grid-cols-1 md:grid-cols-10 gap-4 items-start">
                        <div class="md:col-span-2 flex items-center">
                            <label for="username" class="block font-bold text-c-black">
                                Username:<span class="text-red-500">*</span>
                            </label>
                        </div>
                        <div class="md:col-span-8">
                            <input id="username"
                                class="w-full p-2 bg-c-lighten-gray border border-gray-3 rounded-xl outline-none pl-5"
                                type="text" placeholder="Please enter an username" autocomplete="username" name="username"
                                 data-validate="name" />
                            <small class="text-red-500 mt-1 block"></small>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-10 gap-4 items-start">
                        <div class="md:col-span-2 flex items-center">
                            <label for="name" class="block font-bold text-c-black">
                                Name:<span class="text-red-500">*</span>
                            </label>
                        </div>
                        <div class="md:col-span-8">
                            <input id="name"
                                class="w-full p-2 bg-c-lighten-gray border border-gray-3 rounded-xl outline-none pl-5"
                                type="text" placeholder="Please enter name" name="name" data-validate="name" />
                            <small class="text-red-500 mt-1 block"></small>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-10 gap-4 items-start">
                        <div class="md:col-span-2 flex items-center">
                            <label for="email" class="block font-bold text-c-black">
                                Email:<span class="text-red-500">*</span>
                            </label>
                        </div>
                        <div class="md:col-span-8">
                            <input id="email"
                                class="w-full p-2 bg-c-lighten-gray border border-gray-3 rounded-xl outline-none pl-5"
                                type="email" placeholder="Please enter email" autocomplete="email" name="email"
                                data-validate="email" />
                            <small class="text-red-500 mt-1 block"></small>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-10 gap-4 items-start">
                        <div class="md:col-span-2 flex items-center">
                            <label for="password" class="block font-bold text-c-black">
                                Password:<span class="text-red-500">*</span>
                            </label>
                        </div>
                        <div class="md:col-span-8 flex items-center gap-2">
                            <div class="relative w-full">
                                <input id="password"
                                    class="w-full p-2 bg-c-lighten-gray border border-gray-3 rounded-xl outline-none pl-4 password"
                                    type="password" placeholder="Please enter password" name="password" data-validate="password" />
                                <small class="text-red-500 mt-1 block"></small>
                                <div
                                    class="absolute inset-y-0 right-0 flex items-center border border-gray-3 w-12 rounded-r-xl pl-3 pt-1 cursor-pointer togglePassword" style="height: 2.35rem;">
                                    <i class="ri-eye-line ri-xl toggleIcon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-c-black hover:bg-c-black text-white rounded-full w-32 py-2 text-sm">
                    Create
                </button>
            </div>
        </form>
    </div>
</div>

