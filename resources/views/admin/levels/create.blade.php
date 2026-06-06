@extends('layouts.app')

@section('title', 'Thêm cấp độ JLPT')

@section('content')
    <div class="card">
        <h1>Thêm cấp độ JLPT</h1>

        <form
            method="POST"
            action="{{ route('admin.levels.store') }}"
        >
            @csrf

            @include('admin.levels._form')

            <div class="actions">
                <button class="btn" type="submit">
                    Lưu cấp độ
                </button>

                <a
                    class="btn btn-secondary"
                    href="{{ route('admin.levels.index') }}"
                >
                    Quay lại
                </a>
            </div>
        </form>
    </div>
@endsection
