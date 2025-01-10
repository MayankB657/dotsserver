<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Filefunctions;
use App\Models\File as FileModel;
use App\Models\User;
use App\Models\LightApp;
use App\Models\ContextType;
use App\Models\App;
use App\Models\RecycleBin;
use App\Models\Comment;
use App\Models\CommentReciver;
use App\Helpers\ActivityHelper;
use App\Models\UserType;

use Illuminate\Support\Facades\DB;



class FileManagerController extends Controller
{
    protected $filefunctions;
    public function __construct(Filefunctions $filefunctions)
    {
        $this->filefunctions = $filefunctions;
        
    }

    public function index($path = null)
    {
        $path = $path ? $path : '/';
        
       
        return view('filemanager', compact('path'));
    }

    public function recyclebin($path = null)
    {
        //$path = $path ? base64UrlDecode($path) : '/';
        $path = $path ? $path : '/';

        return view('filemanager', compact('path'));
    }
    public function editfile($fileid)
    {
        $file = FileModel::find(base64UrlDecode($fileid));
        $options = [];
        if ($file) {
            $fileExt = $file->extension;
            $fileName = $file->name;
            // $callbackUrl = route('savedocument');
            $fileUrl = url(Storage::url('app/root/' .session('userstoragepath') . $file->path));
            $token = $file->filehash;
            $user = User::find(auth()->user()->id);
            $userName = "admin";
            if ($user) {
                $userName = $user->name;
            }

            $options = [
                'document' => [
                    'fileType' => $this->filefunctions->fileTypeAlias($fileExt),
                    'key' => $token,
                    'title' => $fileName,
                    'url' => $fileUrl,
                    'permissions' => [
                        'download' => true,
                        'edit' => true,
                        'print' => true,
                    ],
                    'version' => true,
                ],
                'documentType' => $this->filefunctions->getDocumentType($fileExt),
                'type' => 'desktop',
                'editorConfig' => [
                    'callbackUrl' => '',
                    'lang' => "en",
                    'mode' => 'edit',
                    'user' => [
                        'id' => auth()->user()->id,
                        'name' => $userName,
                    ],
                    'customization' => [
                        'autosave' => true,
                        'chat' =>  true,
                        'commentAuthorOnly' => true,
                        'comments' =>  true,
                        'compactHeader' => false,
                        'compactToolbar' => false,
                        'help' =>  false,
                        'toolbarNoTabs' => true,
                        'hideRightMenu' => true,
                    ],
                ],
                'height' => "100%",
                'width' => "100%"
            ];
        }
        return view('editor', compact('options'));
    }
    public function createFolder(Request $request)
    {
        // Retrieve the file manager application
        $fileManagerApp = App::where('flag', 'filemanager')->where('status', 1)->first();
    
        // Decode the parent folder path and add user-specific storage path
        $parentFolder = session('userstoragepath') . base64UrlDecode($request->input('parentFolder'));
        // Define the default child folder name
        $childFolder = 'New Folder';
        $childFolderName = $childFolder;
        // Resolve the full paths
        $parentFolderPath = Storage::disk('root')->path($parentFolder);
        $childFolderPath = $parentFolderPath . DIRECTORY_SEPARATOR . $childFolder;
        $actualPath = $parentFolder . DIRECTORY_SEPARATOR . $childFolder;
    
        // Ensure the parent folder exists
        if (!File::exists($parentFolderPath)) {
            return response()->json(['status' => false, 'message' => 'Parent folder does not exist.']);
        }
              // print_r($childFolderPath);die;

        // Handle naming conflicts by appending a number
        $counter = 1;
        $originalChildFolderPath = $childFolderPath;
        while (File::exists($childFolderPath)) {
            $childFolderPath = $originalChildFolderPath . " ($counter)";
            $childFolderName = $childFolder." ($counter)";
            $actualPath = $parentFolder . DIRECTORY_SEPARATOR . $childFolder . " ($counter)";
            $counter++;
        }
    
        // Create a new folder record in the database
        $newFolder = new FileModel();
        $newFolder->folder = 1;
        $newFolder->extension = 'folder'; // Better descriptor for folders
        $newFolder->name = $childFolderName;
        $newFolder->parentpath = base64UrlDecode($request->input('parentFolder'));
        $newFolder->path = base64UrlDecode($request->input('parentFolder')).'/'.$childFolderName;
        $newFolder->openwith = $fileManagerApp ? $fileManagerApp->id : null;
        $newFolder->sort_order = 0; // Default sort order
        $newFolder->status = 1; // Active status
        $newFolder->created_by = auth()->user()->id; // Set created_by field for logged-in user
    
        // Save the folder metadata and create the folder on disk
        if ($newFolder->save()) {
            File::makeDirectory($childFolderPath, 0755, true);
            $this->updateFolderModification($newFolder->parentpath);
            
        }
        
        //Add Logs
        ActivityHelper::log('Create Folder', 'create' , null , json_encode($newFolder) , 'folder');
    
        return response()->json(['status' => true, 'message' => 'Folder successfully created', 'folderName' => basename($childFolderPath)]);
    }



    public function createFile(Request $request)
    {
        $fileatype = $request->input('filetype');
        $destinationParentPath = base64UrlDecode($request->input('destination')); 
        $resultarr = $this->filefunctions->createNewFile($fileatype, $destinationParentPath);
        if ($resultarr) {
            $this->updateFolderModification($destinationParentPath);
            //Add Logs
            ActivityHelper::log('Create File', 'create', null, json_encode($resultarr['newfile']) , $fileatype);

            return response()->json(['status' => true, 'message' => 'File sucessfully created', 'fileName' => $resultarr['filename'], 'filekey' => $resultarr['filekey']]);
        } else {
            return response()->json(['status' => false, 'message' => 'Path does not exist']);
        }
    }


    public function pathfiledetail(Request $request)
    {
    $filepath = $request->input('path') ? base64UrlDecode($request->input('path')) : '/';
    $parentPath = trim((string) ($filepath ?: '/'));
    $islist = $request->input('is_list')
           ?? (Session::has('is_list') && !empty(Session::get('is_list')) 
           ? Session::get('is_list') 
           : 2);
    $sortby = $request->input('sortby') 
    ?? (Session::has('sortby') && !empty(Session::get('sortby')) 
        ? Session::get('sortby') 
        : 'name');

    $sortorder = $request->input('sortorder') 
       ?? (Session::has('sortorder') && !empty(Session::get('sortorder')) 
           ? Session::get('sortorder') 
           : 'asc');
    $iconsize = $request->input('iconsize')?? 
           (Session::has('iconsize') && !empty(Session::get('iconsize')) 
           ? Session::get('iconsize') 
           : 'medium');

    /// save session 
    $dataArray = [];

        if (!empty($islist)) {
            $dataArray['is_list'] = $islist;
        }
        if (!empty($request->input('sortby'))) {
            $dataArray['sortby'] = $sortby;
        }
        if (!empty($request->input('sortorder'))) {
            $dataArray['sortorder'] = $sortorder;
        }
        if (!empty($request->input('iconsize'))) {
            $dataArray['iconsize'] = $iconsize;
        }

        // Use the sessionSave function
        $this->filefunctions->saveSession($dataArray);
    /// 
   
    $searchterm = $request->input('search');
    // Default values for folders and files
    $defaultfolders = collect();
    $files = collect();

    if ($parentPath !== 'Recycle Bin') {
        // Retrieve files and folders (excluding recycle bin)
        $defaultfolders = App::where('parentpath', $parentPath)
            ->where('filemanager_display', 1)
            ->where('status', 1)
            ->when($searchterm, function ($query) use ($searchterm) {
                $query->where('name', 'LIKE', '%' . $searchterm . '%');
            })
            ->orderBy('name')
            ->get();


        $files = FileModel::where('parentpath', $parentPath)
            ->where('status', 1)
            ->where('created_by', auth()->user()->id)
            ->when($searchterm, function ($query) use ($searchterm) {
                $query->where('name', 'LIKE', '%' . $searchterm . '%');
            })
            ->orderBy($sortby, $sortorder)
            ->get();
            $islist = ($islist==1) ? 'appendview.listview'  : 'appendview.pathview'; 
            $html = view($islist, compact('defaultfolders', 'files'))->render();
    } else {
        // Retrieve files in the recycle bin
        $files = FileModel::where('status', 2) // Recycle bin files typically have `status` 2
            ->where('created_by', auth()->user()->id)
            ->when($searchterm, function ($query) use ($searchterm) {
                $query->where('name', 'LIKE', '%' . $searchterm . '%');
            })
            ->orderBy($sortby, $sortorder)
            ->get();
        // Render the view for the recycle bin
        $islist = ($islist==1) ? 'appendview.recyclelistview'  : 'appendview.recyclebin'; 
        $html = view($islist, compact('files'))->render();
       
    }

    return response()->json(['html' => $html,'iconsize'=>$iconsize,'sortby'=>$sortby,'sortorder'=>$sortorder]);
}



    public function upload(Request $request)
    {
        $uploaddirpath = base64UrlDecode($request->header('Upload-Directory'));
        // Resolve the upload directory path with user storage path
        $uploadDirectorypath = session('userstoragepath') . base64UrlDecode($request->header('Upload-Directory'));
    
        $uploadedFiles = [];
        $uploadDirectory = Storage::disk('root')->path($uploadDirectorypath);
    
        // Ensure the upload directory exists
        if (!file_exists($uploadDirectory)) {
            mkdir($uploadDirectory, 0755, true);
        }
    
        // Process uploaded files
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $originalName = $file->getClientOriginalName();
                $filePath = $uploadDirectory . DIRECTORY_SEPARATOR . $originalName;
                $actualPath = $uploadDirectorypath . DIRECTORY_SEPARATOR . $originalName;
    
                // Resolve file name conflicts
                $originalName = $this->resolveUploadFileNameConflict($originalName, $uploadDirectory);
    
                $filePath = $uploadDirectory . DIRECTORY_SEPARATOR . $originalName;
                $actualPath = $uploadDirectorypath . DIRECTORY_SEPARATOR . $originalName;
                $actualdataPath = $uploaddirpath . DIRECTORY_SEPARATOR . $originalName;
    
                // Move the file to the upload directory
                if (move_uploaded_file($file->getPathname(), $filePath)) {
                   $newFile= $this->saveUploadedFileMetadata($file, $originalName, $filePath, $actualdataPath, $uploaddirpath);
                    $uploadedFiles[] = [
                        'name' => $originalName,
                        'size' => $file->getSize(),
                        'path' => $actualPath,
                    ];
                    ActivityHelper::log('Upload', 'upload', null, json_encode($newFile), $newFile->extension);
                }
            }
        }
    
        return response()->json(['files' => $uploadedFiles]);
    }
    
    private function resolveUploadFileNameConflict($originalName, $directory)
    {
        $fileName = pathinfo($originalName, PATHINFO_FILENAME);
        $fileExtension = pathinfo($originalName, PATHINFO_EXTENSION);
    
        $count = 1;
        while (file_exists($directory . DIRECTORY_SEPARATOR . $originalName)) {
            $originalName = $fileName . " ($count)." . $fileExtension;
            $count++;
        }
    
        return $originalName;
    }
    
    private function saveUploadedFileMetadata($file, $originalName, $filePath, $actualPath, $parentPath)
    {
        $fileExtension = pathinfo($originalName, PATHINFO_EXTENSION);
        $checkApp = checkLightApp($fileExtension);
    
        // Get the associated application
        $lightApp = LightApp::where('name', $checkApp)->where('status', 1)->first();
        $lightApp = $lightApp ?? App::where('name', $checkApp)->where('status', 1)->first();
    
        // Determine file type
        $fileType = $this->filefunctions->getFiletype($filePath);
    
        // Create a new file record in the database
        $newFile = new FileModel();
        $newFile->name = $originalName;
        $newFile->extension = $fileExtension;
        $newFile->filetype = $fileType;
        $newFile->parentpath = $parentPath;
        $newFile->path = $actualPath;
        $newFile->filehash = md5(date('d-M-Y H:i:s'));
        $newFile->openwith = $lightApp ? $lightApp->id : '';
        $newFile->size = $file->getSize();
        $newFile->status = 1; // Active status
        $newFile->created_by = auth()->user()->id;
    
        $newFile->save();
        return $newFile;
    }




    public function copyFile(Request $request)
    {
        $file = array('filepath' => $request->filepath, 'type' => $request->type, 'filekey' => $request->filekey, 'filetype' => $request->filetype);
        Session::put('copyfilepath', $file);

        return response()->json(['message' => 'File ' . $request->type . ' successfully!', 'file_path' => $request->filepath, 'status' => true]);
    }

    public function pasteFile(Request $request)
    {
        $destination = base64UrlDecode($request->path);
        $fullDestinationPath = session('userstoragepath') . $destination; // Full destination path with user storage path
    
        if (!Session::has('copyfilepath')) {
            return response()->json(['message' => 'No file to paste!', 'status' => false]);
        }
    
        $sessionData = Session::get('copyfilepath');
        $fileType = $sessionData['filetype'];
        $id = base64UrlDecode($sessionData['filekey']);
        $sourcepath = session('userstoragepath') . base64UrlDecode($sessionData['filepath']); // Full source path
        $sourcePath = Storage::disk('root')->path(session('userstoragepath') . base64UrlDecode($sessionData['filepath'])); // Full source path
        $destinationPath = Storage::disk('root')->path($fullDestinationPath); // Destination path in storage
    //print_r($sourcePath);
        if (!file_exists($sourcePath)) {
            Session::forget('copyfilepath');
            return response()->json(['message' => 'Source file does not exist.', 'status' => false]);
        }
    
        $filename = pathinfo($sourcePath, PATHINFO_BASENAME);
        $isCopy = ($sessionData['type'] == 'copy');
    
        $newFileName = $this->generateUniqueFilename($filename, $destinationPath, $isCopy, $fileType);
    
        if ($fileType != 'folder') {
            // Handle file copy or move
            $newFilePath = $fullDestinationPath . '/' . $newFileName;
            $newFilePathrename = $destinationPath . '/' . $newFileName;

            $copySuccess = $isCopy
                ? Storage::disk('root')->copy($sourcepath, $newFilePath)
                : rename($sourcePath, $newFilePathrename);
    
            if ($copySuccess) {
                $this->saveFileMetadata($id, $newFileName, $fileType, $destination, $isCopy,$sourcePath);
                Session::forget('copyfilepath');
                return response()->json(['message' => 'File pasted successfully!', 'status' => true]);
            }
        } else {
            // Handle folder copy or move
            $newFolderPath = $destinationPath . '/' . $newFileName;
            $copySuccess = $isCopy
                ? File::copyDirectory($sourcePath, $newFolderPath)
                : rename($sourcePath, $newFolderPath);
    
            if ($copySuccess) {
                $this->saveFolderMetadata($id, $newFileName, $destination, base64UrlDecode($sessionData['filepath']), $newFolderPath, $isCopy);
                Session::forget('copyfilepath');
                return response()->json(['message' => 'Folder pasted successfully!', 'status' => true]);
            }
        }
    
        Session::forget('copyfilepath');
        return response()->json(['message' => 'Failed to paste file or folder.', 'status' => false]);
    }
    
    private function generateUniqueFilename($filename, $destinationPath, $isCopy, $fileType)
    {
        $baseName = File::name($filename);
        $extension = ($fileType != 'folder') ? '.' . File::extension($filename) : '';
        $newFileName = $isCopy ? $baseName . ' - Copy' : $baseName;
    
        $counter = 1;
        $uniquePath = $destinationPath . '/' . $newFileName . $extension;
    
        while (file_exists($uniquePath)) {
            $newFileName = $isCopy
                ? $baseName . ' - Copy (' . $counter . ')'
                : $baseName . ' (' . $counter . ')';
            $uniquePath = $destinationPath . '/' . $newFileName . $extension;
            $counter++;
        }
    
        return $newFileName . $extension;
    }
    
    private function saveFileMetadata($id, $fileName, $fileType, $destination, $isCopy,$sourcePath)
    {
        if ($isCopy) {
            $checkApp = checkLightApp($fileType);
            $lightApp = LightApp::where('name', $checkApp)->where('status', 1)->first();
            $newFile = new FileModel();
            $newFile->name = $fileName;
            $newFile->extension = File::extension($fileName);
            $newFile->filetype = getFiletype($sourcePath);
            $newFile->parentpath = $destination; // Only the relative path is stored
            $newFile->path = $destination . '/' . $fileName; // Relative path for the file
            $newFile->openwith = $lightApp ? $lightApp->id : null;
            $newFile->status = 1;
            $newFile->created_by = auth()->user()->id;
            $newFile->save();
        } else {
            FileModel::where('id', $id)->update([
                'path' => $destination . '/' . $fileName, // Relative path
                'parentpath' => $destination, // Relative path
            ]);
        }
    }
    
    private function saveFolderMetadata($id, $folderName, $destination, $sourcePath, $newFolderPath, $isCopy)
    {
        $loggedInUserId = auth()->user()->id;
    
        if ($isCopy) {
            // Save metadata for the copied folder
            $fileManagerApp = App::where('flag', 'filemanager')->where('status', 1)->first();
            $newFolder = new FileModel();
            $newFolder->folder = 1;
            $newFolder->extension = 'folder';
            $newFolder->name = $folderName;
            $newFolder->parentpath = $destination; // Only the relative path is stored
            $newFolder->path = $destination . '/' . $folderName; // Relative path for the folder
            $newFolder->openwith = $fileManagerApp ? $fileManagerApp->id : null;
            $newFolder->status = 1;
            $newFolder->created_by = $loggedInUserId;
            $newFolder->updated_at =  now();
            $newFolder->save();
    
            // Copy folder contents recursively
            $this->copyFolderContents($sourcePath, $newFolder->id, $destination . '/' . $folderName, $loggedInUserId);
        } else {
            // Update metadata for the moved folder
            FileModel::where('id', $id)->update([
                'path' => $destination . '/' . $folderName, // Relative path
                'parentpath' => $destination, // Relative path
                'updated_at' => now()
            ]);
    
            // Update paths for all subfolders and files recursively
            $this->updateFolderContentsPath($sourcePath, $destination . '/' . $folderName,$loggedInUserId);
        }
    }
    
    private function copyFolderContents($sourceParentPath, $newParentId, $newParentPath, $loggedInUserId)
    {
        $folderContents = FileModel::where('parentpath', $sourceParentPath)
            ->where('created_by', $loggedInUserId)
            ->get();
           // print_r($sourceParentPath);die;
    
        foreach ($folderContents as $content) {
            $newContent = $content->replicate();
            $newContent->parentpath = $newParentPath; // Update parent path
            $newContent->path = $newParentPath . '/' . $content->name; // Update full path
            $newContent->save();
    
            if ($content->folder) {
                // If the content is a folder, copy its contents recursively
                $this->copyFolderContents(
                    $content->path,
                    $newContent->id,
                    $newParentPath . '/' . $content->name,
                    $loggedInUserId
                );
            }
        }
    }

    private function updateFolderContentsPath($sourcePath, $newParentPath,$loggedInUserId)
    {
        $folderContents = FileModel::where('parentpath', $sourcePath)
            ->where('created_by', $loggedInUserId)
            ->get();
    
        foreach ($folderContents as $content) {
            $newPath = $newParentPath . '/' . $content->name;
    
            // Update path for current file or folder
            $content->update([
                'parentpath' => $newParentPath, // New parent path
                'path' => $newPath
            ]);
    
            if ($content->folder) {
                // If the content is a folder, update its contents recursively
                $this->updateFolderContentsPath($content->path, $newPath,$loggedInUserId);
            }
        }
    }
    
    
    private function updateFolderModification($sourcePath)
    {
        $folderContents = FileModel::where('path', $sourcePath)
            ->where('folder', 1)
            ->get();
    
        foreach ($folderContents as $content) {
            // Update 
            $content->update([
                'updated_at' => now()
            ]);
    
            
                // If the content is a folder, update its contents recursively
                $this->updateFolderModification($content->parentpath);
            
        }
    }

    
    

    public function downloadFile($id)
    {
        $id = base64UrlDecode($id);
        $file = FileModel::findOrFail($id);
        $filePath = Storage::disk('root')->path($file->path);
        $fileName = basename($filePath);
        return response()->download($filePath, $fileName, ['Content-Disposition' => 'attachment']);
    }

    public function renameFile(Request $request)
    {
        $type = $request->input('filetype');
        $id = base64UrlDecode($request->input('filekey'));
        $newName = $request->input('name');
        $loggedInUserId = auth()->user()->id;

    
        // Validate the new name
        if (empty($newName)) {
            return response()->json(['message' => 'Please enter something to rename.', 'status' => false]);
        }
    
        // Retrieve the file or folder
        $file = FileModel::findOrFail($id);
    
        // Check if the new name is the same as the current name
        if ($file->name === $newName) {
            return response()->json(['message' => 'Renamed successfully.', 'status' => true,'oldname'=>1]);
        }
    
        // Check if a file or folder with the new name already exists in the same parent path
        $existingFile = FileModel::where('name', $newName)
            ->where('parentpath', $file->parentpath)
            ->where('created_by', $loggedInUserId)
            ->exists();
    
        if ($existingFile) {
            return response()->json(['message' => 'A file or folder with this name already exists.', 'status' => false]);
        }
    
        // Get the current and new paths
        $currentPath = Storage::disk('root')->path(session('userstoragepath') . $file->path);
        $newPath = Storage::disk('root')->path(session('userstoragepath') . $file->parentpath . '/' . $newName);
    
        // If it's a file, ensure the extension is preserved or added
        if ($type != 'folder') {
            $fileExtension = pathinfo($currentPath, PATHINFO_EXTENSION);
            $newExtension = pathinfo($newName, PATHINFO_EXTENSION);
    
            // Append the current extension if it's missing in the new name
            if (empty($newExtension)) {
                $newPath .= '.' . $fileExtension;
                $newName .= '.' . $fileExtension;
            }
        }
    
        // Rename the file or folder
        if (rename($currentPath, $newPath)) {
            $oldparentpath = $file->parentpath;
            $oldfilepath = $file->path;
            $file->name = $newName;
            $file->path = $file->parentpath . '/' . $newName;
            $file->save();
            $this->updateFolderContentsPath($oldfilepath, $file->path,$loggedInUserId);
            $this->updateFolderModification($oldparentpath);
            ActivityHelper::log('Edit File', 'edit', null, json_encode($file));
    
            return response()->json(['message' => 'Renamed successfully.', 'status' => true]);
        }
    
        return response()->json(['message' => 'Failed to rename.', 'status' => false]);
    }

    public function deleteFile(Request $request)
    {
        $fileId = base64UrlDecode($request->input('filekey'));
        $user = auth()->user();
        $userId = $user->id;
        $userType = $user->usertype;
    
        $file = FileModel::find($fileId);
    
        // Check if file exists
        if (!$file) {
            return response()->json(['message' => 'File not found', 'status' => false]);
        }
    
        // Check permissions
        if (($userType === 'user' || $userType === 'group') && $file->created_by !== $userId) {
            return response()->json(['message' => 'Permission denied. You are not the creator of this file', 'status' => false]);
        }
    
        // Determine file paths
        $filePath = Storage::disk('root')->path(session('userstoragepath') . $file->path);
        $recycleBinPath = Storage::disk('root')->path(session('userstoragepath') . 'Recycle Bin/' . base64UrlEncode($file->id . $file->name . $file->created_by).$file->name);
        $dumpedPath = Storage::disk('root')->path('dumped/' .base64UrlEncode($file->id . $file->name . $file->created_by).$file->name);
    
        // Handle file not found at source
        if (!file_exists($filePath) && $file->status == 1 && empty($file->recyclelevel)) {
            return response()->json(['message' => 'File not found', 'status' => false, 'filepath' => $filePath]);
        }
    
        // Define actions based on file status
        try {
            if ($file->status == 1 && empty($file->recyclelevel)) {
                // Move to Recycle Bin
                return $this->updateFileStatusAndMove($file, $filePath, $recycleBinPath, 2);
                
            } elseif($file->status == 2 && empty($file->recyclelevel)){
                $nextrecyclelevel = $this->getNextRecycleLevel($userType);
                // Move to Dumped
                if($userType=='master' || $nextrecyclelevel==null){
                    return $this->removeFile($file, $recycleBinPath);
                }
                return $this->updateFileStatusAndMove($file, $recycleBinPath, $dumpedPath, 0, $nextrecyclelevel);
            } elseif ($file->status == 0 && !empty($file->recyclelevel)){
                 
                // Update Recycle Level
                $nextRecycleLevel = $this->getNextRecycleLevel($userType);
                if($nextRecycleLevel==null){
                    return $this->removeFile($file, $dumpedPath);
                }
                $file->recyclelevel = $nextRecycleLevel;
                $file->updated_at = now(); 
                $file->save();
                return response()->json(['message' => 'File status updated to 0 and recyclelevel set to next level', 'status' => true]);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred: ' . $e->getMessage(), 'status' => false]);
        }
    
        return response()->json(['message' => 'No action taken', 'status' => false]);
    }

    private function updateFileStatusAndMove($file, $sourcePath, $destinationPath, $newStatus, $newRecycleLevel = null)
    {
    
        // Update file status
        $userType = auth()->user()->usertype;
        $originalStatus = $file->status;
        $originalRecycleLevel = $file->recyclelevel;
        $file->status = $newStatus;
        $file->recyclelevel = $newRecycleLevel;
        $file->updated_at = now(); 
        if ($file->save()) {
            if (rename($sourcePath, $destinationPath)) {
                $this->updateFolderModification($file->parentpath);
                return response()->json(['message' => 'File moved successfully', 'status' => true]);
            } else {
                // Revert file status if move fails
                $file->status = $originalStatus;
                $file->recyclelevel = $originalRecycleLevel;
                $file->save();
                return response()->json(['message' => 'Failed to move the file. Status reverted.', 'status' => false]);
            }
        }
    
        return response()->json(['message' => 'Failed to update file status', 'status' => false]);
    }
    
    private function getNextRecycleLevel($userType)
    {
        $getuserlevel = UserType::where('flag',$userType)->first();
        $userlevel = $getuserlevel ? $getuserlevel->level : 1;
        $nextLevel = UserType::where('flag', $userType)
            ->where('level', '<', $userlevel)
            ->orderBy('level', 'desc')
            ->first();
    
        return $nextLevel ? $nextLevel->level : null;
    }
    
    private function removeFile($file,$sourcePath){
        if (file_exists($sourcePath)) {
                        if (is_file($sourcePath)) {
                            // Delete the file
                            if (unlink($sourcePath)) {
                                $file->delete();
                                return response()->json(['message' => 'File deleted successfully', 'status' => true]);
                            } else {
                                return response()->json(['message' => 'Failed to delete the file', 'status' => false]);
                            }
                        } elseif (is_dir($sourcePath)) {
                            if (File::deleteDirectory($sourcePath)) {
                                $file->delete();
                                return response()->json(['message' => 'Folder deleted successfully', 'status' => true]);
                            } else {
                                return response()->json(['message' => 'Failed to delete the folder', 'status' => false]);
                            }
                        } else {
                            return response()->json(['message' => 'Invalid path', 'status' => false]);
                        }
            } else {
                        return response()->json(['message' => 'Failed to delete the file from storage', 'status' => false]);
            }
    }


    public function restoreFile(Request $request)
    {
        $fileId = base64UrlDecode($request->input('filekey'));
        $user = auth()->user();
        $userId = $user->id;
        $userType = $user->usertype;

    
        $file = FileModel::find($fileId);
    
        if (!$file) {
            return response()->json(['message' => 'File not found', 'status' => false]);
        }
    
        if (($userType === 'user' || $userType === 'group') && $file->created_by !== $userId) {
            return response()->json(['message' => 'Permission denied. You are not the creator of this file', 'status' => false]);
        }
    
        $recycleBinPath = Storage::disk('root')->path(session('userstoragepath') . 'Recycle Bin/' .base64UrlEncode($file->id . $file->name . $file->created_by).$file->name);
        $filePath = Storage::disk('root')->path(session('userstoragepath') . $file->path);
    
        if ($file->status == 2 && empty($file->recyclelevel)) {
            if (!file_exists($recycleBinPath)) {
                return response()->json(['message' => 'File not found in Recycle Bin', 'status' => false, 'filepath' => $recycleBinPath]);
            }
    
            try {
                // if (file_exists($filePath)) {
                    $newFileName = 'restore-' . date('d-m-Y-H-i-s') . '.' .$file->name;
                    $newFilePath = dirname($filePath) . '/' . $newFileName;
    
                    if (!rename($recycleBinPath, $newFilePath)) {
                        return response()->json(['message' => 'Failed to move file from Recycle Bin', 'status' => false]);
                    }
                    $oldpath = $file->path;
    
                    $file->name = $newFileName;
                    $file->path = $file->parentpath.'/'.$newFileName;
                // } else {
                //     if (!rename($recycleBinPath, $filePath)) {
                //         return response()->json(['message' => 'Failed to move file from Recycle Bin', 'status' => false]);
                //     }
                // }
    
                $file->status = 1;
                $file->updated_at = now(); 
                $file->save();
                $this->updateFolderContentsPath($oldpath, $file->path,$userId);
    
                return response()->json(['message' => 'File restored successfully', 'status' => true]);
            } catch (\Exception $e) {
                return response()->json(['message' => 'An error occurred: ' . $e->getMessage(), 'status' => false]);
            }
        }
    
        return response()->json(['message' => 'No restore action taken', 'status' => false]);
    }




    public function contextMenu(Request $request)
    {
        $clicktype = $request->input('type');
        $path = $request->input('path');
        $clicktype = $request->input('type');
        if ($clicktype == 'rightclick' || $clicktype == 'recyclebin') {
            $contextTypes = ContextType::with(['contextOptions' => function ($query) {
                $query->orderBy('sort_order', 'asc'); // Sort options by sort_order
            }])
                ->where('show_on', $clicktype)
                ->orderBy('sort_order', 'asc') // Sort context types by sort_order
                ->get();
        } else {
            $contextTypes = ContextType::with(['contextOptions' => function ($query) {
                $query->orderBy('sort_order', 'asc'); // Sort options by sort_order
            }])
                ->whereIn('show_on', [$clicktype, 'all'])
                ->orderBy('sort_order', 'asc') // Sort context types by sort_order
                ->get();
        }

        $html = view('appendview.clickoption')->with('contextTypes', $contextTypes)->with('type', $clicktype)->render();
        return response()->json(['html' => $html]);
    }


    public function dotsImageViewer($file)
    {
        $file = FileModel::find(base64UrlDecode($file));
        return view('dotsimageviewer', compact('file'));
    }
    public function dotsVideoPlayer($file)
    {
        $file = FileModel::find(base64UrlDecode($file));
        return view('dotsvideoplayer', compact('file'));
    }
    public function dotsDocumentViewer($file)
    {
        $file = FileModel::find(base64UrlDecode($file));
        return view('dotsdocumentviewer', compact('file'));
    }

    public function leftArrowClick(Request $request)
    {
        $filepath = $request->input('path');
        if (!empty($filepath) && $filepath != "/") {
            Session::put('rightarrowpath', $filepath);
        } else {
            Session::forget('rightarrowpath');
        }
    }
    public function rightArrowClick(Request $request)
    {
        Session::forget('rightarrowpath');
    }
    public function moveFiles(Request $request)
    {
        $fileKeys = $request->input('fileKeys', []);
        $folderKeys = $request->input('folderKeys', []);
        $targetFolder = base64UrlDecode($request->input('targetFolder'));
        $loggedInUserId = auth()->user()->id;
    
        // Resolve the full target path
        $fullTargetPath = session('userstoragepath') . $targetFolder;
    
        // Find the target folder record, owned by the logged-in user
        $targetFolderRecord = FileModel::where('path', $targetFolder)
            ->where('folder', 1)
            ->where('created_by', $loggedInUserId)
            ->first();
    
        if (!$targetFolderRecord) {
            return response()->json(['status' => false, 'message' => 'Target folder not found.']);
        }
    
        // Move files and folders
        foreach ($fileKeys as $fileKey) {
            $this->moveFile($fileKey, $fullTargetPath, $targetFolderRecord->path);
        }
    
        foreach ($folderKeys as $folderKey) {
            $this->moveFolderAndContents($folderKey, $fullTargetPath, $targetFolderRecord->path);
        }
    
        return response()->json(['status' => true, 'message' => 'Files and folders moved successfully.']);
    }
    
    protected function moveFile($fileKey, $fullTargetPath, $relativeTargetPath)
    {
        $loggedInUserId = auth()->user()->id;
    
        $fileToMove = FileModel::where('id', base64UrlDecode($fileKey))
            ->where('created_by', $loggedInUserId)
            ->first();
    
        if (!$fileToMove || $fileToMove->folder == 1) {
            return;
        }
    
        $newPath = $relativeTargetPath . '/' . $fileToMove->name;
        $fullNewPath = $this->checkFilePathConflict($fullTargetPath . '/' . $fileToMove->name);
    
        try {
            // Move the file in the filesystem
            Storage::disk('root')->move(session('userstoragepath') . $fileToMove->path, $fullNewPath);
    
            // Update database record
            $fileToMove->path = $newPath;
            $fileToMove->parentpath = $relativeTargetPath;
            $fileToMove->save();
        } catch (\Exception $e) {
            throw new \Exception('Error moving file: ' . $fileToMove->name);
        }
    }
    
    protected function moveFolderAndContents($folderKey, $fullTargetPath, $relativeTargetPath)
    {
        $loggedInUserId = auth()->user()->id;
    
        $folderToMove = FileModel::where('id', base64UrlDecode($folderKey))
            ->where('folder', 1)
            ->where('created_by', $loggedInUserId)
            ->first();
    
        if (!$folderToMove) {
            return;
        }
    
        $newFolderPath = $relativeTargetPath . '/' . $folderToMove->name;
        $fullNewFolderPath = $this->checkFilePathConflict($fullTargetPath . '/' . $folderToMove->name);
    
        // Create the new folder
        Storage::disk('root')->makeDirectory($fullNewFolderPath);
    
        // Move files within the folder
        $filesInFolder = FileModel::where('parentpath', $folderToMove->path)
            ->where('folder', 0)
            ->where('created_by', $loggedInUserId)
            ->get();
    
        foreach ($filesInFolder as $file) {
            $newFilePath = $newFolderPath . '/' . $file->name;
            $fullNewFilePath = $this->checkFilePathConflict($fullNewFolderPath . '/' . $file->name);
    
            // Move the file
            Storage::disk('root')->move(session('userstoragepath') . $file->path, $fullNewFilePath);
    
            // Update database record
            $file->path = $newFilePath;
            $file->parentpath = $newFolderPath;
            $file->save();
        }
    
        // Recursively move subfolders
        $subfolders = FileModel::where('parentpath', $folderToMove->path)
            ->where('folder', 1)
            ->where('created_by', $loggedInUserId)
            ->get();
    
        foreach ($subfolders as $subfolder) {
            $this->moveFolderAndContents(base64UrlEncode($subfolder->id), $fullNewFolderPath, $newFolderPath);
        }
    
        // Remove the original folder from storage
        $this->removeOriginalFolder(session('userstoragepath') . $folderToMove->path);
    
        // Update folder database record
        $folderToMove->parentpath = $relativeTargetPath;
        $folderToMove->path = $newFolderPath;
        $folderToMove->save();
    }
    
    protected function removeOriginalFolder($fullPath)
    {
        if (Storage::disk('root')->exists($fullPath)) {
            Storage::disk('root')->deleteDirectory($fullPath);
        }
    }

}
