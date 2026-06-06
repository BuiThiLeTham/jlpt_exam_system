@extends('layouts.app')

@section('title', 'Cập nhật cấp độ JLPT')

@section('content')
    <div class="card">
        <h1>Cập nhật cấp độ JLPT</h1>

        <form
            method="POST"
            action="{{ route(
                'admin.levels.update',
                $level
            ) }}"
        >
            @csrf
            @method('PUT')

            @include('admin.levels._form')

            <div class="actions">
                <button class="btn" type="submit">
                    Cập nhật
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
