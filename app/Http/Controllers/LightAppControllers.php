<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LightAppRequest;
use App\Models\LiteAppModel;
use Validator;
use Illuminate\Support\Facades\Storage;

class LightAppControllers extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
       $app = LiteAppModel::get();

       return view('lightApp.list', compact('app'));

    }


 public function AppRoleList(Request $request, $type)

    {
       
     $app = LiteAppModel::where('app_group',$type)->get();
    
     return view('lightApp.list', ['app' => $app]);

 }
    /**
     * Show the form for creating a new resource.
     */
    public function add_form()
    {
       
        return view('lightApp.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function add_data(Request $request)
    {

     
         $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:1|max:100',
            'website_link' => 'required|string|min:1|max:100',
            'app_group' => 'nullable|string',
            'app_description' => 'nullable|string|max:200',
            'picture_icon' => 'nullable|image|mimes:jpeg,png',
            'dialog_width' => $request->open_type == 'dialog' ? 'required' : 'nullable'.'|integer|max:100',
            'dialog_height' => $request->open_type == 'dialog' ? 'required' : 'nullable'.'|integer|max:100',
        ]);
        
        $validator->after(function ($validator) use ($request) {
            
        });

        if ($validator->fails()) {
            return response()->json([
                'success' => false, 
                'message' => $validator->errors()->first()
            ], 
            500);
        }

        
        $image = $request->file('picture_icon');
        $path = $image->store('images', 'public');

        $url = Storage::url($path);

        $data['name'] = $request->name;
        $data['website_link']= $request->website_link;
        $data['app_group']= $request->app_group;
        $data['app_description']= $request->app_description;
        $data['picture_icon'] = $url;
        $data['dialog_width']= $request->dialog_width;
        $data['dialog_height']= $request->dialog_height;
        $data['open_type']= $request->open_type;
        


        $appData = LiteAppModel::create($data);

       return redirect('list')->with('success', 'Data successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function apps(Request $request, string $id)
    {
        

        // Access and prepare data from the request
       $data['is_added'] = $request->is_added;

        // Optional: Perform additional data manipulation if needed

       

        $updated = LiteAppModel::where('id', $id)->update($data);

        if ($updated) {
             return view('lightApp.list');
        } else {
            // Handle update failure (e.g., log the error or return a specific error message)
             return view('lightApp.list');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {


        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:1|max:100',
            'website_link' => 'required|string|min:1|max:100',
            'app_group' => 'nullable|string',
            'app_description' => 'nullable|string|max:200',
            'picture_icon' => 'nullable|image|mimes:jpeg,png',
            'dialog_width' => 'nullable|integer|max:100',
            'dialog_height' => 'nullable|integer|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 500);
        }

        // Access and prepare data from the request
        $data = $request->all();

        // Optional: Perform additional data manipulation if needed

        $image = $request->file('picture_icon');
        $path = $image->store('images', 'public');

        $url = Storage::url($path);

        $data['picture_icon'] = $url;

        $updated = LiteAppModel::where('id', $id)->update($data);

        if ($updated) {
             return view('lightApp.list');
        } else {
            // Handle update failure (e.g., log the error or return a specific error message)
            return view('lightApp.list');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete_data(string $id)
    {
        
        LiteAppModel::where('id', $id)->delete();

       return redirect('list')->with('success', 'Data Deleted successfully.');
    
    }

}
