<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\LoginLog;
use Carbon\Carbon;
use Jenssegers\Agent\Agent;
use Stevebauman\Location\Facades\Location;
use App\Helpers\ActivityHelper;
use App\Models\Quotes;
use App\Notifications\GeneralNotification;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Notification;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class LoginController extends Controller
{
    // use AuthenticatesUsers;

    // protected $redirectTo = '/dashboard';

    // public function name()
    // {
    //     return 'name';
    // }
    // public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    // }

    public function index()
    {
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        if (Auth::user()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $username = $request->email;
        $user = User::where('username', $username)->orWhere('email', $username)->first();
        if ($user) {
            //check user is suspended or not
            if ($user->status == 0) {
                return response()->json(['status' => false, 'msg' => "User is Suspended."]);
            }

            if (Hash::check($request->password, $user->password)) {
                // password correct
                $email = $user->email;
                $password = $request->password;

                $loginRequest = new LoginRequest();
                $loginRequest->merge(['email' => $email, 'password' => $password]);
                $loginRequest->authenticate();
                $request->session()->regenerate();
                $localIP = getHostByName(getHostName());
                $agent = new Agent();
                $system = $agent->platform();
                $browser = $agent->browser();
                $browserVersion = $agent->version($browser);
                $systemVersion = $agent->version($system);


                $user->last_seen = 1;
                $user->save();

                $this->loggedInUser($user);

                //// Logged in Logs
                  LoginLog::create([
                    'user_id' => $user->id,
                    'user_image' => $user->avatar,
                    'login_time' => now(),
                    'system' => $system,
                    'system_version' => $systemVersion,
                    'system_image' => $this->getSystemImage($system),
                    'browser' => "{$browser} {$browserVersion}",
                    'browser_image' => $this->getBrowserImage($browser),
                    'login_address' => $localIP,
                ]);

                ActivityHelper::log('Log In', 'login');


                Notification::send($user, new GeneralNotification("Login", "New login activity from your account."));

                //check face register
                if ($user->is_support_face == 1 && $user->is_facedata == 0) {
                    return response()->json(['status' => true, 'msg' => "Login Successfull.", 'facedata' => 'Facedata not register, Get it.', 'user' => $user]);
                } else {
                    return response()->json(['status' => true, 'msg' => "Login Successfull.", 'user' => $user]);
                }
            } else {
                // password wrong
                return response()->json(['status' => false, 'msg' => "Password not matched."]);
            }
        } else {
            // username not found
            return response()->json(['status' => false, 'msg' => "Username not found."]);
        }
    }

    public function SupportFace(Request $request)
    {
        $user = User::where('username', $request->username)->first();
        if ($user) {
            if ($user->usertype != "client" && $user->usertype != "company" && $user->usertype!="master" ) {
                $user->is_support_face = $request->status;
            } else {
                $user->is_support_face = 0;
            }
            $user->save();
            return json_encode(['status' => true, 'msg' => "Face support."]);
        }
        return json_encode(['status' => false, 'msg' => "Face not support."]);
    }

    public function CheckFaceData(Request $request)
    {
        $check = User::where('username', $request->username)->first();
        if ($check) {
            if ($check->is_facedata == 1) {
                return json_encode(['status' => true, 'msg' => "Facedata avilable."]);
            } else {
                return json_encode(['status' => false, 'msg' => "Facedata not avilable."]);
            }
        } else {
            return json_encode(['status' => false, 'msg' => "Username not found."]);
        }
    }

    public function ImageLogin(Request $request)
    {
        $image = $request->file('photo');
        $imageContents = file_get_contents($image->getPathName());
        $encodedImage = base64_encode($imageContents);
        $payload = [
            'image' => $encodedImage,
        ];
        $username = $request->username;
        $user = User::where('username', $username)->first();
        if (!$user) {
            return response()->json(['status' => false, 'msg' => "Username not found."]);
        }
        if (!$user->is_facedata) {
            return response()->json(['status' => false, 'msg' => "Facedata not register for this user."]);
        }
        if ($user->status == 0) {
            return response()->json(['status' => false, 'msg' => "User is Suspended."]);
        }
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://dev-ubt-app05.dev.orientdots.net/api/authenticate_face?username=' . base64UrlEncode($_SERVER['SERVER_NAME'] . $user->id),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        $res = json_decode($response);
        curl_close($curl);
        if (isset($res->status) && $res->status == true) {
            return response()->json(['status' => true, 'user' => $user, 'flag' => true]);
        } else {
            return response()->json(['status' => false, 'msg' => $res->message ?? "Can't login using face."]);
        }
    }

    public function VoiceLogin(Request $request)
    {
        $audio = $request->file('audio');
        $audioContents = file_get_contents($audio->getPathName());
        $encodedaudio = base64_encode($audioContents);
        $payload = [
            'audio' => $encodedaudio
        ];
        $username = $request->username;
        $user = User::where('username', $username)->first();
        if (!$user) {
            return response()->json(['status' => false, 'msg' => "Username not found."]);
        }
        if (!$user->is_facedata) {
            return response()->json(['status' => false, 'msg' => "Facedata not register for this user."]);
        }
        if ($user->status == 0) {
            return response()->json(['status' => false, 'msg' => "User is Suspended."]);
        }
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://dev-ubt-app05.dev.orientdots.net/api/authenticate_voice?username=' . base64UrlEncode($_SERVER['SERVER_NAME'] . $user->id),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        $res = json_decode($response);
        curl_close($curl);
        if (isset($res->status) && $res->status == true) {
            $this->loggedInUser($user);
            return response()->json(['status' => true, 'user' => $user]);
        } else {
            return response()->json(['status' => false, 'msg' => $res->message ?? "Can't login using voice."]);
        }
    }

    public function destroy(Request $request)
    {
        if (Auth::user()) {
            $user = Auth::user();
            $user->last_seen = 0;
            $user->save();
            ActivityHelper::log('Log Out', 'logout');
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/');
        } else {
            return redirect('/');
        }
    }

    public function RegisterFacedata(Request $request)
    {
        $username = $request->username;
        $user = User::where('username', $username)->first();
        if (Auth::id() != $user->id) {
            return response()->json(['status' => false, 'msg' => "Something went wrong."]);
        }
        if (!$user) {
            return response()->json(['status' => false, 'msg' => "Username not found."]);
        }
        if ($user->is_facedata) {
            return response()->json(['status' => false, 'msg' => "Facedata already register for this user."]);
        }
        $image = $request->file('photo1');
        $imageContents = file_get_contents($image->getPathName());
        $encodedImage = base64_encode($imageContents);
        $audio = $request->file('audio0');
        $audioContents = file_get_contents($audio->getPathName());
        $encodedAudio = base64_encode($audioContents);
        $image2 = $request->file('photo2');
        $imageContents2 = file_get_contents($image2->getPathName());
        $encodedImage2 = base64_encode($imageContents2);
        $image3 = $request->file('photo3');
        $imageContents3 = file_get_contents($image3->getPathName());
        $encodedImage3 = base64_encode($imageContents3);
        // $audio2 = $request->file('audio1');
        // $audioContents2 = file_get_contents($audio2->getPathName());
        // $encodedAudio2 = base64_encode($audioContents2);
        // $audio3 = $request->file('audio2');
        // $audioContents3 = file_get_contents($audio3->getPathName());
        // $encodedAudio3 = base64_encode($audioContents3);
        $payload = [
            "image1" => $encodedImage,
            "audio1" => $encodedAudio,
            "image2" => $encodedImage2,
            // "audio2" => $encodedAudio2,
            "image3" => $encodedImage3,
            // "audio3" => $encodedAudio3,
        ];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://dev-ubt-app05.dev.orientdots.net/api/register?username=' . base64UrlEncode($_SERVER['SERVER_NAME'] . $user->id),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $res = json_decode($response);
        if ($res->status == true) {
            $user->is_facedata = 1;
            if ($user->avatar == null) {
                $FileName = time() . '.' . $image->getClientOriginalExtension();;
                $image->move(public_path('storage/userprofile'), $FileName);
                $user->avatar = 'public/storage/userprofile/' . $FileName;
            }
            $user->save();
            return response()->json(['status' => true, 'msg' => "Facedata and Voicedata register successfully.", 'user' => $user]);
        } else {
            return response()->json(['status' => false, 'msg' => $res->message]);
        }
    }
    private function getSystemImage($system)
    {
        // Return the image URL based on the system
        $systemImages = [
            'Windows' => 'path/to/windows/image.png',
            'Linux' => 'path/to/linux/image.png',
            'Mac' => 'path/to/mac/image.png',
            // Add other systems and their images
        ];

        return $systemImages[$system] ?? 'path/to/default/system/image.png';
    }

    private function getBrowserImage($browser)
    {
        // Return the image URL based on the browser
        $browserImages = [
            'Chrome' => 'path/to/chrome/image.png',
            'Firefox' => 'path/to/firefox/image.png',
            'Safari' => 'path/to/safari/image.png',
            // Add other browsers and their images
        ];

        return $browserImages[$browser] ?? 'path/to/default/browser/image.png';
    }

    public function GoogleLogin()
    {
        return Socialite::driver('google')->redirect();
    }

    public function GoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Google login was canceled or failed. Please try again.');
        }
        $user = User::where('email', $googleUser->email)->first();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Email not found in system.');
        } else {
            $this->loggedInUser($user);
            setcookie('dotsusername', $user->username, time() + (86400 * 30), '/dots');
            return redirect()->route('dashboard');
        }
    }

    public function Quote()
    {
        $randomQuote = Quotes::inRandomOrder()->first();
        return response()->json($randomQuote);
    }


    public function loggedInUser($user)
    {
        Auth::login($user);

        $basePath = storage_path('app'); // Base folder for storage
        $rootPath = $basePath . '/root'; // Root folder inside 'app'
        $basicFolders = ['Desktop', 'Document', 'Download', 'Gallery', 'Recycle Bin'];
        $relativeUserStoragePath = ''; // To store the relative path without base path

        // Ensure 'app' and 'root' directories exist
        if (!File::exists($rootPath)) {
            File::makeDirectory($rootPath, 0755, true);
        }

        switch ($user->usertype) {
            case 'master':
            case 'client':
                // Master or Client: Folder is named as user ID
                $userPath = base64UrlEncode($user->id);
                $this->createFolderStructure($rootPath . '/' . $userPath, $basicFolders);
                $relativeUserStoragePath = $userPath;
                break;

            case 'company':
                // Company: Folder named as client_id and user ID inside it
                $clientPath = base64UrlEncode($user->client_id);
                $userPath = $clientPath . '/' . base64UrlEncode($user->id);
                $this->createFolderStructure($rootPath . '/' . $clientPath, $basicFolders); // Client-level folders
                $this->createFolderStructure($rootPath . '/' . $userPath, $basicFolders);  // User-level folders
                $relativeUserStoragePath = $userPath;
                break;

            case 'user':
            case 'group':
                if (empty($user->client_id)) {
                    // No client_id: Folder named as user ID
                    $userPath = base64UrlEncode($user->id);
                    $this->createFolderStructure($rootPath . '/' . $userPath, $basicFolders);
                    $relativeUserStoragePath = $userPath;
                } elseif (empty($user->company_id)) {
                    // Has client_id but no company_id: Folder named as client_id and user ID inside
                    $clientPath = base64UrlEncode($user->client_id);
                    $userPath = $clientPath . '/' . base64UrlEncode($user->id);
                    $this->createFolderStructure($rootPath . '/' . $clientPath, $basicFolders); // Client-level folders
                    $this->createFolderStructure($rootPath . '/' . $userPath, $basicFolders);  // User-level folders
                    $relativeUserStoragePath = $userPath;
                } else {
                    // Has both client_id and company_id: Client -> Company -> User structure
                    $clientPath = base64UrlEncode($user->client_id);
                    $companyPath = $clientPath . '/' . base64UrlEncode($user->company_id);
                    $userPath = $companyPath . '/' . base64UrlEncode($user->id);

                    $this->createFolderStructure($rootPath . '/' . $clientPath, $basicFolders);  // Client-level folders
                    $this->createFolderStructure($rootPath . '/' . $companyPath, $basicFolders); // Company-level folders
                    $this->createFolderStructure($rootPath . '/' . $userPath, $basicFolders);    // User-level folders
                    $relativeUserStoragePath = $userPath;
                }
                break;
        }

        // Store the relative path in the session (without base path)
        session(['userstoragepath' => $relativeUserStoragePath . '/']);
    }



    private function createFolderStructure($path, $folders)
    {
        foreach ($folders as $folder) {
            $folderPath = $path . '/' . $folder;
            if (!File::exists($folderPath)) {
                File::makeDirectory($folderPath, 0755, true);
            }
        }
    }


}
