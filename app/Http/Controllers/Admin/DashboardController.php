<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Level;
use App\Models\Question;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Hiển thị trang tổng quan Admin.
     */
    public function index(): View
    {
        return view('admin.dashboard', [
            'userCount' => User::count(),
            'levelCount' => Level::count(),
            'questionCount' => Question::count(),
            'examCount' => Exam::count(),
        ]);
    }
}
