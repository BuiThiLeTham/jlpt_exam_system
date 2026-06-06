@extends('layouts.app')

@section('title', 'Cập nhật danh mục')

@section('content')
    <div class="card">
        <h1>Cập nhật danh mục</h1>

        <form
            method="POST"
            action="{{ route(
                'admin.categories.update',
                $category
            ) }}"
        >
            @csrf
            @method('PUT')

            @include('admin.categories._form')

            <div class="actions">
                <button class="btn" type="submit">
                    Cập nhật
                </button>

                <a
                    class="btn btn-secondary"
                    href="{{ route('admin.categories.index') }}"
                >
                    Quay lại
                </a>
            </div>
        </form>
    </div>
@endsection
