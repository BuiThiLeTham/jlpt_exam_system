<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'JLPT Exam System')
    </title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            color: #222;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            padding: 14px 24px;
            background: #1f2937;
            color: #fff;
        }

        .navbar a {
            color: #fff;
            text-decoration: none;
            margin-right: 12px;
        }

        .navbar form {
            display: inline;
        }

        .container {
            width: min(1100px, calc(100% - 32px));
            margin: 28px auto;
        }

        .card {
            padding: 22px;
            margin-bottom: 18px;
            border-radius: 10px;
            background: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .form-group {
            margin-bottom: 16px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 11px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
        }

        select,
        textarea {
            width: 100%;
            padding: 11px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
        }

        textarea {
            min-height: 110px;
            resize: vertical;
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            background: #2563eb;
            color: #fff;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-danger {
            background: #dc2626;
        }

        .btn-secondary {
            background: #6b7280;
        }

        .btn-warning {
            background: #d97706;
        }

        .btn-success {
            background: #16a34a;
        }

        .alert {
            padding: 12px;
            margin-bottom: 16px;
            border-radius: 6px;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(
                auto-fit,
                minmax(180px, 1fr)
            );
            gap: 16px;
        }

        .stat-number {
            margin-top: 8px;
            font-size: 30px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }

        th,
        td {
            padding: 12px;
            border: 1px solid #e5e7eb;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #f3f4f6;
        }

        .actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .filter-form {
            display: flex;
            gap: 12px;
            align-items: end;
            flex-wrap: wrap;
        }

        .filter-form .form-group {
            min-width: 240px;
            margin-bottom: 0;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div>
            <a href="{{ route('home') }}">
                <strong>JLPT Exam System</strong>
            </a>
        </div>

        <div>
            @auth
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}">
                        Dashboard
                    </a>

                    <a href="{{ route('admin.levels.index') }}">
                        Cấp độ
                    </a>

                    <a href="{{ route('admin.categories.index') }}">
                        Danh mục
                    </a>

                    <a href="{{ route('admin.question-types.index') }}">
                        Mondai
                    </a>
                    <a href="{{ route('admin.questions.index') }}">
    Ngân hàng câu hỏi
</a>
                @endif

                <span>
                    Xin chào, {{ auth()->user()->name }}
                </span>

                <form
                    method="POST"
                    action="{{ route('logout') }}"
                >
                    @csrf

                    <button
                        class="btn btn-danger"
                        type="submit"
                    >
                        Đăng xuất
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}">
                    Đăng nhập
                </a>

                <a href="{{ route('register') }}">
                    Đăng ký
                </a>
            @endauth
        </div>
    </nav>

    <main class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
