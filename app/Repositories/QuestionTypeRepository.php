<?php

namespace App\Repositories;

use App\Models\QuestionType;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class QuestionTypeRepository
{
    /**
     * Lấy danh sách dạng bài Mondai.
     */
    public function paginate(
        ?int $categoryId = null,
        int $perPage = 10
    ): LengthAwarePaginator {
        return QuestionType::query()
            ->with('category.level')
            ->withCount([
                'questions',
                'examSectionTypes',
            ])
            ->when(
                $categoryId,
                fn ($query) => $query->where(
                    'category_id',
                    $categoryId
                )
            )
            ->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();
    }

    /**
     * Tạo Mondai.
     */
    public function create(array $data): QuestionType
    {
        return QuestionType::create($data);
    }

    /**
     * Cập nhật Mondai.
     */
    public function update(
        QuestionType $questionType,
        array $data
    ): QuestionType {
        $questionType->update($data);

        return $questionType->refresh();
    }

    /**
     * Xóa Mondai.
     */
    public function delete(QuestionType $questionType): void
    {
        $questionType->delete();
    }
}
