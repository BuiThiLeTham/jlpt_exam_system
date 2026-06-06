V<div class="form-group">
    <label for="code">
        Mã cấp độ
    </label>

    <input
        id="code"
        type="text"
        name="code"
        value="{{ old('code', $level->code ?? '') }}"
        placeholder="Ví dụ: N5"
        required
    >
</div>

<div class="form-group">
    <label for="name">
        Tên cấp độ
    </label>

    <input
        id="name"
        type="text"
        name="name"
        value="{{ old('name', $level->name ?? '') }}"
        placeholder="Ví dụ: JLPT N5"
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
        placeholder="Nhập mô tả cấp độ"
    >{{ old('description', $level->description ?? '') }}</textarea>
</div>
