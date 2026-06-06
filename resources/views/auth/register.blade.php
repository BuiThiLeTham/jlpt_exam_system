@extends('layouts.app')

@section('title', 'Đăng ký học viên')

@section('content')
    <div
        class="card"
        style="max-width: 520px; margin: 0 auto;"
    >
        <h1>Đăng ký học viên</h1>

        <form
            method="POST"
            action="{{ route('register.submit') }}"
        >
            @csrf

            <div class="form-group">
                <label for="name">
                    Họ và tên
                </label>

                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                >
            </div>

            <div class="form-group">
                <label for="email">
                    Email
                </label>

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                >
            </div>

            <div class="form-group">
                <label for="phone">
                    Số điện thoại
                </label>

                <input
                    id="phone"
                    type="text"
                    name="phone"
                    value="{{ old('phone') }}"
                >
            </div>

            <div class="form-group">
                <label for="password">
                    Mật khẩu
                </label>

                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password_confirmation">
                    Nhập lại mật khẩu
                </label>

                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                >
            </div>

            <button
                class="btn"
                type="submit"
            >
                Đăng ký
            </button>
        </form>

        <p>
            Đã có tài khoản?

            <a href="{{ route('login') }}">
                Đăng nhập
            </a>
        </p>
    </div>
@endsection
