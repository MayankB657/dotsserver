@extends('layouts.backendsettings')
@section('title', 'Profile')
@section('styles')
    <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'] . 'common.css') }}">
@endsection
@section('content')
    <div class="w-full h-full flex account">
        <div class="flex-grow border h-100 main">
            <div class="flex flex-col w-full h-full content">
                <!-- Navbar -->
                <div class="px-2 lg:px-5 py-6">
                    <div class="flex items-center gap-4">
                        <i class="ri-settings-3-fill ri-xl"></i>
                        <span class="text-lg text-color-nav-black">User Profile</span>
                    </div>
                </div>
                <!-- top taskbar -->
                <div class="taskbar bg-no-repeat bg-cover bg-center flex items-center justify-between px-3 sm:px-6 py-4">
                    <div class="flex items-center gap-4 w-full md:w-1/2">
                        <div class="flex gap-1 sm:gap-2 items-center">
                            <span class="text-c-black font-medium">Account</span>
                        </div>
                    </div>
                </div>
                <!-- Content -->
                <div class="w-full h-full px-3 sm:px-6">
                    <div class="py-4 flex items-center justify-between border-b stroke-color avatar">
                        <div class="w-28">
                            <span class="text-base font-bold text-c-black">Avatar:</span>
                        </div>
                        <div class="flex-grow w-full relative">
                            <img id="profileImage" class="w-14 h-14 rounded-full object-cover cursor-pointer"
                                src="{{ url('/') }}/{{ $user->avatar }}" alt="Profile Image" />
                            <div class="absolute top-9 left-10 bg-white border rounded-full h-5 w-5 flex items-center justify-center cursor-pointer"
                                onclick="document.getElementById('fileInput').click()">
                                <i class="ri-pencil-line ri-sm"></i>
                            </div>

                        </div>

                        <!-- Hidden File Input -->
                        <div>
                            <form action="{{ route('profile.store') }}" method="POST" enctype="multipart/form-data"
                                id="profileForm">
                                @csrf
                                <input type="hidden" name="type" value="photo">
                                <input id="fileInput" type="file" class="hidden" name="profile" accept="image/*"
                                    onchange="handleFileChange(event)" />
                            </form>
                        </div>
                    </div>
                    <!-- For nickname -->
                    <div class="border-b stroke-color nickname">
                        <div class="py-4 flex flex-col sm:flex-row items-start relative">
                            <div class="w-28">
                                <label for="nickname-input" class="text-base font-bold text-c-black">Name:</label>
                            </div>
                            <div class="flex-grow flex items-start justify-between w-full edit-nickname">
                                <div class="w-full">
                                    <form action="{{ route('profile.store') }}" method="POST" id="FormUsername"
                                        class="formprofile">
                                        @csrf
                                        <input type="hidden" name="type" value="username">
                                        <div
                                            class="flex items-start sm:items-center flex-col sm:flex-row gap-1 sm:gap-2 w-full form-group">
                                            <input type="text" class="text-c-black font-normal text-base sm:text-lg"
                                                disabled value="{{ $user->username }}" name="username" />
                                            <p class="text-xs sm:text-sm font-light text-c-black pl-1 sm:pl-0"></p>
                                        </div>
                                        <small class="text-red-500 mt-1 block"></small>
                                        <div class="mt-2 flex gap-4 sm:gap-6 usernameFormButtons hidden">
                                            <button class="bg-c-black text-white rounded-full px-10 py-1 sm:px-14 sm:py-2"
                                                type="submit">OK</button>
                                            <button type="reset" onclick="disableNicknameEdit()"
                                                class="cancel-btn text-c-yellow px-8 py-1 sm:px-12 sm:py-2 rounded-full border border-c-yellow">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="absolute right-0">
                                <button class="text-2xl enablenicknameedit" onclick="enableNicknameEdit()">
                                    <i class="ri-edit-line"></i>
                                </button>
                                <i class="ri-close-circle-fill ri-lg cursor-pointer hidden disableNicknameEdit"
                                    onclick="disableNicknameEdit()"></i>
                            </div>
                        </div>
                    </div>
                    <!-- For email -->
                    <div class="border-b stroke-color email">
                        <div class="py-4 flex flex-col sm:flex-row items-start relative">
                            <div class="w-28">
                                <span for="email" class="text-base font-bold text-c-black">Email:</span>
                            </div>
                            <div class="flex-grow flex items-start justify-between w-full edit-email">
                                <div class="w-full">
                                    <span class="font-normal text-base sm:text-lg currentemail">{{ $user->email }}</span>
                                    <div class="divemail hidden">
                                        <form action="{{ route('profile.store') }}" method="POST" class="formprofile"
                                            id="FormEmail">
                                            @csrf
                                            <input type="hidden" name="type" value="email">
                                            <div
                                                class="flex flex-col lg:flex-row items-start lg:items-center gap-1 sm:gap-2 w-full">
                                                <input type="text"
                                                    class="enabled-input text-c-black font-normal text-sm sm:text-base"
                                                    placeholder="Please enter the email address" name="email"
                                                    value="{{ $user->email }}" />
                                                <button type="button"
                                                    class="text-xs sm:text-sm font-light text-c-black pl-1 sm:pl-0 text-c-sky sendverification">
                                                    Send verification code
                                                </button>
                                            </div>
                                            <div class="input-div relative mt-2 form-group">
                                                <div class="flex items-center h-full">
                                                    <input type="text"
                                                        class="text-c-black text-sm sm:text-base font-normal h-full"
                                                        placeholder="Please enter your verification code"
                                                        name="verification_code" id="EmailVerification" disabled />
                                                    <span
                                                        class="bg-c-gray-4 text-sm sm:text-base px-2 h-full flex items-center border-l border-gray text-c-black">
                                                        Verification
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mt-2 flex gap-4 sm:gap-6">
                                                <button
                                                    class="bg-c-black text-white rounded-full px-10 py-1 sm:px-14 sm:py-2"
                                                    type="submit">
                                                    OK</button>
                                                <button type="reset" onclick="disableEmailEdit()"
                                                    class="cancel-btn text-c-yellow px-8 py-1 sm:px-12 sm:py-2 rounded-full border border-c-yellow">
                                                    Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="absolute right-0">
                                <button class="text-2xl enableEmailEdit" onclick="enableEmailEdit()">
                                    <i class="ri-edit-line"></i>
                                </button>
                                <i class="ri-close-circle-fill ri-lg cursor-pointer hidden disableEmailEdit"
                                    onclick="disableEmailEdit()"></i>
                            </div>
                        </div>
                    </div>
                    <!-- For Password -->
                    <div class="border-b stroke-color password">
                        <div class="py-4 flex flex-col sm:flex-row items-start relative">
                            <div class="w-28">
                                <span class="text-base font-bold text-c-black">Password:</span>
                            </div>
                            <div class="flex-grow flex items-start justify-between w-full edit-password">
                                <div class="w-full">
                                    <span class="font-normal text-base sm:text-lg">*************</span>
                                    <div class="divpassword hidden">
                                        <form action="{{ route('profile.store') }}" method="POST" class="formprofile"
                                            id="FormPassword">
                                            @csrf
                                            <input type="hidden" name="type" value="password">
                                            <input type="hidden" name="passwordemail" value="{{ $user->email }}">
                                            <div
                                                class="flex flex-col lg:flex-row items-start lg:items-center gap-1 sm:gap-2 w-full form-group">
                                                <div class="input-div relative">
                                                    <div class="flex items-center justify-between h-full">
                                                        <input type="text"
                                                            class="text-c-black text-sm sm:text-base font-normal h-full"
                                                            placeholder="Please enter a new password" name="password" />
                                                        <span
                                                            class="bg-c-gray-4 h-full px-4 flex items-center border-l border-gray">
                                                            <i class="ri-eye-close-line hidden"></i>
                                                            <i class="ri-eye-line"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <button type="button"
                                                    class="text-xs sm:text-sm font-light text-c-black pl-1 sm:pl-0 text-c-sky sendverificationpassword">
                                                    Send verification code</button>
                                            </div>
                                            <div class="input-div relative mt-2 form-group">
                                                <div class="flex items-center h-full">
                                                    <input type="text"
                                                        class="text-c-black text-sm sm:text-base font-normal h-full"
                                                        placeholder="Please enter your verification code"
                                                        id="PasswordVerification" disabled name="verification_code" />
                                                    <span
                                                        class="bg-c-gray-4 text-sm sm:text-base px-2 h-full flex items-center border-l border-gray text-c-black">
                                                        Verification
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mt-2 flex gap-4 sm:gap-6">
                                                <button
                                                    class="bg-c-black text-white rounded-full px-10 py-1 sm:px-14 sm:py-2"
                                                    type="submit">OK</button>
                                                <button type="reset" onclick="disablePasswordEdit()"
                                                    class="cancel-btn text-c-yellow px-8 py-1 sm:px-12 sm:py-2 rounded-full border border-c-yellow">
                                                    Cancel
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div></div>
                            </div>
                            <div class="absolute right-0">
                                <button class="text-2xl enablePasswordEdit" onclick="enablePasswordEdit()">
                                    <i class="ri-edit-line"></i>
                                </button>
                                <i class="ri-close-circle-fill ri-lg cursor-pointer hidden disablePasswordEdit"
                                    onclick="disablePasswordEdit()"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).on('change', '#fileInput', function(e) {
            e.preventDefault();
            var form = $('#profileForm')[0];
            var data = new FormData(form);
            $.ajax({
                type: "POST",
                url: form.action,
                data: data,
                dataType: "JSON",
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status == true) {
                        $('#profileImage').attr('src', response.path);
                        toastr["success"](response.message);
                    } else {
                        toastr["error"](response.message);
                    }
                }
            });
        });

        $(document).on('submit', '.formprofile', function(e) {
            e.preventDefault();
            $('small.text-red-500').remove();
            var form = $(this);
            var data = form.serialize();
            var type = form.find('input[name="type"]').val();
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: data,
                dataType: "JSON",
                success: function(response) {
                    if (response.status == true) {
                        if (type == 'username') {
                            disableNicknameEdit();
                            $('input[name="username"]').val(response.username);
                        } else if (type == 'email') {
                            disableEmailEdit();
                            $('.currentemail').text(response.email);
                        } else if (type == 'password') {
                            disablePasswordEdit();
                        }
                        toastr["success"](response.message);
                    } else {
                        if (response.errors) {
                            var errors = response.errors;
                            form.find('small.text-red-500').remove();
                            $.each(errors, function(field, messages) {
                                var div = form.find(`[name="${field}"]`).closest(
                                    'div.form-group');
                                var errorElement = $(
                                    `<small class="text-red-500 mt-1 block">${messages[0]}</small>`
                                );
                                errorElement.insertAfter(div);
                            });
                        } else {
                            toastr["error"](response.message);
                        }
                    }
                }
            });
        });

        $(document).on('click', '.sendverificationpassword', function(e) {
            e.preventDefault();
            $('small.text-red-500').remove();
            var email = $('input[name="passwordemail"]').val();
            $.ajax({
                type: "GET",
                url: "{{ route('SendVerificationCode') }}",
                data: {
                    email: email
                },
                beforeSend: function() {
                    $('.sendverificationpassword').text('Sending...');
                    $('.sendverificationpassword').prop('disabled', true);
                },
                success: function(response) {
                    if (response.status == true) {
                        $('#PasswordVerification').prop('disabled', false);
                        toastr["success"](response.message);
                    } else {
                        $('#PasswordVerification').prop('disabled', true);
                        toastr["error"](response.message);
                    }
                },
                complete: function() {
                    $('.sendverificationpassword').text('Send verification code');
                    $('.sendverificationpassword').prop('disabled', false);
                }
            });
        });

        $(document).on('click', '.sendverification', function(e) {
            e.preventDefault();
            $('small.text-red-500').remove();
            var email = $('input[name="email"]').val();
            var input = $('input[name="email"]');
            const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            if (!emailPattern.test(input.val().trim())) {
                var targetDiv = input.closest('div.form-group');
                var errorElement = $(
                    `<small class="text-red-500 mt-1 block">Please enter a valid email address.</small>`);
                errorElement.insertAfter(targetDiv);
            } else {
                $.ajax({
                    type: "GET",
                    url: "{{ route('SendVerificationCode') }}",
                    data: {
                        email: email
                    },
                    beforeSend: function() {
                        $('.sendverification').text('Sending...');
                        $('.sendverification').prop('disabled', true);
                    },
                    success: function(response) {
                        if (response.status == true) {
                            toastr["success"](response.message);
                            $('input[name="email"]').prop('disabled', true);
                            $('#EmailVerification').prop('disabled', false);
                        } else {
                            toastr["error"](response.message);
                        }
                    },
                    complete: function() {
                        $('.sendverification').text('Send verification code');
                        $('.sendverification').prop('disabled', false);
                    }
                });
            }
        });

        function enableNicknameEdit() {
            $('.nickname').find('input').prop('disabled', false);
            $('.nickname').find('input').addClass('enabled-input');
            $('.disableNicknameEdit').removeClass('hidden');
            $('.enablenicknameedit').addClass('hidden');
            $('.usernameFormButtons').removeClass('hidden');
        }

        function disableNicknameEdit() {
            $('#FormUsername')[0].reset();
            $('small.text-red-500').remove();
            $('.nickname').find('input').prop('disabled', true);
            $('.nickname').find('input').removeClass('enabled-input');
            $('.disableNicknameEdit').addClass('hidden');
            $('.enablenicknameedit').removeClass('hidden');
            $('.usernameFormButtons').addClass('hidden');
        }

        function enableEmailEdit() {
            $('.email').find('.currentemail').addClass('hidden');
            $('.email').find('.divemail').removeClass('hidden');
            $('.disableEmailEdit').removeClass('hidden');
            $('.enableEmailEdit').addClass('hidden');
            $('input[name="email"]').prop('disabled', false);
            $('#EmailVerification').prop('disabled', true);
        }

        function disableEmailEdit() {
            $('#FormEmail')[0].reset();
            $('.email').find('small.text-red-500').remove();
            $('.email').find('.currentemail').removeClass('hidden');
            $('.email').find('.divemail').addClass('hidden');
            $('.disableEmailEdit').addClass('hidden');
            $('.enableEmailEdit').removeClass('hidden');
        }

        function enablePasswordEdit() {
            $('.password').find('.divpassword').removeClass('hidden');
            $('.password').find('.currentpassword').addClass('hidden');
            $('.disablePasswordEdit').removeClass('hidden');
            $('.enablePasswordEdit').addClass('hidden');
            $('#PasswordVerification').prop('disabled', true);
        }

        function disablePasswordEdit() {
            $('#FormPassword')[0].reset();
            $('.password').find('small.text-red-500').remove();
            $('.password').find('.divpassword').addClass('hidden');
            $('.password').find('.currentpassword').removeClass('hidden');
            $('.disablePasswordEdit').addClass('hidden');
            $('.enablePasswordEdit').removeClass('hidden');
        }
    </script>
@endsection
