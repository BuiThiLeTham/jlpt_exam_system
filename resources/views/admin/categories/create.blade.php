@extends('layouts.app')

@section('title', 'Thêm danh mục')

@section('content')
    <div class="card">
        <h1>Thêm danh mục</h1>

        <form
            method="POST"
            action="{{ route('admin.categories.store') }}"
        >
            @csrf

            @include('admin.categories._form')

            <div class="actions">
                <button class="btn" type="submit">
                    Lưu danh mục
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
