<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Users;
use App\Models\PasswordResetTokens;

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
    /** end of views */

    public function new_password_view($id = null)
    {
        $token = PasswordResetTokens::where('token', $id)->first();

        if (!$token) {
            return redirect('/forgot-password');
        }

        return Inertia::render('Auth/NewPassword', [
            'token_hash' => $id,
            'user_id' => $token->user_id,
        ]);
    }
}
