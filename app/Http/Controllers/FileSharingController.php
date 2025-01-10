<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LightAppRequest;
use App\Models\LiteAppModel;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Jobs\FileSharingMailSend;
use App\Models\App;
use App\Models\File;
use App\Models\FileSharing;
use App\Models\FileSharingGroups;
use App\Models\FileSharingRoles;
use App\Models\FileSharingUsers;
use App\Models\Folder;
use App\Models\Group;
use App\Models\RecycleBin;
use App\Models\Roles;
use App\Models\User;
use Carbon\Carbon;
use Hashids;
use Maatwebsite\Excel\Facades\Excel; 
use App\Exports\ShareExport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;


class FileSharingController extends Controller
{
    public function GetUrl(Request $request)
    {       
        $groups = Group::get();
        $roles = Roles::get();
        $users = User::get();
        $now = Carbon::now();
        // $viewCount = $downloadCount = 0;
        $today = $now->format('Y-m-d H:i:s');
        $filetype = $request->input('filetype');
        $id = base64UrlDecode($request->input('filekey'));  // file-id
        if ($filetype == "folder") {
            $file = File::find($id);
            $check = FileSharing::where('folders_id', $id)->first();
            if($check){
                $viewCount = $check->views;
                $downloadCount = $check->downloads;
                //$expiryDate = $check->expiry;
            }else{
                $viewCount = 0;
                $downloadCount = 0;
            } 
            if ($check) {
                $paths = explode('/', $check->url);
                $hashed = $paths[2];
            } else {
                $hashed = Hashids::encode($id) . 'o' . uniqid();
            }
        }  
        else {
            $file = File::find($id);
            $check = FileSharing::where('files_id', $id)->first();
            if($check){
                $viewCount = $check->views;
                $downloadCount = $check->downloads;
                //$expiryDate = $check->expiry;
                // $expiryDate = Carbon::parse($expiryDate);
                // if ($expiryDate <= Carbon::parse($today)) {
                //     $check->is_expired = 1;
                //     $check->save();
                // }
            }else{
                $viewCount = 0;
                $downloadCount = 0;
                // $expiryDate = 0;
            }            
            
            if ($check) {
                $paths = explode('/', $check->url);
                $hashed = $paths[2];
            } else {
                $hashed = Hashids::encode($id) . 'i' . uniqid();
            }
        }
        $selectedUsers = [];
        $selectedGroups = [];
        $selectedRoles = [];
        $selectedUsersEdit = [];
        $selectedGroupsEdit = [];
        $selectedRolesEdit = [];
        $expiry = '';
        $password = '';
        $oldId = '';
        if (isset($check)) {
            $selectedUsers = FileSharingUsers::where('file_sharing_id', $check->id)->where('is_write', 0)->pluck('users_id')->toArray();
            $selectedGroups = FileSharingGroups::where('file_sharing_id', $check->id)->where('is_write', 0)->pluck('groups_id')->toArray();
            $selectedRoles = FileSharingRoles::where('file_sharing_id', $check->id)->where('is_write', 0)->pluck('roles_id')->toArray();
            $selectedUsersEdit = FileSharingUsers::where('file_sharing_id', $check->id)->where('is_write', 1)->pluck('users_id')->toArray();
            $selectedGroupsEdit = FileSharingGroups::where('file_sharing_id', $check->id)->where('is_write', 1)->pluck('groups_id')->toArray();
            $selectedRolesEdit = FileSharingRoles::where('file_sharing_id', $check->id)->where('is_write', 1)->pluck('roles_id')->toArray();
            $expiry = $check->expiry;
            $password = $check->password;
            $oldId = $check->id;
        }

        $html = view('appendview.share', compact(
            'hashed',
            'file',
            'filetype',
            'today',
            'users',
            'groups',
            'roles',
            'selectedUsers',
            'selectedGroups',
            'selectedRoles',
            'selectedUsersEdit',
            'selectedGroupsEdit',
            'selectedRolesEdit',
            'expiry',
            'password',
            'oldId',
            'viewCount',
            'downloadCount'
        ))->render();

        return response()->json(['html' => $html]);
    }

    public function store(Request $request)
    {
        try {                     
            DB::beginTransaction();
            $filetype = $request->filetype; 
            $hashed = $request->id;
            
            // Split by 'i' or 'o' and get the first part (the encoded ID part)
            $encodedPart = explode('i', $hashed)[0];
            $encodedPart = explode('o', $encodedPart)[0];
            
            // Decode the extracted part
            $decodedArray = Hashids::decode($encodedPart);
            $id = $decodedArray[0];   
            // $id = Hashids::decode(substr($hashed, 0, 8))[0]; 
            
            if ($request->oldId == null) {
                $share = new FileSharing();
                if ($filetype == "folder") {
                    $share->folders_id = $id;
                } else {
                    $share->files_id = $id;
                }
                $share->sharedby_users_id = Auth::user()->id;
                $share->url = str_replace(url('/'), '', $request->url);
            } else {
                $share = FileSharing::find($request->oldId);
                FileSharingRoles::where('file_sharing_id', $share->id)->delete();
                FileSharingGroups::where('file_sharing_id', $share->id)->delete();
                FileSharingUsers::where('file_sharing_id', $share->id)->delete();
            }
            $share->password = $request->password;
            if ($request->expirydate != null) {
                $share->expiry = Carbon::parse($request->expirydate);
            }
            $share->save();
            $users = [];
            foreach ($request->users ?? [] as $value) {
                $User = new FileSharingUsers();
                $User->users_id = $value;
                $User->file_sharing_id = $share->id;
                if (in_array($value, $request->edit_users ?? [])) {
                    $User->is_write = 1;
                }
                $User->save();
                //push all users to array
                if (!in_array($value, $users)) {
                    $users[] = $value;
                }
            }
            foreach ($request->groups ?? [] as $value) {                
                $Groups = new FileSharingGroups();
                $Groups->groups_id = $value;
                $Groups->file_sharing_id = $share->id;
                if (in_array($value, $request->edit_groups ?? [])) {
                    $Groups->is_write = 1;
                }
                $Groups->save();

                //push all users to array
                // $dbgroup = Group::find($value);
                // foreach ($dbgroup->users ?? [] as $user) {
                //     if (!in_array($user->id, $users)) {
                //         $users[] = $user->id;
                //     }
                // }

                $dbgroup = User::where('groupID', $value)->get();
                foreach ($dbgroup ?? [] as $user) {
                    if (!in_array($user->id, $users)) {
                        $users[] = $user->id;
                    }
                }
                
            }
            foreach ($request->roles ?? [] as $value) {
                //echo 'ok';die;
                $Roles = new FileSharingRoles();
                $Roles->roles_id = $value;
                $Roles->file_sharing_id = $share->id;
                if (in_array($value, $request->edit_roles ?? [])) {
                    $Roles->is_write = 1;
                }
                $Roles->save();
                
                //push all users to array
                // $dbrole = Roles::find($value);
                // foreach ($dbrole->users ?? [] as $user) {
                //     if (!in_array($user->id, $users)) {
                //         $users[] = $user->id;
                //     }
                // }
               
                $dbrole = User::where('roleID', $value)->get();
                foreach ($dbrole ?? [] as $user) {
                    if (!in_array($user->id, $users)) {
                        $users[] = $user->id;
                    }
                }
            }
            foreach ($request->edit_users ?? [] as $value) {
                $check = FileSharingUsers::where('users_id', $value)->where('file_sharing_id', $share->id)->first();
                if ($check == null) {
                    $User = new FileSharingUsers();
                    $User->users_id = $value;
                    $User->file_sharing_id = $share->id;
                    $User->is_write = 1;
                    $User->save();
                }

                //push all users to array
                if (!in_array($value, $users)) {
                    $users[] = $value;
                }
            }
            foreach ($request->edit_groups ?? [] as $value) {
                $check = FileSharingGroups::where('groups_id', $value)->where('file_sharing_id', $share->id)->first();
                if ($check == null) {
                    $Group = new FileSharingGroups();
                    $Group->groups_id = $value;
                    $Group->file_sharing_id = $share->id;
                    $Group->is_write = 1;
                    $Group->save();
                }

                //push all users to array
                $dbgroup = Group::find($value);
                foreach ($dbgroup->users ?? [] as $user) {
                    if (!in_array($user->id, $users)) {
                        $users[] = $user->id;
                    }
                }
            }
            foreach ($request->edit_roles ?? [] as $value) {
                $check = FileSharingRoles::where('roles_id', $value)->where('file_sharing_id', $share->id)->first();
                if ($check == null) {
                    $Role = new FileSharingRoles();
                    $Role->roles_id = $value;
                    $Role->file_sharing_id = $share->id;
                    $Role->is_write = 1;
                    $Role->save();
                }

                //push all users to array
                $dbrole = Roles::find($value);
                foreach ($dbrole->users ?? [] as $user) {
                    if (!in_array($user->id, $users)) {
                        $users[] = $user->id;
                    }
                }
            }  
             
            //if ($request->oldId == null) {                
                $url = url('/') . '/sharing/' . $hashed; 
                foreach ($users as $user) {
                    FileSharingMailSend::dispatch($user, $share, $url);
                }
            //}
            
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th);
            return response()->json(['error' => $th->getMessage()]);
        }
        return redirect()->back()->with('success', "File shared successfully.");
    }

    
    public function updateFileDownloadCount(Request $request){
        $id = $request->fileId; 
        $file = FileSharing::where('files_id', $id)->first();
        $viewDownload = ($file->downloads) + 1;
        $file->downloads = $viewDownload;
        $file->save();          
        //return view('dashboard');       
    }

    public function updateFolderDownloadCount(Request $request){
        $id = $request->fileId; 
        $file = FileSharing::where('folders_id', $id)->first();
        $viewDownload = ($file->downloads) + 1;
        $file->downloads = $viewDownload;
        $file->save();          
        //return view('dashboard');       
    }
    
    public function FileView($id)
    {     
        $data = FileSharing::where('url', 'LIKE', '%' . $id . '%')->first();        
        //$type = substr($id, 8, 1) == 'i' ? "File" : "Folder"; die;
        $encodedPart = explode('i', $id)[0];
        $encodedPart = explode('o', $encodedPart)[0];
        
        $decodedArray = Hashids::decode($encodedPart);
        $id = $decodedArray[0]; 
        
        $file = File::find($id);
        $fileType = $file->folder;

        if ($fileType == "1") { $type = "Folder"; } else { $type = "File";}

        if ($data) {            
            $users = [];
            $users[] = $data->sharedby_users_id;
            // $groups = FileSharingGroups::where('file_sharing_id', $data->id)->get();
            $groups = FileSharingGroups::where('file_sharing_id', $id)->get();
            foreach ($groups ?? [] as $group) {
                $dbgroup = Group::find($group->groups_id);
                foreach ($dbgroup->users ?? [] as $user) {
                    if (!in_array($user->id, $users)) {
                        $users[] = $user->id;
                    }
                }
            }

            $roles = FileSharingRoles::where('file_sharing_id', $id)->get();
            foreach ($roles ?? [] as $role) {
                $dbrole = Roles::find($role->roles_id);
                foreach ($dbrole->users ?? [] as $user) {
                    if (!in_array($user->id, $users)) {
                        $users[] = $user->id;
                    }
                }
            }

            $dbusers = FileSharingUsers::where('file_sharing_id', $id)->get();
            foreach ($dbusers ?? [] as $user) {
                if (!in_array($user->users_id, $users)) {
                    $users[] = $user->users_id;
                }
            }

            $currentuser = Auth::user();
            if (in_array($currentuser->id, $users)) {
                // return true;
               if ($id != null && $type == "File") {
                    $fileShare = FileSharing::where('files_id', $id)->first();
                    $today = Carbon::now();
                    FileSharing::where('expiry', '<', $today)->where('expiry', '!=', null)->where('files_id', $id)->delete();
                    FileSharingGroups::where('file_sharing_id', $fileShare->id)->delete();
                    FileSharingRoles::where('file_sharing_id', $fileShare->id)->delete();
                    FileSharingUsers::where('file_sharing_id', $fileShare->id)->delete();                  

                    $files = File::where('id', $id)->first();
                    $path = $files->path;

                    $viewCount = ($fileShare->views) + 1;
                    $fileShare->views = $viewCount;
                    $fileShare->save();
                    return view('sharing.fileview', compact('data', 'files', 'path', 'id'));
                } 
                elseif ($id != null && $type == "Folder") {
                    $fileShare = FileSharing::where('folders_id', $id)->first();
                    $today = Carbon::now();
                    FileSharing::where('expiry', '<', $today)->where('expiry', '!=', null)->where('files_id', $id)->delete();
                    // FileSharingGroups::where('file_sharing_id', $fileShare->id)->delete();
                    // FileSharingRoles::where('file_sharing_id', $fileShare->id)->delete();
                    // FileSharingUsers::where('file_sharing_id', $fileShare->id)->delete();

                    $files = File::where('id', $id)->first();
                    $path = $files->path;

                    //$file = FileSharing::where('folders_id', $id)->first();
                    $viewCount = ($fileShare->views) + 1;
                    $fileShare->views = $viewCount;
                    $fileShare->save();                    
                    return view('sharing.folderview', compact('data', 'path', 'id'));
                }
            } 
            else {
                return response("You don't have permission to access this file or folder.", 200);
            }
        } 
        elseif (Auth::id() == $file->created_by) {
            $data = $file;
            if ($id != null && $type == "File") {
                $files = File::where('id', $id)->first();
                $path = $files->path;
                return view('sharing.fileview', compact('data', 'files', 'path', 'id'));
            } 
            else{
                $files = File::where('id', $id)->first();
                $path = $files->path;
                return view('sharing.folderview', compact('data', 'path', 'id'));
            }           
        } 
        else {
            return response('Link not exist or expired.', 400);
        }
    }

    public function showPasswordForm($id)
    {
        $data = FileSharing::where('url', 'LIKE', '%' . $id . '%')->first();
        return view('sharing.password', compact('data', 'id'));
    }

    public function verifyPassword(Request $request, $id)
    {
        $data = FileSharing::where('url', 'LIKE', '%' . $id . '%')->first();
        if ($data && $data->password == $request->password) {
            Session::put("file_password_confirmed_{$id}", true);
            // Redirect to the file view
            return redirect()->route('FileSharing', ['id' => $id]);
        } else {
            return redirect()->back()->withErrors(['password' => 'Incorrect password']);
        }
    }

    public function pathfiledetail(Request $request)
    {
        // Get the updated app list HTML 
        $filepath = urldecode($request->input('path'));
        $parentPath = empty($filepath) ? '/' : $filepath; // Adjust this path as needed
        $defaultfolders = array();
        $folders = array();
        $files = array();
        if ($filepath != 'RecycleBin') {
            $defaultfolders = App::where('parentpath', $parentPath)->where('filemanager_display', 1)->where('status', 1)->orderBy('name')->get();
            $folders = File::where('parentpath', $parentPath)->where('status', 1)->get();
            $files = File::where('parentpath', $parentPath)->where('status', 1)->get();
        } else {
            $folders = RecycleBin::where('tablename', 'folder')->get();
            $files = RecycleBin::where('tablename', 'file')->get();
        }
        $html = view('appendview.sharingpathview')->with('folders', $folders)->with('defaultfolders', $defaultfolders)->with('files', $files)->render();
        return response()->json(['html' => $html, 'filepath' => $filepath]);
    }

    public function index2($path = null)
    {
        $path = $path ? urldecode($path) : '/';
        return view('sharing.folderview', compact('path'));
    }

    public function shareLogs()
    {

        $log = FileSharing::with('sharedByUser', 'folder', 'file')->orderBy('created_at', 'desc')->paginate(8);
        $roles = Roles::get();
        return view('sharing.sharelog', compact('log', 'roles'));
    }

    public function Expire()
    {
        $today = Carbon::now();
        FileSharing::where('expiry', '<', $today)->where('expiry', '!=', null)->delete();
        return true;
    }

    public function filter(Request $request)
    {

        $filter = $request->input('filter');
        $query = FileSharing::with('sharedByUser');

        $roleId = @$request->roles ? $request->roles : 0;

        switch ($filter) {
            case 'today':
                $query->whereDate('created_at', Carbon::today());
                break;
            case '7-days':
                $query->where('created_at', '>=', Carbon::today()->subDays(7));
                break;
            case '30-days':
                $query->where('created_at', '>=', Carbon::today()->subDays(30));
                break;
            case 'role':
                if ($roleId) {
                    $query->whereHas('sharedByUser', function ($query) use ($roleId) {
                        $query->where('roleID', $roleId);
                    });
                }

                break;
            case 'dateTime':

                $query->whereBetween('created_at', [
                    date('Y-m-d H:i:s', strtotime($request->start_date_time)),
                    date('Y-m-d H:i:s', strtotime($request->end_date_time))
                ]);



                break;

            default:
                break;
        }

        $log = $query->take(7)->get();

        $view = view('partials.shareLogEntries', compact('log'))->render();

        return response()->json(['html' => $view]);
    }
    
    public function export(Request $request)
    {
        // Add some logging to check if this method is being called
        \Log::info('LoginController export method called');

        return Excel::download(new ShareExport($request), 'Share.xlsx');
    }
    
    public function cancelShare($id)
    {
        // Find the record by ID and delete it

        $log = FileSharing::find($id);

        if ($log) {
            $log->delete();
            return response()->json(['success' => 'Record deleted successfully!']);
        } else {
            return response()->json(['error' => 'Record not found!'], 404);
        }
    }
    
    public function shareLinks()
    {
        return view('sharing.sharelinks');
    }


    public function cancelShare2(Request $request)
    {
        // Find the record by ID and delete it

        // $log = FileSharing::find($id);


        // $log->delete();      
        FileSharing::whereIn('folders_id', $request->folderIds)->delete();
        FileSharing::whereIn('files_id', $request->fileIds)->delete();

        return response()->json(['success' => 'Record deleted successfully!']);
        
    }
   
}
