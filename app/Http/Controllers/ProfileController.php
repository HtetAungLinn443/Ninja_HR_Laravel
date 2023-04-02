<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Profile
    public function profilePage()
    {
        $employee = Auth::user();
        return view('profile.profile', compact('employee'));
    }
}
