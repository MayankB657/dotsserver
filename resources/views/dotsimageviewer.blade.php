<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Zoom Viewer</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    <style>
        body {
            background-color: #1f1f1f; /* Dark background for the body */
        }
        #imageContainer {
            background: #212121; /* Slightly lighter dark background for the container */
            border: 1px solid #444;
            width: 100%; /* Full width of the parent container */
            max-width: 600px; /* Fixed width */
            height: 400px; /* Fixed height */
            overflow: hidden; /* Hide overflowing parts of the image */
            position: relative; /* For absolute positioning of the image */
        }
        #zoomImage {
            transition: transform 0.3s ease;
            position: absolute; /* Absolute positioning to enable zooming */
            top: 0;
            left: 0;
        }
        .control-button {
            background-color: #333;
            color: #fbbf24; /* Tailwind's yellow-400 */
            border: 1px solid #444;
            border-radius: 0.25rem;
        }
        .control-button:hover {
            background-color: #444;
            color: #facc15; /* Tailwind's yellow-300 */
        }
    </style>
</head>
<body class="flex items-center justify-center h-screen p-4">

    <!-- Image Container -->
    <div class="flex flex-col items-center space-y-4 max-w-full w-full">
        <div id="imageContainer" class="border border-gray-700 rounded-lg relative">
            <img id="zoomImage" src="{{ url(Storage::url($constants['ROOTPATH'].session('userstoragepath').$file->path)) }}" alt="Zoomable Image" class="w-full h-full object-contain">
        </div>

        <!-- Zoom Controls -->
        <div class="flex space-x-4">
            <button onclick="zoomIn()" class="control-button px-4 py-2 flex items-center space-x-2">
                <i class="ri-zoom-in-fill text-xl"></i>
                <span>Zoom In</span>
            </button>
            <button onclick="zoomOut()" class="control-button px-4 py-2 flex items-center space-x-2">
                <i class="ri-zoom-out-fill text-xl"></i>
                <span>Zoom Out</span>
            </button>
            <button onclick="resetZoom()" class="control-button px-4 py-2 flex items-center space-x-2">
                <i class="ri-refresh-fill text-xl"></i>
                <span>Reset</span>
            </button>
        </div>
    </div>

    <script>
        let scale = 1;
        const zoomImage = document.getElementById('zoomImage');

        function zoomIn() {
            scale += 0.1;
            zoomImage.style.transform = `scale(${scale})`;
        }

        function zoomOut() {
            if (scale > 0.1) {
                scale -= 0.1;
                zoomImage.style.transform = `scale(${scale})`;
            }
        }

        function resetZoom() {
            scale = 1;
            zoomImage.style.transform = `scale(${scale})`;
        }
    </script>

</body>
</html>
