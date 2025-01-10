<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LightAppController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;




Route::controller(RegisterController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('update/{id}','update');
    Route::post('createUser', 'create');
    Route::post('remember', 'rememberMe');

});

	

Route::middleware('auth:sanctum')->group( function () {


   //Roles routes
	Route::get('role-list', [RolesController::class, 'index']);
	Route::get('role-list/{id}', [RolesController::class, 'index']);
	Route::post('role-create', [RolesController::class, 'create']);
	Route::post('role-update/{id}', [RolesController::class, 'update']);
	Route::get('role-delete/{id}', [RolesController::class, 'destroy']);
  //Permissions routes
	Route::get('permissions-list', [PermissionsController::class, 'index']);
	Route::get('permissions-list/{id}', [PermissionsController::class, 'index']);
	Route::post('permission-create', [PermissionsController::class, 'create']);
	Route::post('permission-update/{id}', [PermissionsController::class, 'update']);
	Route::get('permission-delete/{id}', [PermissionsController::class, 'destroy']);



//Light apps
    Route::resource('apps', LightAppController::class);
	Route::get('app_role_list', [LightAppController::class, 'AppRoleList']);
	Route::post('apps-update/{id}', [LightAppController::class, 'update']);
	Route::post('add-apps-desktop/{id}', [LightAppController::class, 'apps']);

});

