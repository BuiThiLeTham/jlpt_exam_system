@extends('layouts.app')

@section('title', 'Quản lý cấp độ JLPT')

@section('content')
    <div class="card">
        <div class="actions">
            <h1 style="flex: 1;">
                Quản lý cấp độ JLPT
            </h1>

            <a
                class="btn btn-success"
                href="{{ route('admin.levels.create') }}"
            >
                + Thêm cấp độ
            </a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Mã</th>
                    <th>Tên</th>
                    <th>Mô tả</th>
                    <th>Số danh mục</th>
                    <th>Số đề thi</th>
                    <th>Thao tác</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($levels as $level)
                    <tr>
                        <td>{{ $level->id }}</td>
                        <td>{{ $level->code }}</td>
                        <td>{{ $level->name }}</td>
                        <td>{{ $level->description }}</td>
                        <td>{{ $level->categories_count }}</td>
                        <td>{{ $level->exams_count }}</td>
                        <td>
                            <div class="actions">
                                <a
                                    class="btn btn-warning"
                                    href="{{ route(
                                        'admin.levels.edit',
                                        $level
                                    ) }}"
                                >
                                    Sửa
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route(
                                        'admin.levels.destroy',
                                        $level
                                    ) }}"
                                    onsubmit="return confirm(
                                        'Bạn chắc chắn muốn xóa cấp độ này?'
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
                        <td colspan="7">
                            Chưa có dữ liệu.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $levels->links() }}
    </div>
@endsection
