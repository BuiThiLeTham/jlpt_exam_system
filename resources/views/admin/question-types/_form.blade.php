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
                        $questionType->category_id ?? ''
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
    <label for="name">
        Tên Mondai
    </label>

    <input
        id="name"
        type="text"
        name="name"
        value="{{ old(
            'name',
            $questionType->name ?? ''
        ) }}"
        placeholder="Ví dụ: Mondai 1 - Chọn cách đọc Kanji"
        required
    >
</div>

<div class="form-group">
    <label for="description">
        Mô tả
    </label>

    <textarea
        id="description"
        name="description"
        placeholder="Nhập mô tả Mondai"
    >{{ old(
        'description',
        $questionType->description ?? ''
    ) }}</textarea>
</div>
