<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Document Viewer</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    <style>
        #viewerContainer {
            background: #212121;
        }
        #documentViewer {
            width: 100%;
            height: 80vh;
            border: 1px solid #444;
            border-radius: 0.5rem;
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
<body class="bg-gray-900 flex items-center justify-center min-h-screen p-4">

    <div id="viewerContainer" class="w-full max-w-4xl p-4 bg-gray-800 rounded-lg shadow-lg">
        
        <div id="documentViewer" class="relative overflow-hidden">
            <iframe src="{{ url(Storage::url($constants['ROOTPATH'].session('userstoragepath').$file->path)) }}" class="w-full h-full frame"></iframe>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.3.122/pdf.min.js"></script>
   
</body>
</html>
