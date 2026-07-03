<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!Auth::user() || !Auth::user()->isAdmin()) {
            Auth::logout();

            return redirect()
                ->route('login')
                ->withErrors(['email' => 'Chỉ tài khoản admin mới được đăng nhập vào khu vực quản trị.']);
        }

        return $next($request);
    }
}
