<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LightAppController;
use App\Http\Controllers\FileManagerController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginLogController;
use App\Http\Controllers\OperationLogController;
use App\Http\Controllers\OverviewController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\FileSharingController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\AnaliticsController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingsController;
use App\Jobs\ConfigClearJob;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckPermission;

date_default_timezone_set('Asia/Calcutta');

Route::get('/test', function () {
    return view('test');
});
Route::get('/', function () {
    return redirect(route('dashboard'));
});
Route::get('clear', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    // ConfigClearJob::dispatch();
    return view('errors.clear');
})->name('clear');

Route::get('dummydata',function(){
    return view('dummy');
});
Route::post('voice',[UserController::class,'voice'])->name('voice');

Route::get('admindocs',function(){
    return view('docs.admin');
});

//Suspend user middleware wil also use for IPaddress in future
Route::middleware(['blockIP'])->group(function () {
    //login routes
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'store']);
    Route::post('setfacesupport', [LoginController::class, 'SupportFace'])->name('SupportFace');
    Route::post('imagelogin', [LoginController::class, 'ImageLogin'])->name('ImageLogin');
    Route::post('voicelogin', [LoginController::class, 'VoiceLogin'])->name('VoiceLogin');
    Route::get('checkfacedata', [LoginController::class, 'CheckFaceData'])->name('CheckFaceData');
    Route::get('quote', [LoginController::class, 'Quote'])->name('Quote');

    Route::get('auth/google', [LoginController::class, 'GoogleLogin'])->name('GoogleLogin');
    Route::get('auth/google/callback', [LoginController::class, 'GoogleCallback'])->name('GoogleCallback');

    //all routs which require authenticated user under this
    Route::middleware(['auth'])->group(static function () {
            Route::resource('profile',ProfileController::class);
            Route::middleware([CheckPermission::class])->group(function () {

        //Usermanagement

                Route::get('users', [UserController::class, 'index'])->name('users.index');
                Route::get('users/list',[UserController::class,'userlist'])->name('userlist');
                Route::get('users/add', [UserController::class, 'addUser'])->name('adduser');
                Route::post('users/store', [UserController::class, 'store'])->name('users.store');
                Route::get('users/edit', [UserController::class, 'editUser'])->name('edituser');
                Route::put('users/update/{user}', [UserController::class, 'update'])->name('users.update');
                Route::get('users/{id}', [UserController::class, 'show']);   // Show a specific user by ID
                Route::post('user/toggle-status', [UserController::class, 'toggleStatus'])->name('user.togglestatus');
                Route::post('user/delete', [UserController::class, 'deleteUser'])->name('deleteuser');
                Route::post('import-users', [UserController::class, 'importUsers'])->name('import-users');
                Route::get('download-user-sample', function () {
                    $file = public_path() . "/samples/sample-users.xlsx";
                    return response()->download($file);
                })->name('download-user-sample');
                Route::get('users/role/{roleId}', [UserController::class, 'getUsersByRole'])->name('users.byRole');
                Route::post('profilepic', [UserController::class, 'ProfilePic'])->name('ProfilePic');



                Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
                Route::get('roles/list', [RoleController::class, 'rolelist'])->name('roles.list');
                Route::get('roles/add', [RoleController::class, 'addRole'])->name('roles.add');
                Route::post('roles/store', [RoleController::class, 'store'])->name('roles.store');
                Route::get('roles/edit', [RoleController::class, 'editRole'])->name('roles.edit');
                Route::put('roles/update/{id}', [RoleController::class, 'update'])->name('roles.update');
                Route::post('roles/delete', [RoleController::class, 'deleteRole'])->name('roles.delete');

                Route::get('groups', [GroupController::class, 'index'])->name('groups.index');
                Route::get('groups/list', [GroupController::class, 'grouplist'])->name('groups.list');
                Route::get('groups/add', [GroupController::class, 'addgroup'])->name('groups.add');
                Route::post('groups/store', [GroupController::class, 'store'])->name('groups.store');
                Route::get('groups/edit', [GroupController::class, 'editgroup'])->name('groups.edit');
                Route::put('groups/update/{id}', [GroupController::class, 'update'])->name('groups.update');
                Route::post('groups/delete', [GroupController::class, 'deletegroup'])->name('groups.delete');

                // Company Management
                Route::get('companies', [CompanyController::class, 'index'])->name('company.index');
                Route::get('companies/list', [CompanyController::class, 'companylist'])->name('company.list');
                Route::get('companies/add', [CompanyController::class, 'addcompany'])->name('company.add');
                Route::post('companies/store', [CompanyController::class, 'store'])->name('company.store');
                Route::get('companies/edit', [CompanyController::class, 'editcompany'])->name('company.edit');
                Route::put('companies/update/{id}', [CompanyController::class, 'update'])->name('company.update');
                Route::post('companies/delete', [CompanyController::class, 'deletecompany'])->name('company.delete');
                Route::get('company/groups', [GroupController::class, 'index'])->name('company.group.index');
                Route::get('company/groups/list', [GroupController::class, 'grouplist'])->name('company.group.list');
                Route::get('company/groups/add', [GroupController::class, 'addgroup'])->name('company.group.add');
                Route::post('company/groups/store', [GroupController::class, 'store'])->name('company.group.store');
                Route::get('company/groups/edit', [GroupController::class, 'editgroup'])->name('company.group.edit');
                Route::put('company/groups/update/{id}', [GroupController::class, 'update'])->name('company.group.update');
                Route::post('company/groups/delete', [GroupController::class, 'deletegroup'])->name('company.group.delete');
                Route::get('company/roles', [RoleController::class, 'index'])->name('company.role.index');
                Route::get('company/roles/list', [RoleController::class, 'rolelist'])->name('company.role.list');
                Route::get('company/roles/add', [RoleController::class, 'addrole'])->name('company.role.add');
                Route::post('company/roles/store', [RoleController::class, 'store'])->name('company.role.store');
                Route::get('company/roles/edit', [RoleController::class, 'editrole'])->name('company.role.edit');
                Route::put('company/roles/update/{id}', [RoleController::class, 'update'])->name('company.role.update');
                Route::post('company/roles/delete', [RoleController::class, 'deleterole'])->name('company.role.delete');
                Route::get('company/users', [UserController::class, 'index'])->name('company.user.index');
                Route::get('company/users/list', [UserController::class, 'userlist'])->name('company.user.list');
                Route::get('company/users/add', [UserController::class, 'adduser'])->name('company.user.add');
                Route::post('company/users/store', [UserController::class, 'store'])->name('company.user.store');
                Route::get('company/users/edit', [UserController::class, 'edituser'])->name('company.user.edit');
                Route::put('company/users/update/{user}', [UserController::class, 'update'])->name('company.user.update');
                Route::post('company/users/delete', [UserController::class, 'deleteuser'])->name('company.user.delete');


                // Client Management
                Route::get('clients', [ClientController::class, 'index'])->name('clients.index');
                Route::get('clients/list', [ClientController::class, 'clientlist'])->name('clients.list');
                Route::get('clients/add', [ClientController::class, 'addclient'])->name('clients.add');
                Route::post('clients/store', [ClientController::class, 'store'])->name('clients.store');
                Route::get('clients/edit', [ClientController::class, 'editclient'])->name('clients.edit');
                Route::put('clients/update/{id}', [ClientController::class, 'update'])->name('clients.update');
                Route::post('clients/delete', [ClientController::class, 'deleteclient'])->name('clients.delete');
                Route::get('client/companies', [CompanyController::class, 'index'])->name('client.company.index');
                Route::get('client/companies/list', [CompanyController::class, 'companylist'])->name('client.company.list');
                Route::get('client/companies/add', [CompanyController::class, 'addcompany'])->name('client.company.add');
                Route::post('client/companies/store', [CompanyController::class, 'store'])->name('client.company.store');
                Route::get('client/companies/edit', [CompanyController::class, 'editcompany'])->name('client.company.edit');
                Route::put('client/companies/update/{id}', [CompanyController::class, 'update'])->name('client.company.update');
                Route::post('client/companies/delete', [CompanyController::class, 'deletecompany'])->name('client.company.delete');
                Route::get('client/groups', [GroupController::class, 'index'])->name('client.group.index');
                Route::get('client/groups/list', [GroupController::class, 'grouplist'])->name('client.group.list');
                Route::get('client/groups/add', [GroupController::class, 'addgroup'])->name('client.group.add');
                Route::post('client/groups/store', [GroupController::class, 'store'])->name('client.group.store');
                Route::get('client/groups/edit', [GroupController::class, 'editgroup'])->name('client.group.edit');
                Route::put('client/groups/update/{id}', [GroupController::class, 'update'])->name('client.group.update');
                Route::post('client/groups/delete', [GroupController::class, 'deletegroup'])->name('client.group.delete');
                Route::get('client/roles', [RoleController::class, 'index'])->name('client.role.index');
                Route::get('client/roles/list', [RoleController::class, 'rolelist'])->name('client.role.list');
                Route::get('client/roles/add', [RoleController::class, 'addrole'])->name('client.role.add');
                Route::post('client/roles/store', [RoleController::class, 'store'])->name('client.role.store');
                Route::get('client/roles/edit', [RoleController::class, 'editrole'])->name('client.role.edit');
                Route::put('client/roles/update/{id}', [RoleController::class, 'update'])->name('client.role.update');
                Route::post('client/roles/delete', [RoleController::class, 'deleterole'])->name('client.role.delete');
                Route::get('client/users', [UserController::class, 'index'])->name('client.user.index');
                Route::get('client/users/list', [UserController::class, 'userlist'])->name('client.user.list');
                Route::get('client/users/add', [UserController::class, 'adduser'])->name('client.user.add');
                Route::post('client/users/store', [UserController::class, 'store'])->name('client.user.store');
                Route::get('client/users/edit', [UserController::class, 'edituser'])->name('client.user.edit');
                Route::put('client/users/update/{user}', [UserController::class, 'update'])->name('client.user.update');
                Route::post('client/users/delete', [UserController::class, 'deleteuser'])->name('client.user.delete');
                Route::get('client/company/groups', [GroupController::class, 'index'])->name('client.company.group.index');
                Route::get('client/company/groups/list', [GroupController::class, 'grouplist'])->name('client.company.group.list');
                Route::get('client/company/groups/add', [GroupController::class, 'addgroup'])->name('client.company.group.add');
                Route::post('client/company/groups/store', [GroupController::class, 'store'])->name('client.company.group.store');
                Route::get('client/company/groups/edit', [GroupController::class, 'editgroup'])->name('client.company.group.edit');
                Route::put('client/company/groups/update/{id}', [GroupController::class, 'update'])->name('client.company.group.update');
                Route::post('client/company/groups/delete', [GroupController::class, 'deletegroup'])->name('client.company.group.delete');

                Route::get('client/company/roles', [RoleController::class, 'index'])->name('client.company.role.index');
                Route::get('client/company/roles/list', [RoleController::class, 'rolelist'])->name('client.company.role.list');
                Route::get('client/company/roles/add', [RoleController::class, 'addrole'])->name('client.company.role.add');
                Route::post('client/company/roles/store', [RoleController::class, 'store'])->name('client.company.role.store');
                Route::get('client/company/roles/edit', [RoleController::class, 'editrole'])->name('client.company.role.edit');
                Route::put('client/company/roles/update/{id}', [RoleController::class, 'update'])->name('client.company.role.update');
                Route::post('client/company/roles/delete', [RoleController::class, 'deleterole'])->name('client.company.role.delete');

                Route::get('client/company/users', [UserController::class, 'index'])->name('client.company.user.index');
                Route::get('client/company/users/list', [UserController::class, 'userlist'])->name('client.company.user.list');
                Route::get('client/company/users/add', [UserController::class, 'adduser'])->name('client.company.user.add');
                Route::post('client/company/users/store', [UserController::class, 'store'])->name('client.company.user.store');
                Route::get('client/company/users/edit', [UserController::class, 'edituser'])->name('client.company.user.edit');
                Route::put('client/company/users/update/{user}', [UserController::class, 'update'])->name('client.company.user.update');
                Route::post('client/company/users/delete', [UserController::class, 'deleteuser'])->name('client.company.user.delete');
                Route::get('restorelist', [UserController::class, 'restoreList'])->name('restorelist');
                Route::get('dumpedfilelist', [UserController::class, 'dumpedFileList'])->name('dumpedfilelist');





            });



            //UserController
            Route::get('fetch-companies-by-client', [UserController::class, 'getCompaniesByClient'])->name('fetch.companies.by.client');
            Route::get('fetch-roles-groups-by-client', [UserController::class, 'fetchRolesAndGroupsByClient'])->name('fetch.roles.groups.by.client');


        Route::post('registerfacedata', [LoginController::class, 'RegisterFacedata'])->name('RegisterFacedata');
        Route::post('logout', [LoginController::class, 'destroy'])->name('logout');
        Route::post('profilepic', [UserController::class, 'ProfilePic'])->name('ProfilePic');
        //search
        Route::get('search', [SearchController::class, 'search'])->name('search');

        //file & folder sharing
        Route::resource('fileshare',FileSharingController::class);
        Route::get('getUrl',[FileSharingController::class, 'getUrl'])->name('getUrl');
        Route::get('sharepathdetail', [FileSharingController::class, 'pathfiledetail'])->name('sharepathdetail');
        Route::get('sharing/{id}',[FileSharingController::class,'FileView'])->middleware('filesharingpassword')->name('FileSharing');
        Route::get('sharingp/{path?}', [FileSharingController::class, 'index2'])->where('path', '.*');
        Route::get('sharing/password/{id}', [FileSharingController::class, 'showPasswordForm'])->name('showPasswordForm');
        Route::post('sharing/password/verify/{id}', [FileSharingController::class, 'verifyPassword'])->name('verifyPassword');
        Route::get('linkshare', [FileSharingController::class, 'shareLinks'])->name('linkshare');
        Route::get('sharelogs', [FileSharingController::class, 'shareLogs'])->name('sharelogs');
        Route::get('share-logs/filter', [FileSharingController::class, 'filter'])->name('shareLogs.filter');
        Route::get('export-share', [FileSharingController::class, 'export'])->name('export.share');
        Route::get('cancel-share/{id}', [FileSharingController::class, 'cancelShare'])->name('cancel.share');
        Route::post('cancel-share2', [FileSharingController::class, 'cancelShare2'])->name('cancel.share2');
        Route::post('updateFileDownloadCount', [FileSharingController::class, 'updateFileDownloadCount'])->name('updateFileDownloadCount');
        Route::post('updateFolderDownloadCount', [FileSharingController::class, 'updateFolderDownloadCount'])->name('updateFolderDownloadCount');


        Route::resource('notice',NoticeController::class);
        Route::get('runnow/{id}',[NoticeController::class, 'RunNow']);
        Route::get('read-noti/{id}',[NoticeController::class, 'ReadNoti'])->name('ReadNoti');
        Route::get('read-all',[NoticeController::class, 'ReadAll'])->name('ReadAll');


        //wallpaper routes
                Route::get('wallpaperlist', [SettingsController::class, 'WallpaperList'])->name('wallpaperlist');
                Route::get('wallpaper/desktop', [SettingsController::class, 'index'])->name('wallpaper.desktop');
                Route::get('wallpaper/login', [SettingsController::class, 'index'])->name('wallpaper.login');
                Route::get('theme', [SettingsController::class, 'index'])->name('theme');
                Route::post('wallpaper/store', [SettingsController::class, 'storeWallpaper'])->name('wallpaper.store');
                Route::post('wallpaper/update', [SettingsController::class, 'updateUserWallpaperData'])->name('wallpaper.update');
    });

     Route::get('analitics', [AnaliticsController::class, 'index'])->name('analitics');

    //Logs
    Route::get('Graph-Data', [OverviewController::class, 'getGraphData'])->name('Graph.Data');
    Route::get('get-data', [OverviewController::class, 'getData'])->name('get.data');
    Route::get('Overviews', [OverviewController::class, 'index'])->name('Overviews');
    Route::get('export-overview', [OverviewController::class, 'exportOverview'])->name('export.overview');
    Route::get('export-pdf', [OverviewController::class, 'exportPdf'])->name('export.pdf');
    Route::get('chart-logs/userId', [OverviewController::class, 'chartsData'])->name('chartLogs.userId');
    Route::get('group-usage/userId', [OverviewController::class, 'GroupusageData'])->name('groupUusage.userId');
    Route::get('logs', [LoginLogController::class, 'index'])
    ->name('logs');
    Route::get('login-logs/filter', [LoginLogController::class, 'filter'])->name('loginLogs.filter');
    Route::get('users/role/{roleId}', [UserController::class, 'getUsersByRole'])->name('users.byRole');
    Route::get('filter-records', [LoginLogController::class, 'filterRecords'])->name('filter.records');;
    //operation
    Route::get('activities', [ActivityController::class, 'index'])->middleware('auth');
    Route::get('operation_logs', [OperationLogController::class, 'index'])
    ->name('operation_logs');
    Route::get('operation-logs/filter', [OperationLogController::class, 'filter'])->name('operationLogs.filter');
    Route::get('users/role/{roleId}', [UserController::class, 'getUsersByRole'])->name('users.byRole');
    Route::get('filter-record', [OperationLogController::class, 'filterRecords'])->name('filter.record');;
    //end
    //EXCELL
    Route::get('export-logins', [LoginLogController::class, 'export'])->name('export.logins');
    Route::get('export-operation', [OperationLogController::class, 'export'])->name('export.operations');
    //END
    Route::delete('delete-message', [MessageController::class, 'destroy'])->name('delete-message');
    // Light app start
    Route::get('lightapp', [LightAppController::class, 'index'])->name('lightapp');
    Route::post('createlightapp', [LightAppController::class, 'createLightApp'])->name('createlightapp');
    Route::post('updatelightapp', [LightAppController::class, 'updateLightApp'])->name('updatelightapp');
    Route::get('showlightapp', [LightAppController::class, 'allLightApps'])->name('showlightapp');
    Route::get('desktopapp', [LightAppController::class, 'alladdedapps'])->name('desktopapp');
    //Route::get('list', [LightAppController::class, 'index']);
    //Route::get('add-form', [LightAppController::class, 'add_form']);
    Route::post('submit', [LightAppController::class, 'add_data']);
    Route::get('app_role_list/{type}', [LightAppController::class, 'AppRoleList']);
    Route::post('apps-update/{id}', [LightAppController::class, 'update']);
    Route::get('apps-delete/{id}', [LightAppController::class, 'delete_data']);
    Route::post('add-apps-desktop/{id}', [LightAppController::class, 'apps']);
    //end
    //search
    Route::get('search', [SearchController::class, 'search'])->name('search');
    Route::get('openiframe', [SearchController::class, 'listalliframe'])->name('openiframe');
    Route::get('closeiframe', [SearchController::class, 'closeiframe'])->name('closeiframe');
    //
    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::get('dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('desktop', [HomeController::class, 'desktop'])->name('desktop');
    //user routes

    //Link Share
    Route::get('linkshare/{path?}', [FileSharingController::class, 'shareLinks'])->name('linkshare');
    Route::get('/cancel-share/{id}', [FileSharingController::class, 'cancelShare'])->name('cancel.share');

    Route::post('/cancel-share2', [FileSharingController::class, 'cancelShare2'])->name('cancel.share2');
    Route::get('showsharedetail', [FileManagerController::class, 'sharefiledetail'])->name('showsharedetail');

    /// Filemanager
    Route::post('/filemanager/move', [FileManagerController::class, 'moveFiles'])->name('file.move');
    Route::get('filemanager/{path?}', [FileManagerController::class, 'index'])
    ->where('path', '.*')->name('filemanager');
    Route::get('createfolder', [FileManagerController::class, 'createFolder'])->name('createfolder');
    Route::get('createfile', [FileManagerController::class, 'createFile'])->name('createfile');
    Route::get('editfile/{file}', [FileManagerController::class, 'editfile'])->where('name', '.*')->where('file', '.*')->name('editfile');
    Route::get('showpathdetail', [FileManagerController::class, 'pathfiledetail'])->name('showpathdetail');
    Route::post('upload', [FileManagerController::class, 'upload'])->name('upload');
    Route::post('upload/remove', [FileManagerController::class, 'remove'])->name('upload.remove');
    Route::post('upload/pause', [FileManagerController::class, 'pause'])->name('upload.pause');
    Route::post('upload/resume', [FileManagerController::class, 'resume'])->name('upload.resume');
    Route::post('upload/pause-all', [FileManagerController::class, 'pauseAll'])->name('upload.pauseAll');
    Route::post('upload/clear-all', [FileManagerController::class, 'clearAll'])->name('upload.clearAll');
    Route::post('upload/clear-out', [FileManagerController::class, 'clearOut'])->name('upload.clearOut');
    Route::get('download/{id}', [FileManagerController::class, 'downloadFile']);
    Route::get('renamefile', [FileManagerController::class, 'renameFile'])->name('renamefile');
    Route::get('deletefile', [FileManagerController::class, 'deleteFile'])->name('deletefile');
    Route::get('restorefile', [FileManagerController::class, 'restoreFile'])->name('restorefile');
    Route::get('copyfile', [FileManagerController::class, 'copyFile'])->name('copyfile');
    Route::get('pastefile', [FileManagerController::class, 'pasteFile'])->name('pastefile');
    Route::get('contextmenu', [FileManagerController::class, 'contextMenu'])->name('contextmenu');
    Route::get('dotsimageviewer/{file}', [FileManagerController::class, 'dotsImageViewer'])->where('name', '.*')
    ->where('file', '.*')->name('dotsimageviewer');
    Route::get('dotsvideoplayer/{file}', [FileManagerController::class, 'dotsVideoPlayer'])->where('name', '.*')
    ->where('file', '.*')->name('dotsvideoplayer');
    Route::get('dotsdocumentviewer/{file}', [FileManagerController::class, 'dotsDocumentViewer'])->where('name', '.*')
    ->where('file', '.*')->name('dotsdocumentviewer');
    //comments
    Route::get('getUsers', [MessageController::class, 'getUsers'])->name('getUsers');
    Route::post('saveComment', [MessageController::class, 'saveCommentOrReply'])->name('saveComment');
    // Route::post('sendReply', [MessageController::class, 'sendReply'])->name('sendReply');
    Route::get('getMessage', [MessageController::class, 'getMessageData'])->name('getMessageData');
    Route::get('fileExpSearch', [FileManagerController::class, 'fileExpSearch'])->name('fileExp-list');


});

Route::get('expire-sharing',[FileSharingController::class, 'Expire']);

Route::get('leftarrowclick', [FileManagerController::class, 'leftArrowClick'])->name('leftarrowclick');
Route::get('rightarrowclick', [FileManagerController::class, 'rightArrowClick'])->name('rightarrowclick');

Route::get('/wallpaper', [SettingsController::class, 'index'])->name('wallpaper');
Route::post('/wallpaper/store', [SettingsController::class, 'storeWallpaper'])->name('wallpaper.store');
Route::delete('/wallpaper/delete/{id}', [SettingsController::class, 'deleteWallpaper'])->name('wallpaper.delete');
Route::post('/user_wallpaper/update', [SettingsController::class, 'updateUserWallpaper'])->name('user_wallpaper.update');
Route::get('get-user-theme', [SettingsController::class, 'getUserThemeData'])->name('get-user-theme');

//analytics route
    Route::get('analitics', [AnaliticsController::class, 'index'])->name('analitics.main');
    Route::get('fetch-actType-by-actGroup', [AnaliticsController::class, 'getActivityById'])->name('fetch.actType.by.actGroup');
    Route::get('fetch-graphType-by-actType', [AnaliticsController::class, 'getGraphTypeById'])->name('fetch.graphType.by.actType');
    Route::get('graph-view', [AnaliticsController::class, 'getGraph'])->name('graph.view');
    Route::get('add-graph', [AnaliticsController::class, 'addGraph'])->name('add.graph');
    Route::get('remove-graph', [AnaliticsController::class, 'removeGraph'])->name('remove.graph');
    Route::get('update-graph', [AnaliticsController::class, 'updateGraph'])->name('update.graph');
    Route::delete('delete-graph/{id}', [AnaliticsController::class, 'deleteGraph'])->name('delete.graph');

    //metrics route
    Route::get('analitics-custom-graph', [AnaliticsController::class, 'customGraph'])->name('analitics.custom_main');
    Route::get('fetch-custom-actType-by-actGroup', [AnaliticsController::class, 'getCustomActivityById'])->name('fetch.custom.actType.by.actGroup');
    Route::get('fetch-custom-graphType-by-actType', [AnaliticsController::class, 'getCustomGraphTypeById'])->name('fetch.custom.graphType.by.actType');
    Route::get('custom-graph-view', [AnaliticsController::class, 'getCustomGraph'])->name('custom.graph.view');
    Route::get('add-custom-graph', [AnaliticsController::class, 'addCustomGraph'])->name('add.custom.graph');
    Route::get('remove-custom-graph', [AnaliticsController::class, 'removeCustomGraph'])->name('remove.custom.graph');
    Route::get('update-custom-graph', [AnaliticsController::class, 'updateCustomGraph'])->name('update.custom.graph');
    Route::delete('delete-custom-graph/{id}', [AnaliticsController::class, 'deleteCustomGraph'])->name('delete.custom.graph');

    Route::get('sendverificationcode',[ProfileController::class, 'SendVerificationCode'])->name('SendVerificationCode');

