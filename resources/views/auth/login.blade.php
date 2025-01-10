<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'] . 'root.css') }}" />
    <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'] . 'custom.css') }}" />
    <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'] . 'cs.css') }}" />
    <link rel="shortcut icon" href="{{ asset($constants['IMAGEFILEPATH'] . 'logo.ico') }}" type="image/x-icon">
    <meta http-equiv="Content-Security-Policy"
        content="default-src 'self' https: data: 'unsafe-inline' 'unsafe-eval'; worker-src 'self' blob:; media-src 'self' blob: data:;">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <title>{{ config('app.name') }}</title>
</head>

<body class="login">
    @include('layouts.alert')
    <div class="login-screen w-full h-screen flex items-center justify-center gap-2 relative cs">
        <!-- Curtains   -->
        <div id="curtain" class="hidden">
            <div class="left"></div>
            <div class="right"></div>
        </div>
        <!-- main content -->
        <div class="left-background w-1/2 h-full bg-no-repeat bg-cover bg-center">
            <div class="blur-container"></div>
        </div>
        <div class="right-background w-1/2 h-full bg-no-repeat bg-cover bg-center hidden" id="DivUsername">
            <div class="login-container">
                <div class="user-login flex flex-col items-center justify-center w-full h-full gap-5">
                    <img class="h-24" src="{{ asset($constants['IMAGEFILEPATH'] . 'logo.png') }}" alt="Logo" />
                    <div class="flex items-center justify-center gap-1 text-2xl">
                        <p>Welcome to</p>
                        <div class="flex flex-col mt-0.5">
                            <p>Dots.</p>
                            <hr class="border-t-4 -mt-1 border-c-yellow rounded-full" />
                        </div>
                    </div>
                    <div class="right-container flex flex-col gap-7">
                        <input class="userinput" type="text" placeholder="Username" id="InputUsername" required />
                        <button class="rounded-full bg-c-black text-white px-24 py-2" name="next"
                            style="padding: 8px 0px" onclick="setUsername()">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="right-background w-1/2 h-full bg-no-repeat bg-cover bg-center" id="DivButton">
            <div class="login-container">
                <div class="user-login flex flex-col items-center justify-center w-full h-full gap-3">
                    <div class="flex items-center justify-center gap-1 text-2xl">
                        <p>Welcome to</p>
                        <div class="flex flex-col mt-0.5">
                            <p>Dots.</p>
                            <hr class="border-t-4 -mt-1 border-c-yellow rounded-full" />
                        </div>
                    </div>
                    <img class="h-24" src="{{ asset($constants['IMAGEFILEPATH'] . 'logo.png') }}" alt="Logo" />
                    <div class="flex gap-2 login-arrow">
                        <div class="flex flex-col gap-6 mt-2 w-full">
                            <div id="LoginButtonText" class="w-full">
                                <button class="bg-c-black text-white rounded-full w-full px-5 py-2" type="submit"
                                    onclick="showModal('#login')" id="BtnLogoDirectLogin">
                                    Login
                                </button>
                            </div>
                            <button class="text-c-black w-full px-5 py-2 rounded-full"
                                style="background: rgba(0, 0, 0, 0.16);box-shadow: var(--box-shadow)"
                                id="ChangeUsername">
                                Change username
                            </button>
                        </div>
                        <div id="loginButton" class="mt-2">
                        </div>
                    </div>
                    <div class="flex flex-col items-center justify-center space-y-6 mt-5">
                        <div class="flex flex-row items-center">
                            <div class="flex-grow border-t border-c-light-gray w-16 sm:w-20"></div>
                            <div class="text-gray-700 text-xs sm:text-sm px-3">Other ways to login</div>
                            <div class="flex-grow border-t border-c-light-gray w-16 sm:w-20"></div>
                        </div>
                        <a class="bg-c-black text-white rounded-full px-3 py-3 sm:py-2.5 h-10 text-xs sm:text-sm"
                            href="{{ route('GoogleLogin') }}">
                            <i class="ri-google-line ri-lg pr-1 text-c-yellow"></i>Login with Google
                        </a>
                        <div class="flex flex-col sm:flex-row sm:space-x-4 space-y-4 sm:space-y-0">
                            @if ($_SERVER['SERVER_NAME'] == 'desktop2.sizaf.com' || $_SERVER['SERVER_NAME'] == 'localhost')
                                <a href="https://sizaf.com/DotsApkAndExe/Sizaf_Server.apk" download
                                    class="bg-c-black text-white rounded-full px-3 py-3 sm:py-2.5 h-10 text-xs sm:text-sm"><i
                                        class="ri-mobile-download-line ri-lg pr-1 text-c-yellow"></i>Download on
                                    mobile</a>
                                <a href="https://sizaf.com/DotsApkAndExe/Sizaf_server_windows.exe" download
                                    class="bg-c-black text-white rounded-full px-3 py-3 sm:py-2.5 h-10 text-xs sm:text-sm"><i
                                        class="ri-macbook-line ri-lg pr-1 text-c-yellow"></i>Download on desktop</a>
                            @elseif ($_SERVER['SERVER_NAME'] == 'dev-ubt-app04.dev.orientdots.net')
                                <a href="https://sizaf.com/DotsApkAndExe/Dots_Server.apk" download
                                    class="bg-c-black text-white rounded-full px-3 py-3 sm:py-2.5 h-10 text-xs sm:text-sm"><i
                                        class="ri-mobile-download-line ri-lg pr-1 text-c-yellow"></i>Download on
                                    mobile</a>
                                <a href="https://sizaf.com/DotsApkAndExe/Dots_server_windows.exe" download
                                    class="bg-c-black text-white rounded-full px-3 py-3 sm:py-2.5 h-10 text-xs sm:text-sm"><i
                                        class="ri-macbook-line ri-lg pr-1 text-c-yellow"></i>Download on desktop</a>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- register voice and camera popup -->
        <div id="register" role="dialog"
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-0 z-10 hidden">
            <div class="bg-white rounded-2xl overflow-hidden shadow-lg max-w-md w-full modal-content">
                <!-- Sticky header -->
                <div
                    class="sticky top-0 flex py-2 px-5 justify-between items-center border-b border-gray-3 bg-white z-10 text-c-black">
                    <div class="text-lg font-normal">Register</div>
                    <button type="button" id="closeModalButton" class="py-1.5 rounded-md"
                        onclick="event.stopPropagation();hideModal('#register');stopCamera();">
                        <i class="ri-close-circle-fill text-black ri-lg"></i>
                    </button>
                </div>
                <div class="bg-white">
                    <div class="container-fluid">
                        <div class="col-11 col-sm-10 col-md-10 col-lg-6 col-xl-5 text-center p-0 mt-3">
                            <div class="card">
                                <form class="msform" id="RegisterForm" method="POST">
                                    @csrf
                                    <div class="sticky top-0 bg-white z-20">
                                        <ul id="progressbar" class="flex justify-between">
                                            <li class="active" id="camera">Camera
                                            </li>
                                            <li id="voice">Voice</li>
                                            <li id="confirm">Finish</li>
                                        </ul>
                                    </div>
                                    <div class="relative overflow-y-auto scroll" style="max-height: 24rem">
                                        <!-- First Step: Camera -->
                                        <fieldset>
                                            <div id="camera-error"
                                                class="flex gap-2 mb-4 mt-5 text-red-600 justify-center items-center hidden">
                                                <i class="ri-error-warning-fill ri-xl"></i>
                                                <p>Failed to capture photo</p>
                                            </div>
                                            <div
                                                class="form-card flex flex-col sm:flex-row mx-auto sm:space-x-4 gap-2 mt-5 sm:gap-0">
                                                <div class="relative w-8/12 h-48 sm:h-56 mx-auto sm:mx-0 sm:ml-6">
                                                    <video id="cam" autoplay muted playsinline
                                                        class="rounded-lg w-full h-full object-cover">
                                                        Not available
                                                    </video>
                                                    <div
                                                        class="panel absolute flex bottom-0 top-0 left-0 right-0 my-auto space-x-4 p-4 items-end justify-center hidden">
                                                        <button
                                                            class="flex items-center justify-center w-12 h-12 bg-red-500 text-white rounded-full hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400"
                                                            onclick="clickphoto('#register')">
                                                            <i class="ri-camera-3-fill text-xl"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <canvas id="canvas" class="hidden"></canvas>
                                                <div
                                                    class="photos-container flex justify-center items-center sm:items-start sm:justify-start flex-row sm:flex-col space-y-0 gap-2 sm:gap-0 sm:space-y-3">
                                                    <img id="photo1" alt="Photo 1"
                                                        class="photos rounded-lg object-cover mt-0 sm:mt-1 h-16 hidden" />
                                                    <img id="photo2" alt="Photo 2"
                                                        class="photos rounded-lg object-cover h-16 hidden" />
                                                    <img id="photo3" alt="Photo 3"
                                                        class="photos rounded-lg object-cover h-16 hidden" />
                                                </div>
                                            </div>
                                            <input id="retrying" type="button"
                                                class="bg-white text-c-yellow border border-c-yellow rounded-full w-3/12 py-2 text-sm mt-5 mr-5 cursor-pointer hidden"
                                                onclick="retryCapture('#register')" value="Retry" />
                                            <input type="button" name="next" id="nextButton"
                                                class="next bg-c-black hover-bg-c-black text-white rounded-full w-3/12 py-2 text-sm mt-5 cursor-pointer hidden"
                                                value="Next" onclick="stopCamera()" />
                                        </fieldset>
                                        <!-- Second Step: Voice -->
                                        <fieldset>
                                            <div class="form-card voice1 space-y-5">
                                                <div id="voice-error"
                                                    class="flex gap-2 text-red-600 justify-center items-start pl-9 pr-5 hidden">
                                                    <i class="ri-error-warning-fill ri-xl mt-2"></i>
                                                    <p>Failed to record voice</p>
                                                </div>
                                                <div
                                                    class="container flex flex-col justify-center items-center space-y-5">
                                                    <p id="VoiceInfo" class="pl-10 pr-5"></p>
                                                    <div class="mic-container mic-wrapper1 relative flex gap-3">
                                                        <button class="circle cursor-pointer has-tooltip"
                                                            id="recordButton1">
                                                            <i class="ri-mic-line mic"></i>
                                                        </button>
                                                        <div id="voice-retake"
                                                            class="absolute border tooltip border-c-yellow z-20 top-0 left-12 bg-white px-3 py-1 text-xs rounded-md">
                                                            Record
                                                        </div>
                                                    </div>
                                                    <div id="previewContainer1" class="audio-preview space-y-3"></div>
                                                </div>
                                            </div>

                                            <input type="button" name="previous"
                                                class="previous bg-white text-c-yellow border border-c-yellow rounded-full w-3/12 py-2 text-sm mt-5 mr-5 cursor-pointer"
                                                value="Previous" />
                                            <button type="button"
                                                class="bg-c-black hover-bg-c-black text-white rounded-full w-3/12 py-2 text-sm mt-5 cursor-pointer hidden"
                                                id="SubmitRegister">Submit</button>
                                        </fieldset>
                                        <fieldset>
                                            <div class="flex flex-col items-center justify-center mt-3">
                                                <h1 class="text-c-green text-2xl">Congratulations!<i
                                                        class="ri-checkbox-circle-fill text-c-green"></i></h1>
                                                <h1 class="text-c-green text-xl">You have successfully registered.</h1>
                                                <img src="{{ asset($constants['IMAGEFILEPATH'] . 'profile.png') }}"
                                                    alt="Profile" class="w-24 h-24 rounded-full object-cover mt-5"
                                                    id="RegisterImage" />
                                                <a href="{{ route('dashboard') }}"
                                                    class="getStartedBtn bg-c-black hover-bg-c-black text-white rounded-full w-5/12 sm:w-4/12 py-2 px-2 mt-5 text-sm cursor-pointer">Get
                                                    Started >></a>
                                            </div>
                                        </fieldset>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- login voice and camera popup -->
        <div id="login" role="dialog"
            class="fixed hidden inset-0 flex items-center justify-center bg-black bg-opacity-0 z-10">
            <div
                class="bg-white rounded-2xl overflow-hidden shadow-lg max-w-md w-full bg-c-lighten-gray modal-content">
                <div
                    class="sticky top-0 flex py-2 px-5 justify-between items-center border-b border-gray-3 bg-white z-10 text-c-black">
                    <div class="text-lg font-normal">Login</div>
                    <button type="button" id="closeModalButton" class="py-1.5 rounded-md"
                        onclick="event.stopPropagation();hideModal('#login');stopCamera();">
                        <i class="ri-close-circle-fill text-black ri-lg"></i>
                    </button>
                </div>
                <div class="overflow-y-auto max-h-full scroll bg-white">
                    <div class="container-fluid">
                        <div class="col-11 col-sm-10 col-md-10 col-lg-6 col-xl-5 text-center p-0 mt-3">
                            <div class="card">
                                <form class="msform" id="LoginForm" action="{{ route('login') }}" method="POST">
                                    @csrf
                                    <!-- First Step: Camera -->
                                    <fieldset>
                                        <div class="form-card space-y-3">
                                            <div id="camera-error"
                                                class="flex gap-2 text-red-600 justify-center items-start pl-10 pr-2 hidden">
                                                <i class="ri-error-warning-fill ri-xl mt-2"></i>
                                                <p id="CamError">Failed to capture photo</p>
                                            </div>
                                            <div
                                                class="relative flex justify-center items-center mx-auto w-10/12 h-96 sm:h-56 sm:w-8/12">
                                                <video id="cam" autoplay muted playsinline
                                                    class="rounded-lg w-full h-full object-cover">
                                                    Not available
                                                </video>
                                                <div id="countdown-overlay"
                                                    class="absolute w-full h-full flex items-center justify-center bg-black bg-opacity-50 hidden right-0 rounded-lg">
                                                    <span id="countdown-text"
                                                        class="text-c-white text-4xl font-bold"></span>
                                                </div>
                                                <canvas id="canvas" class="hidden"></canvas>
                                                <img id="photo1" alt="The screen capture will appear in this box."
                                                    class="rounded-lg absolute right-0 h-full w-full object-fit hidden" />
                                            </div>
                                        </div>
                                        <input id="retake" type="button"
                                            class="bg-c-black hover-bg-c-black text-c-white rounded-full w-3/12 py-2 text-sm cursor-pointer hidden mt-5 mr-3"
                                            onclick="retry('#login')" value="Retry" />
                                        <input id="next-voice" type="button" name="next"
                                            class="bg-c-black hover-bg-c-black text-c-white rounded-full w-7/12 sm:w-5/12 py-2 text-sm cursor-pointer mt-5 hidden"
                                            value="Login with user credentials"
                                            onclick="stopCamera(); showLoginCred();" />
                                    </fieldset>

                                    <!-- Second Step: Voice -->
                                    <fieldset class="voice2">
                                        <div class="form-card space-y-5">
                                            <div id="voice-error"
                                                class="flex gap-2 text-red-600 justify-center items-start pl-9 pr-5 hidden">
                                                <i class="ri-error-warning-fill ri-xl mt-2"></i>
                                                <p id="VoiceError">Failed to record voice</p>
                                            </div>
                                            <div class="container flex flex-col justify-center items-center space-y-5">
                                                <p class="pl-10 pr-5">Speak: <span id="Quotes"></span></p>
                                                <div class="mic-container mic-wrapper2 relative flex gap-3">
                                                    <button class="circle cursor-pointer has-tooltip"
                                                        id="recordButton2">
                                                        <i class="ri-mic-line mic"></i>
                                                    </button>
                                                    <div id="voice-retake"
                                                        class="absolute border tooltip border-c-yellow z-20 top-0 left-12 bg-white px-3 py-1 text-xs rounded-md">
                                                        Record
                                                    </div>
                                                </div>
                                                <div id="previewContainer2" class="audio-preview"></div>
                                            </div>
                                        </div>
                                        <input id="next-login" type="button" name="next"
                                            class="next bg-c-black hover-bg-c-black text-white rounded-full py-2 px-5 text-sm mt-5 cursor-pointer hidden"
                                            value="Login with user credentials" />
                                    </fieldset>

                                    <!-- Third Step: User Credentials -->
                                    <fieldset>
                                        <div class="form-card">
                                            <div
                                                class="blur-popup-container flex flex-col justify-center items-center gap-7 p-5 w-3/4 h-96 mx-auto relative">
                                            </div>
                                            <div
                                                class="right-container flex flex-col justify-center items-center gap-5 p-5 w-3/4 h-full w-full absolute -top-4">
                                                <div class="w-full flex items-center justify-center relative">
                                                    <img class="vector-img w-40 h-40"
                                                        src="{{ asset($constants['IMAGEFILEPATH'] . 'profileloginvector.png') }}"
                                                        alt="background" />
                                                    <img class="profile-img w-20 h-20 ml-5 mb-2 absolute"
                                                        src="{{ asset($constants['IMAGEFILEPATH'] . 'logo.png') }}"
                                                        alt="profile" />
                                                </div>
                                                <p class="text-lg">Welcome To Dots.</p>
                                                <input id="email" type="text" class="userinput"
                                                    name="email" placeholder="Username" readonly required
                                                    autocomplete="Email" autofocus>
                                                <div class="relative w-full md:w-3/4">
                                                    <input id="password-input" class="userinput md:ml-2"
                                                        type="password" placeholder="Password" name="password"
                                                        required />
                                                    <span
                                                        class="absolute inset-y-0 right-3 md:right-5 flex items-center cursor-pointer text-gray-500 hover:text-gray-700 toggle-password">
                                                        <i class="ri-eye-line"></i>
                                                    </span>
                                                </div>
                                                <button class="userinput" id="login-btn" name="next">
                                                    Login
                                                </button>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <!-- Fourth Step: Confirmation -->
                                    <fieldset>
                                        <div class="flex flex-col items-center justify-center gap-3">
                                            <h1 class="text-xl">
                                                Hi <span id="SpanUsername"></span>
                                            </h1>
                                            <img src="{{ asset($constants['IMAGEFILEPATH'] . 'profile.png') }}"
                                                alt="Profile" class="w-24 h-24 rounded-full object-cover"
                                                id="LoginImage" />
                                            <div class="flex items-center justify-center gap-1 font-semibold text-2xl">
                                                <p>Welcome to</p>
                                                <div class="flex flex-col mt-0.5">
                                                    <p>Dots.</p>
                                                    <hr class="border-t-4 -mt-1 border-c-yellow rounded-full" />
                                                </div>
                                            </div>
                                            <a href="{{ route('dashboard') }}"
                                                class="getStartedBtn bg-c-black hover-bg-c-black text-white rounded-full w-5/12 sm:w-4/12 py-2 px-2 text-sm mt-2 cursor-pointer">Get
                                                Started >></a>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- spinner -->
    <div class="fixed inset-0 flex flex-col items-center justify-center bg-black bg-opacity-50 z-10 text-c-yellow hidden"
        id="DivSpinner">
        <div class="loader ease-linear rounded-full border-4 border-t-4 h-8 w-8"></div>
        <h2 class="text-center text-white text-xl font-normal">Loading...</h2>
    </div>
    @php
        $randomNumber = rand(1, 3);
    @endphp
    <div class="hidden">
        <audio src="{{ asset($constants['IMAGEFILEPATH'] . 'read_' . $randomNumber . '.mp3') }}"
            id="ReadBelow"></audio>
        <audio src="{{ asset($constants['IMAGEFILEPATH'] . 'wod' . $randomNumber . '.mp3') }}"
            id="WODAudio"></audio>
    </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<script script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{ asset($constants['JSFILEPATH'] . 'main.js') }}"></script>
<script>
    const getthemeroute = @json(route('get-user-theme'));
</script>
<script>
    // Dashboard opening animation
    $('.getStartedBtn').on('click', function(event) {
        event.preventDefault();
        $('#curtain').removeClass('hidden');

        $('#curtain').addClass('open');

        setTimeout(() => {
            window.location.href = $(this).attr('href');
        }, 4000);
    });
</script>
<script>
    var avilable_facedata = false;
    var support_facelogin = false;
    var base_url = "{{ url('/') }}";
    $(window).on("pageshow", function(event) {
        $.ajax({
            type: "GET",
            url: "{{ route('dashboard') }}",
            success: function(response) {
                if (response.statusCode != 401) {
                    window.location.href = "{{ route('dashboard') }}";
                }
            }
        });
    });
    $(document).ready(function() {
        $.cookie.raw = true;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //for random Quotes
        $.ajax({
            method: 'GET',
            url: "{{ route('Quote') }}",
            contentType: 'application/json',
            success: function(result) {
                $('#Quotes').html(result.quote);
                $('#VoiceInfo').html(result.quote);
            },
        });

        //for change username
        $(document).on('click', '#ChangeUsername', function() {
            if ($.cookie("dotsusername") != undefined) {
                $.removeCookie('dotsusername');
            }
            location.reload(true);
        });

        //for audio playing
        var is_played = 0;
        $(document).on('click', '#nextButton', function() {
            if (is_played == 0) {
                $("#WODAudio")[0].play();
                is_played = 1;
            }
        });

        var username = getParameterByName('username');
        if (username == null) {
            if ($.cookie("dotsusername") != undefined) {
                username = $.cookie("dotsusername");
                $('#email').val(username);
                CheckFacedata(username);
            } else {
                //show username enter form, get it fromuser and set cookie
                $('#DivButton').addClass('hidden');
                $('#DivUsername').removeClass('hidden');
            }
        } else { //set url username as cookie
            $.cookie("dotsusername", username, {
                expires: 365
            });
            $('#email').val(username);
            CheckFacedata(username);
        }
        if (username != null) {
            $(".login-arrow").removeClass("ml-12")
            if (username != null) {
                $(".login-arrow").addClass("ml-12")
                $('#LoginButtonText').html(
                    `<div class="bg-c-dark-gray text-white rounded-full py-2 text-center">${username}</div>`
                    );
                $('#loginButton').html(
                    `<button class="bg-c-black text-white rounded-full h-10 w-10 flex justify-center items-center" type="submit" onclick="showModal('#login')" id="BtnLogoDirectLogin"><img src="${base_url}/public/images/arrow-right-long-fill.svg" height="25" width="25"></button>`
                    );
            }
        }

        function getParameterByName(name) {
            name = name.replace(/[\[\]]/g, "\\$&");
            var url = window.location.href;
            var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }

        //start cam automattically for login
        // if (navigator.mediaDevices && navigator.mediaDevices.enumerateDevices) {
        //     navigator.mediaDevices.enumerateDevices()
        //         .then(function(devices) {
        //             let cameraAvailable = devices.some(function(device) {
        //                 return device.kind === 'videoinput';
        //             });
        //             if (cameraAvailable) {
        //                 CheckFacedata(username).then(function(avilable_facedata) {
        //                     if (avilable_facedata) {
        //                         showModal('#login', true);
        //                     }
        //                 });
        //             } else {
        //                 return false;
        //             }
        //         })
        //         .catch(function(error) {
        //             return false;
        //         });
        // } else {
        //     return false;
        // }


        //check device capable for camera and set support_facelogin data
        checkCameraAvailability();

        function checkCameraAvailability() {
            if (navigator.mediaDevices && navigator.mediaDevices.enumerateDevices) {
                navigator.mediaDevices.enumerateDevices()
                    .then(function(devices) {
                        let cameraAvailable = devices.some(function(device) {
                            return device.kind === 'videoinput';
                        });
                        if (cameraAvailable) {
                            $.ajax({
                                type: "POST",
                                url: "{{ route('SupportFace') }}",
                                beforeSend: function() {
                                    $('#DivSpinner').removeClass('hidden');
                                },
                                data: {
                                    username: username,
                                    status: 1
                                },
                                dataType: "JSON",
                                success: function(response) {
                                    // if (response.status == true) {
                                    //     $('#BtnLogoDirectLogin').attr('onclick',
                                    //         "showModal('#login', true)");
                                    // }
                                },
                                complete: function() {
                                    $('#DivSpinner').addClass('hidden');
                                }
                            });
                            support_facelogin = true;

                        } else {
                            NotSupportFace();
                            return false;
                        }
                    })
                    .catch(function(error) {
                        NotSupportFace();
                        return false;
                    });
            } else {
                NotSupportFace();
                return false;
            }
        }

        function NotSupportFace() {
            support_facelogin = false;
            $.ajax({
                type: "POST",
                url: "{{ route('SupportFace') }}",
                data: {
                    username: username,
                    status: 0
                },
                dataType: "JSON",
            });
        }
    });

    function setUsername() {
        var username = $('#InputUsername').val();
        $.cookie("dotsusername", username, {
            expires: 365
        });
        $('#email').val(username);
        CheckFacedata(username).then(function(avilable_facedata) {
            if (avilable_facedata) {
                // Perform additional logic if needed
                showModal('#login', true);
            } else {
                location.reload();
                // showModal('#login');
            }
        });
    }

    function CheckFacedata(username) {
        return new Promise(function(resolve, reject) {
            $.ajax({
                type: "GET",
                url: "{{ route('CheckFaceData') }}",
                data: {
                    username: username
                },
                dataType: "JSON",
                success: function(response) {
                    if (response.status == false) {
                        avilable_facedata = false;
                        resolve(false);
                    } else {
                        avilable_facedata = true;
                        resolve(true);
                        fetchAndApplyTheme()
                    }
                }
            });
        });
    }

    $('#LoginForm').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            beforeSend: function() {
                $('#DivSpinner').removeClass('hidden');
            },
            type: "POST",
            url: "{{ route('login') }}",
            data: formData,
            dataType: "JSON",
            success: function(response) {
                if (response.status == false) {
                    toastr.error(response.msg);
                } else {
                    if (response.facedata != undefined && support_facelogin == true) {
                        //go for register face data
                        hideModal('#login');
                        showModal('#register', true);
                    } else {
                        //show next step with details
                        $('#login').find("fieldset").hide();
                        if (response.user.avatar != null) {
                            var image = "{{ url('/') }}" + "/" + response.user.avatar;
                            $('#LoginImage').attr('src', image);
                        }
                        $('#WODAudio').get(0).play();
                        $('#SpanUsername').html(response.user.name);
                        $('#login').find("fieldset").eq(3).show();

                    }
                    fetchAndApplyTheme()

                }
            },
            complete: function() {
                $('#DivSpinner').addClass('hidden');
                fetchAndApplyTheme()
            }
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.3.2/dist/confetti.browser.min.js"></script>
<script defer>
    var RegisterFormdata = new FormData();
    // showModal - Show the modal by removing the hidden class and switch to user camera if the modal is login
    function showModal(id, cam = false) {
        console.log("Show cam = " + cam, "facedata avilable : " + avilable_facedata, "camera avilable : " +
            support_facelogin);
        if (avilable_facedata == true && support_facelogin == true) {
            cam = true;
        }
        $(id).removeClass("hidden");
        if (cam == false && id == "#login") {
            $(id).find("fieldset").hide();
            $(id).find("fieldset").eq(2).show();
        }
        id == "#login" && $(id).find("#photo1").addClass("hidden");
        if (cam == true) {
            switchCamera("user", id);
        }
    }

    // hideModal - Hide the modal by adding the hidden class
    function hideModal(id) {
        $(id).find("#camera-error").removeClass("hidden");
        $(id).addClass("hidden");
    }

    /*** Step Form ***/
    let current_fs, next_fs, previous_fs; // Variables for fieldsets
    let current = 1; // Current step in the form
    const steps = $("fieldset").length; // Total number of steps

    // Next button click event - Move to the next step
    $(".next").click(function() {
        current_fs = $(this).closest("fieldset");
        next_fs = $(this).closest("fieldset").next();

        // Add active class to progress bar step
        $("#progressbar li")
            .eq($("fieldset").index(next_fs))
            .addClass("active");

        next_fs.show(); // Show the next fieldset

        // Animate the transition
        current_fs.animate({
            opacity: 0
        }, {
            step: function(now) {
                const opacity = 1 - now;
                current_fs.css({
                    display: "none",
                    position: "relative",
                });
                next_fs.css({
                    opacity: opacity
                });
            },
            duration: 500, // Animation duration
        });
        setProgressBar(++current); // Update the progress bar
    });

    // Previous button click event - Move to the previous step
    $(".previous").click(function() {
        current_fs = $(this).closest("fieldset");
        previous_fs = $(this).closest("fieldset").prev();

        // Remove active class from progress bar step
        $("#progressbar li")
            .eq($("fieldset").index(current_fs))
            .removeClass("active");

        previous_fs.show(); // Show the previous fieldset

        // Animate the transition
        current_fs.animate({
            opacity: 0
        }, {
            step: function(now) {
                opacity = 1 - now;
                current_fs.css({
                    display: "none",
                    position: "relative",
                });
                previous_fs.css({
                    opacity: opacity
                });
            },
            duration: 500, // Animation duration
        });
        setProgressBar(--current); // Update the progress bar
    });

    // Set the progress bar percentage
    function setProgressBar(curStep) {
        var percent = parseFloat(100 / steps) * curStep;
        percent = percent.toFixed();
        $(".progress-bar").css("width", percent + "%");
    }

    // Prevent form submission on submit button click
    $(".submit").click(function() {
        return false;
    });

    /*** Camera Functionality ***/

    let mediaStream = null; // Store the media stream
    let photoCount = 0; // Photo counter for register mode
    const constraints = {
        audio: false,
        video: {
            width: {
                ideal: 640
            },
            height: {
                ideal: 480
            },
            facingMode: "environment", // Default camera mode
        },
    };

    // Get media stream with specified constraints
    async function getMediaStream(constraints, id) {
        try {
            // Stop existing tracks if already active
            if (mediaStream && mediaStream.active) {
                const tracks = mediaStream.getVideoTracks();
                tracks.forEach((track) => track.stop());
            }
            mediaStream = await navigator.mediaDevices.getUserMedia(constraints);
            $(id).find("#cam").prop("srcObject", mediaStream);
            $(id)
                .find("#cam")
                .on("loadedmetadata", function() {
                    this.play(); // Start playing video
                });
            id == "#login" ?
                startCountdown(id) // Start countdown for login
                :
                $(id).find(".panel").removeClass("hidden"); // Show panel for register
        } catch (err) {
            console.error(err.message);
        }
    }

    // Function to start countdown for taking picture
    function startCountdown(id) {
        let countdown = 3; // Countdown timer
        $(id).find("#countdown-overlay").removeClass("hidden");
        $(id).find("#countdown-text").text(countdown);

        const countdownInterval = setInterval(() => {
            countdown--;
            $(id).find("#countdown-text").text(countdown);

            if (countdown === 0) {
                clearInterval(countdownInterval);
                $(id).find("#countdown-overlay").addClass("hidden");
                takePicture(id); // Take picture when countdown ends
                $(id).find("#retake").removeClass("hidden");
                // $(id).find("#next-voice").removeClass("hidden");
                // $(id).find("#camera-error").removeClass("hidden");
                stopCamera();
            }
        }, 1000); // Interval duration in milliseconds
    }

    // Switch camera facing mode and get media stream
    async function switchCamera(cameraMode, id) {
        try {
            $(id).find("#cam").prop("srcObject", null);
            constraints.video.facingMode = cameraMode;

            await getMediaStream(constraints, id);
        } catch (err) {
            console.error(err.message);
            alert(err.message);
        }
    }

    //if face fail show direct usercrediential form
    function showLoginCred() {
        var id = "login";
        $('#login').find("fieldset").hide();
        $('#login').find("fieldset").eq(2).show();
    }

    // Take a picture and display it
    function takePicture(id) {
        const context = $(id).find("#canvas")[0].getContext("2d");
        const height = $(id).find("#cam")[0].videoHeight;
        const width = $(id).find("#cam")[0].videoWidth;
        if (width && height) {
            $(id).find("#canvas").attr({
                width,
                height
            });
            context.drawImage($(id).find("#cam")[0], 0, 0, width, height);
            const data = $(id).find("#canvas")[0].toDataURL("image/png");

            // Convert Base64 to Blob
            const blob = dataURLtoBlob(data);

            if (id == "#login") {
                var username = $.cookie("dotsusername");
                fetch(data)
                    .then(res => res.blob())
                    .then(blob => {
                        // Create a new FormData object and append the image blob
                        var formData = new FormData();
                        formData.append("photo", blob, "photo.png");
                        formData.append("username", username);

                        // Send the form data to the server
                        $.ajax({
                            type: "POST",
                            url: "{{ route('ImageLogin') }}",
                            data: formData,
                            dataType: "JSON",
                            cache: false,
                            contentType: false,
                            processData: false,
                            beforeSend: function() {
                                $('#DivSpinner').removeClass('hidden');
                            },
                            success: function(response) {
                                if (response.status == true) {
                                    if (response.user.avatar != null) {
                                        var image = "{{ url('/') }}" + "/" + response.user.avatar;
                                        $('#LoginImage').attr('src', image);
                                    }
                                    if (response.flag == true) {
                                        toastr.success("Face authentication match, Check Voice.");
                                    }
                                    $('#ReadBelow').get(0).play();
                                    setTimeout(() => {
                                        startRecording(2);
                                    }, 2000);
                                    $('#login').find("fieldset").hide();
                                    $('#SpanUsername').html(response.user.name);
                                    $('#login').find("fieldset").eq(1).show();
                                } else {
                                    $(id).find('#CamError').html(response.msg);
                                    $(id).find("#camera-error").removeClass("hidden");
                                    $(id).find("#next-voice").removeClass("hidden");
                                    toastr.error(response.msg);
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error("An error occurred while uploading the image:",
                                    error);
                            },
                            complete: function() {
                                $('#DivSpinner').addClass('hidden');
                            }
                        });
                    });
            }
            // Increment photo count for register, set to 1 for login
            id == "#register" ? (photoCount += 1) : (photoCount = 1);
            $(id).find(`#photo${photoCount}`).attr("src", data).removeClass("hidden");
            // Add the blob to RegisterFormdata
            if (id == "#register") {
                RegisterFormdata.append(`photo${photoCount}`, blob, `photo${photoCount}.png`);
            }
            // Handle when photo count reaches 3
            if (photoCount === 3) {
                $(id).find("#retrying").removeClass("hidden");
                $(id).find("#nextButton").removeClass("hidden");
                stopCamera();
            }
        } else {
            clearPhoto();
        }
    }

    // Function to convert Base64 to Blob
    function dataURLtoBlob(dataurl) {
        var arr = dataurl.split(','),
            mime = arr[0].match(/:(.*?);/)[1],
            bstr = atob(arr[1]),
            n = bstr.length,
            u8arr = new Uint8Array(n);
        while (n--) {
            u8arr[n] = bstr.charCodeAt(n);
        }
        return new Blob([u8arr], {
            type: mime
        });
    }

    // Stop the camera by stopping all media stream tracks
    function stopCamera() {
        if (mediaStream && mediaStream.active) {
            const tracks = mediaStream.getTracks();
            tracks.forEach((track) => track.stop());
            mediaStream = null;
        }
    }

    // Click to take a photo with max 3 attempts
    function clickphoto(id) {
        event.preventDefault();
        if (photoCount < 3) {
            takePicture(id);
        }
        if (photoCount === 3) {
            $(id).find("#retake").addClass("hidden");
            $(id).find("#nextButton").removeClass("hidden");
        }
    }

    // Retry taking a photo by resetting and switching the camera
    function retry(id) {
        event.preventDefault();
        $(id).find("#photo1").addClass("hidden");
        switchCamera("user", id);
    }

    function retryCapture(id) {
        event.preventDefault();
        $(id).find("#photo1, #photo2, #photo3").addClass("hidden");
        $(id).find("#photo1, #photo2, #photo3").attr("src", "");
        photoCount = 0
        RegisterFormdata.delete("photo1");
        RegisterFormdata.delete("photo2");
        RegisterFormdata.delete("photo3");
        switchCamera("user", id);
    }

    /*** Audio Functionality ***/

    // Recorders object to store recorder instances and streams
    var recorders = {
        1: {
            recorder: null,
            stream: null,
            count: 0
        }, // Recorder 1
        2: {
            recorder: null,
            stream: null
        }, // Recorder 2
    };

    // Event listener for record button 1
    $("#recordButton1").click(function(event) {
        event.preventDefault();
        startRecording(1);
    });

    // Event listener for record button 2
    $("#recordButton2").click(function(event) {
        event.preventDefault();
        startRecording(2);
    });

    // Start recording for a given recorder number
    function startRecording(recorderNumber) {
        if (!window.MediaRecorder) {
            alert('MediaRecorder is not supported on this browser.');
            return;
        }
        navigator.mediaDevices
            .getUserMedia({
                audio: true
            })
            .then(function(stream) {
                var options;
                if (MediaRecorder.isTypeSupported('audio/webm;')) {
                    options = {
                        mimeType: 'audio/webm;'
                    };
                }
                var newRecorder = new MediaRecorder(stream, options);
                let audioChunks = [];
                let maxRecordTime = 8000; // 8 seconds timer
                let timeoutId;

                recorders[recorderNumber].recorder = newRecorder;
                recorders[recorderNumber].stream = stream;
                setTimeout(() => {
                    const micContainer = $(`.mic-wrapper${recorderNumber}`).find(".circle").first();
                    micContainer.addClass("active");
                    $(`.mic-wrapper${recorderNumber}`)
                        .find(".mic").addClass("ri-voiceprint-line").removeClass("ri-user-voice-fill")
                        .removeClass("ri-mic-line");
                    $(`.mic-wrapper${recorderNumber}`).find("#voice-retake").html("Recording");
                }, 300);

                // Handle data available event to create audio preview
                newRecorder.ondataavailable = function(e) {
                    audioChunks.push(e.data);
                    var reader = new FileReader();
                    reader.onloadend = function() {
                        var dataUrl = reader.result;
                        var preview = $("<audio controls></audio>").attr("src", dataUrl).attr("name",
                            "audio" + recorders[1].count);
                        if (recorderNumber === 1) {
                            $("#previewContainer1").empty().append(preview);
                            recorders[1].count = 1;
                            $('#SubmitRegister').removeClass('hidden');
                            $(`.mic-wrapper${recorderNumber}`).find(".mic").removeClass("ri-mic-line")
                                .addClass("ri-user-voice-fill")
                                .removeClass("ri-voiceprint-line");
                            $(`.mic-wrapper${recorderNumber}`).find("#voice-retake").html("Retry");
                        } else if (recorderNumber === 2) {
                            $("#previewContainer2").empty().append(preview);
                            setTimeout(() => {
                                stopRecording(newRecorder, stream, recorderNumber);
                            }, 4000);
                        }
                    };
                    reader.readAsDataURL(e.data);
                };

                newRecorder.onstop = function() {
                    clearTimeout(timeoutId); // Clear the timeout when recording stops
                    let audioBlob = new Blob(audioChunks, {
                        mimeType: 'audio/webm'
                    });
                    if (recorderNumber == 2) {
                        var username = $.cookie("dotsusername");
                        var voiceLogin = new FormData();
                        voiceLogin.append('audio', audioBlob, 'recorded-audio.webm');
                        voiceLogin.append('username', username);
                        $.ajax({
                            type: "POST",
                            url: "{{ route('VoiceLogin') }}",
                            data: voiceLogin,
                            dataType: "JSON",
                            cache: false,
                            contentType: false,
                            processData: false,
                            beforeSend: function() {
                                $('#DivSpinner').removeClass('hidden');
                            },
                            success: function(response) {
                                if (response.status == true) {
                                    if (response.user.avatar != null) {
                                        var image = "{{ url('/') }}" + "/" + response.user
                                            .avatar;
                                        $('#LoginImage').attr('src', image);
                                    }
                                    $('#WODAudio').get(0).play();
                                    $('#login').find("fieldset").hide();
                                    $('#SpanUsername').html(response.user.name);
                                    $('#login').find("fieldset").eq(3).show();
                                } else {
                                    $('#login').find('#VoiceError').html(response.msg);
                                    $('#login').find('#voice-error').removeClass('hidden');
                                    toastr.error(response.msg);
                                }
                            },
                            complete: function() {
                                $('#DivSpinner').addClass('hidden');
                            }
                        });
                    }
                    RegisterFormdata.append('audio' + recorders[1].count, audioBlob, 'recorded-audio' +
                        recorders[1].count + '.webm');
                };

                // Start recording
                newRecorder.start();

                // Set timeout to stop recording after maxRecordTime
                timeoutId = setTimeout(function() {
                    stopRecording(newRecorder, stream, recorderNumber);
                }, maxRecordTime);
            })
            .catch(function(err) {
                $(`.voice${recorderNumber}`).find("#voice-error").removeClass("hidden");
                console.error("Error accessing audio stream: ", err);
            });
    }

    // Stop recording and reset recorder and stream for a given recorder number
    function stopRecording(currentRecorder, currentStream, recorderNumber) {
        currentRecorder.stop();
        currentStream.getAudioTracks()[0].stop();
        recorders[recorderNumber].recorder = null;
        recorders[recorderNumber].stream = null;
        const micContainer = $(`.mic-wrapper${recorderNumber}`).find(".circle").first();
        micContainer.removeClass("active");
        $(`.mic-wrapper${recorderNumber}`).find(".mic").removeClass("ri-mic-line").addClass("ri-user-voice-fill")
            .removeClass("ri-voiceprint-line");
        $(`.mic-wrapper${recorderNumber}`).find("#voice-retake").html("Retry");
        $(`.voice${recorderNumber}`).find("#next-login").removeClass("hidden");
    }

    // Password eye toggle - Toggle password visibility and icon for the input
    $(".toggle-password").on("click", function() {
        const passwordInput = $("#password-input");
        const icon = $(this).find("i");

        // Toggle the type attribute between password and text
        if (passwordInput.attr("type") === "password") {
            passwordInput.attr("type", "text");
            icon.removeClass("ri-eye-line").addClass("ri-eye-off-line");
        } else {
            passwordInput.attr("type", "password");
            icon.removeClass("ri-eye-off-line").addClass("ri-eye-line");
        }
    });

    $(document).on('click', '#SubmitRegister', function() {
        var username = $.cookie("dotsusername");
        RegisterFormdata.append("username", username);
        $.ajax({
            type: "POST",
            url: "{{ route('RegisterFacedata') }}",
            data: RegisterFormdata,
            dataType: "JSON",
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('#DivSpinner').removeClass('hidden');
            },
            success: function(response) {
                if (response.status == true) {
                    if (response.user.avatar != null) {
                        var image = "{{ url('/') }}" + "/" + response.user.avatar;
                        $('#RegisterImage').attr('src', image);
                    }
                    $('#register').find("fieldset").hide();
                    $('#register').find("fieldset").eq(2).show();
                    $('#confirm').addClass('active');
                    showConfetti();
                } else {
                    toastr.error(response.msg);
                }
            },
            complete: function() {
                $('#DivSpinner').addClass('hidden');
            }
        });
    });

    // Trigger confetti when the Register successfull
    function showConfetti() {
        // Trigger confetti from both edges
        var duration = 5 * 1000; // 5 seconds duration for confetti
        var end = Date.now() + duration;

        (function frame() {
            confetti({
                particleCount: 7,
                angle: 60,
                spread: 55,
                origin: {
                    x: 0
                },
            });
            confetti({
                particleCount: 7,
                angle: 120,
                spread: 55,
                origin: {
                    x: 1
                },
            });

            if (Date.now() < end) {
                requestAnimationFrame(frame);
            }
        })();
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loginWallpaper = getCookie('login_wallpaper');

        if (loginWallpaper) {
            document.documentElement.style.setProperty('--login-wallpaper-1', `url(${loginWallpaper})`);
            document.documentElement.style.setProperty('--curtain-wallpaper', `url(${loginWallpaper})`);
        }
    });

    // Function to retrieve a cookie by name
    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
    }

    //enter to submit
    $(document).on('keydown', '#password-input', function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            $('#LoginForm').submit();
        }
    });
</script>



</html>
