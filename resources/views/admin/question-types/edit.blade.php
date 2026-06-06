@extends('layouts.app')

@section('title', 'Cập nhật Mondai')

@section('content')
    <div class="card">
        <h1>Cập nhật Mondai</h1>

        <form
            method="POST"
            action="{{ route(
                'admin.question-types.update',
                $questionType
            ) }}"
        >
            @csrf
            @method('PUT')

            @include('admin.question-types._form')

            <div class="actions">
                <button class="btn" type="submit">
                    Cập nhật
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
