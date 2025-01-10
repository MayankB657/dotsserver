 <!-- new user modal -->
 
 <div class="bg-white rounded-2xl overflow-hidden shadow-lg max-w-xl w-full bg-c-lighten-gray modal-content">
            <!-- Sticky header -->
            <div
                class="sticky top-0 flex py-2 px-5 justify-between items-center border-b border-gray-3 bg-white z-10 text-c-black">
                <div class="text-lg font-normal">Edit  User</div>
                <button type="button"  class="py-1.5 rounded-md closeModalButton">
                    <i class="ri-close-circle-fill text-black ri-lg"></i>
                </button>
            </div>
            <!-- Scrollable content -->
            @if(!empty($userdetail))
            <div class="p-5 overflow-y-auto scroll" style="max-height: calc(100vh - 10rem)">
                <form class="flex flex-col gap-4 text-sm" id="editUserForm" action="{{ route('company.user.update', ['user' => $userdetail->id]) }}" method="PUT">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-10 gap-4 items-start">
                        <div class="md:col-span-2 flex items-center">
                            <label for="company_id" class="block font-bold text-c-black">
                                Company:<span class="text-red-500">*</span>
                            </label>
                        </div>
                        <div class="md:col-span-8">
                            <select id="company_id" name="company" 
                                    class="w-full p-2 bg-c-lighten-gray border border-gray-3 rounded-xl outline-none pl-5 companychangelist">
                                <option value="" disabled selected>Select company</option>
                                @foreach($companies as $company)
                                    <option value="{{ base64_encode($company->id) }}" 
                                        {{ $userdetail->company_id == $company->id ? 'selected' : '' }}>
                                        {{ $company->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-red-500 mt-1 block"></small>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-10 gap-4 items-start">
                        <div class="md:col-span-2 flex items-center">
                            <label for="username" class="block font-bold text-c-black">
                                Username:<span class="text-red-500">*</span>
                            </label>
                        </div>
                        <div class="md:col-span-8">
                            <input id="username"
                                class="w-full p-2 bg-c-lighten-gray border border-gray-3 rounded-xl outline-none pl-5"
                                type="text" value="{{ $userdetail->username }}" placeholder="Please enter an username" autocomplete="username" name="username"
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
                                type="text" value="{{ $userdetail->name }}" placeholder="Please enter name" name="name" data-validate="name" />
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
                                type="email" value="{{ $userdetail->email }}" placeholder="Please enter email" autocomplete="email" name="email"
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
                                    type="password" value="" placeholder="Please enter password" name="password" data-validate="password" />
                                <small class="text-red-500 mt-1 block"></small>
                                <div
                                    class="absolute inset-y-0 right-0 flex items-center border border-gray-3 w-12 rounded-r-xl pl-3 pt-1 cursor-pointer togglePassword" style="height: 2.35rem;">
                                    <i class="ri-eye-line ri-xl toggleIcon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-10 gap-4 items-start">
                        <div class="md:col-span-2 flex items-center">
                            <label for="space-size" class="block font-bold text-c-black">
                                Space size:<span class="text-red-500">*</span>
                            </label>
                        </div>
                        <div class="md:col-span-8 flex items-center gap-2">
                            <div class="relative w-full">
                                <input id="space-size"
                                    class="w-full p-2 bg-c-lighten-gray border border-gray-3 rounded-xl outline-none pl-4"
                                    type="number" value="{{ $userdetail->sizeMax }}" placeholder="Please enter space size" name="sizeMax" min="0"
                                    max="500" />
                                <small class="text-red-500 mt-1 block"></small>
                                <div
                                    class="absolute inset-y-0 right-0 flex items-center bg-c-gray-4 border border-gray-3 w-12 rounded-r-xl pl-3" style="height: 2.35rem;">
                                    <p class="font-normal">GB</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-10 gap-4 items-start">
                        
                        <div class="md:col-span-2 flex items-center">
                            <label for="role" class="block font-bold text-c-black">
                                Role:<span class="text-red-500">*</span> {!! (empty($roles)) ? '<span class="text-red-500">Please add some Role </span>' : '' !!}
                            </label>
                        </div>
                        @if(!empty($roles))
                        <div class="md:col-span-8 flex items-center gap-2">
                            <div class="relative w-full">
                                <select id="role_id" name="role_id" class="w-full p-2 bg-c-lighten-gray border border-gray-3 rounded-xl outline-none pl-4 roleslist">
                                    <option value="" >Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" {{ ($userdetail->role_id==$role->id) ? 'selected' : ''}}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                <small class="text-red-500 mt-1 block"></small>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-10 gap-4 items-start">
                        <div class="md:col-span-2 flex items-center">
                            <label for="group" class="block font-bold text-c-black">
                                Group: <span class="text-red-500">*</span>{!! (empty($groups)) ? '<span class="text-red-500">Please add some Group </span>' : '' !!}
                            </label>
                        </div>
                        @if(!empty($groups))
                        <div class="md:col-span-8 flex items-center gap-2">
                            <div class="relative w-full">
                                <select id="group_id" class="w-full p-2 bg-c-lighten-gray border border-gray-3 rounded-xl outline-none pl-4 groupslist" name="group_id">
                                    <option value="" >Select Group</option>
                                    @foreach ($groups as $group)
                                        <option value="{{ $group->id }}" {{ ($userdetail->group_id==$group->id) ? 'selected' : ''}}>{{ $group->name }}</option>
                                    @endforeach
                                </select>
                                <small class="text-red-500 mt-1 block"></small>
                            </div>
                        </div>
                        @endif

                    </div>
                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-c-black hover:bg-c-black text-white rounded-full w-32 py-2 text-sm">
                            Update
                        </button>
                    </div>
                </form>
            </div>
            @endif
        </div>
    