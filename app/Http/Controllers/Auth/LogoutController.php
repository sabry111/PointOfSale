<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;

class LogoutController extends Controller
{

    public function logout()
    {

        auth()->guard('web')->logout();
        return view('auth.login');
    }

}
