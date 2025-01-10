<?php

namespace App\Http\Middleware;

use App\Models\FileSharing;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class FileSharingPasswordCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {

        $fileId = $request->route('id');

        $check = FileSharing::where('url', 'LIKE', '%' . $fileId . '%')->first();

        if ($check && $check->password != null) {
            $passwordConfirmed = Session::get("file_password_confirmed_{$fileId}", false);

            if (!$passwordConfirmed) {
                return redirect()->route('showPasswordForm', ['id' => $fileId]);
            }
        }



        return $next($request);
    }
}
