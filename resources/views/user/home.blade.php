@extends('layouts.app')

@section('title', 'Trang chủ học viên')

@section('content')
    <div class="card">
        <h1>Trang chủ học viên</h1>

        <p>
            Chào mừng
            <strong>{{ auth()->user()->name }}</strong>
            đến với hệ thống luyện thi JLPT.
        </p>

        <p>
            Danh sách đề thi sẽ được bổ sung ở Phần 7.
        </p>
    </div>
@endsection
