<div class="form-group">
    <label for="level_id">
        Cấp độ JLPT
    </label>

    <select
        id="level_id"
        name="level_id"
        required
    >
        <option value="">
            -- Chọn cấp độ --
        </option>

        @foreach ($levels as $level)
            <option
                value="{{ $level->id }}"
                @selected(
                    old(
                        'level_id',
                        $category->level_id ?? ''
                    ) == $level->id
                )
            >
                {{ $level->code }} - {{ $level->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="name">
        Tên danh mục
    </label>

    <input
        id="name"
        type="text"
        name="name"
        value="{{ old('name', $category->name ?? '') }}"
        placeholder="Ví dụ: Ngữ pháp"
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
        placeholder="Nhập mô tả danh mục"
    >{{ old('description', $category->description ?? '') }}</textarea>
</div>
