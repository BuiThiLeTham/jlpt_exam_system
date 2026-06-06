<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Hiển thị trang chủ học viên.
     */
    public function index(): View
    {
        return view('user.home');
    }
}
