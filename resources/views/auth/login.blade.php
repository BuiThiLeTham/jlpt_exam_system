@extends('layouts.app')

@section('title', 'Đăng nhập')

@section('content')
    <div
        class="card"
        style="max-width: 520px; margin: 0 auto;"
    >
        <h1>Đăng nhập</h1>

        <form
            method="POST"
            action="{{ route('login.submit') }}"
        >
            @csrf

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
                    autofocus
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
                <label>
                    <input
                        type="checkbox"
                        name="remember"
                        value="1"
                        style="width: auto;"
                    >

                    Ghi nhớ đăng nhập
                </label>
            </div>

            <button
                class="btn"
                type="submit"
            >
                Đăng nhập
            </button>
        </form>

        <p>
            Chưa có tài khoản?

            <a href="{{ route('register') }}">
                Đăng ký học viên
            </a>
        </p>
    </div>
@endsection
