<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::where('user_id', Auth::id())->orderBy('date', 'desc')->get();

        return view('activities.index', compact('activities'));
    }
}
