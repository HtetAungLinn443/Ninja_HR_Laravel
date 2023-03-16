<?php

namespace App\Http\Controllers;

class UserController extends Controller
{
    //login
    public function loginPage()
    {
        return view('login');
    }
}
