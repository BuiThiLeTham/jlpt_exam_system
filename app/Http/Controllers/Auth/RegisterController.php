<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class RegisterController extends Controller
{
    /**
     * Hiển thị form đăng ký.
     */
    public function showRegistrationForm(): View
    {
        return view('auth.register');
    }

    /**
     * Tạo tài khoản học viên.
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:20',
            ],

            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->numbers(),
            ],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),

            // Không lấy role từ request để tránh người dùng tự đăng ký Admin.
            'role' => 'user',
            'status' => 'active',
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()
            ->route('user.home')
            ->with('success', 'Đăng ký tài khoản thành công.');
    }
}
