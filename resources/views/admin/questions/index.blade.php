@extends('layouts.app')

@section('title', 'Ngân hàng câu hỏi')

@section('content')
    <div class="card">
        <div class="actions">
            <h1 style="flex: 1;">
                Ngân hàng câu hỏi
            </h1>

            <a
                class="btn btn-success"
                href="{{ route('admin.questions.create') }}"
            >
                + Thêm câu hỏi
            </a>
        </div>

        <form
            class="filter-form"
            method="GET"
            action="{{ route('admin.questions.index') }}"
        >
            <div class="form-group">
                <label for="keyword">
                    Từ khóa
                </label>

                <input
                    id="keyword"
                    type="text"
                    name="keyword"
                    value="{{ $filters['keyword'] ?? '' }}"
                    placeholder="Tìm trong nội dung câu hỏi"
                >
            </div>

            <div class="form-group">
                <label for="category_id">
                    Danh mục
                </label>

                <select id="category_id" name="category_id">
                    <option value="">
                        Tất cả danh mục
                    </option>

                    @foreach ($categories as $category)
                        <option
                            value="{{ $category->id }}"
                            @selected(
                                ($filters['category_id'] ?? '')
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

            <div class="form-group">
                <label for="question_type_id">
                    Mondai
                </label>

                <select
                    id="question_type_id"
                    name="question_type_id"
                >
                    <option value="">
                        Tất cả Mondai
                    </option>

                    @foreach ($questionTypes as $questionType)
                        <option
                            value="{{ $questionType->id }}"
                            @selected(
                                ($filters['question_type_id'] ?? '')
                                == $questionType->id
                            )
                        >
                            {{ $questionType->category->level->code }}
                            -
                            {{ $questionType->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="difficulty">
                    Độ khó
                </label>

                <select id="difficulty" name="difficulty">
                    <option value="">
                        Tất cả độ khó
                    </option>

                    <option
                        value="easy"
                        @selected(
                            ($filters['difficulty'] ?? '')
                            === 'easy'
                        )
                    >
                        Dễ
                    </option>

                    <option
                        value="medium"
                        @selected(
                            ($filters['difficulty'] ?? '')
                            === 'medium'
                        )
                    >
                        Trung bình
                    </option>

                    <option
                        value="hard"
                        @selected(
                            ($filters['difficulty'] ?? '')
                            === 'hard'
                        )
                    >
                        Khó
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label for="status">
                    Trạng thái
                </label>

                <select id="status" name="status">
                    <option value="">
                        Tất cả trạng thái
                    </option>

                    <option
                        value="draft"
                        @selected(
                            ($filters['status'] ?? '')
                            === 'draft'
                        )
                    >
                        Bản nháp
                    </option>

                    <option
                        value="published"
                        @selected(
                            ($filters['status'] ?? '')
                            === 'published'
                        )
                    >
                        Phát hành
                    </option>
                </select>
            </div>

            <button class="btn" type="submit">
                Lọc dữ liệu
            </button>

            <a
                class="btn btn-secondary"
                href="{{ route('admin.questions.index') }}"
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
                    <th>Mondai</th>
                    <th>Nội dung</th>
                    <th>Độ khó</th>
                    <th>Trạng thái</th>
                    <th>Media</th>
                    <th>Thao tác</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($questions as $question)
                    <tr>
                        <td>{{ $question->id }}</td>

                        <td>
                            {{ $question->category->level->code }}
                        </td>

                        <td>
                            {{ $question->category->name }}
                        </td>

                        <td>
                            {{ $question->questionType->name }}
                        </td>

                        <td>
                            {{ \Illuminate\Support\Str::limit(
                                $question->content,
                                80
                            ) }}
                        </td>

                        <td>
                            @switch($question->difficulty)
                                @case('easy')
                                    Dễ
                                    @break

                                @case('hard')
                                    Khó
                                    @break

                                @default
                                    Trung bình
                            @endswitch
                        </td>

                        <td>
                            {{ $question->status === 'published'
                                ? 'Phát hành'
                                : 'Bản nháp' }}
                        </td>

                        <td>
                            @if ($question->image_path)
                                Ảnh
                            @endif

                            @if (
                                $question->image_path
                                && $question->audio_path
                            )
                                <br>
                            @endif

                            @if ($question->audio_path)
                                Audio
                            @endif

                            @if (
                                ! $question->image_path
                                && ! $question->audio_path
                            )
                                Không có
                            @endif
                        </td>

                        <td>
                            <div class="actions">
                                <a
                                    class="btn"
                                    href="{{ route(
                                        'admin.questions.show',
                                        $question
                                    ) }}"
                                >
                                    Xem
                                </a>

                                <a
                                    class="btn btn-warning"
                                    href="{{ route(
                                        'admin.questions.edit',
                                        $question
                                    ) }}"
                                >
                                    Sửa
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route(
                                        'admin.questions.destroy',
                                        $question
                                    ) }}"
                                    onsubmit="return confirm(
                                        'Bạn chắc chắn muốn xóa câu hỏi?'
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
                        <td colspan="9">
                            Chưa có câu hỏi.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $questions->links() }}
    </div>
@endsection
