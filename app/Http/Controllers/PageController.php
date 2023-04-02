<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    // Page
    public function dashboard()
    {
        $employee = Auth::user();

        return view('dashboard', compact('employee'));

    }
}
