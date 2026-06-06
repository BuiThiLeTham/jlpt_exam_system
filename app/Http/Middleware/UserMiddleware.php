<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Chỉ cho phép học viên đang hoạt động truy cập.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        if (! $user->isActive()) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Tài khoản của bạn đã bị khóa.',
                ]);
        }

        if ($user->role !== 'user') {
            abort(403, 'Trang này chỉ dành cho học viên.');
        }

        return $next($request);
    }
}
