<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $session = session('user');

        if (!$session) {
            return redirect('/sign-in');
        }

        $account_type = $session['account_type'];

        switch ($account_type) {
            case ACCOUNT_TYPE_USER:
                return $next($request);
            case ACCOUNT_TYPE_ADMIN:
                return redirect('/admin/home');
            case ACCOUNT_TYPE_HEAD_ADMIN:
                return $next($request);

            default:
                return redirect('/sign-in');
        }
    }
}
