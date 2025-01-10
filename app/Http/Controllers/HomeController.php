<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LightApp;
use App\Models\App;
use App\Models\LightAppCategory;
use App\Helpers\PermissionHelper;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function dashboard()
    {
        $apps = App::where('desktop_display', 1)->where('status', 1)->get();
        $menuapps = App::where('display_administrator', '!=', 0)
                ->where('status', 1)
                ->orderBy('display_administrator', 'asc')
                ->get();

        $lightApps = LightApp::with('category')->get();
        $path = url();
        $path ='/';
        return view('dashboard', compact('apps', 'lightApps', 'menuapps'));       
    }

    public function desktop()
    {
        $apps = App::all();
        $lightApps = LightApp::with('category')->get();
        $path = url();
        //$path = $path ? urldecode($path) : '/';
        $path ='/';
        return view('app', compact('apps', 'lightApps','path'));
       
    }
}
