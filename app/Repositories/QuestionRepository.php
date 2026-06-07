<?php

namespace App\Repositories;

use App\Models\Question;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class QuestionRepository
{
    /**
     * Lấy danh sách câu hỏi có bộ lọc và phân trang.
     */
    public function paginate(
        array $filters,
        int $perPage = 10
    ): LengthAwarePaginator {
        return Question::query()
            ->with([
                'category.level',
                'questionType',
                'creator',
                'options',
            ])
            ->when(
                $filters['category_id'] ?? null,
                fn ($query, $categoryId) => $query->where(
                    'category_id',
                    $categoryId
                )
            )
            ->when(
                $filters['question_type_id'] ?? null,
                fn ($query, $questionTypeId) => $query->where(
                    'question_type_id',
                    $questionTypeId
                )
            )
            ->when(
                $filters['difficulty'] ?? null,
                fn ($query, $difficulty) => $query->where(
                    'difficulty',
                    $difficulty
                )
            )
            ->when(
                $filters['status'] ?? null,
                fn ($query, $status) => $query->where(
                    'status',
                    $status
                )
            )
            ->when(
                $filters['keyword'] ?? null,
                fn ($query, $keyword) => $query->whereRaw(
                    'content ILIKE ?',
                    ['%' . $keyword . '%']
                )
            )
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    /**
     * Tạo câu hỏi.
     */
    public function create(array $data): Question
    {
        return Question::create($data);
    }

    /**
     * Cập nhật câu hỏi.
     */
    public function update(
        Question $question,
        array $data
    ): Question {
        $question->update($data);

        return $question->refresh();
    }

    /**
     * Xóa câu hỏi.
     */
    public function delete(Question $question): void
    {
        $question->delete();
    }
}
