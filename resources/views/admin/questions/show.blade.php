@extends('layouts.app')

@section('title', 'Chi tiết câu hỏi')

@section('content')
    <div class="card">
        <div class="actions">
            <h1 style="flex: 1;">
                Chi tiết câu hỏi #{{ $question->id }}
            </h1>

            <a
                class="btn btn-warning"
                href="{{ route(
                    'admin.questions.edit',
                    $question
                ) }}"
            >
                Sửa câu hỏi
            </a>

            <a
                class="btn btn-secondary"
                href="{{ route('admin.questions.index') }}"
            >
                Quay lại
            </a>
        </div>

        <p>
            <strong>Cấp độ:</strong>
            {{ $question->category->level->code }}
        </p>

        <p>
            <strong>Danh mục:</strong>
            {{ $question->category->name }}
        </p>

        <p>
            <strong>Mondai:</strong>
            {{ $question->questionType->name }}
        </p>

        <p>
            <strong>Độ khó:</strong>

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
        </p>

        <p>
            <strong>Trạng thái:</strong>
            {{ $question->status === 'published'
                ? 'Phát hành'
                : 'Bản nháp' }}
        </p>

        <p>
            <strong>Người tạo:</strong>
            {{ $question->creator?->name ?? 'Không xác định' }}
        </p>
    </div>

    <div class="card">
        <h2>Nội dung câu hỏi</h2>

        <p>
            {!! nl2br(e($question->content)) !!}
        </p>

        @if ($question->image_path)
            <p>
                <img
                    src="{{ asset(
                        'storage/' . $question->image_path
                    ) }}"
                    alt="Ảnh minh họa câu hỏi"
                    style="max-width: 100%;"
                >
            </p>
        @endif

        @if ($question->audio_path)
            <audio controls>
                <source
                    src="{{ asset(
                        'storage/' . $question->audio_path
                    ) }}"
                >
            </audio>
        @endif
    </div>

    <div class="card">
        <h2>Đáp án</h2>

        <table>
            <thead>
                <tr>
                    <th>Nhãn</th>
                    <th>Nội dung</th>
                    <th>Kết quả</th>
                </tr>
            </thead>

            <tbody>
                @foreach (
                    $question->options->sortBy('label')
                    as $option
                )
                    <tr>
                        <td>
                            <strong>{{ $option->label }}</strong>
                        </td>

                        <td>
                            {!! nl2br(e($option->content)) !!}
                        </td>

                        <td>
                            {{ $option->is_correct
                                ? 'Đáp án đúng'
                                : '' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="card">
        <h2>Giải thích</h2>

        <p>
            {!! nl2br(
                e(
                    $question->explanation
                    ?: 'Chưa có giải thích.'
                )
            ) !!}
        </p>
    </div>
@endsection
