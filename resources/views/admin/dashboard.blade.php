@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="card">
        <h1>Dashboard Admin</h1>

        <p>
            Đây là khu vực quản trị hệ thống thi JLPT.
        </p>
    </div>

    <div class="grid">
        <div class="card">
            <strong>Tài khoản</strong>

            <div class="stat-number">
                {{ $userCount }}
            </div>
        </div>

        <div class="card">
            <strong>Cấp độ JLPT</strong>

            <div class="stat-number">
                {{ $levelCount }}
            </div>
        </div>

        <div class="card">
            <strong>Ngân hàng câu hỏi</strong>

            <div class="stat-number">
                {{ $questionCount }}
            </div>
        </div>

        <div class="card">
            <strong>Đề thi</strong>

            <div class="stat-number">
                {{ $examCount }}
            </div>
        </div>
    </div>
@endsection
