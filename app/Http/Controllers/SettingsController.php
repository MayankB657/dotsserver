<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use App\Models\UserWallpaper;
use App\Models\Wallpaper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Notifications\GeneralNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;

class SettingsController extends Controller
{
    public function index()
    {
        if (request()->is('theme')) {
            $type = 'theme';
        } elseif (request()->is('wallpaper/desktop')) {
            $type = 'desktop';
        } else {
            $type = 'login';
        }
        $title = ($type == 'desktop' || $type == 'login') ? 'wallpaper' : '';
        return view('display.main', compact('type', 'title'));
    }
    public function themes()
    {
        return view('display.theme');
    }

    public function WallpaperList(Request $request)
    {
        $userWallpaper = UserWallpaper::where('user_id', Auth::id())->first();
        $type = $request->type;
        if ($type == 'theme') {
            $view = 'theme';
            $wallpaperlist = Theme::where('status', 1)->get();
        } else {
            $view = 'wallpaper';
            $wallpaperlist = Wallpaper::where(function ($query) use ($type) {
                $query->where('type', $type)
                    ->where('status', 1);
            })
                ->where(function ($query) {
                    $query->where('created_by', Auth::id())
                        ->orWhere('default', 1);
                })
                ->get();
        }
        $html = view('display.' . $view)
            ->with('wallpaperlist', $wallpaperlist)
            ->with('type', $type)
            ->with('userWallpaper', $userWallpaper)
            ->render();
        return response()->json(['html' => $html]);
    }

    public function storeWallpaper(Request $request)
    {
        $type = $request->type;
        $request->validate([
            'image' => 'required|image|max:1024',
        ], [
            'image.max' => 'The image may not be greater than 1 MB.',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/wallpapers/' . $type);


            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
            }

            $image->move($destinationPath, $imageName);

            $wallpaper = Wallpaper::create([
                'image' => $imageName,
                'type' => $type,
                'status' => 1,
                'created_by' => Auth::id(),
                'default' => 0
            ]);
            $user = Auth::user();
            Notification::send($user, new GeneralNotification("Wallpaper Upload", "A new wallpaper has been uploaded."));

            return response()->json([
                'success' => true,
                'message' => 'Wallpaper uploaded successfully!',
                'wallpaper_id' => $wallpaper->id,
                'type' => $request->type
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload wallpaper.'
            ]);
        }
    }

    public function updateUserWallpaperData(Request $request)
    {
        $userId = Auth::id();
        $wallpaperId = $request->input('wallpaper_id');
        $type = $request->input('type');
        $isChecked = $request->boolean('is_checked');

        if (!$userId || !$type) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid user or request type.',
            ]);
        }
        
        $sequence = array('theme'=>1,'login'=>0,'desktop'=>0);
        $userWallpaper = UserWallpaper::firstOrNew(['user_id' => $userId]);
        $oldsequence = !empty($userWallpaper->sequence) ? json_decode($userWallpaper->sequence,true) : $sequence;
        if ($type === 'desktop') {
            $userWallpaper->dashboard_display = $isChecked ? $wallpaperId : 0;
            $sequence = array('theme'=>0,'login'=>$oldsequence['login'],'desktop'=>1);
        } elseif ($type === 'login') {
            $userWallpaper->login_display = $isChecked ? $wallpaperId : 0;
            $sequence = array('theme'=>0,'login'=>1,'desktop'=>$oldsequence['desktop']);

        } elseif ($type === 'theme') {
            $userWallpaper->theme_id = $isChecked ? $wallpaperId : 0;
            $sequence = array('theme'=>1,'login'=>0,'desktop'=>0);

        }
        $userWallpaper->sequence = json_encode($sequence);
        $userWallpaper->save();

        $message = $isChecked
            ? ucfirst($type) . ' updated successfully.'
            : 'Removed ' . $type . ' successfully.';

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }
    
    public function getUserThemeData(Request $request)
    {
        
        $userId = auth()->id();
        
        $userWallpaper = UserWallpaper::where('user_id', $userId)->first();

        if (!$userWallpaper) {
            return response()->json(['status' => 'no_theme', 'message' => 'No theme found for user'], 404);
        }

        $theme = Theme::find($userWallpaper->theme_id);

        // if (!$theme) {
        //     return response()->json(['status' => 'no_theme_found', 'message' => 'Theme not found'], 404);
        // }

        $sequence = json_decode($userWallpaper->sequence, true);

        $wallpaperData = [];
        if (isset($sequence['theme'], $sequence['desktop'], $sequence['login'])) {
            if ($sequence['theme'] == 0 && ($sequence['desktop'] == 1 || $sequence['login'] == 1)) {
                $desktopWallpaper = Wallpaper::find($userWallpaper->dashboard_display);
                $loginWallpaper = Wallpaper::find($userWallpaper->login_display);

                if ($desktopWallpaper && $sequence['desktop']==1) {
                    $wallpaperData['--desktop-wallpaper-1'] = "url('../images/wallpapers/desktop/" . $desktopWallpaper->image . "')";
                }
                if ($loginWallpaper && $sequence['login'] == 1) {
                    $wallpaperData['--login-wallpaper-1'] = "url('../images/wallpapers/login/" . $loginWallpaper->image . "')";
                    $wallpaperData['--curtain-wallpaper'] = "url('../images/wallpapers/login/" . $loginWallpaper->image . "')";
                }
            }
        }

        $themeJson = !empty($theme) ? json_decode($theme->theme, true) : array();
        // Save to session
        session([
            'theme_id' => !empty($theme) ? $theme->id : '',
            'theme_name' => !empty($theme) ? $theme->flag : 'default',
            'theme_json' => $themeJson,
            'additional_wallpapers' => $wallpaperData
        ]);

        return response()->json([
            'theme_id' => !empty($theme) ? $theme->id : '',
            'theme_name' => !empty($theme) ? $theme->flag : 'default',
            'theme_json' => $themeJson,
            'additional_wallpapers' => $wallpaperData,
        ]);
    }
}
