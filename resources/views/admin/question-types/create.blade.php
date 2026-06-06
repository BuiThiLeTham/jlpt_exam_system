@extends('layouts.app')

@section('title', 'Thêm Mondai')

@section('content')
    <div class="card">
        <h1>Thêm Mondai</h1>

        <form
            method="POST"
            action="{{ route(
                'admin.question-types.store'
            ) }}"
        >
            @csrf

            @include('admin.question-types._form')

            <div class="actions">
                <button class="btn" type="submit">
                    Lưu Mondai
                </button>

                <a
                    class="btn btn-secondary"
                    href="{{ route(
                        'admin.question-types.index'
                    ) }}"
                >
                    Quay lại
                </a>
            </div>
        </form>
    </div>
@endsection
