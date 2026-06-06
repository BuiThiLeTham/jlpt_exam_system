<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CategoryRepository
{
    /**
     * Lấy danh sách danh mục.
     */
    public function paginate(
        ?int $levelId = null,
        int $perPage = 10
    ): LengthAwarePaginator {
        return Category::query()
            ->with('level')
            ->withCount([
                'questionTypes',
                'questions',
            ])
            ->when(
                $levelId,
                fn ($query) => $query->where('level_id', $levelId)
            )
            ->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();
    }

    /**
     * Tạo danh mục.
     */
    public function create(array $data): Category
    {
        return Category::create($data);
    }

    /**
     * Cập nhật danh mục.
     */
    public function update(
        Category $category,
        array $data
    ): Category {
        $category->update($data);

        return $category->refresh();
    }

    /**
     * Xóa danh mục.
     */
    public function delete(Category $category): void
    {
        $category->delete();
    }
}
