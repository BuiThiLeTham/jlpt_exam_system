@extends('layouts.app')

@section('title', 'Quản lý Mondai')

@section('content')
    <div class="card">
        <div class="actions">
            <h1 style="flex: 1;">
                Quản lý Mondai
            </h1>

            <a
                class="btn btn-success"
                href="{{ route(
                    'admin.question-types.create'
                ) }}"
            >
                + Thêm Mondai
            </a>
        </div>

        <form
            class="filter-form"
            method="GET"
            action="{{ route(
                'admin.question-types.index'
            ) }}"
        >
            <div class="form-group">
                <label for="category_id">
                    Lọc theo danh mục
                </label>

                <select
                    id="category_id"
                    name="category_id"
                >
                    <option value="">
                        Tất cả danh mục
                    </option>

                    @foreach ($categories as $category)
                        <option
                            value="{{ $category->id }}"
                            @selected(
                                $selectedCategoryId
                                == $category->id
                            )
                        >
                            {{ $category->level->code }}
                            -
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button class="btn" type="submit">
                Lọc dữ liệu
            </button>

            <a
                class="btn btn-secondary"
                href="{{ route(
                    'admin.question-types.index'
                ) }}"
            >
                Xóa bộ lọc
            </a>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cấp độ</th>
                    <th>Danh mục</th>
                    <th>Tên Mondai</th>
                    <th>Mô tả</th>
                    <th>Số câu hỏi</th>
                    <th>Số cấu trúc đề</th>
                    <th>Thao tác</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($questionTypes as $questionType)
                    <tr>
                        <td>{{ $questionType->id }}</td>
                        <td>
                            {{ $questionType->category->level->code }}
                        </td>
                        <td>
                            {{ $questionType->category->name }}
                        </td>
                        <td>{{ $questionType->name }}</td>
                        <td>{{ $questionType->description }}</td>
                        <td>{{ $questionType->questions_count }}</td>
                        <td>
                            {{ $questionType->exam_section_types_count }}
                        </td>
                        <td>
                            <div class="actions">
                                <a
                                    class="btn btn-warning"
                                    href="{{ route(
                                        'admin.question-types.edit',
                                        $questionType
                                    ) }}"
                                >
                                    Sửa
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route(
                                        'admin.question-types.destroy',
                                        $questionType
                                    ) }}"
                                    onsubmit="return confirm(
                                        'Bạn chắc chắn muốn xóa Mondai này?'
                                    );"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="btn btn-danger"
                                        type="submit"
                                    >
                                        Xóa
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">
                            Chưa có dữ liệu.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $questionTypes->links() }}
    </div>
@endsection
