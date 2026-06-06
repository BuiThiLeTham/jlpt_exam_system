<?php

namespace App\Services;

use App\Models\QuestionType;
use App\Repositories\QuestionTypeRepository;
use DomainException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class QuestionTypeService
{
    public function __construct(
        private readonly QuestionTypeRepository $repository
    ) {
    }

    /**
     * Lấy danh sách Mondai.
     */
    public function paginate(
        ?int $categoryId = null
    ): LengthAwarePaginator {
        return $this->repository->paginate($categoryId);
    }

    /**
     * Tạo Mondai.
     */
    public function create(array $data): QuestionType
    {
        return $this->repository->create($data);
    }

    /**
     * Cập nhật Mondai.
     */
    public function update(
        QuestionType $questionType,
        array $data
    ): QuestionType {
        return $this->repository->update(
            $questionType,
            $data
        );
    }

    /**
     * Xóa Mondai nếu không có dữ liệu phụ thuộc.
     */
    public function delete(QuestionType $questionType): void
    {
        if ($questionType->questions()->exists()) {
            throw new DomainException(
                'Không thể xóa Mondai vì vẫn còn câu hỏi liên quan.'
            );
        }

        if ($questionType->examSectionTypes()->exists()) {
            throw new DomainException(
                'Không thể xóa Mondai vì đang được sử dụng trong đề thi.'
            );
        }

        $this->repository->delete($questionType);
    }
}
