<?php

namespace App\Repositories;

use App\Models\Level;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class LevelRepository
{
    /**
     * Lấy danh sách cấp độ có phân trang.
     */
    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return Level::query()
            ->withCount([
                'categories',
                'exams',
            ])
            ->orderByDesc('code')
            ->paginate($perPage);
    }

    /**
     * Tạo cấp độ JLPT mới.
     */
    public function create(array $data): Level
    {
        return Level::create($data);
    }

    /**
     * Cập nhật cấp độ JLPT.
     */
    public function update(Level $level, array $data): Level
    {
        $level->update($data);

        return $level->refresh();
    }

    /**
     * Xóa cấp độ JLPT.
     */
    public function delete(Level $level): void
    {
        $level->delete();
    }
}
