<?php 
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use App\Models\PermissionList;

function base64UrlEncode($data) {
    // Standard base64 encode
    $base64 = base64_encode($data);
    // URL-safe base64 encode
    $base64Url = str_replace(['+', '/', '='], ['-', '_', ''], $base64);
    return $base64Url;
}

function base64UrlDecode($data) {
    // URL-safe base64 decode
    $base64 = str_replace(['-', '_'], ['+', '/'], $data);
    // Standard base64 decode
    $decoded = base64_decode($base64);
    return $decoded;
}
function checkIconExist($filePath, $type) {
    
    $theme = (session()->has('theme_name')) ? session('theme_name') : 'default';
    //return $theme;
    $commonpath = $theme.'/icon/';
    $fileIconPath = config('constants.FILEICONPATH');
    $appIconPath = config('constants.APPFILEPATH').$commonpath;
    $imageIconPath = config('constants.IMAGEFILEPATH');
    if(!empty($theme)){
        $imageIconPath = config('constants.IMAGEFILEPATH').'theme/'.$theme.'/';
    }
    $iconExtension = config('constants.ICONEXTENSION');
    $otherIconPath = config('constants.OTHERFILEPATH');
    $defaultIcon = asset($otherIconPath . 'default.svg');
    
    if (!empty($filePath) && !empty($type) && in_array($type, ['file', 'app', 'folder','menu','image'])) {
        switch ($type) {
            case 'app':
                $fileIconDefault = asset($appIconPath . 'defaultapp.svg');
                $fileIconRelativePath = $appIconPath . $filePath;
                break;
                
            case 'image':
                $fileIconDefault = asset($imageIconPath . 'defaultapp.svg');
                $fileIconRelativePath = $imageIconPath . $filePath;
                break;

            case 'folder':
                $fileIconDefault = asset($fileIconPath . 'defaultfolder.png');
                $fileIconRelativePath = $fileIconPath . $filePath . $iconExtension;
                break;
            case 'menu':
                $fileIconDefault = asset($fileIconPath . 'defaultfolder.png');
                $fileIconRelativePath = $fileIconPath . $filePath . $iconExtension;
            break;

            default:
                $fileIconRelativePath = $fileIconPath . $filePath . $iconExtension;
        }

        $fileIconFullPath = base_path($fileIconRelativePath);
        //return $fileIconFullPath;
        if (file_exists($fileIconFullPath)) {
            return asset($fileIconRelativePath);
        } else {
            if ($type == 'file' || $type == 'folder') {
                $fileIconPngRelativePath = $fileIconPath . $filePath . '.png';
                $fileIconPngFullPath = base_path($fileIconPngRelativePath);

                if (file_exists($fileIconPngFullPath)) {
                    return asset($fileIconPngRelativePath);
                }
            }else if ($type == 'app') {
                $fileIconPngRelativePath = $appIconPath . pathinfo($filePath, PATHINFO_FILENAME). '.png';
                $fileIconPngFullPath = base_path($fileIconPngRelativePath);
                
                if (file_exists($fileIconPngFullPath)) {
                    return asset($fileIconPngRelativePath);
                }
            }else if ($type == 'image') {
                $fileIconPngRelativePath = $imageIconPath . pathinfo($filePath, PATHINFO_FILENAME). '.png';
                $fileIconPngFullPath = base_path($fileIconPngRelativePath);
                
                if (file_exists($fileIconPngFullPath)) {
                    return asset($fileIconPngRelativePath);
                }
            }else if($type == 'menu'){
                $fileIconPngRelativePath = $fileIconPath . $filePath . '.png';
                $fileIconPngFullPath = base_path($fileIconPngRelativePath);

                if (file_exists($fileIconPngFullPath)) {
                    return asset($fileIconPngRelativePath);
                }else{
                    return false;
                }
            }else{
                return $fileIconPngRelativePath;
            }
            
        }
    }
    if($type == 'menu'){
        return false;
    }
    return $defaultIcon;
}


function checkFileGroup($ext){
        $ExtsDoc = array("doc", "docm", "docx", "dot", "dotm", "dotx", "epub", "fodt", "ott", "htm", "html", "mht", "odt", "rtf", "txt", "djvu", "xps");
        $ExtsPre = array("fodp", "odp", "pot", "potm", "potx", "pps", "ppsm", "ppsx", "ppt", "pptm", "pptx", "otp");
        $ExtsSheet = array("xls", "xlsx", "xltx", "ods", "ots", "csv", "xlt", "xltm", "fods");
        $ExtsImage = array("jpg", "jpeg", "png", "gif", "bmp", "webp", "tiff", "tif", "ico", "svg", "heif", "heic", "raw", "nef", "cr2", "orf", "dng");
        $ExtsVideo = array("mp4", "mkv", "avi", "mov", "wmv", "flv", "webm", "mpg", "mpeg", "ogv", "3gp", "3g2", "m4v", "rm", "rmvb", "ts", "vob", "m2ts", "asf", "mts");       
        $ExtsAudio = array("mp3", "wav", "aac", "flac", "ogg", "wma", "m4a", "alac", "aiff", "au", "mid", "midi", "opus", "ra", "ram", "ape", "dsd");
        if (in_array($ext,$ExtsDoc)) {
            return "editor";
        } elseif (in_array($ext,$ExtsPre)) {
            return "editor";
        } elseif (in_array($ext,$ExtsSheet)) {
            return "editor";
        }elseif (in_array($ext,$ExtsImage)) {
            return "image";
         }elseif (in_array($ext,$ExtsVideo)) {
            return "video";
         }elseif (in_array($ext,$ExtsAudio)) {
            return "audio";
         } else {
            return "other";
        }
    
}

function checkLightApp($ext){
    $ExtsDoc = array("doc", "docm", "docx", "dot", "dotm", "dotx", "epub", "fodt", "ott", "htm", "html", "mht", "odt", "rtf", "txt", "djvu", "xps");
    $ExtsPre = array("fodp", "odp", "pot", "potm", "potx", "pps", "ppsm", "ppsx", "ppt", "pptm", "pptx", "otp");
    $ExtsSheet = array("xls", "xlsx", "xltx", "ods", "ots", "csv", "xlt", "xltm", "fods");
    $ExtsImage = array("jpg", "jpeg", "png", "gif", "bmp", "webp", "tiff", "tif", "ico", "svg", "heif", "heic", "raw", "nef", "cr2", "orf", "dng");
    $ExtsVideo = array("mp4", "mkv", "avi", "mov", "wmv", "flv", "webm", "mpg", "mpeg", "ogv", "3gp", "3g2", "m4v", "rm", "rmvb", "ts", "vob", "m2ts", "asf", "mts");       
    $ExtsAudio = array("mp3", "wav", "aac", "flac", "ogg", "wma", "m4a", "alac", "aiff", "au", "mid", "midi", "opus", "ra", "ram", "ape", "dsd");
    if (in_array($ext,$ExtsDoc)) {
        return "Docx";
    } elseif (in_array($ext,$ExtsPre)) {
        return "PPT";
    } elseif (in_array($ext,$ExtsSheet)) {
        return "EXCEL";
    }elseif (in_array($ext,$ExtsImage)) {
        return "DotsImageViewer";
    }elseif (in_array($ext,$ExtsVideo) || in_array($ext,$ExtsAudio)) {
        return "DotsVideoPlayer";
    }else{
        return "DotsDocumentViewer";
    }

}

// Get the size of a single file
function getFileSize($filePath)
{
    // Prepend user storage path
    $filePath =  $filePath;

    // Check if the file exists and return its size
    if (File::exists($filePath)) {
        return formatBytes(File::size($filePath));
    }

    return false;
}

 function getFiletype($file){
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file);
        finfo_close($finfo);
        $mimeParts = explode('/', $mime);
        return $mimeParts[0];
}

// Get the total size of a folder
function folderSize($directory)
{
    // Prepend user storage path
    $directoryPath =  $directory;

    // Resolve the directory path
    if (!File::exists($directoryPath)) {
        $directoryPath = Storage::disk('root')->path($directory);
    }

    $size = 0;

    // Calculate the total size of all files in the directory
    foreach (File::allFiles($directoryPath) as $file) {
        $size += $file->getSize();
    }

    // Format the size to a readable format
    return formatBytes($size);
}


function formatBytes($bytes, $precision = 2)
{
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];

    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);

    $bytes /= (1 << (10 * $pow));

    return round($bytes, $precision) . ' ' . $units[$pow];
}



// Convert file size format
function convertSizeToReadableFormat($size) {
    if ($size >= 1073741824) {
        $size = number_format($size / 1073741824, 2) . ' GB';
    } elseif ($size >= 1048576) {
        $size = number_format($size / 1048576, 2) . ' MB';
    } elseif ($size >= 1024) {
        $size = number_format($size / 1024, 2) . ' KB';
    } 
    else {
        $size = $size . ' KB';
    }
    return $size;
}

function filterView($type, $value)
{
    $user = Auth::user();

    if (!$user) {
        return false;
    }

    if ($user->usertype !== 'user') {
        return true;
    }

    $role = Role::find($user->role_id);
    if (!$role) {
        return false;
    }

    $permissions = json_decode($role->permissions, true);
    if (!$permissions || !is_array($permissions)) {
        return false;
    }

    if ($type == 'route') {
        $permisiionlistexist =  PermissionList::where('route', $value)
            ->exists();
        if($permisiionlistexist){    
            return PermissionList::whereIn('id', $permissions)
                ->where('route', $value)
                ->exists() ? true : false;
        }else{
            return true;
        }
    }

    if ($type == 'function') {
        $permisiionlistexist =  PermissionList::where('permission_keyword', $value)
            ->exists();
        if($permisiionlistexist){    
            return PermissionList::whereIn('id', $permissions)
                ->where('permission_keyword', $value)
                ->exists() ? true : false;
        }else{
            return true;
        }
    }

    return false;
}


function checkSpecificTo($app)
{
    $user = Auth::user();

    if (!$user) {
        return false;
    }

    if (!empty($app->specific_to)) {
    
        $specificToArray = explode(',', $app->specific_to); 
        if (!in_array($user->usertype, $specificToArray)) {
            return false;
        }else{
            return true;
        }
    }else{
        return true;
    }
}



function canShowMenu($menu)
{
    $user = Auth::user();

    if (!$user) {
        return false;
    }

    if (!empty($menu->specific_to)) {
        $specificToArray = explode(',', $menu->specific_to); 
        if (!in_array($user->usertype, $specificToArray)) {
            return false;
        }
    }

    if ($user->usertype == 'company' && in_array($menu->route, ['clients'])) {
        return false;
    }

    if ($user->usertype == 'group' && in_array($menu->route, ['clients', 'company', 'groups.index'])) {
        return false;
    }

    if ($user->usertype == 'user') {
        if (in_array($menu->route, ['clients', 'company', 'groups.index'])) {
            return false;
        }

        $role = Role::find($user->role_id);
        if (!$role) {
            return false;
        }

        $permissions = json_decode($role->permissions, true);
        if (!$permissions || !is_array($permissions)) {
            return false;
        }

        $hasPermission = PermissionList::whereIn('id', $permissions)
            ->where('route', $menu->route)
            ->exists();

        if (!$hasPermission) {
            $routeExists = PermissionList::where('route', $menu->route)->exists();

            if (!$routeExists && !isRestrictedMenu($menu->route)) {
                return true;
            }
            return false;
        }
    }

    // If menu does not exist in PermissionList table, allow it if it's not restricted
    

    return true;
}

function isRestrictedMenu(string $route): bool
{
    $restrictedPrefixes = ['clients', 'company', 'groups.index'];

    foreach ($restrictedPrefixes as $prefix) {
        if (str_starts_with($route, $prefix)) {
            return true;
        }
    }

    return false;
}


?>