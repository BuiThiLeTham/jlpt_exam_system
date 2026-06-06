<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Hiển thị form đăng nhập.
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * Xử lý đăng nhập.
     */
    public function login(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'remember' => ['nullable', 'boolean'],
        ]);

        $credentials = [
            'email' => $validated['email'],
            'password' => $validated['password'],

            // Tài khoản bị khóa không được phép đăng nhập.
            'status' => 'active',
        ];

        $remember = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            return back()
                ->withErrors([
                    'email' => 'Email, mật khẩu không đúng hoặc tài khoản đã bị khóa.',
                ])
                ->onlyInput('email');
        }

        // Tạo lại session ID để tránh session fixation.
        $request->session()->regenerate();

        return $this->redirectByRole();
    }

    /**
     * Đăng xuất khỏi hệ thống.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'Bạn đã đăng xuất thành công.');
    }

    /**
     * Điều hướng sau khi đăng nhập theo quyền của tài khoản.
     */
    private function redirectByRole(): RedirectResponse
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('user.home');
    }
}
