<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\File;
use App\Models\Folder;
use App\Models\LightApp;
use App\Models\App;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Filefunctions;
use App\Helpers\PermissionHelper;


class SearchController extends Controller
{
    protected $filefunctions;

    public function __construct(Filefunctions $filefunctions){
        $this->filefunctions = $filefunctions;
    }
    public function search(Request $request)
    {
        $apps = App::all();
        $query = $request->input('query');
        $createdBy = auth()->user()->id;
        $files = File::select('id','openwith','extension', 'name', 'parentpath', 'path', 'filetype') // Select specific columns
            ->where('name', 'like', "%$query%")
            ->where('created_by', $createdBy)
            ->where('status', 1)
            ->where('folder', 0)
            ->orderBy('extension')
            ->orderBy('name') // Add secondary sorting by name
            ->get();
        $filesByExtension = [];
        foreach ($files as $file) {
            $filesByExtension[$file->extension][] = [
                
                'id'=> $file->id,
                'name' => $file->name,
                'extension' => $file->extension,
                'openwith' => $file->openwith,
                'parentpath' => $file->parentpath,
                'path' => $file->path,
                'filetype' => $file->filetype,
            ];
        }
        $folders = File::where('name', 'like', "%$query%")
            ->where('created_by', $createdBy)
            ->where('status', 1)
            ->where('folder', 1)
            ->orderBy('name')
            ->get();
        $results = [
            'files' => $filesByExtension,
            'folders' => $folders
        ];
        $html = view('appendview.search')->with('results', $results)->render();
        return response()->json(['html' => $html]);
    }


    public function listalliframe(Request $request)
{
    $iframeArray = [];
    $fileKey = $request->input('filekey');
    $appKey = $request->input('appkey');
    $appType = $request->input('apptype');
    $fileType = $request->input('filetype');

    // Validate inputs
    if (!empty($appKey) || !empty($fileKey) || !empty($fileType) || !empty($appType)) {
      
    $appDet = ($appType === 'app') 
        ? App::find(base64UrlDecode($appKey)) 
        : LightApp::find(base64UrlDecode($appKey));

    if (!$appDet) {
        return response()->json(['status' => false, 'message' => 'Application details not found.']);
    }

    $file = ($fileType === 'file' || $fileType === 'folder') 
        ? File::find(base64UrlDecode($fileKey)) 
        : $appDet;

    if (!$file) {
        return response()->json(['status' => false, 'message' => 'File details not found.']);
    }

    // Determine iframe URL and extension
    $iframeUrlLink = $this->determineIframeUrl($file, $fileType, $appDet);

    // Handle new file creation for certain app functions
    if ($fileType !== 'file' && $fileType !== 'folder' && $appDet->function === 'createdocument') {
        $newFile = $this->filefunctions->createNewFile($appDet->fileextension, 'Document');
        if (!$newFile) {
            return response()->json(['status' => false, 'message' => 'Failed to create document.']);
        }

        $file = File::find($newFile['filekey']);
        $iframeUrlLink = url('editfile/' . base64UrlEncode($newFile['filekey']));
        $fileKey = base64UrlEncode($newFile['filekey']);
    }

    $extension = $fileType === 'file' ? checkFileGroup($file->extension) : 'other';

    // Build new iframe entry
    $newArray = [
        'is_popup' => (!empty($appDet->app_function)) ? true : false,
        'popup_page' => (!empty($appDet->app_function)) ? $appDet->app_function : '',
        'filekey' => base64UrlEncode($file->id),
        'filetype' => $fileType,
        'appkey' => $appKey,
        'apptype' => $appType,
        'iframetype' => 'iframe',
        'appicon' => $appDet->icon,
        'filepath' => $file->path,
        'extension' => $extension,
        'filename' => $file->name,
        'appname' => $appDet->name,
        'iframeurl' => $iframeUrlLink
    ];
    // Update session iframe data
    $iframeArray = $this->updateIframeSession($newArray, $appType, $appKey, $fileKey);
    }else{
        $iframeArray = Session::get('iframeapp', []);
    }
    
    
    // Render HTML views
    $iframeArray = $this->filefunctions->reverseArray($iframeArray);
    $html = view('appendview.iframe', compact('iframeArray'))->render();
    $html2 = view('appendview.iframetab', compact('iframeArray'))->render();

    $iframeKey = 'iframepopup' . $fileType . $fileKey;
    return response()->json(['status' => true, 'html' => $html, 'html2' => $html2, 'filekey' => $iframeKey]);
}


private function determineIframeUrl($file, $fileType, $appDet)
{
    switch ($fileType) {
        case 'file':
            $fileGroup = checkFileGroup($file->extension);
            return match ($fileGroup) {
                'image' => url('dotsimageviewer/' . base64UrlEncode($file->id)),
                'video'=> url('dotsvideoplayer/' . base64UrlEncode($file->id)), 
                'audio' => url('dotsvideoplayer/' . base64UrlEncode($file->id)),
                'editor' => url('editfile/' . base64UrlEncode($file->id)),
                default => url('dotsdocumentviewer/' . base64UrlEncode($file->id)),
            };

        case 'folder':
            return url('filemanager', ['path' => base64UrlEncode($file->path)]);

        case 'app':
            return $appDet->type === 'folder' 
                ? url('filemanager', ['path' => base64UrlEncode($appDet->path)]) 
                : url($appDet->link);

        default:
            return $appDet->link;
    }
}

/**
 * Update the iframe session with the new entry.
 */
private function updateIframeSession($newArray, $appType, $appKey, $fileKey)
{
    $iframeArray = Session::get('iframeapp', []);
    $sessionKey = $appType . $appKey;

    if (!isset($iframeArray[$sessionKey])) {
        $iframeArray[$sessionKey] = [$newArray];
    } else {
        $existing = &$iframeArray[$sessionKey];
        $existing = array_filter($existing, fn($item) => $item['filekey'] !== $fileKey);
        array_unshift($existing, $newArray);
    }

    Session::put('iframeapp', $iframeArray);
    return $iframeArray;
}


public function closeiframe(Request $request)
{
    $fileKey = $request->input('filekey');
    $appKey = $request->input('appkey');
    $appType = $request->input('apptype');

    // Validate required parameters
    if (!$fileKey || !$appKey || !$appType) {
        return response()->json(['status' => false, 'message' => 'Invalid input parameters.']);
    }

    // Check if iframe session exists
    if (Session::has('iframeapp')) {
        $iframeArray = Session::get('iframeapp');
        $sessionKey = $appType . $appKey;

        // Check if the session key exists
        if (isset($iframeArray[$sessionKey])) {
            // Remove the specific file entry or clear the session key if only one file exists
            $iframeArray[$sessionKey] = array_filter($iframeArray[$sessionKey], function ($item) use ($fileKey) {
                return $item['filekey'] !== $fileKey;
            });

            if (empty($iframeArray[$sessionKey])) {
                unset($iframeArray[$sessionKey]);
            }

            // Update or clear the session
            if (empty($iframeArray)) {
                Session::forget('iframeapp');
            } else {
                Session::put('iframeapp', $iframeArray);
            }
        }
    }

    // Generate the updated HTML views
    $finalArray = Session::get('iframeapp', []);
    $html = view('appendview.iframe', ['iframeArray' => $finalArray])->render();
    $html2 = view('appendview.iframetab', ['iframeArray' => $finalArray])->render();

    return response()->json(['html' => $html, 'html2' => $html2]);
}

}
