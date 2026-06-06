<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Level;
use App\Repositories\CategoryRepository;
use DomainException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class CategoryService
{
    public function __construct(
        private readonly CategoryRepository $repository
    ) {
    }

    /**
     * Lấy danh sách danh mục.
     */
    public function paginate(
        ?int $levelId = null
    ): LengthAwarePaginator {
        return $this->repository->paginate($levelId);
    }

    /**
     * Tạo danh mục.
     */
    public function create(array $data): Category
    {
        $data['slug'] = $this->generateSlug(
            (int) $data['level_id'],
            $data['name']
        );

        return $this->repository->create($data);
    }

    /**
     * Cập nhật danh mục.
     */
    public function update(
        Category $category,
        array $data
    ): Category {
        $data['slug'] = $this->generateSlug(
            (int) $data['level_id'],
            $data['name']
        );

        return $this->repository->update($category, $data);
    }

    /**
     * Xóa danh mục nếu không có dữ liệu phụ thuộc.
     */
    public function delete(Category $category): void
    {
        if ($category->questionTypes()->exists()) {
            throw new DomainException(
                'Không thể xóa danh mục vì vẫn còn Mondai liên quan.'
            );
        }

        if ($category->questions()->exists()) {
            throw new DomainException(
                'Không thể xóa danh mục vì vẫn còn câu hỏi liên quan.'
            );
        }

        $this->repository->delete($category);
    }

    /**
     * Tạo slug, ví dụ: n4-ngu-phap.
     */
    private function generateSlug(
        int $levelId,
        string $name
    ): string {
        $level = Level::findOrFail($levelId);

        return Str::slug(
            strtolower($level->code) . '-' . $name
        );
    }
}
