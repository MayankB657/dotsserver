<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\LightApp;
use App\Models\LightAppCategory;
use App\Models\File as FileModel;
use App\Models\Folder;
use Illuminate\Support\Facades\Session;



class LightAppController extends Controller
{

    protected $filefunctions;
    public function __construct(Filefunctions $filefunctions)
    {
        $this->middleware('auth');

        $this->filefunctions = $filefunctions;
        
    }
    
    public function index()
    {
        $categories = LightAppCategory::all();
        return view('lightapp', compact('categories'));
    }

    public function updateLightApp(Request $request)
    {
        $lightAppId = $request->input('light_app_id');

        // Update the add_app column for the specified light app
        LightApp::where('id', $lightAppId)->update(['add_app' => 1]);

        // Get the updated app list HTML
        $lightApps = LightApp::where('add_app', 1)->get();
        $html = view('appendview.lightappdashboard')->with('lightApps', $lightApps)->render();

        return response()->json(['html' => $html]);
    }

    // public function alladdedapps(Request $request){
    //      // Get the updated app list HTML
    //     $parentPath = 'Desktop';// Adjust this path as needed
    //     $sortby= !empty($request->input('sort_by')) ? $request->input('sort_by') : 'id';
    //     $sortorder= !empty($request->input('sort_order')) ? $request->input('sort_order') : 'asc';
    //     $files = FileModel::where('parentpath', $parentPath)->where('status', 1)->where('created_by', auth()->id())->orderBy($sortby, $sortorder)->get();
    //     $lightApps = LightApp::where('add_app', 1)->get();
    //     $html = view('appendview.lightappdashboard')->with('lightApps', $lightApps)->with('files', $files)->render();
    //     return response()->json(['html' => $html]);

    // }

    public function alladdedapps(Request $request)
    {
        $filetypeOrder = "FIELD(filetype, NULL, 'application', 'image', 'video', 'audio')";
        $parentPath = 'Desktop';
        /// save session 
        $dataArray = [];
        $sortby = $request->input('sort_by') 
        ?? (Session::has('sort_by') && !empty(Session::get('sort_by')) 
            ? Session::get('sort_by') 
            : 'name');
    
        $sortorder = $request->input('sort_order') 
           ?? (Session::has('sort_order') && !empty(Session::get('sort_order')) 
               ? Session::get('sort_order') 
               : 'asc');
        $iconsize = $request->input('iconsize')?? 
                (Session::has('iconsize') && !empty(Session::get('iconsize')) 
                ? Session::get('iconsize') 
                : 'medium');
        
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
       
        if ($sortby == "id") {
            $files = FileModel::where('parentpath', $parentPath)
                ->where('status', 1)
                ->where('created_by', auth()->user()->id)
                ->orderByRaw($filetypeOrder) 
                ->orderBy($sortby, $sortorder) 
                ->get();
        } else {
            $files = FileModel::where('parentpath', $parentPath)
                ->where('status', 1)
                ->where('created_by', auth()->user()->id)
                ->orderBy($sortby, $sortorder) 
                ->get();
        }
        $lightApps = LightApp::where('add_app', 1)->get();
        $html = view('appendview.lightappdashboard')
            ->with('lightApps', $lightApps)
            ->with('files', $files)
            ->render();
        return response()->json(['html' => $html,'iconsize'=>$iconsize,'sortby'=>$sortby,'sortorder'=>$sortorder]);
    }


    public function allLightApps(Request $request)
    {
        $categoryId = $request->input('category_id');
        $lightApps = LightApp::where('group', $categoryId)->get();
        if (empty($categoryId)) {
            $lightApps = LightApp::all();
        }
        $html = view('appendview.lightapp')->with('lightApps', $lightApps)->render();
        return response()->json(['html' => $html]);
    }
}
