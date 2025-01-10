<?php

namespace App\Providers;

use App\Models\UserWallpaper;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Wallpaper;
use App\Models\SettingMenu;
use App\Models\ContextType;
use App\Models\Group;
use Illuminate\Support\Facades\Session;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {

             View::composer('*', function ($view) {
                $menus = SettingMenu::where('status', 1)->get();
                $view->with('menus', $menus);
            });
            /// adding rightclick options

                View::composer('layouts.filemanager-header', function ($view) {
                    $contexttypes = ContextType::with(['contextOptions' => function ($query) {
                        $query->orderBy('sort_order', 'asc'); // Sort options by sort_order
                    }])
                        ->where('display_header', 1)
                        ->whereIn('function', ['createFileFunction', 'resizeFunction', 'sortFunction']) // Fetch all functions in one query
                        ->orderBy('sort_order', 'asc') // Sort context types by sort_order
                        ->get();

                    $user = auth()->user();
                    $groups = Group::orderBy('name')->where('company_id',$user->company_id)->get();

                    // Separate the context types by function
                    $contextTypes = $contexttypes->where('function', 'createFileFunction');
                    $resizecontextTypes = $contexttypes->where('function', 'resizeFunction');
                    $sortcontextTypes = $contexttypes->where('function', 'sortFunction');
                    $view->with(compact( 'contextTypes', 'resizecontextTypes', 'sortcontextTypes','groups'));
                });
                View::composer('*', function ($view) {
                    $is_list = Session::has('is_list') ? Session::get('is_list') : 0;
                    $sortorder = Session::has('sortorder') ? Session::get('sortorder') : 'asc';
                    $sortby = Session::has('sortby') ? Session::get('sortby') : 'id';
                    $iconsize = Session::has('iconsize') ? Session::get('iconsize') : 'medium';
                    $view->with(compact('is_list','sortorder','sortby','iconsize'));

                });


    }
}
