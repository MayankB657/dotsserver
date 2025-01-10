<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Video & Audio Player</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    <style>
        #playerContainer {
            background-image: url({{ checkIconExist($file->extension,'file')}});
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
        }
        #mediaPlayer {
            position: relative;
            z-index: 1;
        }
        #controls {
            position: relative;
            z-index: 2;
        }
    </style>
</head>
<body class="bg-black flex items-center justify-center min-h-screen p-4">

    <div id="playerContainer" class="max-w-2xl w-full p-4 bg-gray-800 rounded-lg shadow-lg relative">
        <!-- Video/Audio Element -->
        <video id="mediaPlayer" class="w-full h-auto rounded-md" >
            <!-- Video Source -->
            <source src="{{ url(Storage::url($constants['ROOTPATH'].session('userstoragepath').$file->path)) }}" type="{{ $file->filetype.'/'}}{{  ($file->filetype=='audio')? 'mp3':'mp4'}}">
            Your browser does not support the video tag.
        </video>

        <!-- Custom Controls -->
        <div id="controls" class="mt-2 flex items-center justify-between space-x-4">
            <!-- Go Back 5 Seconds Button -->
            <button id="backwardBtn" class="text-yellow-500 hover:text-yellow-400">
                <i class="ri-rewind-mini-fill text-2xl md:text-3xl"></i>
            </button>

            <!-- Play/Pause Button -->
            <button id="playPauseBtn" class="text-yellow-500 hover:text-yellow-400">
                <i class="ri-play-fill text-2xl md:text-3xl"></i>
            </button>

            <!-- Go Forward 5 Seconds Button -->
            <button id="forwardBtn" class="text-yellow-500 hover:text-yellow-400">
                <i class="ri-speed-mini-fill text-2xl md:text-3xl"></i>
            </button>

            <!-- Progress Bar -->
            <input id="progressBar" type="range" value="0" class="flex-grow bg-gray-700 rounded-lg appearance-none h-2">

            <!-- Volume Control -->
            <button id="volumeBtn" class="text-yellow-500 hover:text-yellow-400">
                <i class="ri-volume-up-fill text-2xl md:text-3xl"></i>
            </button>

            <!-- Full Screen Button -->
            <button id="fullscreenBtn" class="text-yellow-500 hover:text-yellow-400">
                <i class="ri-fullscreen-fill text-2xl md:text-3xl"></i>
            </button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mediaPlayer = document.getElementById('mediaPlayer');
            const playPauseBtn = document.getElementById('playPauseBtn');
            const progressBar = document.getElementById('progressBar');
            const volumeBtn = document.getElementById('volumeBtn');
            const backwardBtn = document.getElementById('backwardBtn');
            const forwardBtn = document.getElementById('forwardBtn');
            const fullscreenBtn = document.getElementById('fullscreenBtn');
            const playerContainer = document.getElementById('playerContainer');

            // Play/Pause Functionality
            playPauseBtn.addEventListener('click', () => {
                if (mediaPlayer.paused) {
                    mediaPlayer.play();
                    playPauseBtn.innerHTML = '<i class="ri-pause-fill text-2xl md:text-3xl"></i>';
                } else {
                    mediaPlayer.pause();
                    playPauseBtn.innerHTML = '<i class="ri-play-fill text-2xl md:text-3xl"></i>';
                }
            });

            // Update Progress Bar as Media Plays
            mediaPlayer.addEventListener('timeupdate', () => {
                const progressValue = (mediaPlayer.currentTime / mediaPlayer.duration) * 100;
                progressBar.value = progressValue;
            });

            // Seek Functionality
            progressBar.addEventListener('input', () => {
                const seekTime = (progressBar.value / 100) * mediaPlayer.duration;
                mediaPlayer.currentTime = seekTime;
            });

            // Mute/Unmute Functionality
            volumeBtn.addEventListener('click', () => {
                mediaPlayer.muted = !mediaPlayer.muted;
                volumeBtn.innerHTML = mediaPlayer.muted 
                    ? '<i class="ri-volume-mute-fill text-2xl md:text-3xl"></i>' 
                    : '<i class="ri-volume-up-fill text-2xl md:text-3xl"></i>';
            });

            // Go Back 5 Seconds
            backwardBtn.addEventListener('click', () => {
                mediaPlayer.currentTime = Math.max(0, mediaPlayer.currentTime - 5);
            });

            // Go Forward 5 Seconds
            forwardBtn.addEventListener('click', () => {
                mediaPlayer.currentTime = Math.min(mediaPlayer.duration, mediaPlayer.currentTime + 5);
            });

            // Fullscreen Functionality
            fullscreenBtn.addEventListener('click', () => {
                if (!document.fullscreenElement) {
                    playerContainer.requestFullscreen().catch(err => {
                        alert(`Error attempting to enable full-screen mode: ${err.message} (${err.name})`);
                    });
                } else {
                    document.exitFullscreen();
                }
            });
        });
    </script>
</body>
</html>
