@extends('layouts.app')

@section('title', 'Thêm câu hỏi')

@section('content')
    <div class="card">
        <h1>Thêm câu hỏi</h1>

        <form
            method="POST"
            action="{{ route('admin.questions.store') }}"
            enctype="multipart/form-data"
        >
            @csrf

            @include('admin.questions._form')

            <div class="actions">
                <button class="btn" type="submit">
                    Lưu câu hỏi
                </button>

                <a
                    class="btn btn-secondary"
                    href="{{ route('admin.questions.index') }}"
                >
                    Quay lại
                </a>
            </div>
        </form>
    </div>
@endsection
