@php
    $labels = ['A', 'B', 'C', 'D'];

    $optionMap = isset($question)
        ? $question->options->keyBy('label')
        : collect();

    $selectedCorrectOption = old(
        'correct_option',
        isset($question)
            ? optional(
                $question->options->firstWhere(
                    'is_correct',
                    true
                )
            )->label
            : ''
    );
@endphp

<div class="form-group">
    <label for="category_id">
        Danh mục
    </label>

    <select
        id="category_id"
        name="category_id"
        required
    >
        <option value="">
            -- Chọn danh mục --
        </option>

        @foreach ($categories as $category)
            <option
                value="{{ $category->id }}"
                @selected(
                    old(
                        'category_id',
                        $question->category_id ?? ''
                    ) == $category->id
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
        required
    >
        <option value="">
            -- Chọn Mondai --
        </option>

        @foreach ($questionTypes as $questionType)
            <option
                value="{{ $questionType->id }}"
                data-category-id="{{ $questionType->category_id }}"
                @selected(
                    old(
                        'question_type_id',
                        $question->question_type_id ?? ''
                    ) == $questionType->id
                )
            >
                {{ $questionType->category->level->code }}
                -
                {{ $questionType->category->name }}
                -
                {{ $questionType->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="content">
        Nội dung câu hỏi
    </label>

    <textarea
        id="content"
        name="content"
        required
        placeholder="Nhập nội dung câu hỏi"
    >{{ old('content', $question->content ?? '') }}</textarea>
</div>

<div class="form-group">
    <label for="explanation">
        Giải thích đáp án
    </label>

    <textarea
        id="explanation"
        name="explanation"
        placeholder="Nhập lời giải thích sau khi nộp bài"
    >{{ old(
        'explanation',
        $question->explanation ?? ''
    ) }}</textarea>
</div>

<div class="form-group">
    <label for="difficulty">
        Mức độ khó
    </label>

    <select
        id="difficulty"
        name="difficulty"
        required
    >
        <option
            value="easy"
            @selected(
                old(
                    'difficulty',
                    $question->difficulty ?? 'medium'
                ) === 'easy'
            )
        >
            Dễ
        </option>

        <option
            value="medium"
            @selected(
                old(
                    'difficulty',
                    $question->difficulty ?? 'medium'
                ) === 'medium'
            )
        >
            Trung bình
        </option>

        <option
            value="hard"
            @selected(
                old(
                    'difficulty',
                    $question->difficulty ?? 'medium'
                ) === 'hard'
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

    <select
        id="status"
        name="status"
        required
    >
        <option
            value="draft"
            @selected(
                old(
                    'status',
                    $question->status ?? 'published'
                ) === 'draft'
            )
        >
            Bản nháp
        </option>

        <option
            value="published"
            @selected(
                old(
                    'status',
                    $question->status ?? 'published'
                ) === 'published'
            )
        >
            Phát hành
        </option>
    </select>
</div>

<div class="form-group">
    <label for="image">
        Ảnh minh họa
    </label>

    <input
        id="image"
        type="file"
        name="image"
        accept=".jpg,.jpeg,.png,.webp"
    >

    @if (! empty($question?->image_path))
        <p>
            Ảnh hiện tại:
            <a
                href="{{ asset(
                    'storage/' . $question->image_path
                ) }}"
                target="_blank"
            >
                Xem ảnh
            </a>
        </p>
    @endif
</div>

<div class="form-group">
    <label for="audio">
        Audio cho câu nghe hiểu
    </label>

    <input
        id="audio"
        type="file"
        name="audio"
        accept=".mp3,.wav,.ogg,.m4a"
    >

    @if (! empty($question?->audio_path))
        <p>Audio hiện tại:</p>

        <audio controls>
            <source
                src="{{ asset(
                    'storage/' . $question->audio_path
                ) }}"
            >
        </audio>
    @endif
</div>

<hr>

<h2>Đáp án trắc nghiệm</h2>

<p>
    Nhập đủ bốn đáp án và chọn đúng một đáp án chính xác.
</p>

@foreach ($labels as $index => $label)
    <div class="card">
        <input
            type="hidden"
            name="options[{{ $index }}][label]"
            value="{{ $label }}"
        >

        <div class="form-group">
            <label for="option_{{ $label }}">
                Đáp án {{ $label }}
            </label>

            <textarea
                id="option_{{ $label }}"
                name="options[{{ $index }}][content]"
                required
                placeholder="Nhập nội dung đáp án {{ $label }}"
            >{{ old(
                "options.$index.content",
                optional($optionMap->get($label))->content
            ) }}</textarea>
        </div>

        <label>
            <input
                type="radio"
                name="correct_option"
                value="{{ $label }}"
                style="width: auto;"
                required
                @checked(
                    $selectedCorrectOption === $label
                )
            >

            Đây là đáp án đúng
        </label>
    </div>
@endforeach

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const categorySelect = document.getElementById(
            'category_id'
        );

        const questionTypeSelect = document.getElementById(
            'question_type_id'
        );

        const allQuestionTypeOptions = Array.from(
            questionTypeSelect.options
        );

        function filterQuestionTypes() {
            const selectedCategoryId = categorySelect.value;

            allQuestionTypeOptions.forEach(function (option) {
                if (! option.value) {
                    option.hidden = false;
                    return;
                }

                option.hidden =
                    option.dataset.categoryId
                    !== selectedCategoryId;
            });

            const selectedOption =
                questionTypeSelect.options[
                    questionTypeSelect.selectedIndex
                ];

            if (
                selectedOption
                && selectedOption.value
                && selectedOption.hidden
            ) {
                questionTypeSelect.value = '';
            }
        }

        categorySelect.addEventListener(
            'change',
            filterQuestionTypes
        );

        filterQuestionTypes();
    });
</script>
