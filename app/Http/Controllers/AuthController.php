<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function signup_view()
    {
        return Inertia::render('Auth/Signup');
    }

    public function signin_view()
    {
        return Inertia::render('Auth/Signin');
    }

    public function forgot_password_view()
    {
        return Inertia::render('Auth/SecurityQuestion');
    }

    public function new_password_view()
    {
        return Inertia::render('Auth/NewPassword');
    }
}
